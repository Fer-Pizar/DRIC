<div class="user-form-card">
    <section class="form-section" aria-labelledby="user-basic-title">
        <div class="section-head">
            <h2 id="user-basic-title">Información básica</h2>
            <p class="hint">Datos principales para identificar al usuario dentro del panel.</p>
        </div>

        <div class="section-grid">
        <div class="field">
            <label for="name">Nombre</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}">
            @error('name') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}">
            @error('email') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        </div>
    </section>

    <section class="form-section" aria-labelledby="user-security-title">
        <div class="section-head">
            <h2 id="user-security-title">Seguridad</h2>
            @isset($user)
                <p class="hint">Déjalo vacío si no quieres cambiar la contraseña.</p>
            @else
                <p class="hint">La contraseña debe tener al menos 8 caracteres y confirmarse correctamente.</p>
            @endisset
        </div>

        <div class="section-grid">
        <div class="field">
            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password">
            @error('password') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="field">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" name="password_confirmation" type="password">
        </div>
        </div>
    </section>

    @unless (isset($user) && (int) $user->id === 1)
        <section class="form-section roles-section" aria-labelledby="roles-title">
            <div class="section-head">
                <strong id="roles-title" class="roles-title">Roles</strong>
                <p class="hint">Solo se pueden asignar roles de editor. El rol Admin pertenece únicamente a Dirección.</p>
            </div>

            <div class="roles-list">
                @foreach ($roles as $role)
                    <label class="role-option">
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
        </section>
    @endunless
</div>
