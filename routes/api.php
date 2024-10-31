<?php

use App\Http\Controllers\Api\TextController;
use Illuminate\Support\Facades\Route;

Route::controller(TextController::class)->group(function () {
    Route::post('/summarize', 'summarize');
    Route::post('/translate', 'translate');
    Route::post('/sentiment', 'sentiment');
    Route::post('/entity', 'entity');
})->middleware('throttle:3,1');
