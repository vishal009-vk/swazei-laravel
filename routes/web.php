<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes([
    'reset' => false,
    'verify' => false,
]);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::resource('product', ProductController::class);

    // Order Route's
    Route::get('order-list', [OrderController::class, 'index'])->name('order.list');
    Route::get('order-product/{product}', [OrderController::class, 'orderProduct'])->name('order.product');
    Route::get('cancel-order/{order}', [OrderController::class, 'cancelOrder'])->name('cancel.order');
});
