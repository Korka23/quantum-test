<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;


class LoginUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'name' => 'test',
            'email' => fake()->unique()->email,
            'password' => 'password'
        ]);

        $response = $this->get('/api/login?email='.$user->email.'&password=password');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'message',
                'token'
            ]);
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => fake()->unique()->email,
            'password' => 'password'
        ]);

        $response = $this->get('/api/login?email='.$user->email.'&password=wrong-password');

        $response->assertStatus(401)
            ->assertJson([
                'message' => 'Invalid credentials'
            ]);
    }
}