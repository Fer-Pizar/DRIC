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
    <title>Panel DRIC - Inicio</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1220px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .item-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
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
        form, .field-grid, .section-grid { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid, .three-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .three-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 18px; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 108px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .preview { align-items: center; background: var(--soft); border-radius: 14px; display: flex; justify-content: center; min-height: 140px; overflow: hidden; padding: 10px; }
        .preview img { max-height: 180px; max-width: 100%; object-fit: contain; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; z-index: 5; }
        .remove-row { align-items: center; display: flex; justify-content: space-between; gap: 12px; }
        @media (max-width: 940px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .two-grid, .three-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Inicio</h1>
                <p class="muted">Edita el contenido real de la página principal sin cambiar el diseño del sitio.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.home.update', $page) }}" enctype="multipart/form-data" id="home-form">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Portada y botones</h2>
                    <p class="muted">Puedes editar los textos visibles y los enlaces de los botones superiores.</p>
                </div>
                <div class="three-grid">
                    <label>Enlace del tag superior<input type="text" name="hero_badge_link" value="{{ old('hero_badge_link', $content['hero_badge_link']) }}">@error('hero_badge_link')<span class="field-error">{{ $message }}</span>@enderror</label>
                    <label>Enlace del botón principal<input type="text" name="hero_primary_link" value="{{ old('hero_primary_link', $content['hero_primary_link']) }}">@error('hero_primary_link')<span class="field-error">{{ $message }}</span>@enderror</label>
                    <label>Enlace del botón secundario<input type="text" name="hero_secondary_link" value="{{ old('hero_secondary_link', $content['hero_secondary_link']) }}">@error('hero_secondary_link')<span class="field-error">{{ $message }}</span>@enderror</label>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título interno de página<input type="text" name="{{ $locale }}[page_title]" value="{{ old($locale.'.page_title', $content[$locale]['page_title']) }}">@error($locale.'.page_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto del tag superior<input type="text" name="{{ $locale }}[hero_badge]" value="{{ old($locale.'.hero_badge', $content[$locale]['hero_badge']) }}">@error($locale.'.hero_badge')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Título principal<input type="text" name="{{ $locale }}[hero_title]" value="{{ old($locale.'.hero_title', $content[$locale]['hero_title']) }}">@error($locale.'.hero_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Descripción principal<textarea name="{{ $locale }}[hero_summary]">{{ old($locale.'.hero_summary', $content[$locale]['hero_summary']) }}</textarea>@error($locale.'.hero_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto del botón principal<input type="text" name="{{ $locale }}[hero_primary_label]" value="{{ old($locale.'.hero_primary_label', $content[$locale]['hero_primary_label']) }}">@error($locale.'.hero_primary_label')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto del botón secundario<input type="text" name="{{ $locale }}[hero_secondary_label]" value="{{ old($locale.'.hero_secondary_label', $content[$locale]['hero_secondary_label']) }}">@error($locale.'.hero_secondary_label')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Convocatoria de becas</h2>
                    <p class="muted">Las tarjetas de países son fijas. Puedes editar etiqueta, enlace e imagen, pero no agregar ni eliminar países desde Inicio.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título<input type="text" name="{{ $locale }}[scholarships_title]" value="{{ old($locale.'.scholarships_title', $content[$locale]['scholarships_title']) }}">@error($locale.'.scholarships_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Subtítulo<input type="text" name="{{ $locale }}[scholarships_subtitle]" value="{{ old($locale.'.scholarships_subtitle', $content[$locale]['scholarships_subtitle']) }}">@error($locale.'.scholarships_subtitle')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Descripción<textarea name="{{ $locale }}[scholarships_summary]">{{ old($locale.'.scholarships_summary', $content[$locale]['scholarships_summary']) }}</textarea>@error($locale.'.scholarships_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="three-grid">
                    @foreach ($content['countries'] as $index => $country)
                        <article class="item-card">
                            <h3>País {{ $index }}</h3>
                            <input type="hidden" name="countries[{{ $index }}][existing_image]" value="{{ old('countries.'.$index.'.existing_image', $country['existing_image']) }}">
                            @if ($country['image'])
                                <div class="preview"><img src="{{ $preview($country['image']) }}" alt="Imagen actual"></div>
                            @endif
                            <label>Nombre en español<input type="text" name="countries[{{ $index }}][title_es]" value="{{ old('countries.'.$index.'.title_es', $country['title_es']) }}">@error('countries.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Nombre en inglés<input type="text" name="countries[{{ $index }}][title_en]" value="{{ old('countries.'.$index.'.title_en', $country['title_en']) }}">@error('countries.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Identificador URL<input type="text" name="countries[{{ $index }}][slug]" value="{{ old('countries.'.$index.'.slug', $country['slug']) }}">@error('countries.'.$index.'.slug')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Enlace<input type="text" name="countries[{{ $index }}][href]" value="{{ old('countries.'.$index.'.href', $country['href']) }}">@error('countries.'.$index.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Imagen<input type="file" name="countries[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">JPG o PNG. Máximo 5 MB.</span>@error('countries.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Conócenos</h2>
                    <p class="muted">Contenido de la sección institucional que aparece después de las becas.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título Conócenos<input type="text" name="{{ $locale }}[about_title]" value="{{ old($locale.'.about_title', $content[$locale]['about_title']) }}">@error($locale.'.about_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto Conócenos<textarea name="{{ $locale }}[about_summary]">{{ old($locale.'.about_summary', $content[$locale]['about_summary']) }}</textarea>@error($locale.'.about_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <article class="item-card">
                    <h3>Imagen Conócenos</h3>
                    @if ($content['about_image']) <div class="preview"><img src="{{ $preview($content['about_image']) }}" alt="Imagen actual"></div> @endif
                    <label>Subir nueva imagen<input type="file" name="about_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">No se cambia la imagen anterior hasta guardar una nueva. Máximo 5 MB.</span>@error('about_image')<span class="field-error">{{ $message }}</span>@enderror</label>
                </article>
            </section>

            <section class="panel">
                <div class="panel-header"><h2>Acuerdos recientes</h2><p class="muted">Texto introductorio y tres tarjetas fijas: título, enlace e imagen.</p></div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título acuerdos<input type="text" name="{{ $locale }}[agreements_title]" value="{{ old($locale.'.agreements_title', $content[$locale]['agreements_title']) }}">@error($locale.'.agreements_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto acuerdos<textarea name="{{ $locale }}[agreements_summary]">{{ old($locale.'.agreements_summary', $content[$locale]['agreements_summary']) }}</textarea>@error($locale.'.agreements_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="three-grid">
                    @foreach ($content['agreements'] as $index => $agreement)
                        <article class="item-card">
                            <h3>Acuerdo {{ $index }}</h3>
                            <input type="hidden" name="agreements[{{ $index }}][existing_image]" value="{{ old('agreements.'.$index.'.existing_image', $agreement['existing_image']) }}">
                            @if ($agreement['image']) <div class="preview"><img src="{{ $preview($agreement['image']) }}" alt="Imagen actual"></div> @endif
                            <label>Título español<input type="text" name="agreements[{{ $index }}][title_es]" value="{{ old('agreements.'.$index.'.title_es', $agreement['title_es']) }}">@error('agreements.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Título inglés<input type="text" name="agreements[{{ $index }}][title_en]" value="{{ old('agreements.'.$index.'.title_en', $agreement['title_en']) }}">@error('agreements.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Enlace<input type="text" name="agreements[{{ $index }}][href]" value="{{ old('agreements.'.$index.'.href', $agreement['href']) }}">@error('agreements.'.$index.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Imagen<input type="file" name="agreements[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">JPG o PNG. Máximo 5 MB.</span>@error('agreements.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Dirección, misión y propósito</h2>
                    <p class="muted">Textos de presentación institucional y bloques informativos.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título director<input type="text" name="{{ $locale }}[director_title]" value="{{ old($locale.'.director_title', $content[$locale]['director_title']) }}">@error($locale.'.director_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Subtítulo director<input type="text" name="{{ $locale }}[director_subtitle]" value="{{ old($locale.'.director_subtitle', $content[$locale]['director_subtitle']) }}">@error($locale.'.director_subtitle')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto director<textarea name="{{ $locale }}[director_summary]">{{ old($locale.'.director_summary', $content[$locale]['director_summary']) }}</textarea>@error($locale.'.director_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="two-grid">
                    @foreach ($content['director_blocks'] as $index => $block)
                        <article class="item-card">
                            <h3>Bloque {{ $index }}</h3>
                            <label>Título español<input type="text" name="director_blocks[{{ $index }}][title_es]" value="{{ old('director_blocks.'.$index.'.title_es', $block['title_es']) }}">@error('director_blocks.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto español<textarea name="director_blocks[{{ $index }}][summary_es]">{{ old('director_blocks.'.$index.'.summary_es', $block['summary_es']) }}</textarea>@error('director_blocks.'.$index.'.summary_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Título inglés<input type="text" name="director_blocks[{{ $index }}][title_en]" value="{{ old('director_blocks.'.$index.'.title_en', $block['title_en']) }}">@error('director_blocks.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto inglés<textarea name="director_blocks[{{ $index }}][summary_en]">{{ old('director_blocks.'.$index.'.summary_en', $block['summary_en']) }}</textarea>@error('director_blocks.'.$index.'.summary_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Indicadores</h2>
                    <p class="muted">Texto de contexto y cifras destacadas de la página principal.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título indicadores<input type="text" name="{{ $locale }}[stats_title]" value="{{ old($locale.'.stats_title', $content[$locale]['stats_title']) }}">@error($locale.'.stats_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Subtítulo indicadores<input type="text" name="{{ $locale }}[stats_subtitle]" value="{{ old($locale.'.stats_subtitle', $content[$locale]['stats_subtitle']) }}">@error($locale.'.stats_subtitle')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto indicadores<textarea name="{{ $locale }}[stats_summary]">{{ old($locale.'.stats_summary', $content[$locale]['stats_summary']) }}</textarea>@error($locale.'.stats_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="three-grid">
                    @foreach ($content['stats'] as $index => $stat)
                        <article class="item-card">
                            <h3>Indicador {{ $index }}</h3>
                            <label>Valor<input type="text" name="stats[{{ $index }}][value]" value="{{ old('stats.'.$index.'.value', $stat['value']) }}">@error('stats.'.$index.'.value')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Etiqueta español<input type="text" name="stats[{{ $index }}][label_es]" value="{{ old('stats.'.$index.'.label_es', $stat['label_es']) }}">@error('stats.'.$index.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Etiqueta inglés<input type="text" name="stats[{{ $index }}][label_en]" value="{{ old('stats.'.$index.'.label_en', $stat['label_en']) }}">@error('stats.'.$index.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Experiencias de estudiantes</h2>
                    <p class="muted">Texto general de la sección. Los testimonios individuales se administran en su propio panel.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título de la sección<input type="text" name="{{ $locale }}[testimonials_title]" value="{{ old($locale.'.testimonials_title', $content[$locale]['testimonials_title']) }}">@error($locale.'.testimonials_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Descripción de la sección<textarea name="{{ $locale }}[testimonials_summary]">{{ old($locale.'.testimonials_summary', $content[$locale]['testimonials_summary']) }}</textarea>@error($locale.'.testimonials_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto del botón<input type="text" name="{{ $locale }}[testimonials_button_label]" value="{{ old($locale.'.testimonials_button_label', $content[$locale]['testimonials_button_label']) }}">@error($locale.'.testimonials_button_label')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="two-grid">
                    <article class="item-card">
                        <h3>Enlace del botón</h3>
                        <label>URL del botón<input type="text" name="testimonials_button_link" value="{{ old('testimonials_button_link', $content['testimonials_button_link']) }}">@error('testimonials_button_link')<span class="field-error">{{ $message }}</span>@enderror</label>
                    </article>
                    <article class="item-card">
                        <h3>Testimonios de estudiantes</h3>
                        <p class="muted">Agrega, edita, ordena o quita las tarjetas de estudiantes desde el panel dedicado.</p>
                        <a class="btn btn-primary" href="{{ route('admin.home-testimonials.edit', $page) }}">Administrar testimonios</a>
                    </article>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Preguntas frecuentes</h2>
                    <p class="muted">Esta es la única sección de Inicio donde puedes agregar o quitar elementos.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título FAQ<input type="text" name="{{ $locale }}[faq_title]" value="{{ old($locale.'.faq_title', $content[$locale]['faq_title']) }}">@error($locale.'.faq_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Subtítulo FAQ<input type="text" name="{{ $locale }}[faq_subtitle]" value="{{ old($locale.'.faq_subtitle', $content[$locale]['faq_subtitle']) }}">@error($locale.'.faq_subtitle')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto FAQ<textarea name="{{ $locale }}[faq_summary]">{{ old($locale.'.faq_summary', $content[$locale]['faq_summary']) }}</textarea>@error($locale.'.faq_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="section-grid" id="faq-list">
                    @foreach ($content['faqs'] as $index => $faq)
                        <article class="item-card faq-row">
                            <div class="remove-row">
                                <h3>Pregunta {{ $index + 1 }}</h3>
                                <button type="button" class="btn btn-danger" data-remove-faq>Quitar</button>
                            </div>
                            <input type="hidden" data-name="id" name="faqs[{{ $index }}][id]" value="{{ $faq['id'] }}">
                            <div class="language-grid">
                                <div>
                                    <label>Pregunta español<input type="text" data-name="question_es" name="faqs[{{ $index }}][question_es]" value="{{ old('faqs.'.$index.'.question_es', $faq['question_es']) }}">@error('faqs.'.$index.'.question_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>Respuesta español<textarea data-name="answer_es" name="faqs[{{ $index }}][answer_es]">{{ old('faqs.'.$index.'.answer_es', $faq['answer_es']) }}</textarea>@error('faqs.'.$index.'.answer_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                </div>
                                <div>
                                    <label>Pregunta inglés<input type="text" data-name="question_en" name="faqs[{{ $index }}][question_en]" value="{{ old('faqs.'.$index.'.question_en', $faq['question_en']) }}">@error('faqs.'.$index.'.question_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>Respuesta inglés<textarea data-name="answer_en" name="faqs[{{ $index }}][answer_en]">{{ old('faqs.'.$index.'.answer_en', $faq['answer_en']) }}</textarea>@error('faqs.'.$index.'.answer_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                <button type="button" class="btn btn-secondary" id="add-faq">Agregar pregunta</button>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Cierre</h2>
                    <p class="muted">Contenido final y enlace del botón de llamada a la acción.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título final<input type="text" name="{{ $locale }}[final_title]" value="{{ old($locale.'.final_title', $content[$locale]['final_title']) }}">@error($locale.'.final_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Subtítulo final<input type="text" name="{{ $locale }}[final_subtitle]" value="{{ old($locale.'.final_subtitle', $content[$locale]['final_subtitle']) }}">@error($locale.'.final_subtitle')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto final<textarea name="{{ $locale }}[final_summary]">{{ old($locale.'.final_summary', $content[$locale]['final_summary']) }}</textarea>@error($locale.'.final_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto del botón final<input type="text" name="{{ $locale }}[final_button_label]" value="{{ old($locale.'.final_button_label', $content[$locale]['final_button_label']) }}">@error($locale.'.final_button_label')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <article class="item-card">
                    <h3>Enlace del botón final</h3>
                    <label>Enlace del botón<input type="text" name="final_button_link" value="{{ old('final_button_link', $content['final_button_link']) }}">@error('final_button_link')<span class="field-error">{{ $message }}</span>@enderror</label>
                </article>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se mostrarán al recargar Inicio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <template id="faq-template">
        <article class="item-card faq-row">
            <div class="remove-row"><h3>Nueva pregunta</h3><button type="button" class="btn btn-danger" data-remove-faq>Quitar</button></div>
            <input type="hidden" data-name="id" value="">
            <div class="language-grid">
                <div>
                    <label>Pregunta español<input type="text" data-name="question_es" value=""></label>
                    <label>Respuesta español<textarea data-name="answer_es"></textarea></label>
                </div>
                <div>
                    <label>Pregunta inglés<input type="text" data-name="question_en" value=""></label>
                    <label>Respuesta inglés<textarea data-name="answer_en"></textarea></label>
                </div>
            </div>
        </article>
    </template>

    <script>
        const faqList = document.getElementById("faq-list");
        const faqTemplate = document.getElementById("faq-template");

        function renameFaqs() {
            [...faqList.querySelectorAll(".faq-row")].forEach((row, index) => {
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `faqs[${index}][${field.dataset.name}]`;
                });
            });
        }

        document.getElementById("add-faq").addEventListener("click", () => {
            faqList.appendChild(faqTemplate.content.firstElementChild.cloneNode(true));
            renameFaqs();
        });

        faqList.addEventListener("click", (event) => {
            if (!event.target.matches("[data-remove-faq]")) return;
            event.target.closest(".faq-row").remove();
            renameFaqs();
        });

        document.getElementById("home-form").addEventListener("change", (event) => {
            const input = event.target;
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
    </script>
</body>
</html>
