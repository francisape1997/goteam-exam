<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PokemonController;

Route::group(['prefix' => 'pokemon', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', [PokemonController::class, 'index']);

    Route::post('mark-as-favorite', [PokemonController::class, 'markAsFavorite']);
    Route::post('mark-as-liked', [PokemonController::class, 'markAsLiked']);
    Route::post('mark-as-hated', [PokemonController::class, 'markAsHated']);

    Route::delete('remove-as-favorite', [PokemonController::class, 'removeAsFavorite']);
    Route::delete('remove-as-liked', [PokemonController::class, 'removeAsLiked']);
    Route::delete('remove-as-hated', [PokemonController::class, 'removeAsHated']);
});
