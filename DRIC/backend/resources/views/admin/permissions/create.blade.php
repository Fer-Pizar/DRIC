<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Crear permiso</title>
    <style>
        :root { --blue:#164194; --blue-dark:#0f2f6f; --red:#b5121b; --ink:#172033; --muted:#647084; --line:#d8e0ec; --soft:#f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; padding: 40px; background: linear-gradient(180deg, #f4f7fb 0%, #edf2f7 100%); color: var(--ink); font-family: Arial, sans-serif; }
        .container { max-width: 820px; margin: 0 auto; background: rgba(255,255,255,.94); padding: 28px; border: 1px solid rgba(22,65,148,.1); border-radius: 22px; box-shadow: 0 20px 60px rgba(15,23,42,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; padding-bottom: 18px; border-bottom: 1px solid #e7edf5; }
        h1 { margin: 0; color: var(--blue); font-size: 34px; letter-spacing: -.03em; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 46px; padding: 12px 18px; border-radius: 14px; text-decoration: none; font-weight: 900; border: 0; cursor: pointer; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #eaf0ff; color: var(--blue-dark); }
        form { display: grid; gap: 18px; }
        .field-card { border: 1px solid var(--line); border-radius: 18px; background: var(--soft); padding: 16px; }
        .field { display: grid; gap: 8px; }
        .field label { color: var(--blue-dark); font-size: 13px; font-weight: 900; }
        input { width: 100%; min-height: 48px; padding: 12px 14px; border: 1px solid var(--line); border-radius: 14px; color: var(--ink); font: inherit; }
        .muted { color: var(--muted); line-height: 1.5; margin: 0; }
        .error { color: var(--red); font-size: 13px; font-weight: 800; }
        .actions { display: flex; justify-content: flex-end; gap: 10px; }
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

            <div class="field-card">
                <div class="field">
                    <label for="name"><strong>Nombre interno del permiso</strong></label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Ejemplo: editar.contenido_especial">
                    <p class="muted">Usa minúsculas, números, punto, guion o guion bajo. Este nombre se asignará después a roles.</p>
                    @error('name') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="actions">
                <button type="submit" class="btn btn-primary">Guardar permiso</button>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </main>
</body>
</html>
