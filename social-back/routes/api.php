<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminAuthenticationController;
use App\Http\Controllers\Api\AgentAuthenticationController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Admin authentication routes
Route::middleware(['auth:api'])->post('/admin/test', [AdminAuthenticationController::class, 'test']);
Route::post('/admin/login', [AdminAuthenticationController::class, 'login']);
// Route::post('/admin/test', [AdminAuthenticationController::class, 'test'])->middleware("auth.api"); https://nothingworks.netlify.app/blog/laravel-sanctum-multi-auth/

// Agent authentication routes
Route::post('/agent/login', [AgentAuthenticationController::class, 'login']);
Route::post('/agent/test', [AgentAuthenticationController::class, 'test']);