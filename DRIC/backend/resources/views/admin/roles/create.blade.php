<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Crear rol</title>
    <style>
        body { margin: 0; padding: 40px; background: #f7f7f7; color: #222; font-family: Arial, sans-serif; }
        .container { max-width: 900px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; }
        h1, h2 { margin: 0; }
        h2 { margin-top: 24px; padding-top: 18px; border-top: 1px solid #e5e7eb; font-size: 18px; }
        .btn { display: inline-block; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; border: 0; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-secondary { background: #6b7280; color: #fff; }
        .muted { color: #6b7280; }
        .field { display: grid; gap: 8px; margin-bottom: 18px; }
        input[type="text"] { box-sizing: border-box; width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; }
        .grid { display: grid; gap: 12px; margin-top: 14px; }
        label.permission { display: flex; gap: 10px; align-items: flex-start; padding: 12px; border: 1px solid #e5e7eb; border-radius: 10px; }
        .error { color: #dc2626; }
        .actions { margin-top: 24px; display: flex; gap: 10px; }
        @media (max-width: 640px) {
            body { padding: 16px; }
            .container { padding: 18px; border-radius: 10px; }
            .header { align-items: stretch; flex-direction: column; }
            h1 { font-size: 28px; line-height: 1.15; }
            .actions { flex-direction: column; }
            .btn { box-sizing: border-box; text-align: center; width: 100%; }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <div>
                <h1>Crear rol</h1>
                <p class="muted">Define un nuevo perfil y sus permisos.</p>
            </div>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="name"><strong>Nombre del rol</strong></label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Ejemplo: Editor Proyectos Especiales">
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            @foreach ($permissions as $group)
                <h2>{{ $group['label'] }}</h2>
                <div class="grid">
                    @foreach ($group['items'] as $permission => $label)
                        <label class="permission">
                            <input
                                type="checkbox"
                                name="permissions[]"
                                value="{{ $permission }}"
                                {{ in_array($permission, old('permissions', []), true) ? 'checked' : '' }}
                            >
                            <span>{{ $label }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach

            <div class="actions">
                <button type="submit" class="btn btn-primary">Guardar rol</button>
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
