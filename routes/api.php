<?php

use App\Http\Controllers\Api\UrlMetadataController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/url-metadata', [UrlMetadataController::class, 'extract']);
});
