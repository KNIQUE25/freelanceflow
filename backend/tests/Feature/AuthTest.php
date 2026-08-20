<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_and_access_current_user(): void
    {
        $this->postJson('/api/register', [
            'name' => 'Jane Freelancer',
            'email' => 'jane@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertCreated()->assertJsonPath('user.email', 'jane@example.com');

        $this->getJson('/api/user')->assertOk()->assertJsonPath('user.email', 'jane@example.com');
    }

    public function test_user_can_login_and_logout(): void
    {
        $user = User::factory()->create(['password' => 'password123']);
        $this->postJson('/api/login', ['email' => $user->email, 'password' => 'password123'])->assertOk();
        $this->getJson('/api/user')->assertOk();
        $this->postJson('/api/logout')->assertOk();
    }
}
