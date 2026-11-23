<?php

namespace App\Support;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class AdminRolePermissionSetup
{
    public static function ensureBaseRolesAndPermissions(): void
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

            if ($role->wasRecentlyCreated) {
                $role->syncPermissions($roleData['permissions']);
            }
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
