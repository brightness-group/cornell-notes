<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
        </TransitionChild>

        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
                <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                    <DialogPanel class="relative bg-white rounded-lg px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full sm:p-6">
                        <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                            <button type="button" class="bg-white rounded-md text-gray-400 hover:text-gray-500 focus:outline-none " @click="open = false">
                                <span class="sr-only">Close</span>
                                <XIcon class="h-6 w-6" aria-hidden="true" />
                            </button>
                        </div>
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <KeyIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900"> Confirm Password </DialogTitle>
                                <div class="mt-5">
                                    <p class="text-sm text-gray-500">For your security, please confirm your password to continue.</p>
                                </div>
                                <div class="mt-5">
                                    <div class="col-span-12 sm:col-span-12">
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input v-model="form.current_password" type="password" id="name" :class="[ hasError('current_password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'block w-full pr-10 focus:outline-none sm:text-sm rounded-md']" placeholder="Password" />

                                            <div v-if="hasError('current_password')" class="absolute inset-y-0 mb-6 right-0 pr-3 flex items-center pointer-events-none">
                                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                            </div>

                                            <p v-if="hasError('current_password')" class="mt-2 text-sm text-red-600">{{ errors.current_password[0] }}</p>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                            <button type="button" :class="[isDisabled ? 'bg-red-200 hover:bg-red-500' : 'bg-red-600 hover:bg-red-700', 'w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2  text-base font-medium text-white    sm:ml-3 sm:w-auto sm:text-sm']" @click="confirm" :disabled="isDisabled">

                                <svg v-show="loader" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>

                                Confirm
                            </button>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </div>
        </Dialog>
    </TransitionRoot>

    <Notification ref="notifyRef" />
</template>

<script>
import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationCircleIcon, XIcon, KeyIcon } from '@heroicons/vue/outline'

import Notification from "../mix/Notification.vue";

export default {

    setup() {
        const open = ref(false);
        const loader = ref(false);

        return {
            open,
            loader
        }
    },

    data() {
        return {
            form: {
                current_password : '',
                type : 'verifyPassword'
            },
            errors : '',
        }
    },

    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationCircleIcon,
        XIcon,
        Notification,
        KeyIcon
    },

    emits: [
        'confirm',
        'dismiss'
    ],

    computed: {
        isDisabled() {
            return (!this.form.current_password.length);
        }
    },

    methods: {
        show() {
            this.open = true;
        },

        hide() {
            this.loader = false;
            this.open = false;
        },

        confirm() {
            this.loader = true;

            axios.post(`/api/verify/password`, this.form).then((res) => {
                if (res.status == 200) {
                    this.$emit('confirm');

                } else {
                    this.loader = false;
                    this.form.password = '';
                }

            }).catch(error => {
                this.loader = false;

                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        dismiss() {
            this.hide();
            this.$emit('dismiss');
        },

        hasError(field) {
            return this.errors && this.errors[field];
        },
    }
}
</script>
