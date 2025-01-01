<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('api')->group(function () {

    Route::post('/login', [AuthController::class, 'login'])->name('api.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');

        Route::get('get-published-posts', [PostController::class, 'getPublishedData']);
        Route::get('get-draft-posts', [PostController::class, 'getDraftData']);
        Route::get('get-all-posts', [PostController::class, 'getAllData']);
        Route::post('create-post', [PostController::class, 'createPost']);
        Route::put('update-post/{id}', [PostController::class, 'updatePost']);
        Route::delete('delete-post/{id}', [PostController::class, 'deletePost']);
        });
});
