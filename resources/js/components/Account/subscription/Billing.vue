<template>
    <div class="h-full">
        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5 relative">

                <Sidebar page="subscription" />

                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9 ">
                    <Plans :user="user"/>

                    <Invoices />
                </div>
            </div>
        </main>
    </div>
</template>

<script>

import Sidebar from "../Sidebar";
import Plans from "./Plans";
import Invoices from "./Invoices";

export default {

    components : {
        Sidebar,
        Plans,
        Invoices
    },

    props: [
        'user'
    ],
}
</script>
