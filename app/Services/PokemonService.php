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
     * Just for simplicity so we can get all list of pokemons.
     * We can implement a per page caching here
     * @var int
     */
    private const LIMIT = 50;

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

    public function removeAsFavorite($request)
    {
        $userSelection = UserSelection::owner()->whereFavorite()->where('pokemon', $request->name)->firstOrFail();

        $userSelection->delete();
    }

    public function removeAsLiked($request)
    {
        $userSelection = UserSelection::owner()->whereLiked()->where('pokemon', $request->name)->firstOrFail();

        $userSelection->delete();
    }

    public function removeAsHated($request)
    {
        $userSelection = UserSelection::owner()->whereHated()->where('pokemon', $request->name)->firstOrFail();

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

    /**
     * Get pokemons from the API
     */
    private function getPokemons()
    {
        $pokeApi = new PokeApi;

        return $pokeApi->resourceList('pokemon', self::LIMIT);
    }
}
