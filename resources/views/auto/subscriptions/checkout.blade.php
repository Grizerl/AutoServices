@extends('layouts.auto_layouts')

@section('title', 'Subscribe to '.$plan->name.' - Auto Service')
@section('body-class', 'page-plan')

@section('content')
@php($selected = old('billing_period', $period))
<div class="wrapper">
   <x-page-banner title="Subscribe" :crumbs="[['Subscription', route('plan')], [$plan->name]]" />

   <section class="checkout" id="checkout">
      <div class="container">
         <a class="back-link" href="{{ route('plan', ['period' => $selected]) }}"><i class="fa-solid fa-arrow-left"></i> Back to plans</a>

         <div class="checkout__grid">
            <aside class="checkout__summary">
               <div class="plan-card__icon"><i class="fa-solid {{ $plan->icon }}"></i></div>
               <h2>{{ $plan->name }}</h2>
               @if ($plan->description)<p class="plan-card__desc">{{ $plan->description }}</p>@endif

               <ul class="feature-list">
                  @foreach ($plan->feature_list as $feature)
                     <li class="is-included"><i class="fa-solid fa-check"></i> {{ $feature }}</li>
                  @endforeach
                  @foreach ($plan->excluded_list as $feature)
                     <li class="is-excluded"><i class="fa-solid fa-xmark"></i> {{ $feature }}</li>
                  @endforeach
               </ul>
            </aside>

            <div class="checkout__form">
               <h2>Your details</h2>
               <p class="checkout__note"><i class="fa-solid fa-circle-info"></i> Nothing is charged online. After you send the request a manager will call you to confirm the start date and payment method.</p>

               @if ($errors->any())
                  <div class="form-alert form-alert--error" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Please correct the highlighted fields.</div>
               @endif

               <form action="{{ route('plan.subscribe', $plan) }}" method="post" novalidate data-ajax data-ajax-replace=".checkout__form" data-validate>
                  @csrf

                  <fieldset class="period-picker">
                     <legend>Billing period</legend>
                     @foreach (\App\Models\Subscription::PERIODS as $key => $label)
                        <label @class(['period-option', 'is-selected' => $selected === $key])>
                           <input type="radio" name="billing_period" value="{{ $key }}" @checked($selected === $key)>
                           <span class="period-option__label">{{ $label }}</span>
                           <span class="period-option__price">${{ number_format($plan->priceFor($key)) }}<small>/ {{ $key === 'yearly' ? 'year' : 'month' }}</small></span>
                           @if ($key === 'yearly' && $plan->yearly_saving_percent > 0)
                              <span class="period-option__save">Save {{ $plan->yearly_saving_percent }}%</span>
                           @endif
                        </label>
                     @endforeach
                     @error('billing_period')<p class="field-error">{{ $message }}</p>@enderror
                  </fieldset>

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
                  <div class="request-form__row">
                     <label class="field-group">
                        <span>E-mail <small>(optional)</small></span>
                        <input @class(['is-invalid' => $errors->has('email')]) type="email" name="email" value="{{ old('email') }}" maxlength="255" autocomplete="email">
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                     </label>
                     <label class="field-group">
                        <span>Your car <b>*</b></span>
                        <input @class(['is-invalid' => $errors->has('car')]) type="text" name="car" value="{{ old('car') }}" required minlength="2" maxlength="120" placeholder="e.g. Toyota Camry 2015">
                        @error('car')<p class="field-error">{{ $message }}</p>@enderror
                     </label>
                  </div>
                  <label class="field-group">
                     <span>Notes <small>(optional)</small></span>
                     <textarea @class(['is-invalid' => $errors->has('notes')]) name="notes" rows="3" maxlength="1000" placeholder="Preferred start date, questions...">{{ old('notes') }}</textarea>
                     @error('notes')<p class="field-error">{{ $message }}</p>@enderror
                  </label>

                  <label class="check">
                     <input type="checkbox" name="consent" value="1" @checked(old('consent')) @class(['is-invalid' => $errors->has('consent')])>
                     <span>I agree to the processing of my personal data</span>
                  </label>
                  @error('consent')<p class="field-error">{{ $message }}</p>@enderror

                  <button type="submit" class="btn-car btn-car--lg">Send subscription request</button>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>
@include('partials.contact-strip')
@endsection
