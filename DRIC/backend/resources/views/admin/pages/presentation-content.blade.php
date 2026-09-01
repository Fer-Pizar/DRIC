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
            border: 1px solid #fecdd3;
            color: #9f1239;
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
        }

        .preview {
            align-items: center;
            background: #e8edf5;
            border-radius: 14px;
            display: flex;
            height: 190px;
            justify-content: center;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .preview img {
            height: 100%;
            object-fit: cover;
            width: 100%;
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
            .sticky-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .language-grid,
            .image-grid {
                grid-template-columns: 1fr;
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
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[hero_title]" value="{{ old($locale.'.hero_title', $content[$locale]['hero_title']) }}">
                                    @error($locale.'.hero_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[hero_summary]">{{ old($locale.'.hero_summary', $content[$locale]['hero_summary']) }}</textarea>
                                    @error($locale.'.hero_summary')<span class="hint">{{ $message }}</span>@enderror
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
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Categoría
                                    <input type="text" name="{{ $locale }}[history_badge]" value="{{ old($locale.'.history_badge', $content[$locale]['history_badge']) }}">
                                    @error($locale.'.history_badge')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[history_title]" value="{{ old($locale.'.history_title', $content[$locale]['history_title']) }}">
                                    @error($locale.'.history_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto
                                    <textarea name="{{ $locale }}[history_text]">{{ old($locale.'.history_text', $content[$locale]['history_text']) }}</textarea>
                                    @error($locale.'.history_text')<span class="hint">{{ $message }}</span>@enderror
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
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título de misión
                                    <input type="text" name="{{ $locale }}[mission_title]" value="{{ old($locale.'.mission_title', $content[$locale]['mission_title']) }}">
                                    @error($locale.'.mission_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto de misión
                                    <textarea name="{{ $locale }}[mission_text]">{{ old($locale.'.mission_text', $content[$locale]['mission_text']) }}</textarea>
                                    @error($locale.'.mission_text')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título de propósito
                                    <input type="text" name="{{ $locale }}[purpose_title]" value="{{ old($locale.'.purpose_title', $content[$locale]['purpose_title']) }}">
                                    @error($locale.'.purpose_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto de propósito
                                    <textarea name="{{ $locale }}[purpose_text]">{{ old($locale.'.purpose_text', $content[$locale]['purpose_text']) }}</textarea>
                                    @error($locale.'.purpose_text')<span class="hint">{{ $message }}</span>@enderror
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
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Categoría
                                    <input type="text" name="{{ $locale }}[structure_badge]" value="{{ old($locale.'.structure_badge', $content[$locale]['structure_badge']) }}">
                                    @error($locale.'.structure_badge')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título de estructura
                                    <input type="text" name="{{ $locale }}[structure_title]" value="{{ old($locale.'.structure_title', $content[$locale]['structure_title']) }}">
                                    @error($locale.'.structure_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[structure_description]">{{ old($locale.'.structure_description', $content[$locale]['structure_description']) }}</textarea>
                                    @error($locale.'.structure_description')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Áreas de la estructura
                                    <textarea name="{{ $locale }}[structure_items]">{{ old($locale.'.structure_items', $content[$locale]['structure_items']) }}</textarea>
                                    @error($locale.'.structure_items')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Director
                                    <input type="text" name="{{ $locale }}[director_name]" value="{{ old($locale.'.director_name', $content[$locale]['director_name']) }}">
                                    @error($locale.'.director_name')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título del equipo de convenios
                                    <input type="text" name="{{ $locale }}[agreements_team_title]" value="{{ old($locale.'.agreements_team_title', $content[$locale]['agreements_team_title']) }}">
                                    @error($locale.'.agreements_team_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Personas del equipo de convenios
                                    <textarea name="{{ $locale }}[agreements_team_people]">{{ old($locale.'.agreements_team_people', $content[$locale]['agreements_team_people']) }}</textarea>
                                    @error($locale.'.agreements_team_people')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título del equipo de internacionalización
                                    <input type="text" name="{{ $locale }}[projects_team_title]" value="{{ old($locale.'.projects_team_title', $content[$locale]['projects_team_title']) }}">
                                    @error($locale.'.projects_team_title')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Personas del equipo de internacionalización
                                    <textarea name="{{ $locale }}[projects_team_people]">{{ old($locale.'.projects_team_people', $content[$locale]['projects_team_people']) }}</textarea>
                                    @error($locale.'.projects_team_people')<span class="hint">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="language-card" style="margin-top:18px;">
                    <h3>Correos del director</h3>
                    <label style="margin-top:14px;">
                        Correos visibles
                        <textarea name="director_emails">{{ old('director_emails', $content['director_emails']) }}</textarea>
                        <span class="hint">Escribe un correo por línea.</span>
                        @error('director_emails')<span class="hint">{{ $message }}</span>@enderror
                    </label>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Imágenes</h2>
                    <p class="muted">Solo JPG o PNG. Tamaño máximo permitido: 3 MB por imagen.</p>
                </div>
                <div class="image-grid">
                    <div class="image-card">
                        <div class="preview">
                            @if ($content['team_image_url'])
                                <img src="{{ $content['team_image_url'] }}" alt="Imagen actual del equipo">
                            @else
                                <span class="muted">Se usará la imagen actual del sitio hasta subir una nueva.</span>
                            @endif
                        </div>
                        <label>
                            Imagen del equipo
                            <input type="file" name="team_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <span class="hint">No se eliminará la imagen anterior hasta guardar una nueva.</span>
                            @error('team_image')<span class="hint">{{ $message }}</span>@enderror
                        </label>
                    </div>

                    <div class="image-card">
                        <div class="preview">
                            @if ($content['director_image_url'])
                                <img src="{{ $content['director_image_url'] }}" alt="Imagen actual del director">
                            @else
                                <span class="muted">Se usará la imagen actual del sitio hasta subir una nueva.</span>
                            @endif
                        </div>
                        <label>
                            Imagen del director
                            <input type="file" name="director_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                            <span class="hint">No se eliminará la imagen anterior hasta guardar una nueva.</span>
                            @error('director_image')<span class="hint">{{ $message }}</span>@enderror
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
</body>
</html>
