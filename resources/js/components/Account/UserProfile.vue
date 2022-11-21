<template>
    <div class="h-full">
        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">

                <Sidebar :page="`profile`" />

                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9 mobile:px-4">
                    <!-- User Profile -->
                    <section aria-labelledby="payment-details-heading">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 sm:p-6">
                                <div>
                                    <h2 id="payment-details-heading" class="text-lg leading-6 font-medium text-gray-900">Profile</h2>
                                </div>
                                <div class="mt-6 grid grid-cols-12 gap-6">

                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="photo" class="block text-sm font-medium text-blue-gray-900"> Photo </label>
                                        <div class="mt-1 flex items-center">
                                            <img class="inline-block h-40 w-40 relative rounded-full" :src="imageUrl" alt="">
                                            <div class="ml-4 flex">
                                                <div class="relative bg-white py-2 px-3 border border-blue-gray-300 rounded-md shadow-sm flex items-center cursor-pointer hover:bg-blue-gray-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-offset-blue-gray-50 focus-within:ring-blue-500">
                                                    <label for="user-photo" class="relative text-sm font-medium text-blue-gray-900 pointer-events-none">
                                                        <span>Change</span>
                                                        <span class="sr-only"> user photo</span>
                                                    </label>
                                                    <input id="user-photo" @change="previewImage" ref="photo" name="user-photo" type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Name -->
                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input v-model="form.name" type="text" id="name"
                                                   :class="[hasError('name') ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'block w-full pr-10 focus:outline-none sm:text-sm rounded-md']"
                                                   placeholder="John Doe" />

                                            <div v-if="hasError('name')" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                            </div>
                                        </div>
                                        <p v-if="hasError('name')" class="mt-2 text-sm text-red-600">{{ errors.name[0] }}</p>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-span-12 sm:col-span-12">
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                        <div class="mt-1 relative rounded-md shadow-sm">
                                            <input v-model="form.email" type="email" id="email"
                                                   :class="[hasError('email') ? 'border-red-300 text-red-900 placeholder-red-300 focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:ring-blue-500 focus:border-blue-500', 'block w-full pr-10 focus:outline-none sm:text-sm rounded-md']"
                                                   placeholder="your@example.com" />

                                            <div v-if="hasError('email')" class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <ExclamationCircleIcon class="h-5 w-5 text-red-500" aria-hidden="true" />
                                            </div>
                                        </div>
                                        <p v-if="hasError('email')" class="mt-2 text-sm text-red-600">{{ errors.email[0] }}</p>
                                    </div>

                                    <div class="col-span-12 sm:col-span-12">
                                        <label class="block text-sm font-medium text-gray-700">Gender</label>
                                        <fieldset class="mt-2">
                                            <div class="space-y-4 sm:flex sm:items-center sm:space-y-0 sm:space-x-10">
                                                <div class="flex items-center">
                                                    <input v-model="form.gender" value="Male" id="male" name="notification-method" type="radio" :checked="form.gender === 'Male'" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" />
                                                    <label for="male" class="ml-3 block text-sm font-medium text-gray-700">Male</label>
                                                </div>

                                                <div class="flex items-center">
                                                    <input v-model="form.gender" value="Female" id="female" name="notification-method" type="radio" :checked="form.gender === 'Female'" class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300" />
                                                    <label for="female" class="ml-3 block text-sm font-medium text-gray-700">Female</label>
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>

                                </div>
                            </div>

                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit"  :class="[isDisabled ? 'bg-stone-400' : 'bg-blue-600' ,'border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900']"
                                        @click="update"
                                        :disabled="isDisabled">

                                    <svg v-show="loader" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>

                                    Save
                                </button>
                            </div>
                        </div>
                    </section>

                    <!-- Delete Account -->
                    <section aria-labelledby="payment-details-heading">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 sm:p-6">
                                <div>
                                    <h2 id="payment-details-heading" class="text-lg leading-6 font-medium text-gray-900">Delete Account</h2>
                                </div>
                                <div class="mt-5">
                                    <p class="text-gray-700">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="button" class="bg-red-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900"
                                        @click="confirmRemoveAccount" >
                                    DELETE ACCOUNT
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <ConfirmPassword ref="confirmPasswordRef" @confirm="removeAccount"> </ConfirmPassword>

    <Notification ref="notifyRef" />

</template>

<script>

import { ExclamationCircleIcon } from '@heroicons/vue/solid'

import Sidebar from './Sidebar.vue';
import Notification from "../mix/Notification";

import ConfirmPassword from "../modals/ConfirmPassword.vue";


export default {

    name: "Profile",

    components: {
        Notification,
        Sidebar,
        ExclamationCircleIcon,
        ConfirmPassword
    },

    props: [
        'user'
    ],

    data() {
        return {
            form : {
                avatar : '',
                email : this.user.email,
                name : this.user.name,
                gender : this.user.gender,
                id : this.user.id,
            },

            imageUrl : this.user.avatar_image,
            loader : false,
            errors : '',
        }
    },

    computed: {
        isDisabled() {
            return (!this.form.name.length || !this.form.email.length);
        }
    },

    methods: {
        update() {
            this.loader = true;

            if (this.$refs.photo) {
                this.form.avatar = this.$refs.photo.files[0];
            }

            let payload = new FormData();
            payload.append('name',this.form.name);
            payload.append('avatar',this.form.avatar);
            payload.append('email',this.form.email);
            payload.append('gender',this.form.gender);
            payload.append('id',this.user.id);
            payload.append('_method', 'PUT');

            axios.post(`/api/profile`, payload,
            { headers: { 'Content-Type':  `multipart/form-data;`}}
            ).then(res => {
                this.loader = false;

                if (res.data.success) {
                    this.$refs.notifyRef.open( res.data.message );

                    if (res.data.email_changed) {
                        window.location.reload();
                    }
                }
            }).catch(error => {
                this.loader = false;

                if (error.response.status === 422) {
                  this.errors = error.response.data.errors;
                }
            });
        },

        previewImage(e) {
            const file = e.target.files[0];
            this.imageUrl = URL.createObjectURL(file);
        },

        hasError(field) {
            return this.errors && this.errors[field];
        },

        confirmRemoveAccount() {
            this.$refs.confirmPasswordRef.show();
        },

        removeAccount() {
            axios.delete('api/me/delete').then(res => {
                this.$refs.notifyRef.open(res.data.message);
                window.location.href =  this.$dn.url('login');
            });
        },
    }
}
</script>
