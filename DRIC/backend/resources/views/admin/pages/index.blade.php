@php
    $statusLabels = [
        'draft' => 'Borrador',
        'published' => 'Publicado',
        'archived' => 'Archivado',
    ];

    $pageTypeLabels = [
        'static' => 'Pagina estatica',
        'page' => 'Pagina',
        'main' => 'Principal',
        'content' => 'Contenido',
        'legal' => 'Legal',
        'mobility_catalog' => 'Catalogo de movilidad',
    ];

    $contentRoutes = [
        'inicio' => ['admin.pages.home.edit', 'Contenido de Inicio'],
        'presentacion' => ['admin.pages.presentation.edit', 'Contenido de Presentacion'],
        'convenios' => ['admin.pages.agreements.edit', 'Contenido de Convenios'],
        'proyectos' => ['admin.pages.projects.edit', 'Contenido de Proyectos'],
        'becas-movilidad' => ['admin.pages.scholarship-hub.edit', 'Contenido de Becas y Movilidad'],
        'becas' => ['admin.pages.scholarship-becas.edit', 'Contenido de Becas'],
        'movilidad-pasantias' => ['admin.pages.mobility-pasantias.edit', 'Contenido de Movilidad'],
        'premios-eventos-cursos-concursos' => ['admin.pages.awards-opportunities.edit', 'Contenido de Premios'],
        'informacion-nacionales-extranjeros' => ['admin.pages.national-foreign-info.edit', 'Contenido de Informacion'],
        'internacionalizacion' => ['admin.pages.internationalization.edit', 'Contenido de Internacionalizacion'],
        'membresias' => ['admin.pages.memberships.edit', 'Contenido de Membresias'],
        'noticias' => ['admin.pages.news.edit', 'Contenido de Noticias'],
        'normativas' => ['admin.pages.normatives.edit', 'Contenido de Normativas'],
        'informes-gestion' => ['admin.pages.reports.edit', 'Contenido de Informes'],
        'validar-certificado' => ['admin.pages.certificates.edit', 'Contenido de Certificados'],
        'contacto' => ['admin.pages.contact.edit', 'Contenido de Contacto'],
        'campus-life' => ['admin.pages.campus-life.edit', 'Contenido de Campus Life'],
    ];

    $specialContentRoutes = [
        'convenios-otros' => [route('admin.agreement-lists.edit', 'otros'), 'Lista Otros convenios'],
        'convenios-ceub-gobierno' => [route('admin.agreement-lists.edit', 'ceub-gobierno'), 'Lista CEUB Gobierno'],
        'proyectos-apoyo-financiero' => [route('admin.project-funding.edit'), 'Apoyo financiero'],
    ];

    $contentLink = function ($page) use ($contentRoutes, $specialContentRoutes) {
        if (isset($specialContentRoutes[$page->slug])) {
            return $specialContentRoutes[$page->slug];
        }

        if (isset($contentRoutes[$page->slug])) {
            return [route($contentRoutes[$page->slug][0], $page), $contentRoutes[$page->slug][1]];
        }

        return null;
    };

    $pageTitle = function ($page) {
        return $page->translations->firstWhere('language.code', 'es')?->title
            ?? str($page->slug)->replace('-', ' ')->title();
    };

    $groupTitle = function ($groupKey) {
        if ($groupKey === '__root') {
            return 'Paginas principales';
        }

        return 'Dentro de '.$groupKey;
    };

    $groupedPages = $pages->getCollection()->groupBy(fn ($page) => $page->parent?->slug ?? '__root');
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Paginas</title>
    <style>
        :root {
            --blue: #164194;
            --blue-dark: #0f2f6f;
            --ink: #172033;
            --muted: #667085;
            --line: #e5eaf3;
            --soft: #f5f7fb;
            --success: #157f3d;
            --warning: #a15c05;
            --danger: #9f1239;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                radial-gradient(circle at top left, rgba(22, 65, 148, 0.13), transparent 34rem),
                linear-gradient(180deg, #f3f6fb 0%, #eef2f7 100%);
            color: var(--ink);
            font-family: Arial, sans-serif;
            padding: 32px;
        }

        .page-shell {
            max-width: 1280px;
            margin: 0 auto;
        }

        .hero {
            display: flex;
            justify-content: space-between;
            gap: 24px;
            align-items: center;
            margin-bottom: 22px;
            padding: 30px 34px;
            border: 1px solid rgba(22, 65, 148, 0.10);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.88);
            box-shadow: 0 20px 60px rgba(15, 23, 42, 0.08);
        }

        .eyebrow {
            margin: 0 0 10px;
            color: var(--blue);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            font-size: clamp(34px, 4vw, 56px);
            line-height: 0.95;
            letter-spacing: -0.045em;
        }

        .hero p:last-child {
            max-width: 680px;
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.6;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 22px;
        }

        .summary-card {
            padding: 18px 20px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.82);
        }

        .summary-card span {
            display: block;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .summary-card strong {
            display: block;
            margin-top: 8px;
            color: var(--blue);
            font-size: 28px;
            line-height: 1;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 11px 18px;
            border: 0;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 800;
            line-height: 1;
            text-decoration: none;
            transition: transform 0.18s ease, box-shadow 0.18s ease, background 0.18s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-primary {
            color: #fff;
            background: var(--blue);
            box-shadow: 0 14px 28px rgba(22, 65, 148, 0.22);
        }

        .btn-edit {
            color: var(--blue-dark);
            background: #eaf0ff;
        }

        .btn-content {
            color: #fff;
            background: var(--blue);
        }

        .alert {
            margin-bottom: 22px;
            padding: 16px 18px;
            border: 1px solid #b7efc5;
            border-radius: 16px;
            background: #eafff0;
            color: #166534;
            font-weight: 700;
        }

        .group {
            margin-top: 22px;
            padding: 24px;
            border: 1px solid var(--line);
            border-radius: 24px;
            background: rgba(255, 255, 255, 0.86);
            box-shadow: 0 16px 46px rgba(15, 23, 42, 0.06);
        }

        .group-header {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            align-items: end;
            margin-bottom: 18px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--line);
        }

        .group-header h2 {
            margin: 0;
            color: var(--blue);
            font-size: 25px;
            letter-spacing: -0.025em;
        }

        .group-header p {
            margin: 6px 0 0;
            color: var(--muted);
        }

        .count-pill {
            flex: 0 0 auto;
            border-radius: 999px;
            background: var(--soft);
            color: var(--muted);
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 800;
        }

        .page-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .page-card {
            display: flex;
            flex-direction: column;
            min-height: 240px;
            padding: 20px;
            border: 1px solid var(--line);
            border-radius: 20px;
            background: #fff;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.045);
        }

        .card-top {
            display: flex;
            justify-content: space-between;
            gap: 16px;
        }

        .page-id {
            color: var(--muted);
            font-size: 13px;
            font-weight: 800;
        }

        .page-card h3 {
            margin: 8px 0 8px;
            color: var(--ink);
            font-size: 23px;
            line-height: 1.14;
            letter-spacing: -0.02em;
        }

        .slug {
            display: inline-flex;
            width: fit-content;
            max-width: 100%;
            padding: 7px 10px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 13px;
            overflow-wrap: anywhere;
        }

        .status {
            flex: 0 0 auto;
            height: fit-content;
            padding: 7px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .status-published {
            background: #dcfce7;
            color: var(--success);
        }

        .status-draft {
            background: #fff7ed;
            color: var(--warning);
        }

        .status-archived {
            background: #ffe4e6;
            color: var(--danger);
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
            margin-top: 18px;
        }

        .meta {
            padding: 12px;
            border-radius: 14px;
            background: var(--soft);
        }

        .meta span {
            display: block;
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .meta strong {
            color: var(--ink);
            font-size: 14px;
            overflow-wrap: anywhere;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: auto;
            padding-top: 18px;
        }

        .pagination {
            margin-top: 24px;
        }

        .empty {
            padding: 32px;
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            background: #fff;
            color: var(--muted);
            text-align: center;
        }

        @media (max-width: 900px) {
            body {
                padding: 20px;
            }

            .hero,
            .group-header {
                align-items: stretch;
                flex-direction: column;
            }

            .summary,
            .page-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            body {
                padding: 14px;
            }

            .hero,
            .group {
                padding: 20px;
                border-radius: 18px;
            }

            .page-card {
                min-height: 0;
                padding: 16px;
            }

            .card-top,
            .meta-grid {
                grid-template-columns: 1fr;
            }

            .card-top {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <main class="page-shell">
        <section class="hero">
            <div>
                <p class="eyebrow">Panel DRIC</p>
                <h1>Paginas del sitio</h1>
                <p>Administra la informacion general y entra directo al contenido editable de cada seccion publica.</p>
            </div>

            @if ($isAdmin)
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Crear pagina</a>
            @endif
        </section>

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        <section class="summary" aria-label="Resumen de paginas">
            <div class="summary-card">
                <span>Pagina actual</span>
                <strong>{{ $pages->count() }}</strong>
            </div>
            <div class="summary-card">
                <span>Publicadas visibles</span>
                <strong>{{ $pages->getCollection()->where('status', 'published')->count() }}</strong>
            </div>
            <div class="summary-card">
                <span>Con pagina superior</span>
                <strong>{{ $pages->getCollection()->filter(fn ($page) => $page->parent_id)->count() }}</strong>
            </div>
        </section>

        @if ($pages->count())
            @foreach ($groupedPages as $groupKey => $items)
                <section class="group">
                    <div class="group-header">
                        <div>
                            <h2>{{ $groupTitle($groupKey) }}</h2>
                            <p>{{ $groupKey === '__root' ? 'Secciones base del sitio.' : 'Subpaginas relacionadas con esta seccion.' }}</p>
                        </div>
                        <span class="count-pill">{{ $items->count() }} {{ $items->count() === 1 ? 'pagina' : 'paginas' }}</span>
                    </div>

                    <div class="page-grid">
                        @foreach ($items as $page)
                            @php
                                $link = $contentLink($page);
                                $statusClass = 'status-'.$page->status;
                            @endphp

                            <article class="page-card">
                                <div class="card-top">
                                    <div>
                                        <span class="page-id">ID {{ $page->id }} · Orden {{ $page->sort_order }}</span>
                                        <h3>{{ $pageTitle($page) }}</h3>
                                        <span class="slug">{{ $page->slug }}</span>
                                    </div>
                                    <span class="status {{ $statusClass }}">{{ $statusLabels[$page->status] ?? $page->status }}</span>
                                </div>

                                <div class="meta-grid">
                                    <div class="meta">
                                        <span>Tipo</span>
                                        <strong>{{ $pageTypeLabels[$page->page_type] ?? $page->page_type }}</strong>
                                    </div>
                                    <div class="meta">
                                        <span>Pagina superior</span>
                                        <strong>{{ $page->parent ? $pageTitle($page->parent) : 'Sin pagina superior' }}</strong>
                                    </div>
                                    <div class="meta">
                                        <span>Publicacion</span>
                                        <strong>{{ $page->published_at ? $page->published_at->format('Y-m-d H:i') : 'Sin fecha' }}</strong>
                                    </div>
                                    <div class="meta">
                                        <span>Identificador</span>
                                        <strong>{{ $page->slug }}</strong>
                                    </div>
                                </div>

                                <div class="actions">
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-edit">Editar pagina</a>
                                    @if ($link)
                                        <a href="{{ $link[0] }}" class="btn btn-content">{{ $link[1] }}</a>
                                    @endif
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach

            <div class="pagination">
                {{ $pages->links('admin.partials.pagination') }}
            </div>
        @else
            <div class="empty">
                Todavia no hay paginas registradas.
            </div>
        @endif
    </main>
</body>
</html>
