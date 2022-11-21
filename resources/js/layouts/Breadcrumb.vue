<template>
    <div class="max-w-full mx-auto px-4 sm:px-6">
        <div class="border-t border-gray-200 py-3">
            <nav class="flex" aria-label="Breadcrumb">
                <div class="flex sm:hidden">
                    <a href="#" class="group inline-flex space-x-3 text-sm font-medium text-gray-500 hover:text-gray-700">
                        <ArrowNarrowLeftIcon class="flex-shrink-0 h-5 w-5 text-gray-400 group-hover:text-gray-600" aria-hidden="true" />
                        <span>Back to Applicants</span>
                    </a>
                </div>
                <div class="hidden sm:block">
                    <ol role="list" class="flex items-center space-x-4">
                        <li>
                            <div>
                                <a href="#" class="text-gray-400 hover:text-gray-500">
                                    <HomeIcon class="flex-shrink-0 h-5 w-5" aria-hidden="true" />
                                    <span class="sr-only">Home</span>
                                </a>
                            </div>
                        </li>
                        <li v-for="item in breadcrumbs" :key="item.name">
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                                    <path d="M5.555 17.776l8-16 .894.448-8 16-.894-.448z" />
                                </svg>
                                <a :href="item.href" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700" :aria-current="item.current ? 'page' : undefined">{{ item.name }}</a>
                            </div>
                        </li>
                    </ol>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
import {
    ArrowNarrowLeftIcon,
    HomeIcon
} from '@heroicons/vue/solid'

const breadcrumbs = [
    { name: 'Laravel', href: '#', current: false },
    { name: 'Eloquent', href: '#', current: true }
]

export default {
    components: {
        ArrowNarrowLeftIcon,
        HomeIcon
    },

    setup() {
        return {
            breadcrumbs
        }
    }
}

</script>
