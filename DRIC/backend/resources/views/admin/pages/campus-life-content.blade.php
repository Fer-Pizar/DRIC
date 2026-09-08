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
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .preview { align-items: center; background: #eef2f7; border-radius: 14px; display: flex; justify-content: center; min-height: 150px; overflow: hidden; padding: 14px; }
        .preview img { max-height: 170px; max-width: 100%; object-fit: contain; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .two-grid, .three-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Campus Life</h1>
                <p class="muted">Edita textos y enlaces. Las imágenes institucionales se mantienen fijas desde el sistema.</p>
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
                    <h2>Portada e información principal</h2>
                    <p class="muted">La portada y el logo institucional no son editables desde este panel.</p>
                </div>

                <label>
                    URL del sitio oficial UMSS
                    <input type="url" name="official_url" value="{{ old('official_url', $content['official_url']) }}">
                    @error('official_url')<span class="field-error">{{ $message }}</span>@enderror
                </label>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                @foreach ([
                                    'badge' => 'Insignia superior',
                                    'title' => 'Título principal',
                                    'subtitle' => 'Descripción principal',
                                    'official_label' => 'Texto pequeño del sitio oficial',
                                    'official_title' => 'Texto del botón o tarjeta oficial',
                                    'basic_kicker' => 'Etiqueta de información básica',
                                    'basic_title' => 'Título de información básica',
                                    'basic_text' => 'Texto de información básica',
                                ] as $field => $fieldLabel)
                                    <label>
                                        {{ $fieldLabel }}
                                        @if (str_contains($field, 'text') || $field === 'subtitle')
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
                    <h2>Estadísticas</h2>
                    <p class="muted">Edita los tres datos visibles de la franja de estadísticas.</p>
                </div>
                <div class="three-grid">
                    @foreach ($content['stats'] as $index => $stat)
                        <div class="item-card">
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
                    <p class="muted">Los íconos no se editan; solo textos.</p>
                </div>
                <div class="three-grid">
                    @foreach ($content['features'] as $index => $feature)
                        <div class="item-card">
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
                    <h2>Secciones con enlace</h2>
                    <p class="muted">Las imágenes de estas secciones son las originales del sistema. Aquí solo se editan textos y URLs.</p>
                </div>
                <div class="section-grid">
                    @foreach ($content['stories'] as $index => $story)
                        <article class="item-card">
                            <h3>{{ $storyLabels[$index] ?? 'Sección '.$index }}</h3>
                            <label>
                                URL de redirección
                                <input type="url" name="stories[{{ $index }}][url]" value="{{ old('stories.'.$index.'.url', $story['url']) }}">
                                @error('stories.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>

                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <label>Etiqueta<input type="text" name="stories[{{ $index }}][eyebrow_{{ $locale }}]" value="{{ old('stories.'.$index.'.eyebrow_'.$locale, $story['eyebrow_'.$locale]) }}">@error('stories.'.$index.'.eyebrow_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>Título<input type="text" name="stories[{{ $index }}][title_{{ $locale }}]" value="{{ old('stories.'.$index.'.title_'.$locale, $story['title_'.$locale]) }}">@error('stories.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>Texto<textarea name="stories[{{ $index }}][text_{{ $locale }}]">{{ old('stories.'.$index.'.text_'.$locale, $story['text_'.$locale]) }}</textarea>@error('stories.'.$index.'.text_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        @if ($index === 4)
                                            <label>Texto del botón<input type="text" name="stories[{{ $index }}][button_{{ $locale }}]" value="{{ old('stories.'.$index.'.button_'.$locale, $story['button_'.$locale] ?? '') }}">@error('stories.'.$index.'.button_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Campus Life.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>
</body>
</html>
