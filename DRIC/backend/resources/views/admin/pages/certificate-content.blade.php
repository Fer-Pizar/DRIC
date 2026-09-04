<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Verificar Certificados</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .certificate-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions, .row-actions, .code-row { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-add { background: #2563eb; color: #fff; }
        .btn-generate { background: #0f766e; color: #fff; }
        .btn-remove { background: #fff1f2; color: var(--red-dark); }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .certificates-list { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .certificate-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .certificate-card { box-shadow: none; padding: 18px; }
        .certificate-card { display: grid; gap: 16px; }
        .certificate-header { align-items: center; display: flex; gap: 12px; justify-content: space-between; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .code-row { align-items: end; display: grid; grid-template-columns: minmax(0, 1fr) auto; }
        .code-input { font-weight: 900; letter-spacing: 0.16em; text-transform: uppercase; }
        .checkline { align-items: center; display: flex; gap: 10px; font-size: 13px; font-weight: 800; }
        .checkline input { height: 17px; width: 17px; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .sticky-actions, .certificate-header { align-items: stretch; flex-direction: column; } .language-grid, .certificate-grid, .code-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Verificar Certificados</h1>
                <p class="muted">Edita y administra certificados nuevos.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.certificates.update', $page) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Texto editable de la página</h2>
                    <p class="muted">Solo estos tres textos se modifican en la vista pública. El formulario de verificación y el diseño no se editan.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Texto superior
                                    <input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">
                                    @error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                    @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Descripción
                                    <textarea name="{{ $locale }}[description]">{{ old($locale.'.description', $content[$locale]['description']) }}</textarea>
                                    @error($locale.'.description')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Certificados administrables</h2>
                    <p class="muted">Cada persona necesita un código único de siete caracteres, nombre, fecha de emisión y descripción bilingüe.</p>
                </div>

                <div class="certificates-list" id="certificates-list">
                    @forelse (old('certificates', $certificates) as $index => $certificate)
                        <article class="certificate-card" data-certificate-card>
                            <div class="certificate-header">
                                <div>
                                    <h3>Persona {{ $index + 1 }}</h3>
                                    <p class="muted">Registro administrable para verificación pública.</p>
                                </div>
                                <div class="row-actions">
                                    <label class="checkline">
                                        <input type="checkbox" name="certificates[{{ $index }}][is_active]" value="1" @checked((bool) ($certificate['is_active'] ?? true))>
                                        Activo
                                    </label>
                                    <button class="btn btn-remove" type="button" data-remove-certificate>Quitar</button>
                                </div>
                            </div>

                            <input type="hidden" name="certificates[{{ $index }}][id]" value="{{ $certificate['id'] ?? '' }}">

                            <div class="code-row">
                                <label>
                                    Código único
                                    <input class="code-input" type="text" name="certificates[{{ $index }}][code]" value="{{ $certificate['code'] ?? '' }}" maxlength="7" pattern="[A-Z0-9]{7}" data-code-input>
                                    @error('certificates.'.$index.'.code')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <button class="btn btn-generate" type="button" data-generate-code>Generar código</button>
                            </div>

                            <div class="certificate-grid">
                                <label>
                                    Nombre completo
                                    <input type="text" name="certificates[{{ $index }}][full_name]" value="{{ $certificate['full_name'] ?? '' }}">
                                    @error('certificates.'.$index.'.full_name')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Fecha de emisión
                                    <input type="date" name="certificates[{{ $index }}][issue_date]" value="{{ $certificate['issue_date'] ?? '' }}">
                                    @error('certificates.'.$index.'.issue_date')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <div class="certificate-grid">
                                <label>
                                    Tipo de certificado en español
                                    <input type="text" name="certificates[{{ $index }}][certificate_type]" value="{{ $certificate['certificate_type'] ?? '' }}" placeholder="Certificado DRIC">
                                    <span class="hint">Este texto se guarda en certificate_type.</span>
                                    @error('certificates.'.$index.'.certificate_type')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Tipo de certificado en inglés
                                    <input type="text" name="certificates[{{ $index }}][certificate_type_en]" value="{{ $certificate['certificate_type_en'] ?? '' }}" placeholder="DRIC Certificate">
                                    <span class="hint">Si se deja vacío, se usará el tipo en español.</span>
                                    @error('certificates.'.$index.'.certificate_type_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>

                            <div class="certificate-grid">
                                <label>
                                    Descripción en español
                                    <textarea name="certificates[{{ $index }}][description_es]">{{ $certificate['description_es'] ?? '' }}</textarea>
                                    @error('certificates.'.$index.'.description_es')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Descripción en inglés
                                    <textarea name="certificates[{{ $index }}][description_en]">{{ $certificate['description_en'] ?? '' }}</textarea>
                                    <span class="hint">Si se deja vacío, se usará la descripción en español.</span>
                                    @error('certificates.'.$index.'.description_en')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </article>
                    @empty
                    @endforelse
                </div>

                <button class="btn btn-add" type="button" id="add-certificate">Agregar persona</button>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se ven al verificar el código.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>

        <template id="certificate-template">
            <article class="certificate-card" data-certificate-card>
                <div class="certificate-header">
                    <div>
                        <h3>Nueva persona</h3>
                        <p class="muted">Registro administrable para verificación pública.</p>
                    </div>
                    <div class="row-actions">
                        <label class="checkline">
                            <input type="checkbox" name="__NAME__[is_active]" value="1" checked>
                            Activo
                        </label>
                        <button class="btn btn-remove" type="button" data-remove-certificate>Quitar</button>
                    </div>
                </div>
                <input type="hidden" name="__NAME__[id]" value="">
                <div class="code-row">
                    <label>
                        Código único
                        <input class="code-input" type="text" name="__NAME__[code]" maxlength="7" pattern="[A-Z0-9]{7}" data-code-input>
                    </label>
                    <button class="btn btn-generate" type="button" data-generate-code>Generar código</button>
                </div>
                <div class="certificate-grid">
                    <label>
                        Nombre completo
                        <input type="text" name="__NAME__[full_name]">
                    </label>
                    <label>
                        Fecha de emisión
                        <input type="date" name="__NAME__[issue_date]">
                    </label>
                </div>
                <div class="certificate-grid">
                    <label>
                        Tipo de certificado en español
                        <input type="text" name="__NAME__[certificate_type]" placeholder="Certificado DRIC">
                        <span class="hint">Este texto se guarda en certificate_type.</span>
                    </label>
                    <label>
                        Tipo de certificado en inglés
                        <input type="text" name="__NAME__[certificate_type_en]" placeholder="DRIC Certificate">
                        <span class="hint">Si se deja vacío, se usará el tipo en español.</span>
                    </label>
                </div>
                <div class="certificate-grid">
                    <label>
                        Descripción en español
                        <textarea name="__NAME__[description_es]"></textarea>
                    </label>
                    <label>
                        Descripción en inglés
                        <textarea name="__NAME__[description_en]"></textarea>
                        <span class="hint">Si se deja vacío, se usará la descripción en español.</span>
                    </label>
                </div>
            </article>
        </template>
    </main>

    <script>
        const list = document.getElementById("certificates-list");
        const template = document.getElementById("certificate-template");
        const addButton = document.getElementById("add-certificate");
        let nextIndex = {{ count(old('certificates', $certificates)) }};

        function bindCard(card) {
            card.querySelector("[data-remove-certificate]").addEventListener("click", () => card.remove());
            card.querySelector("[data-code-input]").addEventListener("input", (event) => {
                event.target.value = event.target.value.toUpperCase().replace(/[^A-Z0-9]/g, "").slice(0, 7);
            });
            card.querySelector("[data-generate-code]").addEventListener("click", async () => {
                const input = card.querySelector("[data-code-input]");
                const button = card.querySelector("[data-generate-code]");
                button.disabled = true;
                button.textContent = "Generando...";

                try {
                    const response = await fetch("{{ route('admin.certificates.generate-code') }}", {
                        headers: { Accept: "application/json" },
                    });
                    const result = await response.json();
                    input.value = result.code;
                } finally {
                    button.disabled = false;
                    button.textContent = "Generar código";
                }
            });
        }

        document.querySelectorAll("[data-certificate-card]").forEach(bindCard);

        addButton.addEventListener("click", () => {
            const html = template.innerHTML.replaceAll("__NAME__", `certificates[${nextIndex}]`);
            const wrapper = document.createElement("div");
            wrapper.innerHTML = html.trim();
            const card = wrapper.firstElementChild;
            list.appendChild(card);
            bindCard(card);
            nextIndex += 1;
        });
    </script>
</body>
</html>
