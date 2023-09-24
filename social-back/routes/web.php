<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebHookController;
use App\Http\Controllers\AgentQueueManageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('fb-page-webhook',                  [WebHookController::class, 'fbPageWebHookData']);
Route::get('/test',[AgentQueueManageController::class, 'checkStatus']);
