<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Product routes

Route::resource('products', 'App\Http\Controllers\ProductController')->only(['index', 'show'])->middleware('cors');

Route::name('product.add-to-cart')
    ->post('products/{product}/to-cart', 'App\Http\Controllers\ProductController@addToCart')
    ->middleware(['cors', 'auth:api']);

// User routes

Route::resource('users', 'App\Http\Controllers\UserController')->only('store')->middleware(['cors']);

Route::name('user.authenticate')
    ->post('login', 'App\Http\Controllers\UserController@login')
    ->middleware(['cors']);

Route::name('user.logout')
    ->post('logout', 'App\Http\Controllers\UserController@logout')
    ->middleware(['cors', 'auth:api']);

// ProductsToCart routes

Route::resource('shopping-cart/{shoppingCart}', 'App\Http\Controllers\ProductsToCartController')->only(['index'])->middleware(['cors', 'auth:api']);

Route::name('productsToCart.subtotal')
    ->get('subtotal', 'App\Http\Controllers\ProductsToCartController@getSubtotal')
    ->middleware(['cors', 'auth:api']);

Route::name('productsToCart.buy')
    ->get('buy', 'App\Http\Controllers\ProductsToCartController@buy')
    ->middleware(['cors', 'auth:api']);

Route::name('product.remove-from-cart')
    ->delete('shopping-cart/{productId}', 'App\Http\Controllers\ProductsToCartController@removeFromCart')
    ->middleware(['cors', 'auth:api']);

    
// Route::name('user.logout')
//     ->get('logout', 'App\Http\Controllers\UserController@logout')->middleware(['web']);

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');