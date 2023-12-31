<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;

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



Route::get('/', [FrontEndController::class,'index'])->name('index');
Route::get('/detail/{slug}', [FrontEndController::class,'details'])->name('details');


Route::middleware(['auth:sanctum','verified'])->group(function () {
    Route::get('/cart', [FrontEndController::class,'cart'])->name('cart');
    Route::post('/cart/{id}');
    Route::get('/checkout/success', [FrontEndController::class,'success'])->name('checkout-success');
});


Route::middleware([
    'auth:sanctum',config('jetstream.auth_session'),'verified'])->name('dashboard.')->prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class,'index'])->name('index');

    Route::middleware(['admin'])->group(function () {
        Route::resource('product', ProductController::class);
        Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only(
            [
                'index' , 'create', 'store', 'destroy'
            ]
        );
        Route::resource('transaction', TransactionController::class)->only(
            [
                'index' , 'show', 'edit', 'update'
            ]
        );
        Route::resource('user', UserController::class)->only(
            [
                'index' , 'edit', 'update', 'destroy'
            ]
        );
    });
}
);


