<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PokemonController;

Route::group(['prefix' => 'pokemon', 'middleware' => 'auth:sanctum'], function() {
    Route::get('/', [PokemonController::class, 'index'])->name('pokemon.index');

    Route::post('mark-as-favorite', [PokemonController::class, 'markAsFavorite'])->name('pokemon.mark-as-favorite');
    Route::post('mark-as-liked', [PokemonController::class, 'markAsLiked'])->name('pokemon.mark-as-liked');
    Route::post('mark-as-hated', [PokemonController::class, 'markAsHated'])->name('pokemon.mark-as-hated');

    Route::delete('remove-as-favorite/{pokemon}', [PokemonController::class, 'removeAsFavorite'])->name('pokemon.remove-as-favorite');
    Route::delete('remove-as-liked/{pokemon}', [PokemonController::class, 'removeAsLiked'])->name('pokemon.remove-as-liked');
    Route::delete('remove-as-hated/{pokemon}', [PokemonController::class, 'removeAsHated'])->name('pokemon.remove-as-hated');
});
