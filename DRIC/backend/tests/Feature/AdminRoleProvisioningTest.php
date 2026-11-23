<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminRoleProvisioningTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:']);
        $this->artisan('migrate', ['--path' => [
            'database/migrations/0001_01_01_000000_create_users_table.php',
            'database/migrations/2026_03_03_193129_create_permission_tables.php',
            'database/migrations/2026_09_23_000000_create_site_settings_table.php',
        ]])->assertSuccessful();
    }

    public function test_editor_keeps_only_assigned_access_after_last_admin_leaves(): void
    {
        $admin = User::factory()->create();
        config(['dric.admin.email' => $admin->email]);
        $this->seed(RolePermissionSeeder::class);
        $this->actingAs($admin)->get(route('admin.users.index'))->assertOk();

        $editor = User::factory()->create();
        $role = Role::findByName('Editor_Convenios');
        $this->assertTrue($role->hasPermissionTo('editar.convenios'));
        $editor->assignRole($role);
        $role->syncPermissions([]);
        $admin->delete();

        $this->actingAs($editor)->get(route('admin.dashboard'))->assertOk();
        foreach (['users', 'roles', 'permissions'] as $section) {
            $this->get(route("admin.{$section}.index"))->assertForbidden();
        }
        $this->assertFalse($editor->fresh()->hasRole('Admin'));
        $this->assertSame(0, $role->permissions()->count());

        config(['dric.admin.email' => null]);
        $this->seed(RolePermissionSeeder::class);
        $this->assertFalse($editor->fresh()->hasRole('Admin'));
        $this->assertSame(0, $role->permissions()->count());
    }
}
