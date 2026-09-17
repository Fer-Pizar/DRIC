<?php

namespace App\Support;

use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminRolePermissionSetup
{
    public static function ensureBaseRolesAndPermissions(?User $currentUser = null): void
    {
        foreach (AdminPermissionCatalog::flatPermissions() as $permissionName => $label) {
            Permission::firstOrCreate([
                'name' => $permissionName,
                'guard_name' => 'web',
            ]);
        }

        foreach (AdminPermissionCatalog::defaultRoles() as $roleName => $roleData) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            if ($role->permissions()->count() === 0) {
                $role->syncPermissions($roleData['permissions']);
            }
        }

        if ($currentUser && Role::where('name', 'Admin')->first()?->users()->count() === 0) {
            $currentUser->assignRole('Admin');
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
