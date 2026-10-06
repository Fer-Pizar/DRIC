<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Detalle de noticia</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .image-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 32px; line-height: 1.15; }
        h2 { font-size: 22px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-light { background: #f8fafc; border: 1px solid var(--line); color: var(--ink); padding: 8px 10px; }
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .undo-floating { position: absolute; right: 16px; top: 16px; z-index: 2; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid { display: grid; gap: 14px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card { box-shadow: none; padding: 76px 18px 18px; position: relative; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        textarea, input[type="file"] { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        input[type="text"] { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .toolbar { display: flex; flex-wrap: wrap; gap: 8px; margin: 12px 0; }
        .editor { border: 1px solid #cfd6e3; border-radius: 14px; line-height: 1.75; min-height: 340px; outline: none; padding: 18px; }
        .editor:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(22, 65, 148, 0.12); }
        .editor p { margin: 0 0 16px; }
        .editor p.dric-news-dropcap { border-left: 4px solid var(--blue); margin-top: 20px; padding-left: 12px; }
        .editor blockquote { border-left: 4px solid var(--blue); color: #475569; margin: 16px 0; padding-left: 16px; }
        .gallery-actions { align-items: center; display: flex; gap: 10px; justify-content: space-between; margin-bottom: 14px; }
        .gallery-actions .muted { margin: 0; }
        .images-grid { display: grid; gap: 18px; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); margin: 14px auto 0; max-width: 980px; }
        .image-card { background: #f8fafc; box-shadow: none; overflow: visible; padding: 12px; position: relative; transition: opacity .2s ease, filter .2s ease; }
        .image-card img { background: #fff; border: 1px solid var(--line); border-radius: 18px; cursor: zoom-in; display: block; height: 260px; object-fit: contain; padding: 10px; width: 100%; }
        .image-card .hint { margin-top: 9px; }
        .image-card.is-removed { opacity: .45; }
        .image-card.is-removed img { filter: grayscale(1); }
        .image-card.is-removed::after { align-items: center; background: rgba(23, 32, 51, .72); border-radius: 12px; color: #fff; content: "Se quitará al guardar"; display: flex; font-size: 13px; font-weight: 800; inset: 12px; justify-content: center; position: absolute; text-align: center; }
        .btn-image-remove { align-items: center; background: var(--red-dark); border: 3px solid #fff; border-radius: 999px; color: #fff; cursor: pointer; display: inline-flex; font-size: 20px; font-weight: 900; height: 34px; justify-content: center; line-height: 1; position: absolute; right: -9px; top: -9px; width: 34px; z-index: 3; }
        .image-card > .btn-undo { left: -9px; min-height: 40px; position: absolute; top: -9px; z-index: 4; }
        .selected-images:empty { display: none; }
        .image-card.is-removed .btn-image-remove { display: none; }
        .media-editor-modal { background: #0f1113; color: #f8fafc; display: none; inset: 0; position: fixed; z-index: 80; }
        .media-editor-modal.is-open { display: grid; grid-template-rows: auto 1fr auto; }
        .media-editor-top { align-items: center; background: #171717; display: flex; gap: 18px; justify-content: space-between; padding: 14px 18px; }
        .media-editor-title { align-items: center; display: flex; gap: 18px; font-size: 28px; font-weight: 900; }
        .media-editor-back { background: transparent; border: 0; color: #fff; cursor: pointer; font-size: 34px; line-height: 1; padding: 4px 8px; }
        .media-editor-apply { background: #f8fafc; border: 0; border-radius: 999px; color: #111827; cursor: pointer; font-size: 18px; font-weight: 900; padding: 12px 28px; }
        .media-editor-workspace { align-items: center; display: flex; justify-content: center; min-height: 0; overflow: hidden; padding: 34px 28px; }
        .media-editor-stage { aspect-ratio: 16 / 8.2; background: #111827; max-height: 70vh; max-width: 1040px; overflow: hidden; position: relative; touch-action: none; width: min(100%, 1040px); }
        .media-editor-stage img { left: 50%; max-width: none; position: absolute; top: 50%; transform-origin: center; user-select: none; -webkit-user-drag: none; }
        .media-editor-stage::before { border: 6px solid #ff2b93; content: ""; inset: 0; pointer-events: none; position: absolute; z-index: 3; }
        .media-editor-stage::after { background: rgba(0, 0, 0, .42); content: ""; inset: 0; pointer-events: none; position: absolute; z-index: 2; }
        .media-editor-frame { border: 6px solid #ff2b93; inset: 0; pointer-events: none; position: absolute; z-index: 4; }
        .media-editor-controls { align-items: center; display: grid; gap: 18px; grid-template-columns: auto minmax(220px, 560px) auto; justify-content: center; padding: 20px 28px 28px; }
        .media-editor-controls span { color: #cbd5e1; font-size: 28px; line-height: 1; }
        .media-editor-controls input { accent-color: #ff2b93; width: 100%; }
        .media-editor-error { color: #fecdd3; font-size: 13px; font-weight: 800; min-height: 18px; text-align: center; }
        .sr-only { height: 1px; margin: -1px; overflow: hidden; padding: 0; position: absolute; width: 1px; clip: rect(0,0,0,0); border: 0; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; z-index: 30; }
        @media (max-width: 820px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Detalle de noticia</h1>
                <p class="muted">{{ $news->translations->firstWhere('language.code', 'es')?->title }}</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.news.edit', $newsPage) }}">Volver a Noticias</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.news.detail.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Texto editorial</h2>
                    <p class="muted">Contenido central de la noticia pública: título interno del detalle, bajada, párrafos, listas, citas e imágenes.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <button class="btn btn-undo undo-floating" type="button" data-undo-section title="Restaurar esta sección" aria-label="Restaurar esta sección" disabled>↶</button>
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título del detalle
                                    <input type="text" name="{{ $locale }}[detail_title]" value="{{ old($locale.'.detail_title', $content[$locale]['detail_title']) }}">
                                    <span class="hint">Este título aparece en blanco con brillo dentro del detalle de la noticia.</span>
                                    @error($locale.'.detail_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Bajada del detalle
                                    <textarea name="{{ $locale }}[deck]">{{ old($locale.'.deck', $content[$locale]['deck']) }}</textarea>
                                    @error($locale.'.deck')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Cuerpo de la noticia
                                    <div class="toolbar" data-toolbar="{{ $locale }}">
                                        <button class="btn btn-light" type="button" data-command="bold">B</button>
                                        <button class="btn btn-light" type="button" data-command="italic">I</button>
                                        <button class="btn btn-light" type="button" data-command="underline">U</button>
                                        <button class="btn btn-light" type="button" data-block="h2">H2</button>
                                        <button class="btn btn-light" type="button" data-block="h3">H3</button>
                                        <button class="btn btn-light" type="button" data-dropcap>Nuevo Párrafo</button>
                                        <button class="btn btn-light" type="button" data-command="insertUnorderedList">Viñetas</button>
                                        <button class="btn btn-light" type="button" data-command="insertOrderedList">Números</button>
                                        <button class="btn btn-light" type="button" data-block="blockquote">Cita</button>
                                        <button class="btn btn-light" type="button" data-command="removeFormat">Limpiar</button>
                                    </div>
                                    <div class="editor" data-editor="{{ $locale }}" contenteditable="true">{!! old($locale.'.body', $content[$locale]['body']) !!}</div>
                                    <input type="hidden" name="{{ $locale }}[body]" data-body-input="{{ $locale }}">
                                    <span class="hint">Pega o redacta el contenido aquí. Nuevo Párrafo marca dónde la vista pública inicia con letra grande.</span>
                                    @error($locale.'.body')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Imágenes del detalle</h2>
                    <p class="muted">Puedes subir una o varias imágenes JPG o PNG. Si hay más de una, la página pública las mostrará en carrusel automático.</p>
                </div>

                <div class="gallery-actions">
                    <p class="muted">Puedes agregar varias imágenes. La vista previa muestra cada foto completa, reducida dentro de su propio marco.</p>
                    <button class="btn btn-undo" type="button" id="restore-image" title="Restaurar última imagen quitada" aria-label="Restaurar última imagen quitada" disabled>↶</button>
                </div>

                @if (count($images))
                    <div class="images-grid">
                        @foreach ($images as $image)
                            <div class="image-card" data-existing-image-card data-image-id="{{ $image['media_asset_id'] ?? '' }}">
                                <button class="btn btn-undo" type="button" data-restore-existing-image disabled title="Restaurar esta imagen" aria-label="Restaurar esta imagen">↶</button>
                                <button class="btn-image-remove" type="button" data-remove-existing-image aria-label="Quitar imagen">×</button>
                                <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['file_name'] ?? 'Imagen de noticia' }}">
                                <span class="hint">Imagen actual guardada.</span>
                                <input class="sr-only" type="checkbox" name="remove_images[]" value="{{ $image['media_asset_id'] ?? '' }}" data-remove-existing-image-input>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="muted">Esta noticia todavía no tiene imágenes cargadas.</p>
                @endif

                <label style="margin-top: 18px;">
                    Agregar imágenes
                    <input id="news-images-input" type="file" name="images[]" multiple accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    <span class="hint">Formatos permitidos: JPG y PNG. Tamaño máximo por imagen: 10 MB.</span>
                    <span class="field-error" id="image-error"></span>
                    @error('images.*')<span class="field-error">{{ $message }}</span>@enderror
                </label>
                <div class="images-grid selected-images" id="selected-images"></div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se publican al guardar y recargar la noticia pública.</span>
                <button class="btn btn-primary" type="submit">Guardar detalle</button>
            </div>
        </form>

        <div class="media-editor-modal" id="media-editor-modal" aria-hidden="true">
            <div class="media-editor-top">
                <div class="media-editor-title">
                    <button class="media-editor-back" type="button" id="media-editor-close" aria-label="Volver">‹</button>
                    <span>Editar imagen</span>
                </div>
                <button class="media-editor-apply" type="button" id="media-editor-apply">Aplicar</button>
            </div>
            <div class="media-editor-workspace">
                <div class="media-editor-stage" id="media-editor-stage">
                    <img id="media-editor-image" alt="Vista previa del encuadre">
                    <div class="media-editor-frame" aria-hidden="true"></div>
                </div>
            </div>
            <div class="media-editor-controls">
                <span aria-hidden="true">−</span>
                <input id="media-editor-zoom" type="range" min="1" max="3" step="0.01" value="1" aria-label="Zoom de imagen">
                <span aria-hidden="true">＋</span>
            </div>
            <div class="media-editor-error" id="media-editor-error"></div>
        </div>

    </main>

    <script>
        let savedRange = null;
        const sectionHistory = new WeakMap();
        const pendingSnapshots = new WeakMap();
        const removedImages = [];
        const removedUploads = [];
        const removalHistory = [];
        const removedExistingImagesStorageKey = `news-detail-removed-images:${window.location.pathname}`;
        const restoreImageButton = document.getElementById("restore-image");
        const imageInput = document.getElementById("news-images-input");
        const selectedImagesContainer = document.getElementById("selected-images");
        const mediaEditorModal = document.getElementById("media-editor-modal");
        const mediaEditorStage = document.getElementById("media-editor-stage");
        const mediaEditorImage = document.getElementById("media-editor-image");
        const mediaEditorZoom = document.getElementById("media-editor-zoom");
        const mediaEditorClose = document.getElementById("media-editor-close");
        const mediaEditorApply = document.getElementById("media-editor-apply");
        const mediaEditorError = document.getElementById("media-editor-error");
        const mediaEditorAspect = 16 / 8.2;
        const mediaEditorState = {
            kind: null,
            index: null,
            card: null,
            file: null,
            sourceUrl: "",
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
        let uploadItems = [];

        function editableFields(scope) {
            return [...scope.querySelectorAll("input:not([type='hidden']), textarea, select, [contenteditable='true']")];
        }

        function captureSnapshot(scope) {
            return editableFields(scope).map((field) => ({
                field,
                checked: field.checked,
                html: field.isContentEditable ? field.innerHTML : null,
                value: field.value,
            }));
        }

        function restoreSnapshot(snapshot) {
            snapshot.forEach(({ field, checked, html, value }) => {
                if (!field.isConnected) return;
                if (field.isContentEditable) {
                    field.innerHTML = html;
                } else if (field.type === "checkbox" || field.type === "radio") {
                    field.checked = checked;
                } else {
                    field.value = value;
                }
            });
        }

        function primeSnapshot(scope) {
            if (!scope || pendingSnapshots.has(scope)) return;
            pendingSnapshots.set(scope, captureSnapshot(scope));
        }

        function setUndoState(button, history) {
            if (button) button.disabled = !history.length;
        }

        function rememberChange(scope, button) {
            if (!scope) return;
            const history = sectionHistory.get(scope) || [];
            history.push(pendingSnapshots.get(scope) || captureSnapshot(scope));
            if (history.length > 25) history.shift();
            sectionHistory.set(scope, history);
            pendingSnapshots.set(scope, captureSnapshot(scope));
            setUndoState(button, history);
        }

        function bindUndoScope(scope) {
            if (!scope || scope.dataset.undoBound) return;
            scope.dataset.undoBound = "true";
            const button = scope.querySelector("[data-undo-section]");
            editableFields(scope).forEach((field) => {
                field.addEventListener("focus", () => primeSnapshot(scope));
                field.addEventListener("pointerdown", () => primeSnapshot(scope));
                field.addEventListener("input", () => rememberChange(scope, button));
                field.addEventListener("change", () => rememberChange(scope, button));
            });
            button?.addEventListener("click", () => {
                const history = sectionHistory.get(scope) || [];
                const snapshot = history.pop();
                if (!snapshot) return;
                restoreSnapshot(snapshot);
                setUndoState(button, history);
            });
        }

        function setRestoreImageState() {
            if (restoreImageButton) restoreImageButton.disabled = removalHistory.length === 0 && readRemovedImageRecords().length === 0;
        }

        function readRemovedImageRecords() {
            try {
                const stored = sessionStorage.getItem(removedExistingImagesStorageKey);
                const records = stored ? JSON.parse(stored) : [];
                return Array.isArray(records) ? records.filter((record) => record?.id) : [];
            } catch (error) {
                sessionStorage.removeItem(removedExistingImagesStorageKey);
                return [];
            }
        }

        function writeRemovedImageRecords(records) {
            const cleanRecords = records.filter((record) => record?.id);
            if (!cleanRecords.length) {
                sessionStorage.removeItem(removedExistingImagesStorageKey);
                return;
            }

            sessionStorage.setItem(removedExistingImagesStorageKey, JSON.stringify(cleanRecords));
        }

        function imageIdFromCard(card) {
            return card?.querySelector("[data-remove-existing-image-input]")?.value
                || card?.querySelector("[data-restored-image-input]")?.value
                || card?.dataset.imageId
                || "";
        }

        function imageRecordFromCard(card) {
            const image = card?.querySelector("img");
            const id = imageIdFromCard(card);

            if (!id || !image) return null;

            return {
                id,
                url: image.getAttribute("src") || "",
                fileName: image.getAttribute("alt") || "Imagen de noticia",
            };
        }

        function rememberRemovedImage(card) {
            const record = imageRecordFromCard(card);
            if (!record) return;

            const records = readRemovedImageRecords().filter((item) => item.id !== record.id);
            records.push(record);
            writeRemovedImageRecords(records);
        }

        function forgetRemovedImage(cardOrId) {
            const id = typeof cardOrId === "string" ? cardOrId : imageIdFromCard(cardOrId);
            if (!id) return;

            writeRemovedImageRecords(readRemovedImageRecords().filter((record) => record.id !== id));
        }

        function popRemovedImageRecord() {
            const records = readRemovedImageRecords();
            const record = records.pop();
            writeRemovedImageRecords(records);
            return record || null;
        }

        function imageGrid() {
            let grid = document.querySelector(".images-grid:not(.selected-images)");
            if (grid) return grid;

            grid = document.createElement("div");
            grid.className = "images-grid";
            const uploadLabel = imageInput?.closest("label");
            uploadLabel?.before(grid);
            return grid;
        }

        function addRestoreInput(record) {
            if (!record?.id || document.querySelector(`[data-restored-image-input][value="${CSS.escape(record.id)}"]`)) return;

            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "restore_images[]";
            input.value = record.id;
            input.dataset.restoredImageInput = "";
            document.querySelector("form")?.append(input);
        }

        function removeRestoreInput(id) {
            document.querySelectorAll(`[data-restored-image-input][value="${CSS.escape(String(id))}"]`).forEach((input) => input.remove());
        }

        function restorableCardFor(record) {
            const card = document.createElement("div");
            card.className = "image-card is-removed";
            card.dataset.existingImageCard = "";
            card.dataset.imageId = record.id;
            card.dataset.restorableMissingImage = "";
            card.innerHTML = `
                <button class="btn btn-undo" type="button" data-restore-existing-image title="Restaurar esta imagen" aria-label="Restaurar esta imagen">↶</button>
                <button class="btn-image-remove" type="button" data-remove-existing-image aria-label="Quitar imagen" hidden>×</button>
                <img src="${escapeHtml(record.url)}" alt="${escapeHtml(record.fileName || "Imagen de noticia")}">
                <span class="hint">Imagen quitada en esta sesión. Puedes restaurarla antes de guardar otra vez.</span>
            `;

            card.querySelector("img").addEventListener("click", () => openMediaEditorForExisting(card));
            card.querySelector("[data-restore-existing-image]").addEventListener("click", () => {
                restoreExistingImage(card);
                const historyIndex = removalHistory.findLastIndex((item) => item.type === "existing" && imageIdFromCard(item.card) === record.id);
                if (historyIndex >= 0) removalHistory.splice(historyIndex, 1);
                setRestoreImageState();
            });
            card.querySelector("[data-remove-existing-image]").addEventListener("click", () => removeExistingImage(card));

            return card;
        }

        function applyStoredRemovedImages() {
            readRemovedImageRecords().forEach((record) => {
                const existingCard = [...document.querySelectorAll("[data-existing-image-card]")]
                    .find((card) => imageIdFromCard(card) === record.id);

                if (existingCard) {
                    const input = existingCard.querySelector("[data-remove-existing-image-input]");
                    const restoreButton = existingCard.querySelector("[data-restore-existing-image]");
                    if (input) input.checked = true;
                    existingCard.classList.add("is-removed");
                    if (restoreButton) restoreButton.disabled = false;
                    return;
                }

                imageGrid().append(restorableCardFor(record));
            });
        }

        function removeExistingImage(card) {
            if (!card) return;
            const input = card.querySelector("[data-remove-existing-image-input]");
            const restoreButton = card.querySelector("[data-restore-existing-image]");

            if (input) {
                if (input.checked) return;
                input.checked = true;
            } else {
                const id = imageIdFromCard(card);
                if (!id || card.classList.contains("is-removed")) return;
                removeRestoreInput(id);
            }

            card.classList.add("is-removed");
            if (restoreButton) restoreButton.disabled = false;
            rememberRemovedImage(card);
            removedImages.push(card);
            removalHistory.push({ type: "existing", card });
            setRestoreImageState();
        }

        function restoreExistingImage(card) {
            if (!card) return;
            const input = card.querySelector("[data-remove-existing-image-input]");
            const restoreButton = card.querySelector("[data-restore-existing-image]");
            const record = imageRecordFromCard(card);

            if (input) {
                input.checked = false;
            } else if (record) {
                addRestoreInput(record);
            }

            card.classList.remove("is-removed");
            if (restoreButton) restoreButton.disabled = true;
            card.querySelector("[data-remove-existing-image]")?.removeAttribute("hidden");
            if (record) forgetRemovedImage(record.id);
        }

        function setInputFiles() {
            const transfer = new DataTransfer();
            uploadItems.forEach((item) => transfer.items.add(item.file));
            imageInput.files = transfer.files;
        }

        function revokeUploadUrl(item) {
            if (item?.url) URL.revokeObjectURL(item.url);
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;");
        }

        function renderSelectedImages() {
            selectedImagesContainer.innerHTML = "";
            uploadItems.forEach((item, index) => {
                const card = document.createElement("div");
                card.className = "image-card";
                card.dataset.uploadImageCard = "";
                card.innerHTML = `
                    <button class="btn-image-remove" type="button" data-remove-upload-image aria-label="Quitar imagen">×</button>
                    <img src="${item.url}" alt="${escapeHtml(item.file.name)}">
                    <span class="hint">Haz clic en la imagen para ajustar el encuadre de la vista pública.</span>
                `;
                card.querySelector("img").addEventListener("click", () => openMediaEditorForUpload(index));
                card.querySelector("[data-remove-upload-image]").addEventListener("click", () => removeUpload(index));
                selectedImagesContainer.append(card);
            });
        }

        function addUploads(files) {
            const newItems = files.map((file) => ({
                file,
                originalFile: file,
                url: URL.createObjectURL(file),
                previous: null,
            }));
            uploadItems = [...uploadItems, ...newItems];
            removedUploads.length = 0;
            removalHistory.splice(0, removalHistory.length, ...removalHistory.filter((item) => item.type === "existing"));
            renderSelectedImages();
            setInputFiles();
            setRestoreImageState();
        }

        function removeUpload(index) {
            const item = uploadItems[index];
            if (!item) return;
            removedUploads.push({ item, index });
            removalHistory.push({ type: "upload", item, index });
            uploadItems.splice(index, 1);
            renderSelectedImages();
            setInputFiles();
            setRestoreImageState();
        }

        function restoreUpload(item, index) {
            const safeIndex = Math.min(index, uploadItems.length);
            uploadItems.splice(safeIndex, 0, item);
            renderSelectedImages();
            setInputFiles();
        }

        function resetMediaEditorState() {
            mediaEditorState.kind = null;
            mediaEditorState.index = null;
            mediaEditorState.card = null;
            mediaEditorState.file = null;
            mediaEditorState.sourceUrl = "";
            mediaEditorState.naturalWidth = 0;
            mediaEditorState.naturalHeight = 0;
            mediaEditorState.baseScale = 1;
            mediaEditorState.zoom = 1;
            mediaEditorState.offsetX = 0;
            mediaEditorState.offsetY = 0;
            mediaEditorState.dragging = false;
            mediaEditorError.textContent = "";
            if (mediaEditorState.objectUrl) URL.revokeObjectURL(mediaEditorState.objectUrl);
            mediaEditorState.objectUrl = "";
            mediaEditorImage.removeAttribute("src");
        }

        function croppedFileName(fileName) {
            const base = String(fileName || "noticia-imagen").replace(/\.[^.]+$/, "");
            return `${base}-encuadrada.jpg`;
        }

        function clampMediaEditorOffsets() {
            const stageWidth = mediaEditorStage.clientWidth;
            const stageHeight = mediaEditorStage.clientHeight;
            const imageWidth = mediaEditorState.naturalWidth * mediaEditorState.baseScale * mediaEditorState.zoom;
            const imageHeight = mediaEditorState.naturalHeight * mediaEditorState.baseScale * mediaEditorState.zoom;
            const maxX = Math.max(0, (imageWidth - stageWidth) / 2);
            const maxY = Math.max(0, (imageHeight - stageHeight) / 2);
            mediaEditorState.offsetX = Math.min(maxX, Math.max(-maxX, mediaEditorState.offsetX));
            mediaEditorState.offsetY = Math.min(maxY, Math.max(-maxY, mediaEditorState.offsetY));
        }

        function renderMediaEditor() {
            clampMediaEditorOffsets();
            mediaEditorImage.style.width = `${mediaEditorState.naturalWidth * mediaEditorState.baseScale * mediaEditorState.zoom}px`;
            mediaEditorImage.style.height = `${mediaEditorState.naturalHeight * mediaEditorState.baseScale * mediaEditorState.zoom}px`;
            mediaEditorImage.style.transform = `translate(calc(-50% + ${mediaEditorState.offsetX}px), calc(-50% + ${mediaEditorState.offsetY}px))`;
        }

        function resetMediaEditorPosition() {
            const stageWidth = mediaEditorStage.clientWidth;
            const stageHeight = mediaEditorStage.clientHeight;
            mediaEditorState.baseScale = Math.max(
                stageWidth / mediaEditorState.naturalWidth,
                stageHeight / mediaEditorState.naturalHeight
            );
            mediaEditorState.zoom = 1;
            mediaEditorState.offsetX = 0;
            mediaEditorState.offsetY = 0;
            mediaEditorZoom.value = "1";
            renderMediaEditor();
        }

        function openMediaEditorForUpload(index) {
            const item = uploadItems[index];
            if (!item) return;
            resetMediaEditorState();
            mediaEditorState.kind = "upload";
            mediaEditorState.index = index;
            mediaEditorState.file = item.file;
            mediaEditorState.sourceUrl = item.url;
            mediaEditorImage.src = item.url;
            mediaEditorModal.classList.add("is-open");
            mediaEditorModal.setAttribute("aria-hidden", "false");
        }

        function openMediaEditorForExisting(card) {
            if (!card || card.classList.contains("is-removed")) return;
            const image = card.querySelector("img");
            if (!image?.src) return;
            resetMediaEditorState();
            mediaEditorState.kind = "existing";
            mediaEditorState.card = card;
            mediaEditorState.sourceUrl = image.src;
            mediaEditorImage.src = image.src;
            mediaEditorModal.classList.add("is-open");
            mediaEditorModal.setAttribute("aria-hidden", "false");
        }

        function closeMediaEditor() {
            mediaEditorModal.classList.remove("is-open");
            mediaEditorModal.setAttribute("aria-hidden", "true");
            resetMediaEditorState();
        }

        function applyMediaEditor() {
            if (!mediaEditorState.kind || !mediaEditorState.naturalWidth || !mediaEditorState.naturalHeight) return;
            mediaEditorError.textContent = "";

            const outputWidth = 1600;
            const outputHeight = Math.round(outputWidth / mediaEditorAspect);
            const stageWidth = mediaEditorStage.clientWidth;
            const stageHeight = mediaEditorStage.clientHeight;
            const scale = mediaEditorState.baseScale * mediaEditorState.zoom;
            const visibleLeft = (mediaEditorState.naturalWidth * scale - stageWidth) / 2 - mediaEditorState.offsetX;
            const visibleTop = (mediaEditorState.naturalHeight * scale - stageHeight) / 2 - mediaEditorState.offsetY;
            const sourceX = Math.max(0, visibleLeft / scale);
            const sourceY = Math.max(0, visibleTop / scale);
            const sourceWidth = Math.min(mediaEditorState.naturalWidth - sourceX, stageWidth / scale);
            const sourceHeight = Math.min(mediaEditorState.naturalHeight - sourceY, stageHeight / scale);
            const canvas = document.createElement("canvas");
            canvas.width = outputWidth;
            canvas.height = outputHeight;
            const context = canvas.getContext("2d");
            try {
                context.drawImage(mediaEditorImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, outputWidth, outputHeight);
            } catch (error) {
                mediaEditorError.textContent = "No se pudo editar esta imagen desde el navegador. Sube el archivo original para ajustarla.";
                return;
            }

            try {
                canvas.toBlob((blob) => {
                if (!blob) return;
                const sourceName = mediaEditorState.file?.name
                    || mediaEditorState.card?.querySelector("img")?.alt
                    || "noticia-imagen.jpg";
                const file = new File([blob], croppedFileName(sourceName), { type: "image/jpeg" });
                const item = {
                    file,
                    originalFile: file,
                    url: URL.createObjectURL(file),
                    previous: null,
                };

                if (mediaEditorState.kind === "upload" && Number.isInteger(mediaEditorState.index)) {
                    const previousItem = uploadItems[mediaEditorState.index];
                    if (previousItem) revokeUploadUrl(previousItem);
                    uploadItems[mediaEditorState.index] = item;
                } else if (mediaEditorState.kind === "existing" && mediaEditorState.card) {
                    removeExistingImage(mediaEditorState.card);
                    uploadItems.push(item);
                }

                renderSelectedImages();
                setInputFiles();
                closeMediaEditor();
                }, "image/jpeg", 0.92);
            } catch (error) {
                mediaEditorError.textContent = "No se pudo editar esta imagen desde el navegador. Sube el archivo original para ajustarla.";
            }
        }

        function rememberSelection() {
            const selection = window.getSelection();
            if (selection && selection.rangeCount) {
                savedRange = selection.getRangeAt(0);
            }
        }

        function restoreSelection(editor) {
            editor.focus();

            if (!savedRange) {
                return;
            }

            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(savedRange);
        }

        function currentTextBlock(editor) {
            const selection = window.getSelection();
            if (!selection || !selection.rangeCount) {
                return null;
            }

            let node = selection.getRangeAt(0).startContainer;
            if (node.nodeType === Node.TEXT_NODE) {
                node = node.parentElement;
            }

            while (node && node !== editor) {
                if (["P", "H2", "H3", "BLOCKQUOTE", "LI", "DIV"].includes(node.nodeName)) {
                    return node;
                }

                node = node.parentElement;
            }

            return null;
        }

        function toggleDropcap(editor) {
            restoreSelection(editor);

            let block = currentTextBlock(editor);

            if (!block || block === editor) {
                document.execCommand("formatBlock", false, "p");
                block = currentTextBlock(editor);
            }

            if (!block) {
                return;
            }

            if (block.nodeName !== "P") {
                document.execCommand("formatBlock", false, "p");
                block = currentTextBlock(editor);
            }

            if (block && block.nodeName === "P") {
                block.classList.toggle("dric-news-dropcap");
            }

            rememberSelection();
        }

        function shouldUseNewParagraphMarker(paragraph, index) {
            const text = paragraph.textContent.replace(/\s+/g, " ").trim();

            return index === 0 || text.length >= 80;
        }

        function prefillEditorialMarkers(editor) {
            editor.querySelectorAll("p").forEach((paragraph, index) => {
                if (shouldUseNewParagraphMarker(paragraph, index)) {
                    paragraph.classList.add("dric-news-dropcap");
                }
            });
        }

        document.querySelectorAll("[data-toolbar]").forEach((toolbar) => {
            const locale = toolbar.dataset.toolbar;
            const editor = document.querySelector(`[data-editor="${locale}"]`);
            const scope = toolbar.closest("[data-undo-scope]");
            const undoButton = scope?.querySelector("[data-undo-section]");

            prefillEditorialMarkers(editor);

            editor.addEventListener("keyup", rememberSelection);
            editor.addEventListener("mouseup", rememberSelection);
            editor.addEventListener("focus", rememberSelection);

            toolbar.querySelectorAll("button").forEach((button) => {
                button.addEventListener("mousedown", (event) => event.preventDefault());
                button.addEventListener("click", () => {
                    restoreSelection(editor);
                    rememberChange(scope, undoButton);
                    if (button.hasAttribute("data-dropcap")) {
                        toggleDropcap(editor);
                    } else if (button.dataset.block) {
                        document.execCommand("formatBlock", false, button.dataset.block);
                    } else {
                        document.execCommand(button.dataset.command, false, null);
                    }
                    rememberSelection();
                });
            });
        });

        document.querySelector("form").addEventListener("submit", () => {
            document.querySelectorAll("[data-editor]").forEach((editor) => {
                const input = document.querySelector(`[data-body-input="${editor.dataset.editor}"]`);
                input.value = normalizeEditorHtml(editor);
            });
        });

        document.execCommand("defaultParagraphSeparator", false, "p");

        function normalizeEditorHtml(editor) {
            const clone = editor.cloneNode(true);

            clone.querySelectorAll("div").forEach((div) => {
                const paragraph = document.createElement("p");
                paragraph.innerHTML = div.innerHTML;

                if (div.classList.contains("dric-news-dropcap")) {
                    paragraph.classList.add("dric-news-dropcap");
                }

                div.replaceWith(paragraph);
            });

            clone.querySelectorAll("p").forEach((paragraph) => {
                if (paragraph.classList.contains("dric-news-dropcap")) {
                    paragraph.setAttribute("class", "dric-news-dropcap");
                } else {
                    paragraph.removeAttribute("class");
                }

                paragraph.removeAttribute("style");
            });

            clone.querySelectorAll("*").forEach((node) => {
                node.removeAttribute("style");
                node.removeAttribute("data-mce-style");
                node.removeAttribute("contenteditable");
            });

            const html = clone.innerHTML.trim();
            if (/<(p|h2|h3|ul|ol|li|blockquote|div)\b/i.test(html)) {
                return html
                    .replace(/<div><br><\/div>/gi, "")
                    .replace(/<p>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>)[\s\S]*?(?:<\/ul>|<\/ol>))\s*<\/p>/gi, "$1")
                    .replace(/<p>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>)[\s\S]*?(?:<\/ul>|<\/ol>))\s*<\/p>/gi, "$1");
            }

            return editor.innerText
                .split(/\n{2,}/)
                .map((paragraph) => paragraph.trim())
                .filter(Boolean)
                .map((paragraph) => `<p>${paragraph.replace(/\n/g, "<br>")}</p>`)
                .join("");
        }

        imageInput.addEventListener("change", (event) => {
            const message = document.getElementById("image-error");
            const files = [...event.target.files];
            message.textContent = "";

            for (const file of files) {
                if (!["image/jpeg", "image/png"].includes(file.type)) {
                    message.textContent = "Ese formato no está permitido. Usa JPG o PNG.";
                    event.target.value = "";
                    setInputFiles();
                    return;
                }

                if (file.size > 10 * 1024 * 1024) {
                    message.textContent = "La imagen sobrepasa los 10MB.";
                    event.target.value = "";
                    setInputFiles();
                    return;
                }
            }

            addUploads(files);
        });

        mediaEditorImage.addEventListener("load", () => {
            mediaEditorState.naturalWidth = mediaEditorImage.naturalWidth;
            mediaEditorState.naturalHeight = mediaEditorImage.naturalHeight;
            resetMediaEditorPosition();
        });
        mediaEditorZoom.addEventListener("input", () => {
            mediaEditorState.zoom = Number(mediaEditorZoom.value);
            renderMediaEditor();
        });
        mediaEditorStage.addEventListener("pointerdown", (event) => {
            mediaEditorState.dragging = true;
            mediaEditorState.pointerX = event.clientX;
            mediaEditorState.pointerY = event.clientY;
            mediaEditorStage.setPointerCapture(event.pointerId);
        });
        mediaEditorStage.addEventListener("pointermove", (event) => {
            if (!mediaEditorState.dragging) return;
            mediaEditorState.offsetX += event.clientX - mediaEditorState.pointerX;
            mediaEditorState.offsetY += event.clientY - mediaEditorState.pointerY;
            mediaEditorState.pointerX = event.clientX;
            mediaEditorState.pointerY = event.clientY;
            renderMediaEditor();
        });
        mediaEditorStage.addEventListener("pointerup", (event) => {
            mediaEditorState.dragging = false;
            mediaEditorStage.releasePointerCapture(event.pointerId);
        });
        mediaEditorStage.addEventListener("pointercancel", () => {
            mediaEditorState.dragging = false;
        });
        mediaEditorClose.addEventListener("click", closeMediaEditor);
        mediaEditorApply.addEventListener("click", applyMediaEditor);
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && mediaEditorModal.classList.contains("is-open")) {
                closeMediaEditor();
            }
        });
        document.querySelectorAll("[data-undo-scope]").forEach(bindUndoScope);
        document.querySelectorAll("[data-existing-image-card] img").forEach((image) => {
            image.addEventListener("click", () => openMediaEditorForExisting(image.closest("[data-existing-image-card]")));
        });
        document.querySelectorAll("[data-remove-existing-image]").forEach((button) => {
            button.addEventListener("click", () => removeExistingImage(button.closest("[data-existing-image-card]")));
        });
        document.querySelectorAll("[data-restore-existing-image]").forEach((button) => {
            button.addEventListener("click", () => {
                const card = button.closest("[data-existing-image-card]");
                restoreExistingImage(card);
                const index = removedImages.lastIndexOf(card);
                if (index >= 0) removedImages.splice(index, 1);
                const historyIndex = removalHistory.findLastIndex((item) => item.type === "existing" && item.card === card);
                if (historyIndex >= 0) removalHistory.splice(historyIndex, 1);
                setRestoreImageState();
            });
        });
        restoreImageButton?.addEventListener("click", () => {
            let latest = removalHistory.pop();
            if (!latest) {
                const record = popRemovedImageRecord();
                if (record) {
                    let card = [...document.querySelectorAll("[data-existing-image-card]")]
                        .find((candidate) => imageIdFromCard(candidate) === record.id);

                    if (!card) {
                        card = restorableCardFor(record);
                        imageGrid().append(card);
                    }

                    latest = { type: "existing", card, alreadyForgotten: true };
                }
            }
            if (!latest) return;
            if (latest.type === "existing") {
                restoreExistingImage(latest.card);
                if (!latest.alreadyForgotten) forgetRemovedImage(latest.card);
                const index = removedImages.lastIndexOf(latest.card);
                if (index >= 0) removedImages.splice(index, 1);
            }
            if (latest.type === "upload") {
                restoreUpload(latest.item, latest.index);
                const index = removedUploads.findIndex((entry) => entry.item === latest.item);
                if (index >= 0) removedUploads.splice(index, 1);
            }
            setRestoreImageState();
        });
        applyStoredRemovedImages();
        setRestoreImageState();
    </script>
    @include('admin.partials.persistent-undo')
</body>
</html>
