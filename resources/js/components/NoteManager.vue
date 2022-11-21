<template>
    <div class="lg:col-span-3 py-6 px-2 sm:px-6 lg:py-0 lg:px-0 ipad-1:px-0">

        <button type="button" v-if="!isCollapsed" @click="isCollapsed = true" class="text-gray-600 pl-2 pr-1 ">
            <ChevronDoubleLeftIcon class=" flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                aria-hidden="true" />
        </button>

        <button v-if="isCollapsed" type="button" @click="isCollapsed = false" class="text-gray-600 pl-2 pr-1 ">
            <MenuAlt1Icon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                aria-hidden="true" />
        </button>

        <aside v-if="!isCollapsed">
            <nav class="space-y-1">

                <!-- Add Folder -->
                <Disclosure as="div" class="space-y-1" v-show="!newFolder">
                    <DisclosureButton @click="addNewFolder"
                        class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pl-2 pr-1 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-left">
                        <FolderAddIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                            aria-hidden="true" />
                        <span v-if="admin" class="flex-1">Add Demo Folder</span>
                        <span v-else class="flex-1">Add Folder</span>
                    </DisclosureButton>
                </Disclosure>

                <div v-show="newFolder" class="space-y-1 flex items-center pl-2 pr-1 py-2 text-sm font-medium">
                    <FolderAddIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                        aria-hidden="true" />
                    <div class="mt-1 border-gray-300 focus-within:border-blue-600">
                        <input type="text" id="add-folder" v-model="form.folder"
                            class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 px-4 rounded-full"
                            placeholder="Folder" autocomplete="folder">
                    </div>
                    <button @click="storeFolder" :disabled="!form.folder.length" type="button"
                        class="ml-3 bg-blue-500 rounded-full border-2 border-blue-800 h-9 w-9 flex justify-center items-center">
                        <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    </button>

                    <button @click="newFolder = false" type="button"
                        class="ml-1 bg-gray-500 rounded-full border-2 border-gray-800 h-9 w-9 flex justify-center items-center">
                        <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    </button>
                </div>

                <!-- Default Folder Note -->
                <Disclosure as="div" class="space-y-1" v-show="!newDefaultNote">
                    <DisclosureButton @click="addNewDefaultNote"
                        class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group w-full flex items-center pl-2 pr-1 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-left">
                        <DocumentAddIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                            aria-hidden="true" />
                        <span v-if="admin" class="flex-1">New Demo Note</span>
                        <span v-else class="flex-1">New Note</span>
                    </DisclosureButton>
                </Disclosure>

                <div v-show="newDefaultNote" class="space-y-1 flex items-center pl-2 pr-1 py-2 text-sm font-medium">
                    <DocumentAddIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                        aria-hidden="true" />
                    <div class="mt-1 border-gray-300 focus-within:border-blue-600">
                        <input type="text" v-model="form.note" id="defaultnote"
                            class=" shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 px-4 rounded-full"
                            placeholder="Note" autocomplete="folder">
                    </div>
                    <button @click="storeDefaultNote()" :disabled="!form.note.length" type="button"
                        class="ml-3 bg-blue-500 rounded-full border-2 border-blue-800 h-9 w-9 flex justify-center items-center">
                        <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    </button>

                    <button @click="newDefaultNote = false" type="button"
                        class="ml-1 bg-gray-500 rounded-full border-2 border-gray-800 h-9 w-9 flex justify-center items-center">
                        <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                    </button>
                </div>

                <template v-for="folder in folders" :key="folder.id">
                    <Disclosure as="div" class="space-y-1" :id="`folder-${folder.id}`" v-slot="{ open }"
                        :defaultOpen="true">
                        <!-- Rename Folder -->
                        <div v-if="renameFolder && renameFolder.id === folder.id"
                            class="space-y-1 flex items-center pl-2 pr-1 py-2 text-sm font-medium">
                            <FolderIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true" />
                            <div class="mt-1 border-gray-300 focus-within:border-blue-600">
                                <input type="text" :id="`rename-folder-${folder.id}`" v-model="folder.name"
                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 px-4 rounded-full"
                                    placeholder="Folder" autocomplete="folder">
                            </div>
                            <button @click="updateFolder" :disabled="!folder.name.length" type="button"
                                class="ml-3 bg-blue-500 rounded-full border-2 border-blue-800 h-9 w-9 flex justify-center items-center">
                                <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                            </button>

                            <button @click="resetUpdateFolder" type="button"
                                class="ml-1 bg-gray-500 rounded-full border-2 border-gray-800 h-9 w-9 flex justify-center items-center">
                                <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                            </button>
                        </div>

                        <DisclosureButton v-else v-contextmenu:folderContext @contextmenu="currentFolder = folder;"
                            :class="[isActiveFolder(folder) ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group w-full flex items-center pl-2 pr-1 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-left']"
                            :id="`folders-${folder.id}`">

                            <FolderIcon class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true" />
                            <span class="flex-1">
                                {{ folder.name }}
                            </span>
                            <svg :class="[open ? 'text-gray-400 rotate-90' : 'text-gray-300', 'ml-3 flex-shrink-0 h-5 w-5 transform group-hover:text-gray-400 transition-colors ease-in-out duration-150']"
                                viewBox="0 0 20 20" aria-hidden="true">
                                <path d="M6 6L14 10L6 14V6Z" fill="currentColor" />
                            </svg>
                        </DisclosureButton>

                        <DisclosurePanel class="space-y-1">

                            <draggable :list="folder.notes" item-key="id" group="note" @change="moveNote" :sort="false"
                                :disabled="admin">

                                <template #item="{ element }">
                                    <div :key="element.id">
                                        <!-- Rename Note -->
                                        <div v-if="renameNote && renameNote.id === element.id"
                                            class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                                            <DocumentTextIcon
                                                class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                            <div class="mt-1 border-gray-300 focus-within:border-blue-600">
                                                <input type="text" :id="`rename-note-${element.id}`"
                                                    v-model="element.title"
                                                    class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 px-4 rounded-full"
                                                    placeholder="Note" autocomplete="folder">
                                            </div>
                                            <button @click="updateNote" :disabled="!element.title.length" type="button"
                                                class="ml-3 bg-blue-500 rounded-full border-2 border-blue-800 h-9 w-9 flex justify-center items-center">
                                                <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                            </button>

                                            <button @click="resetUpdateNote" type="button"
                                                class="ml-1 bg-gray-500 rounded-full border-2 border-gray-800 h-9 w-9 flex justify-center items-center">
                                                <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                            </button>
                                        </div>

                                        <a v-else v-contextmenu:noteContext @contextmenu="currentNote = element;"
                                            :href="redirectUrl( element.id)" :id="`note-${element.id}`"
                                            :class="[isActiveNote(element) ? 'text-gray-900 bg-gray-200' : 'text-gray-600 hover:bg-gray-50', 'hover:text-gray-900 group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium rounded-md cursor-pointer']">
                                            <DocumentTextIcon
                                                class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500 "
                                                aria-hidden="true" />
                                            <span class="flex-1">
                                                {{ element.title }}
                                            </span>
                                            <ViewListIcon
                                                class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                                aria-hidden="true" />
                                        </a>
                                    </div>
                                </template>
                            </draggable>

                            <!-- Add Note -->
                            <div v-show="newNote && currentFolder.id === folder.id"
                                class="group w-full flex items-center pl-11 pr-2 py-2 text-sm font-medium text-gray-600 rounded-md hover:text-gray-900 hover:bg-gray-50">
                                <DocumentAddIcon
                                    class="mr-3 flex-shrink-0 h-6 w-6 text-gray-400 group-hover:text-gray-500"
                                    aria-hidden="true" />
                                <div class="mt-1 border-gray-300 focus-within:border-blue-600">
                                    <input type="text" v-model="form.note" :id="`add-new-note-${folder.id}`"
                                        class=" shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 px-4 rounded-full"
                                        placeholder="Note" autocomplete="folder">
                                </div>
                                <button @click="storeNote(folder)" :disabled="!form.note.length" type="button"
                                    class="ml-3 bg-blue-500 rounded-full border-2 border-blue-800 h-9 w-9 flex justify-center items-center">
                                    <CheckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </button>

                                <button @click="newNote = false" type="button"
                                    class="ml-1 bg-gray-500 rounded-full border-2 border-gray-800 h-9 w-9 flex justify-center items-center">
                                    <XIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </button>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                </template>
            </nav>

            <!-- Folder Menu -->
            <v-contextmenu ref="folderContext">
                <v-contextmenu-item>
                    <a @click="addNewNote" href="javascript:void(0);"
                        class="group flex items-center px-1 py-1 text-sm text-gray-600" role="menuitem" tabindex="-1">
                        <DocumentAddIcon class="mr-3 h-5 w-5 text-slate-600" aria-hidden="true" />
                        New note
                    </a>
                </v-contextmenu-item>
                <v-contextmenu-item>
                    <a @click="renamingFolder" href="javascript:void(0);"
                        class="group flex items-center px-1 py-1 text-sm text-gray-600" role="menuitem" tabindex="-1">
                        <PencilIcon class="mr-3 h-5 w-5 text-slate-600" aria-hidden="true" />
                        Rename
                    </a>
                </v-contextmenu-item>
                <v-contextmenu-item>
                    <a @click="confirmDeleteFolder" href="javascript:void(0);"
                        class="group flex items-center px-1 py-1 text-sm text-gray-600" role="menuitem" tabindex="-1">
                        <TrashIcon class="mr-3 h-5 w-5 text-slate-600" aria-hidden="true" />
                        Delete
                    </a>
                </v-contextmenu-item>
            </v-contextmenu>

            <!-- Note Menu -->
            <v-contextmenu ref="noteContext">
                <v-contextmenu-item>
                    <a @click="renamingNote" href="javascript:void(0);"
                        class="group flex items-center px-1 py-1 text-sm text-gray-600" role="menuitem" tabindex="-1">
                        <PencilIcon class="mr-3 h-5 w-5 text-slate-600" aria-hidden="true" />
                        Rename
                    </a>
                </v-contextmenu-item>
                <v-contextmenu-item>
                    <a @click="confirmDeleteNote" href="javascript:void(0);"
                        class="group flex items-center px-1 py-1 text-sm text-gray-600" role="menuitem" tabindex="-1">
                        <TrashIcon class="mr-3 h-5 w-5 text-slate-600" aria-hidden="true" />
                        Delete
                    </a>
                </v-contextmenu-item>
                <v-contextmenu-item v-if="!admin">
                    <a @click="openShareNote" href="javascript:void(0);"
                        class="text-gray-600 group flex items-center px-1 py-1 text-sm" role="menuitem" tabindex="-1">
                        <ShareIcon class="mr-3 h-5 w-5 text-slate-600" aria-hidden="true" />
                        Share
                    </a>
                </v-contextmenu-item>
            </v-contextmenu>

            <!-- Delete Folder -->
            <Confirm ref="confirmFolderRef" color="red" confirm-text="Delete" @confirm="deleteFolder">
                <template #icon>
                    <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </template>

                <template #title>Deleting note</template>

                <template #content>
                    Are you sure you want to delete the folder <span>"{{ currentFolder.name }}"</span>?
                </template>
            </Confirm>

            <!-- Delete Note -->
            <Confirm ref="confirmNoteRef" color="red" confirm-text="Delete" @confirm="deleteNote">
                <template #icon>
                    <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                </template>

                <template #title>
                    Deleting note
                </template>

                <template #content>
                    Are you sure you want to delete the note <span>"{{ currentNote.title }}"</span>?
                </template>
            </Confirm>

            <Share ref="shareNoteRef" />

            <Notification ref="notifyRef" />
        </aside>
    </div>

    <div v-if="!current" class="p-2.5 w-max mt-40 h-80 ml-64 overflow-hidden">
        <h2 class="text-lg font-medium text-gray-900">Notes</h2>
        <p class="mt-1 text-sm text-gray-600">Select or Create a Note from the Left Hand Navigation to get started.</p>
        <ul role="list" class="mt-6 border-t border-gray-200 py-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <li v-for="(item, itemIdx) in items" :key="itemIdx" class="flow-root">
                <div
                    class="relative -m-2 p-2 flex items-center space-x-4 rounded-xl hover:bg-gray-50 focus-within:ring-2 focus-within:ring-indigo-500">
                    <div
                        :class="[item.background, 'flex-shrink-0 flex items-center justify-center h-16 w-16 rounded-lg']">
                        <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">
                            <a href="javascript:;" @click="item.click" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true" />
                                {{ item.title }}
                                <span aria-hidden="true"> &rarr;</span>
                            </a>
                        </h3>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
import "v-contextmenu/dist/themes/default.css";

import draggable from 'vuedraggable'

import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import {
    DocumentAddIcon,
    DocumentTextIcon,
    DownloadIcon,
    ExclamationIcon,
    FolderIcon,
    FolderAddIcon,
    PencilIcon,
    TrashIcon,
    CheckIcon,
    ChevronDoubleLeftIcon,
    XIcon,
    MenuAlt1Icon,
    ViewListIcon,
    ShareIcon
} from '@heroicons/vue/outline'

import Confirm from "./modals/Confirm";
import Share from "./modals/Share";
import Notification from "./mix/Notification";

export default {
    directives: {
        contextmenu: directive,
    },

    components: {
        Confirm,
        Notification,
        Disclosure,
        DisclosureButton,
        DisclosurePanel,
        DocumentAddIcon,
        DocumentTextIcon,
        DownloadIcon,
        ExclamationIcon,
        FolderIcon,
        FolderAddIcon,
        PencilIcon,
        TrashIcon,
        CheckIcon,
        XIcon,
        MenuAlt1Icon,
        ViewListIcon,
        ChevronDoubleLeftIcon,
        [Contextmenu.name]: Contextmenu,
        [ContextmenuItem.name]: ContextmenuItem,
        draggable,
        ShareIcon,
        Share
    },

    props: [
        'current',
        'demo',
        'admin',
        'addFolder',
        'addNote'
    ],

    data() {
        return {
            currentFolder: null,
            newFolder: false,
            renameFolder: null,

            currentNote: null,
            newNote: false,
            renameNote: null,

            form: {
                folder: '',
                note: ''
            },

            folders: [],

            notify: {
                message: '',
                title: ''
            },

            isCollapsed: false,

            newDefaultNote: false,

            noteUrl: 'cornell-notes',

            folderId: '',

            items: [
                {
                    title: 'Create a Note',
                    click: this.addNewDefaultNote,
                    icon: DocumentTextIcon,
                    background: 'bg-blue-500',
                },
                {
                    title: 'Create a Folder',
                    click: this.addNewFolder,
                    icon: FolderIcon,
                    background: 'bg-green-500',
                },
            ],
        }
    },

    mounted() {
        this.getFolders();

        if (this.demo) {
            this.noteUrl = 'demo';
            this.folderId = '491297514'
            let self = this;
            setInterval(function () { self.$note.removeFolder(); }, 2000);
        }
    },

    methods: {

        redirectUrl(id = '') {
            let url = '';

            if (this.demo) {
                url = this.$dn.url('demo/' + id)
            } else if (this.admin) {
                url = this.$dn.url('cp/cornell-notes/' + id)
            } else {
                url = this.$dn.url('cornell-notes/' + id)
            }

            return url;
        },

        storeDefaultNote() {
            const payload = {
                title: this.form.note,
                folder_id: this.folderId
            };

            this.$note.storeNote(payload, this.demo, true, this.admin).then(data => {
                this.resetAddNote();

                window.location.href = this.redirectUrl(data.id);
            })
        },

        addNewDefaultNote() {
            this.focus(`defaultnote`);
            this.newDefaultNote = true;
        },

        focus(id) {
            setTimeout(() => {
                $(`#${id}`).focus();
            }, 100);
        },

        addNewNote() {
            this.focus(`add-new-note-${this.currentFolder.id}`);
            this.newNote = true;
        },

        addNewFolder() {
            this.focus(`add-folder`);
            this.newFolder = true;
        },

        getFolders() {
            this.$note.getFolders(this.demo, this.admin).then(data => {
                this.folders = data;
            })
        },

        storeFolder() {
            let payload = { name: this.form.folder };

            this.$note.storeFolder(payload, this.demo, this.admin).then(data => {
                this.folders.push(data);
            })

            this.resetAddFolder();
        },

        updateFolder() {
            let payload = { name: this.currentFolder.name, note_id: (this.current) ? this.current.id : '' };

            this.$note.updateFolder(payload, this.currentFolder.id, this.demo, this.current, this.admin).then(data => {
                this.noteMount(data.note);
            });

            this.resetUpdateFolder();
        },

        renamingFolder() {
            this.focus(`rename-folder-${this.currentFolder.id}`);
            this.renameFolder = this.currentFolder;
        },

        resetAddFolder() {
            this.newFolder = false;
            this.form.folder = '';
        },

        resetUpdateFolder() {
            this.renameFolder = null;
        },

        confirmDeleteFolder() {
            if (this.admin && this.currentFolder.welcome) {
                this.$refs.notifyRef.open("Welcome Folder can't be deleted.", '', true, 'red');
            } else {
                this.$refs.confirmFolderRef.show();
            }
        },

        deleteFolder() {
            this.$refs.confirmFolderRef.hide();

            this.$note.deleteFolder(this.currentFolder.id, this.demo, this.admin).then(data => {
                this.$refs.notifyRef.open(data);
            })

            this.removeFolder(this.currentFolder);

            window.location.href = this.redirectUrl();
        },

        removeFolder(folder) {
            this.folders.splice(this.folders.findIndex(f => f.id === folder.id), 1);
        },

        storeNote(folder) {
            const payload = {
                title: this.form.note,
                folder_id: folder.id
            };

            this.$note.storeNote(payload, this.demo, false, this.admin).then(data => {
                this.resetAddNote();

                if (data) {
                    folder.notes.push(data);
                    window.location.href = this.redirectUrl(data.id);
                } else {
                    this.$refs.notifyRef.open('Your memory limit has exceed.', '', true, 'red');
                }
            })
        },

        updateNote() {
            this.$note.updateNote(this.currentNote, this.demo, this.admin).then(data => {
                this.noteMount(data);
            });

            this.resetUpdateNote();
        },

        renamingNote() {
            this.focus(`rename-note-${this.currentNote.id}`);
            this.renameNote = this.currentNote;
        },

        resetAddNote() {
            this.newNote = false;
            this.newDefaultNote = false;
            this.form.note = '';
        },

        resetUpdateNote() {
            this.renameNote = null;
        },

        confirmDeleteNote() {
            if (this.admin && this.currentNote.welcome) {
                let welcomeFolder = this.folders.find(f => f.id === this.currentNote.folder_id)

                if (welcomeFolder.notes.length > 1) {
                    this.$refs.confirmNoteRef.show();
                } else {
                    this.$refs.notifyRef.open("You can't delete this note. There should at least one Welcome Note.", '', true, 'red');
                }
            } else {
                this.$refs.confirmNoteRef.show();
            }
        },

        deleteNote() {
            this.$note.deleteNote(this.currentNote, this.demo, this.admin).then(data => {
                this.removeNote(this.currentNote);
                this.$refs.notifyRef.open(data);
            });

            this.$refs.confirmNoteRef.hide();

            window.location.href = this.redirectUrl();
        },

        removeNote(note) {
            let folder = this.folders.find(f => f.id === note.folder_id)
            let index = folder.notes.findIndex(n => n.id === note.id);

            folder.notes.splice(index, 1);
        },

        isFirstNoe() {
            let noteCount = 0;

            this.folders.forEach((folder) => {
                noteCount += folder.notes.length;
            });

            return noteCount === 1;
        },

        isActiveNote(note) {
            if (this.current) {
                return this.current.id === note.id;
            }

            return false;
        },

        isActiveFolder(folder) {
            if (this.current) {
                return !!(folder.notes.find(n => n.id === this.current.id));
            }

            return false;
        },

        moveNote(evt) {
            if (evt.added) {
                const note = evt.added.element;
                const noteId = evt.added.element.id;
                const folderEl = $(`#note-${noteId}`).closest("[id^='folder-']");
                const folderId = folderEl.attr('id');

                let id = folderId.split('-');

                this.demo ? note.folder_id = id[1] : '';

                let payload = { folder_id: id[1] }

                this.$note.moveNote(this.folders, payload, noteId, this.demo).then(data => {
                    this.noteMount(data);
                });
            }
        },

        openShareNote() {
            if (!this.demo) {
                this.$refs.shareNoteRef.show(this.currentNote);
            }
        },

        shareNote() {
            this.$refs.notifyRef.open('Link Copied SuccessFully.');
        },

        noteMount(note) {
            if ((this.current) && this.current.id == note.id) {
                this.$mitt.emit('note-mounted', note);
            }
        },
    }
}
</script>

<style>
.v-contextmenu-item--hover {
    background-color: rgb(228 228 231);
}
</style>
