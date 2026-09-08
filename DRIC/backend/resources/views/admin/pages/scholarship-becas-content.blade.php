<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Becas</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1200px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .item-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .row-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .item-actions { align-items: center; display: flex; flex-wrap: wrap; gap: 10px; justify-content: flex-end; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .item-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 18px; }
        .item-card { display: grid; gap: 16px; }
        .item-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions, .item-header { align-items: stretch; flex-direction: column; } .language-grid, .two-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Becas</h1>
                <p class="muted">Administra la página pública de becas. Puedes crear, editar o quitar tarjetas de países y de otros canales.</p>
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

        <form method="POST" action="{{ route('admin.pages.scholarship-becas.update', $page) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Texto principal</h2>
                    <p class="muted">Estos textos aparecen en el encabezado y títulos de la página.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>Insignia superior<input type="text" name="{{ $locale }}[badge]" value="{{ old($locale.'.badge', $content[$locale]['badge']) }}">@error($locale.'.badge')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título principal<input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">@error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Descripción principal<textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>@error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Etiqueta de países<input type="text" name="{{ $locale }}[countries_badge]" value="{{ old($locale.'.countries_badge', $content[$locale]['countries_badge']) }}">@error($locale.'.countries_badge')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de países<input type="text" name="{{ $locale }}[countries_title]" value="{{ old($locale.'.countries_title', $content[$locale]['countries_title']) }}">@error($locale.'.countries_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Etiqueta de otros canales<input type="text" name="{{ $locale }}[organizations_badge]" value="{{ old($locale.'.organizations_badge', $content[$locale]['organizations_badge']) }}">@error($locale.'.organizations_badge')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de otros canales<input type="text" name="{{ $locale }}[organizations_title]" value="{{ old($locale.'.organizations_title', $content[$locale]['organizations_title']) }}">@error($locale.'.organizations_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            @foreach ([
                'countries' => ['title' => 'Países', 'items' => old('countries', $countries), 'button' => 'Agregar país'],
                'organizations' => ['title' => 'Otros canales', 'items' => old('organizations', $organizations), 'button' => 'Agregar canal'],
            ] as $groupKey => $group)
                <section class="panel">
                    <div class="panel-header">
                        <h2>{{ $group['title'] }}</h2>
                        <p class="muted">Cada tarjeta se guarda en la base de datos y se muestra en la página pública.</p>
                    </div>

                    <div class="item-list" id="{{ $groupKey }}-list">
                        @foreach ($group['items'] as $index => $item)
                            <article class="item-card" data-item-card>
                                <div class="item-header">
                                    <h3>{{ $group['title'] }} {{ $index + 1 }}</h3>
                                    <div class="item-actions">
                                        @if (! empty($item['id']))
                                            <a class="btn btn-primary" href="{{ route('admin.scholarship-items.detail.edit', $item['id']) }}">Editar detalle</a>
                                        @else
                                            <span class="hint">Guarda la tarjeta para editar su detalle.</span>
                                        @endif
                                        <button class="btn btn-remove" type="button" data-remove-item>Quitar</button>
                                    </div>
                                </div>
                                <input type="hidden" name="{{ $groupKey }}[{{ $index }}][id]" value="{{ $item['id'] ?? '' }}">
                                <label>
                                    URL de destino
                                    <input type="text" name="{{ $groupKey }}[{{ $index }}][url]" value="{{ $item['url'] ?? '' }}">
                                    <span class="hint">Puedes usar una ruta interna como /becas-movilidad/becas/alemania o una URL completa.</span>
                                    @error($groupKey.'.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <div class="language-grid">
                                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                        <div class="language-card">
                                            <h3>{{ $label }}</h3>
                                            <label>Nombre<input type="text" name="{{ $groupKey }}[{{ $index }}][name_{{ $locale }}]" value="{{ $item['name_'.$locale] ?? '' }}">@error($groupKey.'.'.$index.'.name_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Categoría<input type="text" name="{{ $groupKey }}[{{ $index }}][region_{{ $locale }}]" value="{{ $item['region_'.$locale] ?? '' }}">@error($groupKey.'.'.$index.'.region_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Descripción<textarea name="{{ $groupKey }}[{{ $index }}][summary_{{ $locale }}]">{{ $item['summary_'.$locale] ?? '' }}</textarea>@error($groupKey.'.'.$index.'.summary_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </div>
                                    @endforeach
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <button class="btn btn-add" type="button" data-add-item="{{ $groupKey }}">{{ $group['button'] }}</button>
                </section>
            @endforeach

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Becas.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>

        <template id="item-template">
            <article class="item-card" data-item-card>
                <div class="item-header">
                    <h3>Nueva tarjeta</h3>
                    <div class="item-actions">
                        <span class="hint">Guarda la tarjeta para editar su detalle.</span>
                        <button class="btn btn-remove" type="button" data-remove-item>Quitar</button>
                    </div>
                </div>
                <input type="hidden" name="__GROUP__[__INDEX__][id]" value="">
                <label>
                    URL de destino
                    <input type="text" name="__GROUP__[__INDEX__][url]" value="">
                    <span class="hint">Puedes usar una ruta interna como /becas-movilidad/becas/alemania o una URL completa.</span>
                </label>
                <div class="language-grid">
                    <div class="language-card">
                        <h3>Español</h3>
                        <label>Nombre<input type="text" name="__GROUP__[__INDEX__][name_es]" value=""></label>
                        <label>Categoría<input type="text" name="__GROUP__[__INDEX__][region_es]" value=""></label>
                        <label>Descripción<textarea name="__GROUP__[__INDEX__][summary_es]"></textarea></label>
                    </div>
                    <div class="language-card">
                        <h3>Inglés</h3>
                        <label>Nombre<input type="text" name="__GROUP__[__INDEX__][name_en]" value=""></label>
                        <label>Categoría<input type="text" name="__GROUP__[__INDEX__][region_en]" value=""></label>
                        <label>Descripción<textarea name="__GROUP__[__INDEX__][summary_en]"></textarea></label>
                    </div>
                </div>
            </article>
        </template>
    </main>

    <script>
        const template = document.getElementById('item-template').innerHTML;

        document.querySelectorAll('[data-add-item]').forEach((button) => {
            button.addEventListener('click', () => {
                const group = button.dataset.addItem;
                const list = document.getElementById(`${group}-list`);
                const index = list.querySelectorAll('[data-item-card]').length;
                const wrapper = document.createElement('div');
                wrapper.innerHTML = template.replaceAll('__GROUP__', group).replaceAll('__INDEX__', index);
                list.appendChild(wrapper.firstElementChild);
            });
        });

        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-item]')) {
                event.target.closest('[data-item-card]').remove();
            }
        });
    </script>
</body>
</html>
