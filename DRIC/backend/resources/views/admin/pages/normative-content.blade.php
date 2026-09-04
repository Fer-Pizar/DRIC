<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Contenido de Normativas</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; --orange: #f59e0b; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .document-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .row-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .documents-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .document-card { box-shadow: none; padding: 18px; }
        .document-card { display: grid; gap: 16px; }
        .document-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        .document-grid { display: grid; gap: 14px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea, select { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 112px; resize: vertical; }
        select { background: #fff; }
        .checkline { align-items: center; display: flex; gap: 10px; font-size: 13px; font-weight: 800; }
        .checkline input { height: 17px; width: 17px; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .current-file { background: var(--soft); border: 1px solid var(--line); border-radius: 12px; color: var(--muted); padding: 10px 12px; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .sticky-actions, .document-header { align-items: stretch; flex-direction: column; } .language-grid, .document-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contenido de Normativas</h1>
                <p class="muted">Edita solo el contenido público: textos, categorías y documentos PDF. El diseño del sitio se mantiene fijo.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.normatives.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado de la página</h2>
                    <p class="muted">Estos textos aparecen sobre el buscador y el listado de normativas.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Texto superior
                                    <input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">
                                    @error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

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
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Lista de documentos</h2>
                    <p class="muted">Puedes crear, editar o quitar documentos. Cada normativa necesita una URL o un PDF cargado.</p>
                </div>

                <div class="documents-list" id="documents-list">
                    @forelse (old('documents', $documents) as $index => $document)
                        <article class="document-card" data-document-card>
                            <div class="document-header">
                                <div>
                                    <h3>Normativa {{ $index + 1 }}</h3>
                                    <p class="muted">Orden actual del documento en la página pública.</p>
                                </div>
                                <div class="row-actions">
                                    <label class="checkline">
                                        <input type="checkbox" name="documents[{{ $index }}][is_active]" value="1" @checked((bool) ($document['is_active'] ?? true))>
                                        Publicar
                                    </label>
                                    <button class="btn btn-remove" type="button" data-remove-document>Quitar</button>
                                </div>
                            </div>

                            <input type="hidden" name="documents[{{ $index }}][id]" value="{{ $document['id'] ?? '' }}">
                            <input type="hidden" name="documents[{{ $index }}][existing_url]" value="{{ $document['url'] ?? '' }}">

                            <div class="document-grid">
                                <label>
                                    Código visible
                                    <input type="text" name="documents[{{ $index }}][code]" value="{{ $document['code'] ?? '' }}" placeholder="Ej.: UMSS_RCU-AGO/2025">
                                    @error('documents.'.$index.'.code')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Categoría
                                    <select name="documents[{{ $index }}][category]">
                                        @foreach ($categories as $key => $category)
                                            <option value="{{ $key }}" @selected(($document['category'] ?? 'primero') === $key)>{{ $category['es'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('documents.'.$index.'.category')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <div class="document-grid">
                                <label>
                                    Título en español
                                    <textarea name="documents[{{ $index }}][title_es]">{{ $document['title_es'] ?? '' }}</textarea>
                                    @error('documents.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Título en inglés
                                    <textarea name="documents[{{ $index }}][title_en]">{{ $document['title_en'] ?? '' }}</textarea>
                                    <span class="hint">Si se deja vacío, se usará el título en español.</span>
                                    @error('documents.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <label>
                                URL del PDF
                                <input type="url" name="documents[{{ $index }}][url]" value="{{ $document['url'] ?? '' }}" placeholder="https://.../documento.pdf">
                                <span class="hint">Puedes pegar una URL externa o dejar este campo vacío si subes un PDF nuevo.</span>
                                @error('documents.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>

                            @if (! empty($document['file_name']))
                                <p class="current-file">PDF cargado actualmente: {{ $document['file_name'] }}</p>
                            @endif

                            <label>
                                Subir o reemplazar PDF
                                <input type="file" name="documents[{{ $index }}][pdf]" accept="application/pdf,.pdf" data-pdf-input>
                                <span class="hint">Formato permitido: PDF. Tamaño máximo: 20 MB.</span>
                                <span class="field-error" data-pdf-error></span>
                                @error('documents.'.$index.'.pdf')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </article>
                    @empty
                    @endforelse
                </div>

                <button class="btn btn-add" type="button" id="add-document">Agregar normativa</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>

        <template id="document-template">
            <article class="document-card" data-document-card>
                <div class="document-header">
                    <div>
                        <h3>Nueva normativa</h3>
                        <p class="muted">Se agregará al listado público después de guardar.</p>
                    </div>
                    <div class="row-actions">
                        <label class="checkline">
                            <input type="checkbox" name="__NAME__[is_active]" value="1" checked>
                            Publicar
                        </label>
                        <button class="btn btn-remove" type="button" data-remove-document>Quitar</button>
                    </div>
                </div>
                <input type="hidden" name="__NAME__[id]" value="">
                <input type="hidden" name="__NAME__[existing_url]" value="">
                <div class="document-grid">
                    <label>
                        Código visible
                        <input type="text" name="__NAME__[code]" placeholder="Ej.: UMSS_RCU-AGO/2025">
                    </label>
                    <label>
                        Categoría
                        <select name="__NAME__[category]">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key }}">{{ $category['es'] }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="document-grid">
                    <label>
                        Título en español
                        <textarea name="__NAME__[title_es]"></textarea>
                    </label>
                    <label>
                        Título en inglés
                        <textarea name="__NAME__[title_en]"></textarea>
                        <span class="hint">Si se deja vacío, se usará el título en español.</span>
                    </label>
                </div>
                <label>
                    URL del PDF
                    <input type="url" name="__NAME__[url]" placeholder="https://.../documento.pdf">
                    <span class="hint">Puedes pegar una URL externa o dejar este campo vacío si subes un PDF nuevo.</span>
                </label>
                <label>
                    Subir PDF
                    <input type="file" name="__NAME__[pdf]" accept="application/pdf,.pdf" data-pdf-input>
                    <span class="hint">Formato permitido: PDF. Tamaño máximo: 20 MB.</span>
                    <span class="field-error" data-pdf-error></span>
                </label>
            </article>
        </template>
    </main>

    <script>
        const list = document.getElementById("documents-list");
        const template = document.getElementById("document-template");
        const addButton = document.getElementById("add-document");
        let nextIndex = {{ count(old('documents', $documents)) }};

        function bindCard(card) {
            card.querySelector("[data-remove-document]").addEventListener("click", () => card.remove());
            card.querySelectorAll("[data-pdf-input]").forEach((input) => {
                input.addEventListener("change", (event) => {
                    const message = input.closest("label").querySelector("[data-pdf-error]");
                    const file = event.target.files[0];
                    message.textContent = "";

                    if (!file) return;

                    if (file.type !== "application/pdf" && !file.name.toLowerCase().endsWith(".pdf")) {
                        message.textContent = "Ese formato no está permitido. Sube un PDF.";
                        event.target.value = "";
                        return;
                    }

                    if (file.size > 20 * 1024 * 1024) {
                        message.textContent = "El PDF sobrepasa los 20MB.";
                        event.target.value = "";
                    }
                });
            });
        }

        document.querySelectorAll("[data-document-card]").forEach(bindCard);

        addButton.addEventListener("click", () => {
            const html = template.innerHTML.replaceAll("__NAME__", `documents[${nextIndex}]`);
            const wrapper = document.createElement("div");
            wrapper.innerHTML = html.trim();
            const card = wrapper.firstElementChild;
            list.appendChild(card);
            bindCard(card);
            nextIndex += 1;
        });
    </script>
</body>
</html>
