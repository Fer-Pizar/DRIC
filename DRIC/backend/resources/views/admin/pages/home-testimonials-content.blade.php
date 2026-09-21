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
    $rows = old('testimonials', $testimonials);
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Testimonios de estudiantes</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1220px; padding: 36px 20px 56px; }
        .topbar, .panel, .testimonial-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2, h3 { color: var(--blue); }
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
        form, .section-grid { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .testimonial-card { box-shadow: none; padding: 18px; }
        .card-head { align-items: center; display: flex; gap: 12px; justify-content: space-between; margin-bottom: 16px; }
        .language-grid, .meta-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .meta-grid { align-items: start; grid-template-columns: 180px minmax(180px, 240px) minmax(200px, 260px); }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea, select { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 130px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .preview { align-items: center; background: #111827; border: 1px solid #d6deeb; border-radius: 18px; display: flex; justify-content: center; margin-bottom: 12px; overflow: visible; padding: 0; position: relative; width: 100%; }
        .preview[data-image-preview] { cursor: pointer; }
        .preview-selfie { aspect-ratio: 1 / 1; border-radius: 999px; max-width: 180px; }
        .preview img { border-radius: inherit; height: 100%; object-fit: cover; width: 100%; }
        .preview-empty { color: rgba(255,255,255,.72); padding: 18px; text-align: center; }
        .preview-ruler { align-items: center; background: rgba(2,6,23,.76); border: 1px solid rgba(255,255,255,.16); border-radius: 999px; color: #fff; display: inline-flex; font-size: 11px; font-weight: 900; gap: 6px; left: 10px; line-height: 1; padding: 7px 10px; position: absolute; top: 10px; }
        .preview-ruler::before { content: ""; background: repeating-linear-gradient(90deg, #fff 0 1px, transparent 1px 7px); display: block; height: 10px; opacity: .82; width: 34px; }
        .btn-image-remove { align-items: center; background: rgba(127,0,16,.96); border: 2px solid rgba(255,255,255,.92); border-radius: 999px; box-shadow: 0 8px 20px rgba(15,23,42,.22); color: #fff; display: inline-flex; font-size: 20px; font-weight: 900; height: 32px; justify-content: center; line-height: 1; padding: 0; position: absolute; right: -8px; top: -8px; width: 32px; z-index: 5; }
        .meta-grid input, .meta-grid select { min-height: 48px; }
        .stars { color: #d7a526; font-size: 20px; letter-spacing: 2px; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; z-index: 5; }
        .crop-modal { align-items: center; background: rgba(2,6,23,.78); display: none; inset: 0; justify-content: center; padding: 18px; position: fixed; z-index: 50; }
        .crop-modal.is-open { display: flex; }
        .crop-dialog { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 30px 90px rgba(0,0,0,.34); display: grid; gap: 16px; max-height: calc(100vh - 36px); max-width: 920px; overflow: auto; padding: 18px; width: min(100%, 920px); }
        .crop-top { align-items: start; display: flex; gap: 16px; justify-content: space-between; }
        .crop-stage { align-items: center; background: #020617; border-radius: 16px; display: flex; justify-content: center; min-height: 280px; overflow: hidden; padding: 16px; position: relative; touch-action: none; }
        .crop-frame { border: 2px solid #fff; border-radius: 999px; box-shadow: 0 0 0 999px rgba(2,6,23,.58), 0 18px 44px rgba(0,0,0,.3); cursor: grab; max-height: min(68vh, 620px); overflow: hidden; position: relative; width: min(100%, 620px); }
        .crop-frame.is-dragging { cursor: grabbing; }
        .crop-frame img { left: 50%; max-width: none; position: absolute; top: 50%; transform-origin: center; user-select: none; -webkit-user-drag: none; }
        .crop-controls { align-items: center; display: grid; gap: 10px; grid-template-columns: auto minmax(180px, 1fr); }
        .crop-controls input { padding: 0; }
        .crop-actions { display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end; }
        @media (max-width: 940px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .meta-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Testimonios de estudiantes</h1>
                <p class="muted">Administra las tarjetas reales que aparecen en Inicio. Puedes agregar, editar, ordenar o quitar testimonios.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.home.edit', $page) }}">Volver a Inicio</a>
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Páginas</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.home-testimonials.update', $page) }}" enctype="multipart/form-data" id="testimonials-form">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Lista de testimonios</h2>
                    <p class="muted">El orden de las tarjetas aquí será el mismo orden del carrusel en la página pública.</p>
                </div>

                <div class="section-grid" id="testimonial-list">
                    @foreach ($rows as $index => $testimonial)
                        <article class="testimonial-card testimonial-row">
                            <div class="card-head">
                                <div>
                                    <h3>Testimonio {{ $index + 1 }}</h3>
                                    <p class="muted">Calificación visual: <span class="stars" data-stars>{{ str_repeat('★', (int) ceil(((int) ($testimonial['rating'] ?? 10)) / 2)) }}</span></p>
                                </div>
                                <div class="actions">
                                    <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                    <button type="button" class="btn btn-danger" data-remove-testimonial>Quitar</button>
                                </div>
                            </div>
                            <input type="hidden" data-name="id" name="testimonials[{{ $index }}][id]" value="{{ $testimonial['id'] ?? '' }}">
                            <input type="hidden" data-name="existing_image" name="testimonials[{{ $index }}][existing_image]" value="{{ $testimonial['existing_image'] ?? '' }}">
                            <input type="hidden" data-name="image_remove" name="testimonials[{{ $index }}][image_remove]" value="0" data-remove-image-input>

                            <div class="meta-grid">
                                <label data-image-card data-crop-aspect="1" data-crop-label="Marco cuadrado 1:1, igual al selfie circular del carrusel.">Selfie
                                    <div class="preview preview-selfie" data-image-preview>
                                        @if (! empty($testimonial['image']))
                                            <img src="{{ $preview($testimonial['image']) }}" alt="Selfie actual" data-preview-image>
                                        @else
                                            <span class="preview-empty" data-preview-empty>Sin selfie seleccionado.</span>
                                        @endif
                                        <span class="preview-ruler">1:1 selfie</span>
                                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar selfie actual">×</button>
                                    </div>
                                    <input type="file" data-name="image" name="testimonials[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                                    <span class="hint">JPG o PNG. Máximo 5 MB.</span>
                                    @error('testimonials.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>Fecha<input type="date" data-name="experience_date" name="testimonials[{{ $index }}][experience_date]" value="{{ $testimonial['experience_date'] ?? '' }}">@error('testimonials.'.$index.'.experience_date')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Calificación de 1 a 10
                                    <select data-name="rating" name="testimonials[{{ $index }}][rating]" data-rating>
                                        @for ($rating = 10; $rating >= 1; $rating--)
                                            <option value="{{ $rating }}" @selected((int) ($testimonial['rating'] ?? 10) === $rating)>{{ $rating }}/10</option>
                                        @endfor
                                    </select>
                                    <span class="hint">10/10 muestra 5 estrellas completas en la página pública.</span>
                                    @error('testimonials.'.$index.'.rating')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <div class="language-grid">
                                <div>
                                    <h3>Español</h3>
                                    <label>Nombre del estudiante<input type="text" data-name="name_es" name="testimonials[{{ $index }}][name_es]" value="{{ $testimonial['name_es'] ?? '' }}">@error('testimonials.'.$index.'.name_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>País<input type="text" data-name="country_es" name="testimonials[{{ $index }}][country_es]" value="{{ $testimonial['country_es'] ?? '' }}">@error('testimonials.'.$index.'.country_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>Tipo de movilidad<input type="text" data-name="mobility_type_es" name="testimonials[{{ $index }}][mobility_type_es]" value="{{ $testimonial['mobility_type_es'] ?? '' }}">@error('testimonials.'.$index.'.mobility_type_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>Descripción<textarea data-name="description_es" name="testimonials[{{ $index }}][description_es]">{{ $testimonial['description_es'] ?? '' }}</textarea>@error('testimonials.'.$index.'.description_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                </div>
                                <div>
                                    <h3>Inglés</h3>
                                    <label>Nombre del estudiante<input type="text" data-name="name_en" name="testimonials[{{ $index }}][name_en]" value="{{ $testimonial['name_en'] ?? '' }}">@error('testimonials.'.$index.'.name_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>País<input type="text" data-name="country_en" name="testimonials[{{ $index }}][country_en]" value="{{ $testimonial['country_en'] ?? '' }}">@error('testimonials.'.$index.'.country_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>Tipo de movilidad<input type="text" data-name="mobility_type_en" name="testimonials[{{ $index }}][mobility_type_en]" value="{{ $testimonial['mobility_type_en'] ?? '' }}">@error('testimonials.'.$index.'.mobility_type_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>Descripción<textarea data-name="description_en" name="testimonials[{{ $index }}][description_en]">{{ $testimonial['description_en'] ?? '' }}</textarea>@error('testimonials.'.$index.'.description_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <button type="button" class="btn btn-secondary" id="add-testimonial">Agregar testimonio</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se mostrarán al recargar Inicio.</span>
                <button class="btn btn-primary" type="submit">Guardar testimonios</button>
            </div>
        </form>
    </main>

    <template id="testimonial-template">
        <article class="testimonial-card testimonial-row">
            <div class="card-head">
                <div>
                    <h3>Nuevo testimonio</h3>
                    <p class="muted">Calificación visual: <span class="stars" data-stars>★★★★★</span></p>
                </div>
                <div class="actions">
                    <button class="btn btn-undo" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    <button type="button" class="btn btn-danger" data-remove-testimonial>Quitar</button>
                </div>
            </div>
            <input type="hidden" data-name="id" value="">
            <input type="hidden" data-name="existing_image" value="">
            <input type="hidden" data-name="image_remove" value="0" data-remove-image-input>
            <div class="meta-grid">
                <label data-image-card data-crop-aspect="1" data-crop-label="Marco cuadrado 1:1, igual al selfie circular del carrusel.">Selfie
                    <div class="preview preview-selfie" data-image-preview>
                        <span class="preview-empty" data-preview-empty>Sin selfie seleccionado.</span>
                        <span class="preview-ruler">1:1 selfie</span>
                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar selfie actual">×</button>
                    </div>
                    <input type="file" data-name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                    <span class="hint">JPG o PNG. Máximo 5 MB.</span>
                </label>
                <label>Fecha<input type="date" data-name="experience_date" value=""></label>
                <label>Calificación de 1 a 10
                    <select data-name="rating" data-rating>
                        @for ($rating = 10; $rating >= 1; $rating--)
                            <option value="{{ $rating }}">{{ $rating }}/10</option>
                        @endfor
                    </select>
                    <span class="hint">10/10 muestra 5 estrellas completas en la página pública.</span>
                </label>
            </div>
            <div class="language-grid">
                <div>
                    <h3>Español</h3>
                    <label>Nombre del estudiante<input type="text" data-name="name_es" value=""></label>
                    <label>País<input type="text" data-name="country_es" value=""></label>
                    <label>Tipo de movilidad<input type="text" data-name="mobility_type_es" value=""></label>
                    <label>Descripción<textarea data-name="description_es"></textarea></label>
                </div>
                <div>
                    <h3>Inglés</h3>
                    <label>Nombre del estudiante<input type="text" data-name="name_en" value=""></label>
                    <label>País<input type="text" data-name="country_en" value=""></label>
                    <label>Tipo de movilidad<input type="text" data-name="mobility_type_en" value=""></label>
                    <label>Descripción<textarea data-name="description_en"></textarea></label>
                </div>
            </div>
        </article>
    </template>

    <div class="crop-modal" id="crop-modal" aria-hidden="true">
        <div class="crop-dialog" role="dialog" aria-modal="true" aria-labelledby="crop-title">
            <div class="crop-top">
                <div>
                    <h2 id="crop-title">Recortar selfie</h2>
                    <p class="muted" id="crop-help">Ajusta la imagen dentro del marco circular del carrusel.</p>
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
        const list = document.getElementById("testimonial-list");
        const template = document.getElementById("testimonial-template");
        const maxImageBytes = 5 * 1024 * 1024;
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();

        function starsForRating(value) {
            return "★".repeat(Math.max(1, Math.min(5, Math.ceil(Number(value || 10) / 2))));
        }

        function editableFields(card) {
            return Array.from(card.querySelectorAll("input:not([type='file']), textarea, select"));
        }

        function imageState(card) {
            const imageCard = card.querySelector("[data-image-card]");
            const preview = imageCard?.querySelector("[data-image-preview]");
            const image = preview?.querySelector("[data-preview-image]");
            const empty = preview?.querySelector("[data-preview-empty]");
            const fileInput = imageCard?.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");

            return {
                src: image?.getAttribute("src") || "",
                imageHidden: image ? image.hidden : true,
                emptyHidden: empty ? empty.hidden : true,
                file: fileInput?.files?.[0] || null,
                removeValue: removeInput?.value || "0",
            };
        }

        function snapshotCard(card) {
            return {
                fields: editableFields(card).map((field) => ({
                    name: field.name,
                    type: field.type,
                    value: field.value,
                    checked: field.checked,
                })),
                image: imageState(card),
            };
        }

        function restoreImageState(card, state) {
            if (!state) return;

            const imageCard = card.querySelector("[data-image-card]");
            const preview = imageCard?.querySelector("[data-image-preview]");
            const fileInput = imageCard?.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");
            if (!imageCard || !preview) return;

            const image = previewImageElement(preview);
            const empty = preview.querySelector("[data-preview-empty]");

            if (state.file) {
                if (image.dataset.objectUrl) {
                    URL.revokeObjectURL(image.dataset.objectUrl);
                }
                image.dataset.objectUrl = URL.createObjectURL(state.file);
                image.src = image.dataset.objectUrl;
                image.hidden = Boolean(state.imageHidden);
                if (empty) {
                    empty.hidden = true;
                }
            } else if (state.src) {
                image.src = state.src;
                image.hidden = Boolean(state.imageHidden);
                if (empty) {
                    empty.hidden = true;
                }
            } else {
                image.removeAttribute("src");
                image.hidden = true;
                if (empty) {
                    empty.hidden = Boolean(state.emptyHidden);
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
            }

            if (removeInput) {
                removeInput.value = state.removeValue || "0";
            }
        }

        function restoreSnapshot(card, snapshot) {
            const fields = Array.isArray(snapshot) ? snapshot : snapshot.fields;

            fields.forEach((item) => {
                const field = editableFields(card).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
            });
            restoreImageState(card, Array.isArray(snapshot) ? null : snapshot.image);
            renameTestimonials();
        }

        function historyFor(card) {
            if (!cardHistory.has(card)) {
                cardHistory.set(card, []);
            }

            return cardHistory.get(card);
        }

        function setUndoState(card) {
            const button = card.querySelector("[data-undo-card]");
            if (!button) return;

            button.disabled = historyFor(card).length === 0;
        }

        function pushSnapshot(card, snapshot = snapshotCard(card)) {
            const history = historyFor(card);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) {
                history.push(snapshot);
            }

            if (history.length > 20) {
                history.shift();
            }

            setUndoState(card);
        }

        function undoCard(card) {
            const snapshot = historyFor(card).pop();
            if (!snapshot) return;

            restoreSnapshot(card, snapshot);
            editableFields(card).forEach((field) => fieldStartSnapshots.delete(field));
            setUndoState(card);
        }

        function markFieldStart(field) {
            const card = field.closest(".testimonial-row");
            if (!card || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotCard(card));
        }

        function rememberFieldChange(field) {
            const card = field.closest(".testimonial-row");
            const snapshot = fieldStartSnapshots.get(field);
            if (!card || !snapshot) return;

            pushSnapshot(card, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function bindUndoCard(card) {
            if (card.dataset.undoBound === "1") return;
            card.dataset.undoBound = "1";

            card.querySelector("[data-undo-card]")?.addEventListener("click", () => undoCard(card));
            editableFields(card).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });
            setUndoState(card);
        }

        function renameTestimonials() {
            [...list.querySelectorAll(".testimonial-row")].forEach((row, index) => {
                row.querySelector("h3").textContent = `Testimonio ${index + 1}`;
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `testimonials[${index}][${field.dataset.name}]`;
                });
                const rating = row.querySelector("[data-rating]");
                const stars = row.querySelector("[data-stars]");
                if (rating && stars) stars.textContent = starsForRating(rating.value);
            });
        }

        document.getElementById("add-testimonial").addEventListener("click", () => {
            const row = template.content.firstElementChild.cloneNode(true);
            list.appendChild(row);
            renameTestimonials();
            bindUndoCard(row);
            bindImageCard(row.querySelector("[data-image-card]"));
        });

        list.addEventListener("click", (event) => {
            if (!event.target.matches("[data-remove-testimonial]")) return;
            event.target.closest(".testimonial-row").remove();
            renameTestimonials();
        });

        list.addEventListener("change", (event) => {
            const input = event.target;
            if (input.matches("[data-rating]")) {
                renameTestimonials();
                return;
            }

            if (input.type !== "file" || !input.files.length) return;
        });

        function imageErrorFor(input) {
            let error = input.parentElement.querySelector(".client-file-error");
            if (!error) {
                error = document.createElement("span");
                error.className = "field-error client-file-error";
                input.parentElement.appendChild(error);
            }

            return error;
        }

        function validateImageInput(input) {
            const file = input.files[0];
            const error = imageErrorFor(input);
            error.textContent = "";

            if (!file) return false;

            if (!["image/jpeg", "image/png"].includes(file.type)) {
                error.textContent = "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                input.value = "";
                return false;
            }

            if (file.size > maxImageBytes) {
                error.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.";
                input.value = "";
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
                empty.textContent = "Sin selfie seleccionado.";
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function previewImageElement(preview) {
            let image = preview.querySelector("[data-preview-image]");

            if (!image) {
                image = document.createElement("img");
                image.alt = "Vista previa del selfie";
                image.dataset.previewImage = "";
                preview.prepend(image);
            }

            image.hidden = false;
            return image;
        }

        function clearImagePreview(card) {
            const row = card.closest(".testimonial-row");
            const preview = card.querySelector("[data-image-preview]");
            const image = preview.querySelector("[data-preview-image]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = row.querySelector("[data-remove-image-input]");

            pushSnapshot(row);

            if (fileInput) {
                fileInput.value = "";
                imageErrorFor(fileInput).textContent = "";
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
            const removeInput = card.closest(".testimonial-row").querySelector("[data-remove-image-input]");

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
            if (!card || card.dataset.imageBound === "1") return;
            card.dataset.imageBound = "1";

            const fileInput = card.querySelector("[data-image-file]");
            const removeButton = card.querySelector("[data-remove-image]");
            const preview = card.querySelector("[data-image-preview]");

            function requestImageFile() {
                if (!fileInput) return;
                fileInput.click();
            }

            preview?.addEventListener("click", (event) => {
                if (event.target.closest("[data-remove-image]")) return;
                requestImageFile();
            });

            removeButton?.addEventListener("click", (event) => {
                event.stopPropagation();
                clearImagePreview(card);
            });

            fileInput?.addEventListener("change", () => {
                if (!validateImageInput(fileInput)) return;
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

        function frameSizeForAspect(aspect) {
            const availableWidth = Math.min(620, cropFrame.parentElement.clientWidth - 32);
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
            const imageWidth = cropState.naturalWidth * cropState.baseScale * cropState.zoom;
            const imageHeight = cropState.naturalHeight * cropState.baseScale * cropState.zoom;
            const maxX = Math.max(0, (imageWidth - cropFrame.clientWidth) / 2);
            const maxY = Math.max(0, (imageHeight - cropFrame.clientHeight) / 2);

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
            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = card;
            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropHelp.textContent = card.dataset.cropLabel || "Marco cuadrado 1:1, igual al selfie circular del carrusel.";
            cropModal.classList.add("is-open");
            cropModal.setAttribute("aria-hidden", "false");

            const size = frameSizeForAspect(Number(card.dataset.cropAspect || "1"));
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
                if (fileInput) fileInput.value = "";
            }

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = null;
            cropState.file = null;
            cropState.objectUrl = "";
            cropImage.removeAttribute("src");
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
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");
            const base = file.name.replace(/\.[^.]+$/, "") || "selfie";
            const croppedName = `${base}-recortada.jpg`;

            canvas.width = 900;
            canvas.height = 900;
            context.drawImage(cropImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, 900, 900);

            canvas.toBlob((blob) => {
                if (!blob) return;

                const cropped = new File([blob], croppedName, { type: "image/jpeg" });
                const transfer = new DataTransfer();
                const fileInput = card.querySelector("[data-image-file]");

                transfer.items.add(cropped);
                fileInput.files = transfer.files;
                showSelectedImage(card, cropped);
                imageErrorFor(fileInput).textContent = "";
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
            if (event.target === cropModal) closeCropTool(true);
        });
        window.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && cropModal.classList.contains("is-open")) {
                closeCropTool(true);
            }
        });

        renameTestimonials();
        document.querySelectorAll(".testimonial-row").forEach(bindUndoCard);
        document.querySelectorAll("[data-image-card]").forEach(bindImageCard);
    </script>
</body>
</html>
