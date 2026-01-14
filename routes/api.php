<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteImageController;

Route::get('/images', [FavoriteImageController::class, 'index']);
Route::post('/images', [FavoriteImageController::class, 'store']);
Route::delete('/images/{id}', [FavoriteImageController::class, 'destroy']);
