@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-center py-4">
        <ul class="flex items-center space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </li>
            @else
                <li>
                    <a class="px-3 py-2 text-islamic-green bg-white border border-islamic-green rounded-lg hover:bg-islamic-green hover:text-white transition duration-150" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-gray-500 bg-gray-100 rounded-lg cursor-not-allowed">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 text-white bg-islamic-green rounded-lg">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a class="px-3 py-2 text-islamic-green bg-white border border-islamic-green rounded-lg hover:bg-islamic-green hover:text-white transition duration-150" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="px-3 py-2 text-islamic-green bg-white border border-islamic-green rounded-lg hover:bg-islamic-green hover:text-white transition duration-150" href="{{ $paginator->nextPageUrl() }}" rel="next">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                        <i class="fas fa-chevron-right"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif