<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Campus Life</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
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
        .undo-floating { position: absolute; right: 18px; top: 18px; z-index: 4; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .section-grid { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid, .three-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .three-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 76px 18px 18px; position: relative; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .image-card { display: grid; gap: 10px; }
        .preview { align-items: center; background: #eef2f7; border: 1px solid var(--line); border-radius: 16px; display: flex; justify-content: center; min-height: 150px; overflow: visible; padding: 0; position: relative; }
        .preview img { border-radius: 16px; display: block; height: 100%; object-fit: cover; width: 100%; }
        .preview-logo img { object-fit: contain; padding: 18px; }
        .preview-hero { aspect-ratio: 16 / 9; }
        .preview-logo { aspect-ratio: 1 / 1; max-width: 260px; }
        .preview-story { aspect-ratio: 16 / 10; }
        .preview-empty { color: var(--muted); font-weight: 700; padding: 18px; text-align: center; }
        .preview-ruler { background: rgba(23, 32, 51, .78); border-radius: 999px; bottom: 10px; color: #fff; font-size: 12px; font-weight: 800; left: 10px; padding: 6px 9px; position: absolute; }
        .btn-image-remove { align-items: center; background: var(--red-dark); border: 3px solid #fff; border-radius: 999px; color: #fff; cursor: pointer; display: inline-flex; font-size: 20px; font-weight: 900; height: 34px; justify-content: center; line-height: 1; position: absolute; right: -10px; top: -10px; width: 34px; z-index: 5; }
        .crop-modal { align-items: center; background: rgba(15, 23, 42, .64); display: none; inset: 0; justify-content: center; padding: 22px; position: fixed; z-index: 50; }
        .crop-modal.is-open { display: flex; }
        .crop-dialog { background: #fff; border-radius: 18px; box-shadow: 0 24px 80px rgba(15, 23, 42, .24); display: grid; gap: 16px; max-height: calc(100vh - 44px); max-width: 980px; overflow: auto; padding: 20px; width: min(100%, 980px); }
        .crop-stage { background: #0f172a; border-radius: 18px; overflow: hidden; position: relative; width: 100%; }
        .crop-stage img { height: 100%; left: 50%; object-fit: cover; position: absolute; top: 50%; transform-origin: center; width: 100%; }
        .crop-controls { display: grid; gap: 12px; }
        .crop-controls input[type="range"] { width: 100%; }
        .crop-actions { display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .two-grid, .three-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        @php
            $preview = function (?string $path): string {
                $path = trim((string) $path);
                if ($path === '') return '';
                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/storage/')) return $path;
                return asset(ltrim($path, '/'));
            };
        @endphp

        <header class="topbar">
            <div>
                <h1>Campus Life</h1>
                <p class="muted">Edita textos, enlaces e imágenes institucionales con vista previa real antes de guardar.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.campus-life.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Portada</h2>
                    <p class="muted">Primera vista de Campus Life: insignia, título principal, descripción e imagen de portada.</p>
                </div>

                <div class="image-card" data-image-card data-crop-aspect="1.777778" data-crop-label="Marco 16:9, igual al fondo principal de portada.">
                    <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    <label>
                        Imagen de portada
                        <div class="preview preview-hero" data-image-preview>
                            @if (!empty($content['hero_image']))
                                <img src="{{ $preview($content['hero_image']) }}" alt="Portada actual" data-preview-image>
                            @else
                                <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                            @endif
                            <span class="preview-ruler">16:9 portada</span>
                            <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                        </div>
                        <input type="hidden" name="hero_image_remove" value="0" data-remove-image-input>
                        <input type="file" name="hero_image" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                        <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                    </label>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Insignia superior
                                    <input type="text" name="{{ $locale }}[badge]" value="{{ old($locale.'.badge', $content[$locale]['badge']) }}">
                                    @error($locale.'.badge')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Título principal
                                    <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                    @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Descripción principal
                                    <textarea name="{{ $locale }}[subtitle]">{{ old($locale.'.subtitle', $content[$locale]['subtitle']) }}</textarea>
                                    @error($locale.'.subtitle')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjeta oficial UMSS</h2>
                    <p class="muted">Tarjeta que aparece en la portada con el logo institucional, el texto descriptivo y el enlace al sitio oficial.</p>
                </div>

                <label>
                    URL del sitio oficial UMSS
                    <input type="url" name="official_url" value="{{ old('official_url', $content['official_url']) }}">
                    @error('official_url')<span class="field-error">{{ $message }}</span>@enderror
                </label>

                <div class="image-card" data-image-card data-crop-aspect="1" data-crop-label="Marco cuadrado 1:1, igual al logo circular de la tarjeta UMSS.">
                    <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    <label>
                        Logo UMSS
                        <div class="preview preview-logo" data-image-preview>
                            @if (!empty($content['official_logo']))
                                <img src="{{ $preview($content['official_logo']) }}" alt="Logo actual" data-preview-image>
                            @else
                                <span class="preview-empty" data-preview-empty>Sin logo seleccionado.</span>
                            @endif
                            <span class="preview-ruler">1:1 logo</span>
                            <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar logo actual">×</button>
                        </div>
                        <input type="hidden" name="official_logo_remove" value="0" data-remove-image-input>
                        <input type="file" name="official_logo" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                        <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                    </label>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Texto pequeño del sitio oficial
                                    <input type="text" name="{{ $locale }}[official_label]" value="{{ old($locale.'.official_label', $content[$locale]['official_label']) }}">
                                    @error($locale.'.official_label')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Texto del botón o tarjeta oficial
                                    <input type="text" name="{{ $locale }}[official_title]" value="{{ old($locale.'.official_title', $content[$locale]['official_title']) }}">
                                    @error($locale.'.official_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Texto descriptivo de la tarjeta UMSS
                                    <textarea name="{{ $locale }}[basic_text]">{{ old($locale.'.basic_text', $content[$locale]['basic_text']) }}</textarea>
                                    <span class="hint">Este mismo texto también aparece en el bloque de Información básica de la página pública.</span>
                                    @error($locale.'.basic_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Estadísticas</h2>
                    <p class="muted">Edita los tres datos visibles de la franja de estadísticas.</p>
                </div>
                <div class="three-grid">
                    @foreach ($content['stats'] as $index => $stat)
                        <div class="item-card" data-undo-scope>
                            <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            <h3>Dato {{ $index }}</h3>
                            <label>Valor<input type="text" name="stats[{{ $index }}][value]" value="{{ old('stats.'.$index.'.value', $stat['value']) }}">@error('stats.'.$index.'.value')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto en español<input type="text" name="stats[{{ $index }}][label_es]" value="{{ old('stats.'.$index.'.label_es', $stat['label_es']) }}">@error('stats.'.$index.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto en inglés<input type="text" name="stats[{{ $index }}][label_en]" value="{{ old('stats.'.$index.'.label_en', $stat['label_en']) }}">@error('stats.'.$index.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas de características</h2>
                    <p class="muted">Tres tarjetas posteriores a las estadísticas. Los íconos no se editan; solo textos.</p>
                </div>
                <div class="three-grid">
                    @foreach ($content['features'] as $index => $feature)
                        <div class="item-card" data-undo-scope>
                            <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            <h3>Tarjeta {{ $index }}</h3>
                            <label>Título en español<input type="text" name="features[{{ $index }}][title_es]" value="{{ old('features.'.$index.'.title_es', $feature['title_es']) }}">@error('features.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Título en inglés<input type="text" name="features[{{ $index }}][title_en]" value="{{ old('features.'.$index.'.title_en', $feature['title_en']) }}">@error('features.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto en español<textarea name="features[{{ $index }}][text_es]">{{ old('features.'.$index.'.text_es', $feature['text_es']) }}</textarea>@error('features.'.$index.'.text_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                            <label>Texto en inglés<textarea name="features[{{ $index }}][text_en]">{{ old('features.'.$index.'.text_en', $feature['text_en']) }}</textarea>@error('features.'.$index.'.text_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Información básica</h2>
                    <p class="muted">Bloque institucional que aparece después de las tarjetas de características. El texto descriptivo se edita arriba, en Tarjeta oficial UMSS, porque la página pública reutiliza el mismo párrafo.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card" data-undo-scope>
                            <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Etiqueta de información básica
                                    <input type="text" name="{{ $locale }}[basic_kicker]" value="{{ old($locale.'.basic_kicker', $content[$locale]['basic_kicker']) }}">
                                    @error($locale.'.basic_kicker')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Título de información básica
                                    <input type="text" name="{{ $locale }}[basic_title]" value="{{ old($locale.'.basic_title', $content[$locale]['basic_title']) }}">
                                    @error($locale.'.basic_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Bibliotecas y facultades</h2>
                    <p class="muted">Primeras dos secciones visuales del recorrido. Las imágenes son las originales del sistema; aquí solo se editan textos y URLs.</p>
                </div>
                <div class="section-grid">
                    @foreach ([1, 2] as $index)
                        @php
                            $story = $content['stories'][$index];
                        @endphp
                        <article class="item-card">
                            <h3>{{ $storyLabels[$index] ?? 'Sección '.$index }}</h3>
                            <div class="image-card" data-image-card data-crop-aspect="1.6" data-crop-label="Marco 16:10, igual a la imagen de la tarjeta pública.">
                                <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                <label>
                                    Imagen de {{ $storyLabels[$index] ?? 'sección '.$index }}
                                    <div class="preview preview-story" data-image-preview>
                                        @if (!empty($story['image']))
                                            <img src="{{ $preview($story['image']) }}" alt="Imagen actual" data-preview-image>
                                        @else
                                            <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                                        @endif
                                        <span class="preview-ruler">16:10 tarjeta</span>
                                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                    </div>
                                    <input type="hidden" name="stories[{{ $index }}][image_remove]" value="0" data-remove-image-input>
                                    <input type="file" name="stories[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                                    <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                                </label>
                            </div>

                            <label>
                                URL de redirección
                                <input type="url" name="stories[{{ $index }}][url]" value="{{ old('stories.'.$index.'.url', $story['url']) }}">
                                @error('stories.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>

                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card" data-undo-scope>
                                        <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                        <h3>{{ $label }}</h3>
                                        <label>Etiqueta<input type="text" name="stories[{{ $index }}][eyebrow_{{ $locale }}]" value="{{ old('stories.'.$index.'.eyebrow_'.$locale, $story['eyebrow_'.$locale]) }}">@error('stories.'.$index.'.eyebrow_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>Título<input type="text" name="stories[{{ $index }}][title_{{ $locale }}]" value="{{ old('stories.'.$index.'.title_'.$locale, $story['title_'.$locale]) }}">@error('stories.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>Texto<textarea name="stories[{{ $index }}][text_{{ $locale }}]">{{ old('stories.'.$index.'.text_'.$locale, $story['text_'.$locale]) }}</textarea>@error('stories.'.$index.'.text_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Museo UMSS</h2>
                    <p class="muted">Sección del museo que aparece después de bibliotecas y facultades.</p>
                </div>
                @php
                    $story = $content['stories'][3];
                @endphp
                <article class="item-card">
                    <div class="image-card" data-image-card data-crop-aspect="1.6" data-crop-label="Marco 16:10, igual a la imagen de la tarjeta pública.">
                        <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                        <label>
                            Imagen de {{ $storyLabels[3] ?? 'Museo' }}
                            <div class="preview preview-story" data-image-preview>
                                @if (!empty($story['image']))
                                    <img src="{{ $preview($story['image']) }}" alt="Imagen actual" data-preview-image>
                                @else
                                    <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                                @endif
                                <span class="preview-ruler">16:10 tarjeta</span>
                                <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                            </div>
                            <input type="hidden" name="stories[3][image_remove]" value="0" data-remove-image-input>
                            <input type="file" name="stories[3][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                            <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                        </label>
                    </div>
                    <h3>{{ $storyLabels[3] ?? 'Museo' }}</h3>
                    <label>
                        URL de redirección
                        <input type="url" name="stories[3][url]" value="{{ old('stories.3.url', $story['url']) }}">
                        @error('stories.3.url')<span class="field-error">{{ $message }}</span>@enderror
                    </label>

                    <div class="language-grid">
                        @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                            <div class="language-card" data-undo-scope>
                                <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                <h3>{{ $label }}</h3>
                                <label>Etiqueta<input type="text" name="stories[3][eyebrow_{{ $locale }}]" value="{{ old('stories.3.eyebrow_'.$locale, $story['eyebrow_'.$locale]) }}">@error('stories.3.eyebrow_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título<input type="text" name="stories[3][title_{{ $locale }}]" value="{{ old('stories.3.title_'.$locale, $story['title_'.$locale]) }}">@error('stories.3.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto<textarea name="stories[3][text_{{ $locale }}]">{{ old('stories.3.text_'.$locale, $story['text_'.$locale]) }}</textarea>@error('stories.3.text_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Cochabamba</h2>
                    <p class="muted">Última sección del recorrido, con enlace y texto del botón.</p>
                </div>
                @php
                    $story = $content['stories'][4];
                @endphp
                <article class="item-card">
                    <div class="image-card" data-image-card data-crop-aspect="1.6" data-crop-label="Marco 16:10, igual a la imagen pública de Cochabamba.">
                        <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                        <label>
                            Imagen de {{ $storyLabels[4] ?? 'Cochabamba' }}
                            <div class="preview preview-story" data-image-preview>
                                @if (!empty($story['image']))
                                    <img src="{{ $preview($story['image']) }}" alt="Imagen actual" data-preview-image>
                                @else
                                    <span class="preview-empty" data-preview-empty>Sin imagen seleccionada.</span>
                                @endif
                                <span class="preview-ruler">16:10 tarjeta</span>
                                <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                            </div>
                            <input type="hidden" name="stories[4][image_remove]" value="0" data-remove-image-input>
                            <input type="file" name="stories[4][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                            <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                        </label>
                    </div>
                    <h3>{{ $storyLabels[4] ?? 'Cochabamba' }}</h3>
                    <label>
                        URL de redirección
                        <input type="url" name="stories[4][url]" value="{{ old('stories.4.url', $story['url']) }}">
                        @error('stories.4.url')<span class="field-error">{{ $message }}</span>@enderror
                    </label>

                    <div class="language-grid">
                        @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                            <div class="language-card" data-undo-scope>
                                <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                <h3>{{ $label }}</h3>
                                <label>Etiqueta<input type="text" name="stories[4][eyebrow_{{ $locale }}]" value="{{ old('stories.4.eyebrow_'.$locale, $story['eyebrow_'.$locale]) }}">@error('stories.4.eyebrow_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título<input type="text" name="stories[4][title_{{ $locale }}]" value="{{ old('stories.4.title_'.$locale, $story['title_'.$locale]) }}">@error('stories.4.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto<textarea name="stories[4][text_{{ $locale }}]">{{ old('stories.4.text_'.$locale, $story['text_'.$locale]) }}</textarea>@error('stories.4.text_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto del botón<input type="text" name="stories[4][button_{{ $locale }}]" value="{{ old('stories.4.button_'.$locale, $story['button_'.$locale] ?? '') }}">@error('stories.4.button_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        @endforeach
                    </div>
                </article>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Campus Life.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
        <div class="crop-modal" id="crop-modal" aria-hidden="true">
            <div class="crop-dialog" role="dialog" aria-modal="true" aria-labelledby="crop-title">
                <div>
                    <h2 id="crop-title">Recortar imagen</h2>
                    <p class="muted" id="crop-label">Ajusta el encuadre antes de guardar.</p>
                </div>
                <div class="crop-stage" id="crop-stage">
                    <img id="crop-image" alt="Vista previa de recorte">
                </div>
                <div class="crop-controls">
                    <label>Zoom<input id="crop-zoom" type="range" min="1" max="3" step="0.01" value="1"></label>
                    <label>Horizontal<input id="crop-x" type="range" min="-100" max="100" step="1" value="0"></label>
                    <label>Vertical<input id="crop-y" type="range" min="-100" max="100" step="1" value="0"></label>
                </div>
                <div class="crop-actions">
                    <button class="btn btn-secondary" type="button" id="crop-cancel">Cancelar</button>
                    <button class="btn btn-primary" type="button" id="crop-accept">Aceptar recorte</button>
                </div>
            </div>
        </div>
    </main>
    <script>
        const historyMap = new WeakMap();
        const pendingSnapshots = new WeakMap();
        const cropModal = document.getElementById("crop-modal");
        const cropStage = document.getElementById("crop-stage");
        const cropImage = document.getElementById("crop-image");
        const cropLabel = document.getElementById("crop-label");
        const cropZoom = document.getElementById("crop-zoom");
        const cropX = document.getElementById("crop-x");
        const cropY = document.getElementById("crop-y");
        const cropCancel = document.getElementById("crop-cancel");
        const cropAccept = document.getElementById("crop-accept");
        let activeImageCard = null;

        function fields(scope) {
            return [...scope.querySelectorAll("input, textarea, select")];
        }

        function snapshot(scope) {
            const items = fields(scope).map((field) => ({ field, value: field.value, checked: field.checked }));
            if (scope.matches("[data-image-card]")) {
                items.push({
                    previewSrc: scope.querySelector("[data-preview-image]")?.src || "",
                    removeValue: scope.querySelector("[data-remove-image-input]")?.value || "0",
                });
            }
            return items;
        }

        function restore(snapshotItems) {
            snapshotItems.forEach(({ field, value, checked, previewSrc, removeValue }) => {
                if (!field && activeImageCard && previewSrc !== undefined) return;
                if (!field) return;
                if (!field.isConnected) return;
                if (field.type === "checkbox" || field.type === "radio") field.checked = checked;
                else field.value = value;
            });
        }

        function restoreImageSnapshot(scope, snapshotItems) {
            const meta = snapshotItems.find((item) => item.previewSrc !== undefined);
            if (!meta) return;
            const removeInput = scope.querySelector("[data-remove-image-input]");
            if (removeInput) removeInput.value = meta.removeValue || "0";
            if (meta.previewSrc) setPreview(scope, meta.previewSrc);
            else clearPreview(scope);
        }

        function setUndo(button, stack) {
            if (button) button.disabled = !stack.length;
        }

        function remember(scope) {
            if (!pendingSnapshots.has(scope)) pendingSnapshots.set(scope, snapshot(scope));
        }

        function changed(scope, button) {
            const stack = historyMap.get(scope) || [];
            stack.push(pendingSnapshots.get(scope) || snapshot(scope));
            if (stack.length > 25) stack.shift();
            historyMap.set(scope, stack);
            pendingSnapshots.set(scope, snapshot(scope));
            setUndo(button, stack);
        }

        function bindUndo(scope) {
            if (!scope || scope.dataset.undoBound) return;
            scope.dataset.undoBound = "true";
            const button = scope.querySelector("[data-undo-card]");
            fields(scope).forEach((field) => {
                if (field.type === "file") return;
                field.addEventListener("focus", () => remember(scope));
                field.addEventListener("pointerdown", () => remember(scope));
                field.addEventListener("input", () => changed(scope, button));
                field.addEventListener("change", () => changed(scope, button));
            });
            button?.addEventListener("click", () => {
                const stack = historyMap.get(scope) || [];
                const last = stack.pop();
                if (!last) return;
                restore(last);
                if (scope.matches("[data-image-card]")) restoreImageSnapshot(scope, last);
                setUndo(button, stack);
            });
        }

        function setPreview(card, src) {
            const preview = card.querySelector("[data-image-preview]");
            preview.querySelector("[data-preview-image]")?.remove();
            preview.querySelector("[data-preview-empty]")?.remove();
            const img = document.createElement("img");
            img.src = src;
            img.alt = "Vista previa";
            img.dataset.previewImage = "";
            preview.prepend(img);
        }

        function clearPreview(card) {
            const preview = card.querySelector("[data-image-preview]");
            preview.querySelector("[data-preview-image]")?.remove();
            if (!preview.querySelector("[data-preview-empty]")) {
                const empty = document.createElement("span");
                empty.className = "preview-empty";
                empty.dataset.previewEmpty = "";
                empty.textContent = "Sin imagen seleccionada.";
                preview.prepend(empty);
            }
        }

        function updateCropPreview() {
            cropImage.style.transform = `translate(calc(-50% + ${Number(cropX.value) * 0.28}%), calc(-50% + ${Number(cropY.value) * 0.28}%)) scale(${cropZoom.value})`;
        }

        function openCrop(card) {
            const src = card.querySelector("[data-preview-image]")?.src;
            if (!src) return;
            activeImageCard = card;
            const aspect = Number(card.dataset.cropAspect || 1.6);
            cropStage.style.aspectRatio = String(aspect);
            cropLabel.textContent = card.dataset.cropLabel || "Ajusta el encuadre antes de guardar.";
            cropImage.src = src;
            cropZoom.value = "1";
            cropX.value = "0";
            cropY.value = "0";
            updateCropPreview();
            cropModal.classList.add("is-open");
            cropModal.setAttribute("aria-hidden", "false");
        }

        function closeCrop() {
            activeImageCard = null;
            cropModal.classList.remove("is-open");
            cropModal.setAttribute("aria-hidden", "true");
        }

        function cropActiveImage() {
            if (!activeImageCard) return;
            const input = activeImageCard.querySelector("[data-image-input]");
            const file = input.files[0];
            if (!file) return closeCrop();
            const image = new Image();
            image.onload = () => {
                const aspect = Number(activeImageCard.dataset.cropAspect || 1.6);
                const canvas = document.createElement("canvas");
                canvas.width = aspect >= 1.5 ? 1600 : 1000;
                canvas.height = Math.round(canvas.width / aspect);
                const zoom = Number(cropZoom.value);
                let cropWidth = image.naturalWidth / zoom;
                let cropHeight = cropWidth / aspect;
                if (cropHeight > image.naturalHeight / zoom) {
                    cropHeight = image.naturalHeight / zoom;
                    cropWidth = cropHeight * aspect;
                }
                const sx = Math.max(0, image.naturalWidth - cropWidth) * ((Number(cropX.value) + 100) / 200);
                const sy = Math.max(0, image.naturalHeight - cropHeight) * ((Number(cropY.value) + 100) / 200);
                canvas.getContext("2d").drawImage(image, sx, sy, cropWidth, cropHeight, 0, 0, canvas.width, canvas.height);
                canvas.toBlob((blob) => {
                    if (!blob) return;
                    const extension = file.type === "image/png" ? "png" : "jpg";
                    const name = file.name.replace(/\.[^.]+$/, "");
                    const cropped = new File([blob], `${name}-recortada.${extension}`, { type: file.type || "image/jpeg" });
                    const transfer = new DataTransfer();
                    transfer.items.add(cropped);
                    input.files = transfer.files;
                    const url = URL.createObjectURL(cropped);
                    setPreview(activeImageCard, url);
                    closeCrop();
                }, file.type || "image/jpeg", 0.92);
            };
            image.src = URL.createObjectURL(file);
        }

        function bindImageCard(card) {
            if (!card || card.dataset.imageBound) return;
            card.dataset.imageBound = "true";
            bindUndo(card);
            const input = card.querySelector("[data-image-input]");
            const removeInput = card.querySelector("[data-remove-image-input]");
            input.addEventListener("change", () => {
                const file = input.files[0];
                if (!file) return;
                if (!["image/jpeg", "image/png"].includes(file.type) || file.size > 10 * 1024 * 1024) {
                    alert(file.size > 10 * 1024 * 1024 ? "La imagen sobrepasa los 10MB." : "Ese formato no está permitido. Usa JPG o PNG.");
                    input.value = "";
                    return;
                }
                removeInput.value = "0";
                setPreview(card, URL.createObjectURL(file));
                openCrop(card);
            });
            card.querySelector("[data-remove-image]").addEventListener("click", (event) => {
                event.preventDefault();
                changed(card, card.querySelector("[data-undo-card]"));
                input.value = "";
                removeInput.value = "1";
                clearPreview(card);
            });
            card.querySelector("[data-image-preview]").addEventListener("click", (event) => {
                if (event.target.closest("button")) return;
                openCrop(card);
            });
        }

        document.querySelectorAll("[data-undo-scope]").forEach(bindUndo);
        document.querySelectorAll("[data-image-card]").forEach(bindImageCard);
        [cropZoom, cropX, cropY].forEach((control) => control.addEventListener("input", updateCropPreview));
        cropCancel.addEventListener("click", closeCrop);
        cropAccept.addEventListener("click", cropActiveImage);
        cropModal.addEventListener("click", (event) => {
            if (event.target === cropModal) closeCrop();
        });
    </script>
</body>
</html>
