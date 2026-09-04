<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Contenido de Noticias</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .news-row { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
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
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .news-list { display: grid; gap: 14px; }
        .panel { padding: 24px; }
        .panel-header { align-items: start; border-bottom: 1px solid var(--line); display: flex; gap: 16px; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .news-fields { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .news-row { box-shadow: none; padding: 18px; }
        .news-row { display: grid; gap: 14px; }
        .row-header { align-items: center; display: flex; justify-content: space-between; }
        .full { grid-column: 1 / -1; }
        .toggle-field { align-items: center; background: #f8fafc; border: 1px solid var(--line); border-radius: 14px; display: flex; gap: 12px; justify-content: space-between; padding: 12px 14px; }
        .toggle-field input { height: 18px; width: 18px; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input[type="text"], input[type="url"], input[type="date"], textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error, .live-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .live-error:empty { display: none; }
        .is-invalid { border-color: var(--red-dark) !important; box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10); }
        .empty-state { background: var(--soft); border: 1px dashed #cfd6e3; border-radius: 16px; color: var(--muted); padding: 22px; text-align: center; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .panel-header, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .news-fields { grid-template-columns: 1fr; } h1 { font-size: 28px; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contenido de Noticias</h1>
                <p class="muted">Administra el encabezado y las noticias visibles en la página pública. El diseño del sitio no se modifica desde aquí.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.news.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Textos generales</h2>
                    <p class="muted">Encabezado, buscador y textos de botones.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                @foreach ([
                                    'title' => 'Título principal',
                                    'summary' => 'Descripción principal',
                                    'kicker' => 'Etiqueta de sección',
                                    'section_title' => 'Título de sección',
                                    'search_placeholder' => 'Texto del buscador',
                                    'read_more_label' => 'Texto del botón',
                                ] as $field => $labelText)
                                    <label>
                                        {{ $labelText }}
                                        @if ($field === 'summary')
                                            <textarea name="{{ $locale }}[{{ $field }}]">{{ old($locale.'.'.$field, $content[$locale][$field]) }}</textarea>
                                        @else
                                            <input type="text" name="{{ $locale }}[{{ $field }}]" value="{{ old($locale.'.'.$field, $content[$locale][$field]) }}">
                                        @endif
                                        @error($locale.'.'.$field)<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Noticias</h2>
                        <p class="muted">Agrega, quita, publica u oculta tarjetas. Esta vista conserva el diseño original sin fotos.</p>
                    </div>
                    <button class="btn btn-primary" type="button" id="add-news">Agregar noticia</button>
                </div>

                <div class="news-list" id="news-list">
                    @php
                        $oldNews = old('news');
                        $rows = is_array($oldNews) ? $oldNews : $newsItems;
                    @endphp

                    @forelse ($rows as $index => $item)
                        <div class="news-row">
                            <div class="row-header">
                                <h3>Noticia <span class="row-number">{{ $loop->iteration }}</span></h3>
                                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                            </div>
                            <input type="hidden" data-name="id" name="news[{{ $index }}][id]" value="{{ $item['id'] ?? '' }}">
                            <div class="news-fields">
                                <label class="toggle-field full">
                                    <span>
                                        Publicar noticia
                                        <span class="hint">Si está desactivado, la noticia queda guardada pero no aparece en la página pública.</span>
                                    </span>
                                    <input type="checkbox" data-name="is_active" name="news[{{ $index }}][is_active]" value="1" @checked((bool) ($item['is_active'] ?? true))>
                                </label>
                                <label>
                                    Título en español
                                    <input type="text" data-name="title_es" name="news[{{ $index }}][title_es]" value="{{ $item['title_es'] ?? '' }}">
                                    @error('news.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título en inglés
                                    <input type="text" data-name="title_en" name="news[{{ $index }}][title_en]" value="{{ $item['title_en'] ?? '' }}">
                                    @error('news.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Categoría en español
                                    <input type="text" data-name="category_es" name="news[{{ $index }}][category_es]" value="{{ $item['category_es'] ?? '' }}">
                                    @error('news.'.$index.'.category_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Categoría en inglés
                                    <input type="text" data-name="category_en" name="news[{{ $index }}][category_en]" value="{{ $item['category_en'] ?? '' }}">
                                    @error('news.'.$index.'.category_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Fecha visible en español
                                    <input type="text" data-name="date_es" name="news[{{ $index }}][date_es]" value="{{ $item['date_es'] ?? '' }}" placeholder="Dic 17, 2024">
                                    @error('news.'.$index.'.date_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Fecha visible en inglés
                                    <input type="text" data-name="date_en" name="news[{{ $index }}][date_en]" value="{{ $item['date_en'] ?? '' }}" placeholder="Dec 17, 2024">
                                    @error('news.'.$index.'.date_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="full">
                                    Fecha de publicación
                                    <input type="date" data-name="published_at" name="news[{{ $index }}][published_at]" value="{{ $item['published_at'] ?? now()->toDateString() }}">
                                    <span class="hint">Se usa para ordenar y mantener la fecha real de publicación.</span>
                                    @error('news.'.$index.'.published_at')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Resumen en español
                                    <textarea data-name="excerpt_es" name="news[{{ $index }}][excerpt_es]">{{ $item['excerpt_es'] ?? '' }}</textarea>
                                    @error('news.'.$index.'.excerpt_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Resumen en inglés
                                    <textarea data-name="excerpt_en" name="news[{{ $index }}][excerpt_en]">{{ $item['excerpt_en'] ?? '' }}</textarea>
                                    @error('news.'.$index.'.excerpt_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="full">
                                    Enlace de la noticia
                                    <input type="text" data-name="href" name="news[{{ $index }}][href]" value="{{ $item['href'] ?? '' }}" placeholder="/noticias/1 o https://sitio.edu.bo/noticia">
                                    <span class="hint">Usa una URL completa o una ruta interna que empiece con /.</span>
                                    @error('news.'.$index.'.href')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" id="empty-state">Todavía no hay noticias guardadas. Agrega la primera para publicarla.</div>
                    @endforelse
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <template id="news-template">
        <div class="news-row">
            <div class="row-header">
                <h3>Noticia <span class="row-number"></span></h3>
                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
            </div>
            <input type="hidden" data-name="id" value="">
            <div class="news-fields">
                <label class="toggle-field full"><span>Publicar noticia<span class="hint">Si está desactivado, la noticia queda guardada pero no aparece en la página pública.</span></span><input type="checkbox" data-name="is_active" value="1" checked></label>
                <label>Título en español<input type="text" data-name="title_es" value=""></label>
                <label>Título en inglés<input type="text" data-name="title_en" value=""></label>
                <label>Categoría en español<input type="text" data-name="category_es" value=""></label>
                <label>Categoría en inglés<input type="text" data-name="category_en" value=""></label>
                <label>Fecha visible en español<input type="text" data-name="date_es" value="" placeholder="Dic 17, 2024"></label>
                <label>Fecha visible en inglés<input type="text" data-name="date_en" value="" placeholder="Dec 17, 2024"></label>
                <label class="full">Fecha de publicación<input type="date" data-name="published_at" value="{{ now()->toDateString() }}"><span class="hint">Se usa para ordenar y mantener la fecha real de publicación.</span></label>
                <label>Resumen en español<textarea data-name="excerpt_es"></textarea></label>
                <label>Resumen en inglés<textarea data-name="excerpt_en"></textarea></label>
                <label class="full">Enlace de la noticia<input type="text" data-name="href" value="" placeholder="/noticias/1 o https://sitio.edu.bo/noticia"><span class="hint">Usa una URL completa o una ruta interna que empiece con /.</span></label>
            </div>
        </div>
    </template>

    <script>
        const cleanLabelPattern = /^[\p{L}\s.,]+$/u;
        const cleanFieldNames = ["title", "kicker", "read_more_label", "category_es", "category_en"];
        const container = document.getElementById("news-list");
        const template = document.getElementById("news-template");
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

        function validateCleanField(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();
            field.classList.remove("is-invalid");
            message.textContent = "";
            if (!value) return;
            if (/\d/u.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "No uses números en categorías o textos cortos.";
                return;
            }
            if (!cleanLabelPattern.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "Solo se permiten letras, espacios, puntos y comas.";
            }
        }

        function validateHref(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();
            field.classList.remove("is-invalid");
            message.textContent = "";
            if (!value) return;
            if (value.startsWith("/")) return;
            try {
                const url = new URL(value);
                if (!["http:", "https:"].includes(url.protocol)) throw new Error("invalid");
            } catch {
                field.classList.add("is-invalid");
                message.textContent = "Ingresa una URL completa o una ruta interna que empiece con /.";
            }
        }

        function refreshRows() {
            const rows = [...container.querySelectorAll(".news-row")];
            rows.forEach((row, index) => {
                row.querySelector(".row-number").textContent = index + 1;
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `news[${index}][${field.dataset.name}]`;
                });
            });
            if (emptyState) emptyState.style.display = rows.length ? "none" : "block";
        }

        function bindField(field) {
            if (field.dataset.name === "href") {
                field.addEventListener("input", () => validateHref(field));
                field.addEventListener("blur", () => validateHref(field));
            }
            if (field.matches("input[type='text']")) {
                const shouldValidate = cleanFieldNames.some((name) => field.name.includes(`[${name}]`) || field.dataset.name === name);
                if (shouldValidate) {
                    field.addEventListener("input", () => validateCleanField(field));
                    field.addEventListener("blur", () => validateCleanField(field));
                }
            }
        }

        function bindRow(row) {
            row.querySelector("[data-remove-row]").addEventListener("click", () => {
                row.remove();
                refreshRows();
            });
            row.querySelectorAll("input, textarea").forEach(bindField);
        }

        document.getElementById("add-news").addEventListener("click", () => {
            const row = template.content.firstElementChild.cloneNode(true);
            container.append(row);
            bindRow(row);
            refreshRows();
            row.querySelector("input[type='text']").focus();
        });

        document.querySelectorAll("input, textarea").forEach(bindField);
        container.querySelectorAll(".news-row").forEach(bindRow);
        refreshRows();
    </script>
</body>
</html>
