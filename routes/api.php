<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\JobApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TagController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware([\App\Http\Middleware\Cors::class])->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
    Route::post('/social-login', [AuthController::class, 'socialLogin']);
    Route::post('password/email', [AuthController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [AuthController::class, 'resetPassword']);
});

Route::get('jobs', [JobApiController::class, 'index']);
Route::get('jobs/{job}', [JobApiController::class, 'show']);

Route::middleware([\App\Http\Middleware\Cors::class, 'auth:sanctum'])->group(function () {
    // job api
    Route::name('job.api.')->group(function () {
        // Route::get('jobs', [JobApiController::class, 'index']);
        Route::post('jobs', [JobApiController::class, 'store']);
        // Route::get('jobs/{job}', [JobApiController::class, 'show']);
        Route::put('jobs/{job}', [JobApiController::class, 'update']);
        Route::delete('jobs/{job}', [JobApiController::class, 'destroy']);
    });

      // Role management routes
    Route::name('role.api.')->group(function () {
        Route::get('roles', [AuthController::class, 'index']);
        Route::post('roles', [AuthController::class, 'store']);
        Route::get('roles/{id}', [AuthController::class, 'show']);
        Route::put('roles/{id}', [AuthController::class, 'update']);
        Route::delete('roles/{id}', [AuthController::class, 'destroy']);
    });
        Route::apiResource('tags', TagController::class);
        Route::apiResource('categories', CategoryController::class);
        Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
            return $request->user();
        });
});
