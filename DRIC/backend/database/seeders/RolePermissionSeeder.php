<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\AdminPermissionCatalog;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = array_keys(AdminPermissionCatalog::flatPermissions());

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        foreach (AdminPermissionCatalog::defaultRoles() as $roleName => $roleData) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($roleData['permissions']);
        }

        $adminEmail = env('DRIC_ADMIN_EMAIL');

        if ($adminEmail) {
            User::where('email', $adminEmail)->first()?->assignRole($admin);
            return;
        }

        if (User::count() === 1) {
            User::first()?->assignRole($admin);
        }
    }
}
