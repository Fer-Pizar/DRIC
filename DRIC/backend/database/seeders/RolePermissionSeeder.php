<?php

namespace Database\Seeders;

use App\Models\User;
use App\Support\AdminRolePermissionSetup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function (): void {
            AdminRolePermissionSetup::ensureBaseRolesAndPermissions();

            $adminEmail = config('dric.admin.email');
            if ($adminEmail) {
                User::where('email', $adminEmail)->first()?->assignRole('Admin');
            }
        });
    }
}
