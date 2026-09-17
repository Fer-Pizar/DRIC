<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Usuarios</title>
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
        th, td { padding: 12px; border-bottom: 1px solid #e5e7eb; text-align: left; }
        th { background: #f3f4f6; }
        .muted { color: #6b7280; }
        .pagination { margin-top: 24px; }
        .header-actions { display: flex; gap: 10px; }
        .row-actions { display: flex; gap: 8px; align-items: center; }
        .row-actions form { margin: 0; }
        .table-wrap { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
        @media (max-width: 640px) {
            body { padding: 16px; }
            .container { padding: 18px; border-radius: 10px; }
            .header { align-items: stretch; flex-direction: column; }
            .header-actions { flex-direction: column; }
            h1 { font-size: 28px; line-height: 1.15; }
            .btn { box-sizing: border-box; text-align: center; width: 100%; }
            table { min-width: 800px; }
            th, td { padding: 10px; white-space: nowrap; }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <h1>Usuarios</h1>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Crear usuario</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo electrónico</th>
                        <th>Roles</th>
                        <th>Creado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @forelse ($user->roles as $role)
                                    {{ $roleLabels[$role->name]['label'] ?? $role->name }}{{ $loop->last ? '' : ', ' }}
                                @empty
                                    Sin rol
                                @endforelse
                            </td>
                            <td class="muted">{{ $user->created_at?->format('Y-m-d H:i') }}</td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn-edit">Editar</a>
                                    @if (! auth()->user()->is($user))
                                        <form
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-danger">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">{{ $users->links('admin.partials.pagination') }}</div>
    </main>
</body>
</html>
