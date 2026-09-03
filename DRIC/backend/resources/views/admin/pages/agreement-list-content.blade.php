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
            padding: 18px;
        }

        .row-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
        }

        .field-grid {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .field-grid .full { grid-column: 1 / -1; }

        label {
            display: grid;
            gap: 7px;
            font-size: 13px;
            font-weight: 800;
        }

        input[type="text"],
        input[type="url"] {
            border: 1px solid #cfd6e3;
            border-radius: 12px;
            color: var(--ink);
            font: inherit;
            font-weight: 500;
            padding: 12px 13px;
            width: 100%;
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

            .field-grid {
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
                <h1>{{ $config['page_title_es'] }}</h1>
                <p class="muted">Administra únicamente el título y la URL de cada documento. Los cambios se reflejan en la página pública.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.agreements.edit', $agreementPage) }}">Volver a Convenios</a>
                <a class="btn btn-secondary" href="{{ $config['public_url'] }}" target="_blank">Ver página pública</a>
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

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Documentos publicados</h2>
                        <p class="muted">Puedes agregar nuevos documentos, editar sus enlaces o quitar los que ya no deben mostrarse.</p>
                    </div>
                    <button class="btn btn-primary" type="button" id="add-document">Agregar documento</button>
                </div>

                <div class="documents" id="documents">
                    @php
                        $oldDocuments = old('documents');
                        $rows = is_array($oldDocuments) ? $oldDocuments : $documents;
                    @endphp

                    @forelse ($rows as $index => $document)
                        <div class="document-row">
                            <div class="row-header">
                                <h3>Documento <span class="row-number">{{ $loop->iteration }}</span></h3>
                                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                            </div>
                            <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document['id'] ?? '' }}">
                            <div class="field-grid">
                                <label>
                                    Título en español
                                    <input type="text" name="documents[{{ $index }}][title_es]" value="{{ $document['title_es'] ?? '' }}">
                                    @error('documents.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título en inglés
                                    <input type="text" name="documents[{{ $index }}][title_en]" value="{{ $document['title_en'] ?? '' }}">
                                    <span class="hint">Si se deja vacío, se usará el título en español.</span>
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
                <h3>Documento <span class="row-number"></span></h3>
                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
            </div>
            <input type="hidden" data-name="id" value="">
            <div class="field-grid">
                <label>
                    Título en español
                    <input type="text" data-name="title_es" value="">
                </label>
                <label>
                    Título en inglés
                    <input type="text" data-name="title_en" value="">
                    <span class="hint">Si se deja vacío, se usará el título en español.</span>
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
        }

        function bindRow(row) {
            row.querySelector("[data-remove-row]").addEventListener("click", () => {
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

        container.querySelectorAll(".document-row").forEach(bindRow);
        refreshRows();
    </script>
</body>
</html>
