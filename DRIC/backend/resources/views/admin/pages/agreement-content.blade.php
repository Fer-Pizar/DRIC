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
    <title>Panel DRIC - Contenido de Convenios</title>
    <style>
        :root {
            --blue: #164194;
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

        .btn-danger {
            background: #fff1f2;
            color: var(--red-dark);
        }

        .btn-undo {
            align-items: center;
            background: #eef3fb;
            color: var(--blue);
            font-size: 20px;
            font-weight: 900;
            line-height: 1;
            min-width: 40px;
            padding: 9px 12px;
            text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor;
        }

        .btn-undo:disabled {
            cursor: not-allowed;
            opacity: .42;
        }

        .undo-floating {
            position: absolute;
            right: 12px;
            top: 12px;
            z-index: 4;
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

        .language-grid,
        .media-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .hero-layout {
            display: grid;
            gap: 18px;
            grid-template-columns: minmax(0, 1.45fr) minmax(280px, 0.55fr);
        }

        .cards-grid {
            display: grid;
            gap: 18px;
        }

        .language-card,
        .media-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: none;
            padding: 18px;
            position: relative;
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
        input[type="url"],
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
            min-height: 104px;
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

        .preview {
            align-items: center;
            background: #111827;
            border: 1px solid #d6deeb;
            border-radius: 18px;
            display: flex;
            justify-content: center;
            margin-bottom: 14px;
            overflow: visible;
            position: relative;
            width: 100%;
        }

        .preview[data-image-preview] {
            cursor: pointer;
        }

        .preview-hero {
            aspect-ratio: 16 / 10;
        }

        .preview-card {
            aspect-ratio: 4 / 3;
        }

        .preview img {
            border-radius: inherit;
            height: 100%;
            object-fit: cover;
            width: 100%;
        }

        .preview-empty {
            color: rgba(255,255,255,.72);
            padding: 18px;
            text-align: center;
        }

        .preview-ruler {
            align-items: center;
            background: rgba(2,6,23,.76);
            border: 1px solid rgba(255,255,255,.16);
            border-radius: 999px;
            color: #fff;
            display: inline-flex;
            font-size: 11px;
            font-weight: 900;
            gap: 6px;
            left: 10px;
            line-height: 1;
            padding: 7px 10px;
            position: absolute;
            top: 10px;
        }

        .preview-ruler::before {
            content: "";
            background: repeating-linear-gradient(90deg, #fff 0 1px, transparent 1px 7px);
            display: block;
            height: 10px;
            opacity: .82;
            width: 34px;
        }

        .btn-image-remove {
            align-items: center;
            background: rgba(127,0,16,.96);
            border: 2px solid rgba(255,255,255,.92);
            border-radius: 999px;
            box-shadow: 0 8px 20px rgba(15,23,42,.22);
            color: #fff;
            display: inline-flex;
            font-size: 20px;
            font-weight: 900;
            height: 32px;
            justify-content: center;
            line-height: 1;
            padding: 0;
            position: absolute;
            right: -8px;
            top: -8px;
            width: 32px;
            z-index: 5;
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

        .subpage-actions {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .subpage-card {
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 18px;
        }

        .crop-modal { align-items: center; background: rgba(2,6,23,.78); display: none; inset: 0; justify-content: center; padding: 18px; position: fixed; z-index: 50; }
        .crop-modal.is-open { display: flex; }
        .crop-dialog { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 30px 90px rgba(0,0,0,.34); display: grid; gap: 16px; max-height: calc(100vh - 36px); max-width: 920px; overflow: auto; padding: 18px; width: min(100%, 920px); }
        .crop-top { align-items: start; display: flex; gap: 16px; justify-content: space-between; }
        .crop-stage { align-items: center; background: #020617; border-radius: 16px; display: flex; justify-content: center; min-height: 280px; overflow: hidden; padding: 16px; position: relative; touch-action: none; }
        .crop-frame { border: 2px solid #fff; box-shadow: 0 0 0 999px rgba(2,6,23,.58), 0 18px 44px rgba(0,0,0,.3); cursor: grab; max-height: min(68vh, 620px); overflow: hidden; position: relative; width: min(100%, 740px); }
        .crop-frame.is-dragging { cursor: grabbing; }
        .crop-frame img { left: 50%; max-width: none; position: absolute; top: 50%; transform-origin: center; user-select: none; -webkit-user-drag: none; }
        .crop-controls { align-items: center; display: grid; gap: 10px; grid-template-columns: auto minmax(180px, 1fr); }
        .crop-controls input { padding: 0; }
        .crop-actions { display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end; }

        @media (max-width: 820px) {
            .topbar,
            .sticky-actions,
            .card-header {
                align-items: stretch;
                flex-direction: column;
            }

            .language-grid,
            .media-grid,
            .hero-layout,
            .subpage-actions {
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
                <h1>Contenido de Convenios</h1>
                <p class="muted">Administra textos, enlaces, PDF e imágenes de la página general de Convenios. El diseño del sitio no se modifica desde aquí.</p>
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
                Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.pages.agreements.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado principal</h2>
                    <p class="muted">Primera vista de la página pública: texto superior, botón de procedimiento e imagen principal.</p>
                </div>
                <div class="hero-layout">
                    <div class="field-grid">
                        <div class="language-grid">
                            @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                <div class="language-card">
                                    <h3>{{ $label }}</h3>
                                    <div class="field-grid">
                                        <label>
                                            Categoría
                                            <input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">
                                            @error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                        <label>
                                            Título
                                            <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                            @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                        <label>
                                            Primer párrafo
                                            <textarea name="{{ $locale }}[intro_one]">{{ old($locale.'.intro_one', $content[$locale]['intro_one']) }}</textarea>
                                            @error($locale.'.intro_one')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                        <label>
                                            Segundo párrafo
                                            <textarea name="{{ $locale }}[intro_two]">{{ old($locale.'.intro_two', $content[$locale]['intro_two']) }}</textarea>
                                            @error($locale.'.intro_two')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="language-card">
                            <h3>Botón de procedimiento</h3>
                            <div class="language-grid" style="margin-top:14px;">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <label>
                                        Texto {{ strtolower($label) }}
                                        <input type="text" name="{{ $locale }}[procedure_label]" value="{{ old($locale.'.procedure_label', $content[$locale]['procedure_label']) }}">
                                        @error($locale.'.procedure_label')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                @endforeach
                            </div>
                            <div class="field-grid" style="margin-top:14px;">
                                <label>
                                    URL del PDF
                                    <input type="url" name="procedure_url" value="{{ old('procedure_url', $content['procedure_url']) }}" placeholder="https://sitio.edu.bo/documento.pdf">
                                    <span class="hint">Usa este campo si el PDF está alojado en otra página.</span>
                                    @error('procedure_url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Subir PDF
                                    <input type="file" name="procedure_pdf" accept=".pdf,application/pdf">
                                    <span class="hint">Solo PDF. Tamaño máximo: 20 MB. @if ($content['procedure_pdf_url']) PDF actual: <a href="{{ $content['procedure_pdf_url'] }}" target="_blank">abrir archivo</a>. @endif</span>
                                    @error('procedure_pdf')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="media-card" data-image-card data-crop-aspect="1.6" data-crop-label="Marco 16:10, similar a la imagen principal de Convenios.">
                        <div class="card-header">
                            <h3>Imagen principal</h3>
                            <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                        </div>
                        <div class="preview preview-hero" data-image-preview>
                            @if ($content['hero_image_url'])
                                <img src="{{ $preview($content['hero_image_url']) }}" alt="Imagen principal" data-preview-image>
                            @else
                                <span class="preview-empty" data-preview-empty>Se usará la imagen actual del sitio hasta subir una nueva.</span>
                            @endif
                            <span class="preview-ruler">16:10 principal</span>
                            <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                        </div>
                        <input type="hidden" name="hero_image_remove" value="0" data-remove-image-input>
                        <label>
                            Subir nueva imagen
                            <input type="file" name="hero_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                            <span class="hint">JPG o PNG. Máximo 5 MB.</span>
                            @error('hero_image')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas de acceso</h2>
                    <p class="muted">Segunda parte de la página pública: tres tarjetas con imagen, texto, enlace y etiqueta común del botón.</p>
                </div>
                <div class="language-card">
                    <h3>Texto del botón de las tarjetas</h3>
                    <div class="language-grid" style="margin-top:14px;">
                        @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                            <label>
                                Texto {{ strtolower($label) }}
                                <input type="text" name="{{ $locale }}[main_button]" value="{{ old($locale.'.main_button', $content[$locale]['main_button']) }}">
                                @error($locale.'.main_button')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="cards-grid">
                    @foreach ([1, 2, 3] as $index)
                        <div class="language-card">
                            <div class="card-header">
                                <h3>Tarjeta {{ $index }}</h3>
                                <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            </div>
                            <div class="media-card" style="margin-top:14px;" data-image-card data-crop-aspect="1.333333" data-crop-label="Marco 4:3, igual al área de imagen de las tarjetas de Convenios.">
                                <div class="preview preview-card" data-image-preview>
                                    @if ($content['card_'.$index.'_image_url'])
                                        <img src="{{ $preview($content['card_'.$index.'_image_url']) }}" alt="Imagen de tarjeta {{ $index }}" data-preview-image>
                                    @else
                                        <span class="preview-empty" data-preview-empty>Se usará la imagen actual del sitio hasta subir una nueva.</span>
                                    @endif
                                    <span class="preview-ruler">4:3 tarjeta</span>
                                    <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                </div>
                                <input type="hidden" name="card_{{ $index }}_image_remove" value="0" data-remove-image-input>
                                <label>
                                    Imagen de la tarjeta
                                    <input type="file" name="card_{{ $index }}_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                                    <span class="hint">JPG o PNG. Máximo 5 MB.</span>
                                    @error('card_'.$index.'_image')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                            <div class="language-grid" style="margin-top:14px;">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="field-grid">
                                        <h3>{{ $label }}</h3>
                                        <label>
                                            Título
                                            <input type="text" name="{{ $locale }}[card_{{ $index }}_title]" value="{{ old($locale.'.card_'.$index.'_title', $content[$locale]['card_'.$index.'_title']) }}">
                                            @error($locale.'.card_'.$index.'_title')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                        <label>
                                            Descripción
                                            <textarea name="{{ $locale }}[card_{{ $index }}_description]">{{ old($locale.'.card_'.$index.'_description', $content[$locale]['card_'.$index.'_description']) }}</textarea>
                                            @error($locale.'.card_'.$index.'_description')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="field-grid" style="margin-top:14px;">
                                <label>
                                    Destino del botón de la tarjeta
                                    <input type="text" name="card_{{ $index }}_href" value="{{ old('card_'.$index.'_href', $content['card_'.$index.'_href']) }}">
                                    <span class="hint">Puedes usar una URL completa o una ruta interna como /convenios/otros.</span>
                                    @error('card_'.$index.'_href')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Subpáginas de convenios</h2>
                    <p class="muted">Administra las listas de documentos que se abren desde las tarjetas de esta página.</p>
                </div>
                <div class="subpage-actions">
                    <div class="subpage-card">
                        <h3>Otros convenios suscritos</h3>
                        <p class="muted">Agrega, edita o quita documentos con título y URL para /convenios/otros.</p>
                        <div class="actions" style="margin-top:14px;">
                            <a class="btn btn-primary" href="{{ route('admin.agreement-lists.edit', 'otros') }}">Editar lista</a>
                        </div>
                    </div>
                    <div class="subpage-card">
                        <h3>Convenios CEUB y Gobierno de Bolivia</h3>
                        <p class="muted">Agrega, edita o quita documentos con título y URL para /convenios/ceub-gobierno.</p>
                        <div class="actions" style="margin-top:14px;">
                            <a class="btn btn-primary" href="{{ route('admin.agreement-lists.edit', 'ceub-gobierno') }}">Editar lista</a>
                        </div>
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
                <button class="btn btn-danger" type="button" id="crop-close">Cancelar</button>
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
            "eyebrow",
            "title",
            "main_button",
            "procedure_label",
            "card_1_title",
            "card_2_title",
            "card_3_title",
        ];
        const maxImageBytes = 5 * 1024 * 1024;
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();

        function editableFields(card) {
            return Array.from(card.querySelectorAll("input:not([type='file']), textarea"));
        }

        function imageState(card) {
            const imageCard = card.matches("[data-image-card]") ? card : card.querySelector("[data-image-card]");
            const preview = imageCard?.querySelector("[data-image-preview]");
            const image = preview?.querySelector("[data-preview-image]");
            const empty = preview?.querySelector("[data-preview-empty]");
            const fileInput = imageCard?.querySelector("[data-image-file]");
            const removeInput = imageCard?.querySelector("[data-remove-image-input]");

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

        function restoreImageState(card, state) {
            if (!state) return;

            const imageCard = card.matches("[data-image-card]") ? card : card.querySelector("[data-image-card]");
            const preview = imageCard?.querySelector("[data-image-preview]");
            const fileInput = imageCard?.querySelector("[data-image-file]");
            const removeInput = imageCard?.querySelector("[data-remove-image-input]");
            if (!imageCard || !preview) return;

            const image = previewImageElement(preview);
            const empty = preview.querySelector("[data-preview-empty]");

            if (state.file) {
                if (image.dataset.objectUrl) {
                    URL.revokeObjectURL(image.dataset.objectUrl);
                }
                image.dataset.objectUrl = URL.createObjectURL(state.file);
                image.src = image.dataset.objectUrl;
                image.hidden = Boolean(state.imageHidden);
                if (empty) empty.hidden = true;
            } else if (state.src) {
                image.src = state.src;
                image.hidden = Boolean(state.imageHidden);
                if (empty) empty.hidden = true;
            } else {
                image.removeAttribute("src");
                image.hidden = true;
                if (empty) empty.hidden = Boolean(state.emptyHidden);
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
                removeInput.value = state.removeValue || "0";
            }
        }

        function restoreSnapshot(card, snapshot) {
            snapshot.fields.forEach((item) => {
                const field = editableFields(card).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
            });
            restoreImageState(card, snapshot.image);
        }

        function historyFor(card) {
            if (!cardHistory.has(card)) {
                cardHistory.set(card, []);
            }

            return cardHistory.get(card);
        }

        function setUndoState(card) {
            const button = card.querySelector("[data-undo-card]");
            if (!button) return;

            button.disabled = historyFor(card).length === 0;
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
            const snapshot = historyFor(card).pop();
            if (!snapshot) return;

            restoreSnapshot(card, snapshot);
            editableFields(card).forEach((field) => fieldStartSnapshots.delete(field));
            setUndoState(card);
        }

        function markFieldStart(field) {
            const card = field.closest(".language-card, .media-card");
            if (!card || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotCard(card));
        }

        function rememberFieldChange(field) {
            const card = field.closest(".language-card, .media-card");
            const snapshot = fieldStartSnapshots.get(field);
            if (!card || !snapshot) return;

            pushSnapshot(card, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function bindUndoCard(card) {
            if (card.dataset.undoBound === "1") return;
            card.dataset.undoBound = "1";

            if (!card.querySelector("[data-undo-card]") && editableFields(card).length > 0) {
                const button = document.createElement("button");
                button.className = "btn btn-undo undo-floating";
                button.type = "button";
                button.dataset.undoCard = "";
                button.disabled = true;
                button.title = "Deshacer último cambio";
                button.setAttribute("aria-label", "Deshacer último cambio");
                button.textContent = "↶";
                card.appendChild(button);
            }

            card.querySelector("[data-undo-card]")?.addEventListener("click", () => undoCard(card));
            editableFields(card).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });
            setUndoState(card);
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
                message.textContent = "No uses números en títulos o categorías.";
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

        function validateUpload(field) {
            const message = ensureLiveError(field);
            const file = field.files?.[0];

            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!file) {
                return;
            }

            const isPdf = field.name === "procedure_pdf";
            const validTypes = isPdf ? ["application/pdf"] : ["image/jpeg", "image/png"];

            if (!validTypes.includes(file.type)) {
                field.classList.add("is-invalid");
                message.textContent = isPdf
                    ? "Ese formato no está permitido. Solo se aceptan archivos PDF."
                    : "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                return;
            }

            const maxSize = isPdf ? 20 * 1024 * 1024 : 5 * 1024 * 1024;

            if (file.size > maxSize) {
                field.classList.add("is-invalid");
                message.textContent = isPdf
                    ? "El PDF es demasiado pesado. El tamaño máximo permitido es 20 MB."
                    : "La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.";
            }
        }

        function imageErrorFor(input) {
            return ensureLiveError(input);
        }

        function validateImageInput(input) {
            const file = input.files?.[0];
            const message = imageErrorFor(input);
            input.classList.remove("is-invalid");
            message.textContent = "";

            if (!file) return false;

            if (!["image/jpeg", "image/png"].includes(file.type)) {
                input.classList.add("is-invalid");
                message.textContent = "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                input.value = "";
                return false;
            }

            if (file.size > maxImageBytes) {
                input.classList.add("is-invalid");
                message.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.";
                input.value = "";
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
                empty.textContent = "Sin imagen seleccionada.";
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function imageUndoScope(card) {
            const outerCard = card.parentElement?.closest(".language-card");
            return outerCard || card.closest(".media-card");
        }

        function clearImagePreview(card) {
            const undoCard = imageUndoScope(card);
            const preview = card.querySelector("[data-image-preview]");
            const image = preview.querySelector("[data-preview-image]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");

            pushSnapshot(undoCard);

            if (fileInput) {
                fileInput.value = "";
                imageErrorFor(fileInput).textContent = "";
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
            if (!card || card.dataset.imageBound === "1") return;
            card.dataset.imageBound = "1";

            const fileInput = card.querySelector("[data-image-file]");
            const removeButton = card.querySelector("[data-remove-image]");
            const preview = card.querySelector("[data-image-preview]");

            function requestImageFile() {
                if (!fileInput) return;
                fileInput.click();
            }

            preview?.addEventListener("click", (event) => {
                if (event.target.closest("[data-remove-image]")) return;
                requestImageFile();
            });

            removeButton?.addEventListener("click", (event) => {
                event.stopPropagation();
                clearImagePreview(card);
            });

            fileInput?.addEventListener("change", () => {
                if (!validateImageInput(fileInput)) return;
                openCropTool(card, fileInput.files[0]);
            });
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
            return Number(card.dataset.cropAspect || "1.333333");
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
            const imageWidth = cropState.naturalWidth * cropState.baseScale * cropState.zoom;
            const imageHeight = cropState.naturalHeight * cropState.baseScale * cropState.zoom;
            const maxX = Math.max(0, (imageWidth - cropFrame.clientWidth) / 2);
            const maxY = Math.max(0, (imageHeight - cropFrame.clientHeight) / 2);

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
            cropState.baseScale = Math.max(
                cropFrame.clientWidth / cropState.naturalWidth,
                cropFrame.clientHeight / cropState.naturalHeight
            );
            cropState.zoom = 1;
            cropState.offsetX = 0;
            cropState.offsetY = 0;
            cropZoom.value = "1";
            renderCrop();
        }

        function openCropTool(card, file) {
            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = card;
            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropHelp.textContent = card.dataset.cropLabel || "Ajusta la imagen dentro del marco y acepta el recorte.";
            cropModal.classList.add("is-open");
            cropModal.setAttribute("aria-hidden", "false");

            const size = frameSizeForAspect(cropAspectFor(card));
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
                if (fileInput) fileInput.value = "";
            }

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = null;
            cropState.file = null;
            cropState.objectUrl = "";
            cropImage.removeAttribute("src");
        }

        function acceptCrop() {
            const card = cropState.card;
            const file = cropState.file;
            if (!card || !file) return;

            const aspect = cropAspectFor(card);
            const scale = cropState.baseScale * cropState.zoom;
            const visibleLeft = (cropState.naturalWidth * scale - cropFrame.clientWidth) / 2 - cropState.offsetX;
            const visibleTop = (cropState.naturalHeight * scale - cropFrame.clientHeight) / 2 - cropState.offsetY;
            const sourceX = Math.max(0, visibleLeft / scale);
            const sourceY = Math.max(0, visibleTop / scale);
            const sourceWidth = Math.min(cropState.naturalWidth - sourceX, cropFrame.clientWidth / scale);
            const sourceHeight = Math.min(cropState.naturalHeight - sourceY, cropFrame.clientHeight / scale);
            const outputWidth = 1200;
            const outputHeight = Math.round(outputWidth / aspect);
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");
            const base = file.name.replace(/\.[^.]+$/, "") || "agreement-image";

            canvas.width = outputWidth;
            canvas.height = outputHeight;
            context.drawImage(cropImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, outputWidth, outputHeight);

            canvas.toBlob((blob) => {
                if (!blob) return;

                const cropped = new File([blob], `${base}-recortada.jpg`, { type: "image/jpeg" });
                const transfer = new DataTransfer();
                const fileInput = card.querySelector("[data-image-file]");

                transfer.items.add(cropped);
                fileInput.files = transfer.files;
                showSelectedImage(card, cropped);
                imageErrorFor(fileInput).textContent = "";
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
            if (event.target === cropModal) closeCropTool(true);
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
        });

        document.querySelectorAll("input[type='file']").forEach((field) => {
            if (field.dataset.imageFile !== undefined) return;
            field.addEventListener("change", () => validateUpload(field));
        });

        document.querySelectorAll(".language-card, .media-card").forEach(bindUndoCard);
        document.querySelectorAll("[data-image-card]").forEach(bindImageCard);
    </script>
</body>
</html>
