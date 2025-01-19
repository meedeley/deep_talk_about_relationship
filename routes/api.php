<?php

use App\Http\Controllers\OneToOneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// One To One
Route::get('/cities', [OneToOneController::class, 'getCities']);
Route::get('/sellers', [OneToOneController::class, 'getSellers']);
Route::get('/city-name', [OneToOneController::class, 'getNameCity']);
Route::get('/city/{cities:id}', [OneToOneController::class, 'getCityById']);
Route::get('/seller-json', [OneToOneController::class, 'sellerJsonToCollect']);
Route::get('/cookie', [OneToOneController::class, 'getCookie']);
Route::get('/save-cookie', [OneToOneController::class, 'saveSellerToCookie']);

// One To Many

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
