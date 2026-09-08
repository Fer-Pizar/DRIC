<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Movilidad y Pasantías</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1240px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .program-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .program-actions, .toolbar { display: flex; flex-wrap: wrap; gap: 10px; }
        .program-actions { align-items: center; justify-content: flex-end; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; margin-top: 16px; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .btn-tool { background: #f8fafc; border: 1px solid var(--line); color: var(--ink); padding: 9px 11px; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .program-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .program-card { box-shadow: none; padding: 18px; }
        .program-card { display: grid; gap: 16px; }
        .program-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        textarea.conditions { min-height: 150px; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions, .program-header { align-items: stretch; flex-direction: column; } .language-grid, .two-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Movilidad y Pasantías</h1>
                <p class="muted">Administra solo contenido: textos, condiciones y enlaces de las tarjetas. El diseño público no se modifica.</p>
            </div>
            <div class="actions">
                @if ($hubPage)
                    <a class="btn btn-secondary" href="{{ route('admin.pages.scholarship-hub.edit', $hubPage) }}">Volver a Becas y Movilidad</a>
                @endif
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.mobility-pasantias.update', $page) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Texto principal</h2>
                    <p class="muted">Estos textos aparecen en la cabecera de la página pública.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>Título del menú<input type="text" name="{{ $locale }}[menu_title]" value="{{ old($locale.'.menu_title', $content[$locale]['menu_title']) }}">@error($locale.'.menu_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Etiqueta superior<input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">@error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título principal<input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">@error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Descripción principal<textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>@error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de movilidad estudiantil<input type="text" name="{{ $locale }}[students_title]" value="{{ old($locale.'.students_title', $content[$locale]['students_title']) }}">@error($locale.'.students_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto de movilidad estudiantil<textarea name="{{ $locale }}[students_intro]">{{ old($locale.'.students_intro', $content[$locale]['students_intro']) }}</textarea>@error($locale.'.students_intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de movilidad docente / administrativa<input type="text" name="{{ $locale }}[staff_title]" value="{{ old($locale.'.staff_title', $content[$locale]['staff_title']) }}">@error($locale.'.staff_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto de movilidad docente / administrativa<textarea name="{{ $locale }}[staff_intro]">{{ old($locale.'.staff_intro', $content[$locale]['staff_intro']) }}</textarea>@error($locale.'.staff_intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            @foreach ($tracks as $groupKey => $track)
                <section class="panel">
                    <div class="panel-header">
                        <h2>{{ $track['title'] }}</h2>
                        <p class="muted">Cada tarjeta se guarda en PostgreSQL y la página pública la leerá al recargar.</p>
                    </div>

                    <div class="program-list" id="{{ $groupKey }}-list">
                        @foreach (old($groupKey, $programs[$groupKey]) as $index => $program)
                            <article class="program-card" data-program-card>
                                <div class="program-header">
                                    <h3>Programa {{ $index + 1 }}</h3>
                                    <div class="program-actions">
                                        @if (! empty($program['id']))
                                            <a class="btn btn-primary" href="{{ route('admin.mobility-programs.detail.edit', $program['id']) }}">Editar contenido</a>
                                        @else
                                            <span class="hint">Guarda el programa para editar su contenido.</span>
                                        @endif
                                        <button class="btn btn-remove" type="button" data-remove-program>Quitar</button>
                                    </div>
                                </div>
                                <input type="hidden" name="{{ $groupKey }}[{{ $index }}][id]" value="{{ $program['id'] ?? '' }}">
                                <label>
                                    URL de destino
                                    <input type="text" name="{{ $groupKey }}[{{ $index }}][url]" value="{{ $program['url'] ?? '' }}">
                                    <span class="hint">Puedes usar una ruta interna como /becas-movilidad/movilidad-pasantias/programa o una URL completa.</span>
                                    @error($groupKey.'.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <div class="language-grid">
                                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                        <div class="language-card">
                                            <h3>{{ $label }}</h3>
                                            <div class="field-grid">
                                                <label>Título<input type="text" name="{{ $groupKey }}[{{ $index }}][title_{{ $locale }}]" value="{{ $program['title_'.$locale] ?? '' }}">@error($groupKey.'.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>Etiqueta<input type="text" name="{{ $groupKey }}[{{ $index }}][tag_{{ $locale }}]" value="{{ $program['tag_'.$locale] ?? '' }}">@error($groupKey.'.'.$index.'.tag_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>Descripción<textarea name="{{ $groupKey }}[{{ $index }}][summary_{{ $locale }}]">{{ $program['summary_'.$locale] ?? '' }}</textarea>@error($groupKey.'.'.$index.'.summary_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>
                                                    Condiciones
                                                    <div class="toolbar" aria-label="Herramientas de condiciones">
                                                        <button class="btn btn-tool" type="button" data-prefix-line="• ">Viñeta</button>
                                                        <button class="btn btn-tool" type="button" data-clear-prefixes>Limpiar viñetas</button>
                                                    </div>
                                                    <textarea class="conditions" name="{{ $groupKey }}[{{ $index }}][conditions_{{ $locale }}]">{{ $program['conditions_'.$locale] ?? '' }}</textarea>
                                                    <span class="hint">Escribe una condición por línea. Las viñetas se verán con el diseño original de la tarjeta.</span>
                                                    @error($groupKey.'.'.$index.'.conditions_'.$locale)<span class="field-error">{{ $message }}</span>@enderror
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <button class="btn btn-add" type="button" data-add-program="{{ $groupKey }}">{{ $track['button'] }}</button>
                </section>
            @endforeach

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Movilidad y Pasantías.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>

        <template id="program-template">
            <article class="program-card" data-program-card>
                <div class="program-header">
                    <h3>Nuevo programa</h3>
                    <div class="program-actions">
                        <span class="hint">Guarda el programa para editar su contenido.</span>
                        <button class="btn btn-remove" type="button" data-remove-program>Quitar</button>
                    </div>
                </div>
                <input type="hidden" name="__GROUP__[__INDEX__][id]" value="">
                <label>
                    URL de destino
                    <input type="text" name="__GROUP__[__INDEX__][url]" value="">
                    <span class="hint">Puedes usar una ruta interna o una URL completa.</span>
                </label>
                <div class="language-grid">
                    <div class="language-card">
                        <h3>Español</h3>
                        <div class="field-grid">
                            <label>Título<input type="text" name="__GROUP__[__INDEX__][title_es]" value=""></label>
                            <label>Etiqueta<input type="text" name="__GROUP__[__INDEX__][tag_es]" value=""></label>
                            <label>Descripción<textarea name="__GROUP__[__INDEX__][summary_es]"></textarea></label>
                            <label>Condiciones<div class="toolbar"><button class="btn btn-tool" type="button" data-prefix-line="• ">Viñeta</button><button class="btn btn-tool" type="button" data-clear-prefixes>Limpiar viñetas</button></div><textarea class="conditions" name="__GROUP__[__INDEX__][conditions_es]"></textarea><span class="hint">Una condición por línea.</span></label>
                        </div>
                    </div>
                    <div class="language-card">
                        <h3>Inglés</h3>
                        <div class="field-grid">
                            <label>Título<input type="text" name="__GROUP__[__INDEX__][title_en]" value=""></label>
                            <label>Etiqueta<input type="text" name="__GROUP__[__INDEX__][tag_en]" value=""></label>
                            <label>Descripción<textarea name="__GROUP__[__INDEX__][summary_en]"></textarea></label>
                            <label>Condiciones<div class="toolbar"><button class="btn btn-tool" type="button" data-prefix-line="• ">Viñeta</button><button class="btn btn-tool" type="button" data-clear-prefixes>Limpiar viñetas</button></div><textarea class="conditions" name="__GROUP__[__INDEX__][conditions_en]"></textarea><span class="hint">Una condición por línea.</span></label>
                        </div>
                    </div>
                </div>
            </article>
        </template>
    </main>

    <script>
        const template = document.getElementById('program-template').innerHTML;

        document.querySelectorAll('[data-add-program]').forEach((button) => {
            button.addEventListener('click', () => {
                const group = button.dataset.addProgram;
                const list = document.getElementById(`${group}-list`);
                const index = list.querySelectorAll('[data-program-card]').length;
                const wrapper = document.createElement('div');
                wrapper.innerHTML = template.replaceAll('__GROUP__', group).replaceAll('__INDEX__', index);
                list.appendChild(wrapper.firstElementChild);
            });
        });

        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-program]')) {
                event.target.closest('[data-program-card]').remove();
            }

            if (event.target.matches('[data-prefix-line]')) {
                const textarea = event.target.closest('label').querySelector('textarea');
                const lines = textarea.value.split('\n').filter((line) => line.trim().length > 0);
                textarea.value = lines.length ? lines.map((line) => line.trim().match(/^[•*-]/) ? line.trim() : `${event.target.dataset.prefixLine}${line.trim()}`).join('\n') : event.target.dataset.prefixLine;
                textarea.focus();
            }

            if (event.target.matches('[data-clear-prefixes]')) {
                const textarea = event.target.closest('label').querySelector('textarea');
                textarea.value = textarea.value.split('\n').map((line) => line.replace(/^[\s•*-]+/, '')).join('\n');
                textarea.focus();
            }
        });
    </script>
</body>
</html>
