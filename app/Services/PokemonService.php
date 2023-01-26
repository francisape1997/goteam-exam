<?php

namespace App\Services;

use App\Interfaces\CacheInterface;

use PokePHP\PokeApi;

use App\Models\UserSelection;

use App\Enums\MarkTypeEnum;

class PokemonService
{
    private const KEY = 'pokemons';
    private const LIMIT = 2000;

    public function __construct(private CacheInterface $cacheInterface) {}

    public function list()
    {
        $cachedPokemons = $this->cacheInterface->get(self::KEY);

        if (!$cachedPokemons) {
            $pokemons = $this->getPokemons();

            $this->cacheInterface->set(self::KEY, $pokemons);

            return json_decode($pokemons);
        }

        return json_decode($cachedPokemons);
    }

    public function markAsFavorite($request)
    {
        return UserSelection::create([
            'user_id' => $request->user()->id,
            'type_id' => MarkTypeEnum::FAVORITE->value,
            'pokemon' => $request->name,
        ]);
    }

    public function markAsLiked($request)
    {
        return UserSelection::create([
            'user_id' => $request->user()->id,
            'type_id' => MarkTypeEnum::LIKED->value,
            'pokemon' => $request->name,
        ]);
    }

    /**
     * @param string $name
     * @return void
     */
    public function validatePokemon(string $name) : void
    {
        $pokemons = $this->list();

        $results = $pokemons->results;

        $names = array_column($results, 'name');

        if (!in_array($name, $names)) {
            abort(422, 'Invalid pokemon!');
        }
    }

    /**
     * Get pokemons from the API
     */
    private function getPokemons()
    {
        $pokeApi = new PokeApi;

        return $pokeApi->resourceList('pokemon', self::LIMIT);
    }
}
