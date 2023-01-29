<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

use Laravel\Sanctum\Sanctum;

use App\Services\PokemonService;

class PokemonTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_pokemoms()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->getJson(route('pokemon.index'))->assertStatus(200);
    }

    public function test_like_pokemon()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $pokemonService = $this->app->make(PokemonService::class);

        $randomPokemon = $pokemonService->getRandomPokemon();

        $this->postJson(route('pokemon.mark-as-liked'), [
            'name' => $randomPokemon,
        ])->assertStatus(200);
    }

    public function test_hate_pokemon()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $pokemonService = $this->app->make(PokemonService::class);

        $randomPokemon = $pokemonService->getRandomPokemon();

        $this->postJson(route('pokemon.mark-as-hated'), [
            'name' => $randomPokemon,
        ])->assertStatus(200);
    }

    public function test_favorite_pokemon()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $pokemonService = $this->app->make(PokemonService::class);

        $randomPokemon = $pokemonService->getRandomPokemon();

        $this->postJson(route('pokemon.mark-as-favorite'), [
            'name' => $randomPokemon,
        ])->assertStatus(200);
    }

    public function test_unlike_pokemon()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $pokemonService = $this->app->make(PokemonService::class);

        $randomPokemon = $pokemonService->getRandomPokemon();

        $this->postJson(route('pokemon.mark-as-liked'), [
            'name' => $randomPokemon,
        ])->assertStatus(200);

        $this->deleteJson(route('pokemon.remove-as-liked', $randomPokemon))->assertNoContent();
    }

    public function test_unhate_pokemon()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $pokemonService = $this->app->make(PokemonService::class);

        $randomPokemon = $pokemonService->getRandomPokemon();

        $this->postJson(route('pokemon.mark-as-hated'), [
            'name' => $randomPokemon,
        ])->assertStatus(200);

        $this->deleteJson(route('pokemon.remove-as-hated', $randomPokemon))->assertNoContent();
    }

    public function test_unfavorite_pokemon()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $pokemonService = $this->app->make(PokemonService::class);

        $randomPokemon = $pokemonService->getRandomPokemon();

        $this->postJson(route('pokemon.mark-as-favorite'), [
            'name' => $randomPokemon,
        ])->assertStatus(200);

        $this->deleteJson(route('pokemon.remove-as-favorite', $randomPokemon))->assertNoContent();
    }
}
