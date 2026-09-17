<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminPermissionCatalog;
use App\Support\AdminRolePermissionSetup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    public function index(): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $this->authorizeAdmin();

        $roles = Role::query()
            ->withCount('users')
            ->with('permissions')
            ->orderBy('name')
            ->get();

        return view('admin.roles.index', [
            'roles' => $roles,
            'roleLabels' => AdminPermissionCatalog::defaultRoles(),
            'permissionLabels' => $this->permissionLabels(),
        ]);
    }

    public function create(): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $this->authorizeAdmin();

        return view('admin.roles.create', [
            'permissions' => $this->groupedPermissions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions($request->user());
        $this->authorizeAdmin();

        $allowedPermissions = array_keys($this->permissionLabels());

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9_ -]+$/',
                Rule::unique('roles', 'name')->where('guard_name', 'web'),
            ],
            'permissions' => ['array'],
            'permissions.*' => ['string', 'in:'.implode(',', $allowedPermissions)],
        ], $this->messages());

        $role = Role::create([
            'name' => trim($data['name']),
            'guard_name' => 'web',
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol creado correctamente.');
    }

    public function edit(Role $role): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $this->authorizeAdmin();
        $this->guardAdminRole($role);

        $role->load('permissions');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $this->groupedPermissions(),
            'roleLabels' => AdminPermissionCatalog::defaultRoles(),
        ]);
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions($request->user());
        $this->authorizeAdmin();
        $this->guardAdminRole($role);

        $allowedPermissions = array_keys($this->permissionLabels());

        $data = $request->validate([
            'permissions' => ['array'],
            'permissions.*' => ['string', 'in:'.implode(',', $allowedPermissions)],
        ]);

        $role->syncPermissions($data['permissions'] ?? []);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Permisos actualizados correctamente.');
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions($request->user());
        $this->authorizeAdmin();

        if ($role->name === 'Admin') {
            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'El rol Admin no se puede eliminar.');
        }

        if ($role->users()->exists()) {
            return redirect()
                ->route('admin.roles.index')
                ->with('success', 'No se puede eliminar un rol asignado a usuarios.');
        }

        $role->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Rol eliminado correctamente.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->hasRole('Admin'), 403, 'Solo el administrador puede gestionar roles y permisos.');
    }

    private function guardAdminRole(Role $role): void
    {
        abort_if($role->name === 'Admin', 403, 'El rol Admin pertenece únicamente a Dirección y no se puede modificar.');
    }

    private function groupedPermissions(): array
    {
        $groups = AdminPermissionCatalog::permissions();
        $catalogPermissions = array_keys(AdminPermissionCatalog::flatPermissions());

        $customPermissions = Permission::query()
            ->whereNotIn('name', $catalogPermissions)
            ->orderBy('name')
            ->pluck('name', 'name')
            ->all();

        if ($customPermissions) {
            $groups['custom'] = [
                'label' => 'Permisos personalizados',
                'items' => $customPermissions,
            ];
        }

        return $groups;
    }

    private function permissionLabels(): array
    {
        return Permission::query()
            ->orderBy('name')
            ->pluck('name', 'name')
            ->merge(AdminPermissionCatalog::flatPermissions())
            ->all();
    }

    private function messages(): array
    {
        return [
            'name.required' => 'El nombre del rol es obligatorio.',
            'name.regex' => 'Usa letras, números, espacios, guion o guion bajo.',
            'name.unique' => 'Este rol ya existe.',
        ];
    }
}
