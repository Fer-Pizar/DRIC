<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - Panel DRIC</title>
    <style>
        :root {
            --blue: #164194;
            --blue-dark: #0f2f73;
            --ink: #101827;
            --muted: #667085;
            --line: #d7e0ef;
            --surface: rgba(255, 255, 255, 0.94);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 28px;
            background:
                radial-gradient(circle at 18% 18%, rgba(22, 65, 148, 0.14), transparent 31rem),
                radial-gradient(circle at 84% 82%, rgba(181, 18, 27, 0.08), transparent 30rem),
                linear-gradient(180deg, #f7f9fd 0%, #edf2f8 100%);
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .shell {
            width: min(980px, 100%);
            display: grid;
            grid-template-columns: 0.92fr 1.08fr;
            overflow: hidden;
            border: 1px solid rgba(22, 65, 148, 0.12);
            border-radius: 28px;
            background: var(--surface);
            box-shadow: 0 30px 90px rgba(15, 23, 42, 0.15);
        }

        .visual {
            min-height: 520px;
            padding: 42px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(150deg, rgba(22, 65, 148, 0.98), rgba(15, 47, 115, 0.96)),
                var(--blue);
            color: #fff;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .logo {
            width: 70px;
            height: 70px;
            border-radius: 21px;
            display: grid;
            place-items: center;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 18px 40px rgba(3, 7, 18, 0.18);
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .brand-text {
            display: grid;
            gap: 4px;
        }

        .brand-text strong {
            font-size: 13px;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .brand-text span {
            color: rgba(255, 255, 255, 0.72);
            font-size: 14px;
            font-weight: 700;
        }

        .illustration-card {
            min-height: 315px;
            display: grid;
            place-items: center;
            padding: 0;
        }

        .robot-image {
            width: min(360px, 100%);
            max-height: 340px;
            object-fit: contain;
            filter: drop-shadow(0 24px 34px rgba(3, 7, 18, 0.22));
        }

        .robot-placeholder {
            display: grid;
            gap: 12px;
            place-items: center;
            color: rgba(255, 255, 255, 0.76);
            text-align: center;
        }

        .robot-placeholder svg {
            width: 76px;
            height: 76px;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        .robot-placeholder span {
            max-width: 250px;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.45;
        }

        .content {
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .status {
            width: 56px;
            height: 56px;
            margin-bottom: 24px;
            border-radius: 18px;
            display: grid;
            place-items: center;
            background: #edf3ff;
            color: var(--blue);
        }

        .status svg {
            width: 28px;
            height: 28px;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        h1 {
            margin: 0;
            color: var(--ink);
            font-size: 42px;
            line-height: 1.05;
        }

        .message {
            margin: 18px 0 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.7;
        }

        .hint {
            margin: 24px 0 0;
            padding: 15px 16px;
            border: 1px solid #cfe0ff;
            border-radius: 16px;
            background: #f3f7ff;
            color: #1f3f86;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.5;
        }

        .actions {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 28px;
        }

        .btn {
            min-height: 48px;
            padding: 13px 16px;
            border: 1px solid transparent;
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            color: var(--blue);
            background: #eef3fb;
            font-size: 15px;
            font-weight: 900;
            text-align: center;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
        }

        .btn:hover,
        .btn:focus {
            transform: translateY(-1px);
            border-color: #bfd0ea;
            box-shadow: 0 14px 28px rgba(15, 23, 42, 0.10);
            outline: none;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
            box-shadow: 0 15px 30px rgba(22, 65, 148, 0.22);
        }

        .btn svg {
            width: 20px;
            height: 20px;
            stroke: currentColor;
            stroke-width: 2.2;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        @media (max-width: 780px) {
            body {
                padding: 18px;
            }

            .shell {
                grid-template-columns: 1fr;
                border-radius: 24px;
            }

            .visual {
                min-height: auto;
                padding: 28px;
                gap: 28px;
            }

            .content {
                padding: 32px 28px;
            }

            h1 {
                font-size: 34px;
            }
        }

        @media (max-width: 520px) {
            .actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <section class="visual" aria-label="Ilustración de página no encontrada">
            <div class="brand">
                <div class="logo">
                    <img src="{{ asset('images/login/dric-logo.png') }}" alt="DRIC">
                </div>
                <div class="brand-text">
                    <strong>Panel DRIC</strong>
                    <span>Centro administrativo</span>
                </div>
            </div>

            <div class="illustration-card">
                <img
                    class="robot-image"
                    src="{{ asset('images/errors/robotcito.png') }}"
                    alt="Robot sin bateria"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                >
                <div class="robot-placeholder" style="display: none;">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="5" y="8" width="14" height="10" rx="3"/>
                        <path d="M12 8V5"/>
                        <path d="M9 5h6"/>
                        <path d="M8.5 12h.01"/>
                        <path d="M15.5 12h.01"/>
                        <path d="M10 15h4"/>
                    </svg>
                    <span>Coloca aqui tu imagen robotcito.png</span>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="status" aria-hidden="true">
                <svg viewBox="0 0 24 24">
                    <path d="M10.3 13.7a5 5 0 0 1 7.1-7.1l1 1a5 5 0 0 1 0 7.1l-1.2 1.2"/>
                    <path d="M13.7 10.3a5 5 0 0 1-7.1 7.1l-1-1a5 5 0 0 1 0-7.1l1.2-1.2"/>
                    <path d="M8 12h8"/>
                </svg>
            </div>

            <h1>No encontramos esta página.</h1>
            <p class="message">
                Es posible que el enlace haya cambiado, que la página ya no exista o que la dirección escrita no corresponda a una sección disponible del sistema.
            </p>
            <div class="hint">
                Revisa la URL o vuelve al panel para continuar.
            </div>

            <div class="actions">
                <a class="btn" href="{{ url()->previous() }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 12H5"/>
                        <path d="m12 19-7-7 7-7"/>
                    </svg>
                    Volver atrás
                </a>
                <a class="btn btn-primary" href="{{ auth()->check() ? route('admin.dashboard') : route('login') }}">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M3 12h18"/>
                        <path d="m12 3 9 9-9 9"/>
                    </svg>
                    {{ auth()->check() ? 'Volver al panel' : 'Ir al inicio de sesión' }}
                </a>
            </div>
        </section>
    </main>
</body>
</html>
