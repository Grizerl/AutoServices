@extends('layouts.auto_layouts')

@section('title', $car->title.' '.$car->year.' - Cars for Sale - Auto Service')
@section('body-class', 'page-car')

@section('content')
@php($sold = $car->status === \App\Models\Car::STATUS_SOLD)
<div class="wrapper">
   <x-page-banner :title="$car->title" :crumbs="[['Cars for sale', route('offer')], [$car->title]]" />

   <section class="car-detail">
      <div class="container">
         <a class="back-link" href="{{ route('offer') }}"><i class="fa-solid fa-arrow-left"></i> Back to all cars</a>

         <div class="car-detail__grid">
            <div class="car-detail__media" data-animate="fade-right">
               <img src="{{ $car->image_url }}" alt="{{ $car->title }}">
               <span class="car-card__badges">
                  @if ($car->status !== \App\Models\Car::STATUS_AVAILABLE)
                     <span class="badge-pill badge-pill--{{ $car->status }}">{{ $car->status_label }}</span>
                  @endif
                  @if ($car->discount_percent)
                     <span class="badge-pill badge-pill--deal">-{{ $car->discount_percent }}%</span>
                  @endif
               </span>
            </div>

            <div class="car-detail__info" data-animate="fade-left">
               <h2 class="car-detail__title">{{ $car->title }} <small>{{ $car->year }}</small></h2>

               <p class="car-detail__price">
                  <strong>${{ number_format($car->price) }}</strong>
                  @if ($car->discount_percent)
                     <s>${{ number_format($car->old_price) }}</s>
                     <span class="badge-pill badge-pill--deal">save ${{ number_format($car->old_price - $car->price) }}</span>
                  @endif
               </p>

               <dl class="spec-table">
                  <div><dt>Year</dt><dd>{{ $car->year }}</dd></div>
                  <div><dt>Mileage</dt><dd>{{ number_format($car->mileage) }} km</dd></div>
                  <div><dt>Fuel</dt><dd>{{ $car->fuel_label }}</dd></div>
                  <div><dt>Transmission</dt><dd>{{ $car->transmission_label }}</dd></div>
                  @if ($car->color)
                     <div><dt>Colour</dt><dd>{{ $car->color }}</dd></div>
                  @endif
                  <div><dt>Status</dt><dd><span class="badge-pill badge-pill--{{ $car->status }}">{{ $car->status_label }}</span></dd></div>
               </dl>

               @if ($car->description)
                  <div class="car-detail__description">
                     <h2>About this car</h2>
                     <p>{!! nl2br(e($car->description)) !!}</p>
                  </div>
               @endif

               <ul class="car-detail__perks">
                  <li><i class="fa-solid fa-screwdriver-wrench"></i> Checked by our mechanics</li>
                  <li><i class="fa-solid fa-shield-halved"></i> Written warranty on our work</li>
                  <li><i class="fa-solid fa-handshake"></i> Test drive on request</li>
               </ul>

               @unless ($sold)
                  <a class="btn-car btn-car--lg" href="#request">Request this car</a>
               @endunless
            </div>
         </div>

         {{-- request form --}}
         <div class="request-card" id="request" data-animate="fade-up">
            <div class="request-card__intro">
               <h2>{{ $sold ? 'This car has been sold' : 'Request this car' }}</h2>
               <p>
                  @if ($sold)
                     Looking for something similar? Browse our other cars below or leave a request and we will find a match for you.
                  @else
                     Leave your contact details and a manager will call you back to arrange a viewing or a test drive. No obligation.
                  @endif
               </p>
            </div>

            @if (session('success'))
               <div class="form-alert form-alert--success" role="status"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if ($errors->any() && ! $errors->has('car'))
               <div class="form-alert form-alert--error" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Please correct the highlighted fields.</div>
            @endif
            @error('car')
               <div class="form-alert form-alert--error" role="alert">{{ $message }}</div>
            @enderror

            @unless ($sold)
               <form class="request-form" action="{{ route('car.inquire', $car) }}" method="post" novalidate data-ajax data-validate>
                  @csrf
                  <div class="request-form__row">
                     <label class="field-group">
                        <span>Your name <b>*</b></span>
                        <input @class(['is-invalid' => $errors->has('name')]) type="text" name="name" value="{{ old('name') }}" required minlength="2" maxlength="60" autocomplete="name">
                        @error('name')<p class="field-error">{{ $message }}</p>@enderror
                     </label>
                     <label class="field-group">
                        <span>Phone <b>*</b></span>
                        <input @class(['is-invalid' => $errors->has('phone')]) type="tel" name="phone" value="{{ old('phone') }}" required maxlength="20" autocomplete="tel" placeholder="+380 95 066 09 59">
                        @error('phone')<p class="field-error">{{ $message }}</p>@enderror
                     </label>
                  </div>
                  <label class="field-group">
                     <span>E-mail <small>(optional)</small></span>
                     <input @class(['is-invalid' => $errors->has('email')]) type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email">
                     @error('email')<p class="field-error">{{ $message }}</p>@enderror
                  </label>
                  <label class="field-group">
                     <span>Message <small>(optional)</small></span>
                     <textarea @class(['is-invalid' => $errors->has('message')]) name="message" rows="3" maxlength="1000" placeholder="When would you like to see the car?">{{ old('message') }}</textarea>
                     @error('message')<p class="field-error">{{ $message }}</p>@enderror
                  </label>
                  <label class="check">
                     <input type="checkbox" name="consent" value="1" @checked(old('consent')) @class(['is-invalid' => $errors->has('consent')])>
                     <span>I agree to the processing of my personal data</span>
                  </label>
                  @error('consent')<p class="field-error">{{ $message }}</p>@enderror

                  <button type="submit" class="btn-car btn-car--lg">Send request</button>
               </form>
            @endunless
         </div>

         @if ($related->isNotEmpty())
            <div class="related">
               <h2 class="related__title">You may also like</h2>
               <div class="car-grid">
                  @foreach ($related as $item)
                     @include('auto.cars._card', ['car' => $item])
                  @endforeach
               </div>
            </div>
         @endif
      </div>
   </section>
</div>
@include('partials.contact-strip')
@endsection
