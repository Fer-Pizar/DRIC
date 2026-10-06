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
        .panel { border-left: 5px solid rgba(22, 65, 148, .88); overflow: hidden; padding: 24px; }
        .panel-header { align-items: flex-start; border-bottom: 1px solid var(--line); display: flex; gap: 18px; justify-content: space-between; margin-bottom: 20px; padding-bottom: 16px; }
        .panel-kicker { background: #eef3fb; border-radius: 999px; color: var(--blue); flex: 0 0 auto; font-size: 12px; font-weight: 900; letter-spacing: .08em; padding: 8px 11px; text-transform: uppercase; }
        .language-grid, .two-grid, .three-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .three-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 76px 18px 18px; position: relative; }
        .url-card { background: #fff; border: 1px solid #d8e2f2; border-radius: 18px; box-shadow: none; padding: 76px 18px 18px; position: relative; }
        .item-card { border-color: #d8e2f2; }
        .story-editor { border-color: #164194; border-left: 5px solid #164194; padding: 22px; }
        .story-editor + .story-editor { margin-top: 4px; }
        .story-head { align-items: center; display: flex; gap: 12px; justify-content: space-between; margin-bottom: 16px; }
        .story-title { display: grid; gap: 4px; }
        .story-title span { color: var(--muted); font-size: 12px; font-weight: 800; text-transform: uppercase; }
        .story-body { display: grid; gap: 18px; }
        .story-top { align-items: start; display: grid; gap: 18px; grid-template-columns: minmax(220px, 360px) minmax(0, 1fr); }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .image-card { background: #f8fafc; border: 1px dashed #cfd8e8; border-radius: 18px; display: grid; gap: 10px; padding: 14px; position: relative; }
        .image-card label { gap: 10px; }
        .image-card.is-empty .preview { display: none; }
        .image-card.is-empty .btn-image-remove { display: none; }
        .preview { align-items: center; background: #eef2f7; border: 1px solid var(--line); border-radius: 16px; display: flex; justify-content: center; max-height: 320px; min-height: 150px; overflow: hidden; padding: 0; position: relative; }
        .preview img { border-radius: 16px; cursor: zoom-in; display: block; height: 100%; object-fit: contain; padding: 10px; width: 100%; }
        .preview-logo img { object-fit: contain; padding: 18px; }
        .preview-hero { aspect-ratio: 16 / 9; }
        .preview-logo { aspect-ratio: 1 / 1; max-width: 180px; min-height: 180px; }
        .preview-story { aspect-ratio: 16 / 10; width: 100%; }
        .preview-empty { color: var(--muted); font-weight: 700; padding: 18px; text-align: center; }
        .preview-ruler { background: rgba(23, 32, 51, .78); border-radius: 999px; bottom: 10px; color: #fff; font-size: 12px; font-weight: 800; left: 10px; padding: 6px 9px; position: absolute; }
        .btn-image-remove { align-items: center; background: var(--red-dark); border: 3px solid #fff; border-radius: 999px; color: #fff; cursor: pointer; display: inline-flex; font-size: 20px; font-weight: 900; height: 34px; justify-content: center; line-height: 1; position: absolute; right: -10px; top: -10px; width: 34px; z-index: 5; }
        .media-editor-modal { background: #0f1113; color: #f8fafc; display: none; inset: 0; position: fixed; z-index: 80; }
        .media-editor-modal.is-open { display: grid; grid-template-rows: auto 1fr auto; }
        .media-editor-top { align-items: center; background: #171717; display: flex; gap: 18px; justify-content: space-between; padding: 14px 18px; }
        .media-editor-title { align-items: center; display: flex; gap: 18px; font-size: 28px; font-weight: 900; }
        .media-editor-back { background: transparent; border: 0; color: #fff; cursor: pointer; font-size: 34px; line-height: 1; padding: 4px 8px; }
        .media-editor-apply { background: #f8fafc; border: 0; border-radius: 999px; color: #111827; cursor: pointer; font-size: 18px; font-weight: 900; padding: 12px 28px; }
        .media-editor-workspace { align-items: center; display: flex; justify-content: center; min-height: 0; overflow: hidden; padding: 34px 28px; }
        .media-editor-stage { background: #111827; max-height: 70vh; max-width: 1040px; overflow: hidden; position: relative; touch-action: none; width: min(100%, 1040px); }
        .media-editor-stage img { left: 50%; max-width: none; position: absolute; top: 50%; transform-origin: center; user-select: none; -webkit-user-drag: none; }
        .media-editor-stage::after { background: rgba(0, 0, 0, .42); content: ""; inset: 0; pointer-events: none; position: absolute; z-index: 2; }
        .media-editor-frame { border: 6px solid #ff2b93; inset: 0; pointer-events: none; position: absolute; z-index: 4; }
        .media-editor-controls { align-items: center; display: grid; gap: 18px; grid-template-columns: auto minmax(220px, 560px) auto; justify-content: center; padding: 20px 28px 28px; }
        .media-editor-controls span { color: #cbd5e1; font-size: 28px; line-height: 1; }
        .media-editor-controls input { accent-color: #ff2b93; width: 100%; }
        .media-editor-error { color: #fecdd3; font-size: 13px; font-weight: 800; min-height: 18px; text-align: center; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; z-index: 30; }
        @media (max-width: 900px) { .topbar, .panel-header, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .two-grid, .three-grid, .story-top { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        @php
            $frontendUrl = rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/');
            $preview = function (?string $path): string {
                $frontendUrl = rtrim(config('app.frontend_url', env('FRONTEND_URL', 'http://localhost:3000')), '/');
                $path = trim((string) $path);
                if ($path === '') return '';
                if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/storage/')) return $path;
                if (str_starts_with($path, '/images/')) return $frontendUrl.$path;
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
                    <div>
                        <h2>Portada</h2>
                        <p class="muted">Primera vista de Campus Life: insignia, título principal y descripción.</p>
                    </div>
                    <span class="panel-kicker">Hero</span>
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
                    <div>
                        <h2>Tarjeta oficial UMSS</h2>
                        <p class="muted">Tarjeta que aparece en la portada con el logo institucional, el texto descriptivo y el enlace al sitio oficial.</p>
                    </div>
                    <span class="panel-kicker">Portada</span>
                </div>

                <div class="url-card" data-undo-scope>
                    <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                    <label>
                        URL del sitio oficial UMSS
                        <input type="url" name="official_url" value="{{ old('official_url', $content['official_url']) }}">
                        @error('official_url')<span class="field-error">{{ $message }}</span>@enderror
                    </label>
                </div>

                <div class="image-card @if (empty($content['official_logo'])) is-empty @endif" data-image-card data-media-id="{{ $content['official_logo_media_id'] ?? '' }}" data-crop-aspect="1" data-crop-label="Marco cuadrado 1:1, igual al logo circular de la tarjeta UMSS.">
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
                        <input type="hidden" name="official_logo_restore" value="" data-restore-image-input>
                        <input type="hidden" name="official_logo_unhide" value="0" data-unhide-image-input>
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
                                    <textarea data-basic-text-mirror="{{ $locale }}">{{ old($locale.'.basic_text', $content[$locale]['basic_text']) }}</textarea>
                                    <span class="hint">Es el mismo texto de Información básica. Puedes editarlo aquí o abajo; ambos campos se sincronizan.</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Estadísticas</h2>
                        <p class="muted">Edita los tres datos visibles de la franja de estadísticas.</p>
                    </div>
                    <span class="panel-kicker">Datos</span>
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
                    <div>
                        <h2>Tarjetas de características</h2>
                        <p class="muted">Tres tarjetas posteriores a las estadísticas. Los íconos no se editan; solo textos.</p>
                    </div>
                    <span class="panel-kicker">Features</span>
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
                    <div>
                        <h2>Información básica</h2>
                        <p class="muted">Bloque institucional que aparece después de las tarjetas de características. El texto descriptivo se edita arriba, en Tarjeta oficial UMSS, porque la página pública reutiliza el mismo párrafo.</p>
                    </div>
                    <span class="panel-kicker">Bloque</span>
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

                                <label>
                                    Texto de información básica
                                    <textarea name="{{ $locale }}[basic_text]" data-basic-text-source="{{ $locale }}">{{ old($locale.'.basic_text', $content[$locale]['basic_text']) }}</textarea>
                                    <span class="hint">Este párrafo aparece en la página pública dentro de Información básica y también alimenta el resumen de la tarjeta UMSS.</span>
                                    @error($locale.'.basic_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Bibliotecas y facultades</h2>
                        <p class="muted">Primeras dos secciones visuales del recorrido. Si no hay imagen subida, solo aparece el selector de archivo.</p>
                    </div>
                    <span class="panel-kicker">Recorrido</span>
                </div>
                <div class="section-grid">
                    @foreach ([1, 2] as $index)
                        @php
                            $story = $content['stories'][$index];
                        @endphp
                        <article class="item-card story-editor">
                            <div class="story-head">
                                <div class="story-title">
                                    <span>{{ $index === 1 ? 'Primera tarjeta visual' : 'Segunda tarjeta visual' }}</span>
                                    <h3>{{ $storyLabels[$index] ?? 'Sección '.$index }}</h3>
                                </div>
                            </div>
                            <div class="story-body">
                                <div class="story-top">
                                    <div class="image-card @if (empty($story['image'])) is-empty @endif" data-image-card data-media-id="{{ $story['image_media_id'] ?? '' }}" data-crop-aspect="1.6" data-crop-label="Marco 16:10, igual a la imagen de la tarjeta pública.">
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
                                            <input type="hidden" name="stories[{{ $index }}][image_restore]" value="" data-restore-image-input>
                                            <input type="hidden" name="stories[{{ $index }}][image_unhide]" value="0" data-unhide-image-input>
                                            <input type="file" name="stories[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                                            <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                                        </label>
                                    </div>

                                    <div class="url-card" data-undo-scope>
                                        <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                        <label>
                                            URL de redirección
                                            <input type="url" name="stories[{{ $index }}][url]" value="{{ old('stories.'.$index.'.url', $story['url']) }}">
                                            <span class="hint">Este enlace se abre al hacer clic en la tarjeta pública.</span>
                                            @error('stories.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                </div>

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
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Museo UMSS</h2>
                        <p class="muted">Sección del museo que aparece después de bibliotecas y facultades.</p>
                    </div>
                    <span class="panel-kicker">Historia</span>
                </div>
                @php
                    $story = $content['stories'][3];
                @endphp
                <article class="item-card story-editor">
                    <div class="story-head">
                        <div class="story-title">
                            <span>Tercera tarjeta visual</span>
                            <h3>{{ $storyLabels[3] ?? 'Museo' }}</h3>
                        </div>
                    </div>
                    <div class="story-body">
                        <div class="story-top">
                            <div class="image-card @if (empty($story['image'])) is-empty @endif" data-image-card data-media-id="{{ $story['image_media_id'] ?? '' }}" data-crop-aspect="1.6" data-crop-label="Marco 16:10, igual a la imagen de la tarjeta pública.">
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
                                    <input type="hidden" name="stories[3][image_restore]" value="" data-restore-image-input>
                                    <input type="hidden" name="stories[3][image_unhide]" value="0" data-unhide-image-input>
                                    <input type="file" name="stories[3][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                                    <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                                </label>
                            </div>

                            <div class="url-card" data-undo-scope>
                                <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                <label>
                                    URL de redirección
                                    <input type="url" name="stories[3][url]" value="{{ old('stories.3.url', $story['url']) }}">
                                    <span class="hint">Este enlace se abre al hacer clic en la tarjeta pública.</span>
                                    @error('stories.3.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>

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
                    </div>
                </article>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Cochabamba</h2>
                        <p class="muted">Última sección del recorrido, con enlace y texto del botón.</p>
                    </div>
                    <span class="panel-kicker">Cierre</span>
                </div>
                @php
                    $story = $content['stories'][4];
                @endphp
                <article class="item-card story-editor">
                    <div class="story-head">
                        <div class="story-title">
                            <span>Sección final</span>
                            <h3>{{ $storyLabels[4] ?? 'Cochabamba' }}</h3>
                        </div>
                    </div>
                    <div class="story-body">
                        <div class="story-top">
                            <div class="image-card @if (empty($story['image'])) is-empty @endif" data-image-card data-media-id="{{ $story['image_media_id'] ?? '' }}" data-crop-aspect="1.6" data-crop-label="Marco 16:10, igual a la imagen pública de Cochabamba.">
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
                                    <input type="hidden" name="stories[4][image_restore]" value="" data-restore-image-input>
                                    <input type="hidden" name="stories[4][image_unhide]" value="0" data-unhide-image-input>
                                    <input type="file" name="stories[4][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-input>
                                    <span class="hint">JPG o PNG. Máximo 10 MB. Haz clic en la vista previa para recortar.</span>
                                </label>
                            </div>

                            <div class="url-card" data-undo-scope>
                                <button class="btn btn-undo undo-floating" type="button" data-undo-card disabled title="Deshacer último cambio" aria-label="Deshacer último cambio">↶</button>
                                <label>
                                    URL de redirección
                                    <input type="url" name="stories[4][url]" value="{{ old('stories.4.url', $story['url']) }}">
                                    <span class="hint">Este enlace se abre desde el botón final de la página pública.</span>
                                    @error('stories.4.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>

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
                    </div>
                </article>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Campus Life.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
        <div class="media-editor-modal" id="media-editor-modal" aria-hidden="true">
            <div class="media-editor-top">
                <div class="media-editor-title">
                    <button class="media-editor-back" type="button" id="media-editor-close" aria-label="Volver">‹</button>
                    <span>Editar imagen</span>
                </div>
                <button class="media-editor-apply" type="button" id="media-editor-apply">Aplicar</button>
            </div>
            <div class="media-editor-workspace">
                <div class="media-editor-stage" id="media-editor-stage">
                    <img id="media-editor-image" alt="Vista previa del encuadre">
                    <div class="media-editor-frame" aria-hidden="true"></div>
                </div>
            </div>
            <div class="media-editor-controls">
                <span aria-hidden="true">−</span>
                <input id="media-editor-zoom" type="range" min="1" max="3" step="0.01" value="1" aria-label="Zoom de imagen">
                <span aria-hidden="true">＋</span>
            </div>
            <div class="media-editor-error" id="media-editor-error"></div>
        </div>
    </main>
    <script>
        const historyMap = new WeakMap();
        const pendingSnapshots = new WeakMap();
        const imageHistoryMap = new WeakMap();
        const fieldUndoStorageKey = `campus-life-field-undo:${window.location.pathname}`;
        const imageUndoStorageKey = `campus-life-image-undo:${window.location.pathname}`;
        const mediaEditorModal = document.getElementById("media-editor-modal");
        const mediaEditorStage = document.getElementById("media-editor-stage");
        const mediaEditorImage = document.getElementById("media-editor-image");
        const mediaEditorZoom = document.getElementById("media-editor-zoom");
        const mediaEditorClose = document.getElementById("media-editor-close");
        const mediaEditorApply = document.getElementById("media-editor-apply");
        const mediaEditorError = document.getElementById("media-editor-error");
        const mediaEditorState = {
            card: null,
            sourceUrl: "",
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

        function fields(scope) {
            return [...scope.querySelectorAll("input, textarea, select")];
        }

        function undoableFields(scope) {
            return fields(scope).filter((field) => field.type !== "file" && field.type !== "hidden");
        }

        function fieldKey(field, scope) {
            if (field.name) return field.name;
            if (field.dataset.basicTextMirror) return `basic-text-mirror:${field.dataset.basicTextMirror}`;
            if (field.id) return `id:${field.id}`;
            return `index:${undoableFields(scope).indexOf(field)}`;
        }

        function snapshot(scope) {
            return fields(scope).map((field) => ({ field, value: field.value, checked: field.checked }));
        }

        function serializableSnapshot(scope, snapshotItems = snapshot(scope)) {
            return snapshotItems
                .filter(({ field }) => field && field.type !== "file" && field.type !== "hidden")
                .map(({ field, value, checked }) => ({
                    key: fieldKey(field, scope),
                    type: field.type,
                    value,
                    checked,
                }))
                .filter((item) => item.key);
        }

        function restore(snapshotItems) {
            snapshotItems.forEach(({ field, value, checked }) => {
                if (!field || !field.isConnected) return;
                if (field.type === "checkbox" || field.type === "radio") field.checked = checked;
                else field.value = value;
                field.dispatchEvent(new Event("input", { bubbles: true }));
                field.dispatchEvent(new Event("change", { bubbles: true }));
            });
        }

        function restoreSerializedSnapshot(scope, snapshotItems) {
            const scopedFields = undoableFields(scope);
            snapshotItems.forEach((item) => {
                const field = scopedFields.find((candidate) => fieldKey(candidate, scope) === item.key);
                if (!field) return;
                if (field.type === "checkbox" || field.type === "radio") field.checked = item.checked;
                else field.value = item.value;
                field.dispatchEvent(new Event("input", { bubbles: true }));
                field.dispatchEvent(new Event("change", { bubbles: true }));
            });
        }

        function fieldScopeKey(scope) {
            return undoableFields(scope).map((field) => fieldKey(field, scope)).join("|");
        }

        function readFieldUndoStore() {
            try {
                const stored = sessionStorage.getItem(fieldUndoStorageKey);
                const parsed = stored ? JSON.parse(stored) : {};
                return parsed && typeof parsed === "object" ? parsed : {};
            } catch (error) {
                sessionStorage.removeItem(fieldUndoStorageKey);
                return {};
            }
        }

        function writeFieldUndoStore(store) {
            const clean = Object.fromEntries(Object.entries(store).filter(([, value]) => Array.isArray(value) && value.length));
            if (!Object.keys(clean).length) {
                sessionStorage.removeItem(fieldUndoStorageKey);
                return;
            }
            sessionStorage.setItem(fieldUndoStorageKey, JSON.stringify(clean));
        }

        function pushStoredFieldSnapshot(scope, snapshotItems) {
            const record = serializableSnapshot(scope, snapshotItems);
            const key = fieldScopeKey(scope);
            if (!key || !record.length) return;

            const store = readFieldUndoStore();
            if (!Array.isArray(store[key])) store[key] = [];

            const serialized = JSON.stringify(record);
            const last = store[key].length ? JSON.stringify(store[key][store[key].length - 1]) : null;
            if (serialized !== last) store[key].push(record);
            if (store[key].length > 25) store[key].shift();
            writeFieldUndoStore(store);
        }

        function popStoredFieldSnapshot(scope) {
            const key = fieldScopeKey(scope);
            if (!key) return null;
            const store = readFieldUndoStore();
            const stack = Array.isArray(store[key]) ? store[key] : [];
            const record = stack.pop() || null;
            if (stack.length) store[key] = stack;
            else delete store[key];
            writeFieldUndoStore(store);
            return record;
        }

        function refreshFieldUndoButton(scope) {
            const button = scope.querySelector("[data-undo-card]");
            if (!button) return;
            const memoryStack = historyMap.get(scope) || [];
            const storedStack = readFieldUndoStore()[fieldScopeKey(scope)] || [];
            button.disabled = !(memoryStack.length || storedStack.length);
        }

        function refreshAllFieldUndoButtons() {
            document.querySelectorAll("[data-undo-scope]").forEach(refreshFieldUndoButton);
        }

        function setUndo(button, stack) {
            if (button) button.disabled = !stack.length;
        }

        function remember(scope) {
            if (!pendingSnapshots.has(scope)) pendingSnapshots.set(scope, snapshot(scope));
        }

        function changed(scope, button) {
            const stack = historyMap.get(scope) || [];
            const previousSnapshot = pendingSnapshots.get(scope) || snapshot(scope);
            stack.push(previousSnapshot);
            if (stack.length > 25) stack.shift();
            historyMap.set(scope, stack);
            pushStoredFieldSnapshot(scope, previousSnapshot);
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
                const stored = last ? null : popStoredFieldSnapshot(scope);
                if (!last && !stored) return;
                if (last) {
                    popStoredFieldSnapshot(scope);
                    restore(last);
                }
                else restoreSerializedSnapshot(scope, stored);
                syncBasicTextPairs();
                refreshFieldUndoButton(scope);
            });
            refreshFieldUndoButton(scope);
        }

        function syncBasicTextPairs() {
            document.querySelectorAll("[data-basic-text-source]").forEach((source) => {
                const locale = source.dataset.basicTextSource;
                const mirror = document.querySelector(`[data-basic-text-mirror="${locale}"]`);
                if (mirror && mirror.value !== source.value) mirror.value = source.value;
            });
        }

        function bindBasicTextMirrors() {
            let syncing = false;
            document.querySelectorAll("[data-basic-text-source]").forEach((source) => {
                const locale = source.dataset.basicTextSource;
                const mirror = document.querySelector(`[data-basic-text-mirror="${locale}"]`);
                if (!mirror) return;

                source.addEventListener("input", () => {
                    if (syncing) return;
                    syncing = true;
                    mirror.value = source.value;
                    syncing = false;
                });

                mirror.addEventListener("input", () => {
                    if (syncing) return;
                    syncing = true;
                    source.value = mirror.value;
                    source.dispatchEvent(new Event("input", { bubbles: true }));
                    syncing = false;
                });
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
            img.addEventListener("error", () => clearPreview(card));
            preview.prepend(img);
            card.classList.remove("is-empty");
        }

        function clearPreview(card) {
            const preview = card.querySelector("[data-image-preview]");
            preview.querySelector("[data-preview-image]")?.remove();
            card.classList.add("is-empty");
            if (!preview.querySelector("[data-preview-empty]")) {
                const empty = document.createElement("span");
                empty.className = "preview-empty";
                empty.dataset.previewEmpty = "";
                empty.textContent = "Sin imagen seleccionada.";
                preview.prepend(empty);
            }
        }

        function imageFieldName(card) {
            return card.querySelector("[data-image-input]")?.name || "";
        }

        function readImageUndoStore() {
            try {
                const stored = sessionStorage.getItem(imageUndoStorageKey);
                const parsed = stored ? JSON.parse(stored) : {};
                return parsed && typeof parsed === "object" ? parsed : {};
            } catch (error) {
                sessionStorage.removeItem(imageUndoStorageKey);
                return {};
            }
        }

        function writeImageUndoStore(store) {
            const clean = Object.fromEntries(Object.entries(store).filter(([, value]) => Array.isArray(value) && value.length));
            if (!Object.keys(clean).length) {
                sessionStorage.removeItem(imageUndoStorageKey);
                return;
            }
            sessionStorage.setItem(imageUndoStorageKey, JSON.stringify(clean));
        }

        function imageSnapshot(card) {
            return {
                fieldName: imageFieldName(card),
                mediaId: card.dataset.mediaId || "",
                previewSrc: card.querySelector("[data-preview-image]")?.getAttribute("src") || "",
                removeValue: card.querySelector("[data-remove-image-input]")?.value || "0",
                restoreValue: card.querySelector("[data-restore-image-input]")?.value || "",
            };
        }

        function pushImageSnapshot(card) {
            const record = imageSnapshot(card);
            if (!record.fieldName) return;

            const stack = imageHistoryMap.get(card) || [];
            stack.push(record);
            if (stack.length > 20) stack.shift();
            imageHistoryMap.set(card, stack);

            const store = readImageUndoStore();
            if (!Array.isArray(store[record.fieldName])) store[record.fieldName] = [];
            const serialized = JSON.stringify(record);
            const last = store[record.fieldName].length ? JSON.stringify(store[record.fieldName][store[record.fieldName].length - 1]) : null;
            if (serialized !== last) store[record.fieldName].push(record);
            if (store[record.fieldName].length > 20) store[record.fieldName].shift();
            writeImageUndoStore(store);

            const button = card.querySelector("[data-undo-card]");
            if (button) button.disabled = false;
        }

        function popStoredImageSnapshot(card) {
            const key = imageFieldName(card);
            if (!key) return null;
            const store = readImageUndoStore();
            const stack = Array.isArray(store[key]) ? store[key] : [];
            const record = stack.pop() || null;
            if (stack.length) store[key] = stack;
            else delete store[key];
            writeImageUndoStore(store);
            return record;
        }

        function applyImageSnapshot(card, record) {
            if (!record) return;
            const input = card.querySelector("[data-image-input]");
            const removeInput = card.querySelector("[data-remove-image-input]");
            const restoreInput = card.querySelector("[data-restore-image-input]");
            const unhideInput = card.querySelector("[data-unhide-image-input]");

            if (input) input.value = "";
            if (removeInput) removeInput.value = record.removeValue || "0";
            if (restoreInput) restoreInput.value = record.restoreValue || record.mediaId || "";
            if (unhideInput) unhideInput.value = record.previewSrc && !record.restoreValue && !record.mediaId ? "1" : "0";
            if (record.mediaId) card.dataset.mediaId = record.mediaId;
            delete card.dataset.pendingImageSnapshot;
            if (record.previewSrc) setPreview(card, record.previewSrc);
            else clearPreview(card);
        }

        function refreshImageUndoButton(card) {
            const button = card.querySelector("[data-undo-card]");
            if (!button) return;
            const memoryStack = imageHistoryMap.get(card) || [];
            const storedStack = readImageUndoStore()[imageFieldName(card)] || [];
            if (memoryStack.length || storedStack.length) button.disabled = false;
        }

        function resetMediaEditorState() {
            mediaEditorState.card = null;
            mediaEditorState.sourceUrl = "";
            mediaEditorState.naturalWidth = 0;
            mediaEditorState.naturalHeight = 0;
            mediaEditorState.baseScale = 1;
            mediaEditorState.zoom = 1;
            mediaEditorState.offsetX = 0;
            mediaEditorState.offsetY = 0;
            mediaEditorState.dragging = false;
            mediaEditorError.textContent = "";
            mediaEditorImage.removeAttribute("src");
        }

        function clampMediaEditorOffsets() {
            const stageWidth = mediaEditorStage.clientWidth;
            const stageHeight = mediaEditorStage.clientHeight;
            const imageWidth = mediaEditorState.naturalWidth * mediaEditorState.baseScale * mediaEditorState.zoom;
            const imageHeight = mediaEditorState.naturalHeight * mediaEditorState.baseScale * mediaEditorState.zoom;
            const maxX = Math.max(0, (imageWidth - stageWidth) / 2);
            const maxY = Math.max(0, (imageHeight - stageHeight) / 2);
            mediaEditorState.offsetX = Math.min(maxX, Math.max(-maxX, mediaEditorState.offsetX));
            mediaEditorState.offsetY = Math.min(maxY, Math.max(-maxY, mediaEditorState.offsetY));
        }

        function renderMediaEditor() {
            clampMediaEditorOffsets();
            mediaEditorImage.style.width = `${mediaEditorState.naturalWidth * mediaEditorState.baseScale * mediaEditorState.zoom}px`;
            mediaEditorImage.style.height = `${mediaEditorState.naturalHeight * mediaEditorState.baseScale * mediaEditorState.zoom}px`;
            mediaEditorImage.style.transform = `translate(calc(-50% + ${mediaEditorState.offsetX}px), calc(-50% + ${mediaEditorState.offsetY}px))`;
        }

        function resetMediaEditorPosition() {
            const stageWidth = mediaEditorStage.clientWidth;
            const stageHeight = mediaEditorStage.clientHeight;
            mediaEditorState.baseScale = Math.max(
                stageWidth / mediaEditorState.naturalWidth,
                stageHeight / mediaEditorState.naturalHeight
            );
            mediaEditorState.zoom = 1;
            mediaEditorState.offsetX = 0;
            mediaEditorState.offsetY = 0;
            mediaEditorZoom.value = "1";
            renderMediaEditor();
        }

        function openMediaEditor(card) {
            const src = card.querySelector("[data-preview-image]")?.src;
            if (!src) return;
            resetMediaEditorState();
            mediaEditorState.card = card;
            mediaEditorState.sourceUrl = src;
            mediaEditorStage.style.aspectRatio = String(Number(card.dataset.cropAspect || 1.6));
            mediaEditorImage.src = src;
            mediaEditorModal.classList.add("is-open");
            mediaEditorModal.setAttribute("aria-hidden", "false");
        }

        function closeMediaEditor() {
            mediaEditorModal.classList.remove("is-open");
            mediaEditorModal.setAttribute("aria-hidden", "true");
            resetMediaEditorState();
        }

        function croppedFileName(fileName) {
            const base = String(fileName || "campus-life-imagen").replace(/\.[^.]+$/, "");
            return `${base}-encuadrada.jpg`;
        }

        function applyMediaEditor() {
            const card = mediaEditorState.card;
            if (!card || !mediaEditorState.naturalWidth || !mediaEditorState.naturalHeight) return;
            mediaEditorError.textContent = "";

            const aspect = Number(card.dataset.cropAspect || 1.6);
            const outputWidth = aspect >= 1.5 ? 1600 : 1000;
            const outputHeight = Math.round(outputWidth / aspect);
            const stageWidth = mediaEditorStage.clientWidth;
            const stageHeight = mediaEditorStage.clientHeight;
            const scale = mediaEditorState.baseScale * mediaEditorState.zoom;
            const visibleLeft = (mediaEditorState.naturalWidth * scale - stageWidth) / 2 - mediaEditorState.offsetX;
            const visibleTop = (mediaEditorState.naturalHeight * scale - stageHeight) / 2 - mediaEditorState.offsetY;
            const sourceX = Math.max(0, visibleLeft / scale);
            const sourceY = Math.max(0, visibleTop / scale);
            const sourceWidth = Math.min(mediaEditorState.naturalWidth - sourceX, stageWidth / scale);
            const sourceHeight = Math.min(mediaEditorState.naturalHeight - sourceY, stageHeight / scale);
            const canvas = document.createElement("canvas");
            canvas.width = outputWidth;
            canvas.height = outputHeight;

            try {
                canvas.getContext("2d").drawImage(mediaEditorImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, outputWidth, outputHeight);
            } catch (error) {
                mediaEditorError.textContent = "No se pudo editar esta imagen desde el navegador. Sube el archivo original para ajustarla.";
                return;
            }

            canvas.toBlob((blob) => {
                if (!blob) return;
                if (card.dataset.pendingImageSnapshot === "1") {
                    delete card.dataset.pendingImageSnapshot;
                } else {
                    pushImageSnapshot(card);
                }
                const input = card.querySelector("[data-image-input]");
                const removeInput = card.querySelector("[data-remove-image-input]");
                const restoreInput = card.querySelector("[data-restore-image-input]");
                const unhideInput = card.querySelector("[data-unhide-image-input]");
                const sourceName = input?.files?.[0]?.name || card.querySelector("[data-preview-image]")?.alt || "campus-life-imagen.jpg";
                const file = new File([blob], croppedFileName(sourceName), { type: "image/jpeg" });
                const transfer = new DataTransfer();

                transfer.items.add(file);
                input.files = transfer.files;
                if (removeInput) removeInput.value = "0";
                if (restoreInput) restoreInput.value = "";
                if (unhideInput) unhideInput.value = "0";
                setPreview(card, URL.createObjectURL(file));
                closeMediaEditor();
            }, "image/jpeg", 0.92);
        }

        function bindImageCard(card) {
            if (!card || card.dataset.imageBound) return;
            card.dataset.imageBound = "true";
            bindUndo(card);

            const input = card.querySelector("[data-image-input]");
            const removeInput = card.querySelector("[data-remove-image-input]");
            const restoreInput = card.querySelector("[data-restore-image-input]");
            const unhideInput = card.querySelector("[data-unhide-image-input]");
            const button = card.querySelector("[data-undo-card]");
            const previewImage = card.querySelector("[data-preview-image]");

            if (previewImage) {
                previewImage.addEventListener("error", () => clearPreview(card));
                if (previewImage.complete && previewImage.naturalWidth === 0) clearPreview(card);
            }

            input.addEventListener("change", () => {
                const file = input.files[0];
                if (!file) return;
                if (!["image/jpeg", "image/png"].includes(file.type) || file.size > 10 * 1024 * 1024) {
                    alert(file.size > 10 * 1024 * 1024 ? "La imagen sobrepasa los 10MB." : "Ese formato no está permitido. Usa JPG o PNG.");
                    input.value = "";
                    return;
                }
                pushImageSnapshot(card);
                card.dataset.pendingImageSnapshot = "1";
                removeInput.value = "0";
                if (restoreInput) restoreInput.value = "";
                if (unhideInput) unhideInput.value = "0";
                setPreview(card, URL.createObjectURL(file));
                openMediaEditor(card);
            });

            card.querySelector("[data-remove-image]").addEventListener("click", (event) => {
                event.preventDefault();
                pushImageSnapshot(card);
                delete card.dataset.pendingImageSnapshot;
                input.value = "";
                removeInput.value = "1";
                if (restoreInput) restoreInput.value = "";
                if (unhideInput) unhideInput.value = "0";
                clearPreview(card);
            });

            card.querySelector("[data-image-preview]").addEventListener("click", (event) => {
                if (event.target.closest("button")) return;
                openMediaEditor(card);
            });

            button?.addEventListener("click", (event) => {
                const stack = imageHistoryMap.get(card) || [];
                const memoryRecord = stack.pop();
                const record = memoryRecord || popStoredImageSnapshot(card);
                if (!record) return;
                event.preventDefault();
                event.stopImmediatePropagation();
                if (memoryRecord) popStoredImageSnapshot(card);
                applyImageSnapshot(card, record);
                setUndo(button, stack);
                refreshImageUndoButton(card);
            });

            refreshImageUndoButton(card);
        }

        document.querySelectorAll("[data-undo-scope]").forEach(bindUndo);
        document.querySelectorAll("[data-image-card]").forEach(bindImageCard);
        bindBasicTextMirrors();
        refreshAllFieldUndoButtons();
        window.addEventListener("pageshow", refreshAllFieldUndoButtons);
        mediaEditorImage.addEventListener("load", () => {
            mediaEditorState.naturalWidth = mediaEditorImage.naturalWidth;
            mediaEditorState.naturalHeight = mediaEditorImage.naturalHeight;
            resetMediaEditorPosition();
        });
        mediaEditorZoom.addEventListener("input", () => {
            mediaEditorState.zoom = Number(mediaEditorZoom.value);
            renderMediaEditor();
        });
        mediaEditorStage.addEventListener("pointerdown", (event) => {
            mediaEditorState.dragging = true;
            mediaEditorState.pointerX = event.clientX;
            mediaEditorState.pointerY = event.clientY;
            mediaEditorStage.setPointerCapture(event.pointerId);
        });
        mediaEditorStage.addEventListener("pointermove", (event) => {
            if (!mediaEditorState.dragging) return;
            mediaEditorState.offsetX += event.clientX - mediaEditorState.pointerX;
            mediaEditorState.offsetY += event.clientY - mediaEditorState.pointerY;
            mediaEditorState.pointerX = event.clientX;
            mediaEditorState.pointerY = event.clientY;
            renderMediaEditor();
        });
        mediaEditorStage.addEventListener("pointerup", (event) => {
            mediaEditorState.dragging = false;
            mediaEditorStage.releasePointerCapture(event.pointerId);
        });
        mediaEditorStage.addEventListener("pointercancel", () => {
            mediaEditorState.dragging = false;
        });
        mediaEditorClose.addEventListener("click", closeMediaEditor);
        mediaEditorApply.addEventListener("click", applyMediaEditor);
        document.addEventListener("keydown", (event) => {
            if (event.key === "Escape" && mediaEditorModal.classList.contains("is-open")) closeMediaEditor();
        });
    </script>
    @include('admin.partials.persistent-undo')
</body>
</html>
