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
    <title>Panel DRIC - Contenido de Proyectos</title>
    <style>
        :root {
            --blue: #164194;
            --red-dark: #7f0010;
            --ink: #172033;
            --muted: #647084;
            --line: #e5e9f0;
        }

        * { box-sizing: border-box; }

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

        h1, h2, h3 { margin: 0; }

        h1 { font-size: 34px; line-height: 1.1; }
        h2 { font-size: 22px; }
        h3 { color: var(--blue); font-size: 18px; }

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

        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-danger { background: #fff1f2; color: var(--red-dark); }
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .undo-floating { position: absolute; right: 12px; top: 12px; z-index: 4; }
        .media-card > .undo-floating { right: -10px; top: -10px; z-index: 6; }

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

        .panel { padding: 24px; }

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

        .cards-grid,
        .field-grid {
            display: grid;
            gap: 14px;
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
            min-height: 112px;
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

        .live-error:empty { display: none; }

        .is-invalid {
            border-color: var(--red-dark) !important;
            box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10);
        }

        .preview {
            align-items: center;
            background: #111827;
            border: 1px solid #d6deeb;
            border-radius: 16px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            margin-bottom: 14px;
            overflow: hidden;
            position: relative;
            width: 100%;
        }

        .preview-project-card {
            aspect-ratio: 2 / 1;
            min-height: 180px;
        }

        .preview img {
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
            background: repeating-linear-gradient(90deg, #fff 0 1px, transparent 1px 7px);
            content: "";
            display: block;
            height: 10px;
            opacity: .82;
            width: 34px;
        }

        .btn-image-remove {
            align-items: center;
            background: rgba(127,0,16,.92);
            border: 2px solid rgba(255,255,255,.88);
            border-radius: 999px;
            color: #fff;
            display: inline-flex;
            font-size: 20px;
            font-weight: 900;
            height: 32px;
            justify-content: center;
            line-height: 1;
            padding: 0;
            position: absolute;
            right: 10px;
            top: 10px;
            width: 32px;
            z-index: 3;
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
            .sticky-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .language-grid,
            .media-grid {
                grid-template-columns: 1fr;
            }

            h1 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contenido de Proyectos</h1>
                <p class="muted">Administra textos, enlaces, PDF e imágenes de la página general de Proyectos. El diseño del sitio no se modifica desde aquí.</p>
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
            <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div>
        @endif

        <form method="POST" action="{{ route('admin.pages.projects.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado principal</h2>
                    <p class="muted">Texto principal de la página pública.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                    @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>
                                    @error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto del botón de procedimiento
                                    <input type="text" name="{{ $locale }}[procedure_label]" value="{{ old($locale.'.procedure_label', $content[$locale]['procedure_label']) }}">
                                    @error($locale.'.procedure_label')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>PDF de procedimiento</h2>
                    <p class="muted">Puedes usar una URL externa o subir un PDF. Si subes un PDF nuevo, ese archivo tendrá prioridad.</p>
                </div>
                <div class="language-card">
                    <div class="field-grid">
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
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas de acceso</h2>
                    <p class="muted">Edita el texto, destino e imagen de cada tarjeta.</p>
                </div>
                <div class="cards-grid">
                    @foreach ([1, 2] as $index)
                        <div class="language-card">
                            <h3>Tarjeta {{ $index }}</h3>
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
                                        <label>
                                            Texto del botón
                                            <input type="text" name="{{ $locale }}[card_{{ $index }}_button]" value="{{ old($locale.'.card_'.$index.'_button', $content[$locale]['card_'.$index.'_button']) }}">
                                            @error($locale.'.card_'.$index.'_button')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="field-grid" style="margin-top:14px;">
                                <label>
                                    Destino del botón de la tarjeta
                                    <input type="text" name="card_{{ $index }}_href" value="{{ old('card_'.$index.'_href', $content['card_'.$index.'_href']) }}">
                                    <span class="hint">Puedes usar una URL completa o una ruta interna como apoyo-financiero.</span>
                                    @error('card_'.$index.'_href')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <div class="media-card" data-image-card data-crop-aspect="2" data-crop-label="Marco ancho 2:1, similar a la imagen superior de la tarjeta pública de Proyectos.">
                                    <div class="preview preview-project-card" data-image-preview>
                                        @if ($content['card_'.$index.'_image_url'])
                                            <img src="{{ $preview($content['card_'.$index.'_image_url']) }}" alt="Imagen de la tarjeta {{ $index }}" data-preview-image>
                                        @else
                                            <span class="preview-empty" data-preview-empty>Se usará la imagen actual del sitio hasta subir una nueva.</span>
                                        @endif
                                        <span class="preview-ruler">2:1 tarjeta</span>
                                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                    </div>
                                    <input type="hidden" name="card_{{ $index }}_image_remove" value="0" data-remove-image-input>
                                    <label>
                                        Imagen de la tarjeta {{ $index }}
                                        <input type="file" name="card_{{ $index }}_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                                        <span class="hint">La X quita la selección actual. Solo JPG o PNG. Tamaño máximo: 10 MB.</span>
                                        @error('card_'.$index.'_image')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Subpágina de proyectos</h2>
                    <p class="muted">Administra el contenido de la vista que se abre desde la tarjeta de Apoyo Financiero.</p>
                </div>
                <div class="subpage-card">
                    <h3>Apoyo Financiero</h3>
                    <p class="muted">Edita textos, métricas, botón oficial y documentos de la convocatoria.</p>
                    <div class="actions" style="margin-top:14px;">
                        <a class="btn btn-primary" href="{{ route('admin.project-funding.edit') }}">Editar contenido</a>
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
            "title",
            "procedure_label",
            "card_1_title",
            "card_1_button",
            "card_2_title",
            "card_2_button",
        ];
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const imageStartSnapshots = new WeakMap();
        const maxImageBytes = 10 * 1024 * 1024;
        const maxPdfBytes = 20 * 1024 * 1024;

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll("input:not([type='file']), textarea"));
        }

        function imageCardFor(scope) {
            if (scope.matches?.("[data-image-card]")) {
                return scope;
            }

            return scope.querySelector?.("[data-image-card]") || null;
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

        function snapshotScope(scope) {
            return {
                fields: editableFields(scope).map((field) => ({
                    name: field.name,
                    type: field.type,
                    value: field.value,
                    checked: field.checked,
                })),
                image: imageState(scope),
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

                ensureLiveError(fileInput).textContent = "";
            }

            if (removeInput) {
                removeInput.value = state.removeValue;
            }
        }

        function restoreSnapshot(scope, snapshot) {
            const fields = Array.isArray(snapshot) ? snapshot : snapshot.fields;

            fields.forEach((item) => {
                const field = editableFields(scope).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
                field.dispatchEvent(new Event("input", { bubbles: true }));
            });

            if (!Array.isArray(snapshot)) {
                restoreImageState(scope, snapshot.image);
            }
        }

        function historyFor(scope) {
            if (!cardHistory.has(scope)) {
                cardHistory.set(scope, []);
            }

            return cardHistory.get(scope);
        }

        function setUndoState(scope) {
            const button = scope.querySelector(":scope > [data-undo-card]");
            if (!button) return;

            button.disabled = historyFor(scope).length === 0;
        }

        function pushSnapshot(scope, snapshot = snapshotScope(scope)) {
            const history = historyFor(scope);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) {
                history.push(snapshot);
            }

            if (history.length > 20) {
                history.shift();
            }

            setUndoState(scope);
        }

        function undoScope(scope) {
            const snapshot = historyFor(scope).pop();
            if (!snapshot) return;

            restoreSnapshot(scope, snapshot);
            editableFields(scope).forEach((field) => fieldStartSnapshots.delete(field));
            setUndoState(scope);
        }

        function markFieldStart(field) {
            const scope = field.closest("[data-undo-scope]");
            if (!scope || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotScope(scope));
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

            const button = document.createElement("button");
            button.className = "btn btn-undo undo-floating";
            button.type = "button";
            button.dataset.undoCard = "";
            button.disabled = true;
            button.title = "Deshacer último cambio";
            button.setAttribute("aria-label", "Deshacer último cambio");
            button.textContent = "↶";
            scope.appendChild(button);

            button.addEventListener("click", () => undoScope(scope));

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
                message.textContent = "No uses números en títulos.";
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
                return false;
            }

            const isPdf = field.name === "procedure_pdf";
            const validTypes = isPdf ? ["application/pdf"] : ["image/jpeg", "image/png"];

            if (!validTypes.includes(file.type)) {
                field.classList.add("is-invalid");
                message.textContent = isPdf
                    ? "Ese formato no está permitido. Solo se aceptan archivos PDF."
                    : "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                field.value = "";
                return false;
            }

            const maxSize = isPdf ? maxPdfBytes : maxImageBytes;

            if (file.size > maxSize) {
                field.classList.add("is-invalid");
                message.textContent = isPdf
                    ? "El PDF es demasiado pesado. El tamaño máximo permitido es 20 MB."
                    : "La imagen es demasiado pesada. El tamaño máximo permitido es 10 MB.";
                field.value = "";
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
                ensureLiveError(fileInput).textContent = "";
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
            if (card.dataset.imageBound === "1") return;
            card.dataset.imageBound = "1";

            const fileInput = card.querySelector("[data-image-file]");
            const removeButton = card.querySelector("[data-remove-image]");
            const preview = card.querySelector("[data-image-preview]");

            function rememberImageStart() {
                const scope = card.closest("[data-undo-scope]") || card;
                imageStartSnapshots.set(fileInput, snapshotScope(scope));
            }

            preview?.addEventListener("click", (event) => {
                if (event.target.closest("[data-remove-image]")) return;

                if (fileInput) {
                    rememberImageStart();
                }

                fileInput?.click();
            });

            removeButton?.addEventListener("click", (event) => {
                event.stopPropagation();
                clearImagePreview(card);
            });

            fileInput?.addEventListener("click", rememberImageStart);
            fileInput?.addEventListener("change", () => {
                if (!validateUpload(fileInput)) return;
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
            return Number(card.dataset.cropAspect || "2");
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
            const aspect = cropAspectFor(card);

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = card;
            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropHelp.textContent = card.dataset.cropLabel || "Ajusta la imagen dentro del marco y acepta el recorte.";
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
            const base = file.name.replace(/\.[^.]+$/, "") || "project-image";
            return `${base}-recortada.jpg`;
        }

        function acceptCrop() {
            const card = cropState.card;
            const file = cropState.file;
            if (!card || !file) return;

            const scale = cropState.baseScale * cropState.zoom;
            const visibleLeft = (cropState.naturalWidth * scale - cropFrame.clientWidth) / 2 - cropState.offsetX;
            const visibleTop = (cropState.naturalHeight * scale - cropFrame.clientHeight) / 2 - cropState.offsetY;
            const sourceX = Math.max(0, visibleLeft / scale);
            const sourceY = Math.max(0, visibleTop / scale);
            const sourceWidth = Math.min(cropState.naturalWidth - sourceX, cropFrame.clientWidth / scale);
            const sourceHeight = Math.min(cropState.naturalHeight - sourceY, cropFrame.clientHeight / scale);
            const aspect = cropAspectFor(card);
            const outputWidth = 1400;
            const outputHeight = Math.round(outputWidth / aspect);
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
                const snapshot = imageStartSnapshots.get(fileInput) || snapshotScope(scope);

                transfer.items.add(cropped);
                pushSnapshot(scope, snapshot);
                fileInput.files = transfer.files;
                imageStartSnapshots.delete(fileInput);
                showSelectedImage(card, cropped);
                ensureLiveError(fileInput).textContent = "";
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

        document.querySelectorAll("input[type='text']").forEach((field) => {
            const shouldValidate = cleanFieldNames.some((name) => field.name.includes(`[${name}]`));

            if (shouldValidate) {
                field.addEventListener("input", () => validateCleanField(field));
                field.addEventListener("blur", () => validateCleanField(field));
            }
        });

        document.querySelectorAll("input[type='file']:not([data-image-file])").forEach((field) => {
            field.addEventListener("change", () => validateUpload(field));
        });

        document.querySelectorAll(".language-card, .media-card").forEach(bindUndoScope);
        document.querySelectorAll("[data-image-card]").forEach(bindImageCard);
    </script>
</body>
</html>
