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
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            align-items: stretch;
        }

        .btn {
            width: 100%;
            min-height: 54px;
            box-sizing: border-box;
            padding: 14px 18px;
            border: 0;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: inherit;
            text-decoration: none;
            font-family: inherit;
            font-size: 16px;
            font-weight: 700;
            line-height: 1.2;
            cursor: pointer;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            appearance: none;
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
                grid-template-columns: 1fr;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
<main class="card">
    <h1>Elegir nueva contraseña</h1>
    <p>Usa al menos 12 caracteres. El enlace vence y se puede utilizar una sola vez.</p>
    <form method="POST" action="{{ route('admin.password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <label for="email">Correo del panel</label>
        <input id="email" name="email" type="email" value="{{ old('email', $email) }}" autocomplete="email" required>
        <label for="password">Nueva contraseña</label>
        <input id="password" name="password" type="password" minlength="12" maxlength="255" autocomplete="new-password" required>
        <label for="password_confirmation">Confirmar contraseña</label>
        <input id="password_confirmation" name="password_confirmation" type="password" minlength="12" maxlength="255" autocomplete="new-password" required>
        @foreach ($errors->all() as $error)<p class="error" role="alert">{{ $error }}</p>@endforeach
        <div class="actions">
            <a href="{{ route('admin.password.request') }}">Solicitar otro enlace</a>
            <button class="btn btn-primary" type="submit">Guardar contraseña</button>
        </div>
    </form>
</main>
</body>
</html>
