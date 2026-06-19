<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    public function test_guest_is_redirected_from_the_admin_dashboard(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_merchant_cannot_access_the_admin_dashboard(): void
    {
        $merchant = User::factory()->create();
        $merchant->assignRole(UserRole::Merchant);

        $this->actingAs($merchant)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_access_the_admin_dashboard(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(UserRole::Admin);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_compliance_user_can_access_the_admin_dashboard(): void
    {
        $complianceUser = User::factory()->create();
        $complianceUser->assignRole(UserRole::Compliance);

        $this->actingAs($complianceUser)->get('/admin')->assertOk();
    }
}
