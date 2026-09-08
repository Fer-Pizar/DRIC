@php
    $statusLabels = [
        'draft' => 'Borrador',
        'published' => 'Publicado',
        'archived' => 'Archivado',
    ];

    $pageTypeLabels = [
        'static' => 'Página estática',
        'page' => 'Página',
        'main' => 'Principal',
        'content' => 'Contenido',
        'legal' => 'Legal',
        'mobility_catalog' => 'Catálogo de movilidad',
    ];
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel DRIC - Páginas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
            margin: 0;
            padding: 40px;
            color: #222;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.08);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #2563eb;
            color: #fff;
        }

        .btn-secondary {
            background: #6b7280;
            color: #fff;
        }

        .btn-edit {
            background: #f59e0b;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-content {
            background: #164194;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            text-decoration: none;
        }

        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            background: #dcfce7;
            color: #166534;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: #f3f4f6;
        }

        .muted {
            color: #6b7280;
        }

        .pagination {
            margin-top: 24px;
        }

        .empty {
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            color: #6b7280;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        @media (max-width: 640px) {
            body {
                padding: 16px;
            }

            .container {
                padding: 18px;
                border-radius: 10px;
            }

            .header {
                align-items: stretch;
                flex-direction: column;
                gap: 14px;
            }

            h1 {
                font-size: 28px;
                line-height: 1.15;
            }

            .btn {
                box-sizing: border-box;
                text-align: center;
                width: 100%;
            }

            table {
                min-width: 760px;
            }

            th, td {
                padding: 10px;
                white-space: nowrap;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Páginas</h1>
            @if ($isAdmin)
                <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Crear página</a>
            @endif
        </div>

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($pages->count())
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Identificador</th>
                            <th>Tipo de página</th>
                            <th>Estado</th>
                            <th>Orden</th>
                            <th>Fecha de publicación</th>
                            <th>Página superior</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $page)
                            <tr>
                                <td>{{ $page->id }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>{{ $pageTypeLabels[$page->page_type] ?? $page->page_type }}</td>
                                <td>{{ $statusLabels[$page->status] ?? $page->status }}</td>
                                <td>{{ $page->sort_order }}</td>
                                <td>{{ $page->published_at ? $page->published_at->format('Y-m-d H:i') : '—' }}</td>
                                <td>{{ $page->parent?->slug ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('admin.pages.edit', $page) }}" class="btn-edit">Editar</a>
                                    @if ($page->slug === 'presentacion')
                                        <a href="{{ route('admin.pages.presentation.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'convenios')
                                        <a href="{{ route('admin.pages.agreements.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'convenios-otros')
                                        <a href="{{ route('admin.agreement-lists.edit', 'otros') }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'convenios-ceub-gobierno')
                                        <a href="{{ route('admin.agreement-lists.edit', 'ceub-gobierno') }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'proyectos')
                                        <a href="{{ route('admin.pages.projects.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'proyectos-apoyo-financiero')
                                        <a href="{{ route('admin.project-funding.edit') }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'becas-movilidad')
                                        <a href="{{ route('admin.pages.scholarship-hub.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'becas')
                                        <a href="{{ route('admin.pages.scholarship-becas.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'movilidad-pasantias')
                                        <a href="{{ route('admin.pages.mobility-pasantias.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'premios-eventos-cursos-concursos')
                                        <a href="{{ route('admin.pages.awards-opportunities.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'membresias')
                                        <a href="{{ route('admin.pages.memberships.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'noticias')
                                        <a href="{{ route('admin.pages.news.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'normativas')
                                        <a href="{{ route('admin.pages.normatives.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'informes-gestion')
                                        <a href="{{ route('admin.pages.reports.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'validar-certificado')
                                        <a href="{{ route('admin.pages.certificates.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'contacto')
                                        <a href="{{ route('admin.pages.contact.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                    @if ($page->slug === 'campus-life')
                                        <a href="{{ route('admin.pages.campus-life.edit', $page) }}" class="btn-content">Editar contenido</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $pages->links('admin.partials.pagination') }}
            </div>
        @else
            <div class="empty">
                Todavía no hay páginas registradas.
            </div>
        @endif
    </div>
</body>
</html>
