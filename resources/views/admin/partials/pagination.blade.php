@if ($paginator->hasPages())
    <nav class="pagination" aria-label="Pagination">

        @if ($paginator->onFirstPage())
            <span class="is-disabled">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
        @endif

        <span class="is-current">Page {{ $paginator->currentPage() }} of {{ $paginator->lastPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
        @else
            <span class="is-disabled">Next</span>
        @endif

    </nav>
@endif
