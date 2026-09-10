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
        .preview { align-items: center; background: var(--soft); border-radius: 14px; display: flex; justify-content: center; min-height: 120px; overflow: hidden; padding: 10px; }
        .preview img { border-radius: 999px; height: 96px; object-fit: cover; width: 96px; }
        .meta-grid input, .meta-grid select { min-height: 48px; }
        .stars { color: #d7a526; font-size: 20px; letter-spacing: 2px; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; z-index: 5; }
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
                                <button type="button" class="btn btn-danger" data-remove-testimonial>Quitar</button>
                            </div>
                            <input type="hidden" data-name="id" name="testimonials[{{ $index }}][id]" value="{{ $testimonial['id'] ?? '' }}">
                            <input type="hidden" data-name="existing_image" name="testimonials[{{ $index }}][existing_image]" value="{{ $testimonial['existing_image'] ?? '' }}">

                            <div class="meta-grid">
                                <label>Selfie
                                    @if (! empty($testimonial['image']))
                                        <div class="preview"><img src="{{ $preview($testimonial['image']) }}" alt="Selfie actual"></div>
                                    @endif
                                    <input type="file" data-name="image" name="testimonials[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
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
                <button type="button" class="btn btn-danger" data-remove-testimonial>Quitar</button>
            </div>
            <input type="hidden" data-name="id" value="">
            <input type="hidden" data-name="existing_image" value="">
            <div class="meta-grid">
                <label>Selfie<input type="file" data-name="image" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">JPG o PNG. Máximo 5 MB.</span></label>
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

    <script>
        const list = document.getElementById("testimonial-list");
        const template = document.getElementById("testimonial-template");

        function starsForRating(value) {
            return "★".repeat(Math.max(1, Math.min(5, Math.ceil(Number(value || 10) / 2))));
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
            list.appendChild(template.content.firstElementChild.cloneNode(true));
            renameTestimonials();
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
            const file = input.files[0];
            let error = input.parentElement.querySelector(".client-file-error");
            if (!error) {
                error = document.createElement("span");
                error.className = "field-error client-file-error";
                input.parentElement.appendChild(error);
            }
            error.textContent = "";
            if (!["image/jpeg", "image/png"].includes(file.type)) {
                error.textContent = "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                input.value = "";
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                error.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.";
                input.value = "";
            }
        });

        renameTestimonials();
    </script>
</body>
</html>
