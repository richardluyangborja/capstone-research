<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\ClientSatisfactionController;
use App\Http\Controllers\CommunicationController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\OpportunityController;
use App\Http\Controllers\PublicSurveyController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SalesRepresentativeController;
use App\Http\Controllers\WinOpportunityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/me', function () {
    return Auth::check();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('leads', LeadController::class)
        ->except(['destroy']);

    Route::patch('leads/{lead}/status', [LeadController::class, 'updateStatus']);

    Route::get(
        'sales-representatives',
        [SalesRepresentativeController::class, 'index']
    );

    Route::get('companies', [CompanyController::class, 'index']);

    Route::apiResource('clients', ClientController::class)
        ->only(['index', 'show']);

    Route::apiResource('opportunities', OpportunityController::class)
        ->except(['destroy']);

    Route::patch('opportunities/{opportunity}/stage', [OpportunityController::class, 'updateStage']);

    Route::post('opportunities/{opportunity}/win', [WinOpportunityController::class, 'win']);

    Route::apiResource('communications', CommunicationController::class)
        ->only(['index', 'show', 'store']);

    Route::apiResource('reminders', ReminderController::class)
        ->only(['index', 'show', 'store', 'update']);

    Route::get('satisfaction', [ClientSatisfactionController::class, 'index']);
    Route::get('satisfaction/{client}', [ClientSatisfactionController::class, 'show']);
    Route::post('satisfaction/{client}/surveys', [ClientSatisfactionController::class, 'store']);
    Route::delete('satisfaction/{client}/surveys/{survey}', [ClientSatisfactionController::class, 'destroy']);
});

Route::get('surveys/{token}', [PublicSurveyController::class, 'show']);
Route::post('surveys/{token}/submit', [PublicSurveyController::class, 'submit']);
