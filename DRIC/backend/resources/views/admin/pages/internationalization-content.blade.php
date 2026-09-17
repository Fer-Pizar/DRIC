<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Internacionalización</title>
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
        .language-grid, .three-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .three-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 18px; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 112px; resize: vertical; }
        textarea.large { min-height: 260px; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid, .three-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Internacionalización</h1>
                <p class="muted">Edita únicamente el contenido textual visible en la página pública. El diseño y los íconos se mantienen fijos.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.internationalization.update', $page) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Portada</h2>
                    <p class="muted">Corresponde al encabezado principal de la página.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Insignia superior
                                    <input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">
                                    @error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título principal
                                    <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                    @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción principal
                                    <textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>
                                    @error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Contenido central</h2>
                    <p class="muted">Separa los párrafos con una línea en blanco para mantener la lectura ordenada en la página pública.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título de la sección
                                    <input type="text" name="{{ $locale }}[detail_title]" value="{{ old($locale.'.detail_title', $content[$locale]['detail_title']) }}">
                                    @error($locale.'.detail_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto de la sección
                                    <textarea class="large" name="{{ $locale }}[detail_text]">{{ old($locale.'.detail_text', $content[$locale]['detail_text']) }}</textarea>
                                    <span class="hint">Cada bloque separado por línea en blanco se mostrará como un párrafo.</span>
                                    @error($locale.'.detail_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Ejes de trabajo</h2>
                    <p class="muted">Edita el texto introductorio y las tres tarjetas. Los íconos se conservan como parte del diseño.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Etiqueta
                                    <input type="text" name="{{ $locale }}[section_eyebrow]" value="{{ old($locale.'.section_eyebrow', $content[$locale]['section_eyebrow']) }}">
                                    @error($locale.'.section_eyebrow')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[section_title]" value="{{ old($locale.'.section_title', $content[$locale]['section_title']) }}">
                                    @error($locale.'.section_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[section_text]">{{ old($locale.'.section_text', $content[$locale]['section_text']) }}</textarea>
                                    @error($locale.'.section_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="three-grid" style="margin-top: 18px;">
                    @foreach ($content['cards'] as $index => $card)
                        <div class="item-card">
                            <h3>Tarjeta {{ $index }}</h3>
                            <label>
                                Título en español
                                <input type="text" name="cards[{{ $index }}][title_es]" value="{{ old('cards.'.$index.'.title_es', $card['title_es']) }}">
                                @error('cards.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label>
                                Texto en español
                                <textarea name="cards[{{ $index }}][text_es]">{{ old('cards.'.$index.'.text_es', $card['text_es']) }}</textarea>
                                @error('cards.'.$index.'.text_es')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label>
                                Título en inglés
                                <input type="text" name="cards[{{ $index }}][title_en]" value="{{ old('cards.'.$index.'.title_en', $card['title_en']) }}">
                                @error('cards.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                            <label>
                                Texto en inglés
                                <textarea name="cards[{{ $index }}][text_en]">{{ old('cards.'.$index.'.text_en', $card['text_en']) }}</textarea>
                                @error('cards.'.$index.'.text_en')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se mostrarán al recargar Internacionalización.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>
</body>
</html>
