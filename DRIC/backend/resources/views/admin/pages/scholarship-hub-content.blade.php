<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Becas y Movilidad</title>
    <style>
        :root { --blue: #164194; --red-dark: #7f0010; --ink: #172033; --muted: #647084; --line: #e5e9f0; --soft: #f5f7fb; }
        * { box-sizing: border-box; }
        body { margin: 0; background: #f4f6f9; color: var(--ink); font-family: Arial, sans-serif; }
        .shell { margin: 0 auto; max-width: 1180px; padding: 36px 20px 56px; }
        .topbar, .panel, .language-card, .item-card { background: #fff; border: 1px solid var(--line); border-radius: 18px; box-shadow: 0 18px 50px rgba(15, 23, 42, 0.08); }
        .topbar { align-items: center; display: flex; gap: 18px; justify-content: space-between; margin-bottom: 22px; padding: 24px; }
        h1, h2, h3 { margin: 0; }
        h1 { font-size: 34px; line-height: 1.1; }
        h2 { color: var(--blue); font-size: 24px; }
        h3 { color: var(--blue); font-size: 18px; }
        .muted { color: var(--muted); line-height: 1.55; margin: 8px 0 0; }
        .actions { display: flex; flex-wrap: wrap; gap: 10px; }
        .btn { border: 0; border-radius: 10px; cursor: pointer; display: inline-flex; font-weight: 800; justify-content: center; padding: 12px 16px; text-decoration: none; }
        .btn-primary { background: var(--blue); color: #fff; }
        .btn-secondary { background: #e8edf5; color: var(--ink); }
        .btn-undo { align-items: center; background: #eef3fb; color: var(--blue); font-size: 20px; font-weight: 900; line-height: 1; min-width: 40px; padding: 9px 12px; text-shadow: 0 0 0 currentColor, .35px 0 0 currentColor, 0 .35px 0 currentColor; }
        .btn-undo:disabled { cursor: not-allowed; opacity: .42; }
        .undo-floating { position: absolute; right: 12px; top: 12px; z-index: 4; }
        .item-card > .undo-floating { right: -10px; top: -10px; z-index: 6; }
        .alert { border-radius: 14px; margin-bottom: 18px; padding: 14px 16px; }
        .alert-success { background: #e8f8ee; border: 1px solid #bde8c9; color: #176534; }
        .alert-error { background: #fff1f2; border: 1px solid #b91c1c; color: var(--red-dark); font-weight: 800; }
        form, .field-grid, .section-grid { display: grid; gap: 16px; }
        .panel { padding: 24px; }
        .panel-header { border-bottom: 1px solid var(--line); margin-bottom: 20px; padding-bottom: 16px; }
        .language-grid, .two-grid { display: grid; gap: 18px; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .language-card, .item-card { box-shadow: none; padding: 18px; position: relative; }
        label { display: grid; gap: 7px; font-size: 13px; font-weight: 800; }
        input, textarea { border: 1px solid #cfd6e3; border-radius: 12px; color: var(--ink); font: inherit; font-weight: 500; padding: 12px 13px; width: 100%; }
        textarea { line-height: 1.55; min-height: 112px; resize: vertical; }
        .hint { color: var(--muted); font-size: 12px; font-weight: 500; line-height: 1.45; }
        .field-error { color: var(--red-dark); font-size: 12px; font-weight: 800; line-height: 1.45; }
        .sticky-actions { align-items: center; background: rgba(255,255,255,.94); border: 1px solid var(--line); border-radius: 16px; bottom: 18px; box-shadow: 0 18px 45px rgba(15,23,42,.12); display: flex; justify-content: space-between; padding: 14px; position: sticky; }
        .card-heading { align-items: flex-start; display: flex; gap: 16px; justify-content: space-between; margin-bottom: 16px; }
        .card-heading .muted { font-size: 13px; font-weight: 800; margin-top: 4px; }
        .card-heading .btn { flex-shrink: 0; }
        @media (max-width: 900px) { .topbar, .sticky-actions, .card-heading { align-items: stretch; flex-direction: column; } .language-grid, .two-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <main class="shell">
        @php
            $cardEditLinks = [
                1 => $scholarshipPage ? [
                    'label' => 'Editar detalle de Becas',
                    'href' => route('admin.pages.scholarship-becas.edit', $scholarshipPage),
                ] : null,
                2 => $mobilityPage ? [
                    'label' => 'Editar detalle de Movilidad',
                    'href' => route('admin.pages.mobility-pasantias.edit', $mobilityPage),
                ] : null,
                3 => $awardsPage ? [
                    'label' => 'Editar detalle de Premios-Concursos',
                    'href' => route('admin.pages.awards-opportunities.edit', $awardsPage),
                ] : null,
                4 => $nationalForeignInfoPage ? [
                    'label' => 'Editar detalle de Información',
                    'href' => route('admin.pages.national-foreign-info.edit', $nationalForeignInfoPage),
                ] : null,
            ];
        @endphp

        <header class="topbar">
            <div>
                <h1>Becas y Movilidad</h1>
                <p class="muted">Edita el texto y los enlaces de la página principal. Íconos, colores y diseño no se modifican.</p>
            </div>
            <div class="actions">
                <a class="btn btn-secondary" href="{{ route('admin.pages.index') }}">Volver a páginas</a>
                <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Panel</a>
            </div>
        </header>

        @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if ($errors->any()) <div class="alert alert-error">Revisa los campos marcados. Cada error aparece debajo del campo que necesita corrección.</div> @endif

        <form method="POST" action="{{ route('admin.pages.scholarship-hub.update', $page) }}">
            @csrf
            @method('PUT')

            <section class="panel">
                <div class="panel-header">
                    <h2>Encabezado y bloque de exploración</h2>
                    <p class="muted">Estos textos aparecen antes de las tarjetas de navegación.</p>
                </div>

                <div class="language-grid">
                    @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                        <div class="language-card">
                            <h3>{{ $label }}</h3>
                            <div class="field-grid">
                                <label>Título principal<input type="text" name="{{ $locale }}[title]" value="{{ old($locale.'.title', $content[$locale]['title']) }}">@error($locale.'.title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Descripción principal<textarea name="{{ $locale }}[intro]">{{ old($locale.'.intro', $content[$locale]['intro']) }}</textarea>@error($locale.'.intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Etiqueta de exploración<input type="text" name="{{ $locale }}[explore_badge]" value="{{ old($locale.'.explore_badge', $content[$locale]['explore_badge']) }}">@error($locale.'.explore_badge')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Título de exploración<input type="text" name="{{ $locale }}[explore_title]" value="{{ old($locale.'.explore_title', $content[$locale]['explore_title']) }}">@error($locale.'.explore_title')<span class="field-error">{{ $message }}</span>@enderror</label>
                                <label>Texto de exploración<textarea name="{{ $locale }}[explore_intro]">{{ old($locale.'.explore_intro', $content[$locale]['explore_intro']) }}</textarea>@error($locale.'.explore_intro')<span class="field-error">{{ $message }}</span>@enderror</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <h2>Tarjetas principales</h2>
                    <p class="muted">El orden sigue la vista pública: Becas, Movilidad, Premios e Información. Cada tarjeta tiene su acceso directo al panel de detalle correspondiente.</p>
                </div>

                <div class="section-grid">
                    @foreach ($content['cards'] as $index => $card)
                        <article class="item-card">
                            <div class="card-heading">
                                <div>
                                    <h3>{{ $cardLabels[$index] ?? 'Tarjeta '.$index }}</h3>
                                    <p class="muted">Tarjeta {{ $index }} de Becas y Movilidad</p>
                                </div>

                                @if ($cardEditLinks[$index] ?? null)
                                    <a class="btn btn-primary" href="{{ $cardEditLinks[$index]['href'] }}">{{ $cardEditLinks[$index]['label'] }}</a>
                                @endif
                            </div>

                            <label>
                                URL de destino
                                <input type="text" name="cards[{{ $index }}][href]" value="{{ old('cards.'.$index.'.href', $card['href']) }}">
                                <span class="hint">Usa una ruta interna como /becas-movilidad/becas o una URL completa.</span>
                                @error('cards.'.$index.'.href')<span class="field-error">{{ $message }}</span>@enderror
                            </label>

                            <div class="language-grid">
                                @foreach (['es' => 'Español', 'en' => 'Inglés'] as $locale => $label)
                                    <div class="language-card">
                                        <h3>{{ $label }}</h3>
                                        <label>Título<input type="text" name="cards[{{ $index }}][title_{{ $locale }}]" value="{{ old('cards.'.$index.'.title_'.$locale, $card['title_'.$locale]) }}">@error('cards.'.$index.'.title_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>Descripción<textarea name="cards[{{ $index }}][description_{{ $locale }}]">{{ old('cards.'.$index.'.description_'.$locale, $card['description_'.$locale]) }}</textarea>@error('cards.'.$index.'.description_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                        <label>Texto del botón<input type="text" name="cards[{{ $index }}][label_{{ $locale }}]" value="{{ old('cards.'.$index.'.label_'.$locale, $card['label_'.$locale]) }}">@error('cards.'.$index.'.label_'.$locale)<span class="field-error">{{ $message }}</span>@enderror</label>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>

            <div class="sticky-actions">
                <span class="muted">Los cambios se guardan en la base de datos y se muestran al recargar Becas y Movilidad.</span>
                <button class="btn btn-primary" type="submit">Guardar contenido</button>
            </div>
        </form>
    </main>
    <script>
        const cardHistory = new WeakMap();
        const fieldStartSnapshots = new WeakMap();

        function editableFields(scope) {
            return Array.from(scope.querySelectorAll("input, textarea"));
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

                if (field.type === "checkbox") {
                    field.checked = item.checked;
                    return;
                }

                field.value = item.value;
                field.dispatchEvent(new Event("input", { bubbles: true }));
            });
        }

        function historyFor(scope) {
            if (!cardHistory.has(scope)) {
                cardHistory.set(scope, []);
            }

            return cardHistory.get(scope);
        }

        function setUndoState(scope) {
            const button = scope.querySelector(":scope > [data-undo-card]");
            if (!button) return;

            button.disabled = historyFor(scope).length === 0;
        }

        function pushSnapshot(scope, snapshot = snapshotScope(scope)) {
            const history = historyFor(scope);
            const serialized = JSON.stringify(snapshot);
            const last = history.length ? JSON.stringify(history[history.length - 1]) : null;

            if (serialized !== last) {
                history.push(snapshot);
            }

            if (history.length > 20) {
                history.shift();
            }

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
            const scope = field.closest("[data-undo-scope]");
            if (!scope || fieldStartSnapshots.has(field)) return;

            fieldStartSnapshots.set(field, snapshotScope(scope));
        }

        function rememberFieldChange(field) {
            const scope = field.closest("[data-undo-scope]");
            const snapshot = fieldStartSnapshots.get(field);
            if (!scope || !snapshot) return;

            pushSnapshot(scope, snapshot);
            fieldStartSnapshots.delete(field);
        }

        function bindUndoScope(scope) {
            if (scope.dataset.undoBound === "1") return;

            scope.dataset.undoScope = "";
            scope.dataset.undoBound = "1";

            const button = document.createElement("button");
            button.className = "btn btn-undo undo-floating";
            button.type = "button";
            button.dataset.undoCard = "";
            button.disabled = true;
            button.title = "Deshacer último cambio";
            button.setAttribute("aria-label", "Deshacer último cambio");
            button.textContent = "↶";
            scope.appendChild(button);

            button.addEventListener("click", () => undoScope(scope));

            editableFields(scope).forEach((field) => {
                field.addEventListener("focusin", () => markFieldStart(field));
                field.addEventListener("input", () => rememberFieldChange(field));
                field.addEventListener("change", () => rememberFieldChange(field));
            });
        }

        document.querySelectorAll(".language-card, .item-card").forEach(bindUndoScope);
    </script>
</body>
</html>
