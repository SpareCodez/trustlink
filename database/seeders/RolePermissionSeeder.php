<?php

namespace Database\Seeders;

use App\Enums\UserPermission;
use App\Enums\UserRole;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach (UserPermission::cases() as $permission) {
            Permission::findOrCreate($permission->value);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissionsByRole = [
            UserRole::Admin->value => UserPermission::cases(),
            UserRole::Compliance->value => [
                UserPermission::AccessAdmin,
                UserPermission::ViewTransactions,
                UserPermission::ViewMerchants,
                UserPermission::ReviewKyc,
            ],
            UserRole::Support->value => [
                UserPermission::AccessAdmin,
                UserPermission::ViewTransactions,
                UserPermission::ViewMerchants,
                UserPermission::ManageDisputes,
            ],
            UserRole::Merchant->value => [
                UserPermission::AccessMerchantDashboard,
                UserPermission::CreateEscrowLinks,
            ],
        ];

        foreach ($permissionsByRole as $roleName => $permissions) {
            Role::findOrCreate($roleName)->syncPermissions(
                array_map(fn (UserPermission $permission) => $permission->value, $permissions),
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
