<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PokemonController;

Route::group(['prefix' => 'pokemon', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', [PokemonController::class, 'index']);
    Route::post('mark-as-favorite', [PokemonController::class, 'markAsFavorite']);
    Route::post('mark-as-liked', [PokemonController::class, 'markAsLiked']);
    // Route::post('mark-as-hated');
});
