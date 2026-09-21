<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Apoyo Financiero</title>
    <style>
        :root {
            --blue: #164194;
            --red-dark: #7f0010;
            --ink: #172033;
            --muted: #647084;
            --line: #e5e9f0;
            --soft: #f5f7fb;
        }

        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .document-row { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { font-size: 22px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-danger { background: #fff1f2; color: var(--red-dark); }
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .undo-floating { position: absolute; right: 12px; top: 12px; z-index: 4; }
        .document-row > .undo-floating { right: -10px; top: -10px; z-index: 6; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .cards-grid, .field-grid, .documents { display: grid; gap: 14px; }
        .panel { padding: 24px; }
        .panel-header { align-items: start; border-bottom: 1px solid var(--line); display: flex; gap: 16px; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .document-row { box-shadow: none; padding: 18px; position: relative; }
        .document-row { display: grid; gap: 14px; }
        .row-header { align-items: center; display: flex; justify-content: space-between; }
        .document-fields { display: grid; gap: 14px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .document-fields .full { grid-column: 1 / -1; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input[type="text"], input[type="url"], textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 112px; resize: vertical; }
        .tall { min-height: 190px; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error, .live-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .live-error:empty { display: none; }
        .is-invalid { border-color: var(--red-dark) !important; box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10); }
        .empty-state { background: var(--soft); border: 1px dashed #cfd6e3; border-radius: 16px; color: var(--muted); padding: 22px; text-align: center; }
        .sticky-actions { align-items: center; background: rgba(255, 255, 255, 0.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }

        @media (max-width: 820px) {
            .topbar, .panel-header, .sticky-actions { align-items: stretch; flex-direction: column; }
            .language-grid, .document-fields { grid-template-columns: 1fr; }
            h1 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Apoyo Financiero</h1>
                <p class="muted">Administra textos y enlaces de la página pública. El diseño del sitio no se modifica desde aquí.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.projects.edit', $projectPage) }}">Volver a Proyectos</a>
                <a class="btn btn-secondary" href="/es/proyectos/apoyo-financiero" target="_blank">Ver página pública</a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div>
        @endif

        <form method="POST" action="{{ route('admin.project-funding.update') }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Contenido principal</h2>
                    <p class="muted">Encabezado, métricas, párrafos, áreas y textos de botones.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                @foreach ([
                                    'eyebrow' => 'Categoría',
                                    'title' => 'Título',
                                    'subtitle' => 'Descripción superior',
                                    'open_label' => 'Etiqueta de estado',
                                    'total' => 'Monto principal',
                                    'total_label' => 'Texto del monto principal',
                                    'augm' => 'Dato destacado',
                                    'augm_label' => 'Texto del dato destacado',
                                    'section_title' => 'Título del contenido',
                                    'areas_title' => 'Título de áreas',
                                    'docs_title' => 'Título de documentos',
                                    'docs_intro' => 'Descripción de documentos',
                                    'more_info' => 'Texto del botón de información',
                                ] as $field => $labelText)
                                    <label>
                                        {{ $labelText }}
                                        <input type="text" name="{{ $locale }}[{{ $field }}]" value="{{ old($locale.'.'.$field, $content[$locale][$field]) }}">
                                        @error($locale.'.'.$field)<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                @endforeach
                                <label>
                                    Párrafos del contenido
                                    <textarea class="tall" name="{{ $locale }}[paragraphs]">{{ old($locale.'.paragraphs', $content[$locale]['paragraphs']) }}</textarea>
                                    <span class="hint">Escribe un párrafo por línea.</span>
                                    @error($locale.'.paragraphs')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Áreas estratégicas
                                    <textarea name="{{ $locale }}[areas]">{{ old($locale.'.areas', $content[$locale]['areas']) }}</textarea>
                                    <span class="hint">Escribe un área por línea.</span>
                                    @error($locale.'.areas')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Botón de información oficial</h2>
                    <p class="muted">Este enlace corresponde al botón principal del bloque de contenido.</p>
                </div>
                <div class="language-card">
                    <label>
                        URL del botón
                        <input type="url" name="more_info_url" value="{{ old('more_info_url', $content['more_info_url']) }}" placeholder="https://sitio.edu.bo/noticia">
                        @error('more_info_url')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Documentos de la convocatoria</h2>
                        <p class="muted">Agrega o quita los enlaces que aparecen en la tarjeta derecha de la página pública.</p>
                    </div>
                    <div class="actions">
                        <button class="btn btn-undo" type="button" id="undo-documents" disabled title="Restaurar último cambio de documentos" aria-label="Restaurar último cambio de documentos">↶</button>
                        <button class="btn btn-primary" type="button" id="add-document">Agregar documento</button>
                    </div>
                </div>

                <div class="documents" id="documents">
                    @php
                        $oldDocuments = old('documents');
                        $rows = is_array($oldDocuments) ? $oldDocuments : $documents;
                    @endphp

                    @foreach ($rows as $index => $document)
                        <div class="document-row">
                            <div class="row-header">
                                <h3>Documento <span class="row-number">{{ $index + 1 }}</span></h3>
                                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                            </div>
                            <input type="hidden" data-name="id" name="documents[{{ $index }}][id]" value="{{ $document['id'] ?? '' }}">
                            <div class="document-fields">
                                <label>
                                    Texto en español
                                    <input type="text" data-name="title_es" name="documents[{{ $index }}][title_es]" value="{{ $document['title_es'] ?? '' }}">
                                    @error('documents.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto en inglés
                                    <input type="text" data-name="title_en" name="documents[{{ $index }}][title_en]" value="{{ $document['title_en'] ?? '' }}">
                                    <span class="hint">Si se deja vacío, se usará el texto en español.</span>
                                    @error('documents.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="full">
                                    URL del documento
                                    <input type="url" data-name="url" name="documents[{{ $index }}][url]" value="{{ $document['url'] ?? '' }}" placeholder="https://sitio.edu.bo/documento.pdf">
                                    @error('documents.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                    <div class="empty-state" id="empty-state" @if (count($rows)) style="display:none;" @endif>Todavía no hay documentos guardados. Agrega el primer documento para publicarlo.</div>
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <template id="document-template">
        <div class="document-row">
            <div class="row-header">
                <h3>Documento <span class="row-number"></span></h3>
                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
            </div>
            <input type="hidden" data-name="id" value="">
            <div class="document-fields">
                <label>
                    Texto en español
                    <input type="text" data-name="title_es" value="">
                </label>
                <label>
                    Texto en inglés
                    <input type="text" data-name="title_en" value="">
                    <span class="hint">Si se deja vacío, se usará el texto en español.</span>
                </label>
                <label class="full">
                    URL del documento
                    <input type="url" data-name="url" value="" placeholder="https://sitio.edu.bo/documento.pdf">
                </label>
            </div>
        </div>
    </template>

    <script>
        const cleanLabelPattern = /^[\p{L}\s.,]+$/u;
        const cleanFieldNames = ["eyebrow", "areas_title", "docs_title", "more_info"];
        const container = document.getElementById("documents");
        const template = document.getElementById("document-template");
        const emptyState = document.getElementById("empty-state");
        const undoDocumentsButton = document.getElementById("undo-documents");
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const documentHistory = [];

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll("input, textarea"));
        }

        function snapshotScope(scope) {
            return editableFields(scope).map((field) => ({
                name: field.name,
                type: field.type,
                value: field.value,
                checked: field.checked,
            }));
        }

        function restoreSnapshot(scope, snapshot) {
            snapshot.forEach((item) => {
                const field = editableFields(scope).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
                field.dispatchEvent(new Event("input", { bubbles: true }));
            });
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

        function validateCleanField(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();
            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!value) return;

            if (/\d/u.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "No uses números en este campo.";
                return;
            }

            if (!cleanLabelPattern.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "Solo se permiten letras, espacios, puntos y comas.";
            }
        }

        function validateUrl(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();
            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!value) return;

            try {
                const url = new URL(value);
                if (!["http:", "https:"].includes(url.protocol)) throw new Error("invalid");
            } catch {
                field.classList.add("is-invalid");
                message.textContent = "Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf";
            }
        }

        function documentRowsState() {
            return [...container.querySelectorAll(".document-row")].map((row) => ({
                id: row.querySelector("[data-name='id']")?.value || "",
                title_es: row.querySelector("[data-name='title_es']")?.value || "",
                title_en: row.querySelector("[data-name='title_en']")?.value || "",
                url: row.querySelector("[data-name='url']")?.value || "",
            }));
        }

        function setDocumentUndoState() {
            undoDocumentsButton.disabled = documentHistory.length === 0;
        }

        function pushDocumentSnapshot() {
            const snapshot = documentRowsState();
            const serialized = JSON.stringify(snapshot);
            const last = documentHistory.length ? JSON.stringify(documentHistory[documentHistory.length - 1]) : null;

            if (serialized !== last) {
                documentHistory.push(snapshot);
            }

            if (documentHistory.length > 20) {
                documentHistory.shift();
            }

            setDocumentUndoState();
        }

        function rowFromState(state) {
            const row = template.content.firstElementChild.cloneNode(true);

            row.querySelector("[data-name='id']").value = state.id || "";
            row.querySelector("[data-name='title_es']").value = state.title_es || "";
            row.querySelector("[data-name='title_en']").value = state.title_en || "";
            row.querySelector("[data-name='url']").value = state.url || "";

            return row;
        }

        function restoreDocumentRows(rows) {
            container.querySelectorAll(".document-row").forEach((row) => row.remove());

            rows.forEach((state) => {
                const row = rowFromState(state);
                container.append(row);
                bindRow(row);
            });

            refreshRows();
        }

        function undoDocuments() {
            const snapshot = documentHistory.pop();
            if (!snapshot) return;

            restoreDocumentRows(snapshot);
            setDocumentUndoState();
        }

        function refreshRows() {
            const rows = [...container.querySelectorAll(".document-row")];

            rows.forEach((row, index) => {
                row.querySelector(".row-number").textContent = index + 1;
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `documents[${index}][${field.dataset.name}]`;
                });
            });

            if (emptyState) emptyState.style.display = rows.length ? "none" : "block";
        }

        function bindRow(row) {
            bindUndoScope(row);

            row.querySelector("[data-remove-row]").addEventListener("click", () => {
                pushDocumentSnapshot();
                row.remove();
                refreshRows();
            });

            row.querySelectorAll("input[type='url']").forEach((field) => {
                field.addEventListener("input", () => validateUrl(field));
                field.addEventListener("blur", () => validateUrl(field));
            });
        }

        document.getElementById("add-document").addEventListener("click", () => {
            const row = template.content.firstElementChild.cloneNode(true);
            container.append(row);
            bindRow(row);
            refreshRows();
            row.querySelector("input[type='text']").focus();
        });

        undoDocumentsButton.addEventListener("click", undoDocuments);

        document.querySelectorAll("input[type='text']").forEach((field) => {
            const shouldValidate = cleanFieldNames.some((name) => field.name.includes(`[${name}]`));

            if (shouldValidate) {
                field.addEventListener("input", () => validateCleanField(field));
                field.addEventListener("blur", () => validateCleanField(field));
            }
        });

        document.querySelectorAll("input[type='url']").forEach((field) => {
            field.addEventListener("input", () => validateUrl(field));
            field.addEventListener("blur", () => validateUrl(field));
        });

        container.querySelectorAll(".document-row").forEach(bindRow);
        document.querySelectorAll(".language-card").forEach(bindUndoScope);
        setDocumentUndoState();
        refreshRows();
    </script>
</body>
</html>
