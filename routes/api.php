<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ExchangeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SyncController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Items
    Route::get('/items',        [ItemController::class, 'index']);
    Route::post('/items',       [ItemController::class, 'store']);
    Route::get('/items/{id}',   [ItemController::class, 'show']);
    Route::put('/items/{id}',   [ItemController::class, 'update']);
    Route::delete('/items/{id}',[ItemController::class, 'destroy']);

    // Exchanges
    Route::get('/exchanges/{id}', [ExchangeController::class,'show']);
    Route::post('/exchanges',     [ExchangeController::class,'store']); // transactional

    // Comments
    Route::get('/exchanges/{id}/comments', [CommentController::class,'index']);
    Route::post('/exchanges/{id}/comments',[CommentController::class,'store']);

    // Sync
    Route::get('/sync', [SyncController::class, 'pull']); // ?updated_since=ISO8601
});
