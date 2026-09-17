@php
    use Illuminate\Support\Facades\Storage;

    $photoUrl = $user->profile_photo_path ? Storage::disk('public')->url($user->profile_photo_path) : null;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Panel DRIC</title>
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
            --green: #047857;
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
            max-width: 980px;
            margin: 0 auto;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            margin-bottom: 18px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.17em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(34px, 5vw, 54px);
            line-height: 1;
            letter-spacing: -0.04em;
        }

        .layout {
            display: grid;
            grid-template-columns: 300px minmax(0, 1fr);
            gap: 18px;
        }

        .panel,
        .form-card,
        .alert {
            border: 1px solid rgba(22, 65, 148, 0.10);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        .panel {
            padding: 24px;
            align-self: start;
        }

        .avatar {
            width: 138px;
            height: 138px;
            margin: 0 auto 18px;
            border: 5px solid #fff;
            border-radius: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            background: linear-gradient(135deg, var(--blue), #2d6cdf);
            box-shadow: 0 18px 34px rgba(22, 65, 148, 0.24);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar svg {
            width: 54px;
            height: 54px;
        }

        .panel h2 {
            margin: 0;
            text-align: center;
            font-size: 22px;
            line-height: 1.2;
        }

        .panel p {
            margin: 8px 0 0;
            color: var(--muted);
            text-align: center;
            line-height: 1.5;
        }

        .role-pill {
            width: fit-content;
            margin: 18px auto 0;
            padding: 8px 12px;
            border-radius: 999px;
            background: #ecfdf5;
            color: var(--green);
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .form-card {
            padding: 26px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .field {
            display: grid;
            gap: 8px;
            margin-bottom: 16px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            color: var(--blue-dark);
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fff;
            color: var(--ink);
            font-size: 16px;
        }

        input:focus {
            outline: 3px solid rgba(22, 65, 148, 0.14);
            border-color: rgba(22, 65, 148, 0.45);
        }

        input[type="file"] {
            padding: 11px;
            color: var(--muted);
        }

        .hint {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.5;
        }

        .error {
            color: var(--red);
            font-size: 13px;
            font-weight: 700;
        }

        .alert {
            margin-bottom: 18px;
            padding: 14px 16px;
            color: var(--green);
            font-weight: 800;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn {
            min-height: 46px;
            padding: 12px 16px;
            border: 0;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: inherit;
            text-decoration: none;
            font-size: 14px;
            font-weight: 900;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 14px 28px rgba(22, 65, 148, 0.22);
        }

        .btn-secondary {
            border: 1px solid rgba(22, 65, 148, 0.14);
            background: #edf2fb;
            color: var(--blue-dark);
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

        @media (max-width: 820px) {
            body {
                padding: 20px;
            }

            .topbar,
            .layout,
            .grid {
                grid-template-columns: 1fr;
            }

            .topbar {
                align-items: stretch;
                flex-direction: column;
            }

            .btn,
            .actions {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <div class="topbar">
            <div>
                <p class="eyebrow">Panel DRIC</p>
                <h1>Perfil</h1>
            </div>
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                Volver al panel
            </a>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <section class="layout">
            <aside class="panel" aria-label="Resumen del perfil">
                <div class="avatar" aria-hidden="true">
                    @if ($photoUrl)
                        <img src="{{ $photoUrl }}" alt="">
                    @else
                        <svg viewBox="0 0 24 24"><path d="M20 21a8 8 0 0 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>
                    @endif
                </div>
                <h2>{{ $user->name }}</h2>
                <p>{{ $user->email }}</p>
                <div class="role-pill">Editor</div>
            </aside>

            <form class="form-card" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid">
                    <div class="field">
                        <label for="name">Nombre</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                        @error('name') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="email">Gmail</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                        @error('email') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field full">
                        <label for="profile_photo">Foto de perfil</label>
                        <input id="profile_photo" name="profile_photo" type="file" accept="image/png,image/jpeg,image/webp">
                        <p class="hint">JPG, PNG o WebP. Maximo 2 MB.</p>
                        @error('profile_photo') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="password">Nueva contrasena</label>
                        <input id="password" name="password" type="password" autocomplete="new-password">
                        <p class="hint">Dejala vacia si no quieres cambiarla.</p>
                        @error('password') <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">Confirmar contrasena</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                    </div>
                </div>

                <div class="actions">
                    <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Cancelar</a>
                    <button class="btn btn-primary" type="submit">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/></svg>
                        Guardar perfil
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
