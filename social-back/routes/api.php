<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\AgentQueueManageController;


// Only for Agents
Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/get-sms',[AgentQueueManageController::class, 'getSms']);
Route::post('/test',[AgentQueueManageController::class, 'checkStatus']);


Route::middleware(['auth:sanctum', 'type.agent'])->group(function () {
    Route::post('/agent-assign-in-queues',[AgentQueueManageController::class, 'agentAssignInQueue']);
    Route::get('/complete',[AgentQueueManageController::class, 'clearMessage']);
});

