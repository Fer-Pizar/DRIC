<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Premios y convocatorias</title>
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
        .list-field { min-height: 150px; }
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
                <h1>Premios, eventos, cursos y concursos</h1>
                <p class="muted">Edita únicamente el contenido público. El diseño, colores, íconos y distribución se mantienen desde el sistema.</p>
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

        <form method="POST" action="{{ route('admin.pages.awards-opportunities.update', $page) }}">
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
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Oportunidades</h2>
                    <p class="muted">Cada oportunidad se muestra como tarjeta. Las listas se escriben con una línea por elemento; el sistema conserva las viñetas del diseño público.</p>
                </div>
                <div class="item-list" id="opportunities-list">
                    @foreach (old('opportunities', $opportunities) as $index => $item)
                        <article class="item-card" data-opportunity-card>
                            <div class="item-header">
                                <h3>Oportunidad {{ $index + 1 }}</h3>
                                <div class="item-actions">
                                    <button class="btn btn-remove" type="button" data-remove-item>Quitar</button>
                                </div>
                            </div>
                            <input type="hidden" name="opportunities[{{ $index }}][id]" value="{{ $item['id'] ?? '' }}">

                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <div class="field-grid">
                                            <label>Título<input type="text" name="opportunities[{{ $index }}][title_{{ $locale }}]" value="{{ $item['title_'.$locale] ?? '' }}">@error('opportunities.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Categoría<input type="text" name="opportunities[{{ $index }}][category_{{ $locale }}]" value="{{ $item['category_'.$locale] ?? '' }}">@error('opportunities.'.$index.'.category_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Dirigido a<textarea name="opportunities[{{ $index }}][audience_{{ $locale }}]">{{ $item['audience_'.$locale] ?? '' }}</textarea>@error('opportunities.'.$index.'.audience_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Resumen<textarea name="opportunities[{{ $index }}][summary_{{ $locale }}]">{{ $item['summary_'.$locale] ?? '' }}</textarea>@error('opportunities.'.$index.'.summary_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Fechas<input type="text" name="opportunities[{{ $index }}][dates_{{ $locale }}]" value="{{ $item['dates_'.$locale] ?? '' }}">@error('opportunities.'.$index.'.dates_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Plazo<input type="text" name="opportunities[{{ $index }}][deadline_{{ $locale }}]" value="{{ $item['deadline_'.$locale] ?? '' }}">@error('opportunities.'.$index.'.deadline_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Lugar<input type="text" name="opportunities[{{ $index }}][location_{{ $locale }}]" value="{{ $item['location_'.$locale] ?? '' }}">@error('opportunities.'.$index.'.location_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Modalidad<input type="text" name="opportunities[{{ $index }}][format_{{ $locale }}]" value="{{ $item['format_'.$locale] ?? '' }}">@error('opportunities.'.$index.'.format_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Información clave<textarea class="list-field" name="opportunities[{{ $index }}][details_{{ $locale }}]">{{ $item['details_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por viñeta.</span>@error('opportunities.'.$index.'.details_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Beneficios<textarea class="list-field" name="opportunities[{{ $index }}][benefits_{{ $locale }}]">{{ $item['benefits_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por viñeta.</span>@error('opportunities.'.$index.'.benefits_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Requisitos<textarea class="list-field" name="opportunities[{{ $index }}][requirements_{{ $locale }}]">{{ $item['requirements_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por viñeta.</span>@error('opportunities.'.$index.'.requirements_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                            <label>Documentos<textarea class="list-field" name="opportunities[{{ $index }}][documents_{{ $locale }}]">{{ $item['documents_'.$locale] ?? '' }}</textarea><span class="hint">Una línea por documento.</span>@error('opportunities.'.$index.'.documents_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <label>Contacto<input type="text" name="opportunities[{{ $index }}][contact]" value="{{ $item['contact'] ?? '' }}">@error('opportunities.'.$index.'.contact')<span class="field-error">{{ $message }}</span>@enderror</label>

                            <div>
                                <h3>Enlaces</h3>
                                <div class="links-list" data-links-list>
                                    @foreach (($item['links'] ?? []) as $linkIndex => $link)
                                        <article class="link-card" data-link-card>
                                            <div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar enlace</button></div>
                                            <div class="two-grid">
                                                <label>Texto en español<input type="text" name="opportunities[{{ $index }}][links][{{ $linkIndex }}][label_es]" value="{{ $link['label_es'] ?? '' }}">@error('opportunities.'.$index.'.links.'.$linkIndex.'.label_es')<span class="field-error">{{ $message }}</span>@enderror</label>
                                                <label>Texto en inglés<input type="text" name="opportunities[{{ $index }}][links][{{ $linkIndex }}][label_en]" value="{{ $link['label_en'] ?? '' }}">@error('opportunities.'.$index.'.links.'.$linkIndex.'.label_en')<span class="field-error">{{ $message }}</span>@enderror</label>
                                            </div>
                                            <label>URL<input type="text" name="opportunities[{{ $index }}][links][{{ $linkIndex }}][href]" value="{{ $link['href'] ?? '' }}">@error('opportunities.'.$index.'.links.'.$linkIndex.'.href')<span class="field-error">{{ $message }}</span>@enderror</label>
                                        </article>
                                    @endforeach
                                </div>
                                <button class="btn btn-add" type="button" data-add-link>Agregar enlace</button>
                            </div>
                        </article>
                    @endforeach
                </div>
                <button class="btn btn-add" type="button" data-add-opportunity>Agregar oportunidad</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en PostgreSQL y se muestran al recargar la página pública.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>

    <template id="opportunity-template">
        <article class="item-card" data-opportunity-card>
            <div class="item-header"><h3>Nueva oportunidad</h3><div class="item-actions"><button class="btn btn-remove" type="button" data-remove-item>Quitar</button></div></div>
            <input type="hidden" name="opportunities[__INDEX__][id]" value="">
            <div class="language-grid">
                <div class="language-card"><h3>Español</h3><div class="field-grid">
                    <label>Título<input type="text" name="opportunities[__INDEX__][title_es]" value=""></label>
                    <label>Categoría<input type="text" name="opportunities[__INDEX__][category_es]" value=""></label>
                    <label>Dirigido a<textarea name="opportunities[__INDEX__][audience_es]"></textarea></label>
                    <label>Resumen<textarea name="opportunities[__INDEX__][summary_es]"></textarea></label>
                    <label>Fechas<input type="text" name="opportunities[__INDEX__][dates_es]" value=""></label>
                    <label>Plazo<input type="text" name="opportunities[__INDEX__][deadline_es]" value=""></label>
                    <label>Lugar<input type="text" name="opportunities[__INDEX__][location_es]" value=""></label>
                    <label>Modalidad<input type="text" name="opportunities[__INDEX__][format_es]" value=""></label>
                    <label>Información clave<textarea class="list-field" name="opportunities[__INDEX__][details_es]"></textarea><span class="hint">Una línea por viñeta.</span></label>
                    <label>Beneficios<textarea class="list-field" name="opportunities[__INDEX__][benefits_es]"></textarea><span class="hint">Una línea por viñeta.</span></label>
                    <label>Requisitos<textarea class="list-field" name="opportunities[__INDEX__][requirements_es]"></textarea><span class="hint">Una línea por viñeta.</span></label>
                    <label>Documentos<textarea class="list-field" name="opportunities[__INDEX__][documents_es]"></textarea><span class="hint">Una línea por documento.</span></label>
                </div></div>
                <div class="language-card"><h3>Inglés</h3><div class="field-grid">
                    <label>Título<input type="text" name="opportunities[__INDEX__][title_en]" value=""></label>
                    <label>Categoría<input type="text" name="opportunities[__INDEX__][category_en]" value=""></label>
                    <label>Dirigido a<textarea name="opportunities[__INDEX__][audience_en]"></textarea></label>
                    <label>Resumen<textarea name="opportunities[__INDEX__][summary_en]"></textarea></label>
                    <label>Fechas<input type="text" name="opportunities[__INDEX__][dates_en]" value=""></label>
                    <label>Plazo<input type="text" name="opportunities[__INDEX__][deadline_en]" value=""></label>
                    <label>Lugar<input type="text" name="opportunities[__INDEX__][location_en]" value=""></label>
                    <label>Modalidad<input type="text" name="opportunities[__INDEX__][format_en]" value=""></label>
                    <label>Información clave<textarea class="list-field" name="opportunities[__INDEX__][details_en]"></textarea><span class="hint">Una línea por viñeta.</span></label>
                    <label>Beneficios<textarea class="list-field" name="opportunities[__INDEX__][benefits_en]"></textarea><span class="hint">Una línea por viñeta.</span></label>
                    <label>Requisitos<textarea class="list-field" name="opportunities[__INDEX__][requirements_en]"></textarea><span class="hint">Una línea por viñeta.</span></label>
                    <label>Documentos<textarea class="list-field" name="opportunities[__INDEX__][documents_en]"></textarea><span class="hint">Una línea por documento.</span></label>
                </div></div>
            </div>
            <label>Contacto<input type="text" name="opportunities[__INDEX__][contact]" value=""></label>
            <div><h3>Enlaces</h3><div class="links-list" data-links-list></div><button class="btn btn-add" type="button" data-add-link>Agregar enlace</button></div>
        </article>
    </template>

    <template id="link-template">
        <article class="link-card" data-link-card>
            <div class="link-actions"><button class="btn btn-remove" type="button" data-remove-link>Quitar enlace</button></div>
            <div class="two-grid">
                <label>Texto en español<input type="text" name="opportunities[__OPPORTUNITY__][links][__LINK__][label_es]" value=""></label>
                <label>Texto en inglés<input type="text" name="opportunities[__OPPORTUNITY__][links][__LINK__][label_en]" value=""></label>
            </div>
            <label>URL<input type="text" name="opportunities[__OPPORTUNITY__][links][__LINK__][href]" value=""></label>
        </article>
    </template>

    <script>
        const opportunitiesList = document.getElementById('opportunities-list');

        function reindexOpportunity(card, index) {
            card.querySelectorAll('[name]').forEach((field) => {
                field.name = field.name.replace(/opportunities\[\d+\]/, `opportunities[${index}]`);
            });
        }

        function reindexAll() {
            opportunitiesList.querySelectorAll('[data-opportunity-card]').forEach((card, index) => {
                reindexOpportunity(card, index);
                card.querySelector('h3').textContent = `Oportunidad ${index + 1}`;
            });
        }

        function addOpportunity() {
            const index = opportunitiesList.querySelectorAll('[data-opportunity-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('opportunity-template').innerHTML.replaceAll('__INDEX__', index);
            opportunitiesList.appendChild(wrapper.firstElementChild);
        }

        function addLink(card) {
            reindexLinks(card);
            const opportunityIndex = Array.from(opportunitiesList.querySelectorAll('[data-opportunity-card]')).indexOf(card);
            const list = card.querySelector('[data-links-list]');
            const linkIndex = list.querySelectorAll('[data-link-card]').length;
            const wrapper = document.createElement('div');
            wrapper.innerHTML = document.getElementById('link-template').innerHTML.replaceAll('__OPPORTUNITY__', opportunityIndex).replaceAll('__LINK__', linkIndex);
            list.appendChild(wrapper.firstElementChild);
        }

        function reindexLinks(card) {
            const opportunityIndex = Array.from(opportunitiesList.querySelectorAll('[data-opportunity-card]')).indexOf(card);
            card.querySelectorAll('[data-link-card]').forEach((linkCard, linkIndex) => {
                linkCard.querySelectorAll('[name]').forEach((field) => {
                    field.name = field.name.replace(/opportunities\[\d+\]\[links\]\[\d+\]/, `opportunities[${opportunityIndex}][links][${linkIndex}]`);
                });
            });
        }

        document.querySelector('[data-add-opportunity]').addEventListener('click', addOpportunity);
        document.addEventListener('click', (event) => {
            if (event.target.matches('[data-remove-item]')) {
                event.target.closest('[data-opportunity-card]').remove();
                reindexAll();
            }
            if (event.target.matches('[data-add-link]')) addLink(event.target.closest('[data-opportunity-card]'));
            if (event.target.matches('[data-remove-link]')) {
                const card = event.target.closest('[data-opportunity-card]');
                event.target.closest('[data-link-card]').remove();
                reindexLinks(card);
            }
        });
    </script>
</body>
</html>
