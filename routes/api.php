<?php

use App\Http\Controllers\Backend\IncidentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
        return $request->user();
    })->middleware('auth:sanctum');

    Route::apiResource('incidents', IncidentController::class)
        ->only(['index', 'store', 'show', 'update', 'destroy']);

    Route::prefix('incidents/{incident}')->group(function () {
        Route::patch('status', [IncidentController::class, 'updateStatus']);
        Route::post('attach-services', [IncidentController::class, 'attachServices']);
    });

    Route::get('incidents/status/{status}', [IncidentController::class, 'getByStatus']);
    Route::get('incidents/type/{type}', [IncidentController::class, 'getByType']);
    Route::get('user/incidents', [IncidentController::class, 'getUserIncidents'])->middleware('auth:api');
