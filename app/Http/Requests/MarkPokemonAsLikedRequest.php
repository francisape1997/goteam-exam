<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Services\PokemonService;
use App\Models\UserSelection;

class MarkPokemonAsLikedRequest extends FormRequest
{
    private const LIMIT = 3;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(PokemonService $pokemonService)
    {
        # Check if the input pokemon is valid.
        $pokemonService->validatePokemon($this->name);

        $likedPokemons = UserSelection::owner()->whereLiked();
        
        if ($likedPokemons->count() === self::LIMIT) {
            abort(422, 'You can only like 3 pokemons');
        }

        if ($likedPokemons->where('pokemon', $this->name)->exists()) {
            abort(422, 'You already liked this pokemon');
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }
}
