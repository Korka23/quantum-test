<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class RegisterUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_register_with_valid_data()
    {
        $mail = fake()->unique()->email;
        $response = $this->postJson('/api/register', [
            'name' => fake()->name,
            'email' => $mail,
            'password' => 'password'
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $mail
        ]);
    }

    public function test_user_cannot_register_with_invalid_data()
    {
        $response = $this->postJson('/api/register', [
            'name' => '',
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
    }
}
