<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\UserPreferenceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'signin']);
Route::post('register', [AuthController::class, 'signup']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('articles', ArticleController::class);
    Route::patch('/preferences', [UserPreferenceController::class, 'update']);
    Route::get('/preferred-news', [UserPreferenceController::class, 'getPreferredNews']);
});

