@if ($paginator->hasPages())
    <style>
        .admin-pagination {
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-end;
            margin-top: 24px;
        }

        .admin-pagination__item {
            align-items: center;
            background: #fff;
            border: 1px solid #d7dce5;
            border-radius: 8px;
            color: #1f2937;
            display: inline-flex;
            font-size: 14px;
            font-weight: 700;
            justify-content: center;
            min-height: 36px;
            min-width: 36px;
            padding: 8px 12px;
            text-decoration: none;
        }

        .admin-pagination__item:hover {
            border-color: #164194;
            color: #164194;
        }

        .admin-pagination__item.is-active {
            background: #164194;
            border-color: #164194;
            color: #fff;
        }

        .admin-pagination__item.is-disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .admin-pagination__summary {
            color: #6b7280;
            font-size: 13px;
            margin-right: auto;
        }

        @media (max-width: 640px) {
            .admin-pagination {
                justify-content: center;
            }

            .admin-pagination__summary {
                flex-basis: 100%;
                margin-right: 0;
                text-align: center;
            }
        }
    </style>

    <nav class="admin-pagination" role="navigation" aria-label="Paginación">
        <span class="admin-pagination__summary">
            Mostrando {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} de {{ $paginator->total() }}
        </span>

        @if ($paginator->onFirstPage())
            <span class="admin-pagination__item is-disabled">Anterior</span>
        @else
            <a class="admin-pagination__item" href="{{ $paginator->previousPageUrl() }}" rel="prev">Anterior</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="admin-pagination__item is-disabled">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="admin-pagination__item is-active" aria-current="page">{{ $page }}</span>
                    @else
                        <a class="admin-pagination__item" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="admin-pagination__item" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente</a>
        @else
            <span class="admin-pagination__item is-disabled">Siguiente</span>
        @endif
    </nav>
@endif
