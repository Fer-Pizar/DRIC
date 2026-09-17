<div style="display:grid; gap:18px;">
    <div>
        <label for="name" style="display:block; margin-bottom:6px; font-weight:bold;">Nombre</label>
        <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
        @error('name') <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="email" style="display:block; margin-bottom:6px; font-weight:bold;">Correo electrónico</label>
        <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
        @error('email') <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="password" style="display:block; margin-bottom:6px; font-weight:bold;">Contraseña</label>
        <input id="password" name="password" type="password" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
        @isset($user)
            <p style="margin:6px 0 0; color:#6b7280;">Déjalo vacío si no quieres cambiar la contraseña.</p>
        @endisset
        @error('password') <div style="color:#dc2626; margin-top:6px;">{{ $message }}</div> @enderror
    </div>

    <div>
        <label for="password_confirmation" style="display:block; margin-bottom:6px; font-weight:bold;">Confirmar contraseña</label>
        <input id="password_confirmation" name="password_confirmation" type="password" style="width:100%; padding:10px; border:1px solid #d1d5db; border-radius:8px;">
    </div>

    <div>
        <strong style="display:block; margin-bottom:10px;">Roles</strong>
        <p style="margin:0 0 10px; color:#6b7280;">Solo se pueden asignar roles de editor. El rol Admin pertenece únicamente a Dirección.</p>
        <div style="display:grid; gap:10px;">
            @foreach ($roles as $role)
                <label style="display:flex; gap:10px; align-items:center; padding:12px; border:1px solid #e5e7eb; border-radius:10px;">
                    <input
                        type="checkbox"
                        name="roles[]"
                        value="{{ $role->name }}"
                        {{ in_array($role->name, old('roles', isset($user) ? $user->roles->pluck('name')->all() : []), true) ? 'checked' : '' }}
                    >
                    <span>{{ $roleLabels[$role->name]['label'] ?? $role->name }}</span>
                </label>
            @endforeach
        </div>
    </div>
</div>
