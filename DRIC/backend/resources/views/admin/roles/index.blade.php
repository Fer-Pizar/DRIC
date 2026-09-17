<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Roles y permisos</title>
    <style>
        body { margin: 0; padding: 40px; background: #f7f7f7; color: #222; font-family: Arial, sans-serif; }
        .container { max-width: 1100px; margin: 0 auto; background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,.08); }
        .header { display: flex; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px; }
        h1 { margin: 0; }
        .btn { display: inline-block; padding: 10px 16px; border-radius: 8px; text-decoration: none; font-weight: bold; border: 0; cursor: pointer; }
        .btn-primary { background: #2563eb; color: #fff; }
        .btn-secondary { background: #6b7280; color: #fff; }
        .btn-edit { background: #f59e0b; color: #fff; padding: 8px 12px; border-radius: 6px; text-decoration: none; }
        .btn-danger { background: #b5121b; color: #fff; padding: 8px 12px; border-radius: 6px; font-weight: 700; border: 0; cursor: pointer; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; background: #dcfce7; color: #166534; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; vertical-align: top; }
        th { background: #f3f4f6; }
        .muted { color: #6b7280; }
        .chips { display: flex; flex-wrap: wrap; gap: 6px; }
        .chip { padding: 4px 8px; border-radius: 999px; background: #eef2ff; color: #164194; font-size: 12px; font-weight: 700; }
        .header-actions { display: flex; gap: 10px; }
        .row-actions { display: flex; gap: 8px; align-items: center; }
        .row-actions form { margin: 0; }
        .notice { padding: 14px 16px; border-radius: 10px; margin-bottom: 20px; background: #eff6ff; color: #164194; line-height: 1.5; }
        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        @media (max-width: 640px) {
            body { padding: 16px; }
            .container { padding: 18px; border-radius: 10px; }
            .header { align-items: stretch; flex-direction: column; }
            .header-actions { flex-direction: column; }
            h1 { font-size: 28px; line-height: 1.15; }
            .btn { box-sizing: border-box; text-align: center; width: 100%; }
            table { min-width: 960px; }
            th, td { padding: 10px; }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <h1>Roles y permisos</h1>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
                <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Ver permisos</a>
                <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">Crear rol</a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Crear usuario</a>
            </div>
        </div>

        <div class="notice">
            Los roles agrupan permisos. Puedes crear roles especiales, asignarles permisos y luego registrar usuarios desde <strong>Usuarios</strong>. El rol Admin no se puede eliminar.
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Descripción</th>
                        <th>Usuarios</th>
                        <th>Permisos activos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        @php
                            $roleData = $roleLabels[$role->name] ?? null;
                        @endphp
                        <tr>
                            <td><strong>{{ $roleData['label'] ?? $role->name }}</strong></td>
                            <td class="muted">{{ $roleData['description'] ?? 'Rol personalizado.' }}</td>
                            <td>{{ $role->users_count }}</td>
                            <td>
                                <div class="chips">
                                    @foreach ($role->permissions as $permission)
                                        <span class="chip">{{ $permissionLabels[$permission->name] ?? $permission->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="row-actions">
                                    @if ($role->name !== 'Admin')
                                        <a href="{{ route('admin.roles.edit', $role) }}" class="btn-edit">Editar</a>
                                    @endif
                                    @if ($role->name !== 'Admin' && $role->users_count === 0)
                                        <form
                                            action="{{ route('admin.roles.destroy', $role) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este rol?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger">Eliminar</button>
                                        </form>
                                    @elseif ($role->name === 'Admin')
                                        <span class="muted">Protegido</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
