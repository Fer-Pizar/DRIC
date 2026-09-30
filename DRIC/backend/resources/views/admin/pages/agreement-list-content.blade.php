<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - {{ $config['page_title_es'] }}</title>
    <style>
        :root {
            --blue: #164194;
            --red: #c8102e;
            --red-dark: #7f0010;
            --ink: #172033;
            --muted: #647084;
            --line: #e5e9f0;
            --soft: #f5f7fb;
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
        .document-row {
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

        h1 {
            font-size: 34px;
            line-height: 1.1;
        }

        h2 { font-size: 22px; }

        h3 {
            color: var(--blue);
            font-size: 16px;
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

        .list-tools {
            align-items: end;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: flex-end;
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

        .pagination {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: center;
            margin-top: 18px;
        }

        .page-btn {
            background: #e8edf5;
            color: var(--ink);
            min-width: 44px;
        }

        .page-btn.is-active {
            background: var(--blue);
            color: #fff;
        }

        .page-btn:disabled {
            cursor: not-allowed;
            opacity: 0.45;
        }

        .page-ellipsis {
            color: var(--muted);
            font-weight: 800;
            padding: 0 4px;
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

        .panel { padding: 24px; }

        .workflow-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .workflow-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
            display: grid;
            gap: 8px;
            padding: 18px;
        }

        .workflow-card strong {
            align-items: center;
            color: var(--blue);
            display: flex;
            font-size: 15px;
            gap: 10px;
        }

        .workflow-card strong::before {
            align-items: center;
            background: #eef3fb;
            border-radius: 999px;
            color: var(--blue);
            content: attr(data-step);
            display: inline-flex;
            flex: 0 0 auto;
            font-size: 12px;
            height: 28px;
            justify-content: center;
            width: 28px;
        }

        .workflow-card span {
            color: var(--muted);
            font-size: 13px;
            font-weight: 600;
            line-height: 1.5;
        }

        .panel-header {
            align-items: start;
            border-bottom: 1px solid var(--line);
            display: flex;
            gap: 16px;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 16px;
        }

        .documents {
            display: grid;
            gap: 14px;
        }

        .document-row {
            box-shadow: none;
            display: grid;
            gap: 14px;
            overflow: hidden;
            padding: 0;
        }

        .row-header {
            align-items: center;
            background: linear-gradient(180deg, #f8fafc 0%, #fff 100%);
            border-bottom: 1px solid var(--line);
            display: flex;
            justify-content: space-between;
            padding: 16px 18px;
        }

        .row-title {
            display: grid;
            gap: 6px;
        }

        .row-title span {
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
        }

        .field-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            padding: 18px;
        }

        .field-grid.guide-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .field-grid .full { grid-column: 1 / -1; }
        .field-grid .wide { grid-column: span 2; }
        .field-grid.guide-grid label:first-child { grid-column: 1 / -1; }

        .custom-country-field[hidden] { display: none; }

        label {
            display: grid;
            gap: 7px;
            font-size: 13px;
            font-weight: 800;
        }

        input[type="text"],
        input[type="url"],
        textarea,
        select {
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
            min-height: 94px;
            resize: vertical;
        }

        .hint {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            line-height: 1.45;
        }

        .guide-note {
            background: #eef3fb;
            border: 1px solid rgba(22, 65, 148, .14);
            border-radius: 16px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 800;
            line-height: 1.5;
            margin: 0 0 18px;
            padding: 14px 16px;
        }

        .field-error,
        .live-error {
            color: var(--red-dark);
            font-size: 12px;
            font-weight: 800;
            line-height: 1.45;
        }

        .live-error:empty { display: none; }

        .list-status {
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .search-panel {
            align-items: center;
            background:
                linear-gradient(135deg, rgba(22, 65, 148, .08), rgba(200, 16, 46, .06)),
                #fff;
            border: 1px solid rgba(22, 65, 148, .14);
            border-radius: 18px;
            display: grid;
            gap: 14px;
            grid-template-columns: minmax(0, 1fr) auto;
            margin-bottom: 18px;
            padding: 16px;
        }

        .search-field {
            align-items: center;
            background: rgba(255, 255, 255, .86);
            border: 1px solid #cfd6e3;
            border-radius: 14px;
            display: flex;
            gap: 10px;
            padding: 0 14px;
        }

        .search-icon {
            color: var(--blue);
            flex: 0 0 auto;
            font-size: 18px;
            font-weight: 900;
        }

        .search-field input {
            background: transparent;
            border: 0;
            box-shadow: none;
            flex: 1;
            min-height: 48px;
            padding: 0;
        }

        .search-field input:focus {
            outline: none;
        }

        .btn-clear {
            background: #eef3fb;
            color: var(--blue);
            white-space: nowrap;
        }

        .search-empty {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 14px;
            color: #9a3412;
            display: none;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.5;
            margin: 0 0 18px;
            padding: 14px 16px;
        }

        .is-invalid {
            border-color: var(--red-dark) !important;
            box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10);
        }

        .empty-state {
            background: var(--soft);
            border: 1px dashed #cfd6e3;
            border-radius: 16px;
            color: var(--muted);
            padding: 22px;
            text-align: center;
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
            .panel-header,
            .sticky-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .workflow-grid {
                grid-template-columns: 1fr;
            }

            .list-tools {
                align-items: stretch;
                justify-content: flex-start;
            }

            .search-panel {
                grid-template-columns: 1fr;
            }

            .field-grid,
            .field-grid.guide-grid {
                grid-template-columns: 1fr;
            }

            .field-grid .wide { grid-column: 1; }

            h1 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>{{ $config['page_title_es'] }}</h1>
                <p class="muted">Administra los campos que usa la página pública: país o grupo, título visible y URL del documento.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.agreements.edit', $agreementPage) }}">Volver a Convenios</a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">Revisa los campos marcados. Cada error aparece exactamente debajo del campo que necesita corrección.</div>
        @endif

        <form method="POST" action="{{ route('admin.agreement-lists.update', $list) }}">
            @csrf
            @method('PUT')

            @if ($list === 'ceub-gobierno')
                <section class="workflow-grid" aria-label="Guía de edición">
                    <div class="workflow-card">
                        <strong data-step="1">Clasificación pública</strong>
                        <span>Elige CEUB, un país existente o agrega un nuevo país. Esta decisión organiza el documento en la página pública.</span>
                    </div>
                    <div class="workflow-card">
                        <strong data-step="2">Texto visible</strong>
                        <span>Revisa el título en español y su versión profesional en inglés.</span>
                    </div>
                    <div class="workflow-card">
                        <strong data-step="3">Documento</strong>
                        <span>Confirma que la URL abre el PDF o enlace institucional correcto.</span>
                    </div>
                </section>
            @endif

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Documentos publicados</h2>
                        <p class="muted">
                            @if ($list === 'ceub-gobierno')
                                La página pública agrupa primero los convenios CEUB y después los convenios bilaterales por país.
                            @else
                                Busca, agrega y edita los documentos que aparecerán en la lista pública.
                            @endif
                        </p>
                    </div>
                    <div class="list-tools">
                        @if ($list === 'ceub-gobierno')
                            <label>
                                Mostrar
                                <select id="visible-limit">
                                    <option value="10">10 documentos</option>
                                    <option value="50">50 documentos</option>
                                    <option value="100">100 documentos</option>
                                    <option value="all">Todos</option>
                                </select>
                            </label>
                        @endif
                        <button class="btn btn-undo" type="button" id="restore-document" disabled title="Restaurar último documento quitado" aria-label="Restaurar último documento quitado">↶</button>
                        <button class="btn btn-primary" type="button" id="add-document">Agregar documento</button>
                    </div>
                </div>
                @if ($list === 'ceub-gobierno')
                    <p class="guide-note">Usa “Convenios suscritos por el CEUB con otras instituciones” para el bloque CEUB. Para acuerdos bilaterales, elige el país correspondiente; si no existe, selecciona “Agregar nuevo país”.</p>
                @endif
                <div class="search-panel" role="search">
                    <label class="search-field" for="document-search">
                        <span class="search-icon" aria-hidden="true">⌕</span>
                        <input id="document-search" type="search" placeholder="{{ $list === 'ceub-gobierno' ? 'Buscar por país, título o URL' : 'Buscar por título o URL' }}">
                    </label>
                    <button class="btn btn-clear" type="button" id="clear-document-search">Limpiar búsqueda</button>
                </div>
                <p class="search-empty" id="search-empty">No se encontraron documentos con esa búsqueda. Prueba con otro título, institución, fecha o parte de la URL.</p>
                <p class="list-status" id="visible-status"></p>

                <div class="documents" id="documents">
                    @php
                        $oldDocuments = old('documents');
                        $rows = is_array($oldDocuments) ? $oldDocuments : $documents;
                    @endphp

                    @forelse ($rows as $index => $document)
                        <div class="document-row">
                            <div class="row-header">
                                <div class="row-title">
                                    <h3>Documento <span class="row-number">{{ $loop->iteration }}</span></h3>
                                    @if ($list === 'ceub-gobierno')
                                        <span>Se mostrará dentro del país o grupo seleccionado.</span>
                                    @endif
                                </div>
                                <div class="actions">
                                    <button class="btn btn-undo" type="button" data-undo-row disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                    <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                                </div>
                            </div>
                            <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document['id'] ?? '' }}">
                            <div class="field-grid {{ $list === 'ceub-gobierno' ? 'guide-grid' : '' }}">
                                @if ($list === 'ceub-gobierno')
                                    @php
                                        $selectedCountry = $document['country'] ?? '';
                                        $usesCustomCountry = $selectedCountry !== '' && ! array_key_exists($selectedCountry, $governmentGroups);
                                    @endphp
                                    <label>
                                        País o grupo
                                        <select name="documents[{{ $index }}][country]" data-country-select>
                                            <option value="">Detectar automaticamente</option>
                                            @foreach ($governmentGroups as $value => $label)
                                                <option value="{{ $value }}" @selected(! $usesCustomCountry && $selectedCountry === $value)>{{ $label }}</option>
                                            @endforeach
                                            <option value="__custom" @selected($usesCustomCountry)>Agregar nuevo país</option>
                                        </select>
                                        @error('documents.'.$index.'.country')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                    <label class="custom-country-field" @hidden(! $usesCustomCountry)>
                                        Nuevo país
                                        <input type="text" name="documents[{{ $index }}][country_custom]" value="{{ $usesCustomCountry ? $selectedCountry : '' }}" data-country-custom placeholder="Ej. Canadá">
                                        <span class="hint">Escribe el nombre como debe aparecer como grupo en la página pública.</span>
                                        @error('documents.'.$index.'.country_custom')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                @endif
                                <label>
                                    Título en español
                                    <textarea name="documents[{{ $index }}][title_es]">{{ $document['title_es'] ?? '' }}</textarea>
                                    @error('documents.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título en inglés
                                    <textarea name="documents[{{ $index }}][title_en]">{{ $document['title_en'] ?? '' }}</textarea>
                                    <span class="hint">Si queda vacío o igual al español, se completará con una versión en inglés basada en los términos oficiales ya usados por el sitio.</span>
                                    @error('documents.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="full">
                                    URL del documento
                                    <input type="url" name="documents[{{ $index }}][url]" value="{{ $document['url'] ?? '' }}" placeholder="https://sitio.edu.bo/documento.pdf">
                                    @error('documents.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" id="empty-state">Todavía no hay documentos guardados. Agrega el primer documento para publicarlo.</div>
                    @endforelse
                </div>
                @if ($list === 'ceub-gobierno')
                    <nav class="pagination" id="pagination" aria-label="Paginación de documentos"></nav>
                @endif
            </section>

            <div class="sticky-actions">
                <span class="muted">Al guardar, la lista pública usará esta información de la base de datos.</span>
                <button class="btn btn-primary" type="submit">Guardar lista</button>
            </div>
        </form>
    </main>

    <template id="document-template">
        <div class="document-row">
            <div class="row-header">
                <div class="row-title">
                    <h3>Documento <span class="row-number"></span></h3>
                    @if ($list === 'ceub-gobierno')
                        <span>Se mostrará dentro del país o grupo seleccionado.</span>
                    @endif
                </div>
                <div class="actions">
                    <button class="btn btn-undo" type="button" data-undo-row disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                </div>
            </div>
            <input type="hidden" data-name="id" value="">
            <div class="field-grid {{ $list === 'ceub-gobierno' ? 'guide-grid' : '' }}">
                @if ($list === 'ceub-gobierno')
                    <label>
                        País o grupo
                        <select data-name="country">
                            <option value="">Detectar automaticamente</option>
                            @foreach ($governmentGroups as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                            <option value="__custom">Agregar nuevo país</option>
                        </select>
                    </label>
                    <label class="custom-country-field" hidden>
                        Nuevo país
                        <input type="text" data-name="country_custom" value="" data-country-custom placeholder="Ej. Canadá">
                        <span class="hint">Escribe el nombre como debe aparecer como grupo en la página pública.</span>
                    </label>
                @endif
                <label>
                    Título en español
                    <textarea data-name="title_es"></textarea>
                </label>
                <label>
                    Título en inglés
                    <textarea data-name="title_en"></textarea>
                    <span class="hint">Si queda vacío o igual al español, se completará con una versión en inglés basada en los términos oficiales ya usados por el sitio.</span>
                </label>
                <label class="full">
                    URL del documento
                    <input type="url" data-name="url" value="" placeholder="https://sitio.edu.bo/documento.pdf">
                </label>
            </div>
        </div>
    </template>

    <script>
        const container = document.getElementById("documents");
        const template = document.getElementById("document-template");
        const emptyState = document.getElementById("empty-state");
        const visibleLimit = document.getElementById("visible-limit");
        const visibleStatus = document.getElementById("visible-status");
        const pagination = document.getElementById("pagination");
        const documentSearch = document.getElementById("document-search");
        const clearDocumentSearch = document.getElementById("clear-document-search");
        const searchEmpty = document.getElementById("search-empty");
        const restoreDocumentButton = document.getElementById("restore-document");
        const rowHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const removedRows = [];
        let currentPage = 1;

        function normalizeSearchText(value) {
            return value
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .toLocaleLowerCase();
        }

        function editableFields(row) {
            return Array.from(row.querySelectorAll("input, select, textarea"));
        }

        function snapshotRow(row) {
            return editableFields(row).map((field) => ({
                name: field.name,
                value: field.value,
            }));
        }

        function restoreSnapshot(row, snapshot) {
            snapshot.forEach((item) => {
                const field = editableFields(row).find((candidate) => candidate.name === item.name);
                if (!field) return;

                field.value = item.value;
                if (field.type === "url") {
                    validateUrl(field);
                }
            });
        }

        function historyFor(row) {
            if (!rowHistory.has(row)) {
                rowHistory.set(row, []);
            }

            return rowHistory.get(row);
        }

        function setUndoState(row) {
            const button = row.querySelector("[data-undo-row]");
            if (!button) return;

            button.disabled = historyFor(row).length === 0;
        }

        function pushSnapshot(row, snapshot = snapshotRow(row)) {
            const history = historyFor(row);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) {
                history.push(snapshot);
            }

            if (history.length > 20) {
                history.shift();
            }

            setUndoState(row);
        }

        function undoRow(row) {
            const snapshot = historyFor(row).pop();
            if (!snapshot) return;

            restoreSnapshot(row, snapshot);
            editableFields(row).forEach((field) => fieldStartSnapshots.delete(field));
            setUndoState(row);
        }

        function markFieldStart(field) {
            const row = field.closest(".document-row");
            if (!row || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotRow(row));
        }

        function rememberFieldChange(field) {
            const row = field.closest(".document-row");
            const snapshot = fieldStartSnapshots.get(field);
            if (!row || !snapshot) return;

            pushSnapshot(row, snapshot);
            fieldStartSnapshots.delete(field);
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

        function validateUrl(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();

            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!value) {
                return;
            }

            try {
                const url = new URL(value);

                if (!["http:", "https:"].includes(url.protocol)) {
                    throw new Error("invalid");
                }
            } catch {
                field.classList.add("is-invalid");
                message.textContent = "Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo/documento.pdf";
            }
        }

        function syncCountryControls(row) {
            const select = row.querySelector("[data-country-select], select[data-name='country']");
            const customField = row.querySelector(".custom-country-field");
            const customInput = row.querySelector("[data-country-custom]");

            if (!select || !customField || !customInput) {
                return;
            }

            const usesCustomCountry = select.value === "__custom";
            customField.hidden = !usesCustomCountry;

            if (!usesCustomCountry) {
                customInput.value = "";
            }
        }

        function rowSearchText(row) {
            return editableFields(row)
                .filter((field) => field.type !== "hidden")
                .map((field) => {
                    if (field.tagName === "SELECT") {
                        const option = field.selectedOptions[0];
                        return `${field.value} ${option ? option.textContent : ""}`;
                    }

                    return field.value;
                })
                .join(" ");
        }

        function filteredRows(rows) {
            const query = normalizeSearchText(documentSearch?.value.trim() || "");

            if (!query) {
                return rows;
            }

            return rows.filter((row) => normalizeSearchText(rowSearchText(row)).includes(query));
        }

        function refreshRows() {
            const rows = [...container.querySelectorAll(".document-row")];

            rows.forEach((row, index) => {
                row.querySelector(".row-number").textContent = index + 1;
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `documents[${index}][${field.dataset.name}]`;
                });
            });

            if (emptyState) {
                emptyState.style.display = rows.length ? "none" : "block";
            }

            applyPagination();
        }

        function pageSize(rows) {
            if (!visibleLimit || visibleLimit.value === "all") {
                return rows.length || 1;
            }

            return Number(visibleLimit.value);
        }

        function applyPagination() {
            const rows = [...container.querySelectorAll(".document-row")];
            const matches = filteredRows(rows);

            if (!visibleLimit) {
                const visibleRows = new Set(matches);

                rows.forEach((row) => {
                    row.style.display = visibleRows.has(row) ? "" : "none";
                });

                if (visibleStatus) {
                    visibleStatus.textContent = rows.length
                        ? `${matches.length} coincidencias de ${rows.length} documentos. Los documentos ocultos siguen guardándose al enviar el formulario.`
                        : "";
                }

                if (searchEmpty) {
                    searchEmpty.style.display = rows.length && matches.length === 0 ? "block" : "none";
                }

                return;
            }

            const size = pageSize(matches);
            const totalPages = Math.max(1, Math.ceil(matches.length / size));
            currentPage = Math.min(Math.max(currentPage, 1), totalPages);
            const start = (currentPage - 1) * size;
            const end = start + size;
            const visibleRows = new Set(matches.slice(start, end));

            rows.forEach((row) => {
                row.style.display = visibleRows.has(row) ? "" : "none";
            });

            if (visibleStatus) {
                const from = matches.length ? start + 1 : 0;
                const to = Math.min(end, matches.length);
                const searchSuffix = documentSearch?.value.trim()
                    ? ` ${matches.length} coincidencias de ${rows.length} documentos.`
                    : ` ${rows.length} documentos.`;

                visibleStatus.textContent = rows.length
                    ? `Mostrando ${from}-${to} de${searchSuffix} Los documentos ocultos siguen guardándose al enviar el formulario.`
                    : "";
            }

            if (searchEmpty) {
                searchEmpty.style.display = rows.length && matches.length === 0 ? "block" : "none";
            }

            renderPagination(totalPages);
        }

        function pageButton(label, page, options = {}) {
            const button = document.createElement("button");
            button.type = "button";
            button.className = `btn page-btn${options.active ? " is-active" : ""}`;
            button.textContent = label;
            button.disabled = Boolean(options.disabled);
            button.addEventListener("click", () => {
                currentPage = page;
                applyPagination();
                container.scrollIntoView({ behavior: "smooth", block: "start" });
            });

            return button;
        }

        function addEllipsis() {
            const ellipsis = document.createElement("span");
            ellipsis.className = "page-ellipsis";
            ellipsis.textContent = "...";
            pagination.append(ellipsis);
        }

        function renderPagination(totalPages) {
            if (!pagination) {
                return;
            }

            pagination.innerHTML = "";

            if (!visibleLimit || visibleLimit.value === "all" || totalPages <= 1) {
                return;
            }

            pagination.append(pageButton("Anterior", currentPage - 1, { disabled: currentPage === 1 }));

            const pages = new Set([1, totalPages, currentPage, currentPage - 1, currentPage + 1]);
            let previousPage = 0;

            [...pages]
                .filter((page) => page >= 1 && page <= totalPages)
                .sort((a, b) => a - b)
                .forEach((page) => {
                    if (previousPage && page - previousPage > 1) {
                        addEllipsis();
                    }

                    pagination.append(pageButton(String(page), page, { active: page === currentPage }));
                    previousPage = page;
                });

            pagination.append(pageButton("Siguiente", currentPage + 1, { disabled: currentPage === totalPages }));
        }

        function setRestoreDocumentState() {
            restoreDocumentButton.disabled = removedRows.length === 0;
        }

        function snapshotRemovedRow(row) {
            const clone = row.cloneNode(true);
            delete clone.dataset.bound;
            clone.querySelectorAll(".live-error").forEach((message) => message.remove());
            clone.querySelectorAll(".is-invalid").forEach((field) => field.classList.remove("is-invalid"));

            return clone.outerHTML;
        }

        function rememberRemovedRow(row) {
            const rows = [...container.querySelectorAll(".document-row")];
            removedRows.push({
                html: snapshotRemovedRow(row),
                index: rows.indexOf(row),
            });

            if (removedRows.length > 20) {
                removedRows.shift();
            }

            setRestoreDocumentState();
        }

        function restoreRemovedRow() {
            const snapshot = removedRows.pop();
            if (!snapshot) return;

            const wrapper = document.createElement("div");
            wrapper.innerHTML = snapshot.html.trim();
            const row = wrapper.firstElementChild;
            const reference = container.querySelectorAll(".document-row")[snapshot.index] || null;

            container.insertBefore(row, reference);
            bindRow(row);
            refreshRows();
            setRestoreDocumentState();
        }

        function bindRow(row) {
            if (row.dataset.bound === "1") return;
            row.dataset.bound = "1";

            row.querySelector("[data-undo-row]")?.addEventListener("click", () => undoRow(row));

            row.querySelector("[data-remove-row]").addEventListener("click", () => {
                rememberRemovedRow(row);
                row.remove();
                refreshRows();
            });

            editableFields(row).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => {
                    rememberFieldChange(field);
                    applyPagination();
                });
                field.addEventListener("change", () => {
                    rememberFieldChange(field);
                    applyPagination();
                });
            });

            row.querySelectorAll("input[type='url']").forEach((field) => {
                field.addEventListener("input", () => validateUrl(field));
                field.addEventListener("blur", () => validateUrl(field));
            });

            row.querySelectorAll("[data-country-select], select[data-name='country']").forEach((field) => {
                field.addEventListener("change", () => syncCountryControls(row));
            });

            syncCountryControls(row);
            setUndoState(row);
        }

        document.getElementById("add-document").addEventListener("click", () => {
            const row = template.content.firstElementChild.cloneNode(true);
            container.append(row);
            bindRow(row);
            if (visibleLimit) {
                visibleLimit.value = "all";
            }
            if (documentSearch) {
                documentSearch.value = "";
            }
            currentPage = 1;
            refreshRows();
            row.querySelector("textarea")?.focus();
        });

        restoreDocumentButton.addEventListener("click", restoreRemovedRow);

        visibleLimit?.addEventListener("change", () => {
            currentPage = 1;
            applyPagination();
        });

        documentSearch?.addEventListener("input", () => {
            currentPage = 1;
            applyPagination();
        });

        clearDocumentSearch?.addEventListener("click", () => {
            if (!documentSearch) return;

            documentSearch.value = "";
            currentPage = 1;
            applyPagination();
            documentSearch.focus();
        });

        container.querySelectorAll(".document-row").forEach(bindRow);
        setRestoreDocumentState();
        refreshRows();
    </script>
</body>
</html>
