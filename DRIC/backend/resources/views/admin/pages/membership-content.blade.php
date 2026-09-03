<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Contenido de Membresías</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .membership-row { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
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
        form, .field-grid, .memberships { display: grid; gap: 14px; }
        .panel { padding: 24px; }
        .panel-header { align-items: start; border-bottom: 1px solid var(--line); display: flex; gap: 16px; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .membership-fields { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .membership-row { box-shadow: none; padding: 18px; }
        .membership-row { display: grid; gap: 14px; }
        .row-header { align-items: center; display: flex; justify-content: space-between; }
        .full { grid-column: 1 / -1; }
        .toggle-field { align-items: center; background: #f8fafc; border: 1px solid var(--line); border-radius: 14px; display: flex; gap: 12px; justify-content: space-between; padding: 12px 14px; }
        .toggle-field input { height: 18px; width: 18px; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input[type="text"], input[type="url"], input[type="file"], textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error, .live-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .live-error:empty { display: none; }
        .is-invalid { border-color: var(--red-dark) !important; box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10); }
        .preview { align-items: center; background: #e8edf5; border-radius: 14px; display: flex; height: 130px; justify-content: center; overflow: hidden; }
        .preview img { height: 100%; object-fit: contain; padding: 12px; width: 100%; }
        .empty-state { background: var(--soft); border: 1px dashed #cfd6e3; border-radius: 16px; color: var(--muted); padding: 22px; text-align: center; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .panel-header, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .membership-fields { grid-template-columns: 1fr; } h1 { font-size: 28px; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contenido de Membresías</h1>
                <p class="muted">Administra textos, enlaces e imágenes de las membresías. El botón público siempre dirá Visitar sitio.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.memberships.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Textos generales</h2>
                <p class="muted">Encabezado, título de la lista e información institucional.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                @foreach ([
                                    'title' => 'Título principal',
                                    'summary' => 'Descripción principal',
                                    'kicker' => 'Categoría de la lista',
                                    'section_title' => 'Título de la lista',
                                    'info_title' => 'Título de información',
                                    'info_text' => 'Texto de información',
                                ] as $field => $labelText)
                                    <label>
                                        {{ $labelText }}
                                        @if (str_contains($field, 'text') || $field === 'summary')
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
                        <h2>Membresías</h2>
                        <p class="muted">Agrega o quita tarjetas. Cada tarjeta permite título, descripción corta, URL e imagen JPG o PNG.</p>
                    </div>
                    <button class="btn btn-primary" type="button" id="add-membership">Agregar membresía</button>
                </div>

                <div class="memberships" id="memberships">
                    @php
                        $oldMemberships = old('memberships');
                        $rows = is_array($oldMemberships) ? $oldMemberships : $memberships;
                    @endphp

                    @forelse ($rows as $index => $membership)
                        <div class="membership-row">
                            <div class="row-header">
                                <h3>Membresía <span class="row-number">{{ $loop->iteration }}</span></h3>
                                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                            </div>
                            <input type="hidden" data-name="id" name="memberships[{{ $index }}][id]" value="{{ $membership['id'] ?? '' }}">
                            <input type="hidden" data-name="existing_image" name="memberships[{{ $index }}][existing_image]" value="{{ $membership['existing_image'] ?? $membership['image'] ?? '' }}">
                            <div class="membership-fields">
                                <label>
                                    Título en español
                                    <input type="text" data-name="title_es" name="memberships[{{ $index }}][title_es]" value="{{ $membership['title_es'] ?? '' }}">
                                    @error('memberships.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título en inglés
                                    <input type="text" data-name="title_en" name="memberships[{{ $index }}][title_en]" value="{{ $membership['title_en'] ?? '' }}">
                                    @error('memberships.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción en español
                                    <textarea data-name="description_es" name="memberships[{{ $index }}][description_es]">{{ $membership['description_es'] ?? '' }}</textarea>
                                    @error('memberships.'.$index.'.description_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción en inglés
                                    <textarea data-name="description_en" name="memberships[{{ $index }}][description_en]">{{ $membership['description_en'] ?? '' }}</textarea>
                                    @error('memberships.'.$index.'.description_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="full">
                                    URL del sitio
                                    <input type="url" data-name="url" name="memberships[{{ $index }}][url]" value="{{ $membership['url'] ?? '' }}" placeholder="https://sitio.edu.bo">
                                    <span class="hint">Si se deja vacío, la tarjeta no mostrará botón.</span>
                                    @error('memberships.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="toggle-field full">
                                    <span>
                                        Mostrar información extra
                                        <span class="hint">Activa esta opción si la tarjeta necesita texto adicional y correo de contacto.</span>
                                    </span>
                                    <input type="checkbox" data-name="extra_info_enabled" name="memberships[{{ $index }}][extra_info_enabled]" value="1" @checked((bool) ($membership['extra_info_enabled'] ?? false))>
                                </label>
                                <label class="pador-field">
                                    Texto de información extra en español
                                    <textarea data-name="pador_text_es" name="memberships[{{ $index }}][pador_text_es]">{{ $membership['pador_text_es'] ?? '' }}</textarea>
                                    <span class="hint">Este texto se muestra dentro de la tarjeta cuando el interruptor está activo.</span>
                                    @error('memberships.'.$index.'.pador_text_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="pador-field">
                                    Texto de información extra en inglés
                                    <textarea data-name="pador_text_en" name="memberships[{{ $index }}][pador_text_en]">{{ $membership['pador_text_en'] ?? '' }}</textarea>
                                    <span class="hint">Si se deja vacío, se usará el texto en español.</span>
                                    @error('memberships.'.$index.'.pador_text_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="pador-field full">
                                    Correo de contacto
                                    <input type="text" data-name="extra_info_email" name="memberships[{{ $index }}][extra_info_email]" value="{{ $membership['extra_info_email'] ?? '' }}" placeholder="dric@umss.edu.bo">
                                    <span class="hint">Solo este campo permite @ y caracteres propios de un correo.</span>
                                    @error('memberships.'.$index.'.extra_info_email')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label class="full">
                                    Imagen
                                    @if (!empty($membership['image']))
                                        <div class="preview"><img src="{{ $membership['image'] }}" alt="Imagen actual"></div>
                                    @endif
                                    <input type="file" data-name="image" name="memberships[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    <span class="hint">Solo JPG o PNG. Tamaño máximo: 5 MB.</span>
                                    @error('memberships.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" id="empty-state">Todavía no hay membresías guardadas. Agrega la primera para publicarla.</div>
                    @endforelse
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <template id="membership-template">
        <div class="membership-row">
            <div class="row-header">
                <h3>Membresía <span class="row-number"></span></h3>
                <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
            </div>
            <input type="hidden" data-name="id" value="">
            <input type="hidden" data-name="existing_image" value="">
            <div class="membership-fields">
                <label>Título en español<input type="text" data-name="title_es" value=""></label>
                <label>Título en inglés<input type="text" data-name="title_en" value=""></label>
                <label>Descripción en español<textarea data-name="description_es"></textarea></label>
                <label>Descripción en inglés<textarea data-name="description_en"></textarea></label>
                <label class="full">URL del sitio<input type="url" data-name="url" value="" placeholder="https://sitio.edu.bo"><span class="hint">Si se deja vacío, la tarjeta no mostrará botón.</span></label>
                <label class="toggle-field full"><span>Mostrar información extra<span class="hint">Activa esta opción si la tarjeta necesita texto adicional y correo de contacto.</span></span><input type="checkbox" data-name="extra_info_enabled" value="1"></label>
                <label class="pador-field">Texto de información extra en español<textarea data-name="pador_text_es"></textarea><span class="hint">Este texto se muestra dentro de la tarjeta cuando el interruptor está activo.</span></label>
                <label class="pador-field">Texto de información extra en inglés<textarea data-name="pador_text_en"></textarea><span class="hint">Si se deja vacío, se usará el texto en español.</span></label>
                <label class="pador-field full">Correo de contacto<input type="text" data-name="extra_info_email" value="" placeholder="dric@umss.edu.bo"><span class="hint">Solo este campo permite @ y caracteres propios de un correo.</span></label>
                <label class="full">Imagen<input type="file" data-name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">Solo JPG o PNG. Tamaño máximo: 5 MB.</span></label>
            </div>
        </div>
    </template>

    <script>
        const cleanLabelPattern = /^[\p{L}\s.,]+$/u;
        const cleanFieldNames = ["title", "kicker", "title_es", "title_en"];
        const container = document.getElementById("memberships");
        const template = document.getElementById("membership-template");
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
                message.textContent = "No uses números en títulos o categorías.";
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
                message.textContent = "Ingresa una URL completa y válida, por ejemplo: https://sitio.edu.bo";
            }
        }

        function validateEmail(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();
            field.classList.remove("is-invalid");
            message.textContent = "";
            if (!value) return;
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "Ingresa un correo válido, por ejemplo: dric@umss.edu.bo";
            }
        }

        function validateUpload(field) {
            const message = ensureLiveError(field);
            const file = field.files?.[0];
            field.classList.remove("is-invalid");
            message.textContent = "";
            if (!file) return;
            if (!["image/jpeg", "image/png"].includes(file.type)) {
                field.classList.add("is-invalid");
                message.textContent = "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                field.classList.add("is-invalid");
                message.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.";
            }
        }

        function refreshRows() {
            const rows = [...container.querySelectorAll(".membership-row")];
            rows.forEach((row, index) => {
                row.querySelector(".row-number").textContent = index + 1;
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `memberships[${index}][${field.dataset.name}]`;
                });
                const extraInfoToggle = row.querySelector("[data-name='extra_info_enabled']");
                const showPadorFields = extraInfoToggle.checked;
                row.querySelectorAll(".pador-field").forEach((field) => {
                    field.style.display = showPadorFields ? "grid" : "none";
                });
            });
            if (emptyState) emptyState.style.display = rows.length ? "none" : "block";
        }

        function bindField(field) {
            if (field.matches("input[type='url']")) {
                field.addEventListener("input", () => {
                    validateUrl(field);
                });
                field.addEventListener("blur", () => {
                    validateUrl(field);
                });
            }
            if (field.dataset.name === "extra_info_email") {
                field.addEventListener("input", () => validateEmail(field));
                field.addEventListener("blur", () => validateEmail(field));
            }
            if (field.dataset.name === "extra_info_enabled") {
                field.addEventListener("change", refreshRows);
            }
            if (field.matches("input[type='file']")) {
                field.addEventListener("change", () => validateUpload(field));
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

        document.getElementById("add-membership").addEventListener("click", () => {
            const row = template.content.firstElementChild.cloneNode(true);
            container.append(row);
            bindRow(row);
            refreshRows();
            row.querySelector("input[type='text']").focus();
        });

        document.querySelectorAll("input, textarea").forEach(bindField);
        container.querySelectorAll(".membership-row").forEach(bindRow);
        refreshRows();
    </script>
</body>
</html>
