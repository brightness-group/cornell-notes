<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                             leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"/>
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300"
                                     enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                     enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                     leave-from="opacity-100 translate-y-0 sm:scale-100"
                                     leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel
                            class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[38%] sm:w-full sm:p-6">
                            <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                                <button type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 "
                                        @click="hide">
                                    <span class="sr-only">Close</span>
                                    <XIcon class="h-6 w-6" aria-hidden="true"/>
                                </button>
                            </div>
                            <div class="h-48">
                                <div
                                    class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                                    <DocumentDuplicateIcon class="h-6 w-6 text-green-600" aria-hidden="true"/>
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Share
                                        {{ title }}
                                    </DialogTitle>
                                </div>

                                <div class="mt-5 flex rounded-md shadow-sm">
                                    <div class="relative flex items-stretch flex-grow ">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <LinkIcon class="h-5 w-5 text-gray-400" aria-hidden="true"/>
                                        </div>
                                        <input type="text" readonly="true" v-model="url"
                                               class="h-12 block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300"/>
                                    </div>

                                    <button v-if="!copy" @click="copyToClipboard" type="button"
                                            class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-white-700 bg-green-500 hover:bg-green-600 f">
                                        <span>Copy</span>
                                    </button>

                                    <button v-if="copy" type="button"
                                            class="-ml-px relative inline-flex items-center space-x-2 px-4 py-2 border border-gray-300 text-sm font-medium rounded-r-md text-white bg-blue-500 hover:bg-blue-600 f">
                                        <span>Copied</span>
                                    </button>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script>

import { ref } from 'vue'

import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot
} from '@headlessui/vue'

import {
    DocumentDuplicateIcon,
    LinkIcon,
    XIcon
} from '@heroicons/vue/outline';

export default {
    setup() {
        const open = ref(false);
        const copy = ref(false);

        return {
            open,
            copy
        }
    },

    data() {
        return {
            title: '',
            link: '',
            time: 3000
        }
    },

    props: ['note'],

    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        DocumentDuplicateIcon,
        LinkIcon,
        XIcon
    },

    methods: {
        show(note) {
            this.title = note.title;
            this.url = note.public_url;
            this.open = true;
        },

        hide() {
            this.open = false;
            this.copy = false;
        },

        async copyToClipboard() {
            let self = this;

            await navigator.clipboard.writeText(this.url);
            this.copy = true;

            setTimeout(function () {
                self.copy = false;
            }, self.time);
        }
    }
}
</script>
