<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::resource('/folders', FolderController::class);

    Route::put('/profile', [UserController::class, 'store']);
    Route::put('/password', [UserController::class, 'updatePassword']);
    Route::delete('/me/delete', [UserController::class, 'destroy']);
    Route::post('verify/password', [UserController::class, 'verifyPassword']);

    Route::group(['prefix' => 'stripe'], function () {
        Route::get('/products', [SubscriptionController::class, 'stripeProducts']);
        Route::post('/checkout', [SubscriptionController::class, 'stripeCheckout']);
        Route::post('/subscription/change', [SubscriptionController::class, 'changeSubscription']);
        Route::post('/subscription/cancel', [SubscriptionController::class, 'cancelSubscription']);
        Route::post('/subscription/resume', [SubscriptionController::class, 'resumeSubscription']);
        Route::get('/invoices', [SubscriptionController::class, 'stripeInvoices']);
    });

    Route::get('/cornell-notes/search', [NoteController::class, 'search']);
    Route::post('/cornell-notes/{note}/upload', [NoteController::class, 'uploadImage']);
    Route::put('/cornell-notes/{note}/move', [NoteController::class, 'move']);
    Route::resource('/cornell-notes', NoteController::class)->parameters([
        'cornell-notes' => 'note',
    ]);
});

Route::get('/demo/folders', [DemoController::class, 'folders']);

Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->name('newsletter.subscribe');
