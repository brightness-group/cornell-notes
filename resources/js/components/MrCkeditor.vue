<template>
    <div class="mrck-container">

        <div id="mrck-toolbar-wrapper" class="bg-white sticky top-0 z-10">
            <slot name="toolbar"></slot>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 lg:py-0 lg:px-10 ipad-1:px-5">

            <slot name="aside"></slot>

            <div class="lg:col-span-9 m:px-6 lg:px-0 ipad:overflow-hidden ipad:overflow-x-auto">

                <section v-if="note" id="mrck-roots-wrapper">
                    <div class="page bg-white border-2 border-solid border-grey shadow-md mb-5"
                        v-for="(roots, page) in note.content" :key="`page-${page}`">
                        <slot name="page" :roots="roots" :number="page + 1"></slot>
                    </div>

                    <div class="page bg-white border-2 border-solid border-grey shadow-md mb-5 invisible">
                        <slot name="page" number="fake" :roots="{ cue: 'Cue', note: 'Note', summary: 'Summary' }">
                        </slot>
                    </div>
                </section>

            </div>
        </div>
    </div>
</template>

<script>

import '../../css/ckeditor-tailwind-reset.css';
import EditorWatchdog from '@ckeditor/ckeditor5-watchdog/src/editorwatchdog.js';

const watchdog = new EditorWatchdog();

export default {
    props: [
        'pageNumber',
        'note',
        'rootNames',
        'toolbarId',
        'focusedRoot',
        'demo',
        'admin'
    ],

    data() {
        return {
            editor: null,
        }
    },

    emits: [
        'focused-element',
        'is-focused',
        'data',
        'save',
        'insert-page',
        'keydown',
    ],

    mounted() {
        if (this.note) {
            this.watchDog();
        }
    },

    methods: {
        watchDog() {
            watchdog.setCreator((config) => {
                return this.createWatchDogEditor(config);
            });

            watchdog.setDestructor(editor => {
                document.querySelector(`#${this.toolbarId}`).removeChild(editor.ui.view.toolbar.element);

                return editor.destroy();
            });

            watchdog.on('error', (error) => { console.log('Editor crashed.', error) });

            watchdog.on('restart', () => { console.log('Editor was restarted.') });

            this.createEditor();
        },

        createWatchDogEditor(config) {
            return MultiRootEditor.create(this.rootElements(), config)
                .then(editor => {
                    this.appendToolbar(editor);

                    this.editor = editor;

                    return editor;
                });
        },

        createEditor() {
            const self = this;

            let prefix = this.admin ? 'cp' : 'api';

            return watchdog.create();
        },

        generatePdf(editor) {
            let html = '';

            html += `<div class="mrck-container">
                        <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 lg:py-0 lg:px-10">
                            <div class="lg:col-span-9 m:px-6 lg:px-0">
                                <section  id="mrck-roots-wrapper">`;

            this.note.content.forEach(function (editors, page) {

                let cue = editor.data.get({ rootName: `cue-${page + 1}`, trim: 'none' });
                let note = editor.data.get({ rootName: `note-${page + 1}`, trim: 'none' });
                let summary = editor.data.get({ rootName: `summary-${page + 1}`, trim: 'none' });

                if (cue || note || summary) {
                    html += `<div class="page bg-white border-2 border-solid border-grey shadow-md mb-5">
                                <div class="grid grid-cols-3 cue-note-section h-[25cm]">
                                    <div class="root cue border-r-dotted ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners">
                                    ${cue}
                                    </div>

                                    <div class="col-span-2 root note ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners blurrable">${note}
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 py-3">
                                    <div class="summary-section">
                                        <div class="root summary h-[5cm] ck-content ck-editor__editable_inline ck ck-editor__editable ck-rounded-corners">${summary}
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                }
            });

            html += `</section></div></div></div>`;

            return html;
        },

        rootElements() {
            let self = this;
            let roots = [];

            this.note.content.forEach(function (editors, page) {
                for (let [name] of Object.entries(editors)) {
                    let key = `${name}-${page + 1}`;

                    roots[key] = self.$el.querySelector(`#${key}`);
                }
            });

            return roots;
        },

        appendToolbar(editor) {
            this.$el.querySelector(`#${this.toolbarId}`).appendChild(editor.ui.view.toolbar.element);
        },

        preventTabClose(editor, domEvt) {
            if (editor.plugins.get('PendingActions').hasAny) {
                domEvt.preventDefault();
                domEvt.returnValue = true;
            }
        },

        disableDemoToolbar(editor) {
            const commands = ['imageTextAlternative', 'toggleImageCaption', 'uploadImage', 'imageUpload', 'imageInsert', 'insertImage'];

            commands.forEach(function (cmd) {
                setTimeout(function () {
                    editor.commands.get(cmd).isEnabled = false;
                })
            });
        },
    }
}
</script>

<style>
.ck.ck-editor__editable {
    --ck-focus-ring: transparent;
}

.ck-editor__editable_inline {
    border: var(--ck-focus-ring) !important;
    overflow: auto;
    padding: 0 var(--ck-spacing-standard);
}

.ck.ck-toolbar > .ck-toolbar__items {
    justify-content: center;
}

.ck.ck-toolbar > .ck-toolbar__items > :not(.ck-toolbar__line-break) {
    margin-right: var(--ck-spacing-tiny);
}

#mrck-roots-wrapper {
    width: 21cm !important;
    overflow: hidden;
}
</style>
