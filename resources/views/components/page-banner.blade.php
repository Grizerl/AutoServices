@props(['title', 'crumbs' => [], 'subtitle' => null])

{{-- Page banner: title + breadcrumbs. $crumbs = [['Label', url|null], ...]; the last item is the current page. --}}
<div class="banner-area">
  <div class="banner-area__inner">
    <h1 class="banner-title">{{ $title }}</h1>
    @if ($subtitle)
      <p class="banner-subtitle">{{ $subtitle }}</p>
    @endif

    @if (count($crumbs))
      <nav class="crumbs" aria-label="Breadcrumb">
        <ol class="crumbs__list" itemscope itemtype="https://schema.org/BreadcrumbList">
          <li class="crumbs__item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a href="{{ route('home_auto') }}" itemprop="item"><i class="fa-solid fa-house"></i><span itemprop="name">Home</span></a>
            <meta itemprop="position" content="1">
          </li>
          @foreach ($crumbs as $i => $crumb)
            @php([$label, $url] = [$crumb[0], $crumb[1] ?? null])
            <li class="crumbs__item @if ($loop->last) is-current @endif" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"
                @if ($loop->last) aria-current="page" @endif>
              @if (! $loop->last && $url)
                <a href="{{ $url }}" itemprop="item"><span itemprop="name">{{ $label }}</span></a>
              @else
                <span itemprop="name">{{ $label }}</span>
              @endif
              <meta itemprop="position" content="{{ $i + 2 }}">
            </li>
          @endforeach
        </ol>
      </nav>
    @endif
  </div>
</div>
