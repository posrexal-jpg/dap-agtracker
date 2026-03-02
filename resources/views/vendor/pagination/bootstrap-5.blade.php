@if ($paginator->hasPages())
<div class="d-flex flex-column align-items-center gap-2 mt-3">

    {{-- Page info --}}
    <p class="text-muted small mb-0">
        Showing <strong>{{ $paginator->firstItem() }}</strong> to <strong>{{ $paginator->lastItem() }}</strong> of <strong>{{ $paginator->total() }}</strong> results
    </p>

    {{-- Mobile: Prev | Page X of Y | Next --}}
    <div class="d-flex d-md-none align-items-center gap-2">
        @if ($paginator->onFirstPage())
            <button class="btn btn-outline-secondary btn-sm" disabled>&laquo; Prev</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-primary btn-sm" rel="prev">&laquo; Prev</a>
        @endif

        <span class="text-muted small px-2">Page <strong>{{ $paginator->currentPage() }}</strong> of <strong>{{ $paginator->lastPage() }}</strong></span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-primary btn-sm" rel="next">Next &raquo;</a>
        @else
            <button class="btn btn-outline-secondary btn-sm" disabled>Next &raquo;</button>
        @endif
    </div>

    {{-- Desktop: full page number list --}}
    <ul class="pagination pagination-sm mb-0 d-none d-md-flex">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">&laquo;</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page">
                            <span class="page-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">&raquo;</span>
            </li>
        @endif

    </ul>
</div>
@endif
