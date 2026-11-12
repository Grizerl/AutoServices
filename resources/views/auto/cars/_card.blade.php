@php($sold = $car->status === \App\Models\Car::STATUS_SOLD)
<article @class(['car-card', 'car-card--sold' => $sold])>
  <a class="car-card__media" href="{{ route('car.show', $car) }}" tabindex="-1" aria-hidden="true">
    <img src="{{ $car->thumb_url }}" alt="{{ $car->title }}" width="640" height="480" loading="lazy" decoding="async">
    <span class="car-card__badges">
      @if ($car->status !== \App\Models\Car::STATUS_AVAILABLE)
        <span class="badge-pill badge-pill--{{ $car->status }}">{{ $car->status_label }}</span>
      @endif
      @if ($car->discount_percent)
        <span class="badge-pill badge-pill--deal">-{{ $car->discount_percent }}%</span>
      @endif
      @if ($car->is_featured && ! $sold)
        <span class="badge-pill badge-pill--featured"><i class="fa-solid fa-star"></i> Featured</span>
      @endif
    </span>
  </a>

  <div class="car-card__body">
    <h3 class="car-card__title"><a href="{{ route('car.show', $car) }}">{{ $car->title }}</a></h3>

    <ul class="car-card__specs">
      <li title="Year"><i class="fa-regular fa-calendar"></i> {{ $car->year }}</li>
      <li title="Mileage"><i class="fa-solid fa-gauge-high"></i> {{ number_format($car->mileage) }} km</li>
      <li title="Fuel"><i class="fa-solid fa-gas-pump"></i> {{ $car->fuel_label }}</li>
      <li title="Transmission"><i class="fa-solid fa-sliders"></i> {{ $car->transmission_label }}</li>
    </ul>

    <div class="car-card__footer">
      <p class="car-card__price">
        <strong>${{ number_format($car->price) }}</strong>
        @if ($car->discount_percent)
          <s>${{ number_format($car->old_price) }}</s>
        @endif
      </p>
      <a class="btn-car" href="{{ route('car.show', $car) }}">{{ $sold ? 'View' : 'View details' }}</a>
    </div>
  </div>
</article>
