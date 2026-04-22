<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::middleware('auth:sanctum')->post('/posts', [PostController::class, 'store']);
Route::middleware('auth:sanctum')->delete('/posts/{id}', [PostController::class, 'destroy']);
Route::middleware('auth:sanctum')->put('/posts/{id}', [PostController::class, 'update']);

require __DIR__.'/auth.php';