<template>
    <div aria-live="assertive" class="fixed inset-0 flex items-end px-4 py-6 pointer-events-none sm:p-6 sm:items-start z-10">
        <div class="w-full flex flex-col items-center space-y-4 sm:items-end">
            <transition enter-active-class="transform ease-out duration-300 transition" enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2" enter-to-class="translate-y-0 opacity-100 sm:translate-x-0" leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <div v-if="show" class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden">
                    <div class="p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <slot name="icon">
                                    <CheckCircleIcon :class="[ color == 'green' ? 'text-green-400' : 'text-red-400','h-6 w-6' ]" aria-hidden="true" />
                                </slot>
                            </div>
                            <div class="ml-3 w-0 flex-1 pt-0.5">
                                <p class="text-sm font-medium text-gray-900">{{ title }}</p>
                                <p v-show="message" class="mt-1 text-sm text-gray-500">{{ message }}</p>
                            </div>
                            <div class="ml-4 flex-shrink-0 flex">
                                <button type="button" @click="show = false" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <span class="sr-only">Close</span>
                                    <XIcon class="h-5 w-5" aria-hidden="true" />
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { CheckCircleIcon } from '@heroicons/vue/outline'
import { XIcon } from '@heroicons/vue/solid'

export default {
    setup() {
        const show = ref(false)

        return {
            show
        }
    },

    data() {
        return {
            title: '',
            message: '',
            time: 5000,
            color : ''
        }
    },

    components: {
        CheckCircleIcon,
        XIcon
    },

    methods: {
        open(title = '', message = '', autoClose = true, color = 'green') {
            let self = this;
            this.title = title;
            this.message = message;
            this.color = color;
            this.show = true;

            if (autoClose) {
                setTimeout(function () {
                    self.close();
                }, self.time);
            }
        },

        close() {
            this.show = false;
            this.title = '';
            this.message = '';
            this.color = '';
        }
    }
}
</script>
