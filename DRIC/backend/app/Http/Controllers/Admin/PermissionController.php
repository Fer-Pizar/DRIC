<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminPermissionCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionController extends Controller
{
    public function index(): View
    {
        $this->authorizeAdmin();

        $systemPermissions = array_keys(AdminPermissionCatalog::flatPermissions());

        $permissions = Permission::query()
            ->withCount('roles')
            ->orderBy('name')
            ->get();

        return view('admin.permissions.index', [
            'permissions' => $permissions,
            'permissionLabels' => AdminPermissionCatalog::flatPermissions(),
            'systemPermissions' => $systemPermissions,
        ]);
    }

    public function create(): View
    {
        $this->authorizeAdmin();

        return view('admin.permissions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-z0-9_.-]+$/',
                Rule::unique('permissions', 'name')->where('guard_name', 'web'),
            ],
        ], $this->messages());

        Permission::create([
            'name' => $data['name'],
            'guard_name' => 'web',
        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permiso creado correctamente.');
    }

    public function destroy(Request $request, Permission $permission): RedirectResponse
    {
        $this->authorizeAdmin();

        if (array_key_exists($permission->name, AdminPermissionCatalog::flatPermissions())) {
            return redirect()
                ->route('admin.permissions.index')
                ->with('success', 'Los permisos del sistema no se pueden eliminar.');
        }

        $permission->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();

        return redirect()
            ->route('admin.permissions.index')
            ->with('success', 'Permiso eliminado correctamente.');
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->hasRole('Admin'), 403, 'Solo el administrador puede gestionar permisos.');
    }

    private function messages(): array
    {
        return [
            'name.required' => 'El nombre del permiso es obligatorio.',
            'name.regex' => 'Usa solo minúsculas, números, punto, guion o guion bajo. Ejemplo: editar.contenido_especial.',
            'name.unique' => 'Este permiso ya existe.',
        ];
    }
}
