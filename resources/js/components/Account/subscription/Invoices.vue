<template>
    <InvoicesLoader v-if="!isLoad" />
    <section v-if="isLoad" aria-labelledby="billing-history-heading" class="mobile:mx-5 mobile:overflow-hidden mobile:overflow-x-auto">
        <div v-if="invoices.length > 0" class="bg-white pt-6 shadow sm:rounded-md sm:overflow-hidden responsive-table">
            <div class="px-4 sm:px-6">
                <h2 id="billing-history-heading" class="text-lg leading-6 font-medium text-gray-900">Billing History</h2>
            </div>

            <div class="mt-6 flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8">
                        <div class="overflow-hidden border-t border-gray-200">

                            <table class="min-w-full w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                        <th scope="col" class="relative px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <span class="sr-only">View receipt</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(invoice,index) in invoices" :key="index">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            <time datetime="payment.datetime">{{ $dn.formatDate(invoice.created, 'yyyy-MM-dd') }}</time>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ invoice.lines.data[0].description }}
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ invoice.amount_paid/100 }}$
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a :href="invoice.hosted_invoice_url" target="blank" class="text-blue-600 hover:text-blue-900">View receipt</a>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import InvoicesLoader from "../subscription/loader/Invoices.vue";

export default {

    data() {
        return {
            invoices : [],
            isLoad : false
        }
    },

    components: {
        InvoicesLoader
    },

    mounted() {
        this.getInvoices();
    },

    methods: {

        getInvoices() {
            axios.get('/api/stripe/invoices').then(response => {
                this.isLoad = true;
                this.invoices = response.data.data;
            });
        },

    }
}
</script>
<style>
@media only screen and (max-width: 767px) {
    .responsive-table{
        width: 860px;
    }
}
</style>
