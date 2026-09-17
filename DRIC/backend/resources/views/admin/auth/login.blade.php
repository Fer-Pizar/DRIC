<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar - Panel DRIC</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(circle at 22% 20%, rgba(22, 65, 148, 0.14), transparent 30rem),
                radial-gradient(circle at 80% 82%, rgba(181, 18, 27, 0.08), transparent 28rem),
                linear-gradient(180deg, #f6f8fc 0%, #eef2f7 100%);
            color: #111827;
            font-family: Arial, sans-serif;
        }

        .card {
            width: min(470px, 100%);
            padding: 34px;
            border: 1px solid rgba(22, 65, 148, 0.10);
            background: rgba(255, 255, 255, 0.94);
            border-radius: 24px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.13);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 24px;
        }

        .logo-slot {
            width: 76px;
            height: 76px;
            border: 1px solid rgba(22, 65, 148, 0.14);
            border-radius: 22px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            background:
                linear-gradient(135deg, rgba(22, 65, 148, 0.10), rgba(255, 255, 255, 0.86));
            color: #164194;
            font-size: 11px;
            font-weight: 900;
            letter-spacing: 0.12em;
            text-align: center;
            text-transform: uppercase;
            overflow: hidden;
        }

        .logo-slot img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            padding: 0px;
        }

        .eyebrow {
            margin: 0 0 6px;
            color: #164194;
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 32px;
            line-height: 1.08;
            letter-spacing: -0.03em;
        }

        p {
            margin: 0 0 26px;
            color: #6b7280;
            line-height: 1.6;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input[type="email"],
        input[type="password"],
        .password-field input {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 18px;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 16px;
        }

        input[type="email"]:focus,
        input[type="password"]:focus,
        .password-field input:focus {
            outline: 3px solid rgba(22, 65, 148, 0.14);
            border-color: rgba(22, 65, 148, 0.55);
        }

        .password-field {
            position: relative;
        }

        .password-field input {
            padding-right: 48px;
        }

        .password-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            width: 36px;
            height: 36px;
            min-height: 0;
            padding: 0;
            border: 0;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            color: #6b7280;
            transform: translateY(calc(-50% - 9px));
            box-shadow: none;
            cursor: pointer;
        }

        .password-toggle:hover,
        .password-toggle:focus {
            background: #eef2ff;
            color: #164194;
            transform: translateY(calc(-50% - 9px));
            box-shadow: none;
            outline: none;
        }

        .password-toggle svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .password-toggle .eye-open {
            display: none;
        }

        .password-toggle.is-visible .eye-closed {
            display: none;
        }

        .password-toggle.is-visible .eye-open {
            display: block;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
            color: #374151;
        }

        .remember label {
            margin: 0;
            font-weight: 400;
        }

        .form-links {
            display: flex;
            justify-content: flex-end;
            margin: 0 0 20px;
        }

        .form-links a {
            color: #164194;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        .alert {
            margin: 0 0 18px;
            padding: 12px 14px;
            border-radius: 10px;
            background: #ecfdf5;
            color: #047857;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.45;
        }

        button {
            width: 100%;
            min-height: 48px;
            padding: 13px 16px;
            border: 0;
            border-radius: 12px;
            background: #164194;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 14px 28px rgba(22, 65, 148, 0.22);
            transition: transform 0.18s ease, box-shadow 0.18s ease;
        }

        button:hover {
            transform: translateY(-1px);
            box-shadow: 0 18px 34px rgba(22, 65, 148, 0.26);
        }

        .error {
            margin: -8px 0 16px;
            color: #b91c1c;
            font-size: 14px;
        }

        @media (max-width: 520px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 26px;
                border-radius: 20px;
            }

            .brand {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="brand">
            <div class="logo-slot" aria-label="Espacio para el logo DRIC">
                <img src="{{ asset('images/login/dric-logo.png') }}" alt="DRIC">
            </div>
            <div>
                <p class="eyebrow">Panel DRIC</p>
                <h1>Centro administrativo</h1>
            </div>
        </div>

        <p>Ingresa con tu correo institucional y contraseña para gestionar el contenido autorizado.</p>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Contraseña</label>
            <div class="password-field">
                <input id="password" name="password" type="password" autocomplete="current-password" required>
                <button class="password-toggle" type="button" aria-label="Mostrar contraseña" aria-pressed="false" data-password-toggle>
                    <svg class="eye-closed" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 3l18 18"/>
                        <path d="M10.6 10.6A2 2 0 0 0 13.4 13.4"/>
                        <path d="M9.9 4.2A10.6 10.6 0 0 1 12 4c5 0 9 4.5 10 8a12.8 12.8 0 0 1-2.3 4.1"/>
                        <path d="M6.6 6.6A12.2 12.2 0 0 0 2 12c1 3.5 5 8 10 8a10.8 10.8 0 0 0 5.4-1.5"/>
                    </svg>
                    <svg class="eye-open" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                </button>
            </div>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="remember">
                <input id="remember" name="remember" type="checkbox" value="1">
                <label for="remember">Recordar sesión</label>
            </div>

            <div class="form-links">
                <a href="{{ route('admin.password.request') }}">¿Olvidaste tu contraseña?</a>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </main>
    <script>
        const passwordInput = document.querySelector('#password');
        const passwordToggle = document.querySelector('[data-password-toggle]');

        passwordToggle?.addEventListener('click', () => {
            const isVisible = passwordInput.type === 'text';

            passwordInput.type = isVisible ? 'password' : 'text';
            passwordToggle.classList.toggle('is-visible', ! isVisible);
            passwordToggle.setAttribute('aria-pressed', String(! isVisible));
            passwordToggle.setAttribute('aria-label', isVisible ? 'Mostrar contraseña' : 'Ocultar contraseña');
            passwordInput.focus();
        });
    </script>
</body>
</html>
