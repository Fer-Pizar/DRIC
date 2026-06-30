<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC</title>
    <style>
        body {
            margin: 0;
            padding: 40px;
            background: #f7f7f7;
            color: #222;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        h1 {
            margin: 0;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
        }

        .card {
            display: block;
            padding: 18px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            color: inherit;
            text-decoration: none;
        }

        .card strong {
            display: block;
            margin-bottom: 6px;
            color: #164194;
        }

        .muted {
            color: #6b7280;
        }

        button {
            padding: 10px 14px;
            border: 0;
            border-radius: 8px;
            background: #b5121b;
            color: #fff;
            font-weight: 700;
            cursor: pointer;
        }

        @media (max-width: 640px) {
            body {
                padding: 16px;
            }

            .container {
                padding: 18px;
                border-radius: 10px;
            }

            .header {
                align-items: stretch;
                flex-direction: column;
            }

            h1 {
                font-size: 28px;
                line-height: 1.15;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="container">
        <div class="header">
            <div>
                <h1>Panel administrativo</h1>
                <p class="muted">Bienvenido, {{ auth()->user()->name ?? auth()->user()->email }}.</p>
                <p class="muted">Rol: {{ $isAdmin ? 'Admin' : 'Editor' }}</p>
            </div>

            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit">Cerrar sesión</button>
            </form>
        </div>

        <section class="grid">
            <a class="card" href="{{ route('admin.pages.index') }}">
                <strong>Páginas</strong>
                <span class="muted">Administrar páginas del sitio.</span>
            </a>
            @if ($isAdmin)
                <a class="card" href="{{ route('admin.roles.index') }}">
                    <strong>Roles y permisos</strong>
                    <span class="muted">Definir qué pestañas puede editar cada rol.</span>
                </a>
                <a class="card" href="{{ route('admin.permissions.index') }}">
                    <strong>Permisos</strong>
                    <span class="muted">Crear permisos personalizados para roles especiales.</span>
                </a>
                <a class="card" href="{{ route('admin.users.index') }}">
                    <strong>Usuarios</strong>
                    <span class="muted">Crear editores y asignarles roles.</span>
                </a>
            @endif
        </section>
    </main>
</body>
</html>
