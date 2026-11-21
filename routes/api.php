<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('login', [UserController::class, 'login']);
Route::post('register', [UserController::class, 'register']);

Route::get('Places', [PlaceController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('placeCreate', [PlaceController::class, 'store']);
    Route::post('placeDelete/{place}', [PlaceController::class, 'destroy']);
    Route::get('place/{place}', [PlaceController::class, 'show']);
    Route::post('placeEdit/{place}', [PlaceController::class, 'update']);
    Route::post('orderCreate', [OrderController::class, 'store']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::post('orderStatusUpdate/{order}', [OrderController::class, 'update']);
    Route::get('userOrders', [OrderController::class, 'userOrders']);
    Route::post('commentCreate/{order}', [CommentController::class, 'store']);
});
