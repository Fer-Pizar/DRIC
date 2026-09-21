<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Detalle de beca</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1200px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .item-card, .link-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .item-actions, .link-actions, .links-heading { align-items: center; display: flex; flex-wrap: wrap; gap: 10px; }
        .item-actions, .link-actions { justify-content: flex-end; }
        .links-heading { justify-content: space-between; margin-bottom: 12px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .undo-floating { position: absolute; right: 12px; top: 12px; z-index: 4; }
        .item-card > .undo-floating, .link-card > .undo-floating { right: -10px; top: -10px; z-index: 6; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .item-list, .links-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .item-card, .link-card { box-shadow: none; padding: 18px; position: relative; }
        .item-card { display: grid; gap: 16px; }
        .link-card { display: grid; gap: 12px; background: #f8fafc; }
        .item-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        .editor-toolbar { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 8px; }
        .tool-btn { background: #f8fafc; border: 1px solid #d7deea; border-radius: 9px; color: var(--ink); cursor: pointer; font: inherit; font-size: 12px; font-weight: 800; padding: 8px 10px; }
        .tool-btn:hover { background: #edf2f8; border-color: #b8c3d6; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 150px; resize: vertical; }
        .content-editor { font-family: Arial, sans-serif; min-height: 380px; white-space: pre-wrap; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 900px) { .topbar, .sticky-actions, .item-header, .links-heading { align-items: stretch; flex-direction: column; } .language-grid, .two-grid { grid-template-columns: 1fr; } .item-actions, .link-actions { justify-content: flex-start; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Detalle de beca</h1>
                <p class="muted">Edita el contenido público de {{ $name['es'] }}. Puedes crear secciones, viñetas y varios enlaces.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.scholarship-becas.edit', $page) }}">Volver a Becas</a>
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.scholarship-items.detail.update', $block) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Contenido de la página</h2>
                <p class="muted">Cada bloque se mostrará como una sección en la página pública. Usa los botones para insertar subtítulos y viñetas sin cambiar el diseño.</p>
                </div>

                <div class="item-list" id="opportunities-list">
                    @foreach ($items as $index => $item)
                        <article class="item-card" data-opportunity-card data-opportunity-index="{{ $index }}">
                            <div class="item-header">
                                <h3>Contenido {{ $index + 1 }}</h3>
                                <div class="item-actions">
                                    <button class="btn btn-remove" type="button" data-remove-opportunity>Eliminar contenido</button>
                                </div>
                            </div>
                            <input type="hidden" name="opportunities[{{ $index }}][id]" value="{{ $item['id'] ?? '' }}">
                            <input type="hidden" name="opportunities[{{ $index }}][raw_sections]" value="{{ $item['raw_sections'] ?? '' }}">
                            <input type="hidden" name="opportunities[{{ $index }}][original_content_es]" value="{{ $item['original_content_es'] ?? '' }}">
                            <input type="hidden" name="opportunities[{{ $index }}][original_content_en]" value="{{ $item['original_content_en'] ?? '' }}">

                            <div class="language-grid">
                                <div class="language-card">
                                    <h3>Español</h3>
                                    <label>Título<input type="text" name="opportunities[{{ $index }}][title_es]" value="{{ $item['title_es'] ?? '' }}">@error('opportunities.'.$index.'.title_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>
                                        Contenido
                                        <div class="editor-toolbar" aria-label="Herramientas del editor">
                                            <button class="tool-btn" type="button" data-editor-action="bold">Negrita</button>
                                            <button class="tool-btn" type="button" data-editor-action="italic">Cursiva</button>
                                            <button class="tool-btn" type="button" data-editor-action="subtitle">Subtítulo</button>
                                            <button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button>
                                            <button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button>
                                        </div>
                                        <textarea class="content-editor" name="opportunities[{{ $index }}][content_es]" data-smart-editor>{{ $item['content_es'] ?? '' }}</textarea>
                                        <span class="hint">Texto normal = párrafo. Líneas con ## = subtítulos. Líneas con - = viñetas.</span>
                                        @error('opportunities.'.$index.'.content_es')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                </div>

                                <div class="language-card">
                                    <h3>Inglés</h3>
                                    <label>Título<input type="text" name="opportunities[{{ $index }}][title_en]" value="{{ $item['title_en'] ?? '' }}">@error('opportunities.'.$index.'.title_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                    <label>
                                        Contenido
                                        <div class="editor-toolbar" aria-label="Herramientas del editor">
                                            <button class="tool-btn" type="button" data-editor-action="bold">Negrita</button>
                                            <button class="tool-btn" type="button" data-editor-action="italic">Cursiva</button>
                                            <button class="tool-btn" type="button" data-editor-action="subtitle">Subtítulo</button>
                                            <button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button>
                                            <button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button>
                                        </div>
                                        <textarea class="content-editor" name="opportunities[{{ $index }}][content_en]" data-smart-editor>{{ $item['content_en'] ?? '' }}</textarea>
                                        <span class="hint">Si se deja vacío, se usará el contenido en español.</span>
                                        @error('opportunities.'.$index.'.content_en')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                </div>
                            </div>

                            <div data-links-section>
                                <div class="links-heading">
                                    <div>
                                        <h3>Enlaces</h3>
                                        <p class="muted">Puedes agregar más de un enlace o PDF por contenido.</p>
                                    </div>
                                    <button class="btn btn-undo" type="button" data-restore-link disabled title="Restaurar último enlace eliminado" aria-label="Restaurar último enlace eliminado">↶</button>
                                </div>
                                <div class="links-list" data-links-list>
                                    @foreach (($item['links'] ?? []) as $linkIndex => $link)
                                        <article class="link-card" data-link-card data-link-index="{{ $linkIndex }}">
                                            <div class="link-actions">
                                                <button class="btn btn-remove" type="button" data-remove-link>Quitar enlace</button>
                                            </div>
                                            <div class="two-grid">
                                                <label>Texto del enlace en español<input type="text" name="opportunities[{{ $index }}][links][{{ $linkIndex }}][label_es]" value="{{ $link['label_es'] ?? '' }}">@error('opportunities.'.$index.'.links.'.$linkIndex.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>Texto del enlace en inglés<input type="text" name="opportunities[{{ $index }}][links][{{ $linkIndex }}][label_en]" value="{{ $link['label_en'] ?? '' }}">@error('opportunities.'.$index.'.links.'.$linkIndex.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                            </div>
                                            <label>URL o PDF<input type="text" name="opportunities[{{ $index }}][links][{{ $linkIndex }}][href]" value="{{ $link['href'] ?? '' }}">@error('opportunities.'.$index.'.links.'.$linkIndex.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </article>
                                    @endforeach
                                </div>
                                <button class="btn btn-add" type="button" data-add-link>Agregar enlace</button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <button class="btn btn-add" type="button" data-add-opportunity>Agregar contenido</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar la página pública.</span>
                <button class="btn btn-primary" type="submit">Guardar detalle</button>
            </div>
        </form>

        <template id="opportunity-template">
            <article class="item-card" data-opportunity-card data-opportunity-index="__OPP__">
                <div class="item-header">
                    <h3>Nuevo contenido</h3>
                    <div class="item-actions"><button class="btn btn-remove" type="button" data-remove-opportunity>Eliminar contenido</button></div>
                </div>
                <input type="hidden" name="opportunities[__OPP__][id]" value="">
                <input type="hidden" name="opportunities[__OPP__][raw_sections]" value="">
                <input type="hidden" name="opportunities[__OPP__][original_content_es]" value="">
                <input type="hidden" name="opportunities[__OPP__][original_content_en]" value="">
                <div class="language-grid">
                    <div class="language-card">
                        <h3>Español</h3>
                        <label>Título<input type="text" name="opportunities[__OPP__][title_es]" value=""></label>
                        <label>
                            Contenido
                            <div class="editor-toolbar" aria-label="Herramientas del editor">
                                <button class="tool-btn" type="button" data-editor-action="bold">Negrita</button>
                                <button class="tool-btn" type="button" data-editor-action="italic">Cursiva</button>
                                <button class="tool-btn" type="button" data-editor-action="subtitle">Subtítulo</button>
                                <button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button>
                                <button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button>
                            </div>
                            <textarea class="content-editor" name="opportunities[__OPP__][content_es]" data-smart-editor></textarea>
                            <span class="hint">Texto normal = párrafo. Líneas con ## = subtítulos. Líneas con - = viñetas.</span>
                        </label>
                    </div>
                    <div class="language-card">
                        <h3>Inglés</h3>
                        <label>Título<input type="text" name="opportunities[__OPP__][title_en]" value=""></label>
                        <label>
                            Contenido
                            <div class="editor-toolbar" aria-label="Herramientas del editor">
                                <button class="tool-btn" type="button" data-editor-action="bold">Negrita</button>
                                <button class="tool-btn" type="button" data-editor-action="italic">Cursiva</button>
                                <button class="tool-btn" type="button" data-editor-action="subtitle">Subtítulo</button>
                                <button class="tool-btn" type="button" data-editor-action="bullet">Viñeta</button>
                                <button class="tool-btn" type="button" data-editor-action="paragraph">Párrafo</button>
                            </div>
                            <textarea class="content-editor" name="opportunities[__OPP__][content_en]" data-smart-editor></textarea>
                            <span class="hint">Si se deja vacío, se usará el contenido en español.</span>
                        </label>
                    </div>
                </div>
                <div data-links-section>
                    <div class="links-heading">
                        <div>
                            <h3>Enlaces</h3>
                            <p class="muted">Puedes agregar más de un enlace o PDF por contenido.</p>
                        </div>
                        <button class="btn btn-undo" type="button" data-restore-link disabled title="Restaurar último enlace eliminado" aria-label="Restaurar último enlace eliminado">↶</button>
                    </div>
                    <div class="links-list" data-links-list></div>
                    <button class="btn btn-add" type="button" data-add-link>Agregar enlace</button>
                </div>
            </article>
        </template>

        <template id="link-template">
            <article class="link-card" data-link-card data-link-index="__LINK__">
                <div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar enlace</button></div>
                <div class="two-grid">
                    <label>Texto del enlace en español<input type="text" name="opportunities[__OPP__][links][__LINK__][label_es]" value=""></label>
                    <label>Texto del enlace en inglés<input type="text" name="opportunities[__OPP__][links][__LINK__][label_en]" value=""></label>
                </div>
                <label>URL o PDF<input type="text" name="opportunities[__OPP__][links][__LINK__][href]" value=""></label>
            </article>
        </template>
    </main>

    <script>
        const opportunityTemplate = document.getElementById('opportunity-template').innerHTML;
        const linkTemplate = document.getElementById('link-template').innerHTML;
        const opportunitiesList = document.getElementById('opportunities-list');
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();
        const removedLinkHistory = new WeakMap();

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll('input, textarea'));
        }

        function snapshotScope(scope) {
            return editableFields(scope).map((field) => ({
                name: field.name,
                type: field.type,
                value: field.value,
                checked: field.checked,
            }));
        }

        function restoreSnapshot(scope, snapshot) {
            snapshot.forEach((item) => {
                const field = editableFields(scope).find((candidate) => candidate.name === item.name);
                if (!field) return;

                if (field.type === 'checkbox') {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
                field.dispatchEvent(new Event('input', { bubbles: true }));
            });
        }

        function historyFor(scope) {
            if (!cardHistory.has(scope)) cardHistory.set(scope, []);
            return cardHistory.get(scope);
        }

        function setUndoState(scope) {
            const button = scope.querySelector(':scope > [data-undo-card]');
            if (button) button.disabled = historyFor(scope).length === 0;
        }

        function pushSnapshot(scope, snapshot = snapshotScope(scope)) {
            const history = historyFor(scope);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) history.push(snapshot);
            if (history.length > 20) history.shift();
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
            const scope = field.closest('[data-undo-scope]');
            if (!scope || fieldStartSnapshots.has(field)) return;
            fieldStartSnapshots.set(field, snapshotScope(scope));
        }

        function rememberFieldChange(field) {
            const scope = field.closest('[data-undo-scope]');
            const snapshot = fieldStartSnapshots.get(field);
            if (!scope || !snapshot) return;

            pushSnapshot(scope, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function bindUndoScope(scope) {
            if (scope.dataset.undoBound === '1') return;
            scope.dataset.undoScope = '';
            scope.dataset.undoBound = '1';

            const button = document.createElement('button');
            button.className = 'btn btn-undo undo-floating';
            button.type = 'button';
            button.dataset.undoCard = '';
            button.disabled = true;
            button.title = 'Deshacer último cambio';
            button.setAttribute('aria-label', 'Deshacer último cambio');
            button.textContent = '↶';
            scope.appendChild(button);

            button.addEventListener('click', () => undoScope(scope));
            editableFields(scope).forEach((field) => {
                field.addEventListener('focusin', () => markFieldStart(field));
                field.addEventListener('input', () => rememberFieldChange(field));
                field.addEventListener('change', () => rememberFieldChange(field));
            });
        }

        function bindUndoScopes(root = document) {
            if (root.matches?.('.language-card, .item-card, .link-card')) bindUndoScope(root);
            root.querySelectorAll('.language-card, .item-card, .link-card').forEach(bindUndoScope);
        }

        function linkRemovalHistoryFor(list) {
            if (!removedLinkHistory.has(list)) removedLinkHistory.set(list, []);
            return removedLinkHistory.get(list);
        }

        function setRestoreLinkState(list) {
            const button = list.closest('[data-links-section]')?.querySelector('[data-restore-link]');
            if (button) button.disabled = linkRemovalHistoryFor(list).length === 0;
        }

        function cleanLinkSnapshot(card) {
            const clone = card.cloneNode(true);
            clone.querySelectorAll('[data-undo-card]').forEach((button) => button.remove());
            delete clone.dataset.undoScope;
            delete clone.dataset.undoBound;
            return clone.outerHTML;
        }

        function updateLinkIndexes(opportunityCard) {
            const oppIndex = opportunityCard.dataset.opportunityIndex;
            opportunityCard.querySelectorAll('[data-link-card]').forEach((linkCard, index) => {
                linkCard.dataset.linkIndex = index;
                linkCard.querySelectorAll('input, textarea').forEach((field) => {
                    field.name = field.name.replace(/opportunities\[[^\]]+\]\[links\]\[[^\]]+\]/u, `opportunities[${oppIndex}][links][${index}]`);
                });
            });
        }

        function rememberRemovedLink(linkCard) {
            const list = linkCard.closest('[data-links-list]');
            const cards = [...list.querySelectorAll('[data-link-card]')];
            const history = linkRemovalHistoryFor(list);
            history.push({
                html: cleanLinkSnapshot(linkCard),
                index: cards.indexOf(linkCard),
            });

            if (history.length > 20) history.shift();
            setRestoreLinkState(list);
        }

        function restoreRemovedLink(button) {
            const section = button.closest('[data-links-section]');
            const list = section.querySelector('[data-links-list]');
            const snapshot = linkRemovalHistoryFor(list).pop();
            if (!snapshot) return;

            const wrapper = document.createElement('div');
            wrapper.innerHTML = snapshot.html.trim();
            const linkCard = wrapper.firstElementChild;
            const reference = list.querySelectorAll('[data-link-card]')[snapshot.index] || null;
            list.insertBefore(linkCard, reference);
            bindUndoScopes(linkCard);
            updateLinkIndexes(button.closest('[data-opportunity-card]'));
            setRestoreLinkState(list);
        }

        function bindRestoreLinkControls(root = document) {
            root.querySelectorAll('[data-links-section]').forEach((section) => {
                if (section.dataset.restoreLinkBound === '1') return;

                section.dataset.restoreLinkBound = '1';
                const button = section.querySelector('[data-restore-link]');
                const list = section.querySelector('[data-links-list]');
                button?.addEventListener('click', () => restoreRemovedLink(button));
                if (list) setRestoreLinkState(list);
            });
        }

        function addLink(card) {
            const linksList = card.querySelector('[data-links-list]');
            const oppIndex = card.dataset.opportunityIndex;
            const indexes = [...linksList.querySelectorAll('[data-link-card]')].map((link) => Number(link.dataset.linkIndex || 0));
            const linkIndex = indexes.length ? Math.max(...indexes) + 1 : 0;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = linkTemplate.replaceAll('__OPP__', oppIndex).replaceAll('__LINK__', linkIndex);
            const linkCard = wrapper.firstElementChild;
            linksList.appendChild(linkCard);
            bindUndoScopes(linkCard);
            updateLinkIndexes(card);
        }

        function selectedLines(textarea) {
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            const value = textarea.value;
            const lineStart = value.lastIndexOf('\n', Math.max(0, start - 1)) + 1;
            const lineEndSearch = value.indexOf('\n', end);
            const lineEnd = lineEndSearch === -1 ? value.length : lineEndSearch;

            return {
                start: lineStart,
                end: lineEnd,
                text: value.slice(lineStart, lineEnd),
            };
        }

        function applyEditorAction(button) {
            const editor = button.closest('label').querySelector('[data-smart-editor]');
            const action = button.dataset.editorAction;
            const selection = selectedLines(editor);
            const original = selection.text || '';
            let replacement = original;

            if (action === 'subtitle') {
                replacement = original
                    .split('\n')
                    .map((line) => {
                        const clean = line.replace(/^#{2,3}\s+/u, '').trim();
                        return clean ? `## ${clean}` : '## Nuevo subtítulo';
                    })
                    .join('\n');
            }

            if (action === 'bullet') {
                replacement = original
                    .split('\n')
                    .map((line) => {
                        const clean = line.replace(/^\s*[-*•]\s+/u, '').trim();
                        return clean ? `- ${clean}` : '- Nueva viñeta';
                    })
                    .join('\n');
            }

            if (action === 'paragraph') {
                replacement = original
                    .split('\n')
                    .map((line) => line.replace(/^#{2,3}\s+/u, '').replace(/^\s*[-*•]\s+/u, '').trim())
                    .filter(Boolean)
                    .join('\n\n') || 'Nuevo párrafo';
            }

            if (action === 'bold') {
                replacement = original ? `**${original}**` : '**texto en negrita**';
            }

            if (action === 'italic') {
                replacement = original ? `_${original}_` : '_texto en cursiva_';
            }

            editor.value = `${editor.value.slice(0, selection.start)}${replacement}${editor.value.slice(selection.end)}`;
            editor.focus();
            editor.setSelectionRange(selection.start, selection.start + replacement.length);
        }

        document.querySelector('[data-add-opportunity]').addEventListener('click', () => {
            const indexes = [...opportunitiesList.querySelectorAll('[data-opportunity-card]')].map((card) => Number(card.dataset.opportunityIndex || 0));
            const index = indexes.length ? Math.max(...indexes) + 1 : 0;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = opportunityTemplate.replaceAll('__OPP__', index);
            const card = wrapper.firstElementChild;
            opportunitiesList.appendChild(card);
            bindUndoScopes(card);
            bindRestoreLinkControls(card);
            addLink(card);
        });

        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-opportunity]')) {
                event.target.closest('[data-opportunity-card]').remove();
            }

            if (event.target.matches('[data-add-link]')) {
                addLink(event.target.closest('[data-opportunity-card]'));
            }

            if (event.target.matches('[data-remove-link]')) {
                const linkCard = event.target.closest('[data-link-card]');
                const opportunityCard = event.target.closest('[data-opportunity-card]');
                rememberRemovedLink(linkCard);
                linkCard.remove();
                updateLinkIndexes(opportunityCard);
            }

            if (event.target.matches('[data-editor-action]')) {
                applyEditorAction(event.target);
            }
        });

        bindUndoScopes();
        bindRestoreLinkControls();
    </script>
</body>
</html>
