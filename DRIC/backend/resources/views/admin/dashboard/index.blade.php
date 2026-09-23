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
        .permission-note,
        .logo-settings {
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

        .logo-settings,
        .footer-settings {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            gap: 22px;
            align-items: start;
            margin-top: 16px;
            padding: 24px;
        }

        .footer-settings {
            grid-template-columns: minmax(0, .7fr) minmax(0, 1.3fr);
        }

        .logo-settings h3,
        .footer-settings h3 {
            margin: 0;
            color: var(--ink);
            font-size: 22px;
            letter-spacing: -0.02em;
        }

        .logo-settings p,
        .footer-settings p {
            margin: 8px 0 0;
            color: var(--muted);
            line-height: 1.55;
        }

        .logo-form {
            display: grid;
            gap: 12px;
            margin-top: 18px;
        }

        .logo-form label {
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .logo-form input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fff;
            color: var(--ink);
        }

        .image-card {
            background: var(--soft);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 16px;
            position: relative;
        }

        .preview {
            align-items: center;
            background: #111827;
            border: 1px solid #d6deeb;
            border-radius: 18px;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .08);
            cursor: pointer;
            display: flex;
            justify-content: center;
            margin-bottom: 14px;
            min-height: 170px;
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .preview-logo {
            aspect-ratio: 3 / 2;
            max-height: 260px;
        }

        .preview img {
            height: 100%;
            object-fit: contain;
            padding: 28px;
            width: 100%;
        }

        .preview-ruler {
            align-items: center;
            background: rgba(2, 6, 23, .76);
            border: 1px solid rgba(255, 255, 255, .16);
            border-radius: 999px;
            color: #fff;
            display: inline-flex;
            font-size: 11px;
            font-weight: 900;
            gap: 6px;
            left: 12px;
            line-height: 1;
            padding: 7px 10px;
            position: absolute;
            top: 12px;
        }

        .preview-ruler::before {
            content: "";
            background: repeating-linear-gradient(90deg, #fff 0 1px, transparent 1px 7px);
            display: block;
            height: 10px;
            opacity: .82;
            width: 38px;
        }

        .btn-image-remove {
            align-items: center;
            background: rgba(127, 0, 16, .92);
            border: 2px solid rgba(255, 255, 255, .88);
            border-radius: 999px;
            color: #fff;
            display: inline-flex;
            font-size: 22px;
            font-weight: 900;
            height: 34px;
            justify-content: center;
            line-height: 1;
            min-height: 34px;
            padding: 0;
            position: absolute;
            right: 12px;
            top: 12px;
            width: 34px;
            z-index: 2;
        }

        .preview-empty {
            color: rgba(255, 255, 255, .72);
            padding: 18px;
            text-align: center;
        }

        .hint {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            line-height: 1.45;
        }

        .field-error,
        .live-error {
            color: #7f0010;
            font-size: 12px;
            font-weight: 800;
            line-height: 1.45;
        }

        .live-error:empty {
            display: none;
        }

        .is-invalid {
            border-color: #7f0010 !important;
            box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10);
        }

        .settings-form {
            display: grid;
            gap: 18px;
        }

        .settings-group {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: var(--soft);
            padding: 18px;
        }

        .settings-group-title {
            margin: 0 0 14px;
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .settings-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .settings-grid .span-2 {
            grid-column: 1 / -1;
        }

        .settings-form label {
            display: grid;
            gap: 7px;
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 900;
        }

        .settings-form input[type="text"],
        .settings-form input[type="url"] {
            width: 100%;
            border: 1px solid #cfd6e3;
            border-radius: 12px;
            color: var(--ink);
            font: inherit;
            font-weight: 500;
            padding: 12px 13px;
        }

        .footer-preview {
            border: 1px solid rgba(22, 65, 148, .14);
            border-radius: 18px;
            background: #001935;
            color: #fff;
            overflow: hidden;
        }

        .footer-preview-top {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            padding: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, .22);
        }

        .footer-preview-socials {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .footer-preview-socials span {
            border: 1px solid rgba(255, 255, 255, .18);
            border-radius: 999px;
            color: rgba(255, 255, 255, .76);
            font-size: 11px;
            font-weight: 900;
            padding: 7px 9px;
        }

        .footer-preview-body {
            display: grid;
            gap: 16px;
            grid-template-columns: 82px 1fr;
            padding: 18px;
        }

        .footer-preview-logo {
            align-items: center;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 14px;
            display: flex;
            justify-content: center;
            min-height: 82px;
        }

        .footer-preview-logo img {
            max-width: 58px;
            opacity: .5;
        }

        .footer-preview h4 {
            margin: 0;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.45;
            text-transform: uppercase;
        }

        .footer-preview address {
            margin-top: 8px;
            color: rgba(255, 255, 255, .72);
            font-style: normal;
            line-height: 1.6;
        }

        .notice,
        .error-list {
            margin: 0 0 16px;
            padding: 14px 16px;
            border-radius: 16px;
            font-weight: 800;
        }

        .notice {
            border: 1px solid #bbf7d0;
            background: #f0fdf4;
            color: #166534;
        }

        .error-list {
            border: 1px solid #fecdd3;
            background: #fff1f2;
            color: #9f1239;
        }

        .error-list ul {
            margin: 8px 0 0;
            padding-left: 20px;
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
            .grid,
            .logo-settings,
            .footer-settings,
            .settings-grid,
            .footer-preview-body {
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
        @if (session('success'))
            <div class="notice">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error-list">
                No se pudo guardar el cambio.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

        @if ($isAdmin)
            <div class="section-title">
                <div>
                    <h2>Configuracion del sitio</h2>
                    <p>Herramientas disponibles solo para administradores.</p>
                </div>
            </div>

            <section class="logo-settings" aria-labelledby="topbar-logo-title">
                <div>
                    <h3 id="topbar-logo-title">Logo del topbar</h3>
                    <p>Actualiza solo la imagen del logo que aparece en la barra superior del sitio publico. El diseno, color y posicion del topbar no cambian.</p>

                    <form class="logo-form" method="POST" action="{{ route('admin.settings.topbar-logo.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="hidden" name="topbar_logo_remove" value="0" data-remove-image-input>
                        <label for="topbar_logo">
                            Nuevo logo
                            <input id="topbar_logo" name="topbar_logo" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" data-image-file>
                            <span class="hint">JPG, PNG o WebP. Maximo 2 MB. Tambien puedes hacer clic en la vista previa para elegir una imagen.</span>
                            @error('topbar_logo')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                        <button type="submit">Guardar logo</button>
                    </form>
                </div>

                <div class="image-card" data-image-card>
                    <div class="preview preview-logo" data-image-preview aria-label="Logo actual del topbar">
                        <img src="{{ $topbarLogoUrl }}" alt="{{ $hasCustomTopbarLogo ? 'Logo personalizado actual del topbar' : 'Logo predeterminado actual del topbar' }}" data-preview-image>
                        <span class="preview-ruler">Logo topbar</span>
                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar logo actual">×</button>
                    </div>
                </div>
            </section>

            <section class="footer-settings" aria-labelledby="footer-settings-title">
                <div>
                    <h3 id="footer-settings-title">Footer</h3>
                    <p>Edita solo el texto institucional, la URL del logo UMSS y los enlaces oficiales de redes sociales.</p>

                    <div class="footer-preview" aria-label="Vista previa del footer">
                        <div class="footer-preview-top">
                            <span>Todos los derechos reservados © 2026</span>
                            <div class="footer-preview-socials">
                                <span>LinkedIn</span>
                                <span>Facebook</span>
                                <span>X</span>
                                <span>Instagram</span>
                                <span>YouTube</span>
                            </div>
                        </div>
                        <div class="footer-preview-body">
                            <div class="footer-preview-logo">
                                <img src="{{ $frontendUrl ?? 'http://127.0.0.1:3000' }}/images/brand/umss-triangle.png" alt="UMSS">
                            </div>
                            <div>
                                <h4>{{ $footerSettings['footer_title'] }}</h4>
                                <address>
                                    <div>{{ $footerSettings['footer_address_line_1'] }}</div>
                                    <div>{{ $footerSettings['footer_address_line_2'] }}</div>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>

                <form class="settings-form" method="POST" action="{{ route('admin.settings.footer.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="settings-group">
                        <p class="settings-group-title">Texto institucional</p>
                        <div class="settings-grid">
                            <label class="span-2">
                                Nombre institucional
                                <input type="text" name="footer_title" value="{{ old('footer_title', $footerSettings['footer_title']) }}" maxlength="180" required>
                                @error('footer_title')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label class="span-2">
                                Direccion
                                <input type="text" name="footer_address_line_1" value="{{ old('footer_address_line_1', $footerSettings['footer_address_line_1']) }}" maxlength="180" required>
                                @error('footer_address_line_1')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label class="span-2">
                                Edificio
                                <input type="text" name="footer_address_line_2" value="{{ old('footer_address_line_2', $footerSettings['footer_address_line_2']) }}" maxlength="180" required>
                                @error('footer_address_line_2')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label class="span-2">
                                URL del logo UMSS
                                <input type="url" name="footer_umss_url" value="{{ old('footer_umss_url', $footerSettings['footer_umss_url']) }}" maxlength="500" required>
                                @error('footer_umss_url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </div>
                    </div>

                    <div class="settings-group">
                        <p class="settings-group-title">Redes sociales</p>
                        <div class="settings-grid">
                            <label>
                                LinkedIn
                                <input type="url" name="footer_social_linkedin_url" value="{{ old('footer_social_linkedin_url', $footerSettings['footer_social_linkedin_url']) }}" maxlength="500" required>
                                @error('footer_social_linkedin_url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label>
                                Facebook
                                <input type="url" name="footer_social_facebook_url" value="{{ old('footer_social_facebook_url', $footerSettings['footer_social_facebook_url']) }}" maxlength="500" required>
                                @error('footer_social_facebook_url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label>
                                X
                                <input type="url" name="footer_social_x_url" value="{{ old('footer_social_x_url', $footerSettings['footer_social_x_url']) }}" maxlength="500" required>
                                @error('footer_social_x_url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label>
                                Instagram
                                <input type="url" name="footer_social_instagram_url" value="{{ old('footer_social_instagram_url', $footerSettings['footer_social_instagram_url']) }}" maxlength="500" required>
                                @error('footer_social_instagram_url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label class="span-2">
                                YouTube
                                <input type="url" name="footer_social_youtube_url" value="{{ old('footer_social_youtube_url', $footerSettings['footer_social_youtube_url']) }}" maxlength="500" required>
                                @error('footer_social_youtube_url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </div>
                    </div>

                    <button type="submit">Guardar footer</button>
                </form>
            </section>
        @endif

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
    <script>
        const maxLogoBytes = 2 * 1024 * 1024;
        const allowedLogoTypes = ["image/jpeg", "image/png", "image/webp"];

        function imageErrorFor(input) {
            let error = input.parentElement.querySelector(".client-file-error");

            if (!error) {
                error = document.createElement("span");
                error.className = "field-error client-file-error";
                input.parentElement.appendChild(error);
            }

            return error;
        }

        function validateImageInput(input) {
            const file = input.files?.[0];
            const error = imageErrorFor(input);

            input.classList.remove("is-invalid");
            error.textContent = "";

            if (!file) {
                return false;
            }

            if (!allowedLogoTypes.includes(file.type)) {
                input.classList.add("is-invalid");
                error.textContent = "Ese formato no esta permitido. Solo se aceptan imagenes JPG, PNG o WebP.";
                return false;
            }

            if (file.size > maxLogoBytes) {
                input.classList.add("is-invalid");
                error.textContent = "La imagen es demasiado pesada. El tamano maximo permitido es 2 MB.";
                return false;
            }

            return true;
        }

        function previewEmpty(preview) {
            let empty = preview.querySelector("[data-preview-empty]");

            if (!empty) {
                empty = document.createElement("span");
                empty.className = "preview-empty";
                empty.dataset.previewEmpty = "";
                empty.textContent = "Sin logo seleccionado. Puedes subir uno nuevo antes de guardar.";
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function previewImageElement(preview) {
            let image = preview.querySelector("[data-preview-image]");

            if (!image) {
                image = document.createElement("img");
                image.alt = "Vista previa del logo seleccionado";
                image.dataset.previewImage = "";
                preview.prepend(image);
            }

            image.hidden = false;
            return image;
        }

        function clearImagePreview(card) {
            const preview = card.querySelector("[data-image-preview]");
            const image = preview.querySelector("[data-preview-image]");
            const fileInput = document.querySelector("[data-image-file]");
            const removeInput = document.querySelector("[data-remove-image-input]");

            if (fileInput) {
                fileInput.value = "";
                imageErrorFor(fileInput).textContent = "";
                fileInput.classList.remove("is-invalid");
            }

            if (image) {
                if (image.dataset.objectUrl) {
                    URL.revokeObjectURL(image.dataset.objectUrl);
                    delete image.dataset.objectUrl;
                }

                image.removeAttribute("src");
                image.hidden = true;
            }

            previewEmpty(preview);

            if (removeInput) {
                removeInput.value = "1";
            }
        }

        function showSelectedImage(card, file) {
            const preview = card.querySelector("[data-image-preview]");
            const image = previewImageElement(preview);
            const empty = preview.querySelector("[data-preview-empty]");
            const removeInput = document.querySelector("[data-remove-image-input]");

            if (image.dataset.objectUrl) {
                URL.revokeObjectURL(image.dataset.objectUrl);
            }

            image.dataset.objectUrl = URL.createObjectURL(file);
            image.src = image.dataset.objectUrl;

            if (empty) {
                empty.hidden = true;
            }

            if (removeInput) {
                removeInput.value = "0";
            }
        }

        document.querySelectorAll("[data-image-card]").forEach((card) => {
            const fileInput = document.querySelector("[data-image-file]");
            const preview = card.querySelector("[data-image-preview]");
            const removeButton = card.querySelector("[data-remove-image]");

            preview?.addEventListener("click", (event) => {
                if (event.target.closest("[data-remove-image]")) {
                    return;
                }

                fileInput?.click();
            });

            removeButton?.addEventListener("click", (event) => {
                event.stopPropagation();
                clearImagePreview(card);
            });

            fileInput?.addEventListener("change", () => {
                if (!validateImageInput(fileInput)) {
                    return;
                }

                showSelectedImage(card, fileInput.files[0]);
            });
        });
    </script>
</body>
</html>
