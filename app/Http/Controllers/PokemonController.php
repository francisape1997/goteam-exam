<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;

use App\Http\Requests\MarkPokemonAsFavoriteRequest;
use App\Http\Requests\MarkPokemonAsLikedRequest;

class PokemonController extends Controller
{
    public function __construct(private PokemonService $pokemonService) {}

    public function index()
    {
        return response()->json($this->pokemonService->list());
    }

    public function markAsFavorite(MarkPokemonAsFavoriteRequest $request)
    {
        return response($this->pokemonService->markAsFavorite($request));
    }

    public function markAsLiked(MarkPokemonAsLikedRequest $request)
    {
        return response($this->pokemonService->markAsLiked($request));
    }
}
