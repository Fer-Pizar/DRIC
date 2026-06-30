<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\AdminPermissionCatalog;
use App\Support\AdminRolePermissionSetup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $this->authorizeAdmin();

        $users = User::query()
            ->with('roles')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
            'roleLabels' => AdminPermissionCatalog::defaultRoles(),
        ]);
    }

    public function create(): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $this->authorizeAdmin();

        return view('admin.users.create', [
            'roles' => $this->roles(),
            'roleLabels' => AdminPermissionCatalog::defaultRoles(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions($request->user());
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ], $this->messages());

        $roles = $this->editableRoleNames($data['roles'] ?? []);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);

        $user->syncRoles($roles);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user): View
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions(auth()->user());
        $this->authorizeAdmin();

        $user->load('roles');

        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
            'roleLabels' => AdminPermissionCatalog::defaultRoles(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions($request->user());
        $this->authorizeAdmin();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'roles' => ['array'],
            'roles.*' => ['string', 'exists:roles,name'],
        ], $this->messages());

        $roles = $this->editableRoleNames($data['roles'] ?? []);

        if ($user->hasRole('Admin')) {
            $roles[] = 'Admin';
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        $user->syncRoles(array_unique($roles));

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        AdminRolePermissionSetup::ensureBaseRolesAndPermissions($request->user());
        $this->authorizeAdmin();

        if ($request->user()->is($user)) {
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'No puedes eliminar tu propio usuario administrador.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario eliminado correctamente.');
    }

    private function roles()
    {
        return Role::query()
            ->where('name', '!=', 'Admin')
            ->orderBy('name')
            ->get();
    }

    private function editableRoleNames(array $roles): array
    {
        return collect($roles)
            ->reject(fn (string $role) => $role === 'Admin')
            ->values()
            ->all();
    }

    private function authorizeAdmin(): void
    {
        abort_unless(auth()->user()?->hasRole('Admin'), 403, 'Solo el administrador puede gestionar usuarios.');
    }

    private function messages(): array
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de contraseña no coincide.',
        ];
    }
}
