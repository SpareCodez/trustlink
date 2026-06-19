<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_merchant_dashboard_displays_a_logout_action(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get('/home')
            ->assertOk()
            ->assertSee('aria-label="Sign out"', false);
    }

    public function test_authenticated_user_can_log_out(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }
}
