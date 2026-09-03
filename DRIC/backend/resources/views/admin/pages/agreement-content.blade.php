<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Contenido de Convenios</title>
    <style>
        :root {
            --blue: #164194;
            --red-dark: #7f0010;
            --ink: #172033;
            --muted: #647084;
            --line: #e5e9f0;
            --soft: #f5f7fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6f9;
            color: var(--ink);
            font-family: Arial, sans-serif;
        }

        .shell {
            margin: 0 auto;
            max-width: 1180px;
            padding: 36px 20px 56px;
        }

        .topbar,
        .panel,
        .language-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08);
        }

        .topbar {
            align-items: center;
            display: flex;
            gap: 18px;
            justify-content: space-between;
            margin-bottom: 22px;
            padding: 24px;
        }

        h1,
        h2,
        h3 {
            margin: 0;
        }

        h1 {
            font-size: 34px;
            line-height: 1.1;
        }

        h2 {
            font-size: 22px;
        }

        h3 {
            color: var(--blue);
            font-size: 18px;
        }

        .muted {
            color: var(--muted);
            line-height: 1.55;
            margin: 8px 0 0;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            border: 0;
            border-radius: 10px;
            cursor: pointer;
            display: inline-flex;
            font-weight: 800;
            justify-content: center;
            padding: 12px 16px;
            text-decoration: none;
        }

        .btn-primary {
            background: var(--blue);
            color: #fff;
        }

        .btn-secondary {
            background: #e8edf5;
            color: var(--ink);
        }

        .alert {
            border-radius: 14px;
            margin-bottom: 18px;
            padding: 14px 16px;
        }

        .alert-success {
            background: #e8f8ee;
            border: 1px solid #bde8c9;
            color: #176534;
        }

        .alert-error {
            background: #fff1f2;
            border: 1px solid #b91c1c;
            color: var(--red-dark);
            font-weight: 800;
        }

        form {
            display: grid;
            gap: 22px;
        }

        .panel {
            padding: 24px;
        }

        .panel-header {
            border-bottom: 1px solid var(--line);
            margin-bottom: 20px;
            padding-bottom: 16px;
        }

        .language-grid,
        .media-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cards-grid {
            display: grid;
            gap: 18px;
        }

        .language-card,
        .media-card {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: none;
            padding: 18px;
        }

        .field-grid {
            display: grid;
            gap: 14px;
        }

        label {
            display: grid;
            gap: 7px;
            font-size: 13px;
            font-weight: 800;
        }

        input[type="text"],
        input[type="url"],
        input[type="file"],
        textarea {
            border: 1px solid #cfd6e3;
            border-radius: 12px;
            color: var(--ink);
            font: inherit;
            font-weight: 500;
            padding: 12px 13px;
            width: 100%;
        }

        textarea {
            line-height: 1.55;
            min-height: 104px;
            resize: vertical;
        }

        .hint {
            color: var(--muted);
            font-size: 12px;
            font-weight: 500;
            line-height: 1.45;
        }

        .field-error,
        .live-error {
            color: var(--red-dark);
            font-size: 12px;
            font-weight: 800;
            line-height: 1.45;
        }

        .live-error:empty {
            display: none;
        }

        .is-invalid {
            border-color: var(--red-dark) !important;
            box-shadow: 0 0 0 3px rgba(127, 0, 16, 0.10);
        }

        .preview {
            align-items: center;
            background: #e8edf5;
            border-radius: 14px;
            display: flex;
            height: 170px;
            justify-content: center;
            margin-bottom: 14px;
            overflow: hidden;
        }

        .preview img {
            height: 100%;
            object-fit: cover;
            width: 100%;
        }

        .sticky-actions {
            align-items: center;
            background: rgba(255, 255, 255, 0.94);
            border: 1px solid var(--line);
            border-radius: 16px;
            bottom: 18px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.12);
            display: flex;
            justify-content: space-between;
            padding: 14px;
            position: sticky;
        }

        .subpage-actions {
            display: grid;
            gap: 14px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .subpage-card {
            border: 1px solid var(--line);
            border-radius: 16px;
            padding: 18px;
        }

        @media (max-width: 820px) {
            .topbar,
            .sticky-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .language-grid,
            .media-grid,
            .subpage-actions {
                grid-template-columns: 1fr;
            }

            h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Contenido de Convenios</h1>
                <p class="muted">Administra textos, enlaces, PDF e imágenes de la página general de Convenios. El diseño del sitio no se modifica desde aquí.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.
            </div>
        @endif

        <form method="POST" action="{{ route('admin.pages.agreements.update', $page) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado principal</h2>
                    <p class="muted">Texto superior y párrafos introductorios de la página.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Categoría
                                    <input type="text" name="{{ $locale }}[eyebrow]" value="{{ old($locale.'.eyebrow', $content[$locale]['eyebrow']) }}">
                                    @error($locale.'.eyebrow')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Título
                                    <input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">
                                    @error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Primer párrafo
                                    <textarea name="{{ $locale }}[intro_one]">{{ old($locale.'.intro_one', $content[$locale]['intro_one']) }}</textarea>
                                    @error($locale.'.intro_one')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Segundo párrafo
                                    <textarea name="{{ $locale }}[intro_two]">{{ old($locale.'.intro_two', $content[$locale]['intro_two']) }}</textarea>
                                    @error($locale.'.intro_two')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                                <label>
                                    Texto del botón de las tarjetas
                                    <input type="text" name="{{ $locale }}[main_button]" value="{{ old($locale.'.main_button', $content[$locale]['main_button']) }}">
                                    @error($locale.'.main_button')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Botón de procedimiento</h2>
                    <p class="muted">Puedes usar una URL externa o subir un PDF. Si subes un PDF nuevo, ese archivo tendrá prioridad.</p>
                </div>
                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <label style="margin-top:14px;">
                                Texto del botón
                                <input type="text" name="{{ $locale }}[procedure_label]" value="{{ old($locale.'.procedure_label', $content[$locale]['procedure_label']) }}">
                                @error($locale.'.procedure_label')<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </div>
                    @endforeach
                </div>
                <div class="language-card" style="margin-top:18px;">
                    <div class="field-grid">
                        <label>
                            URL del PDF
                            <input type="url" name="procedure_url" value="{{ old('procedure_url', $content['procedure_url']) }}" placeholder="https://sitio.edu.bo/documento.pdf">
                            <span class="hint">Usa este campo si el PDF está alojado en otra página.</span>
                            @error('procedure_url')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                        <label>
                            Subir PDF
                            <input type="file" name="procedure_pdf" accept=".pdf,application/pdf">
                            <span class="hint">Solo PDF. Tamaño máximo: 20 MB. @if ($content['procedure_pdf_url']) PDF actual: <a href="{{ $content['procedure_pdf_url'] }}" target="_blank">abrir archivo</a>. @endif</span>
                            @error('procedure_pdf')<span class="field-error">{{ $message }}</span>@enderror
                        </label>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas de acceso</h2>
                    <p class="muted">Edita el texto y destino de las tres tarjetas. Las subpáginas se administrarán luego en sus propios módulos.</p>
                </div>
                <div class="cards-grid">
                    @foreach ([1, 2, 3] as $index)
                        <div class="language-card">
                            <h3>Tarjeta {{ $index }}</h3>
                            <div class="language-grid" style="margin-top:14px;">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="field-grid">
                                        <h3>{{ $label }}</h3>
                                        <label>
                                            Título
                                            <input type="text" name="{{ $locale }}[card_{{ $index }}_title]" value="{{ old($locale.'.card_'.$index.'_title', $content[$locale]['card_'.$index.'_title']) }}">
                                            @error($locale.'.card_'.$index.'_title')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                        <label>
                                            Descripción
                                            <textarea name="{{ $locale }}[card_{{ $index }}_description]">{{ old($locale.'.card_'.$index.'_description', $content[$locale]['card_'.$index.'_description']) }}</textarea>
                                            @error($locale.'.card_'.$index.'_description')<span class="field-error">{{ $message }}</span>@enderror
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="field-grid" style="margin-top:14px;">
                                <label>
                                    Destino del botón de la tarjeta
                                    <input type="text" name="card_{{ $index }}_href" value="{{ old('card_'.$index.'_href', $content['card_'.$index.'_href']) }}">
                                    <span class="hint">Puedes usar una URL completa o una ruta interna como /convenios/otros.</span>
                                    @error('card_'.$index.'_href')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Imágenes</h2>
                    <p class="muted">Solo JPG o PNG. Tamaño máximo permitido: 5 MB por imagen.</p>
                </div>
                <div class="media-grid">
                    @foreach ([
                        'hero_image' => ['label' => 'Imagen principal', 'url' => $content['hero_image_url']],
                        'card_1_image' => ['label' => 'Imagen de la tarjeta uno', 'url' => $content['card_1_image_url']],
                        'card_2_image' => ['label' => 'Imagen de la tarjeta dos', 'url' => $content['card_2_image_url']],
                        'card_3_image' => ['label' => 'Imagen de la tarjeta tres', 'url' => $content['card_3_image_url']],
                    ] as $field => $image)
                        <div class="media-card">
                            <div class="preview">
                                @if ($image['url'])
                                    <img src="{{ $image['url'] }}" alt="{{ $image['label'] }}">
                                @else
                                    <span class="muted">Se usará la imagen actual del sitio hasta subir una nueva.</span>
                                @endif
                            </div>
                            <label>
                                {{ $image['label'] }}
                                <input type="file" name="{{ $field }}" accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                                <span class="hint">No se eliminará la imagen anterior hasta guardar una nueva.</span>
                                @error($field)<span class="field-error">{{ $message }}</span>@enderror
                            </label>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Subpáginas de convenios</h2>
                    <p class="muted">Administra las listas de documentos que se abren desde las tarjetas de esta página.</p>
                </div>
                <div class="subpage-actions">
                    <div class="subpage-card">
                        <h3>Otros convenios suscritos</h3>
                        <p class="muted">Agrega, edita o quita documentos con título y URL para /convenios/otros.</p>
                        <div class="actions" style="margin-top:14px;">
                            <a class="btn btn-primary" href="{{ route('admin.agreement-lists.edit', 'otros') }}">Editar lista</a>
                        </div>
                    </div>
                    <div class="subpage-card">
                        <h3>Convenios CEUB y Gobierno de Bolivia</h3>
                        <p class="muted">Agrega, edita o quita documentos con título y URL para /convenios/ceub-gobierno.</p>
                        <div class="actions" style="margin-top:14px;">
                            <a class="btn btn-primary" href="{{ route('admin.agreement-lists.edit', 'ceub-gobierno') }}">Editar lista</a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios publicados se verán en la página pública al recargar el sitio.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>
    <script>
        const cleanLabelPattern = /^[\p{L}\s.,]+$/u;
        const cleanFieldNames = [
            "eyebrow",
            "title",
            "main_button",
            "procedure_label",
            "card_1_title",
            "card_2_title",
            "card_3_title",
        ];

        function ensureLiveError(field) {
            let message = field.parentElement.querySelector(".live-error");

            if (!message) {
                message = document.createElement("span");
                message.className = "live-error";
                field.insertAdjacentElement("afterend", message);
            }

            return message;
        }

        function forbiddenCharacters(value) {
            return [...new Set([...value].filter((character) => character.trim() && !/[\p{L}.,]/u.test(character)))];
        }

        function validateCleanField(field) {
            const message = ensureLiveError(field);
            const value = field.value.trim();

            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!value) {
                return;
            }

            if (/\d/u.test(value)) {
                field.classList.add("is-invalid");
                message.textContent = "No uses números en títulos o categorías.";
                return;
            }

            if (!cleanLabelPattern.test(value)) {
                const invalid = forbiddenCharacters(value).join(" ");
                field.classList.add("is-invalid");
                message.textContent = invalid
                    ? `Solo se permiten letras, espacios, puntos y comas. Quita: ${invalid}`
                    : "Solo se permiten letras, espacios, puntos y comas.";
            }
        }

        function validateUpload(field) {
            const message = ensureLiveError(field);
            const file = field.files?.[0];

            field.classList.remove("is-invalid");
            message.textContent = "";

            if (!file) {
                return;
            }

            const isPdf = field.name === "procedure_pdf";
            const validTypes = isPdf ? ["application/pdf"] : ["image/jpeg", "image/png"];

            if (!validTypes.includes(file.type)) {
                field.classList.add("is-invalid");
                message.textContent = isPdf
                    ? "Ese formato no está permitido. Solo se aceptan archivos PDF."
                    : "Ese formato no está permitido. Solo se aceptan imágenes JPG o PNG.";
                return;
            }

            const maxSize = isPdf ? 20 * 1024 * 1024 : 5 * 1024 * 1024;

            if (file.size > maxSize) {
                field.classList.add("is-invalid");
                message.textContent = isPdf
                    ? "El PDF es demasiado pesado. El tamaño máximo permitido es 20 MB."
                    : "La imagen es demasiado pesada. El tamaño máximo permitido es 5 MB.";
            }
        }

        document.querySelectorAll("input[type='text'], textarea").forEach((field) => {
            const shouldValidate = cleanFieldNames.some((name) => field.name.includes(`[${name}]`));

            if (shouldValidate) {
                field.addEventListener("input", () => validateCleanField(field));
                field.addEventListener("blur", () => validateCleanField(field));
            }
        });

        document.querySelectorAll("input[type='file']").forEach((field) => {
            field.addEventListener("change", () => validateUpload(field));
        });
    </script>
</body>
</html>
