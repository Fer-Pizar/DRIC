<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Detalle de noticia</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .image-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 32px; line-height: 1.15; }
        h2 { font-size: 22px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-light { background: #f8fafc; border: 1px solid var(--line); color: var(--ink); padding: 8px 10px; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid { display: grid; gap: 14px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card { box-shadow: none; padding: 18px; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        textarea, input[type="file"] { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        input[type="text"] { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 104px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .toolbar { display: flex; flex-wrap: wrap; gap: 8px; margin: 12px 0; }
        .editor { border: 1px solid #cfd6e3; border-radius: 14px; line-height: 1.75; min-height: 340px; outline: none; padding: 18px; }
        .editor:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(22, 65, 148, 0.12); }
        .editor p { margin: 0 0 16px; }
        .editor blockquote { border-left: 4px solid var(--blue); color: #475569; margin: 16px 0; padding-left: 16px; }
        .images-grid { display: grid; gap: 14px; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); }
        .image-card { box-shadow: none; overflow: hidden; padding: 12px; }
        .image-card img { aspect-ratio: 16 / 10; border-radius: 12px; display: block; object-fit: cover; width: 100%; }
        .remove-option { align-items: center; display: flex; gap: 8px; margin-top: 10px; }
        .remove-option input { height: 16px; width: 16px; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        @media (max-width: 820px) { .topbar, .sticky-actions { align-items: stretch; flex-direction: column; } .language-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        <header class="topbar">
            <div>
                <h1>Detalle de noticia</h1>
                <p class="muted">{{ $news->translations->firstWhere('language.code', 'es')?->title }}</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.news.edit', $newsPage) }}">Volver a Noticias</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.news.detail.update', $news) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Texto editorial</h2>
                    <p class="muted">Puedes usar negrita, cursiva, subrayado, subtítulos, citas y listas. El diseño público se mantiene fijo.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>
                                    Título del detalle
                                    <input type="text" name="{{ $locale }}[detail_title]" value="{{ old($locale.'.detail_title', $content[$locale]['detail_title']) }}">
                                    <span class="hint">Este título aparece en blanco con brillo dentro del detalle de la noticia.</span>
                                    @error($locale.'.detail_title')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Bajada del detalle
                                    <textarea name="{{ $locale }}[deck]">{{ old($locale.'.deck', $content[$locale]['deck']) }}</textarea>
                                    @error($locale.'.deck')<span class="field-error">{{ $message }}</span>@enderror
                                </label>

                                <label>
                                    Cuerpo de la noticia
                                    <div class="toolbar" data-toolbar="{{ $locale }}">
                                        <button class="btn btn-light" type="button" data-command="bold">B</button>
                                        <button class="btn btn-light" type="button" data-command="italic">I</button>
                                        <button class="btn btn-light" type="button" data-command="underline">U</button>
                                        <button class="btn btn-light" type="button" data-block="h2">H2</button>
                                        <button class="btn btn-light" type="button" data-block="h3">H3</button>
                                        <button class="btn btn-light" type="button" data-command="insertUnorderedList">Viñetas</button>
                                        <button class="btn btn-light" type="button" data-command="insertOrderedList">Números</button>
                                        <button class="btn btn-light" type="button" data-block="blockquote">Cita</button>
                                        <button class="btn btn-light" type="button" data-command="removeFormat">Limpiar</button>
                                    </div>
                                    <div class="editor" data-editor="{{ $locale }}" contenteditable="true">{!! old($locale.'.body', $content[$locale]['body']) !!}</div>
                                    <input type="hidden" name="{{ $locale }}[body]" data-body-input="{{ $locale }}">
                                    <span class="hint">Pega o redacta el contenido aquí. El primer párrafo mantiene la letra inicial grande en la vista pública.</span>
                                    @error($locale.'.body')<span class="field-error">{{ $message }}</span>@enderror
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Imágenes del detalle</h2>
                    <p class="muted">Puedes subir una o varias imágenes JPG o PNG. Si hay más de una, la página pública las mostrará en carrusel automático.</p>
                </div>

                @if (count($images))
                    <div class="images-grid">
                        @foreach ($images as $image)
                            <div class="image-card">
                                <img src="{{ $image['url'] ?? '' }}" alt="{{ $image['file_name'] ?? 'Imagen de noticia' }}">
                                <label class="remove-option">
                                    <input type="checkbox" name="remove_images[]" value="{{ $image['media_asset_id'] ?? '' }}">
                                    Quitar imagen
                                </label>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="muted">Esta noticia todavía no tiene imágenes cargadas.</p>
                @endif

                <label style="margin-top: 18px;">
                    Agregar imágenes
                    <input type="file" name="images[]" multiple accept=".jpg,.jpeg,.png,image/jpeg,image/png">
                    <span class="hint">Formatos permitidos: JPG y PNG. Tamaño máximo por imagen: 10 MB.</span>
                    <span class="field-error" id="image-error"></span>
                    @error('images.*')<span class="field-error">{{ $message }}</span>@enderror
                </label>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se publican al guardar y recargar la noticia pública.</span>
                <button class="btn btn-primary" type="submit">Guardar detalle</button>
            </div>
        </form>
    </main>

    <script>
        let savedRange = null;

        function rememberSelection() {
            const selection = window.getSelection();
            if (selection && selection.rangeCount) {
                savedRange = selection.getRangeAt(0);
            }
        }

        function restoreSelection(editor) {
            editor.focus();

            if (!savedRange) {
                return;
            }

            const selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(savedRange);
        }

        document.querySelectorAll("[data-toolbar]").forEach((toolbar) => {
            const locale = toolbar.dataset.toolbar;
            const editor = document.querySelector(`[data-editor="${locale}"]`);

            editor.addEventListener("keyup", rememberSelection);
            editor.addEventListener("mouseup", rememberSelection);
            editor.addEventListener("focus", rememberSelection);

            toolbar.querySelectorAll("button").forEach((button) => {
                button.addEventListener("mousedown", (event) => event.preventDefault());
                button.addEventListener("click", () => {
                    restoreSelection(editor);
                    if (button.dataset.block) {
                        document.execCommand("formatBlock", false, button.dataset.block);
                    } else {
                        document.execCommand(button.dataset.command, false, null);
                    }
                    rememberSelection();
                });
            });
        });

        document.querySelector("form").addEventListener("submit", () => {
            document.querySelectorAll("[data-editor]").forEach((editor) => {
                const input = document.querySelector(`[data-body-input="${editor.dataset.editor}"]`);
                input.value = normalizeEditorHtml(editor);
            });
        });

        document.execCommand("defaultParagraphSeparator", false, "p");

        function normalizeEditorHtml(editor) {
            const html = editor.innerHTML.trim();
            if (/<(p|h2|h3|ul|ol|li|blockquote|div)\b/i.test(html)) {
                return html
                    .replace(/<div><br><\/div>/gi, "")
                    .replace(/<div>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>)[\s\S]*?(?:<\/ul>|<\/ol>))\s*<\/div>/gi, "$1")
                    .replace(/<p>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>)[\s\S]*?(?:<\/ul>|<\/ol>))\s*<\/p>/gi, "$1")
                    .replace(/<div>/gi, "<p>")
                    .replace(/<\/div>/gi, "</p>")
                    .replace(/<p>\s*((?:<ul\b[^>]*>|<ol\b[^>]*>)[\s\S]*?(?:<\/ul>|<\/ol>))\s*<\/p>/gi, "$1");
            }

            return editor.innerText
                .split(/\n{2,}/)
                .map((paragraph) => paragraph.trim())
                .filter(Boolean)
                .map((paragraph) => `<p>${paragraph.replace(/\n/g, "<br>")}</p>`)
                .join("");
        }

        document.querySelector("input[type='file']").addEventListener("change", (event) => {
            const message = document.getElementById("image-error");
            const files = [...event.target.files];
            message.textContent = "";

            for (const file of files) {
                if (!["image/jpeg", "image/png"].includes(file.type)) {
                    message.textContent = "Ese formato no está permitido. Usa JPG o PNG.";
                    event.target.value = "";
                    return;
                }

                if (file.size > 10 * 1024 * 1024) {
                    message.textContent = "La imagen sobrepasa los 10MB.";
                    event.target.value = "";
                    return;
                }
            }
        });
    </script>
</body>
</html>
