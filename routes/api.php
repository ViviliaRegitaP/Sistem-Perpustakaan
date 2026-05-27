<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FineController;

// ======================
// UPDATE DENDA VIA API
// ======================
Route::middleware('auth')->group(function () {
    Route::post('/denda/{fines_id}', [FineController::class, 'update']);
});
