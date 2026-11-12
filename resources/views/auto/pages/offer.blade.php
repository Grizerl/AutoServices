@extends('layouts.auto_layouts')

@section('title', 'Cars for Sale - Auto Service')
@section('body-class', 'page-offer')

@section('content')
<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">Cars for Sale</h2>
         <ul class="container-nav-item">
            <li><a class="cont-list" href="{{ route('home_auto') }}">Home</a></li>
            <li class="cont-list"><i class="fas fa-angle-right"></i></li>
            <li><span class="cont-list">Cars for sale</span></li>
         </ul>
      </div>
   </div>

   <section class="catalog">
      <div class="container">
         <div class="sn-title-container">
            <h2 class="sn-title">OUR CARS</h2>
            <h3 class="sn-subtitle">Find your next car</h3>
            <p class="catalog__lead">Every car is checked by our mechanics before it goes on sale. Found one you like? Send a request and a manager will call you back.</p>
         </div>

         <form class="catalog-filters" method="get" action="{{ route('offer') }}" aria-label="Filter cars">
            <div class="catalog-filters__grid">
               <label class="field-group field-group--wide">
                  <span>Search</span>
                  <input type="search" name="q" value="{{ $filters['q'] }}" placeholder="Brand or model" maxlength="60">
               </label>
               <label class="field-group">
                  <span>Brand</span>
                  <select name="brand">
                     <option value="">All brands</option>
                     @foreach ($brands as $brand)
                        <option value="{{ $brand }}" @selected($filters['brand'] === $brand)>{{ $brand }}</option>
                     @endforeach
                  </select>
               </label>
               <label class="field-group">
                  <span>Fuel</span>
                  <select name="fuel">
                     <option value="">Any fuel</option>
                     @foreach (\App\Models\Car::FUELS as $key => $label)
                        <option value="{{ $key }}" @selected($filters['fuel'] === $key)>{{ $label }}</option>
                     @endforeach
                  </select>
               </label>
               <label class="field-group">
                  <span>Transmission</span>
                  <select name="transmission">
                     <option value="">Any</option>
                     @foreach (\App\Models\Car::TRANSMISSIONS as $key => $label)
                        <option value="{{ $key }}" @selected($filters['transmission'] === $key)>{{ $label }}</option>
                     @endforeach
                  </select>
               </label>
               <label class="field-group">
                  <span>Max price, $</span>
                  <input type="number" name="max_price" value="{{ $filters['max_price'] }}" min="1" step="500" placeholder="e.g. 10000">
               </label>
               <label class="field-group">
                  <span>Sort by</span>
                  <select name="sort">
                     @foreach (\App\Models\Car::SORTS as $key => $label)
                        <option value="{{ $key }}" @selected($filters['sort'] === $key)>{{ $label }}</option>
                     @endforeach
                  </select>
               </label>
            </div>
            <div class="catalog-filters__actions">
               <label class="check">
                  <input type="checkbox" name="status" value="available" @checked($filters['status'] === 'available')>
                  <span>Available only</span>
               </label>
               <div>
                  <button type="submit" class="btn-car">Apply filters</button>
                  @if ($hasFilters || $filters['sort'] !== 'newest')
                     <a class="btn-car btn-car--ghost" href="{{ route('offer') }}">Reset</a>
                  @endif
               </div>
            </div>
         </form>

         <p class="catalog__count" aria-live="polite">
            @if ($cars->total())
               Showing {{ $cars->firstItem() }}–{{ $cars->lastItem() }} of {{ $cars->total() }} {{ \Illuminate\Support\Str::plural('car', $cars->total()) }}
            @endif
         </p>

         @if ($cars->count())
            <div class="car-grid">
               @foreach ($cars as $car)
                  @include('auto.cars._card', ['car' => $car])
               @endforeach
            </div>

            {{ $cars->links('partials.pagination') }}
         @else
            <div class="empty-state">
               <i class="fa-solid fa-car-burst"></i>
               <h3>{{ $hasFilters ? 'No cars match your filters' : 'No cars for sale right now' }}</h3>
               <p>{{ $hasFilters ? 'Try removing some filters or searching for a different brand.' : 'New cars are added regularly. Leave us a request and we will let you know when something suitable arrives.' }}</p>
               <a class="btn-car" href="{{ $hasFilters ? route('offer') : route('home_auto').'#contacts' }}">{{ $hasFilters ? 'Clear filters' : 'Contact us' }}</a>
            </div>
         @endif
      </div>
   </section>
</div>
@include('partials.contact-strip')
@endsection
