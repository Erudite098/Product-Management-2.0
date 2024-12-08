<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/register', [RegisterController::class, 'create']);
Route::post('/logout', [LogoutController::class, 'logout']);

Route::get('/products', [ProductController::class, 'index']); //list of products
Route::get('/products/{id}', [ProductController::class, 'show']); //show specific product
Route::post('/products', [ProductController::class, 'store']); //add new product
Route::put('/products/{id}', [ProductController::class, 'update']); //update product
Route::delete('/products/{id}', [ProductController::class, 'destroy']); //remove product

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart/add', [CartController::class, 'addItem']); //add product to cart
    Route::get('/cart', [CartController::class, 'viewCart']); //view cart
    Route::put('/cart/update/{cartItemid}', [CartController::class, 'updateCart']); //update am item quantity in cart
    Route::delete('/cart/remove/{cartItemid}', [CartController::class, 'removeItem']); //remove an item from cart
    Route::post('/cart/clear', [CartController::class, 'clearCart']); //clear cart
});