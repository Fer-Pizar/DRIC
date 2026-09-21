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
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .memberships { display: grid; gap: 14px; }
        .panel { padding: 24px; }
        .panel-header { align-items: start; border-bottom: 1px solid var(--line); display: flex; gap: 16px; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .membership-fields { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .membership-row { box-shadow: none; padding: 18px; position: relative; }
        .membership-row { display: grid; gap: 14px; }
        .row-header { align-items: center; display: flex; justify-content: space-between; }
        .row-actions { align-items: center; display: flex; flex-wrap: wrap; gap: 10px; }
        .undo-floating { position: absolute; right: 12px; top: 12px; z-index: 4; }
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
        .preview { align-items: center; background: #f8fafc; border: 1px solid #d6deeb; border-radius: 14px; display: flex; height: 112px; justify-content: center; max-width: 260px; overflow: visible; position: relative; }
        .preview img { height: auto; max-height: 96px; max-width: 220px; object-fit: contain; padding: 10px; width: auto; }
        .preview-empty { color: var(--muted); font-size: 12px; font-weight: 800; padding: 14px; text-align: center; }
        .btn-image-remove { align-items: center; background: rgba(127,0,16,.96); border: 2px solid rgba(255,255,255,.92); border-radius: 999px; box-shadow: 0 8px 20px rgba(15,23,42,.22); color: #fff; display: inline-flex; font-size: 20px; font-weight: 900; height: 32px; justify-content: center; line-height: 1; padding: 0; position: absolute; right: -8px; top: -8px; width: 32px; z-index: 5; }
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
                    <div>
                        <h2>Encabezado</h2>
                        <p class="muted">Primera vista de la página pública: título principal y descripción introductoria.</p>
                    </div>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título principal
                                    <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                    @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción principal
                                    <textarea name="{{ $locale }}[summary]">{{ old($locale.'.summary', $content[$locale]['summary']) }}</textarea>
                                    @error($locale.'.summary')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Listado de membresías</h2>
                        <p class="muted">Texto que aparece justo antes de las tarjetas de membresías.</p>
                    </div>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Categoría de la lista
                                    <input type="text" name="{{ $locale }}[kicker]" value="{{ old($locale.'.kicker', $content[$locale]['kicker']) }}">
                                    @error($locale.'.kicker')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título de la lista
                                    <input type="text" name="{{ $locale }}[section_title]" value="{{ old($locale.'.section_title', $content[$locale]['section_title']) }}">
                                    @error($locale.'.section_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Tarjetas de membresías</h2>
                        <p class="muted">Cada tarjeta pública muestra logo, nombre, descripción, información extra opcional y botón al sitio.</p>
                    </div>
                    <div class="row-actions">
                        <button class="btn btn-undo" type="button" id="restore-membership" disabled title="Restaurar última membresía eliminada" aria-label="Restaurar última membresía eliminada">↶</button>
                        <button class="btn btn-primary" type="button" id="add-membership">Agregar membresía</button>
                    </div>
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
                                <div class="row-actions">
                                    <button class="btn btn-undo" type="button" data-undo-row disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                    <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                                </div>
                            </div>
                            <input type="hidden" data-name="id" name="memberships[{{ $index }}][id]" value="{{ $membership['id'] ?? '' }}">
                            <input type="hidden" data-name="existing_image" name="memberships[{{ $index }}][existing_image]" value="{{ $membership['existing_image'] ?? $membership['image'] ?? '' }}">
                            <input type="hidden" data-name="image_remove" name="memberships[{{ $index }}][image_remove]" value="0" data-remove-image-input>
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
                                    <div class="preview" data-image-preview>
                                        @if (!empty($membership['image']))
                                            <img src="{{ $preview($membership['image']) }}" alt="Logo actual" data-preview-image>
                                        @else
                                            <span class="preview-empty" data-preview-empty>Sin logo seleccionado.</span>
                                        @endif
                                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                    </div>
                                    <input type="file" data-name="image" name="memberships[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    <span class="hint">Solo JPG o PNG. Tamaño máximo: 10 MB. Vista previa al tamaño real del logo en la tarjeta.</span>
                                    @error('memberships.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state" id="empty-state">Todavía no hay membresías guardadas. Agrega la primera para publicarla.</div>
                    @endforelse
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Información institucional</h2>
                        <p class="muted">Bloque final que aparece después de todas las tarjetas.</p>
                    </div>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título de información
                                    <input type="text" name="{{ $locale }}[info_title]" value="{{ old($locale.'.info_title', $content[$locale]['info_title']) }}">
                                    @error($locale.'.info_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto de información
                                    <textarea name="{{ $locale }}[info_text]">{{ old($locale.'.info_text', $content[$locale]['info_text']) }}</textarea>
                                    @error($locale.'.info_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Correo de información
                                    <input type="text" name="{{ $locale }}[info_email]" value="{{ old($locale.'.info_email', $content[$locale]['info_email']) }}" placeholder="dric@umss.edu">
                                    @error($locale.'.info_email')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
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
                <div class="row-actions">
                    <button class="btn btn-undo" type="button" data-undo-row disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    <button class="btn btn-danger" type="button" data-remove-row>Quitar</button>
                </div>
            </div>
            <input type="hidden" data-name="id" value="">
            <input type="hidden" data-name="existing_image" value="">
            <input type="hidden" data-name="image_remove" value="0" data-remove-image-input>
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
                <label class="full">Imagen<div class="preview" data-image-preview><span class="preview-empty" data-preview-empty>Sin logo seleccionado.</span><button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button></div><input type="file" data-name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">Solo JPG o PNG. Tamaño máximo: 10 MB. Vista previa al tamaño real del logo en la tarjeta.</span></label>
            </div>
        </div>
    </template>

    <script>
        const cleanLabelPattern = /^[\p{L}\s.,]+$/u;
        const cleanFieldNames = ["title", "kicker", "title_es", "title_en"];
        const container = document.getElementById("memberships");
        const template = document.getElementById("membership-template");
        const emptyState = document.getElementById("empty-state");
        const restoreMembershipButton = document.getElementById("restore-membership");
        const rowHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const removedRows = [];

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
            if (file.size > 10 * 1024 * 1024) {
                field.classList.add("is-invalid");
                message.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 10 MB.";
                return;
            }

            showSelectedImage(field.closest(".membership-row"), file);
        }

        function editableFields(row) {
            return Array.from(row.querySelectorAll("input:not([type='file']), textarea"));
        }

        function imageState(row) {
            const preview = row.querySelector("[data-image-preview]");
            const image = preview?.querySelector("[data-preview-image]");
            const empty = preview?.querySelector("[data-preview-empty]");
            const fileInput = row.querySelector("input[type='file'][data-name='image']");
            const removeInput = row.querySelector("[data-remove-image-input]");

            return {
                src: image?.getAttribute("src") || "",
                imageHidden: image ? image.hidden : true,
                emptyHidden: empty ? empty.hidden : true,
                file: fileInput?.files?.[0] || null,
                removeValue: removeInput?.value || "0",
            };
        }

        function snapshotRow(row) {
            return {
                fields: editableFields(row).map((field) => ({
                    name: field.name,
                    type: field.type,
                    value: field.value,
                    checked: field.checked,
                })),
                image: imageState(row),
            };
        }

        function previewImageElement(preview) {
            let image = preview.querySelector("[data-preview-image]");

            if (!image) {
                image = document.createElement("img");
                image.alt = "Vista previa del logo";
                image.dataset.previewImage = "";
                preview.prepend(image);
            }

            image.hidden = false;
            return image;
        }

        function previewEmpty(preview) {
            let empty = preview.querySelector("[data-preview-empty]");

            if (!empty) {
                empty = document.createElement("span");
                empty.className = "preview-empty";
                empty.dataset.previewEmpty = "";
                empty.textContent = "Sin logo seleccionado.";
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function restoreImageState(row, state) {
            if (!state) return;

            const preview = row.querySelector("[data-image-preview]");
            const fileInput = row.querySelector("input[type='file'][data-name='image']");
            const removeInput = row.querySelector("[data-remove-image-input]");
            if (!preview) return;

            const image = previewImageElement(preview);
            const empty = preview.querySelector("[data-preview-empty]");

            if (state.file) {
                if (image.dataset.objectUrl) URL.revokeObjectURL(image.dataset.objectUrl);
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

            if (removeInput) removeInput.value = state.removeValue || "0";
        }

        function restoreSnapshot(row, snapshot) {
            snapshot.fields.forEach((item) => {
                const field = editableFields(row).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
            });

            restoreImageState(row, snapshot.image);
            refreshRows();
        }

        function historyFor(row) {
            if (!rowHistory.has(row)) rowHistory.set(row, []);
            return rowHistory.get(row);
        }

        function setUndoState(row) {
            const button = row.querySelector(":scope > [data-undo-row], :scope > [data-undo-card], :scope > .row-header [data-undo-row]");
            if (button) button.disabled = historyFor(row).length === 0;
        }

        function pushSnapshot(row, snapshot = snapshotRow(row)) {
            const history = historyFor(row);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) history.push(snapshot);
            if (history.length > 20) history.shift();
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
            const row = field.closest(".membership-row, .language-card");
            if (!row || fieldStartSnapshots.has(field)) return;
            fieldStartSnapshots.set(field, snapshotRow(row));
        }

        function rememberFieldChange(field) {
            const row = field.closest(".membership-row, .language-card");
            const snapshot = fieldStartSnapshots.get(field);
            if (!row || !snapshot) return;

            pushSnapshot(row, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function showSelectedImage(row, file) {
            const preview = row.querySelector("[data-image-preview]");
            const image = previewImageElement(preview);
            const empty = preview.querySelector("[data-preview-empty]");
            const removeInput = row.querySelector("[data-remove-image-input]");

            if (image.dataset.objectUrl) URL.revokeObjectURL(image.dataset.objectUrl);
            image.dataset.objectUrl = URL.createObjectURL(file);
            image.src = image.dataset.objectUrl;
            image.hidden = false;
            if (empty) empty.hidden = true;
            if (removeInput) removeInput.value = "0";
        }

        function clearImagePreview(row) {
            const preview = row.querySelector("[data-image-preview]");
            const image = preview?.querySelector("[data-preview-image]");
            const fileInput = row.querySelector("input[type='file'][data-name='image']");
            const removeInput = row.querySelector("[data-remove-image-input]");

            pushSnapshot(row);

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

            if (preview) previewEmpty(preview);
            if (removeInput) removeInput.value = "1";
        }

        function setRestoreMembershipState() {
            restoreMembershipButton.disabled = removedRows.length === 0;
        }

        function cleanRemovedRowSnapshot(row) {
            const clone = row.cloneNode(true);
            delete clone.dataset.bound;
            delete clone.dataset.undoBound;
            clone.querySelectorAll("[data-field-bound]").forEach((field) => {
                delete field.dataset.fieldBound;
            });
            clone.querySelectorAll(".live-error").forEach((message) => message.remove());
            clone.querySelectorAll(".is-invalid").forEach((field) => field.classList.remove("is-invalid"));
            return clone.outerHTML;
        }

        function rememberRemovedRow(row) {
            const rows = [...container.querySelectorAll(".membership-row")];
            removedRows.push({
                html: cleanRemovedRowSnapshot(row),
                index: rows.indexOf(row),
            });

            if (removedRows.length > 20) removedRows.shift();
            setRestoreMembershipState();
        }

        function restoreRemovedRow() {
            const snapshot = removedRows.pop();
            if (!snapshot) return;

            const wrapper = document.createElement("div");
            wrapper.innerHTML = snapshot.html.trim();
            const row = wrapper.firstElementChild;
            const reference = container.querySelectorAll(".membership-row")[snapshot.index] || null;

            container.insertBefore(row, reference);
            bindRow(row);
            refreshRows();
            setRestoreMembershipState();
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

        function bindUndoCard(card) {
            if (card.dataset.undoBound === "1") return;
            card.dataset.undoBound = "1";

            const button = document.createElement("button");
            button.className = "btn btn-undo undo-floating";
            button.type = "button";
            button.dataset.undoCard = "";
            button.disabled = true;
            button.title = "Deshacer último cambio";
            button.setAttribute("aria-label", "Deshacer último cambio");
            button.textContent = "↶";
            card.appendChild(button);
            button.addEventListener("click", () => undoRow(card));

            editableFields(card).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });

            setUndoState(card);
        }

        function bindField(field) {
            if (field.dataset.fieldBound === "1") return;
            field.dataset.fieldBound = "1";

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
                field.addEventListener("change", () => {
                    const row = field.closest(".membership-row");
                    if (row) pushSnapshot(row);
                    validateUpload(field);
                });
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
            if (row.dataset.bound === "1") return;
            row.dataset.bound = "1";

            row.querySelector("[data-undo-row]")?.addEventListener("click", () => undoRow(row));

            row.querySelector("[data-remove-row]").addEventListener("click", () => {
                rememberRemovedRow(row);
                row.remove();
                refreshRows();
            });

            row.querySelector("[data-remove-image]")?.addEventListener("click", () => clearImagePreview(row));

            editableFields(row).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });

            row.querySelectorAll("input, textarea").forEach(bindField);
            setUndoState(row);
        }

        document.getElementById("add-membership").addEventListener("click", () => {
            const row = template.content.firstElementChild.cloneNode(true);
            container.append(row);
            bindRow(row);
            refreshRows();
            row.querySelector("input[type='text']").focus();
        });

        restoreMembershipButton.addEventListener("click", restoreRemovedRow);

        document.querySelectorAll("input, textarea").forEach(bindField);
        container.querySelectorAll(".membership-row").forEach(bindRow);
        document.querySelectorAll(".language-card").forEach(bindUndoCard);
        setRestoreMembershipState();
        refreshRows();
    </script>
</body>
</html>
