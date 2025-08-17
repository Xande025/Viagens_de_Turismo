<?php

use App\Http\Controllers\Api\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// API REST para listar viagens (RNF03)
Route::get('/trips', [TripController::class, 'index']);
