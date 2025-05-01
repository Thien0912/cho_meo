<?php

use App\Http\Controllers\Api\ChatApiController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TransactionApiController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthApiController::class, 'login']);
Route::post('/google-login', [AuthApiController::class, 'googleLogin']);
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/deposit', [TransactionApiController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/get-coins', [AuthApiController::class, 'fetchUserCoins']);
    Route::get('/user/{id}', [AuthApiController::class, 'getUser']);
    Route::put('/user/{id}', [AuthApiController::class, 'updateUser']);
    Route::post('/chat/upload', [ChatApiController::class, 'handleUpload']);
});