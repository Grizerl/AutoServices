@if ($paginator->hasPages())
  <nav class="pager" role="navigation" aria-label="Pagination">
    @if ($paginator->onFirstPage())
      <span class="pager__item is-disabled" aria-disabled="true"><i class="fa-solid fa-chevron-left"></i></span>
    @else
      <a class="pager__item" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page"><i class="fa-solid fa-chevron-left"></i></a>
    @endif

    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="pager__item is-disabled">{{ $element }}</span>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="pager__item is-active" aria-current="page">{{ $page }}</span>
          @else
            <a class="pager__item" href="{{ $url }}" aria-label="Go to page {{ $page }}">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <a class="pager__item" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page"><i class="fa-solid fa-chevron-right"></i></a>
    @else
      <span class="pager__item is-disabled" aria-disabled="true"><i class="fa-solid fa-chevron-right"></i></span>
    @endif
  </nav>
@endif
