<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Services\PokemonService;
use App\Models\UserSelection;

class MarkPokemonAsLikedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(PokemonService $pokemonService)
    {
        # Check if the input pokemon is valid.
        $pokemonService->validatePokemon($this->name);

        $likedPokemons = UserSelection::authenticatedUser()->whereLiked()->where('pokemon', $this->name);

        dd($likedPokemons->count());

        if ($likedPokemons->count() > 3) {
            abort(422, 'You can only like 3 pokemons');
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
