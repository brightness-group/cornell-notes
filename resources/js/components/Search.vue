<template>
    <div class="flex-1 flex items-center justify-center px-2 lg:ml-6 lg:justify-end">
        <div class="max-w-lg w-full lg:max-w-xs">
            <label for="search" class="sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <SearchIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                </div>
                <input @click="open = true" id="search" name="search" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white shadow-sm placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-600 focus:border-blue-600 sm:text-sm" placeholder="Search" type="search" />
            </div>
        </div>

        <TransitionRoot :show="open" as="template" @after-leave="query = ''" appear>
            <Dialog as="div" class="relative z-10" @close="open = false">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" />
                </TransitionChild>

                <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="ease-in duration-200" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                        <DialogPanel class="mx-auto max-w-xl transform divide-y divide-gray-100 overflow-hidden rounded-xl bg-white shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                            <Combobox @update:modelValue="onSelect">
                                <div class="relative">
                                    <SearchIcon class="pointer-events-none absolute top-3.5 left-4 h-5 w-5 text-gray-400" aria-hidden="true" />
                                    <ComboboxInput class="h-12 w-full border-0 bg-transparent pl-11 pr-4 text-gray-800 placeholder-gray-400 focus:ring-0 sm:text-sm" placeholder="Search..." @change="debouncedOnSearch" />
                                </div>

                                <ComboboxOptions v-if="notes.length > 0" static class="max-h-96 scroll-py-3 overflow-y-auto p-3">
                                    <ComboboxOption v-for="item in notes" :key="item.id" :value="item" as="template" v-slot="{ active }">
                                        <li :class="['flex cursor-default select-none rounded-xl p-3', active && 'bg-gray-100']">
                                            <div :class="['flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-blue-500']">
                                                <component :is="item.icon" class="h-6 w-6 text-white" aria-hidden="true" />
                                                <DocumentTextIcon class="h-6 w-6 text-white" aria-hidden="true"/>
                                            </div>
                                            <div class="ml-4 flex-auto">
                                                <p :class="['text-sm font-medium', active ? 'text-gray-900' : 'text-gray-700']">
                                                    {{ item.title }}
                                                </p>
                                                <p :class="['text-sm', active ? 'text-gray-700' : 'text-gray-500']">
                                                    {{ item.folder.name }}
                                                </p>

                                            </div>
                                            <time :datetime="item.updated_at" class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">{{ $dn.timeAgo(item.updated_at) }}</time>
                                        </li>
                                    </ComboboxOption>
                                </ComboboxOptions>

                                <div v-if="query !== '' && notes.length === 0" class="py-14 px-6 text-center text-sm sm:px-14">
                                    <ExclamationCircleIcon type="outline" name="exclamation-circle" class="mx-auto h-6 w-6 text-gray-400" />
                                    <p class="mt-4 font-semibold text-gray-900">No results found</p>
                                    <p class="mt-2 text-gray-500">No notes found for this search term. Please try again.</p>
                                </div>
                            </Combobox>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </Dialog>
        </TransitionRoot>
    </div>
</template>

<script>
import { SearchIcon } from '@heroicons/vue/solid'
import { ExclamationCircleIcon, DocumentTextIcon } from '@heroicons/vue/outline'
import {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'

import _debounce from 'lodash.debounce';

export default {
    components: {
        DocumentTextIcon,
        SearchIcon,
        ExclamationCircleIcon,
        Combobox,
        ComboboxInput,
        ComboboxOptions,
        ComboboxOption,
        Dialog,
        DialogPanel,
        TransitionChild,
        TransitionRoot
    },

    computed: {
        debouncedOnSearch () {
            return _debounce(this.search, 700);
        }
    },

    data() {
        return {
            open: false,
            query: '',
            notes: [],
        }
    },

    methods: {
        search($event) {
            this.query = $event.target.value

            axios.get(`/api/cornell-notes/search?term=${this.query}`).then(response => {
                this.notes = response.data.data;
            });
        },

        onSelect(item) {
            window.location = this.$dn.url(`cornell-notes/${item.id}`);
        }
    }
}
</script>
