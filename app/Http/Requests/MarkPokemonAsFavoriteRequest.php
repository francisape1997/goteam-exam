<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Services\PokemonService;
use App\Models\UserSelection;

class MarkPokemonAsFavoriteRequest extends FormRequest
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

        # Check if the user already marked the pokemon as favorite.
        $pokemonExists = UserSelection::authenticatedUser()->whereFavorite()->where('pokemon', $this->name)->exists();

        if ($pokemonExists) {
            return false;
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
