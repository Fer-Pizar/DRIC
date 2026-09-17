<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar contraseña - Panel DRIC</title>
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            background:
                radial-gradient(circle at 22% 22%, rgba(22, 65, 148, 0.14), transparent 30rem),
                radial-gradient(circle at 78% 82%, rgba(181, 18, 27, 0.08), transparent 28rem),
                linear-gradient(180deg, #f6f8fc 0%, #eef2f7 100%);
            color: #111827;
            font-family: Arial, sans-serif;
            padding: 24px;
        }

        .card {
            width: min(480px, 100%);
            padding: 34px;
            border: 1px solid rgba(22, 65, 148, 0.10);
            background: rgba(255, 255, 255, 0.94);
            border-radius: 24px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, 0.13);
        }

        .badge {
            width: 54px;
            height: 54px;
            margin-bottom: 18px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: #eef2ff;
            color: #164194;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 32px;
            line-height: 1.08;
            letter-spacing: -0.03em;
        }

        p {
            margin: 0 0 22px;
            color: #6b7280;
            line-height: 1.6;
        }

        .note {
            margin-bottom: 24px;
            padding: 14px 16px;
            border: 1px solid #dbeafe;
            border-radius: 14px;
            background: #eff6ff;
            color: #1e3a8a;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input[type="email"] {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 16px;
        }

        input[type="email"]:focus {
            outline: 3px solid rgba(22, 65, 148, 0.14);
            border-color: rgba(22, 65, 148, 0.55);
        }

        .actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn {
            flex: 1;
            min-height: 46px;
            padding: 13px 16px;
            border: 0;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: inherit;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.2;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            background: #164194;
            color: #fff;
            box-shadow: 0 14px 28px rgba(22, 65, 148, 0.22);
        }

        .btn-secondary {
            border: 1px solid rgba(22, 65, 148, 0.16);
            background: #f8fafc;
            color: #164194;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.8);
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

        .error {
            margin: -8px 0 16px;
            color: #b91c1c;
            font-size: 14px;
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

        @media (max-width: 520px) {
            body {
                padding: 16px;
            }

            .card {
                padding: 26px;
                border-radius: 20px;
            }

            .actions {
                display: grid;
            }
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="badge" aria-hidden="true">
            <svg viewBox="0 0 24 24"><rect x="4" y="11" width="16" height="9" rx="2"/><path d="M8 11V7a4 4 0 0 1 8 0v4"/></svg>
        </div>
        <h1>Recuperar contraseña</h1>
        <p>Escribe tu Gmail del panel y te enviaremos una nueva contraseña temporal.</p>
        <div class="note">Usa la contraseña temporal para entrar. Después podrás cambiarla desde tu perfil.</div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('admin.password.email') }}">
            @csrf

            <label for="email">Correo del panel</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('login') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5"/><path d="M12 19l-7-7 7-7"/></svg>
                    Volver
                </a>
                <button class="btn btn-primary" type="submit">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    Enviar código
                </button>
            </div>
        </form>
    </main>
</body>
</html>
