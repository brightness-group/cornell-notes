<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterRequest;
use Newsletter;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterRequest $request)
    {
        try {
            Newsletter::subscribe($request->email);

            return response()->json(['message' => 'Subscribed successfully.']);
        } catch (Exception $e) {

            return response()->json(['message' => $e->getMessage()], $e->getCode());
        }
    }
}
