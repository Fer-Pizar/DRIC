@php
    use Illuminate\Support\Facades\Storage;

    $user = auth()->user();
    $displayName = $user->name ?? $user->email;
    $roleLabel = $isAdmin ? 'Administrador' : 'Editor';
    $roleDescription = $isAdmin
        ? 'Acceso completo a paginas, usuarios, roles y permisos.'
        : 'Acceso limitado a las secciones asignadas por Direccion.';
    $photoUrl = ! $isAdmin && $user->profile_photo_path ? Storage::disk('public')->url($user->profile_photo_path) : null;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC</title>
    <style>
        :root {
            --blue: #164194;
            --blue-dark: #0f2f6f;
            --red: #b5121b;
            --ink: #172033;
            --muted: #647084;
            --line: #e2e8f0;
            --soft: #f5f7fb;
            --white: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 32px;
            background:
                radial-gradient(circle at top left, rgba(22, 65, 148, 0.16), transparent 34rem),
                radial-gradient(circle at bottom right, rgba(181, 18, 27, 0.09), transparent 30rem),
                linear-gradient(180deg, #f4f7fb 0%, #edf2f7 100%);
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .shell {
            max-width: 1180px;
            margin: 0 auto;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 360px;
            gap: 22px;
            align-items: stretch;
            margin-bottom: 22px;
        }

        .hero-main,
        .user-panel,
        .card,
        .permission-note {
            border: 1px solid rgba(22, 65, 148, 0.10);
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.90);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        .hero-main {
            padding: 34px;
        }

        .eyebrow {
            margin: 0 0 12px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.17em;
            text-transform: uppercase;
        }

        h1 {
            max-width: 720px;
            margin: 0;
            font-size: clamp(38px, 5vw, 64px);
            line-height: 0.95;
            letter-spacing: -0.05em;
        }

        .lead {
            max-width: 680px;
            margin: 18px 0 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.65;
        }

        .user-panel {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px;
        }

        .identity {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .avatar,
        .icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex: 0 0 auto;
        }

        .avatar {
            width: 58px;
            height: 58px;
            border-radius: 20px;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), #2d6cdf);
            box-shadow: 0 16px 30px rgba(22, 65, 148, 0.22);
            overflow: hidden;
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .identity h2 {
            margin: 0;
            font-size: 20px;
            line-height: 1.15;
        }

        .identity p,
        .role-box p,
        .permission-note p {
            margin: 6px 0 0;
            color: var(--muted);
            line-height: 1.5;
        }

        .role-box {
            margin-top: 22px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--soft);
        }

        .role-title {
            display: flex;
            gap: 10px;
            align-items: center;
            color: var(--blue-dark);
            font-weight: 900;
        }

        .logout {
            margin-top: 22px;
        }

        .panel-actions {
            display: grid;
            gap: 10px;
            margin-top: 22px;
        }

        .panel-actions .logout {
            margin-top: 0;
        }

        .profile-link {
            width: 100%;
            min-height: 46px;
            padding: 12px 16px;
            border: 1px solid rgba(22, 65, 148, 0.18);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            background: #eaf0ff;
            color: var(--blue-dark);
            text-decoration: none;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.2;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        button,
        .card {
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        button {
            width: 100%;
            min-height: 46px;
            padding: 12px 16px;
            border: 0;
            border-radius: 14px;
            background: var(--red);
            color: #fff;
            font-weight: 900;
            cursor: pointer;
        }

        .profile-link:hover,
        button:hover,
        .card:hover {
            transform: translateY(-2px);
        }

        .profile-link:hover {
            border-color: rgba(22, 65, 148, 0.34);
            box-shadow: 0 16px 30px rgba(22, 65, 148, 0.16);
        }

        button:hover {
            box-shadow: 0 16px 30px rgba(181, 18, 27, 0.20);
        }

        .section-title {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 18px;
            margin: 28px 0 16px;
        }

        .section-title h2 {
            margin: 0;
            color: var(--blue);
            font-size: 26px;
            letter-spacing: -0.03em;
        }

        .section-title p {
            margin: 6px 0 0;
            color: var(--muted);
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .card {
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            gap: 16px;
            align-items: start;
            min-height: 150px;
            padding: 22px;
            color: inherit;
            text-decoration: none;
        }

        .card:hover {
            border-color: rgba(22, 65, 148, 0.30);
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.11);
        }

        .icon {
            width: 48px;
            height: 48px;
            border-radius: 16px;
            background: #eaf0ff;
            color: var(--blue);
        }

        .icon.lock {
            background: #fff1f2;
            color: var(--red);
        }

        .icon.user {
            background: #ecfdf5;
            color: #047857;
        }

        .card strong {
            display: block;
            margin-bottom: 8px;
            color: var(--ink);
            font-size: 20px;
            letter-spacing: -0.02em;
        }

        .card span {
            color: var(--muted);
            line-height: 1.55;
        }

        .tag {
            display: inline-flex;
            width: fit-content;
            margin-top: 14px;
            padding: 7px 10px;
            border-radius: 999px;
            background: var(--soft);
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .permission-note {
            display: flex;
            gap: 14px;
            align-items: start;
            margin-top: 16px;
            padding: 18px;
        }

        svg {
            width: 22px;
            height: 22px;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        @media (max-width: 860px) {
            body {
                padding: 20px;
            }

            .hero,
            .grid {
                grid-template-columns: 1fr;
            }

            .hero-main,
            .user-panel {
                padding: 24px;
                border-radius: 22px;
            }
        }

        @media (max-width: 560px) {
            body {
                padding: 14px;
            }

            .card,
            .permission-note {
                grid-template-columns: 1fr;
            }

            .section-title {
                align-items: stretch;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="hero">
            <div class="hero-main">
                <p class="eyebrow">Panel DRIC</p>
                <h1>Centro administrativo</h1>
                <p class="lead">Gestiona el contenido publico del sitio y accede a las herramientas disponibles para tu rol.</p>
            </div>

            <aside class="user-panel" aria-label="Sesion y permisos">
                <div>
                    <div class="identity">
                        <span class="avatar" aria-hidden="true">
                            @if ($photoUrl)
                                <img src="{{ $photoUrl }}" alt="">
                            @else
                                <svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                            @endif
                        </span>
                        <div>
                            <h2>{{ $displayName }}</h2>
                            <p>{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="role-box">
                        <div class="role-title">
                            <span aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg></span>
                            {{ $roleLabel }}
                        </div>
                        <p>{{ $roleDescription }}</p>
                    </div>
                </div>

                <div class="panel-actions">
                    @unless ($isAdmin)
                        <a class="profile-link" href="{{ route('admin.profile.edit') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                            Perfil
                        </a>
                    @endunless

                    <form class="logout" method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit">Cerrar sesion</button>
                    </form>
                </div>
            </aside>
        </section>

        <div class="section-title">
            <div>
                <h2>Accesos principales</h2>
                <p>Entradas rapidas para editar contenido y administrar el panel.</p>
            </div>
        </div>

        <section class="grid">
            <a class="card" href="{{ route('admin.pages.index') }}">
                <span class="icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24"><path d="M4 5h16"/><path d="M4 12h16"/><path d="M4 19h16"/><path d="M7 5v14"/></svg>
                </span>
                <span>
                    <strong>Paginas</strong>
                    <span>Administrar paginas del sitio, editar contenido publico y revisar secciones visibles.</span>
                    <span class="tag">Contenido</span>
                </span>
            </a>

            @if ($isAdmin)
                <a class="card" href="{{ route('admin.roles.index') }}">
                    <span class="icon lock" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
                    </span>
                    <span>
                        <strong>Roles y permisos</strong>
                        <span>Definir que secciones puede editar cada rol y mantener el acceso ordenado.</span>
                        <span class="tag">Seguridad</span>
                    </span>
                </a>

                <a class="card" href="{{ route('admin.permissions.index') }}">
                    <span class="icon lock" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M12 3l7 4v5c0 5-3.5 8-7 9-3.5-1-7-4-7-9V7l7-4z"/><path d="M9.5 12l1.8 1.8L15 10"/></svg>
                    </span>
                    <span>
                        <strong>Permisos</strong>
                        <span>Crear permisos personalizados para roles especiales sin mezclar responsabilidades.</span>
                        <span class="tag">Control</span>
                    </span>
                </a>

                <a class="card" href="{{ route('admin.users.index') }}">
                    <span class="icon user" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </span>
                    <span>
                        <strong>Usuarios</strong>
                        <span>Crear editores, asignarles roles y mantener la administracion del equipo.</span>
                        <span class="tag">Equipo</span>
                    </span>
                </a>
            @endif
        </section>

        <section class="permission-note">
            <span class="icon lock" aria-hidden="true">
                <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
            </span>
            <div>
                <strong>Permisos activos</strong>
                <p>El panel solo muestra las herramientas permitidas para tu rol. Si necesitas otra seccion, Direccion puede habilitarla desde roles y permisos.</p>
            </div>
        </section>
    </main>
</body>
</html>
