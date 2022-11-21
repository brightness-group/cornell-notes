<template>
    <div>
        <mr-ckeditor ref="mrckRef" :note="note ? note : null" :page-number="totalPages" :root-names="roots" :demo="demo"
            :admin="admin" focused-root="note-1" toolbar-id="mrck-toolbar" @focused-element="handleFocusedElement"
            @data="handlePageContent" @save="saveNotes" @insert-page="addPage('', '')" @keydown="handleKeyDown"
            @is-focused="handleIsFocused">
            <template #toolbar>
                <header class="bg-grey shadow-sm mb-5 mobile:mb-0">
                    <div class="max-w-full mx-auto py-0 pb-1 px-1 sm:px-1 lg:px-1 mobile:pb-5 mobile:px-4">
                        <div id="mrck-toolbar"></div>
                    </div>
                </header>
            </template>

            <template #aside></template>

            <template #page="{ number, roots }">
                <div class="grid grid-cols-3 cue-note-section h-[25cm]" :id="'rcn-' + number">
                    <div :id="'cue-' + number" v-html="roots.cue"
                        class="root cue border-r-dotted ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners">
                    </div>

                    <div :id="'note-' + number" v-html="roots.note"
                        class="col-span-2 root note ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners blurrable">
                    </div>
                </div>

                <div class="grid grid-cols-1 py-3">
                    <div class="summary-section">
                        <div :id="'summary-' + number" v-html="roots.summary"
                            class="root summary h-[5cm] ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners">
                        </div>
                    </div>
                </div>
            </template>
        </mr-ckeditor>
        <Notification ref="notifyRef" />
    </div>
</template>

<script>

import { toRaw } from 'vue';

import MrCkeditor from "./MrCkeditor";
import NoteManager from "./NoteManager";

import isOverflowing from '../utils/overflow';
import Clamp from '../utils/clamp';
import Demo from "../services/Demo";
import Notification from "./mix/Notification";
import { keyCodes } from '@ckeditor/ckeditor5-utils/src/keyboard';

export default {
    components: {
        NoteManager,
        MrCkeditor,
        Notification
    },

    props: [
        'note',
        'demo',
        'admin'
    ],

    data() {
        return {
            totalPages: 1,
            roots: ['cue', 'note', 'summary'],
            defaultRoot: { cue: '', note: '', summary: '' },
            cursorPosition: null,
            removedPages: [],
            mediaTags: ['FIGURE', 'IMG', 'VIDEO', 'OEMBED'],
        }
    },

    mounted() {
        this.scrollToTop();

        if (this.note) {
            this.totalPages = this.note.content.length;

            this.noteMount();
        }
    },

    methods: {
        noteMount() {
            let data = '';

            if (this.demo) {
                let folders = Demo.getFolders();
                if (folders) {
                    folders.forEach(folder => {
                        let note = folder.notes.find(n => n.id === this.note.id);

                        if (note) {
                            data = { ...note, folder: folder };
                        }
                    });
                } else {
                    data = this.note
                }

            } else {
                data = this.note
            }

            this.$mitt.emit('note-mounted', data);
        },

        handleFocusedElement(editor, evt, name, value) {
            this.$nextTick(function () {
                this.handleToolbar(editor, value);
            });
        },

        handleIsFocused(editor, evt, data, isFocused) {
            const self = this;
            const focusedElement = editor.ui.focusTracker.focusedElement

            setTimeout(function () {
                self.handleToolbar(editor, focusedElement)
            });
        },

        handleToolbar(editor, value, timeOut) {
            if (value) {
                if ($(value).hasClass('cue') || $(value).hasClass('summary')) {
                    this.toggleToolbarItems(editor, false, timeOut);
                }
                if ($(value).hasClass('note')) {
                    this.toggleToolbarItems(editor, true, timeOut);
                }
            }
        },

        toggleToolbarItems(editor, type, timeOut = true) {
            const commands = [
                'alignment', 'blockQuote', 'code', 'codeBlock', 'heading', 'horizontalLine', 'indent', 'outdent', 'todoList',
                'imageTextAlternative', 'toggleImageCaption', 'uploadImage', 'imageUpload', 'imageInsert', 'insertImage', 'mediaEmbed'
            ];

            const demoDisabled = ['imageTextAlternative', 'toggleImageCaption', 'uploadImage', 'imageUpload', 'imageInsert'];

            const self = this;
            const demo = this.demo;

            commands.forEach(function (cmd) {
                if (demo && demoDisabled.includes(cmd)) {
                    self.togglePlugin(editor, cmd, false, timeOut);
                } else {
                    self.togglePlugin(editor, cmd, type, timeOut);
                }
            });
        },

        togglePlugin(editor, cmd, type, timeOut) {
            if (timeOut) {
                setTimeout(function () {
                    editor.commands.get(cmd).isEnabled = type;
                });
            }
            else {
                editor.commands.get(cmd).isEnabled = type;
            }
        },

        saveNotes(editor) {
            return new Promise(resolve => {
                if (!this.demo) {
                    const rootNames = editor.model.document.getRootNames();

                    let content = {};

                    for (const rootName of rootNames) {
                        const pageNumber = rootName.split('-');
                        const name = pageNumber[0];
                        const id = pageNumber[1];

                        if (!(id in content)) {
                            content[id] = {};
                        }

                        content[id][name] = editor.getData({ rootName: rootName });
                    }

                    let payload = [];
                    Object.entries(content).forEach(([key, value]) => {
                        if (value.cue || value.note || value.summary) {
                            payload.push(value);
                        }

                        if (!payload.length) {
                            payload = [this.defaultRoot];
                        }
                    });

                    let prefix = this.admin ? 'cp' : 'api';

                    axios.put(`/${prefix}/cornell-notes/${this.note.id}`, { content: payload }).then((res) => {
                        if (res.status == 203) {
                            this.$refs.notifyRef.open(res.data.message, '', true, 'red');
                        } else {
                            this.$mitt.emit('note-mounted', res.data.data);
                        }

                        resolve();
                    });
                } else {
                    resolve();
                }
            });
        },

        handlePageContent(editor) {
            this.$nextTick(function () {
                const focusedElement = editor.ui.focusTracker.focusedElement;

                const cursor = this.$dn.cursor(focusedElement);
                if (focusedElement.id) {
                    this.handleToolbar(editor, focusedElement, false);

                    if (!this.cursorPosition || !cursor.atEnd) {
                        this.cursorPosition = editor.model.document.selection.getFirstPosition();
                    }

                    if (isOverflowing(focusedElement)) {
                        this.docProcessor(editor, focusedElement.id, cursor);
                    }
                }
            });
        },

        focusNextPage(editor, currentRoot, html, cursor) {
            const id = currentRoot.split('-');
            let nextFocus = `${id[0]}-${++id[1]}`;

            if (!document.getElementById(nextFocus)) {
                nextFocus = `${id[0]}-${this.nextFocusId(id[1])}`;
            }

            if (!document.getElementById(nextFocus)) {
                this.addPage(nextFocus, html, cursor);
            } else {
                this.$nextTick(function () {
                    let rootData = editor.getData({ rootName: nextFocus })

                    this.focus(editor, nextFocus, html + rootData, cursor);
                });
            }
        },

        focusPrevPage(editor, isRemovePage = false) {
            const focusedElement = editor.ui.focusTracker.focusedElement

            const id = focusedElement.id.split('-');
            let prevFocus = `${id[0]}-${--id[1]}`;

            if (isRemovePage) {
                prevFocus = `${id[0]}-${this.previousFocusId(id[1])}`;
            }

            if (document.getElementById(prevFocus) && !editor.getData({ rootName: focusedElement.id })) {
                this.focus(editor, prevFocus);
            }
        },

        focusCurrent(editor) {
            let self = this;

            this.$nextTick(function () {
                const position = toRaw(self.cursorPosition);

                if (position) {
                    const root = editor.model.document.getRoot(position.root.rootName)

                    let id = position.root.rootName.split('-');
                    let nextRoot = `${id[0]}-${++id[1]}`;

                    let error = false;

                    try {
                        root.offsetToIndex(position.path[0])
                    } catch (e) {
                        console.log('focusCurrent error', e);
                        error = true;
                    }

                    if (!error) {
                        let hasChild = root.getChild(root.offsetToIndex(position.path[0]));

                        editor.model.change(writer => {
                            if (hasChild) {
                                try {
                                    writer.setSelection(position);
                                } catch (e) {
                                    console.log('focusCurrent setSelection error', e);
                                    this.cursorAtEnd(editor, nextRoot, writer);
                                }
                            } else {
                                this.cursorAtEnd(editor, nextRoot, writer);
                            }

                            self.cursorPosition = null;
                        });
                    } else {
                        this.focusAtEnd(editor, nextRoot);
                        self.cursorPosition = null;
                    }
                }
            });
        },

        focusAtEnd(editor, root) {
            editor.model.change(writer => {
                this.cursorAtEnd(editor, root, writer);
            });
        },

        cursorAtEnd(editor, root, writer) {
            writer.setSelection(writer.createPositionAt(editor.model.document.getRoot(root), 'end'));
        },

        focus(editor, root, html = null, cursor) {
            this.$nextTick(function () {

                if (html) {
                    editor.setData({ [root]: html.replaceAll(':dnsp:', '&nbsp;') });

                    if (cursor.atEnd) {
                        this.focusAtEnd(editor, root);
                    } else {
                        this.focusCurrent(editor);
                    }
                } else {
                    this.focusAtEnd(editor, root);
                }
            });
        },

        docProcessor(editor, id, cursor) {
        },

        truncatedContent(originalHtml, fakeElement) {
        },

        truncateMedia(editorHtml, truncatedHtml) {
        },

        resetFake() {
            this.roots.forEach(function (root) {
                $(`#${root}-fake`).empty();
            });
        },

        scrollToTop() {
            window.scrollTo(0, 0);
        },

        handleKeyDown(editor, evt, data) {
            if (data.keyCode === keyCodes.backspace || data.keyCode === keyCodes.delete) {

                this.$nextTick(function () {
                    const focusedElement = editor.ui.focusTracker.focusedElement;
                    const idSplit = focusedElement.id.split('-');

                    if (idSplit[1] != 1) {
                        if (!this.$dn.editorHasContent(`cue-${idSplit[1]}`) &&
                            !this.$dn.editorHasContent(`note-${idSplit[1]}`) &&
                            !this.$dn.editorHasContent(`summary-${idSplit[1]}`)
                        ) {
                            this.removedPages.push(idSplit[1]);

                            this.focusPrevPage(editor, true);

                            this.$nextTick(function () {
                                $(`#rcn-${idSplit[1]}`).parent().remove('.page');
                            });
                        }
                    }
                });
            }
        },

        previousFocusId(rootId) {
            let prevId = rootId
            let lastElement = this.removedPages[this.removedPages.length - 1];

            for (let i = lastElement; i >= 1; i--) {
                if (!document.getElementById(`note-${prevId}`)) {
                    prevId = prevId - 1;
                }
            }

            return prevId;
        },

        nextFocusId(rootId) {
            let nextId = rootId;
            let length = this.removedPages.length;

            for (var i = 0; i < length; i++) {
                if (!document.getElementById(`note-${nextId}`)) {
                    nextId++;
                } else if (document.getElementById(`note-${nextId}`)) {
                    break;
                }
            }

            if (nextId > this.totalPages) {
                nextId = this.totalPages + 1;
            }

            return nextId;
        }
    }
}
</script>

<style>
.note {
    overflow: hidden !important;
}

.cue {
    border-right: 2px dotted black !important;
    overflow: hidden !important;
}

.summary {
    border-top: 2px dotted black !important;
    overflow: hidden !important;
}
</style>
