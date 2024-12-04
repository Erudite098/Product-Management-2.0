<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [LoginController::class, 'apiLogin']);
Route::post('/register', [RegisterController::class, 'create']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::middleware('auth:sanctum')->group(function () {
    // Cart Item Actions
    Route::post('/cart/{cartId}/items', [CartController::class, 'addItemToCart']);
    Route::get('/cart/{cartId}/items', [CartController::class, 'viewCartItems']);
    Route::put('/cart/items/{cartItemId}', [CartController::class, 'updateItemQuantity']);
    Route::delete('/cart/items/{cartItemId}', [CartController::class, 'removeItemFromCart']);

    // Cart Actions
    Route::get('/cart/{cartId}', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'add']);
    Route::delete('/cart/{cartId}', [CartController::class, 'remove']);
});
