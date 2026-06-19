<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_local_test_accounts_have_known_credentials_and_roles(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('email', DatabaseSeeder::ADMIN_EMAIL)->firstOrFail();
        $merchant = User::where('email', DatabaseSeeder::MERCHANT_EMAIL)->firstOrFail();

        $this->assertTrue(Hash::check(DatabaseSeeder::ADMIN_PASSWORD, $admin->password));
        $this->assertTrue($admin->hasRole(UserRole::Admin));
        $this->assertTrue(Hash::check(DatabaseSeeder::MERCHANT_PASSWORD, $merchant->password));
        $this->assertTrue($merchant->hasRole(UserRole::Merchant));

        $this->post('/login', [
            'email' => DatabaseSeeder::ADMIN_EMAIL,
            'password' => DatabaseSeeder::ADMIN_PASSWORD,
        ])->assertRedirect('/admin');

        $this->assertAuthenticatedAs($admin);
    }

    public function test_seeder_can_be_run_repeatedly_without_duplicate_accounts(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertSame(1, User::where('email', DatabaseSeeder::ADMIN_EMAIL)->count());
        $this->assertSame(1, User::where('email', DatabaseSeeder::MERCHANT_EMAIL)->count());
    }
}
