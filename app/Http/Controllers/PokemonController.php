<?php

namespace App\Http\Controllers;

use App\Services\PokemonService;

use App\Http\Requests\MarkPokemonAsFavoriteRequest;
use App\Http\Requests\MarkPokemonAsLikedRequest;
use App\Http\Requests\MarkPokemonAsHatedRequest;

use Illuminate\Http\Request;

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

    public function removeAsFavorite($pokemon)
    {
        $this->pokemonService->removeAsFavorite($pokemon);

        return response()->noContent();
    }

    public function removeAsLiked($pokemon)
    {
        $this->pokemonService->removeAsLiked($pokemon);

        return response()->noContent();
    }

    public function removeAsHated($pokemon)
    {
        $this->pokemonService->removeAsHated($pokemon);

        return response()->noContent();
    }
}
