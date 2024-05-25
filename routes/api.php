<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/post/create', [\App\Http\Controllers\API\PostController::class, 'create']);
Route::post('/post/subscribe', [\App\Http\Controllers\API\WebsiteController::class, 'subscribe']);
