<template>
    <section class="relative" aria-labelledby="pricing-heading">
        <h2 id="pricing-heading" class="sr-only">Pricing</h2>

        <div class="max-w-2xl mx-auto animate-pulse  px-4 space-y-12 sm:px-6 lg:max-w-7xl lg:space-y-0 lg:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
            <div v-for="item in items" :key="item" class="relative  p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">

                <div class="flex-1 ">
                    <h3 class="text-xl h-4 bg-blue-200 font-semibold text-gray-900"></h3>

                    <p class="mt-4 bg-blue-200 flex  ">
                        <span class=" bg-blue-200 h-10 tracking-tight"></span>
                        <span class="ml-1 text-xl bg-blue-200 h-10 font-semibold"></span>
                    </p>

                    <span class="ml-1 text-sm bg-blue-200 h-2 text-blue-500 font-semibold" ></span>

                    <p class="mt-6 bg-blue-200 h-6 "></p>
                    <ul role="list" class="mt-6  bg-blue-200 space-y-6">
                        <li class="flex ">
                            <div class="flex-shrink-0 bg-blue-200 w-6 h-6 text-blue-500" aria-hidden="true" />
                            <span class="ml-3  h-2 bg-blue-200"></span>
                        </li>

                        <li class="flex">
                            <div class="flex-shrink-0 w-6 h-6 text-blue-500 bg-blue-200" aria-hidden="true" />
                            <span class="ml-3  h-2 bg-blue-200"></span>
                        </li>

                        <li class="flex">
                            <div class="flex-shrink-0 w-6 h-6 text-blue-500 bg-blue-200" aria-hidden="true" />
                            <span class="ml-3  h-2 bg-blue-200"></span>
                        </li>
                    </ul>
                </div>

                <button class=" mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium bg-blue-200"></button>

            </div>
        </div>
    </section>
</template>

<script>
import { CheckIcon } from '@heroicons/vue/outline'

export default {

    components : {
        CheckIcon,
    },

    data() {
        return {
            items: [1,2],
        }
    }
}
</script>
