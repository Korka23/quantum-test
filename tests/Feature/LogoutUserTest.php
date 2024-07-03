<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class LogoutUserTest extends TestCase
{
    use DatabaseTransactions;

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->get('/api/logout');

        $response->assertStatus(204);
    }

    public function test_guest_cannot_logout()
    {
        $response = $this->getJson('/api/logout');

        $response->assertStatus(401);
    }
}