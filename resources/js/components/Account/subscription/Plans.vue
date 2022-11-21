<template>

    <PlansLoader v-if="!isLoad" ref="isLoaded"/>

    <section v-if="isLoad" class="relative" aria-labelledby="pricing-heading">
        <h2 id="pricing-heading" class="sr-only">Pricing</h2>

        <div class="max-w-2xl mx-auto px-4 space-y-12 sm:px-6 lg:max-w-7xl lg:space-y-0 lg:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
            <div v-for="product in products" :key="product.id" class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">

                <div class="flex-1">

                    <h3 class="text-xl font-semibold text-gray-900">{{ product.name }}</h3>

                    <p v-if="isActivePlan(product.default_price)" class="absolute top-0 py-1.5 px-4 bg-blue-500 rounded-full text-xs font-semibold uppercase tracking-wide text-white transform -translate-y-1/2">Current Plan</p>

                    <p class="mt-4 flex items-baseline text-gray-900">
                        <span class="text-5xl font-extrabold tracking-tight">${{ product.price.unit_amount / 100 }}</span>
                        <span class="ml-1 text-xl font-semibold"> / {{ product.price.recurring.interval }}</span>
                    </p>

                    <span class="ml-1 text-sm text-blue-500 font-semibold" v-if="isActivePlan(product.default_price) && user.current_plan && user.current_plan.trial_ends_at">{{ (user.trial_days > 0) ? `Your trial expires in ${user.trial_days} days`  : `Your trial has expired` }}</span>

                    <span class="ml-1 text-sm text-blue-500 font-semibold" v-else-if="!isActivePlan(product.default_price) && product.price.recurring.trial_period_days">{{ product.price.recurring.trial_period_days }}-day free trial</span>

                    <p v-if="product.description" class="mt-6 text-gray-500">{{ product.description }}</p>

                    <ul role="list" class="mt-6 space-y-6">
                        <li class="flex" v-for="feature in product.features" :key="feature">
                            <CheckIcon class="flex-shrink-0 w-6 h-6 text-blue-500" aria-hidden="true" />
                            <span class="ml-3 text-gray-500">{{ feature }}</span>
                        </li>
                    </ul>
                </div>

                <button v-if="!user.current_plan" href="javascript:;"
                   @click="generateCheckoutSession(product)" :disabled="disabled"
                   :class="['bg-blue-500 text-white hover:bg-blue-600 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium']">
                    {{ `Buy ${product.name} Plan` }}
                </button>

                <button v-else-if="isActivePlan(product.default_price)"
                   href="javascript:;" ref="cancel" :disabled="disabled" @click="(user.current_plan.is_cancel_plan) ? resumePlan() : confirmCancelSubscription()"
                   :class="[ 'bg-red-500 text-white hover:bg-red-600 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium shadow-sm inline-flex justify-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900']">

                   <svg v-show="cancelLoader" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    {{ (user.current_plan.is_cancel_plan) ? 'Resume' : 'Cancel Plan'}}
                </button>

                <button v-else href="javascript:;"
                   @click="changePlan(product)" :disabled="disabled"
                   :class="'bg-blue-500 text-white hover:bg-blue-600 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium shadow-sm inline-flex justify-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-900'" >

                   <svg v-show="changeLoader" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    {{ `Upgrade to ${product.name}` }}
                </button>

            </div>
        </div>
    </section>

    <!-- Cancel Subscription -->
    <Confirm ref="confirmSubscriptionRef"
                color="red"
                confirm-text="Cancel"
                @confirm="cancelPlan"
    >
        <template #icon>
            <ExclamationIcon class="h-6 w-6 text-red-600" aria-hidden="true" />
        </template>

        <template #title>
            Cancel Subscription
        </template>

        <template #content>
            Are you sure you want to Cancel the Subscription?
        </template>
    </Confirm>

    <Notification ref="notifyRef" />

</template>

<script>

import Confirm from "../../modals/Confirm.vue";
import Notification from "../../mix/Notification";
import PlansLoader from "../subscription/loader/Plans.vue";

import { CheckIcon, ExclamationIcon } from '@heroicons/vue/outline'

export default {

    props: [
        'user'
    ],

    components : {
        CheckIcon,
        Notification,
        Confirm,
        ExclamationIcon,
        PlansLoader
    },

    data() {
        return {
            products: [],
            disabled: false,
            cancelLoader: false,
            changeLoader: false,
            isLoad : false
        }
    },

    mounted() {
        this.getProducts();
    },

    methods: {

        getProducts() {
            this.products = [];
            axios.get('/api/stripe/products').then(response => {

                if (response.status === 200) {
                    this.isLoad = true;

                    this.products = response.data.data;
                }
            });
        },

        generateCheckoutSession(data) {
            this.disabled = true;
            const payload = {
                price: data.default_price,
                product_id: data.id,
                trial_period_days: data.price.recurring.trial_period_days,
                plan_name: data.name,
            }

            axios.post('/api/stripe/checkout', payload).then(response => {
                window.location.href = response.data.data.url;
            });
        },

        changePlan(data) {
            this.disabled = true;
            this.changeLoader = true;

            const payload = {
                price: data.default_price,
                trial_period_days: data.price.recurring.trial_period_days,
                plan_name: data.name,
            }

            axios.post('/api/stripe/subscription/change',payload).then(response => {
                this.$refs.notifyRef.open(response.data.message);
                location.reload();
            });
        },

        isActivePlan(price) {
            return (this.user.current_plan ) ? this.user.current_plan.stripe_price === price : false;
        },

        confirmCancelSubscription() {
            this.$refs.confirmSubscriptionRef.show();
        },

        cancelPlan() {
            this.disabled = true;
            this.cancelLoader = true;

            axios.post('/api/stripe/subscription/cancel').then(response => {

                this.$refs.confirmSubscriptionRef.hide();
                this.$refs.notifyRef.open(response.data.message);

                let current_plan = response.data.data.current_plan;

                this.user.current_plan.stripe_price = (current_plan.is_cancel_plan) ? current_plan.stripe_price : '';
                this.user.current_plan.is_cancel_plan = current_plan.is_cancel_plan

                this.disabled = false;
                this.cancelLoader = false;

                setTimeout(() => {
                    location.reload();
                }, 400);

            });
        },

        resumePlan() {
            this.disabled = true;
            this.cancelLoader = true;

            axios.post('/api/stripe/subscription/resume').then(response => {
                this.$refs.notifyRef.open(response.data.message);

                this.disabled = false;
                this.cancelLoader = false;

                location.reload();
            });
        }
    }
}
</script>
