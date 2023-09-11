<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\SocialPlatFormController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

Route::get('/', function () {
    return view('auth.login');
});

// Route::post('/get-sms',[AgentQueueManageController::class, 'getSms']);
Route::post('/test',[AgentQueueManageController::class, 'checkStatus']);
Route::group(['middleware' => ['auth']], function () { 
    Route::post('/agent-assign-in-queues',[AgentQueueManageController::class, 'agentAssignInQueue']);
    Route::post('/get-session-sms',[SocialPlatFormController::class, 'getSessionMessage']);
    // Route::get('/complete',[SocialPlatFormController::class, 'clearMessage']);
});



Route::post('login',                            AuthController::class);
Route::resource('users',                        UserController::class);
Route::get('logout',                            [UserController::class, 'logout']);
Route::resource('roles',                        RoleController::class);
Route::resource('permissions',                  PermissionController::class);
Route::resource('agent',                        AgentController::class);
Route::resource('social-platform',              SocialPlatFormController::class);
Route::post('/agent-reply-message',             [SocialPlatFormController::class,'agentReplyMessage'])->name('agent.message.reply');
Route::resource('webhook-log',                  WebHookController::class);

Route::get('fb-page-webhook',                   [WebHookController::class, 'webHook']);
Route::post('fb-page-webhook',                  [WebHookController::class, 'fbPageWebHookData']);
Route::post('instagram-webhook',                [WebHookController::class, 'instagramWebHookData']);
Route::post('whatsapp-webhook',                 [WebHookController::class, 'whatsAppWebHookData']);

/* API */
// Route::get('api/v1/getAccount/{id}', [AccountController::class, 'getAccount']);
