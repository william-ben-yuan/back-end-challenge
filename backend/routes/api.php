<?php

use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::get('/tracks', [TrackController::class, 'index']);
    Route::post('/tracks/{isrc}', [TrackController::class, 'import']);
    Route::get('/tracks/{track}', [TrackController::class, 'show']);
    Route::delete('/tracks/{track}', [TrackController::class, 'destroy']);
});