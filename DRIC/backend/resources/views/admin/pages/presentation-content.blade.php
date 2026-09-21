@php
    $frontendUrl = rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/');
    $preview = function (?string $path) use ($frontendUrl): string {
        $path = (string) $path;
        if ($path === '') {
            return '';
        }
        if (\Illuminate\Support\Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }
        if (\Illuminate\Support\Str::startsWith($path, '/storage/')) {
            return url($path);
        }
        return $frontendUrl.$path;
    };
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Contenido de Presentación</title>
    <style>
        :root {
            --blue: #164194;
            --red: #b5121b;
            --red-dark: #7f0010;
            --ink: #172033;
            --muted: #647084;
            --line: #e5e9f0;
            --soft: #f5f7fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6f9;
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .shell {
            margin: 0 auto;
            max-width: 1180px;
            padding: 36px 20px 56px;
        }

        .topbar,
        .panel,
        .language-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
        }

        .topbar {
            align-items: center;
            display: flex;
            gap: 18px;
            justify-content: space-between;
            margin-bottom: 22px;
            padding: 24px;
        }

        h1,
        h2,
        h3 {
            margin: 0;
        }

        h1 {
            font-size: 34px;
            line-height: 1.1;
        }

        h2 {
            font-size: 22px;
        }

        h3 {
            color: var(--blue);
            font-size: 18px;
        }

        .muted {
            color: var(--muted);
            line-height: 1.55;
            margin: 8px 0 0;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            font-weight: 800;
            justify-content: center;
            padding: 12px 16px;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-secondary {
            background: #e8edf5;
            color: var(--ink);
        }

        .btn-undo {
            align-items: center;
            background: #eef3fb;
            color: var(--blue);
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
            min-width: 44px;
            text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor;
        }

        .btn-undo:disabled {
            cursor: not-allowed;
            opacity: .42;
        }

        .alert {
            border-radius: 14px;
            margin-bottom: 18px;
            padding: 14px 16px;
        }

        .alert-success {
            background: #e8f8ee;
            border: 1px solid #bde8c9;
            color: #176534;
        }

        .alert-error {
            background: #fff1f2;
            border: 1px solid #b91c1c;
            color: var(--red-dark);
            font-weight: 800;
        }

        form {
            display: grid;
            gap: 22px;
        }

        .panel {
            padding: 24px;
        }

        .panel-header {
            border-bottom: 1px solid var(--line);
            margin-bottom: 20px;
            padding-bottom: 16px;
        }

        .language-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .language-card {
            box-shadow: none;
            padding: 18px;
        }

        .card-header {
            align-items: center;
            display: flex;
            gap: 12px;
            justify-content: space-between;
            margin-bottom: 14px;
        }

        .field-grid {
            display: grid;
            gap: 14px;
        }

        label {
            display: grid;
            gap: 7px;
            font-size: 13px;
            font-weight: 800;
        }

        input[type="text"],
        input[type="file"],
        textarea {
            border: 1px solid #cfd6e3;
            border-radius: 12px;
            color: var(--ink);
            font: inherit;
            font-weight: 500;
            padding: 12px 13px;
            width: 100%;
        }

        textarea {
            line-height: 1.55;
            min-height: 110px;
            resize: vertical;
        }

        .hint {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            line-height: 1.45;
        }

        .field-error,
        .live-error {
            color: var(--red-dark);
            font-size: 12px;
            font-weight: 800;
            line-height: 1.45;
        }

        .live-error:empty {
            display: none;
        }

        .is-invalid {
            border-color: var(--red-dark) !important;
            box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10);
        }

        .image-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .image-card {
            background: var(--soft);
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 16px;
            position: relative;
        }

        .undo-floating {
            position: absolute;
            right: 12px;
            top: 12px;
            z-index: 4;
        }

        .image-card > .undo-floating {
            right: -10px;
            top: -10px;
            z-index: 6;
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
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .preview-team {
            aspect-ratio: 4 / 3;
            max-height: 420px;
        }

        .preview-director {
            aspect-ratio: 2 / 3;
            max-height: 821px;
        }

        .preview img {
            height: 100%;
            object-fit: cover;
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
            padding: 0;
            position: absolute;
            right: 12px;
            top: 12px;
            width: 34px;
            z-index: 2;
        }

        .btn-image-remove:disabled {
            cursor: not-allowed;
            opacity: .42;
        }

        .preview-empty {
            color: rgba(255, 255, 255, .72);
            padding: 18px;
            text-align: center;
        }

        .crop-modal {
            align-items: center;
            background: rgba(2, 6, 23, .78);
            display: none;
            inset: 0;
            justify-content: center;
            padding: 18px;
            position: fixed;
            z-index: 50;
        }

        .crop-modal.is-open {
            display: flex;
        }

        .crop-dialog {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 30px 90px rgba(0, 0, 0, .34);
            display: grid;
            gap: 16px;
            max-height: calc(100vh - 36px);
            max-width: 920px;
            overflow: auto;
            padding: 18px;
            width: min(100%, 920px);
        }

        .crop-top {
            align-items: start;
            display: flex;
            gap: 16px;
            justify-content: space-between;
        }

        .crop-stage {
            align-items: center;
            background: #020617;
            border-radius: 16px;
            display: flex;
            justify-content: center;
            min-height: 280px;
            overflow: hidden;
            padding: 16px;
            position: relative;
            touch-action: none;
        }

        .crop-frame {
            border: 2px solid #fff;
            box-shadow: 0 0 0 999px rgba(2, 6, 23, .58), 0 18px 44px rgba(0, 0, 0, .3);
            cursor: grab;
            max-height: min(68vh, 620px);
            overflow: hidden;
            position: relative;
            width: min(100%, 740px);
        }

        .crop-frame.is-dragging {
            cursor: grabbing;
        }

        .crop-frame img {
            left: 50%;
            max-width: none;
            position: absolute;
            top: 50%;
            transform-origin: center;
            user-select: none;
            -webkit-user-drag: none;
        }

        .crop-controls {
            align-items: center;
            display: grid;
            gap: 10px;
            grid-template-columns: auto minmax(180px, 1fr);
        }

        .crop-controls input {
            padding: 0;
        }

        .crop-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: flex-end;
        }

        .btn-cancel {
            background: #fff1f2;
            color: var(--red-dark);
        }

        .sticky-actions {
            align-items: center;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid var(--line);
            border-radius: 16px;
            bottom: 18px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            display: flex;
            justify-content: space-between;
            padding: 14px;
            position: sticky;
        }

        @media (max-width: 820px) {
            .topbar,
            .sticky-actions,
            .card-header {
                align-items: stretch;
                flex-direction: column;
            }

            .language-grid,
            .image-grid {
                grid-template-columns: 1fr;
            }

            .crop-top,
            .crop-actions {
                align-items: stretch;
                flex-direction: column;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contenido de Presentación</h1>
                <p class="muted">Edita únicamente textos e imágenes. El diseño, colores y estructura visual del sitio se mantienen protegidos.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                Revisa los campos marcados. Hay información incompleta o archivos que no cumplen los requisitos.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.pages.presentation.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado principal</h2>
                    <p class="muted">Título y descripción visible al inicio de la página.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <div class="card-header">
                                <h3>{{ $label }}</h3>
                                <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            </div>
                            <div class="field-grid">
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[hero_title]" value="{{ old($locale.'.hero_title', $content[$locale]['hero_title']) }}">
                                    @error($locale.'.hero_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[hero_summary]">{{ old($locale.'.hero_summary', $content[$locale]['hero_summary']) }}</textarea>
                                    @error($locale.'.hero_summary')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Historia institucional</h2>
                    <p class="muted">Subtítulo, texto histórico e imagen del equipo.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <div class="card-header">
                                <h3>{{ $label }}</h3>
                                <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            </div>
                            <div class="field-grid">
                                <label>
                                    Categoría
                                    <input type="text" name="{{ $locale }}[history_badge]" value="{{ old($locale.'.history_badge', $content[$locale]['history_badge']) }}">
                                    @error($locale.'.history_badge')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[history_title]" value="{{ old($locale.'.history_title', $content[$locale]['history_title']) }}">
                                    @error($locale.'.history_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto
                                    <textarea name="{{ $locale }}[history_text]">{{ old($locale.'.history_text', $content[$locale]['history_text']) }}</textarea>
                                    @error($locale.'.history_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Misión y propósito</h2>
                    <p class="muted">Contenido de las dos tarjetas institucionales.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <div class="card-header">
                                <h3>{{ $label }}</h3>
                                <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            </div>
                            <div class="field-grid">
                                <label>
                                    Título de misión
                                    <input type="text" name="{{ $locale }}[mission_title]" value="{{ old($locale.'.mission_title', $content[$locale]['mission_title']) }}">
                                    @error($locale.'.mission_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto de misión
                                    <textarea name="{{ $locale }}[mission_text]">{{ old($locale.'.mission_text', $content[$locale]['mission_text']) }}</textarea>
                                    @error($locale.'.mission_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título de propósito
                                    <input type="text" name="{{ $locale }}[purpose_title]" value="{{ old($locale.'.purpose_title', $content[$locale]['purpose_title']) }}">
                                    @error($locale.'.purpose_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto de propósito
                                    <textarea name="{{ $locale }}[purpose_text]">{{ old($locale.'.purpose_text', $content[$locale]['purpose_text']) }}</textarea>
                                    @error($locale.'.purpose_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Dirección y equipo</h2>
                    <p class="muted">Estructura, director, correos y equipos. Escribe un elemento por línea en las listas.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <div class="card-header">
                                <h3>{{ $label }}</h3>
                                <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            </div>
                            <div class="field-grid">
                                <label>
                                    Categoría
                                    <input type="text" name="{{ $locale }}[structure_badge]" value="{{ old($locale.'.structure_badge', $content[$locale]['structure_badge']) }}">
                                    @error($locale.'.structure_badge')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título de estructura
                                    <input type="text" name="{{ $locale }}[structure_title]" value="{{ old($locale.'.structure_title', $content[$locale]['structure_title']) }}">
                                    @error($locale.'.structure_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[structure_description]">{{ old($locale.'.structure_description', $content[$locale]['structure_description']) }}</textarea>
                                    @error($locale.'.structure_description')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Áreas de la estructura
                                    <textarea name="{{ $locale }}[structure_items]">{{ old($locale.'.structure_items', $content[$locale]['structure_items']) }}</textarea>
                                    @error($locale.'.structure_items')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Director
                                    <input type="text" name="{{ $locale }}[director_name]" value="{{ old($locale.'.director_name', $content[$locale]['director_name']) }}">
                                    @error($locale.'.director_name')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título del equipo de convenios
                                    <input type="text" name="{{ $locale }}[agreements_team_title]" value="{{ old($locale.'.agreements_team_title', $content[$locale]['agreements_team_title']) }}">
                                    @error($locale.'.agreements_team_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Personas del equipo de convenios
                                    <textarea name="{{ $locale }}[agreements_team_people]">{{ old($locale.'.agreements_team_people', $content[$locale]['agreements_team_people']) }}</textarea>
                                    @error($locale.'.agreements_team_people')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título del equipo de internacionalización
                                    <input type="text" name="{{ $locale }}[projects_team_title]" value="{{ old($locale.'.projects_team_title', $content[$locale]['projects_team_title']) }}">
                                    @error($locale.'.projects_team_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Personas del equipo de internacionalización
                                    <textarea name="{{ $locale }}[projects_team_people]">{{ old($locale.'.projects_team_people', $content[$locale]['projects_team_people']) }}</textarea>
                                    @error($locale.'.projects_team_people')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="language-card" style="margin-top:18px;" data-undo-scope>
                    <div class="card-header">
                        <h3>Correos del director</h3>
                        <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    </div>
                    <label style="margin-top:14px;">
                        Correos visibles
                        <textarea name="director_emails">{{ old('director_emails', $content['director_emails']) }}</textarea>
                        <span class="hint">Escribe un correo por línea.</span>
                        @error('director_emails')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Imágenes</h2>
                    <p class="muted">Solo JPG o PNG. Tamaño máximo permitido: 10 MB por imagen.</p>
                </div>
                <div class="image-grid">
                    <div class="image-card">
                        <div class="preview preview-team" data-image-preview>
                            @if ($content['team_image_url'])
                                <img src="{{ $preview($content['team_image_url']) }}" alt="Imagen actual del equipo" data-preview-image>
                            @else
                                <span class="preview-empty" data-preview-empty>Se usará la imagen actual del sitio hasta subir una nueva.</span>
                            @endif
                            <span class="preview-ruler">4:3 portada</span>
                            <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                        </div>
                        <input type="hidden" name="team_image_remove" value="0" data-remove-image-input>
                        <label>
                            Imagen del equipo
                            <input type="file" name="team_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                            <span class="hint">La X quita la selección actual. Si guardas sin subir otra imagen, se usará la imagen base del sitio.</span>
                            @error('team_image')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                    </div>

                    <div class="image-card">
                        <div class="preview preview-director" data-image-preview>
                            @if ($content['director_image_url'])
                                <img src="{{ $preview($content['director_image_url']) }}" alt="Imagen actual del director" data-preview-image>
                            @else
                                <span class="preview-empty" data-preview-empty>Se usará la imagen actual del sitio hasta subir una nueva.</span>
                            @endif
                            <span class="preview-ruler">2:3 retrato</span>
                            <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                        </div>
                        <input type="hidden" name="director_image_remove" value="0" data-remove-image-input>
                        <label>
                            Imagen del director
                            <input type="file" name="director_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                            <span class="hint">La X quita la selección actual. Si guardas sin subir otra imagen, se usará la imagen base del sitio.</span>
                            @error('director_image')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                    </div>
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <div class="crop-modal" id="crop-modal" aria-hidden="true">
        <div class="crop-dialog" role="dialog" aria-modal="true" aria-labelledby="crop-title">
            <div class="crop-top">
                <div>
                    <h2 id="crop-title">Recortar imagen</h2>
                    <p class="muted" id="crop-help">Ajusta la imagen dentro del marco y acepta el recorte.</p>
                </div>
                <button class="btn btn-cancel" type="button" id="crop-close">Cancelar</button>
            </div>

            <div class="crop-stage">
                <div class="crop-frame" id="crop-frame">
                    <img id="crop-image" alt="Imagen para recortar">
                </div>
            </div>

            <label class="crop-controls">
                Zoom
                <input type="range" id="crop-zoom" min="1" max="3" step="0.01" value="1">
            </label>

            <div class="crop-actions">
                <button class="btn btn-secondary" type="button" id="crop-reset">Centrar</button>
                <button class="btn btn-primary" type="button" id="crop-accept">Aceptar recorte</button>
            </div>
        </div>
    </div>

    <script>
        const cleanLabelPattern = /^[\p{L}\s.,]+$/u;
        const cleanFieldNames = [
            "hero_title",
            "history_badge",
            "history_title",
            "mission_title",
            "purpose_title",
            "structure_badge",
            "structure_title",
            "director_name",
            "agreements_team_title",
            "projects_team_title",
        ];
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const imageStartSnapshots = new WeakMap();

        function editableFields(card) {
            return Array.from(card.querySelectorAll("input:not([type='file']), textarea"));
        }

        function imageCardFor(scope) {
            if (scope.matches?.(".image-card")) {
                return scope;
            }

            return scope.querySelector?.(".image-card") || null;
        }

        function imageState(scope) {
            const card = imageCardFor(scope);
            if (!card) return null;

            const preview = card.querySelector("[data-image-preview]");
            const image = preview?.querySelector("[data-preview-image]");
            const empty = preview?.querySelector("[data-preview-empty]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");

            return {
                src: image?.getAttribute("src") || "",
                imageHidden: image ? image.hidden : true,
                emptyHidden: empty ? empty.hidden : true,
                file: fileInput?.files?.[0] || null,
                removeValue: removeInput?.value || "0",
            };
        }

        function snapshotCard(card) {
            return {
                fields: editableFields(card).map((field) => ({
                    name: field.name,
                    type: field.type,
                    value: field.value,
                    checked: field.checked,
                })),
                image: imageState(card),
            };
        }

        function restoreImageState(scope, state) {
            if (!state) return;

            const card = imageCardFor(scope);
            if (!card) return;

            const preview = card.querySelector("[data-image-preview]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");
            const empty = preview?.querySelector("[data-preview-empty]");
            let image = preview?.querySelector("[data-preview-image]");

            if (image?.dataset.objectUrl) {
                URL.revokeObjectURL(image.dataset.objectUrl);
                delete image.dataset.objectUrl;
            }

            if (state.file && preview) {
                image = previewImageElement(preview);
                image.dataset.objectUrl = URL.createObjectURL(state.file);
                image.src = image.dataset.objectUrl;
                image.hidden = false;
                if (empty) empty.hidden = true;
            } else if (state.src && preview) {
                image = previewImageElement(preview);
                image.src = state.src;
                image.hidden = state.imageHidden;
                if (empty) empty.hidden = true;
            } else {
                if (image) {
                    image.removeAttribute("src");
                    image.hidden = true;
                }

                if (empty) {
                    empty.hidden = state.emptyHidden;
                } else if (preview) {
                    previewEmpty(preview);
                }
            }

            if (fileInput) {
                if (state.file) {
                    const transfer = new DataTransfer();
                    transfer.items.add(state.file);
                    fileInput.files = transfer.files;
                } else {
                    fileInput.value = "";
                }
            }

            if (removeInput) {
                removeInput.value = state.removeValue;
            }
        }

        function restoreSnapshot(card, snapshot) {
            const fields = Array.isArray(snapshot) ? snapshot : snapshot.fields;

            fields.forEach((item) => {
                const field = editableFields(card).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
                field.dispatchEvent(new Event("input", { bubbles: true }));
            });

            if (!Array.isArray(snapshot)) {
                restoreImageState(card, snapshot.image);
            }
        }

        function historyFor(card) {
            if (!cardHistory.has(card)) {
                cardHistory.set(card, []);
            }

            return cardHistory.get(card);
        }

        function setUndoState(card) {
            const undoButton = card.querySelector("[data-undo-card]");
            if (!undoButton) return;

            undoButton.disabled = historyFor(card).length === 0;
        }

        function pushSnapshot(card, snapshot = snapshotCard(card)) {
            const history = historyFor(card);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) {
                history.push(snapshot);
            }

            if (history.length > 20) {
                history.shift();
            }

            setUndoState(card);
        }

        function undoCard(card) {
            const history = historyFor(card);
            const snapshot = history.pop();

            if (!snapshot) return;

            restoreSnapshot(card, snapshot);
            editableFields(card).forEach((field) => fieldStartSnapshots.delete(field));
            setUndoState(card);
        }

        function markFieldStart(field) {
            const scope = field.closest("[data-undo-scope]");
            if (!scope || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotCard(scope));
        }

        function rememberFieldChange(field) {
            const scope = field.closest("[data-undo-scope]");
            const snapshot = fieldStartSnapshots.get(field);

            if (!scope || !snapshot) return;

            pushSnapshot(scope, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function bindUndoScope(scope) {
            if (scope.dataset.undoBound === "1") return;

            scope.dataset.undoScope = "";
            scope.dataset.undoBound = "1";
            let undoButton = scope.querySelector("[data-undo-card]");

            if (!undoButton) {
                undoButton = document.createElement("button");
                undoButton.className = "btn btn-undo undo-floating";
                undoButton.type = "button";
                undoButton.dataset.undoCard = "";
                undoButton.disabled = true;
                undoButton.title = "Deshacer último cambio";
                undoButton.setAttribute("aria-label", "Deshacer último cambio");
                undoButton.textContent = "↶";
                scope.appendChild(undoButton);
            }

            setUndoState(scope);

            undoButton.addEventListener("click", () => undoCard(scope));
            editableFields(scope).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });
        }

        function ensureLiveError(field) {
            let message = field.parentElement.querySelector(".live-error");

            if (!message) {
                message = document.createElement("span");
                message.className = "live-error";
                field.insertAdjacentElement("afterend", message);
            }

            return message;
        }

        function forbiddenCharacters(value) {
            return [...new Set([...value].filter((character) => character.trim() && !/[\p{L}.,]/u.test(character)))];
        }

        function validateCleanField(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();

            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!value) {
                return;
            }

            if (/\d/u.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "No uses números en nombres, títulos o listas.";
                return;
            }

            if (!cleanLabelPattern.test(value)) {
                const invalid = forbiddenCharacters(value).join(" ");
                field.classList.add("is-invalid");
                message.textContent = invalid
                    ? `Solo se permiten letras, espacios, puntos y comas. Quita: ${invalid}`
                    : "Solo se permiten letras, espacios, puntos y comas.";
            }
        }

        function validateEmailList(field) {
            const message = ensureLiveError(field);
            const invalidEmail = field.value
                .split(/\r?\n/)
                .map((line) => line.trim())
                .filter(Boolean)
                .find((email) => !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email));

            field.classList.toggle("is-invalid", Boolean(invalidEmail));
            message.textContent = invalidEmail ? `Corrige este correo: ${invalidEmail}` : "";
        }

        function validateImage(field) {
            const message = ensureLiveError(field);
            const file = field.files?.[0];

            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!file) {
                return;
            }

            if (!["image/jpeg", "image/png"].includes(file.type)) {
                field.classList.add("is-invalid");
                message.textContent = "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                return;
            }

            if (file.size > 10 * 1024 * 1024) {
                field.classList.add("is-invalid");
                message.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 10 MB.";
            }
        }

        function previewEmpty(preview) {
            let empty = preview.querySelector("[data-preview-empty]");

            if (!empty) {
                empty = document.createElement("span");
                empty.className = "preview-empty";
                empty.dataset.previewEmpty = "";
                empty.textContent = "Sin imagen seleccionada. Puedes subir una nueva antes de guardar.";
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function previewImageElement(preview) {
            let image = preview.querySelector("[data-preview-image]");

            if (!image) {
                image = document.createElement("img");
                image.alt = "Vista previa de la imagen seleccionada";
                image.dataset.previewImage = "";
                preview.prepend(image);
            }

            image.hidden = false;
            return image;
        }

        function clearImagePreview(card) {
            const scope = card.closest("[data-undo-scope]") || card;
            const preview = card.querySelector("[data-image-preview]");
            const image = preview.querySelector("[data-preview-image]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");

            pushSnapshot(scope);

            if (fileInput) {
                fileInput.value = "";
                fileInput.dispatchEvent(new Event("change", { bubbles: true }));
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
            const removeInput = card.querySelector("[data-remove-image-input]");

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

        function bindImageCard(card) {
            const fileInput = card.querySelector("[data-image-file]");
            const removeButton = card.querySelector("[data-remove-image]");
            const preview = card.querySelector("[data-image-preview]");

            function rememberImageStart() {
                const scope = card.closest("[data-undo-scope]") || card;
                imageStartSnapshots.set(fileInput, snapshotCard(scope));
            }

            preview?.addEventListener("click", (event) => {
                if (event.target.closest("[data-remove-image]")) {
                    return;
                }

                if (fileInput) {
                    rememberImageStart();
                }
                fileInput?.click();
            });

            removeButton?.addEventListener("click", (event) => {
                event.stopPropagation();
                clearImagePreview(card);
            });

            fileInput?.addEventListener("change", () => {
                const file = fileInput.files?.[0];

                validateImage(fileInput);

                if (!file || fileInput.classList.contains("is-invalid")) {
                    return;
                }

                openCropTool(card, file);
            });

            fileInput?.addEventListener("click", rememberImageStart);
        }

        const cropModal = document.getElementById("crop-modal");
        const cropFrame = document.getElementById("crop-frame");
        const cropImage = document.getElementById("crop-image");
        const cropZoom = document.getElementById("crop-zoom");
        const cropHelp = document.getElementById("crop-help");
        const cropAccept = document.getElementById("crop-accept");
        const cropReset = document.getElementById("crop-reset");
        const cropClose = document.getElementById("crop-close");
        const cropState = {
            card: null,
            file: null,
            objectUrl: "",
            naturalWidth: 0,
            naturalHeight: 0,
            baseScale: 1,
            zoom: 1,
            offsetX: 0,
            offsetY: 0,
            dragging: false,
            pointerX: 0,
            pointerY: 0,
        };

        function cropAspectFor(card) {
            return card.querySelector(".preview-director") ? 2 / 3 : 4 / 3;
        }

        function cropLabelFor(card) {
            return card.querySelector(".preview-director")
                ? "Marco vertical 2:3, igual al retrato del director en la página pública."
                : "Marco horizontal 4:3, igual a la tarjeta del equipo en la página pública.";
        }

        function frameSizeForAspect(aspect) {
            const availableWidth = Math.min(740, cropFrame.parentElement.clientWidth - 32);
            const availableHeight = Math.min(620, window.innerHeight * 0.58);
            let width = availableWidth;
            let height = width / aspect;

            if (height > availableHeight) {
                height = availableHeight;
                width = height * aspect;
            }

            return { width, height };
        }

        function clampCropOffsets() {
            const frameWidth = cropFrame.clientWidth;
            const frameHeight = cropFrame.clientHeight;
            const imageWidth = cropState.naturalWidth * cropState.baseScale * cropState.zoom;
            const imageHeight = cropState.naturalHeight * cropState.baseScale * cropState.zoom;
            const maxX = Math.max(0, (imageWidth - frameWidth) / 2);
            const maxY = Math.max(0, (imageHeight - frameHeight) / 2);

            cropState.offsetX = Math.min(maxX, Math.max(-maxX, cropState.offsetX));
            cropState.offsetY = Math.min(maxY, Math.max(-maxY, cropState.offsetY));
        }

        function renderCrop() {
            clampCropOffsets();
            cropImage.style.width = `${cropState.naturalWidth * cropState.baseScale * cropState.zoom}px`;
            cropImage.style.height = `${cropState.naturalHeight * cropState.baseScale * cropState.zoom}px`;
            cropImage.style.transform = `translate(calc(-50% + ${cropState.offsetX}px), calc(-50% + ${cropState.offsetY}px))`;
        }

        function resetCropPosition() {
            const frameWidth = cropFrame.clientWidth;
            const frameHeight = cropFrame.clientHeight;

            cropState.baseScale = Math.max(
                frameWidth / cropState.naturalWidth,
                frameHeight / cropState.naturalHeight
            );
            cropState.zoom = 1;
            cropState.offsetX = 0;
            cropState.offsetY = 0;
            cropZoom.value = "1";
            renderCrop();
        }

        function openCropTool(card, file) {
            const aspect = cropAspectFor(card);

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = card;
            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropHelp.textContent = cropLabelFor(card);
            cropModal.classList.add("is-open");
            cropModal.setAttribute("aria-hidden", "false");
            const size = frameSizeForAspect(aspect);
            cropFrame.style.width = `${size.width}px`;
            cropFrame.style.height = `${size.height}px`;
            cropImage.src = cropState.objectUrl;
        }

        function closeCropTool(clearSelection = false) {
            const card = cropState.card;

            cropModal.classList.remove("is-open");
            cropModal.setAttribute("aria-hidden", "true");

            if (clearSelection && card) {
                const fileInput = card.querySelector("[data-image-file]");
                if (fileInput) {
                    const scope = card.closest("[data-undo-scope]") || card;
                    const snapshot = imageStartSnapshots.get(fileInput);

                    if (snapshot) {
                        restoreImageState(scope, snapshot.image);
                        imageStartSnapshots.delete(fileInput);
                    } else {
                        fileInput.value = "";
                    }
                }
            }

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = null;
            cropState.file = null;
            cropState.objectUrl = "";
            cropImage.removeAttribute("src");
        }

        function croppedFileName(file) {
            const base = file.name.replace(/\.[^.]+$/, "") || "presentation-image";
            return `${base}-recortada.jpg`;
        }

        function acceptCrop() {
            const card = cropState.card;
            const file = cropState.file;

            if (!card || !file) return;

            const frameWidth = cropFrame.clientWidth;
            const frameHeight = cropFrame.clientHeight;
            const scale = cropState.baseScale * cropState.zoom;
            const visibleLeft = (cropState.naturalWidth * scale - frameWidth) / 2 - cropState.offsetX;
            const visibleTop = (cropState.naturalHeight * scale - frameHeight) / 2 - cropState.offsetY;
            const sourceX = Math.max(0, visibleLeft / scale);
            const sourceY = Math.max(0, visibleTop / scale);
            const sourceWidth = Math.min(cropState.naturalWidth - sourceX, frameWidth / scale);
            const sourceHeight = Math.min(cropState.naturalHeight - sourceY, frameHeight / scale);
            const outputWidth = card.querySelector(".preview-director") ? 900 : 1200;
            const outputHeight = Math.round(outputWidth / cropAspectFor(card));
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");

            canvas.width = outputWidth;
            canvas.height = outputHeight;
            context.drawImage(cropImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, outputWidth, outputHeight);

            canvas.toBlob((blob) => {
                if (!blob) return;

                const cropped = new File([blob], croppedFileName(file), { type: "image/jpeg" });
                const transfer = new DataTransfer();
                const fileInput = card.querySelector("[data-image-file]");
                const scope = card.closest("[data-undo-scope]") || card;
                const snapshot = imageStartSnapshots.get(fileInput) || snapshotCard(scope);

                transfer.items.add(cropped);
                pushSnapshot(scope, snapshot);
                fileInput.files = transfer.files;
                imageStartSnapshots.delete(fileInput);
                showSelectedImage(card, cropped);
                closeCropTool(false);
            }, "image/jpeg", .92);
        }

        cropImage.addEventListener("load", () => {
            cropState.naturalWidth = cropImage.naturalWidth;
            cropState.naturalHeight = cropImage.naturalHeight;
            resetCropPosition();
        });

        cropZoom.addEventListener("input", () => {
            cropState.zoom = Number(cropZoom.value);
            renderCrop();
        });

        cropFrame.addEventListener("pointerdown", (event) => {
            cropState.dragging = true;
            cropState.pointerX = event.clientX;
            cropState.pointerY = event.clientY;
            cropFrame.classList.add("is-dragging");
            cropFrame.setPointerCapture(event.pointerId);
        });

        cropFrame.addEventListener("pointermove", (event) => {
            if (!cropState.dragging) return;

            cropState.offsetX += event.clientX - cropState.pointerX;
            cropState.offsetY += event.clientY - cropState.pointerY;
            cropState.pointerX = event.clientX;
            cropState.pointerY = event.clientY;
            renderCrop();
        });

        cropFrame.addEventListener("pointerup", (event) => {
            cropState.dragging = false;
            cropFrame.classList.remove("is-dragging");
            cropFrame.releasePointerCapture(event.pointerId);
        });

        cropFrame.addEventListener("pointercancel", () => {
            cropState.dragging = false;
            cropFrame.classList.remove("is-dragging");
        });

        cropReset.addEventListener("click", resetCropPosition);
        cropAccept.addEventListener("click", acceptCrop);
        cropClose.addEventListener("click", () => closeCropTool(true));
        cropModal.addEventListener("click", (event) => {
            if (event.target === cropModal) {
                closeCropTool(true);
            }
        });

        window.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && cropModal.classList.contains("is-open")) {
                closeCropTool(true);
            }
        });

        document.querySelectorAll("input[type='text'], textarea").forEach((field) => {
            const shouldValidate = cleanFieldNames.some((name) => field.name.includes(`[${name}]`));

            if (shouldValidate) {
                field.addEventListener("input", () => validateCleanField(field));
                field.addEventListener("blur", () => validateCleanField(field));
            }

            if (field.name === "director_emails") {
                field.addEventListener("input", () => validateEmailList(field));
                field.addEventListener("blur", () => validateEmailList(field));
            }
        });

        document.querySelectorAll("input[type='file']").forEach((field) => {
            field.addEventListener("change", () => validateImage(field));
        });

        document.querySelectorAll(".image-card").forEach(bindImageCard);

        document.querySelectorAll("[data-undo-scope], .image-card").forEach(bindUndoScope);
    </script>
</body>
</html>
