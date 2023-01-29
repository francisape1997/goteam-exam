<?php

namespace App\Services;

use App\Interfaces\CacheInterface;

use PokePHP\PokeApi;

use App\Models\UserSelection;

use App\Enums\MarkTypeEnum;

class PokemonService
{
    private const KEY = 'pokemons';

    /**
     * Just for simplicity.
     * We can implement a per page caching here
     * @var int
     */
    private const LIMIT = 100;

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
            'type_id' => MarkTypeEnum::FAVORITED->value,
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

    public function markAsHated($request)
    {
        return UserSelection::create([
            'user_id' => $request->user()->id,
            'type_id' => MarkTypeEnum::HATED->value,
            'pokemon' => $request->name,
        ]);
    }

    public function removeAsFavorite($pokemon)
    {
        $userSelection = UserSelection::owner()->whereFavorite()->where('pokemon', $pokemon)->firstOrFail();

        $userSelection->delete();
    }

    public function removeAsLiked($pokemon)
    {
        $userSelection = UserSelection::owner()->whereLiked()->where('pokemon', $pokemon)->firstOrFail();

        $userSelection->delete();
    }

    public function removeAsHated($pokemon)
    {
        $userSelection = UserSelection::owner()->whereHated()->where('pokemon', $pokemon)->firstOrFail();

        $userSelection->delete();
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

    public function getRandomPokemon()
    {
        $pokemons = $this->list();

        $results = $pokemons->results;

        $names = array_column($results, 'name');

        return $names[rand(0, count($names))];
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
