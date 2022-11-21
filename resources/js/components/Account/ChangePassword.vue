<template>
    <div class="h-full">
        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">

                <Sidebar :page="`password`" />

                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                    <section aria-labelledby="payment-details-heading">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 sm:p-6 mobile:mx-4">
                                <div>
                                    <h2 id="payment-details-heading" class="text-lg leading-6 font-medium text-gray-900">Change Password</h2>
                                </div>

                                <div class="mt-6 grid grid-cols-4 gap-6">

                                    <!-- Current Password -->
                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input v-model="form.current_password" type="password" id="current_password"
                                               :class="[hasError('current_password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'block w-full pr-10 focus:outline-none sm:text-sm rounded-md']"
                                            />

                                            <div v-if="hasError('current_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                            </div>
                                        </div>
                                        <p v-if="hasError('current_password')" class="mt-2 text-sm text-red-600">{{ errors.current_password[0] }}</p>
                                    </div>

                                    <!-- Password -->
                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input v-model="form.password" type="password" id="password"
                                               :class="[hasError('password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'block w-full pr-10 focus:outline-none sm:text-sm rounded-md']"
                                            />

                                            <div v-if="hasError('password')" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                            </div>
                                        </div>
                                        <p v-if="hasError('password')" class="mt-2 text-sm text-red-600">{{ errors.password[0] }}</p>
                                    </div>

                                    <!-- New Password -->
                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="confirm_password" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input v-model="form.confirm_password" type="password" id="confirm_password"
                                                :class="[hasError('confirm_password') ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'block w-full pr-10 focus:outline-none sm:text-sm rounded-md']"
                                            />

                                            <div v-if="hasError('confirm_password')" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                            </div>
                                        </div>
                                        <p v-if="hasError('confirm_password')" class="mt-2 text-sm text-red-600">{{ errors.confirm_password[0] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 mobile:mx-4">
                                <button type="submit" :class="[isDisabled ? 'bg-blue-400':'bg-blue-600' , 'border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900']"
                                        @click="updatePassword()"
                                        :disabled="isDisabled">

                                    <svg v-show="loader" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>

                                    Update Password
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <Notification ref="notifyRef" />

</template>

<script>

import { ExclamationCircleIcon } from '@heroicons/vue/solid'

import Sidebar from "./Sidebar.vue";
import Notification from "../mix/Notification";

export default {
    name: "ChangePassword",

    components: {
        Notification,
        Sidebar,
        ExclamationCircleIcon
    },

    data() {
        return {
            form : {
                current_password : '',
                password : '',
                confirm_password : '',
            },

            loader : false,
            errors : '',
        }
    },

    computed: {
        isDisabled() {
            return (!this.form.current_password.length || !this.form.password.length || !this.form.confirm_password.length);
        }
    },

    methods: {
        updatePassword() {
            this.loader = true;

            axios.put('/api/password', this.form).then(res => {
                if (res.data.status) {
                    this.$refs.notifyRef.open(res.data.message);
                } else {
                    this.loader = false;
                }

            }).catch(error => {
                this.loader = false;

                if (error.response.status === 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        hasError(field) {
            return this.errors && this.errors[field];
        }
    }
}
</script>
