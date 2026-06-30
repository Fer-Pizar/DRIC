<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Crear permiso</title>
    <style>
        body { margin: 0; padding: 40px; background: #f7f7f7; color: #222; font-family: Arial, sans-serif; }
        .container { max-width: 720px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; }
        h1 { margin: 0; }
        .btn { display: inline-block; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; border: 0; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-secondary { background: #6b7280; color: #fff; }
        .field { display: grid; gap: 8px; margin-bottom: 18px; }
        input { box-sizing: border-box; width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 8px; }
        .muted { color: #6b7280; line-height: 1.5; }
        .error { color: #dc2626; }
        .actions { display: flex; gap: 10px; }
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
            <h1>Crear permiso</h1>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="name"><strong>Nombre interno del permiso</strong></label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Ejemplo: editar.contenido_especial">
                <p class="muted">Usa minúsculas, números, punto, guion o guion bajo. Este nombre se asignará después a roles.</p>
                @error('name') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Guardar permiso</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
