<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Editar página</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 40px;
            color: #222;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-secondary {
            background: #6b7280;
            color: #fff;
        }

        form {
            display: grid;
            gap: 20px;
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
                gap: 14px;
            }

            h1 {
                font-size: 28px;
                line-height: 1.15;
            }

            .btn {
                box-sizing: border-box;
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Editar página</h1>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Volver</a>
        </div>

        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf
            @method('PUT')

            @include('admin.pages._form')

            <div>
                <button type="submit" class="btn btn-primary">Actualizar página</button>
            </div>
        </form>
    </div>
</body>
</html>
