@if ($paginator->hasPages())
    <nav class="d-flex justify-content-center py-4">
        <ul class="pagination flex-wrap justify-content-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        <i class="fas fa-arrow-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link px-4 py-2 text-islamic-green bg-white border border-islamic-green rounded-lg hover:bg-islamic-green hover:text-white transition duration-150" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link px-4 py-2 text-islamic-green bg-white border border-islamic-green rounded-lg hover:bg-islamic-green hover:text-white transition duration-150" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link px-4 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        <i class="fas fa-arrow-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif