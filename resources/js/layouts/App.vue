<template>
    <div class="min-h-full">
        <header class="bg-white shadow">
            <div class="max-w-full mx-auto px-2 sm:px-4 lg:px-8 mobile:py-5">
                <Popover class="flex justify-between h-12 mobile:flex-wrap mobile:h-full" v-slot="{ open }">
                    <div class="flex px-2 lg:px-0 mobile:flex-wrap mobile:justify-center">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/">
                                <img class="h-8 w-auto" :src="$dn.url('assets/logo/diligentnotes.png')" alt="Diligent Notes" />
                            </a>
                        </div>

                        <nav v-if="note" class="flex" aria-label="Breadcrumb">
                            <ol role="list" class="pl-4 py-1 flex items-center space-x-4 mobile:pl-0 mobile:py-3">
                                <li>
                                    <div class="flex">
                                        <a href="javascript:void(0);" class="text-md font-medium text-gray-500 hover:text-gray-700">{{ note.folder.name }}</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <ChevronRightIcon class="flex-shrink-0 h-5 w-5 text-gray-400" aria-hidden="true" />
                                        <a :href="$dn.url('cornell-notes/' + note.id)" class="ml-4 text-md font-medium text-gray-500 hover:text-gray-700">{{ note.title }}</a>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                        <div v-if="note && note.updated_at" class="ml-5 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6 mobile:pb-3 ipadx:hidden">
                            <div class="flex items-center text-sm text-gray-500">
                                Last edit was {{ $dn.timeAgo(note.updated_at) }}
                            </div>
                        </div>
                    </div>

                    <Search v-if="user"/>

                    <div v-if="user" class="flex items-center ml-8 mobile:ml-2">
                        <div class="flex-shrink-0">
                            <a :href="$dn.url('cornell-notes')" type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 -ml-1 focus:ring-offset-gray-800 focus:ring-blue-500">
                            <DocumentTextIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            <span>Notes</span>
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center lg:hidden">
                        <!-- Mobile menu button -->
                        <PopoverButton class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                            <span class="sr-only">Open main menu</span>
                            <MenuIcon class="block h-6 w-6" aria-hidden="true" />
                        </PopoverButton>
                    </div>
                    <TransitionRoot  as="template" :show="open">
                        <div class="lg:hidden">
                            <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0" enter-to="opacity-100" leave="duration-150 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                                <PopoverOverlay class="z-20 fixed inset-0 bg-black bg-opacity-25" aria-hidden="true" />
                            </TransitionChild>

                            <TransitionChild as="template" enter="duration-150 ease-out" enter-from="opacity-0 scale-95" enter-to="opacity-100 scale-100" leave="duration-150 ease-in" leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                                <PopoverPanel focus class="z-30 absolute top-0 right-0 max-w-none w-full p-2 transition transform origin-top">
                                    <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 bg-white divide-y divide-gray-200">
                                        <div class="pt-3 pb-2">
                                            <div class="flex items-center justify-between px-4">
                                                <div>
                                                    <img class="h-8 w-auto" :src="$dn.url('assets/logo/diligentnotes.png')" alt="Diligent Notes" />
                                                </div>
                                                <div class="-mr-2">
                                                    <PopoverButton class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                                        <span class="sr-only">Close menu</span>
                                                        <XIcon class="h-6 w-6" aria-hidden="true" />
                                                    </PopoverButton>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-4 pb-2" v-if="user">
                                            <div class="flex items-center px-5">
                                                <div class="flex-shrink-0">
                                                    <img class="h-10 w-10 rounded-full" :src="user.avatar_image" alt="" />
                                                </div>
                                                <div class="ml-3">
                                                    <div class="text-base font-medium text-gray-800">{{ user.name }}</div>
                                                    <div class="text-sm font-medium text-gray-500">{{ user.email }}</div>
                                                </div>
                                            </div>
                                            <div class="mt-3 px-2 space-y-1">
                                                <a v-for="item in userNavigation" :key="item.name" :href="item.href" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">{{ item.name }}</a>
                                                <a @click="$user.logout()" class="cursor-pointer block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Logout</a>
                                            </div>
                                        </div>

                                        <div class="pt-4 pb-2" v-if="!user">
                                            <div class="mt-3 px-2 space-y-1">
                                                <a :href="this.$dn.url('login')" class="block rounded-md px-3 py-2 text-base text-gray-900 font-medium hover:bg-gray-100 hover:text-gray-800">Login</a>
                                            </div>
                                        </div>
                                    </div>
                                </PopoverPanel>
                            </TransitionChild>
                        </div>
                    </TransitionRoot>
                    <div class="hidden lg:ml-4 lg:flex lg:items-center">
                        <!-- Profile dropdown -->
                        <Menu v-if="user" as="div" class="ml-4 relative flex-shrink-0 z-20">
                            <div>
                                <MenuButton class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <span class="sr-only">Open user menu</span>
                                   <img class="h-8 w-8 rounded-full" :src="user.avatar_image" alt="" />
                                </MenuButton>
                            </div>
                            <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                <MenuItems class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                        <a :href="item.href" :class="[active ? 'bg-gray-100' : '', 'block px-4 py-2 text-sm text-gray-700']">{{ item.name }}</a>
                                    </MenuItem>
                                    <MenuItem>
                                        <a @click="$user.logout()" class="cursor-pointer block px-4 py-2 text-sm text-gray-700">Logout</a>
                                    </MenuItem>
                                </MenuItems>
                            </transition>
                        </Menu>
                        <a  v-if="!admin && !user" :href="$dn.url('cornell-notes')" type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500">
                            <DocumentTextIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            <span>Notes</span>
                        </a>
                        <a  v-if="admin" :href="$dn.url('cp')" type="button" class="relative inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-500 hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-blue-500">
                            <HomeIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                            <span>Dashboard</span>
                        </a>
                        <Menu v-if="!admin && !user" as="div" class="ml-4 relative flex-shrink-0 z-20">
                            <div>
                                <MenuButton class="bg-white flex text-sm  ">
                                    <a :href="this.$dn.url('login')" class="text-base font-medium text-gray-500 hover:text-gray-600">Login</a>
                                </MenuButton>
                            </div>
                        </Menu>
                    </div>
                </Popover>
            </div>
        </header>

        <main class="max-w-full mx-auto pb-10">
            <slot name="content"></slot>
        </main>
    </div>
</template>

<script>
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
    Popover,
    PopoverButton,
    PopoverOverlay,
    PopoverPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue'

import {
    ChevronRightIcon,
    HomeIcon,
    SearchIcon
} from '@heroicons/vue/solid'

import { MenuIcon, XIcon, DocumentTextIcon } from '@heroicons/vue/outline'

import Search from "../components/Search";

import { ref } from 'vue'

export default {
    components: {
        ChevronRightIcon,
        Search,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Popover,
        PopoverButton,
        PopoverOverlay,
        PopoverPanel,
        TransitionChild,
        TransitionRoot,
        HomeIcon,
        MenuIcon,
        SearchIcon,
        XIcon,
        DocumentTextIcon
    },

    props: [
        'user',
        'admin'
    ],

    setup() {
        const note = ref(null);

        return {
            note,
        }
    },

    data() {
        return {
            userNavigation : [
                { name: 'Your Profile', href: this.$dn.url('profile') },
                { name: 'Subscription', href: this.$dn.url('subscription') },
            ]
        }
    },

    created () {
        this.$mitt.on('note-mounted', (note) => {
            this.note = note;
        })
    }
}
</script>
