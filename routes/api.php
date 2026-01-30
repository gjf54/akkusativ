<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\ChatController;
use App\Http\Controllers\api\MessageController;
use App\Http\Controllers\api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/show-token', function (Request $request) {
    dd($request);
})->middleware('auth:sanctum');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users/{login}', [UserController::class, 'show'])->middleware('auth:sanctum');

Route::apiResource('/chats', ChatController::class)->middleware('auth:sanctum');
Route::apiResource('/messages', MessageController::class)->middleware('auth:sanctum');

Route::get('chats/users/{login}', [ChatController::class, 'is_exists'])->middleware('auth:sanctum');

Route::prefix('/auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});






