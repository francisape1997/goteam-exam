<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

use Laravel\Sanctum\Sanctum;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_get_users()
    {
        $this->seed();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->getJson(route('user.list'))->assertStatus(200);
    }

    // public function test_login_user()
    // {
    //     $user = User::factory()->create();

    //     $this->postJson(route('login'), [
    //         'email' => $user->email,
    //         'password' => 'password',
    //     ])->assertStatus(200);
    // }

    public function test_register_user()
    {
        $password = $this->faker()->password();

        $this->postJson(route('register'), [
            'email' => $this->faker()->email(),
            'first_name' => $this->faker()->firstName(),
            'last_name' => $this->faker()->lastName(),
            'password' => $password,
            'password_confirmation' => $password,
            'date_of_birth' => $this->faker()->date(),
        ])
        ->assertStatus(200);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->postJson(route('logout'))->assertNoContent();
    }

    public function test_get_profile()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->getJson(route('user.profile'))->assertStatus(200);
    }

    public function test_update_user()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $this->putJson(route('user.update'), [
            'first_name' => $this->faker()->firstName(),
            'last_name' => $this->faker()->lastName(),
            'date_of_birth' => $this->faker()->date(),
        ])->assertStatus(200);
    }
}
