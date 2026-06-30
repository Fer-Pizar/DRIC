<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Permisos</title>
    <style>
        body { margin: 0; padding: 40px; background: #f7f7f7; color: #222; font-family: Arial, sans-serif; }
        .container { max-width: 1000px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; }
        h1 { margin: 0; }
        .btn { display: inline-block; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; border: 0; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-secondary { background: #6b7280; color: #fff; }
        .btn-danger { background: #b5121b; color: #fff; padding: 8px 12px; border-radius: 6px; font-weight: 700; border: 0; cursor: pointer; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; background: #dcfce7; color: #166534; }
        .notice { padding: 14px 16px; border-radius: 10px; margin-bottom: 20px; background: #eff6ff; color: #164194; line-height: 1.5; }
        .header-actions { display: flex; gap: 10px; }
        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; vertical-align: middle; }
        th { background: #f3f4f6; }
        .muted { color: #6b7280; }
        form { margin: 0; }
        @media (max-width: 640px) {
            body { padding: 16px; }
            .container { padding: 18px; border-radius: 10px; }
            .header { align-items: stretch; flex-direction: column; }
            .header-actions { flex-direction: column; }
            h1 { font-size: 28px; line-height: 1.15; }
            .btn { box-sizing: border-box; text-align: center; width: 100%; }
            table { min-width: 720px; }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <h1>Permisos</h1>
            <div class="header-actions">
                <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Volver a roles</a>
                <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary">Crear permiso</a>
            </div>
        </div>

        <div class="notice">
            Los permisos del sistema no se eliminan porque el panel los usa. Se puede crear permisos personalizados y asignarlos a roles especiales.
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Permiso</th>
                        <th>Nombre interno</th>
                        <th>Tipo</th>
                        <th>Roles vinculados</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        @php
                            $isSystem = in_array($permission->name, $systemPermissions, true);
                        @endphp
                        <tr>
                            <td><strong>{{ $permissionLabels[$permission->name] ?? $permission->name }}</strong></td>
                            <td class="muted">{{ $permission->name }}</td>
                            <td>{{ $isSystem ? 'Sistema' : 'Personalizado' }}</td>
                            <td>{{ $permission->roles_count }}</td>
                            <td>
                                @if (! $isSystem)
                                    <form
                                        action="{{ route('admin.permissions.destroy', $permission) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este permiso?');"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-danger">Eliminar</button>
                                    </form>
                                @else
                                    <span class="muted">Protegido</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
