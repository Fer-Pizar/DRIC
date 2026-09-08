<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Detalle de movilidad</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1240px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .item-card, .link-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .item-actions, .link-actions, .toolbar { align-items: center; display: flex; flex-wrap: wrap; gap: 10px; }
        .item-actions, .link-actions { justify-content: flex-end; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; margin-top: 14px; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .tool-btn { background: #f8fafc; border: 1px solid #d7deea; border-radius: 9px; color: var(--ink); cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; padding: 8px 10px; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .item-list, .links-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .item-card, .link-card { box-shadow: none; padding: 18px; }
        .item-card { display: grid; gap: 16px; }
        .link-card { background: #f8fafc; display: grid; gap: 12px; }
        .item-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        input[type="file"] { background: #fff; }
        textarea { line-height: 1.55; min-height: 130px; resize: vertical; }
        .content-editor { min-height: 230px; white-space: pre-wrap; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions, .item-header { align-items: stretch; flex-direction: column; } .language-grid, .two-grid { grid-template-columns: 1fr; } .item-actions, .link-actions { justify-content: flex-start; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Detalle del programa</h1>
                <p class="muted">Edita el contenido público de {{ $name['es'] }}. Los PDFs se guardan como archivos del sitio y los enlaces pueden apuntar a URLs externas o rutas internas.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.mobility-pasantias.edit', $page) }}">Volver a Movilidad</a>
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.mobility-programs.detail.update', $block) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Datos clave</h2>
                    <p class="muted">Aparecen en el panel lateral como información rápida del programa.</p>
                </div>
                <div class="item-list" id="highlights-list">
                    @foreach (old('highlights', $detail['highlights'] ?? []) as $index => $item)
                        <article class="item-card" data-highlight-card>
                            <div class="item-header"><h3>Dato {{ $index + 1 }}</h3><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div>
                            <div class="two-grid">
                                <label>Etiqueta en español<input type="text" name="highlights[{{ $index }}][label_es]" value="{{ $item['label_es'] ?? '' }}">@error('highlights.'.$index.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Etiqueta en inglés<input type="text" name="highlights[{{ $index }}][label_en]" value="{{ $item['label_en'] ?? '' }}">@error('highlights.'.$index.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Valor en español<input type="text" name="highlights[{{ $index }}][value_es]" value="{{ $item['value_es'] ?? '' }}">@error('highlights.'.$index.'.value_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Valor en inglés<input type="text" name="highlights[{{ $index }}][value_en]" value="{{ $item['value_en'] ?? '' }}">@error('highlights.'.$index.'.value_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </article>
                    @endforeach
                </div>
                <button class="btn btn-add" type="button" data-add-highlight>Agregar dato clave</button>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Enlace oficial</h2>
                    <p class="muted">Se muestra como tarjeta de enlace oficial. Puedes usar una URL o subir un PDF de hasta 20 MB.</p>
                </div>
                <div class="two-grid">
                    <label>Texto del enlace en español<input type="text" name="reference[label_es]" value="{{ old('reference.label_es', $detail['reference']['label_es'] ?? '') }}">@error('reference.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                    <label>Texto del enlace en inglés<input type="text" name="reference[label_en]" value="{{ old('reference.label_en', $detail['reference']['label_en'] ?? '') }}">@error('reference.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                </div>
                <label>URL actual o nueva<input type="text" name="reference[href]" value="{{ old('reference.href', $detail['reference']['href'] ?? '') }}">@error('reference.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                <input type="hidden" name="reference[existing_href]" value="{{ $detail['reference']['existing_href'] ?? '' }}">
                <input type="hidden" name="reference[existing_media_asset_id]" value="{{ $detail['reference']['existing_media_asset_id'] ?? '' }}">
                <label>Subir PDF opcional<input type="file" name="reference[pdf]" accept="application/pdf">@error('reference.pdf')<span class="field-error">{{ $message }}</span>@enderror</label>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Guía del programa</h2>
                    <p class="muted">Cada sección se mostrará como tarjeta. En el contenido, una línea normal será texto y una línea con viñeta será lista.</p>
                </div>
                <div class="item-list" id="sections-list">
                    @foreach (old('sections', $detail['sections'] ?? []) as $index => $item)
                        <article class="item-card" data-section-card>
                            <div class="item-header"><h3>Sección {{ $index + 1 }}</h3><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div>
                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <label>Título<input type="text" name="sections[{{ $index }}][title_{{ $locale }}]" value="{{ $item['title_'.$locale] ?? '' }}">@error('sections.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>
                                            Contenido
                                            <div class="toolbar">
                                                <button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button>
                                                <button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button>
                                            </div>
                                            <textarea class="content-editor" name="sections[{{ $index }}][content_{{ $locale }}]" data-smart-editor>{{ $item['content_'.$locale] ?? '' }}</textarea>
                                            @error('sections.'.$index.'.content_'.$locale)<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
                <button class="btn btn-add" type="button" data-add-section>Agregar sección</button>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Convocatorias y documentos</h2>
                    <p class="muted">Puedes agregar convocatorias, beneficios, documentos, fechas, notas y varios enlaces o PDFs.</p>
                </div>
                <div class="item-list" id="calls-list">
                    @foreach (old('calls', $detail['calls'] ?? []) as $index => $call)
                        <article class="item-card" data-call-card data-call-index="{{ $index }}">
                            <div class="item-header"><h3>Convocatoria {{ $index + 1 }}</h3><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div>
                            <input type="hidden" name="calls[{{ $index }}][id]" value="{{ $call['id'] ?? '' }}">
                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <div class="field-grid">
                                            <label>Título<input type="text" name="calls[{{ $index }}][title_{{ $locale }}]" value="{{ $call['title_'.$locale] ?? '' }}">@error('calls.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Descripción<textarea name="calls[{{ $index }}][description_{{ $locale }}]">{{ $call['description_'.$locale] ?? '' }}</textarea>@error('calls.'.$index.'.description_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Beneficios<textarea name="calls[{{ $index }}][benefits_{{ $locale }}]">{{ $call['benefits_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por beneficio.</span>@error('calls.'.$index.'.benefits_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Documentos<textarea name="calls[{{ $index }}][documents_{{ $locale }}]">{{ $call['documents_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por documento visible.</span>@error('calls.'.$index.'.documents_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Plazo<input type="text" name="calls[{{ $index }}][deadline_{{ $locale }}]" value="{{ $call['deadline_'.$locale] ?? '' }}">@error('calls.'.$index.'.deadline_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Nota<textarea name="calls[{{ $index }}][note_{{ $locale }}]">{{ $call['note_'.$locale] ?? '' }}</textarea>@error('calls.'.$index.'.note_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div>
                                <h3>Enlaces y PDFs</h3>
                                <div class="links-list" data-links-list>
                                    @foreach (($call['links'] ?? []) as $linkIndex => $link)
                                        <article class="link-card" data-link-card data-link-index="{{ $linkIndex }}">
                                            <div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar enlace</button></div>
                                            <div class="two-grid">
                                                <label>Texto en español<input type="text" name="calls[{{ $index }}][links][{{ $linkIndex }}][label_es]" value="{{ $link['label_es'] ?? '' }}">@error('calls.'.$index.'.links.'.$linkIndex.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>Texto en inglés<input type="text" name="calls[{{ $index }}][links][{{ $linkIndex }}][label_en]" value="{{ $link['label_en'] ?? '' }}">@error('calls.'.$index.'.links.'.$linkIndex.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                            </div>
                                            <label>URL<input type="text" name="calls[{{ $index }}][links][{{ $linkIndex }}][href]" value="{{ $link['href'] ?? '' }}">@error('calls.'.$index.'.links.'.$linkIndex.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <input type="hidden" name="calls[{{ $index }}][links][{{ $linkIndex }}][existing_href]" value="{{ $link['existing_href'] ?? '' }}">
                                            <input type="hidden" name="calls[{{ $index }}][links][{{ $linkIndex }}][existing_media_asset_id]" value="{{ $link['existing_media_asset_id'] ?? '' }}">
                                            <label>Subir PDF opcional<input type="file" name="calls[{{ $index }}][links][{{ $linkIndex }}][pdf]" accept="application/pdf">@error('calls.'.$index.'.links.'.$linkIndex.'.pdf')<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </article>
                                    @endforeach
                                </div>
                                <button class="btn btn-add" type="button" data-add-link>Agregar enlace o PDF</button>
                            </div>
                        </article>
                    @endforeach
                </div>
                <button class="btn btn-add" type="button" data-add-call>Agregar convocatoria</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar el detalle público.</span>
                <button class="btn btn-primary" type="submit">Guardar detalle</button>
            </div>
        </form>
    </main>

    <template id="highlight-template"><article class="item-card" data-highlight-card><div class="item-header"><h3>Nuevo dato</h3><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div><div class="two-grid"><label>Etiqueta en español<input type="text" name="highlights[__INDEX__][label_es]" value=""></label><label>Etiqueta en inglés<input type="text" name="highlights[__INDEX__][label_en]" value=""></label><label>Valor en español<input type="text" name="highlights[__INDEX__][value_es]" value=""></label><label>Valor en inglés<input type="text" name="highlights[__INDEX__][value_en]" value=""></label></div></article></template>
    <template id="section-template"><article class="item-card" data-section-card><div class="item-header"><h3>Nueva sección</h3><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div><div class="language-grid"><div class="language-card"><h3>Español</h3><label>Título<input type="text" name="sections[__INDEX__][title_es]" value=""></label><label>Contenido<div class="toolbar"><button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button><button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button></div><textarea class="content-editor" name="sections[__INDEX__][content_es]" data-smart-editor></textarea></label></div><div class="language-card"><h3>Inglés</h3><label>Título<input type="text" name="sections[__INDEX__][title_en]" value=""></label><label>Contenido<div class="toolbar"><button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button><button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button></div><textarea class="content-editor" name="sections[__INDEX__][content_en]" data-smart-editor></textarea></label></div></div></article></template>
    <template id="call-template"><article class="item-card" data-call-card data-call-index="__CALL__"><div class="item-header"><h3>Nueva convocatoria</h3><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div><input type="hidden" name="calls[__CALL__][id]" value=""><div class="language-grid"><div class="language-card"><h3>Español</h3><div class="field-grid"><label>Título<input type="text" name="calls[__CALL__][title_es]" value=""></label><label>Descripción<textarea name="calls[__CALL__][description_es]"></textarea></label><label>Beneficios<textarea name="calls[__CALL__][benefits_es]"></textarea></label><label>Documentos<textarea name="calls[__CALL__][documents_es]"></textarea></label><label>Plazo<input type="text" name="calls[__CALL__][deadline_es]" value=""></label><label>Nota<textarea name="calls[__CALL__][note_es]"></textarea></label></div></div><div class="language-card"><h3>Inglés</h3><div class="field-grid"><label>Título<input type="text" name="calls[__CALL__][title_en]" value=""></label><label>Descripción<textarea name="calls[__CALL__][description_en]"></textarea></label><label>Beneficios<textarea name="calls[__CALL__][benefits_en]"></textarea></label><label>Documentos<textarea name="calls[__CALL__][documents_en]"></textarea></label><label>Plazo<input type="text" name="calls[__CALL__][deadline_en]" value=""></label><label>Nota<textarea name="calls[__CALL__][note_en]"></textarea></label></div></div></div><div><h3>Enlaces y PDFs</h3><div class="links-list" data-links-list></div><button class="btn btn-add" type="button" data-add-link>Agregar enlace o PDF</button></div></article></template>
    <template id="link-template"><article class="link-card" data-link-card data-link-index="__LINK__"><div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar enlace</button></div><div class="two-grid"><label>Texto en español<input type="text" name="calls[__CALL__][links][__LINK__][label_es]" value=""></label><label>Texto en inglés<input type="text" name="calls[__CALL__][links][__LINK__][label_en]" value=""></label></div><label>URL<input type="text" name="calls[__CALL__][links][__LINK__][href]" value=""></label><input type="hidden" name="calls[__CALL__][links][__LINK__][existing_href]" value=""><input type="hidden" name="calls[__CALL__][links][__LINK__][existing_media_asset_id]" value=""><label>Subir PDF opcional<input type="file" name="calls[__CALL__][links][__LINK__][pdf]" accept="application/pdf"></label></article></template>

    <script>
        function addFromTemplate(listId, templateId, selector) {
            const list = document.getElementById(listId);
            const index = list.querySelectorAll(selector).length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById(templateId).innerHTML.replaceAll('__INDEX__', index);
            list.appendChild(wrapper.firstElementChild);
        }

        function addLink(card) {
            const list = card.querySelector('[data-links-list]');
            const callIndex = card.dataset.callIndex;
            const linkIndex = list.querySelectorAll('[data-link-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('link-template').innerHTML.replaceAll('__CALL__', callIndex).replaceAll('__LINK__', linkIndex);
            list.appendChild(wrapper.firstElementChild);
        }

        function selectedLines(textarea) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const value = textarea.value;
            const lineStart = value.lastIndexOf('\n', Math.max(0, start - 1)) + 1;
            const lineEndSearch = value.indexOf('\n', end);
            const lineEnd = lineEndSearch === -1 ? value.length : lineEndSearch;
            return { start: lineStart, end: lineEnd, text: value.slice(lineStart, lineEnd) };
        }

        function applyEditorAction(button) {
            const editor = button.closest('label').querySelector('[data-smart-editor]');
            const selection = selectedLines(editor);
            const original = selection.text || '';
            const replacement = button.dataset.editorAction === 'bullet'
                ? original.split('\n').map((line) => {
                    const clean = line.replace(/^\s*[-*•]\s+/u, '').trim();
                    return clean ? `- ${clean}` : '- Nueva viñeta';
                }).join('\n')
                : (original.split('\n').map((line) => line.replace(/^\s*[-*•]\s+/u, '').trim()).filter(Boolean).join('\n\n') || 'Nuevo párrafo');
            editor.value = `${editor.value.slice(0, selection.start)}${replacement}${editor.value.slice(selection.end)}`;
            editor.focus();
        }

        document.querySelector('[data-add-highlight]').addEventListener('click', () => addFromTemplate('highlights-list', 'highlight-template', '[data-highlight-card]'));
        document.querySelector('[data-add-section]').addEventListener('click', () => addFromTemplate('sections-list', 'section-template', '[data-section-card]'));
        document.querySelector('[data-add-call]').addEventListener('click', () => {
            const list = document.getElementById('calls-list');
            const index = list.querySelectorAll('[data-call-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('call-template').innerHTML.replaceAll('__CALL__', index);
            list.appendChild(wrapper.firstElementChild);
        });

        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-item]')) event.target.closest('.item-card').remove();
            if (event.target.matches('[data-add-link]')) addLink(event.target.closest('[data-call-card]'));
            if (event.target.matches('[data-remove-link]')) event.target.closest('[data-link-card]').remove();
            if (event.target.matches('[data-editor-action]')) applyEditorAction(event.target);
        });
    </script>
</body>
</html>
