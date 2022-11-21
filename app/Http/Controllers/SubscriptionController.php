<?php

namespace App\Http\Controllers;

use App\Providers\RouteServiceProvider;
use App\Utils\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('user.account.billing');
    }

    public function stripeProducts(Request $request)
    {
        return response()->json(['data' => Subscription::products()]);
    }

    public function stripeCheckout(Request $request)
    {
        return response()->json(['data' => $request->user()->checkout($request->all())]);
    }

    public function changeSubscription(Request $request)
    {
        return response()->json(['message' => 'Subscription changed successfully!!', 'data' => $request->user()->change($request->price)]);
    }

    public function successPayment(Request $request)
    {
        $checkoutSession = $request->user()->stripe()->checkout->sessions->retrieve($request->get('session_id'));
        $plan = $request->user()->current_plan;

        $purchase = [
            'value' =>  $checkoutSession->amount_total / 100,
            'currency' => $checkoutSession->currency,
            'transaction_id' => $checkoutSession->subscription,
            'items' => [[
                'id' => $plan->stripe_price,
                'name' => $plan->name,
                'quantity' => $plan->quantity,
                'price' => $checkoutSession->amount_total / 100
            ]]
        ];

        return redirect()->intended(RouteServiceProvider::redirectUrl())->with('purchase', $purchase);
    }

    public function cancelPayment(Request $request)
    {
        return redirect('subscription');
    }

    public function cancelSubscription(Request $request)
    {
        $request->user()->cancelSubscription();

        return response()->json(['message' => 'Subscription canceled successfully!!', 'data' => $request->user()]);
    }

    public function stripeInvoices(Request $request)
    {
        $invoices = $request->user()->invoices();

        return response()->json(['data' => $invoices]);
    }

    public function resumeSubscription(Request $request)
    {
        $request->user()->resumeSubscription();

        return response()->json(['message' => 'Subscription resumed successfully!!']);
    }
}
