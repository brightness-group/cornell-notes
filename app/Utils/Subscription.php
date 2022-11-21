<?php

namespace App\Utils;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Statamic\Facades\Term;

class Subscription
{
    public static function product($id)
    {
        return Cashier::stripe()->products->retrieve($id);
    }

    public static function extendTrial($user, $date)
    {
        $subscription = $user->subscriptions()->active()->latest()->first();

        $days = Carbon::parse(now()->startOfDay())->diffInDays($date);

        $subscription->extendTrial(now()->addDays($days));
    }

    public static function cancel($user)
    {
        if ($user->current_plan) {
            $id = $user->current_plan->stripe_id;

            $subscription = $user->stripe()->subscriptions->retrieve($id);

            $plan = $user->subscription($user->current_plan->name);

            if ($plan->onTrial()) {
                $plan->cancelAt($user->current_plan->trial_ends_at);
            } else {
                $subscription->cancel();
            }
        }
    }

    public static function status($user)
    {
        $plan = $user->current_plan;

        if ($plan) {
            return $plan->product->name.' - '.Str::ucfirst($user->current_plan->stripe_status);
        }
    }

    public static function products()
    {
        $products = Cashier::stripe()->products->all(['active' => true]);

        $names = array();
        
        foreach ($products->data as $key => $value) {
            $price = Cashier::stripe()->prices->retrieve($value->default_price);
            $value->price = $price;

            $features = Term::findBySlug(($value->name == 'Monthly') ? 'monthly' : 'yearly', 'plan_features')->in('default')->get('points');

            $value->features = $features;

            $names[$key] = $value->name;
        }

        array_multisort($names, SORT_ASC, $products->data);

        return $products->data; 
    }

    public static function checkout($user, $request)
    {
        $newSubscription = $user->newSubscription($request['plan_name'], $request['price']);

        $subscription = $user->subscriptions()->latest()->first();

        if ($subscription && $user->trial_days > 0) {
            $newSubscription = $newSubscription->trialUntil($subscription->trial_ends_at);
        } else {
            if (! $subscription && $request['trial_period_days']) {
                $newSubscription = $newSubscription->trialUntil(Carbon::now()->endOfDay()->addDays($request['trial_period_days']));
            }
        }

        return $newSubscription->checkout([
            'success_url' => env('SUCCESS_URL').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => env('CANCEL_URL'),
            'metadata' => ['name' => $request['plan_name']],
        ]);
    }

    public static function change($user, $price)
    {
        $subscription = $user->subscription($user->current_plan->name);

        if ($subscription) {
            if ($subscription->onTrial()) {
                $subscription = $subscription->skipTrial();
            }

            $subscription = $subscription->swapAndInvoice($price);
        }

        return $subscription;
    }

    public static function resume($user)
    {
        $subscription = $user->subscription($user->current_plan->name);

        if ($subscription) {
            $subscription->resume();
        }

        return $subscription;
    }
}
