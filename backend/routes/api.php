<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\SalesRepresentativeController;
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

    Route::get(
        'sales-representatives',
        [SalesRepresentativeController::class, 'index']
    );

    Route::apiResource('clients', ClientController::class)
        ->only(['index', 'show']);
});
