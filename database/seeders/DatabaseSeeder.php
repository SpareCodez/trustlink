<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public const ADMIN_EMAIL = 'admin@example.com';

    public const ADMIN_PASSWORD = 'TrustLinkAdmin123!';

    public const MERCHANT_EMAIL = 'test@example.com';

    public const MERCHANT_PASSWORD = 'TrustLinkMerchant123!';

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        $admin = User::query()->updateOrCreate([
            'email' => self::ADMIN_EMAIL,
        ], [
            'name' => 'TrustLink Admin',
            'phone_number' => '+233200000001',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => Hash::make(self::ADMIN_PASSWORD),
        ]);
        $admin->syncRoles([UserRole::Admin]);

        $merchant = User::query()->updateOrCreate([
            'email' => self::MERCHANT_EMAIL,
        ], [
            'name' => 'Test Merchant',
            'phone_number' => '+233200000002',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => Hash::make(self::MERCHANT_PASSWORD),
        ]);
        $merchant->syncRoles([UserRole::Merchant]);
    }
}
