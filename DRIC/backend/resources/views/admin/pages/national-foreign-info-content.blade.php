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
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .item-list, .links-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .item-card, .link-card { box-shadow: none; padding: 18px; }
        .item-card { display: grid; gap: 16px; }
        .link-card { background: var(--soft); display: grid; gap: 12px; }
        .item-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 110px; resize: vertical; }
        .list-field { min-height: 160px; }
        .preview { align-items: center; background: #eef3f9; border-radius: 14px; display: flex; justify-content: center; min-height: 170px; overflow: hidden; padding: 12px; }
        .preview img { max-height: 150px; max-width: 100%; object-fit: contain; }
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
                    <p class="muted">Estos textos aparecen en la parte superior de la página pública.</p>
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
                                <label>Título de información clave<input type="text" name="{{ $locale }}[key_info]" value="{{ old($locale.'.key_info', $content[$locale]['key_info']) }}">@error($locale.'.key_info')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de recursos<input type="text" name="{{ $locale }}[resources]" value="{{ old($locale.'.resources', $content[$locale]['resources']) }}">@error($locale.'.resources')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto de abrir enlace<input type="text" name="{{ $locale }}[open]" value="{{ old($locale.'.open', $content[$locale]['open']) }}">@error($locale.'.open')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto reservado de imagen<input type="text" name="{{ $locale }}[photo_slot]" value="{{ old($locale.'.photo_slot', $content[$locale]['photo_slot']) }}">@error($locale.'.photo_slot')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas de información</h2>
                    <p class="muted">Cada tarjeta conserva el formato visual. Las viñetas se escriben con una línea por punto.</p>
                </div>

                <div class="item-list" id="sections-list">
                    @foreach (old('sections', $sections) as $index => $section)
                        <article class="item-card" data-section-card>
                            <div class="item-header">
                                <h3>Tarjeta {{ $index + 1 }}</h3>
                                <div class="item-actions">
                                    <button class="btn btn-remove" type="button" data-remove-section>Quitar tarjeta</button>
                                </div>
                            </div>

                            <input type="hidden" name="sections[{{ $index }}][id]" value="{{ $section['id'] ?? '' }}">
                            <input type="hidden" name="sections[{{ $index }}][key]" value="{{ $section['key'] ?? '' }}">
                            <input type="hidden" name="sections[{{ $index }}][existing_image]" value="{{ $section['image'] ?? '' }}">

                            <div class="two-grid">
                                <div>
                                    <label>Imagen</label>
                                    @if (! empty($section['image']))
                                        @php
                                            $previewUrl = \Illuminate\Support\Str::startsWith($section['image'], 'http')
                                                ? $section['image']
                                                : (\Illuminate\Support\Str::startsWith($section['image'], '/storage/') ? url($section['image']) : ($frontendUrl.$section['image']));
                                        @endphp
                                        <div class="preview">
                                            <img src="{{ $previewUrl }}" alt="Imagen actual">
                                        </div>
                                    @endif
                                    <input type="file" name="sections[{{ $index }}][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                    <p class="hint">Solo JPG o PNG. Tamaño máximo: 7 MB.</p>
                                    @error('sections.'.$index.'.image')<span class="field-error">{{ $message }}</span>@enderror
                                </div>
                            </div>

                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <div class="field-grid">
                                            <label>Etiqueta superior<input type="text" name="sections[{{ $index }}][eyebrow_{{ $locale }}]" value="{{ $section['eyebrow_'.$locale] ?? '' }}">@error('sections.'.$index.'.eyebrow_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Título<input type="text" name="sections[{{ $index }}][title_{{ $locale }}]" value="{{ $section['title_'.$locale] ?? '' }}">@error('sections.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Descripción<textarea name="sections[{{ $index }}][summary_{{ $locale }}]">{{ $section['summary_'.$locale] ?? '' }}</textarea>@error('sections.'.$index.'.summary_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Texto alternativo de imagen<input type="text" name="sections[{{ $index }}][image_alt_{{ $locale }}]" value="{{ $section['image_alt_'.$locale] ?? '' }}">@error('sections.'.$index.'.image_alt_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
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
        <article class="item-card" data-section-card>
            <div class="item-header"><h3>Nueva tarjeta</h3><div class="item-actions"><button class="btn btn-remove" type="button" data-remove-section>Quitar tarjeta</button></div></div>
            <input type="hidden" name="sections[__INDEX__][id]" value="">
            <input type="hidden" name="sections[__INDEX__][key]" value="">
            <input type="hidden" name="sections[__INDEX__][existing_image]" value="">
            <label>Imagen<input type="file" name="sections[__INDEX__][image]" accept=".jpg,.jpeg,.png,image/jpeg,image/png"><span class="hint">Solo JPG o PNG. Tamaño máximo: 7 MB.</span></label>
            <div class="language-grid">
                <div class="language-card"><h3>Español</h3><div class="field-grid">
                    <label>Etiqueta superior<input type="text" name="sections[__INDEX__][eyebrow_es]" value=""></label>
                    <label>Título<input type="text" name="sections[__INDEX__][title_es]" value=""></label>
                    <label>Descripción<textarea name="sections[__INDEX__][summary_es]"></textarea></label>
                    <label>Texto alternativo de imagen<input type="text" name="sections[__INDEX__][image_alt_es]" value=""></label>
                    <label>Viñetas<textarea class="list-field" name="sections[__INDEX__][points_es]" data-list-field></textarea><span class="hint">Una línea por viñeta.</span></label>
                </div></div>
                <div class="language-card"><h3>Inglés</h3><div class="field-grid">
                    <label>Etiqueta superior<input type="text" name="sections[__INDEX__][eyebrow_en]" value=""></label>
                    <label>Título<input type="text" name="sections[__INDEX__][title_en]" value=""></label>
                    <label>Descripción<textarea name="sections[__INDEX__][summary_en]"></textarea></label>
                    <label>Texto alternativo de imagen<input type="text" name="sections[__INDEX__][image_alt_en]" value=""></label>
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

    <script>
        const sectionsList = document.getElementById('sections-list');

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
            sectionsList.appendChild(wrapper.firstElementChild);
        }

        function addLink(card) {
            reindexLinks(card);
            const sectionIndex = Array.from(sectionsList.querySelectorAll('[data-section-card]')).indexOf(card);
            const list = card.querySelector('[data-links-list]');
            const linkIndex = list.querySelectorAll('[data-link-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('link-template').innerHTML.replaceAll('__SECTION__', sectionIndex).replaceAll('__LINK__', linkIndex);
            list.appendChild(wrapper.firstElementChild);
        }

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
