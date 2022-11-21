<?php

use App\Http\Controllers\DemoController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::group(['middleware' => ['billed']], function () {
        Route::get('/cornell-notes', [NoteController::class, 'index'])->name('home');
        Route::get('/cornell-notes/{note}', [NoteController::class, 'show']);
    });

    Route::get('/profile', [UserController::class, 'index']);
    Route::get('/change-password', [UserController::class, 'changePassword']);

    Route::get('/subscription', [SubscriptionController::class, 'index']);
    Route::get('payment/success', [SubscriptionController::class, 'successPayment']);
    Route::get('payment/cancelled', [SubscriptionController::class, 'cancelPayment']);
});

Route::get('/cornell-notes/{note}/public', [NoteController::class, 'publicNote'])
    ->name('cornell_notes.public')
    ->middleware('signed');

Route::get('/demo', [DemoController::class, 'index'])->name('demo');
Route::get('/demo/{demo_note}', [DemoController::class, 'show'])->name('demo.note');

require __DIR__.'/auth.php';

require __DIR__.'/front.php';
