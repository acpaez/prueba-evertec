<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\http\Controllers\OrderController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('create-order', [OrderController::class, 'index'])->name('create-order');
    Route::get('list-order', [OrderController::class, 'listOrder'])->name('list-order');
    Route::post('create',[OrderController::class, 'createOrder'])->name('create');
    Route::get('list-orders',[OrderController::class, 'listOrders'])->name('list-orders');
    Route::post('payment', 'App\Http\Controllers\PaymentController@createNewPaymentRequest');
    Route::get('pay-order',[OrderController::class, 'payOrder'])->name('pay-order');
    Route::post('status-pay', 'App\Http\Controllers\PaymentController@statusPayment');

    
});
