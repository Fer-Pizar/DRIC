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
            background: #f3f4f6;
            color: #111827;
            font-family: Arial, sans-serif;
        }

        .card {
            width: min(420px, calc(100vw - 32px));
            padding: 32px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 18px 60px rgba(15, 23, 42, 0.14);
        }

        h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        p {
            margin: 0 0 28px;
            color: #6b7280;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 700;
        }

        input[type="email"],
        input[type="password"] {
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 18px;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 16px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 22px;
            color: #374151;
        }

        .remember label {
            margin: 0;
            font-weight: 400;
        }

        button {
            width: 100%;
            padding: 13px 16px;
            border: 0;
            border-radius: 10px;
            background: #164194;
            color: #fff;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
        }

        .error {
            margin: -8px 0 16px;
            color: #b91c1c;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <main class="card">
        <h1>Panel administrativo DRIC</h1>
        <p>Ingresa con tu correo institucional y contraseña.</p>

        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <label for="email">Correo electrónico</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" autofocus required>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Contraseña</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <div class="remember">
                <input id="remember" name="remember" type="checkbox" value="1">
                <label for="remember">Recordar sesión</label>
            </div>

            <button type="submit">Ingresar</button>
        </form>
    </main>
</body>
</html>
