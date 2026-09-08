<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Contenido de Contacto</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .social-card, .notice { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .row-actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .social-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .social-card, .notice { box-shadow: none; padding: 18px; }
        .social-card { display: grid; gap: 16px; }
        .social-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .notice { background: #f8fafc; }
        .notice strong { color: var(--blue); }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .sticky-actions, .social-header { align-items: stretch; flex-direction: column; } .language-grid, .two-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contacto</h1>
                <p class="muted">Edita el contenido público de contacto. El mapa no se modifica desde el panel.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.contact.update', $page) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Texto editable</h2>
                    <p class="muted">Estos textos se publican en la página Contacto. No cambian el diseño.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
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
                                    <textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>
                                    @error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <div class="two-grid">
                                    <label>
                                        Título de teléfono
                                        <input type="text" name="{{ $locale }}[phone_title]" value="{{ old($locale.'.phone_title', $content[$locale]['phone_title']) }}">
                                        @error($locale.'.phone_title')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>

                                    <label>
                                        Teléfono visible
                                        <input type="text" name="{{ $locale }}[phone_value]" value="{{ old($locale.'.phone_value', $content[$locale]['phone_value']) }}">
                                        @error($locale.'.phone_value')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                </div>

                                <div class="two-grid">
                                    <label>
                                        Título de correo
                                        <input type="text" name="{{ $locale }}[email_title]" value="{{ old($locale.'.email_title', $content[$locale]['email_title']) }}">
                                        @error($locale.'.email_title')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>

                                    <label>
                                        Correo visible
                                        <input type="email" name="{{ $locale }}[email_value]" value="{{ old($locale.'.email_value', $content[$locale]['email_value']) }}">
                                        @error($locale.'.email_value')<span class="field-error">{{ $message }}</span>@enderror
                                    </label>
                                </div>

                                <label>
                                    Título de dirección
                                    <input type="text" name="{{ $locale }}[address_title]" value="{{ old($locale.'.address_title', $content[$locale]['address_title']) }}">
                                    @error($locale.'.address_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Nombre del lugar
                                    <input type="text" name="{{ $locale }}[address_name]" value="{{ old($locale.'.address_name', $content[$locale]['address_name']) }}">
                                    @error($locale.'.address_name')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Dirección visible
                                    <textarea name="{{ $locale }}[address_text]">{{ old($locale.'.address_text', $content[$locale]['address_text']) }}</textarea>
                                    @error($locale.'.address_text')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Título de redes sociales
                                    <input type="text" name="{{ $locale }}[social_title]" value="{{ old($locale.'.social_title', $content[$locale]['social_title']) }}">
                                    @error($locale.'.social_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Texto de redes sociales
                                    <textarea name="{{ $locale }}[social_summary]">{{ old($locale.'.social_summary', $content[$locale]['social_summary']) }}</textarea>
                                    @error($locale.'.social_summary')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Redes sociales</h2>
                    <p class="muted">Agrega, edita o quita redes sociales. Cada URL debe ser completa.</p>
                </div>

                <div class="social-list" id="social-list">
                    @forelse (old('social_links', $socialLinks) as $index => $socialLink)
                        <article class="social-card" data-social-card>
                            <div class="social-header">
                                <h3>Red social {{ $index + 1 }}</h3>
                                <button class="btn btn-remove" type="button" data-remove-social>Quitar</button>
                            </div>

                            <input type="hidden" name="social_links[{{ $index }}][id]" value="{{ $socialLink['id'] ?? '' }}">

                            <div class="two-grid">
                                <label>
                                    Nombre en español
                                    <input type="text" name="social_links[{{ $index }}][label_es]" value="{{ $socialLink['label_es'] ?? '' }}">
                                    @error('social_links.'.$index.'.label_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Nombre en inglés
                                    <input type="text" name="social_links[{{ $index }}][label_en]" value="{{ $socialLink['label_en'] ?? '' }}">
                                    <span class="hint">Si se deja vacío, se usará el nombre en español.</span>
                                    @error('social_links.'.$index.'.label_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <label>
                                URL de redirección
                                <input type="url" name="social_links[{{ $index }}][url]" value="{{ $socialLink['url'] ?? '' }}" placeholder="https://www.facebook.com/UMSS.DRIC">
                                @error('social_links.'.$index.'.url')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </article>
                    @empty
                    @endforelse
                </div>

                <button class="btn btn-add" type="button" id="add-social">Agregar red social</button>
            </section>

            <div class="notice">
                <strong>Mapa protegido.</strong>
                <p class="muted">El mapa no es editable. La vista pública usa Google Maps con la búsqueda institucional de DRIC UMSS en Cochabamba para que funcione cuando la ubicación esté registrada.</p>
            </div>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Contacto.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>

        <template id="social-template">
            <article class="social-card" data-social-card>
                <div class="social-header">
                    <h3>Nueva red social</h3>
                    <button class="btn btn-remove" type="button" data-remove-social>Quitar</button>
                </div>
                <input type="hidden" name="__NAME__[id]" value="">
                <div class="two-grid">
                    <label>
                        Nombre en español
                        <input type="text" name="__NAME__[label_es]">
                    </label>
                    <label>
                        Nombre en inglés
                        <input type="text" name="__NAME__[label_en]">
                        <span class="hint">Si se deja vacío, se usará el nombre en español.</span>
                    </label>
                </div>
                <label>
                    URL de redirección
                    <input type="url" name="__NAME__[url]" placeholder="https://www.facebook.com/UMSS.DRIC">
                </label>
            </article>
        </template>
    </main>

    <script>
        const list = document.getElementById("social-list");
        const template = document.getElementById("social-template");
        const addButton = document.getElementById("add-social");
        let nextIndex = {{ count(old('social_links', $socialLinks)) }};

        function bindSocialCard(card) {
            card.querySelector("[data-remove-social]").addEventListener("click", () => card.remove());
        }

        document.querySelectorAll("[data-social-card]").forEach(bindSocialCard);

        addButton.addEventListener("click", () => {
            const html = template.innerHTML.replaceAll("__NAME__", `social_links[${nextIndex}]`);
            const wrapper = document.createElement("div");
            wrapper.innerHTML = html.trim();
            const card = wrapper.firstElementChild;
            list.appendChild(card);
            bindSocialCard(card);
            nextIndex += 1;
        });
    </script>
</body>
</html>
