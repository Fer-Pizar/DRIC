<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Información para nacionales y extranjeros</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f8fafc; }
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
        .btn-tool { background: #f8fafc; border: 1px solid #d7deea; color: var(--ink); font-size: 12px; padding: 8px 10px; }
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
        .link-card { background: var(--soft); display: grid; gap: 12px; }
        .item-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 110px; resize: vertical; }
        .list-field { min-height: 160px; }
        .preview { align-items: center; background: #111827; border: 1px solid #d6deeb; border-radius: 16px; cursor: pointer; display: flex; justify-content: center; min-height: 170px; overflow: hidden; padding: 0; position: relative; width: 100%; }
        .preview-info-card { aspect-ratio: 16 / 10; }
        .preview img { height: 100%; object-fit: cover; width: 100%; }
        .preview-empty { color: rgba(255,255,255,.72); padding: 18px; text-align: center; }
        .preview-ruler { align-items: center; background: rgba(2,6,23,.76); border: 1px solid rgba(255,255,255,.16); border-radius: 999px; color: #fff; display: inline-flex; font-size: 11px; font-weight: 900; gap: 6px; left: 10px; line-height: 1; padding: 7px 10px; position: absolute; top: 10px; }
        .preview-ruler::before { background: repeating-linear-gradient(90deg, #fff 0 1px, transparent 1px 7px); content: ""; display: block; height: 10px; opacity: .82; width: 34px; }
        .btn-image-remove { align-items: center; background: rgba(127,0,16,.92); border: 2px solid rgba(255,255,255,.88); border-radius: 999px; color: #fff; display: inline-flex; font-size: 20px; font-weight: 900; height: 32px; justify-content: center; line-height: 1; padding: 0; position: absolute; right: 10px; top: 10px; width: 32px; z-index: 3; }
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
                <h1>Información para nacionales y extranjeros</h1>
                <p class="muted">Edita contenido, imágenes, enlaces y PDFs. El diseño público se mantiene desde el sistema.</p>
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

        <form method="POST" action="{{ route('admin.pages.national-foreign-info.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado</h2>
                    <p class="muted">Primera parte de la página pública: etiqueta, título y descripción principal.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <input type="hidden" name="{{ $locale }}[photo_slot]" value="{{ old($locale.'.photo_slot', $content[$locale]['photo_slot']) }}">
                                <label>Etiqueta superior<input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">@error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título principal<input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">@error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Descripción principal<textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>@error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Información clave y recursos</h2>
                    <p class="muted">Textos compartidos que ordenan las tarjetas y sus enlaces en la página pública.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>Título de información clave<input type="text" name="{{ $locale }}[key_info]" value="{{ old($locale.'.key_info', $content[$locale]['key_info']) }}">@error($locale.'.key_info')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de recursos<input type="text" name="{{ $locale }}[resources]" value="{{ old($locale.'.resources', $content[$locale]['resources']) }}">@error($locale.'.resources')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto de abrir enlace<input type="text" name="{{ $locale }}[open]" value="{{ old($locale.'.open', $content[$locale]['open']) }}">@error($locale.'.open')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas de movilidad</h2>
                    <p class="muted">Cada tarjeta sigue el orden público: imagen, texto principal, viñetas y recursos.</p>
                </div>

                <div class="item-list" id="sections-list">
                    @foreach (old('sections', $sections) as $index => $section)
                        <article class="item-card" data-section-card data-image-card data-crop-aspect="1.6" data-crop-label="Marco ancho 16:10, similar a la tarjeta pública de información.">
                            <div class="item-header">
                                <h3>Tarjeta {{ $index + 1 }}</h3>
                                <div class="item-actions">
                                    <button class="btn btn-remove" type="button" data-remove-section>Quitar tarjeta</button>
                                </div>
                            </div>

                            <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $section['id'] ?? '' }}">
                            <input type="hidden" name="sections[{{ $index }}][key]" value="{{ $section['key'] ?? '' }}">
                            <input type="hidden" name="sections[{{ $index }}][existing_image]" value="{{ $section['image'] ?? '' }}">
                            <input type="hidden" name="sections[{{ $index }}][image_remove]" value="0" data-remove-image-input>

                            <div class="two-grid">
                                <div>
                                    <label>Imagen actual y nueva imagen</label>
                                    <div class="preview preview-info-card" data-image-preview>
                                    @if (! empty($section['image']))
                                        @php
                                            $previewUrl = \Illuminate\Support\Str::startsWith($section['image'], 'http')
                                                ? $section['image']
                                                : (\Illuminate\Support\Str::startsWith($section['image'], '/storage/') ? url($section['image']) : ($frontendUrl.$section['image']));
                                        @endphp
                                            <img src="{{ $previewUrl }}" alt="Imagen actual" data-preview-image>
                                    @else
                                        <span class="preview-empty" data-preview-empty>Sin imagen seleccionada. Puedes subir una nueva antes de guardar.</span>
                                    @endif
                                        <span class="preview-ruler">16:10 tarjeta</span>
                                        <button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button>
                                    </div>
                                    <input type="file" name="sections[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
                                    <p class="hint">Solo JPG o PNG. Tamaño máximo: 10 MB.</p>
                                    @error('sections.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <div class="field-grid">
                                            <input type="hidden" name="sections[{{ $index }}][image_alt_{{ $locale }}]" value="{{ $section['image_alt_'.$locale] ?? '' }}">
                                            <label>Etiqueta superior<input type="text" name="sections[{{ $index }}][eyebrow_{{ $locale }}]" value="{{ $section['eyebrow_'.$locale] ?? '' }}">@error('sections.'.$index.'.eyebrow_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Título<input type="text" name="sections[{{ $index }}][title_{{ $locale }}]" value="{{ $section['title_'.$locale] ?? '' }}">@error('sections.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Descripción<textarea name="sections[{{ $index }}][summary_{{ $locale }}]">{{ $section['summary_'.$locale] ?? '' }}</textarea>@error('sections.'.$index.'.summary_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Viñetas<textarea class="list-field" name="sections[{{ $index }}][points_{{ $locale }}]" data-list-field>{{ $section['points_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por viñeta. Puedes escribir con o sin •, el sistema mantiene el diseño público.</span>@error('sections.'.$index.'.points_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div>
                                <h3>Recursos, enlaces y PDFs</h3>
                                <div class="links-list" data-links-list>
                                    @foreach (($section['links'] ?? []) as $linkIndex => $link)
                                        <article class="link-card" data-link-card>
                                            <div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar recurso</button></div>
                                            <input type="hidden" name="sections[{{ $index }}][links][{{ $linkIndex }}][existing_href]" value="{{ $link['href'] ?? '' }}">
                                            <div class="two-grid">
                                                <label>Texto en español<input type="text" name="sections[{{ $index }}][links][{{ $linkIndex }}][label_es]" value="{{ $link['label_es'] ?? '' }}">@error('sections.'.$index.'.links.'.$linkIndex.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>Texto en inglés<input type="text" name="sections[{{ $index }}][links][{{ $linkIndex }}][label_en]" value="{{ $link['label_en'] ?? '' }}">@error('sections.'.$index.'.links.'.$linkIndex.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                            </div>
                                            <label>URL<input type="text" name="sections[{{ $index }}][links][{{ $linkIndex }}][href]" value="{{ $link['href'] ?? '' }}">@error('sections.'.$index.'.links.'.$linkIndex.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Subir PDF opcional<input type="file" name="sections[{{ $index }}][links][{{ $linkIndex }}][pdf]" accept=".pdf,application/pdf"><span class="hint">Si subes un PDF, reemplaza la URL de este recurso. Tamaño máximo: 20 MB.</span>@error('sections.'.$index.'.links.'.$linkIndex.'.pdf')<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </article>
                                    @endforeach
                                </div>
                                <button class="btn btn-add" type="button" data-add-link>Agregar recurso</button>
                            </div>
                        </article>
                    @endforeach
                </div>

                <button class="btn btn-add" type="button" data-add-section>Agregar tarjeta</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en PostgreSQL y se muestran al recargar la página pública.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <template id="section-template">
        <article class="item-card" data-section-card data-image-card data-crop-aspect="1.6" data-crop-label="Marco ancho 16:10, similar a la tarjeta pública de información.">
            <div class="item-header"><h3>Nueva tarjeta</h3><div class="item-actions"><button class="btn btn-remove" type="button" data-remove-section>Quitar tarjeta</button></div></div>
            <input type="hidden" name="sections[__INDEX__][id]" value="">
            <input type="hidden" name="sections[__INDEX__][key]" value="">
            <input type="hidden" name="sections[__INDEX__][existing_image]" value="">
            <input type="hidden" name="sections[__INDEX__][image_remove]" value="0" data-remove-image-input>
            <label>Imagen</label>
            <div class="preview preview-info-card" data-image-preview><span class="preview-empty" data-preview-empty>Sin imagen seleccionada. Puedes subir una nueva antes de guardar.</span><span class="preview-ruler">16:10 tarjeta</span><button class="btn-image-remove" type="button" data-remove-image aria-label="Quitar imagen actual">×</button></div>
            <input type="file" name="sections[__INDEX__][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png" data-image-file>
            <span class="hint">Solo JPG o PNG. Tamaño máximo: 10 MB.</span>
            <div class="language-grid">
                <div class="language-card"><h3>Español</h3><div class="field-grid">
                    <input type="hidden" name="sections[__INDEX__][image_alt_es]" value="">
                    <label>Etiqueta superior<input type="text" name="sections[__INDEX__][eyebrow_es]" value=""></label>
                    <label>Título<input type="text" name="sections[__INDEX__][title_es]" value=""></label>
                    <label>Descripción<textarea name="sections[__INDEX__][summary_es]"></textarea></label>
                    <label>Viñetas<textarea class="list-field" name="sections[__INDEX__][points_es]" data-list-field></textarea><span class="hint">Una línea por viñeta.</span></label>
                </div></div>
                <div class="language-card"><h3>Inglés</h3><div class="field-grid">
                    <input type="hidden" name="sections[__INDEX__][image_alt_en]" value="">
                    <label>Etiqueta superior<input type="text" name="sections[__INDEX__][eyebrow_en]" value=""></label>
                    <label>Título<input type="text" name="sections[__INDEX__][title_en]" value=""></label>
                    <label>Descripción<textarea name="sections[__INDEX__][summary_en]"></textarea></label>
                    <label>Viñetas<textarea class="list-field" name="sections[__INDEX__][points_en]" data-list-field></textarea><span class="hint">Una línea por viñeta.</span></label>
                </div></div>
            </div>
            <div><h3>Recursos, enlaces y PDFs</h3><div class="links-list" data-links-list></div><button class="btn btn-add" type="button" data-add-link>Agregar recurso</button></div>
        </article>
    </template>

    <template id="link-template">
        <article class="link-card" data-link-card>
            <div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar recurso</button></div>
            <input type="hidden" name="sections[__SECTION__][links][__LINK__][existing_href]" value="">
            <div class="two-grid">
                <label>Texto en español<input type="text" name="sections[__SECTION__][links][__LINK__][label_es]" value=""></label>
                <label>Texto en inglés<input type="text" name="sections[__SECTION__][links][__LINK__][label_en]" value=""></label>
            </div>
            <label>URL<input type="text" name="sections[__SECTION__][links][__LINK__][href]" value=""></label>
            <label>Subir PDF opcional<input type="file" name="sections[__SECTION__][links][__LINK__][pdf]" accept=".pdf,application/pdf"><span class="hint">Si subes un PDF, reemplaza la URL de este recurso. Tamaño máximo: 20 MB.</span></label>
        </article>
    </template>

    <div class="crop-modal" id="crop-modal" aria-hidden="true">
        <div class="crop-dialog" role="dialog" aria-modal="true" aria-labelledby="crop-title">
            <div class="crop-top">
                <div>
                    <h2 id="crop-title">Recortar imagen</h2>
                    <p class="muted" id="crop-help">Ajusta la imagen dentro del marco y acepta el recorte.</p>
                </div>
                <button class="btn btn-remove" type="button" id="crop-close">Cancelar</button>
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
        const sectionsList = document.getElementById('sections-list');
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll('input:not([type="file"]), textarea'));
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

        function ensureLiveError(field) {
            let message = field.parentElement.querySelector('.live-error');

            if (!message) {
                message = document.createElement('span');
                message.className = 'field-error live-error';
                field.insertAdjacentElement('afterend', message);
            }

            return message;
        }

        function validateImageInput(input) {
            const file = input.files?.[0];
            const error = ensureLiveError(input);
            error.textContent = '';

            if (!file) return false;

            if (!['image/jpeg', 'image/png'].includes(file.type)) {
                error.textContent = 'Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.';
                input.value = '';
                return false;
            }

            if (file.size > 10 * 1024 * 1024) {
                error.textContent = 'La imagen es demasiado pesada. El tamaño máximo permitido es 10 MB.';
                input.value = '';
                return false;
            }

            return true;
        }

        function previewEmpty(preview) {
            let empty = preview.querySelector('[data-preview-empty]');

            if (!empty) {
                empty = document.createElement('span');
                empty.className = 'preview-empty';
                empty.dataset.previewEmpty = '';
                empty.textContent = 'Sin imagen seleccionada. Puedes subir una nueva antes de guardar.';
                preview.appendChild(empty);
            }

            empty.hidden = false;
        }

        function previewImageElement(preview) {
            let image = preview.querySelector('[data-preview-image]');

            if (!image) {
                image = document.createElement('img');
                image.alt = 'Vista previa de la imagen seleccionada';
                image.dataset.previewImage = '';
                preview.prepend(image);
            }

            image.hidden = false;
            return image;
        }

        function clearImagePreview(card) {
            const preview = card.querySelector('[data-image-preview]');
            const image = preview.querySelector('[data-preview-image]');
            const fileInput = card.querySelector('[data-image-file]');
            const removeInput = card.querySelector('[data-remove-image-input]');
            const existingInput = card.querySelector("input[name$='[existing_image]']");

            pushSnapshot(card);

            if (fileInput) {
                fileInput.value = '';
                ensureLiveError(fileInput).textContent = '';
            }

            if (image) {
                if (image.dataset.objectUrl) {
                    URL.revokeObjectURL(image.dataset.objectUrl);
                    delete image.dataset.objectUrl;
                }
                image.removeAttribute('src');
                image.hidden = true;
            }

            previewEmpty(preview);
            if (removeInput) removeInput.value = '1';
            if (existingInput) existingInput.value = '';
        }

        function showSelectedImage(card, file) {
            const preview = card.querySelector('[data-image-preview]');
            const image = previewImageElement(preview);
            const empty = preview.querySelector('[data-preview-empty]');
            const removeInput = card.querySelector('[data-remove-image-input]');

            if (image.dataset.objectUrl) URL.revokeObjectURL(image.dataset.objectUrl);
            image.dataset.objectUrl = URL.createObjectURL(file);
            image.src = image.dataset.objectUrl;
            if (empty) empty.hidden = true;
            if (removeInput) removeInput.value = '0';
        }

        function bindImageCard(card) {
            if (card.dataset.imageBound === '1') return;
            card.dataset.imageBound = '1';

            const fileInput = card.querySelector('[data-image-file]');
            const removeButton = card.querySelector('[data-remove-image]');
            const preview = card.querySelector('[data-image-preview]');

            preview?.addEventListener('click', (event) => {
                if (event.target.closest('[data-remove-image]')) return;
                fileInput?.click();
            });

            removeButton?.addEventListener('click', (event) => {
                event.stopPropagation();
                clearImagePreview(card);
            });

            fileInput?.addEventListener('change', () => {
                if (!validateImageInput(fileInput)) return;
                openCropTool(card, fileInput.files[0]);
            });
        }

        function bindImageCards(root = document) {
            if (root.matches?.('[data-image-card]')) bindImageCard(root);
            root.querySelectorAll('[data-image-card]').forEach(bindImageCard);
        }

        const cropModal = document.getElementById('crop-modal');
        const cropFrame = document.getElementById('crop-frame');
        const cropImage = document.getElementById('crop-image');
        const cropZoom = document.getElementById('crop-zoom');
        const cropHelp = document.getElementById('crop-help');
        const cropAccept = document.getElementById('crop-accept');
        const cropReset = document.getElementById('crop-reset');
        const cropClose = document.getElementById('crop-close');
        const cropState = { card: null, file: null, objectUrl: '', naturalWidth: 0, naturalHeight: 0, baseScale: 1, zoom: 1, offsetX: 0, offsetY: 0, dragging: false, pointerX: 0, pointerY: 0 };

        function cropAspectFor(card) {
            return Number(card.dataset.cropAspect || '1.6');
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
            cropState.baseScale = Math.max(cropFrame.clientWidth / cropState.naturalWidth, cropFrame.clientHeight / cropState.naturalHeight);
            cropState.zoom = 1;
            cropState.offsetX = 0;
            cropState.offsetY = 0;
            cropZoom.value = '1';
            renderCrop();
        }

        function openCropTool(card, file) {
            const aspect = cropAspectFor(card);
            if (cropState.objectUrl) URL.revokeObjectURL(cropState.objectUrl);
            cropState.card = card;
            cropState.file = file;
            cropState.objectUrl = URL.createObjectURL(file);
            cropHelp.textContent = card.dataset.cropLabel || 'Ajusta la imagen dentro del marco y acepta el recorte.';
            cropModal.classList.add('is-open');
            cropModal.setAttribute('aria-hidden', 'false');
            const size = frameSizeForAspect(aspect);
            cropFrame.style.width = `${size.width}px`;
            cropFrame.style.height = `${size.height}px`;
            cropImage.src = cropState.objectUrl;
        }

        function closeCropTool(clearSelection = false) {
            const card = cropState.card;
            cropModal.classList.remove('is-open');
            cropModal.setAttribute('aria-hidden', 'true');
            if (clearSelection && card) {
                const fileInput = card.querySelector('[data-image-file]');
                if (fileInput) fileInput.value = '';
            }
            if (cropState.objectUrl) URL.revokeObjectURL(cropState.objectUrl);
            cropState.card = null;
            cropState.file = null;
            cropState.objectUrl = '';
            cropImage.removeAttribute('src');
        }

        function croppedFileName(file) {
            const base = file.name.replace(/\.[^.]+$/, '') || 'info-image';
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
            const outputWidth = 1400;
            const outputHeight = Math.round(outputWidth / aspect);
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');

            canvas.width = outputWidth;
            canvas.height = outputHeight;
            context.drawImage(cropImage, sourceX, sourceY, sourceWidth, sourceHeight, 0, 0, outputWidth, outputHeight);
            canvas.toBlob((blob) => {
                if (!blob) return;
                const cropped = new File([blob], croppedFileName(file), { type: 'image/jpeg' });
                const transfer = new DataTransfer();
                const fileInput = card.querySelector('[data-image-file]');
                transfer.items.add(cropped);
                pushSnapshot(card);
                fileInput.files = transfer.files;
                showSelectedImage(card, cropped);
                ensureLiveError(fileInput).textContent = '';
                closeCropTool(false);
            }, 'image/jpeg', .92);
        }

        cropImage.addEventListener('load', () => {
            cropState.naturalWidth = cropImage.naturalWidth;
            cropState.naturalHeight = cropImage.naturalHeight;
            resetCropPosition();
        });

        cropZoom.addEventListener('input', () => {
            cropState.zoom = Number(cropZoom.value);
            renderCrop();
        });

        cropFrame.addEventListener('pointerdown', (event) => {
            cropState.dragging = true;
            cropState.pointerX = event.clientX;
            cropState.pointerY = event.clientY;
            cropFrame.classList.add('is-dragging');
            cropFrame.setPointerCapture(event.pointerId);
        });
        cropFrame.addEventListener('pointermove', (event) => {
            if (!cropState.dragging) return;
            cropState.offsetX += event.clientX - cropState.pointerX;
            cropState.offsetY += event.clientY - cropState.pointerY;
            cropState.pointerX = event.clientX;
            cropState.pointerY = event.clientY;
            renderCrop();
        });
        cropFrame.addEventListener('pointerup', (event) => {
            cropState.dragging = false;
            cropFrame.classList.remove('is-dragging');
            cropFrame.releasePointerCapture(event.pointerId);
        });
        cropFrame.addEventListener('pointercancel', () => {
            cropState.dragging = false;
            cropFrame.classList.remove('is-dragging');
        });
        cropReset.addEventListener('click', resetCropPosition);
        cropAccept.addEventListener('click', acceptCrop);
        cropClose.addEventListener('click', () => closeCropTool(true));
        cropModal.addEventListener('click', (event) => {
            if (event.target === cropModal) closeCropTool(true);
        });

        function reindexSection(card, index) {
            card.querySelectorAll('[name]').forEach((field) => {
                field.name = field.name.replace(/sections\[\d+\]/, `sections[${index}]`);
            });
        }

        function reindexLinks(card) {
            const sectionIndex = Array.from(sectionsList.querySelectorAll('[data-section-card]')).indexOf(card);
            card.querySelectorAll('[data-link-card]').forEach((linkCard, linkIndex) => {
                linkCard.querySelectorAll('[name]').forEach((field) => {
                    field.name = field.name.replace(/sections\[\d+\]\[links\]\[\d+\]/, `sections[${sectionIndex}][links][${linkIndex}]`);
                });
            });
        }

        function reindexAll() {
            sectionsList.querySelectorAll('[data-section-card]').forEach((card, index) => {
                reindexSection(card, index);
                reindexLinks(card);
                card.querySelector('h3').textContent = `Tarjeta ${index + 1}`;
            });
        }

        function addSection() {
            const index = sectionsList.querySelectorAll('[data-section-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('section-template').innerHTML.replaceAll('__INDEX__', index);
            const card = wrapper.firstElementChild;
            sectionsList.appendChild(card);
            bindUndoScopes(card);
            bindImageCards(card);
        }

        function addLink(card) {
            reindexLinks(card);
            const sectionIndex = Array.from(sectionsList.querySelectorAll('[data-section-card]')).indexOf(card);
            const list = card.querySelector('[data-links-list]');
            const linkIndex = list.querySelectorAll('[data-link-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('link-template').innerHTML.replaceAll('__SECTION__', sectionIndex).replaceAll('__LINK__', linkIndex);
            const linkCard = wrapper.firstElementChild;
            list.appendChild(linkCard);
            bindUndoScopes(linkCard);
        }

        bindUndoScopes();
        bindImageCards();
        document.querySelector('[data-add-section]').addEventListener('click', addSection);
        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-section]')) {
                event.target.closest('[data-section-card]').remove();
                reindexAll();
            }
            if (event.target.matches('[data-add-link]')) addLink(event.target.closest('[data-section-card]'));
            if (event.target.matches('[data-remove-link]')) {
                const card = event.target.closest('[data-section-card]');
                event.target.closest('[data-link-card]').remove();
                reindexLinks(card);
            }
        });
    </script>
</body>
</html>
