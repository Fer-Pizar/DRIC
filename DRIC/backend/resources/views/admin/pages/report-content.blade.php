<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Informes de Gestión</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .report-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
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
        form, .field-grid, .reports-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .report-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .report-card { box-shadow: none; padding: 18px; }
        .report-card { display: grid; gap: 16px; }
        .report-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .checkline { align-items: center; display: flex; gap: 10px; font-size: 13px; font-weight: 800; }
        .checkline input { height: 17px; width: 17px; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .current-file { background: var(--soft); border: 1px solid var(--line); border-radius: 12px; color: var(--muted); padding: 10px 12px; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .sticky-actions, .report-header { align-items: stretch; flex-direction: column; } .language-grid, .report-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Informes de Gestión</h1>
                <p class="muted">Edita solo el contenido público: textos, gestiones, fechas y documentos PDF. El diseño del sitio se mantiene fijo.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.reports.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Textos de la página</h2>
                    <p class="muted">Estos campos controlan los textos visibles del encabezado, el archivo y las tarjetas.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                @foreach ([
                                    'eyebrow' => 'Texto superior',
                                    'title' => 'Título',
                                    'archive_label' => 'Etiqueta del archivo',
                                    'explore_label' => 'Etiqueta de exploración',
                                    'archive_title' => 'Título del archivo',
                                    'search_placeholder' => 'Texto del buscador',
                                    'cover_eyebrow' => 'Texto superior de portada',
                                    'cover_title' => 'Título de portada',
                                    'year_label' => 'Etiqueta de gestión',
                                    'download_label' => 'Texto del botón PDF',
                                ] as $field => $fieldLabel)
                                    <label>
                                        {{ $fieldLabel }}
                                        <input type="text" name="{{ $locale }}[{{ $field }}]" value="{{ old($locale.'.'.$field, $content[$locale][$field]) }}">
                                        @error($locale.'.'.$field)<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                @endforeach

                                <label>
                                    Descripción principal
                                    <textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>
                                    @error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Descripción del archivo
                                    <textarea name="{{ $locale }}[archive_description]">{{ old($locale.'.archive_description', $content[$locale]['archive_description']) }}</textarea>
                                    @error($locale.'.archive_description')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Lista de informes</h2>
                    <p class="muted">Puedes crear, editar o quitar informes. Cada informe necesita una URL o un PDF cargado.</p>
                </div>

                <div class="reports-list" id="reports-list">
                    @forelse (old('reports', $reports) as $index => $report)
                        <article class="report-card" data-report-card>
                            <div class="report-header">
                                <div>
                                    <h3>Informe {{ $index + 1 }}</h3>
                                    <p class="muted">Se ordena automáticamente por gestión, de mayor a menor.</p>
                                </div>
                                <div class="row-actions">
                                    <label class="checkline">
                                        <input type="checkbox" name="reports[{{ $index }}][is_active]" value="1" @checked((bool) ($report['is_active'] ?? true))>
                                        Publicar
                                    </label>
                                    <button class="btn btn-remove" type="button" data-remove-report>Quitar</button>
                                </div>
                            </div>

                            <input type="hidden" name="reports[{{ $index }}][id]" value="{{ $report['id'] ?? '' }}">
                            <input type="hidden" name="reports[{{ $index }}][existing_url]" value="{{ $report['url'] ?? '' }}">

                            <div class="report-grid">
                                <label>
                                    Gestión
                                    <input type="number" min="1900" max="2100" name="reports[{{ $index }}][year]" value="{{ $report['year'] ?? '' }}" placeholder="2024">
                                    @error('reports.'.$index.'.year')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Fecha visible en español
                                    <input type="text" name="reports[{{ $index }}][date_es]" value="{{ $report['date_es'] ?? '' }}" placeholder="Oct 15, 2024">
                                    @error('reports.'.$index.'.date_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <label>
                                Fecha visible en inglés
                                <input type="text" name="reports[{{ $index }}][date_en]" value="{{ $report['date_en'] ?? '' }}" placeholder="Oct 15, 2024">
                                <span class="hint">Si se deja vacío, se usará la fecha en español.</span>
                                @error('reports.'.$index.'.date_en')<span class="field-error">{{ $message }}</span>@enderror
                            </label>

                            <div class="report-grid">
                                <label>
                                    Título en español
                                    <input type="text" name="reports[{{ $index }}][title_es]" value="{{ $report['title_es'] ?? '' }}">
                                    @error('reports.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Título en inglés
                                    <input type="text" name="reports[{{ $index }}][title_en]" value="{{ $report['title_en'] ?? '' }}">
                                    <span class="hint">Si se deja vacío, se usará el título en español.</span>
                                    @error('reports.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <label>
                                URL del PDF
                                <input type="text" name="reports[{{ $index }}][url]" value="{{ $report['url'] ?? '' }}" placeholder="https://.../informe.pdf">
                                <span class="hint">Puedes pegar una URL externa o dejar este campo vacío si subes un PDF nuevo.</span>
                                @error('reports.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>

                            @if (! empty($report['file_name']))
                                <p class="current-file">PDF cargado actualmente: {{ $report['file_name'] }}</p>
                            @endif

                            <label>
                                Subir o reemplazar PDF
                                <input type="file" name="reports[{{ $index }}][pdf]" accept="application/pdf,.pdf" data-pdf-input>
                                <span class="hint">Formato permitido: PDF. Tamaño máximo: 20 MB.</span>
                                <span class="field-error" data-pdf-error></span>
                                @error('reports.'.$index.'.pdf')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </article>
                    @empty
                    @endforelse
                </div>

                <button class="btn btn-add" type="button" id="add-report">Agregar informe</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>

        <template id="report-template">
            <article class="report-card" data-report-card>
                <div class="report-header">
                    <div>
                        <h3>Nuevo informe</h3>
                        <p class="muted">Se agregará al listado público después de guardar.</p>
                    </div>
                    <div class="row-actions">
                        <label class="checkline">
                            <input type="checkbox" name="__NAME__[is_active]" value="1" checked>
                            Publicar
                        </label>
                        <button class="btn btn-remove" type="button" data-remove-report>Quitar</button>
                    </div>
                </div>
                <input type="hidden" name="__NAME__[id]" value="">
                <input type="hidden" name="__NAME__[existing_url]" value="">
                <div class="report-grid">
                    <label>
                        Gestión
                        <input type="number" min="1900" max="2100" name="__NAME__[year]" placeholder="2024">
                    </label>
                    <label>
                        Fecha visible en español
                        <input type="text" name="__NAME__[date_es]" placeholder="Oct 15, 2024">
                    </label>
                </div>
                <label>
                    Fecha visible en inglés
                    <input type="text" name="__NAME__[date_en]" placeholder="Oct 15, 2024">
                    <span class="hint">Si se deja vacío, se usará la fecha en español.</span>
                </label>
                <div class="report-grid">
                    <label>
                        Título en español
                        <input type="text" name="__NAME__[title_es]">
                    </label>
                    <label>
                        Título en inglés
                        <input type="text" name="__NAME__[title_en]">
                        <span class="hint">Si se deja vacío, se usará el título en español.</span>
                    </label>
                </div>
                <label>
                    URL del PDF
                    <input type="text" name="__NAME__[url]" placeholder="https://.../informe.pdf">
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
        const list = document.getElementById("reports-list");
        const template = document.getElementById("report-template");
        const addButton = document.getElementById("add-report");
        let nextIndex = {{ count(old('reports', $reports)) }};

        function bindCard(card) {
            card.querySelector("[data-remove-report]").addEventListener("click", () => card.remove());
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

        document.querySelectorAll("[data-report-card]").forEach(bindCard);

        addButton.addEventListener("click", () => {
            const html = template.innerHTML.replaceAll("__NAME__", `reports[${nextIndex}]`);
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
