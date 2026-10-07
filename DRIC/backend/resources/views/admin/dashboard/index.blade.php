@php
    $user = auth()->user();
    $displayName = $user->name ?? $user->email;
    $roleLabel = $isAdmin ? 'Administrador' : 'Editor';
    $roleDescription = $isAdmin
        ? 'Acceso completo a paginas, usuarios, roles y permisos.'
        : 'Acceso limitado a las secciones asignadas por Direccion.';
    $photoUrl = ! $isAdmin && $user->profile_photo_path ? asset('storage/'.$user->profile_photo_path) : null;
    $menuForm = old('menu', $mobileMenuSettings);
    $menuItemCount = max(count(data_get($menuForm, 'es.items', [])), count(data_get($menuForm, 'en.items', [])));
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

        .form-actions {
            display: flex;
            gap: 10px;
            justify-content: flex-end;
        }

        .form-actions button {
            width: auto;
        }

        .btn-undo {
            align-items: center;
            background: #edf2fb;
            color: var(--blue);
            display: inline-flex;
            font-size: 24px;
            justify-content: center;
            min-height: 46px;
            padding: 10px 16px;
            width: 56px;
        }

        .btn-undo:not(:disabled):hover {
            box-shadow: 0 16px 30px rgba(22, 65, 148, 0.16);
        }

        .btn-undo:disabled {
            cursor: not-allowed;
            opacity: .42;
            transform: none;
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
            gap: 14px;
        }

        .settings-group {
            border: 1px solid var(--line);
            border-radius: 18px;
            background: linear-gradient(180deg, #f8fafc 0%, #f2f5fa 100%);
            padding: 14px;
        }

        .settings-group-title {
            margin: 0 0 12px;
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .settings-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .settings-grid .span-2 {
            grid-column: 1 / -1;
        }

        .footer-locale-grid {
            display: grid;
            gap: 12px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .footer-locale-card {
            background: rgba(255,255,255,.86);
            border: 1px solid #dbe3f0;
            border-radius: 16px;
            display: grid;
            gap: 10px;
            padding: 12px;
        }

        .footer-locale-card h4 {
            align-items: center;
            color: var(--ink);
            display: flex;
            font-size: 14px;
            gap: 8px;
            margin: 0;
        }

        .footer-locale-card h4 span {
            background: #e8edf5;
            border-radius: 999px;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 900;
            padding: 5px 8px;
            text-transform: uppercase;
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
            padding: 10px 12px;
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

        .menu-settings {
            border: 1px solid rgba(22, 65, 148, 0.10);
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.90);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
            display: grid;
            gap: 20px;
            grid-template-columns: minmax(280px, .78fr) minmax(0, 1.22fr);
            align-items: start;
            margin-top: 18px;
            padding: 24px;
        }

        .menu-preview {
            background:
                radial-gradient(circle at top left, rgba(181, 18, 27, .26), transparent 19rem),
                linear-gradient(135deg, #041226 0%, #141824 100%);
            border: 1px solid rgba(255, 255, 255, .10);
            border-radius: 22px;
            color: #fff;
            aspect-ratio: 1 / 1;
            max-width: 440px;
            min-height: 0;
            overflow: hidden;
            padding: 24px;
            width: 100%;
        }

        .menu-preview .eyebrow {
            color: #ef233c;
            margin-bottom: 14px;
        }

        .menu-preview h3 {
            color: #fff;
            font-size: clamp(32px, 3.4vw, 42px);
            font-weight: 300;
            letter-spacing: -.05em;
            line-height: .96;
            margin: 0;
            text-transform: uppercase;
        }

        .menu-preview p {
            color: rgba(255, 255, 255, .64);
            font-size: 14px;
            line-height: 1.58;
            margin: 14px 0 0;
        }

        .menu-preview small {
            color: rgba(255, 255, 255, .42);
            display: block;
            font-weight: 800;
            letter-spacing: .18em;
            margin-top: 22px;
            text-transform: uppercase;
        }

        .menu-tabs {
            display: grid;
            gap: 12px;
        }

        .menu-editor-panel {
            background: linear-gradient(180deg, #f8fafc 0%, #f2f5fa 100%);
            border: 1px solid var(--line);
            border-radius: 20px;
            padding: 16px;
        }

        .menu-editor-head {
            align-items: center;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .menu-editor-head h4 {
            align-items: center;
            display: flex;
            gap: 8px;
            margin: 0;
            color: var(--ink);
            font-size: 16px;
        }

        .menu-editor-head span,
        .menu-lang-tag {
            background: #e8edf5;
            border-radius: 999px;
            color: var(--blue-dark);
            font-size: 11px;
            font-weight: 900;
            padding: 5px 8px;
            text-transform: uppercase;
        }

        .menu-hero-fields {
            display: grid;
            gap: 12px;
            margin-bottom: 14px;
        }

        .menu-field-pair {
            background: rgba(255, 255, 255, .82);
            border: 1px solid #dbe3f0;
            border-radius: 16px;
            display: grid;
            gap: 10px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 12px;
        }

        .menu-field-pair-title {
            align-items: center;
            color: var(--blue);
            display: flex;
            font-size: 12px;
            font-weight: 900;
            gap: 8px;
            grid-column: 1 / -1;
            letter-spacing: .06em;
            margin: 0;
            text-transform: uppercase;
        }

        .menu-field-pair-title::before,
        .menu-item-top strong::before {
            background: var(--blue);
            border-radius: 4px;
            content: "";
            display: inline-block;
            flex: 0 0 auto;
            height: 10px;
            width: 10px;
        }

        .menu-hero-fields label,
        .menu-item label {
            display: grid;
            gap: 7px;
            color: var(--blue-dark);
            font-size: 12px;
            font-weight: 900;
        }

        .menu-hero-fields input,
        .menu-hero-fields textarea,
        .menu-item input {
            border: 1px solid #cfd6e3;
            border-radius: 12px;
            color: var(--ink);
            font: inherit;
            font-weight: 500;
            padding: 10px 12px;
            width: 100%;
        }

        .menu-hero-fields textarea {
            min-height: 82px;
            resize: vertical;
        }

        .menu-items-list {
            display: grid;
            gap: 10px;
        }

        .menu-item {
            background: rgba(255, 255, 255, .9);
            border: 1px solid #dbe3f0;
            border-radius: 16px;
            display: grid;
            gap: 10px;
            padding: 12px;
        }

        .menu-item-top {
            align-items: center;
            display: flex;
            gap: 10px;
            justify-content: space-between;
        }

        .menu-item-top strong {
            align-items: center;
            color: var(--blue);
            display: inline-flex;
            gap: 8px;
        }

        .menu-item-grid {
            display: grid;
            gap: 10px;
            grid-template-columns: minmax(0, .72fr) minmax(0, 1fr) minmax(0, 1fr);
        }

        .menu-item-grid .span-2 {
            grid-column: span 1;
        }

        .menu-item-grid .route-field {
            grid-row: span 2;
        }

        .menu-item-grid .route-field input {
            min-height: 46px;
        }

        .btn-secondary,
        .btn-danger-soft {
            width: auto;
        }

        .btn-secondary {
            background: #eaf0ff;
            color: var(--blue-dark);
        }

        .btn-danger-soft {
            background: #fff1f2;
            color: #9f1239;
            min-height: 40px;
            padding: 9px 12px;
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
            .menu-settings,
            .footer-locale-grid,
            .settings-grid,
            .menu-field-pair,
            .menu-item-grid,
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
                    @if ($isAdmin)
                        <a class="profile-link" href="{{ route('admin.users.edit', $user) }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                            Editar
                        </a>
                    @else
                        <a class="profile-link" href="{{ route('admin.profile.edit') }}">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                            Perfil
                        </a>
                    @endif

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
                        <input type="hidden" name="topbar_logo_restore" value="" data-restore-image-input>
                        <label for="topbar_logo">
                            Nuevo logo
                            <input id="topbar_logo" name="topbar_logo" type="file" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" data-image-file>
                            <span class="hint">JPG, PNG o WebP. Maximo 2 MB. Tambien puedes hacer clic en la vista previa para elegir una imagen.</span>
                            @error('topbar_logo')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                        <div class="form-actions">
                            <button class="btn-undo" type="button" data-logo-undo disabled aria-label="Deshacer cambio de logo">↶</button>
                            <button type="submit">Guardar logo</button>
                        </div>
                    </form>
                </div>

                <div class="image-card" data-image-card data-current-image-path="{{ $topbarLogoPath ?? '' }}" data-default-image-src="{{ $frontendUrl }}/images/brand/DRIC_logo.png">
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
                        <div class="footer-locale-grid">
                            <div class="footer-locale-card">
                                <h4><span>ES</span> Español</h4>
                                <label>
                                    Nombre institucional
                                    <input type="text" name="footer_title" value="{{ old('footer_title', $footerSettings['footer_title']) }}" maxlength="180" required>
                                    @error('footer_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Dirección
                                    <input type="text" name="footer_address_line_1" value="{{ old('footer_address_line_1', $footerSettings['footer_address_line_1']) }}" maxlength="180" required>
                                    @error('footer_address_line_1')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Edificio
                                    <input type="text" name="footer_address_line_2" value="{{ old('footer_address_line_2', $footerSettings['footer_address_line_2']) }}" maxlength="180" required>
                                    @error('footer_address_line_2')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                            <div class="footer-locale-card">
                                <h4><span>EN</span> English</h4>
                                <label>
                                    Institutional name
                                    <input type="text" name="footer_title_en" value="{{ old('footer_title_en', $footerSettings['footer_title_en']) }}" maxlength="180" required>
                                    @error('footer_title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Address
                                    <input type="text" name="footer_address_line_1_en" value="{{ old('footer_address_line_1_en', $footerSettings['footer_address_line_1_en']) }}" maxlength="180" required>
                                    @error('footer_address_line_1_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Building
                                    <input type="text" name="footer_address_line_2_en" value="{{ old('footer_address_line_2_en', $footerSettings['footer_address_line_2_en']) }}" maxlength="180" required>
                                    @error('footer_address_line_2_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                        <div class="settings-grid" style="margin-top:12px;">
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

                    <div class="form-actions">
                        <button class="btn-undo" type="button" data-footer-undo disabled aria-label="Deshacer cambio del footer">↶</button>
                        <button type="submit">Guardar footer</button>
                    </div>
                </form>
            </section>

            <section class="menu-settings" aria-labelledby="mobile-menu-title">
                <div>
                    <h3 id="mobile-menu-title">Menú principal</h3>
                    <p>Administra el contenido del menú superior desplegable. El diseño público se mantiene fijo; aquí solo cambian textos, orden y destinos.</p>

                    <div class="menu-preview" aria-label="Vista previa del menu">
                        <p class="eyebrow">{{ data_get($menuForm, 'en.kicker', 'Explore DRIC') }}</p>
                        <h3>{{ data_get($menuForm, 'en.title', 'Global UMSS') }}</h3>
                        <p>{{ data_get($menuForm, 'en.copy', '') }}</p>
                        <small>{{ data_get($menuForm, 'en.footer', 'Universidad Mayor de San Simón · DRIC') }}</small>
                    </div>
                </div>

                <form class="settings-form" method="POST" action="{{ route('admin.settings.mobile-menu.update') }}" data-menu-form>
                    @csrf
                    @method('PUT')

                    <div class="menu-tabs">
                        <div class="menu-editor-panel">
                            <div class="menu-editor-head">
                                <h4><span>ES/EN</span> Bloque principal</h4>
                            </div>

                            <div class="menu-hero-fields">
                                @foreach ([
                                    'kicker' => ['label' => 'Etiqueta superior', 'type' => 'input', 'max' => 80],
                                    'title' => ['label' => 'Título principal', 'type' => 'input', 'max' => 120],
                                    'copy' => ['label' => 'Descripción', 'type' => 'textarea', 'max' => 420],
                                    'footer' => ['label' => 'Texto inferior', 'type' => 'input', 'max' => 120],
                                ] as $field => $meta)
                                    <div class="menu-field-pair">
                                        <p class="menu-field-pair-title">{{ $meta['label'] }}</p>
                                        @foreach (['es' => 'Español', 'en' => 'English'] as $locale => $label)
                                            <label>
                                                <span><span class="menu-lang-tag">{{ strtoupper($locale) }}</span> {{ $label }}</span>
                                                @if ($meta['type'] === 'textarea')
                                                    <textarea name="menu[{{ $locale }}][{{ $field }}]" maxlength="{{ $meta['max'] }}" required>{{ data_get($menuForm, $locale.'.'.$field) }}</textarea>
                                                @else
                                                    <input type="text" name="menu[{{ $locale }}][{{ $field }}]" value="{{ data_get($menuForm, $locale.'.'.$field) }}" maxlength="{{ $meta['max'] }}" required>
                                                @endif
                                                @error('menu.'.$locale.'.'.$field)<span class="field-error">{{ $message }}</span>@enderror
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="menu-editor-panel">
                            <div class="menu-editor-head">
                                <h4><span>Tabs</span> Pestañas del menú</h4>
                                <button class="btn-secondary" type="button" data-add-menu-item>Agregar pestaña</button>
                            </div>

                            <div class="menu-items-list" data-menu-items>
                                @for ($index = 0; $index < $menuItemCount; $index++)
                                    @php
                                        $esItem = data_get($menuForm, 'es.items.'.$index, []);
                                        $enItem = data_get($menuForm, 'en.items.'.$index, []);
                                        $href = data_get($esItem, 'href', data_get($enItem, 'href', ''));
                                    @endphp
                                    <div class="menu-item" data-menu-item>
                                        <div class="menu-item-top">
                                            <strong>Pestaña {{ $index + 1 }}</strong>
                                            <button class="btn-danger-soft" type="button" data-remove-menu-item>Quitar</button>
                                        </div>
                                        <div class="menu-item-grid">
                                            <label class="route-field">
                                                Ruta o URL
                                                <input type="text" data-menu-href value="{{ $href }}" maxlength="500" required>
                                                <input type="hidden" name="menu[es][items][{{ $index }}][href]" value="{{ $href }}" data-hidden-href="es">
                                                <input type="hidden" name="menu[en][items][{{ $index }}][href]" value="{{ $href }}" data-hidden-href="en">
                                            </label>
                                            <label>
                                                <span><span class="menu-lang-tag">ES</span> Título</span>
                                                <input type="text" name="menu[es][items][{{ $index }}][label]" value="{{ data_get($esItem, 'label') }}" maxlength="80" required>
                                            </label>
                                            <label>
                                                <span><span class="menu-lang-tag">EN</span> Title</span>
                                                <input type="text" name="menu[en][items][{{ $index }}][label]" value="{{ data_get($enItem, 'label') }}" maxlength="80" required>
                                            </label>
                                            <label>
                                                <span><span class="menu-lang-tag">ES</span> Subtítulo</span>
                                                <input type="text" name="menu[es][items][{{ $index }}][description]" value="{{ data_get($esItem, 'description') }}" maxlength="120" required>
                                            </label>
                                            <label>
                                                <span><span class="menu-lang-tag">EN</span> Subtitle</span>
                                                <input type="text" name="menu[en][items][{{ $index }}][description]" value="{{ data_get($enItem, 'description') }}" maxlength="120" required>
                                            </label>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn-undo" type="button" data-menu-undo disabled aria-label="Deshacer cambio del menu">↶</button>
                        <button type="submit">Guardar menú</button>
                    </div>
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
        const undoScope = `admin-dashboard:${window.location.pathname}`;

        function readUndoStack(key) {
            try {
                return JSON.parse(sessionStorage.getItem(key) || "[]");
            } catch (error) {
                return [];
            }
        }

        function writeUndoStack(key, stack) {
            sessionStorage.setItem(key, JSON.stringify(stack.slice(-80)));
        }

        function pushUndoState(key, state, button) {
            const stack = readUndoStack(key);
            const lastState = stack[stack.length - 1];

            if (lastState && JSON.stringify(lastState) === JSON.stringify(state)) {
                return;
            }

            stack.push(state);
            writeUndoStack(key, stack);
            updateUndoButton(key, button);
        }

        function popUndoState(key, button) {
            const stack = readUndoStack(key);
            const state = stack.pop();

            writeUndoStack(key, stack);
            updateUndoButton(key, button);

            return state || null;
        }

        function updateUndoButton(key, button) {
            if (!button) {
                return;
            }

            button.disabled = readUndoStack(key).length === 0;
        }

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
            const restoreInput = document.querySelector("[data-restore-image-input]");

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

            if (restoreInput) {
                restoreInput.value = "";
            }

            card.dataset.currentImagePath = "";
        }

        function showSelectedImage(card, file) {
            const preview = card.querySelector("[data-image-preview]");
            const image = previewImageElement(preview);
            const empty = preview.querySelector("[data-preview-empty]");
            const removeInput = document.querySelector("[data-remove-image-input]");
            const restoreInput = document.querySelector("[data-restore-image-input]");

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

            if (restoreInput) {
                restoreInput.value = "";
            }

            card.dataset.currentImagePath = "";
        }

        document.querySelectorAll("[data-image-card]").forEach((card) => {
            const fileInput = document.querySelector("[data-image-file]");
            const preview = card.querySelector("[data-image-preview]");
            const removeButton = card.querySelector("[data-remove-image]");
            const removeInput = document.querySelector("[data-remove-image-input]");
            const restoreInput = document.querySelector("[data-restore-image-input]");
            const undoButton = document.querySelector("[data-logo-undo]");
            const logoUndoKey = `${undoScope}:topbar-logo`;

            function logoSnapshot() {
                const image = preview.querySelector("[data-preview-image]");
                const src = image && !image.hidden ? image.getAttribute("src") || "" : "";
                const path = card.dataset.currentImagePath || "";
                const defaultSrc = card.dataset.defaultImageSrc || "";

                return {
                    src,
                    path,
                    isDefault: Boolean(src && defaultSrc && src === defaultSrc && !path),
                    removeValue: removeInput?.value || "0",
                };
            }

            function applyLogoSnapshot(snapshot) {
                const image = previewImageElement(preview);
                const empty = preview.querySelector("[data-preview-empty]");

                if (fileInput) {
                    fileInput.value = "";
                    imageErrorFor(fileInput).textContent = "";
                    fileInput.classList.remove("is-invalid");
                }

                if (image.dataset.objectUrl) {
                    URL.revokeObjectURL(image.dataset.objectUrl);
                    delete image.dataset.objectUrl;
                }

                if (snapshot.src) {
                    image.src = snapshot.src;
                    image.hidden = false;

                    if (empty) {
                        empty.hidden = true;
                    }
                } else {
                    image.removeAttribute("src");
                    image.hidden = true;
                    previewEmpty(preview);
                }

                card.dataset.currentImagePath = snapshot.path || "";

                if (restoreInput) {
                    restoreInput.value = snapshot.path || "";
                }

                if (removeInput) {
                    removeInput.value = snapshot.path
                        ? "0"
                        : (snapshot.isDefault ? "1" : snapshot.removeValue || "0");
                }
            }

            updateUndoButton(logoUndoKey, undoButton);

            preview?.addEventListener("click", (event) => {
                if (event.target.closest("[data-remove-image]")) {
                    return;
                }

                fileInput?.click();
            });

            removeButton?.addEventListener("click", (event) => {
                event.stopPropagation();
                pushUndoState(logoUndoKey, logoSnapshot(), undoButton);
                clearImagePreview(card);
            });

            fileInput?.addEventListener("change", () => {
                if (!validateImageInput(fileInput)) {
                    return;
                }

                pushUndoState(logoUndoKey, logoSnapshot(), undoButton);
                showSelectedImage(card, fileInput.files[0]);
            });

            undoButton?.addEventListener("click", () => {
                const snapshot = popUndoState(logoUndoKey, undoButton);

                if (snapshot) {
                    applyLogoSnapshot(snapshot);
                }
            });
        });

        document.querySelectorAll("[data-footer-undo]").forEach((undoButton) => {
            const form = undoButton.closest("form");
            const footerUndoKey = `${undoScope}:footer`;
            let beforeEdit = null;

            function fields() {
                return Array.from(form.querySelectorAll("input[type='text'], input[type='url']"));
            }

            function footerSnapshot() {
                return fields().map((field) => ({
                    name: field.name,
                    value: field.value,
                }));
            }

            function applyFooterSnapshot(snapshot) {
                snapshot.forEach((entry) => {
                    const field = fields().find((candidate) => candidate.name === entry.name);

                    if (field) {
                        field.value = entry.value;
                    }
                });
            }

            function maybePushBeforeEdit() {
                if (!beforeEdit) {
                    return;
                }

                if (JSON.stringify(beforeEdit) !== JSON.stringify(footerSnapshot())) {
                    pushUndoState(footerUndoKey, beforeEdit, undoButton);
                    beforeEdit = footerSnapshot();
                }
            }

            updateUndoButton(footerUndoKey, undoButton);

            form.addEventListener("focusin", (event) => {
                if (event.target.matches("input[type='text'], input[type='url']")) {
                    beforeEdit = footerSnapshot();
                }
            });

            form.addEventListener("input", maybePushBeforeEdit);
            form.addEventListener("change", maybePushBeforeEdit);

            form.addEventListener("submit", () => {
                maybePushBeforeEdit();
            });

            undoButton.addEventListener("click", () => {
                const snapshot = popUndoState(footerUndoKey, undoButton);

                if (snapshot) {
                    applyFooterSnapshot(snapshot);
                    beforeEdit = footerSnapshot();
                }
            });
        });

        document.querySelectorAll("[data-menu-form]").forEach((form) => {
            const menuUndoKey = `${undoScope}:mobile-menu`;
            const undoButton = form.querySelector("[data-menu-undo]");
            let beforeMenuEdit = null;

            function menuItemsList() {
                return form.querySelector("[data-menu-items]");
            }

            function syncSharedHrefs() {
                form.querySelectorAll("[data-menu-item]").forEach((item) => {
                    const href = item.querySelector("[data-menu-href]")?.value || "";

                    item.querySelectorAll("[data-hidden-href]").forEach((input) => {
                        input.value = href;
                    });
                });
            }

            function reindexMenuItems() {
                syncSharedHrefs();

                Array.from(form.querySelectorAll("[data-menu-item]")).forEach((item, index) => {
                    const title = item.querySelector(".menu-item-top strong");

                    if (title) {
                        title.textContent = `Pestaña ${index + 1}`;
                    }

                    item.querySelectorAll("input[name], [data-hidden-href], [data-menu-field]").forEach((input) => {
                        const locale = input.dataset.hiddenHref || input.dataset.menuLocale || (input.name.includes("menu[en]") ? "en" : "es");
                        const field = input.dataset.hiddenHref
                            ? "href"
                            : input.dataset.menuField || (input.name.includes("[label]")
                            ? "label"
                            : input.name.includes("[description]")
                                ? "description"
                                : "href");

                        input.name = `menu[${locale}][items][${index}][${field}]`;
                    });
                });
            }

            function menuSnapshot() {
                reindexMenuItems();

                return ["es", "en"].reduce((snapshot, locale) => {
                    const getValue = (selector) => form.querySelector(selector)?.value || "";

                    snapshot[locale] = {
                        kicker: getValue(`[name="menu[${locale}][kicker]"]`),
                        title: getValue(`[name="menu[${locale}][title]"]`),
                        copy: getValue(`[name="menu[${locale}][copy]"]`),
                        footer: getValue(`[name="menu[${locale}][footer]"]`),
                        items: Array.from(form.querySelectorAll("[data-menu-item]")).map((item) => ({
                            label: item.querySelector(`[name^="menu[${locale}]"][name*="[label]"]`)?.value || "",
                            href: item.querySelector("[data-menu-href]")?.value || "",
                            description: item.querySelector(`[name^="menu[${locale}]"][name*="[description]"]`)?.value || "",
                        })),
                    };

                    return snapshot;
                }, {});
            }

            function createMenuItem(item = {}) {
                const list = menuItemsList();

                if (!list) {
                    return null;
                }

                const es = item.es || {};
                const en = item.en || {};
                const href = item.href || es.href || en.href || "";
                const element = document.createElement("div");
                element.className = "menu-item";
                element.dataset.menuItem = "";
                element.innerHTML = `
                    <div class="menu-item-top">
                        <strong>Pestaña</strong>
                        <button class="btn-danger-soft" type="button" data-remove-menu-item>Quitar</button>
                    </div>
                    <div class="menu-item-grid">
                        <label class="route-field">
                            Ruta o URL
                            <input type="text" data-menu-href maxlength="500" required>
                            <input type="hidden" data-hidden-href="es">
                            <input type="hidden" data-hidden-href="en">
                        </label>
                        <label>
                            <span><span class="menu-lang-tag">ES</span> Título</span>
                            <input type="text" data-menu-locale="es" data-menu-field="label" maxlength="80" required>
                        </label>
                        <label>
                            <span><span class="menu-lang-tag">EN</span> Title</span>
                            <input type="text" data-menu-locale="en" data-menu-field="label" maxlength="80" required>
                        </label>
                        <label>
                            <span><span class="menu-lang-tag">ES</span> Subtítulo</span>
                            <input type="text" data-menu-locale="es" data-menu-field="description" maxlength="120" required>
                        </label>
                        <label>
                            <span><span class="menu-lang-tag">EN</span> Subtitle</span>
                            <input type="text" data-menu-locale="en" data-menu-field="description" maxlength="120" required>
                        </label>
                    </div>
                `;

                const hrefInput = element.querySelector("[data-menu-href]");
                const hiddenHrefs = element.querySelectorAll("[data-hidden-href]");
                const textInputs = Array.from(element.querySelectorAll("input[type='text']:not([data-menu-href])"));

                hrefInput.value = href;
                hiddenHrefs.forEach((input) => {
                    input.value = href;
                });
                textInputs[0].value = es.label || "";
                textInputs[1].value = en.label || "";
                textInputs[2].value = es.description || "";
                textInputs[3].value = en.description || "";

                list.appendChild(element);
                reindexMenuItems();

                return element;
            }

            function applyMenuSnapshot(snapshot) {
                ["es", "en"].forEach((locale) => {
                    const localeData = snapshot[locale] || {};

                    const setFieldValue = (selector, value) => {
                        const field = form.querySelector(selector);

                        if (field) {
                            field.value = value || "";
                        }
                    };

                    setFieldValue(`[name="menu[${locale}][kicker]"]`, localeData.kicker);
                    setFieldValue(`[name="menu[${locale}][title]"]`, localeData.title);
                    setFieldValue(`[name="menu[${locale}][copy]"]`, localeData.copy);
                    setFieldValue(`[name="menu[${locale}][footer]"]`, localeData.footer);
                });

                const list = menuItemsList();
                const esItems = snapshot.es?.items || [];
                const enItems = snapshot.en?.items || [];
                const itemCount = Math.max(esItems.length, enItems.length);

                if (list) {
                    list.innerHTML = "";
                }

                for (let index = 0; index < itemCount; index += 1) {
                    createMenuItem({
                        es: esItems[index] || {},
                        en: enItems[index] || {},
                        href: esItems[index]?.href || enItems[index]?.href || "",
                    });
                }

                reindexMenuItems();
            }

            function maybePushMenuBeforeEdit() {
                if (!beforeMenuEdit) {
                    return;
                }

                if (JSON.stringify(beforeMenuEdit) !== JSON.stringify(menuSnapshot())) {
                    pushUndoState(menuUndoKey, beforeMenuEdit, undoButton);
                    beforeMenuEdit = menuSnapshot();
                }
            }

            updateUndoButton(menuUndoKey, undoButton);
            reindexMenuItems();

            form.addEventListener("focusin", (event) => {
                if (event.target.matches("input[type='text'], textarea")) {
                    beforeMenuEdit = menuSnapshot();
                }
            });

            form.addEventListener("input", maybePushMenuBeforeEdit);

            form.addEventListener("click", (event) => {
                const addButton = event.target.closest("[data-add-menu-item]");
                const removeButton = event.target.closest("[data-remove-menu-item]");

                if (addButton) {
                    beforeMenuEdit = menuSnapshot();
                    const newItem = createMenuItem({ es: {}, en: {}, href: "" });
                    maybePushMenuBeforeEdit();

                    if (newItem) {
                        newItem.scrollIntoView({ behavior: "smooth", block: "center" });
                        requestAnimationFrame(() => {
                            newItem.querySelector("[data-menu-href]")?.focus();
                        });
                    }
                }

                if (removeButton) {
                    const item = removeButton.closest("[data-menu-item]");

                    beforeMenuEdit = menuSnapshot();
                    item?.remove();
                    reindexMenuItems();
                    maybePushMenuBeforeEdit();
                }
            });

            form.addEventListener("submit", () => {
                maybePushMenuBeforeEdit();
                reindexMenuItems();
            });

            undoButton?.addEventListener("click", () => {
                const snapshot = popUndoState(menuUndoKey, undoButton);

                if (snapshot) {
                    applyMenuSnapshot(snapshot);
                    beforeMenuEdit = menuSnapshot();
                }
            });
        });
    </script>
</body>
</html>
