<?php

use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/tracks', [TrackController::class, 'index']);
    Route::post('/tracks', [TrackController::class, 'store']);
    Route::get('/tracks/{track}', [TrackController::class, 'show']);
    Route::put('/tracks/{track}', [TrackController::class, 'update']);
    Route::delete('/tracks/{track}', [TrackController::class, 'destroy']);
});