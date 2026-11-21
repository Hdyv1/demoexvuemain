<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);
Route::post('placeCreate', [PlaceController::class, 'store']);
Route::get('Places', [PlaceController::class, 'index']);
Route::post('placeDelete/{place}', [PlaceController::class, 'destroy']);
Route::get('place/{place}', [PlaceController::class, 'show']);
Route::post('placeEdit/{place}', [PlaceController::class, 'update']);