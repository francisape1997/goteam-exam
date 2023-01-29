<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;

use App\Http\Requests\MarkPokemonAsFavoriteRequest;
use App\Http\Requests\MarkPokemonAsLikedRequest;
use App\Http\Requests\MarkPokemonAsHatedRequest;

use App\Http\Requests\RemovePokemonAsFavoriteRequest;
use App\Http\Requests\RemovePokemonAsLikedRequest;
use App\Http\Requests\RemovePokemonAsHatedRequest;

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

    public function markAsHated(MarkPokemonAsHatedRequest $request)
    {
        return response($this->pokemonService->markAsHated($request));
    }

    public function removeAsFavorite(RemovePokemonAsFavoriteRequest $request)
    {
        $this->pokemonService->removeAsFavorite($request);

        return response()->noContent();
    }

    public function removeAsLiked(RemovePokemonAsLikedRequest $request)
    {
        $this->pokemonService->removeAsLiked($request);

        return response()->noContent();
    }

    public function removeAsHated(RemovePokemonAsHatedRequest $request)
    {
        $this->pokemonService->removeAsHated($request);

        return response()->noContent();
    }
}
