<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', fn (Request $request) => $request->user());
});

Route::prefix('v1')->group(function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::apiResource('users', App\Http\Controllers\API\UserController::class)->only(['index', 'show', 'store']);
        Route::post('login', [App\Http\Controllers\API\SessionController::class, 'store']);

        Route::middleware('auth:sanctum')->group(function () {
            Route::delete('logout', [App\Http\Controllers\API\SessionController::class, 'destroy']);
            Route::apiResource('users', App\Http\Controllers\API\UserController::class)->only(['update']);
            Route::post('change-password', App\Http\Controllers\API\ChangePasswordController::class);

            Route::apiResource('lots', App\Http\Controllers\API\LotController::class)->only(['store', 'update']);
        });

        Route::post('password/email',  App\Http\Controllers\API\ForgotPasswordController::class);
        Route::post('password/code/check', App\Http\Controllers\API\CodeCheckController::class);
        Route::post('password/reset', App\Http\Controllers\API\ResetPasswordController::class);
    });

    Route::apiResource('lots', App\Http\Controllers\API\LotController::class)->only(['index', 'show']);


});

