<?php

use App\Http\Controllers\OneToManyController;
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
Route::get('/session', [OneToOneController::class, 'saveCityToSession']);   

// One To Many
Route::get('/ticket', [OneToManyController::class, 'getTickets']);
Route::get('/flight', [OneToManyController::class, 'getFlights']);
Route::get('/count-ticket', [OneToManyController::class, 'countTicket']);
Route::get('/ticket-relationship', [OneToManyController::class, 'getTicketRelationship']);
Route::post('/flight-relationship', [OneToManyController::class, 'setFlightRelationship']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
