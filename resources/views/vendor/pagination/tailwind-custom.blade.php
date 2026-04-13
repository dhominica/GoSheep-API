@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-400 bg-white border border-slate-200 cursor-default leading-5 rounded-lg shadow-sm">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 bg-white border border-slate-200 leading-5 rounded-lg shadow-sm hover:text-green-600 hover:border-green-300 focus:outline-none focus:ring-2 ring-green-500/20 active:bg-slate-50 transition ease-in-out duration-150">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-semibold text-slate-700 bg-white border border-slate-200 leading-5 rounded-lg shadow-sm hover:text-green-600 hover:border-green-300 focus:outline-none focus:ring-2 ring-green-500/20 active:bg-slate-50 transition ease-in-out duration-150">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-semibold text-slate-400 bg-white border border-slate-200 cursor-default leading-5 rounded-lg shadow-sm">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-slate-500 leading-5 font-semibold">
                    Menampilkan
                    <span class="font-bold text-slate-800">{{ $paginator->firstItem() }}</span>
                    hingga
                    <span class="font-bold text-slate-800">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-bold text-slate-800">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-lg">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-slate-300 bg-white border border-slate-200 cursor-default rounded-l-lg leading-5" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2.5 py-2 text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-l-lg leading-5 hover:bg-slate-50 hover:text-green-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-3.5 py-2 -ml-px text-sm font-medium text-slate-500 bg-white border border-slate-200 cursor-default leading-5">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page">
                                        <span class="relative inline-flex items-center px-3.5 py-2 -ml-px text-sm font-bold text-green-700 bg-green-50 border border-green-200 cursor-default leading-5 z-10">{{ $page }}</span>
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-3.5 py-2 -ml-px text-sm font-semibold text-slate-600 bg-white border border-slate-200 leading-5 hover:bg-slate-50 hover:text-green-600 focus:z-10 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition ease-in-out duration-150 " aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2.5 py-2 -ml-px text-sm font-medium text-slate-600 bg-white border border-slate-200 rounded-r-lg leading-5 hover:bg-slate-50 hover:text-green-600 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 transition ease-in-out duration-150" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2.5 py-2 -ml-px text-sm font-medium text-slate-300 bg-white border border-slate-200 cursor-default rounded-r-lg leading-5" aria-hidden="true">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
