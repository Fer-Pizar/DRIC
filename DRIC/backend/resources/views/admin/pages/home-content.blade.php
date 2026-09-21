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
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .undo-floating { position: absolute; right: 12px; top: 12px; z-index: 4; }
        [data-image-card] > .undo-floating { right: -10px; top: -10px; z-index: 6; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .section-grid { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid, .three-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .three-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 18px; position: relative; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 108px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .preview { align-items: center; background: #111827; border: 1px solid #d6deeb; border-radius: 16px; display: flex; justify-content: center; margin-bottom: 12px; min-height: 140px; overflow: hidden; padding: 0; position: relative; width: 100%; }
        .preview[data-image-preview] { cursor: pointer; }
        .preview img { height: 100%; object-fit: cover; width: 100%; }
        .preview-country { aspect-ratio: 4 / 3; }
        .preview-about { aspect-ratio: 16 / 10; }
        .preview-agreement { aspect-ratio: 4 / 5; }
        .preview-empty { color: rgba(255,255,255,.72); padding: 18px; text-align: center; }
        .preview-ruler { align-items: center; background: rgba(2,6,23,.76); border: 1px solid rgba(255,255,255,.16); border-radius: 999px; color: #fff; display: inline-flex; font-size: 11px; font-weight: 900; gap: 6px; left: 10px; line-height: 1; padding: 7px 10px; position: absolute; top: 10px; }
        .preview-ruler::before { content: ""; background: repeating-linear-gradient(90deg, #fff 0 1px, transparent 1px 7px); display: block; height: 10px; opacity: .82; width: 34px; }
        .btn-image-remove { align-items: center; background: rgba(127,0,16,.92); border: 2px solid rgba(255,255,255,.88); border-radius: 999px; color: #fff; display: inline-flex; font-size: 20px; font-weight: 900; height: 32px; justify-content: center; line-height: 1; padding: 0; position: absolute; right: 10px; top: 10px; width: 32px; z-index: 3; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; z-index: 5; }
        .remove-row { align-items: center; display: flex; justify-content: space-between; gap: 12px; }
        .toggle-row { align-items: center; background: var(--soft); border: 1px solid var(--line); border-radius: 16px; display: flex; justify-content: space-between; gap: 18px; margin-bottom: 18px; padding: 16px; }
        .switch { align-items: center; cursor: pointer; display: inline-flex; flex: 0 0 auto; gap: 12px; user-select: none; }
        .switch input { height: 1px; opacity: 0; position: absolute; width: 1px; }
        .switch-track { align-items: center; background: #cbd5e1; border: 1px solid #b8c2d1; border-radius: 999px; box-shadow: inset 0 2px 5px rgba(15,23,42,.14); display: inline-flex; height: 34px; padding: 3px; transition: background .2s ease, border-color .2s ease, box-shadow .2s ease; width: 62px; }
        .switch-thumb { background: #fff; border-radius: 50%; box-shadow: 0 6px 14px rgba(15,23,42,.24); display: block; height: 26px; transform: translateX(0); transition: transform .2s ease; width: 26px; }
        .switch input:checked + .switch-track { background: var(--blue); border-color: var(--blue); box-shadow: 0 10px 22px rgba(22,65,148,.22); }
        .switch input:checked + .switch-track .switch-thumb { transform: translateX(28px); }
        .switch-text { color: var(--muted); font-size: 13px; font-weight: 900; letter-spacing: .02em; min-width: 62px; text-transform: uppercase; }
        .switch-text::before { content: "Inactivo"; }
        .switch input:checked ~ .switch-text { color: var(--blue); }
        .switch input:checked ~ .switch-text::before { content: "Activo"; }
        .switch:focus-within .switch-track { outline: 3px solid rgba(22,65,148,.18); outline-offset: 3px; }
        .crop-modal { align-items: center; background: rgba(2,6,23,.78); display: none; inset: 0; justify-content: center; padding: 18px; position: fixed; z-index: 50; }
        .crop-modal.is-open { display: flex; }
        .crop-dialog { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 30px 90px rgba(0,0,0,.34); display: grid; gap: 16px; max-height: calc(100vh - 36px); max-width: 920px; overflow: auto; padding: 18px; width: min(100%, 920px); }
        .crop-top { align-items: start; display: flex; gap: 16px; justify-content: space-between; }
        .crop-stage { align-items: center; background: #020617; border-radius: 16px; display: flex; justify-content: center; min-height: 280px; overflow: hidden; padding: 16px; position: relative; touch-action: none; }
        .crop-frame { border: 2px solid #fff; box-shadow: 0 0 0 999px rgba(2,6,23,.58), 0 18px 44px rgba(0,0,0,.3); cursor: grab; max-height: min(68vh, 620px); overflow: hidden; position: relative; width: min(100%, 740px); }
        .crop-frame.is-dragging { cursor: grabbing; }
        .crop-frame img { left: 50%; max-width: none; position: absolute; top: 50%; transform-origin: center; user-select: none; -webkit-user-drag: none; }
        .crop-controls { align-items: center; display: grid; gap: 10px; grid-template-columns: auto minmax(180px, 1fr); }
        .crop-controls input { padding: 0; }
        .crop-actions { display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end; }
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
                        </div>
                    @endforeach
                </div>
                <div class="three-grid">
                    @foreach ($content['countries'] as $index => $country)
                        <article class="item-card" data-image-card data-crop-aspect="1.333333" data-crop-label="Marco 4:3, similar a la tarjeta de país en Inicio.">
                            <h3>País {{ $index }}</h3>
                            <input type="hidden" name="countries[{{ $index }}][existing_image]" value="{{ old('countries.'.$index.'.existing_image', $country['existing_image']) }}">
                            <input type="hidden" name="countries[{{ $index }}][image_remove]" value="0" data-remove-image-input>
                            @if ($country['image'])
                                <div class="preview preview-country" data-image-preview>
                                    <img src="{{ $preview($country['image']) }}" alt="Imagen actual" data-preview-image>
                                    <span class="preview-ruler">4:3 país</span>
                                    <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                </div>
                            @else
                                <div class="preview preview-country" data-image-preview>
                                    <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                                    <span class="preview-ruler">4:3 país</span>
                                    <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                </div>
                            @endif
                            <label>Nombre en español<input type="text" name="countries[{{ $index }}][title_es]" value="{{ old('countries.'.$index.'.title_es', $country['title_es']) }}">@error('countries.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Nombre en inglés<input type="text" name="countries[{{ $index }}][title_en]" value="{{ old('countries.'.$index.'.title_en', $country['title_en']) }}">@error('countries.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Identificador URL<input type="text" name="countries[{{ $index }}][slug]" value="{{ old('countries.'.$index.'.slug', $country['slug']) }}">@error('countries.'.$index.'.slug')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Enlace<input type="text" name="countries[{{ $index }}][href]" value="{{ old('countries.'.$index.'.href', $country['href']) }}">@error('countries.'.$index.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Imagen<input type="file" name="countries[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file><span class="hint">JPG o PNG. Máximo 10 MB.</span>@error('countries.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror</label>
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
                <article class="item-card" data-image-card data-crop-aspect="1.6" data-crop-label="Marco ancho 16:10 para previsualizar Conócenos.">
                    <h3>Imagen Conócenos</h3>
                    <input type="hidden" name="about_image_remove" value="0" data-remove-image-input>
                    <div class="preview preview-about" data-image-preview>
                        @if ($content['about_image'])
                            <img src="{{ $preview($content['about_image']) }}" alt="Imagen actual" data-preview-image>
                        @else
                            <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                        @endif
                        <span class="preview-ruler">16:10 ancho</span>
                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                    </div>
                    <label>Subir nueva imagen<input type="file" name="about_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file><span class="hint">La X vuelve a la imagen base al guardar. Máximo 10 MB.</span>@error('about_image')<span class="field-error">{{ $message }}</span>@enderror</label>
                </article>
            </section>

            <section class="panel">
                <div class="panel-header"><h2>Acuerdos recientes</h2><p class="muted">Texto introductorio y tres tarjetas fijas: título, enlace e imagen.</p></div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Etiqueta superior<input type="text" name="{{ $locale }}[agreements_eyebrow]" value="{{ old($locale.'.agreements_eyebrow', $content[$locale]['agreements_eyebrow']) }}">@error($locale.'.agreements_eyebrow')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Título acuerdos<input type="text" name="{{ $locale }}[agreements_title]" value="{{ old($locale.'.agreements_title', $content[$locale]['agreements_title']) }}">@error($locale.'.agreements_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto acuerdos<textarea name="{{ $locale }}[agreements_summary]">{{ old($locale.'.agreements_summary', $content[$locale]['agreements_summary']) }}</textarea>@error($locale.'.agreements_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <div class="three-grid">
                    @foreach ($content['agreements'] as $index => $agreement)
                        <article class="item-card" data-image-card data-crop-aspect="0.8" data-crop-label="Marco vertical 4:5, similar a las tarjetas de acuerdos recientes.">
                            <h3>Acuerdo {{ $index }}</h3>
                            <input type="hidden" name="agreements[{{ $index }}][existing_image]" value="{{ old('agreements.'.$index.'.existing_image', $agreement['existing_image']) }}">
                            <input type="hidden" name="agreements[{{ $index }}][image_remove]" value="0" data-remove-image-input>
                            @if ($agreement['image'])
                                <div class="preview preview-agreement" data-image-preview>
                                    <img src="{{ $preview($agreement['image']) }}" alt="Imagen actual" data-preview-image>
                                    <span class="preview-ruler">4:5 acuerdo</span>
                                    <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                </div>
                            @else
                                <div class="preview preview-agreement" data-image-preview>
                                    <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                                    <span class="preview-ruler">4:5 acuerdo</span>
                                    <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                </div>
                            @endif
                            <label>Título español<input type="text" name="agreements[{{ $index }}][title_es]" value="{{ old('agreements.'.$index.'.title_es', $agreement['title_es']) }}">@error('agreements.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Título inglés<input type="text" name="agreements[{{ $index }}][title_en]" value="{{ old('agreements.'.$index.'.title_en', $agreement['title_en']) }}">@error('agreements.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Enlace<input type="text" name="agreements[{{ $index }}][href]" value="{{ old('agreements.'.$index.'.href', $agreement['href']) }}">@error('agreements.'.$index.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Imagen<input type="file" name="agreements[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file><span class="hint">JPG o PNG. Máximo 10 MB.</span>@error('agreements.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Misión y propósito</h2>
                    <p class="muted">Textos de presentación institucional y bloques informativos.</p>
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
                    <p class="muted">Edita solo las cifras visibles y sus etiquetas.</p>
                </div>
                <div class="three-grid">
                    @foreach ($content['stats'] as $index => $stat)
                        <article class="item-card">
                            <h3>Indicador {{ $index }}</h3>
                            <label>Valor<input type="text" name="stats[{{ $index }}][value]" value="{{ old('stats.'.$index.'.value', $stat['value']) }}">@error('stats.'.$index.'.value')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto español<input type="text" name="stats[{{ $index }}][label_es]" value="{{ old('stats.'.$index.'.label_es', $stat['label_es']) }}">@error('stats.'.$index.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto inglés<input type="text" name="stats[{{ $index }}][label_en]" value="{{ old('stats.'.$index.'.label_en', $stat['label_en']) }}">@error('stats.'.$index.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
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
                    <h2>Agendar cita</h2>
                    <p class="muted">Última sección de Inicio. Puedes apagarla para ocultarla por completo en la página pública.</p>
                </div>
                <div class="toggle-row">
                    <div>
                        <h3>Mostrar sección en Inicio</h3>
                        <p class="muted">Si está apagado, no se verá el bloque final de Agendar cita en la página pública.</p>
                    </div>
                    <label class="switch">
                        <input type="checkbox" name="final_cta_enabled" value="1" @checked(old('final_cta_enabled', $content['final_cta_enabled']))>
                        <span class="switch-track" aria-hidden="true">
                            <span class="switch-thumb"></span>
                        </span>
                        <span class="switch-text"></span>
                    </label>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label>Título<input type="text" name="{{ $locale }}[final_title]" value="{{ old($locale.'.final_title', $content[$locale]['final_title']) }}">@error($locale.'.final_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto<textarea name="{{ $locale }}[final_summary]">{{ old($locale.'.final_summary', $content[$locale]['final_summary']) }}</textarea>@error($locale.'.final_summary')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto del botón<input type="text" name="{{ $locale }}[final_button_label]" value="{{ old($locale.'.final_button_label', $content[$locale]['final_button_label']) }}">@error($locale.'.final_button_label')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
                <article class="item-card">
                    <h3>Enlace del botón</h3>
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

    <div class="crop-modal" id="crop-modal" aria-hidden="true">
        <div class="crop-dialog" role="dialog" aria-modal="true" aria-labelledby="crop-title">
            <div class="crop-top">
                <div>
                    <h2 id="crop-title">Recortar imagen</h2>
                    <p class="muted" id="crop-help">Ajusta la imagen dentro del marco y acepta el recorte.</p>
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
        const faqList = document.getElementById("faq-list");
        const faqTemplate = document.getElementById("faq-template");
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const imageStartSnapshots = new WeakMap();
        const maxImageBytes = 10 * 1024 * 1024;

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll("input:not([type='file']), textarea"));
        }

        function imageCardFor(scope) {
            if (scope.matches?.("[data-image-card]")) {
                return scope;
            }

            return scope.querySelector?.("[data-image-card]") || null;
        }

        function imageState(scope) {
            const card = imageCardFor(scope);
            if (!card) return null;

            const preview = card.querySelector("[data-image-preview]");
            const image = preview?.querySelector("[data-preview-image]");
            const empty = preview?.querySelector("[data-preview-empty]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");

            return {
                src: image?.getAttribute("src") || "",
                imageHidden: image ? image.hidden : true,
                emptyHidden: empty ? empty.hidden : true,
                file: fileInput?.files?.[0] || null,
                removeValue: removeInput?.value || "0",
            };
        }

        function snapshotScope(scope) {
            return {
                fields: editableFields(scope).map((field) => ({
                    name: field.name,
                    type: field.type,
                    value: field.value,
                    checked: field.checked,
                })),
                image: imageState(scope),
            };
        }

        function restoreImageState(scope, state) {
            if (!state) return;

            const card = imageCardFor(scope);
            if (!card) return;

            const preview = card.querySelector("[data-image-preview]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");
            const empty = preview?.querySelector("[data-preview-empty]");
            let image = preview?.querySelector("[data-preview-image]");

            if (image?.dataset.objectUrl) {
                URL.revokeObjectURL(image.dataset.objectUrl);
                delete image.dataset.objectUrl;
            }

            if (state.file && preview) {
                image = previewImageElement(preview);
                image.dataset.objectUrl = URL.createObjectURL(state.file);
                image.src = image.dataset.objectUrl;
                image.hidden = false;
                if (empty) empty.hidden = true;
            } else if (state.src && preview) {
                image = previewImageElement(preview);
                image.src = state.src;
                image.hidden = state.imageHidden;
                if (empty) empty.hidden = true;
            } else {
                if (image) {
                    image.removeAttribute("src");
                    image.hidden = true;
                }

                if (empty) {
                    empty.hidden = state.emptyHidden;
                } else if (preview) {
                    previewEmpty(preview);
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

                imageErrorFor(fileInput).textContent = "";
            }

            if (removeInput) {
                removeInput.value = state.removeValue;
            }
        }

        function restoreSnapshot(scope, snapshot) {
            const fields = Array.isArray(snapshot) ? snapshot : snapshot.fields;

            fields.forEach((item) => {
                const field = editableFields(scope).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
            });

            if (!Array.isArray(snapshot)) {
                restoreImageState(scope, snapshot.image);
            }
        }

        function historyFor(scope) {
            if (!cardHistory.has(scope)) {
                cardHistory.set(scope, []);
            }

            return cardHistory.get(scope);
        }

        function setUndoState(scope) {
            const button = scope.querySelector(":scope > [data-undo-card]");
            if (!button) return;

            button.disabled = historyFor(scope).length === 0;
        }

        function pushSnapshot(scope, snapshot = snapshotScope(scope)) {
            const history = historyFor(scope);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) {
                history.push(snapshot);
            }

            if (history.length > 20) {
                history.shift();
            }

            setUndoState(scope);
        }

        function undoScope(scope) {
            const snapshot = historyFor(scope).pop();
            if (!snapshot) return;

            restoreSnapshot(scope, snapshot);
            editableFields(scope).forEach((field) => fieldStartSnapshots.delete(field));
            setUndoState(scope);
        }

        function markFieldStart(field) {
            const scope = field.closest("[data-undo-scope]");
            if (!scope || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotScope(scope));
        }

        function rememberFieldChange(field) {
            const scope = field.closest("[data-undo-scope]");
            const snapshot = fieldStartSnapshots.get(field);
            if (!scope || !snapshot) return;

            pushSnapshot(scope, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function bindUndoScope(scope) {
            if (scope.dataset.undoBound === "1") return;

            scope.dataset.undoScope = "";
            scope.dataset.undoBound = "1";

            const button = document.createElement("button");
            button.className = "btn btn-undo undo-floating";
            button.type = "button";
            button.dataset.undoCard = "";
            button.disabled = true;
            button.title = "Deshacer último cambio";
            button.setAttribute("aria-label", "Deshacer último cambio");
            button.textContent = "↶";
            scope.appendChild(button);

            button.addEventListener("click", () => undoScope(scope));

            editableFields(scope).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });
        }

        function bindUndoScopes(root = document) {
            root.querySelectorAll(".language-card, .item-card, .toggle-row").forEach(bindUndoScope);
        }

        function renameFaqs() {
            [...faqList.querySelectorAll(".faq-row")].forEach((row, index) => {
                row.querySelectorAll("[data-name]").forEach((field) => {
                    field.name = `faqs[${index}][${field.dataset.name}]`;
                });
            });
        }

        document.getElementById("add-faq").addEventListener("click", () => {
            const row = faqTemplate.content.firstElementChild.cloneNode(true);
            faqList.appendChild(row);
            renameFaqs();
            bindUndoScope(row);
        });

        faqList.addEventListener("click", (event) => {
            if (!event.target.matches("[data-remove-faq]")) return;
            event.target.closest(".faq-row").remove();
            renameFaqs();
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
            const file = input.files?.[0];
            const error = imageErrorFor(input);
            error.textContent = "";

            if (!file) {
                return false;
            }

            if (!["image/jpeg", "image/png"].includes(file.type)) {
                error.textContent = "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                input.value = "";
                return false;
            }

            if (file.size > maxImageBytes) {
                error.textContent = "La imagen es demasiado pesada. El tamaño máximo permitido es 10 MB.";
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
                empty.textContent = "Sin imagen seleccionada. Puedes subir una nueva antes de guardar.";
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function previewImageElement(preview) {
            let image = preview.querySelector("[data-preview-image]");

            if (!image) {
                image = document.createElement("img");
                image.alt = "Vista previa de la imagen seleccionada";
                image.dataset.previewImage = "";
                preview.prepend(image);
            }

            image.hidden = false;
            return image;
        }

        function clearImagePreview(card) {
            const scope = card.closest("[data-undo-scope]") || card;
            const preview = card.querySelector("[data-image-preview]");
            const image = preview.querySelector("[data-preview-image]");
            const fileInput = card.querySelector("[data-image-file]");
            const removeInput = card.querySelector("[data-remove-image-input]");

            pushSnapshot(scope);

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
            const removeInput = card.querySelector("[data-remove-image-input]");

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
            if (card.dataset.imageBound === "1") return;
            card.dataset.imageBound = "1";

            const fileInput = card.querySelector("[data-image-file]");
            const removeButton = card.querySelector("[data-remove-image]");
            const preview = card.querySelector("[data-image-preview]");

            function requestImageFile() {
                if (!fileInput) return;

                const scope = card.closest("[data-undo-scope]") || card;
                imageStartSnapshots.set(fileInput, snapshotScope(scope));
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

            fileInput?.addEventListener("click", () => {
                const scope = card.closest("[data-undo-scope]") || card;
                imageStartSnapshots.set(fileInput, snapshotScope(scope));
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

        function cropAspectFor(card) {
            return Number(card.dataset.cropAspect || "1.333333");
        }

        function frameSizeForAspect(aspect) {
            const availableWidth = Math.min(740, cropFrame.parentElement.clientWidth - 32);
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
            const frameWidth = cropFrame.clientWidth;
            const frameHeight = cropFrame.clientHeight;
            const imageWidth = cropState.naturalWidth * cropState.baseScale * cropState.zoom;
            const imageHeight = cropState.naturalHeight * cropState.baseScale * cropState.zoom;
            const maxX = Math.max(0, (imageWidth - frameWidth) / 2);
            const maxY = Math.max(0, (imageHeight - frameHeight) / 2);

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
            const aspect = cropAspectFor(card);

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = card;
            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropHelp.textContent = card.dataset.cropLabel || "Ajusta la imagen dentro del marco y acepta el recorte.";
            cropModal.classList.add("is-open");
            cropModal.setAttribute("aria-hidden", "false");

            const size = frameSizeForAspect(aspect);
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
                if (fileInput) {
                    const scope = card.closest("[data-undo-scope]") || card;
                    const snapshot = imageStartSnapshots.get(fileInput);

                    if (snapshot) {
                        restoreImageState(scope, snapshot.image);
                        imageStartSnapshots.delete(fileInput);
                    } else {
                        fileInput.value = "";
                    }
                }
            }

            if (cropState.objectUrl) {
                URL.revokeObjectURL(cropState.objectUrl);
            }

            cropState.card = null;
            cropState.file = null;
            cropState.objectUrl = "";
            cropImage.removeAttribute("src");
        }

        function croppedFileName(file) {
            const base = file.name.replace(/\.[^.]+$/, "") || "home-image";
            return `${base}-recortada.jpg`;
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
            const aspect = cropAspectFor(card);
            const outputWidth = aspect < 1 ? 900 : 1200;
            const outputHeight = Math.round(outputWidth / aspect);
            const canvas = document.createElement("canvas");
            const context = canvas.getContext("2d");

            canvas.width = outputWidth;
            canvas.height = outputHeight;
            context.drawImage(cropImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, outputWidth, outputHeight);

            canvas.toBlob((blob) => {
                if (!blob) return;

                const cropped = new File([blob], croppedFileName(file), { type: "image/jpeg" });
                const transfer = new DataTransfer();
                const fileInput = card.querySelector("[data-image-file]");
                const scope = card.closest("[data-undo-scope]") || card;
                const snapshot = imageStartSnapshots.get(fileInput) || snapshotScope(scope);

                transfer.items.add(cropped);
                pushSnapshot(scope, snapshot);
                fileInput.files = transfer.files;
                imageStartSnapshots.delete(fileInput);
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
            if (event.target === cropModal) {
                closeCropTool(true);
            }
        });

        window.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && cropModal.classList.contains("is-open")) {
                closeCropTool(true);
            }
        });

        bindUndoScopes();
        document.querySelectorAll("[data-image-card]").forEach(bindImageCard);
    </script>
</body>
</html>
