@extends('layouts.auto_layouts')

@section('title', 'Subscription Plans - Auto Service')
@section('body-class', 'page-plan')

@push('scripts')
<script src="{{ asset('assets/js/pricing_plan/plan.js') }}"></script>
@endpush

@section('content')
<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">Subscription Plans</h2>
         <ul class="container-nav-item">
            <li><a class="cont-list" href="{{ route('home_auto') }}">Home</a></li>
            <li class="cont-list"><i class="fas fa-angle-right"></i></li>
            <li><span class="cont-list">Subscription</span></li>
         </ul>
      </div>
   </div>

   <section class="plans" data-plans data-period="{{ $period }}">
      <div class="container">
         <div class="plans__head">
            <h2 class="sn-title">MONTHLY CAR CARE</h2>
            <h3 class="sn-subtitle">Pick a plan that fits your car</h3>
            <p class="catalog__lead">Pay a fixed amount and let us keep your car in shape: scheduled inspections, fluids and priority booking. Cancel any time.</p>

            <div class="billing-toggle" role="group" aria-label="Billing period">
               <a href="{{ route('plan', ['period' => 'monthly']) }}" data-period-btn="monthly" @class(['billing-toggle__btn', 'is-active' => $period === 'monthly']) aria-pressed="{{ $period === 'monthly' ? 'true' : 'false' }}">Monthly</a>
               <a href="{{ route('plan', ['period' => 'yearly']) }}" data-period-btn="yearly" @class(['billing-toggle__btn', 'is-active' => $period === 'yearly']) aria-pressed="{{ $period === 'yearly' ? 'true' : 'false' }}">
                  Yearly
                  @php($maxSaving = $plans->max('yearly_saving_percent'))
                  @if ($maxSaving > 0)<span class="billing-toggle__save">save up to {{ $maxSaving }}%</span>@endif
               </a>
            </div>
         </div>

         @if ($plans->isEmpty())
            <div class="empty-state">
               <i class="fa-solid fa-hourglass-half"></i>
               <h3>Plans are coming soon</h3>
               <p>We are preparing new subscription plans. Contact us and we will tell you about the options.</p>
               <a class="btn-car" href="{{ route('home_auto') }}#contacts">Contact us</a>
            </div>
         @else
            <div class="plan-grid">
               @foreach ($plans as $plan)
                  <article @class(['plan-card', 'plan-card--popular' => $plan->is_popular])>
                     @if ($plan->is_popular)
                        <span class="plan-card__ribbon">Most popular</span>
                     @endif

                     <div class="plan-card__icon"><i class="fa-solid {{ $plan->icon }}"></i></div>
                     <h3 class="plan-card__name">{{ $plan->name }}</h3>
                     @if ($plan->description)
                        <p class="plan-card__desc">{{ $plan->description }}</p>
                     @endif

                     <div class="plan-card__price">
                        <p class="price price--monthly">
                           <span class="price__amount"><sup>$</sup>{{ number_format($plan->price_monthly) }}</span>
                           <span class="price__period">/ month</span>
                        </p>
                        <p class="price price--yearly">
                           <span class="price__amount"><sup>$</sup>{{ number_format($plan->effective_yearly_price) }}</span>
                           <span class="price__period">/ year</span>
                           @if ($plan->yearly_saving_percent > 0)
                              <span class="price__note">Save {{ $plan->yearly_saving_percent }}% vs monthly</span>
                           @else
                              <span class="price__note">{{ '$'.number_format($plan->effective_yearly_price / 12, 2) }} per month</span>
                           @endif
                        </p>
                     </div>

                     <ul class="feature-list">
                        @foreach ($plan->feature_list as $feature)
                           <li class="is-included"><i class="fa-solid fa-check"></i> {{ $feature }}</li>
                        @endforeach
                        @foreach ($plan->excluded_list as $feature)
                           <li class="is-excluded"><i class="fa-solid fa-xmark"></i> {{ $feature }}</li>
                        @endforeach
                     </ul>

                     <a class="btn-plan"
                        href="{{ route('plan.checkout', ['plan' => $plan, 'period' => $period]) }}"
                        data-checkout-link
                        data-base="{{ route('plan.checkout', $plan) }}">Choose {{ $plan->name }}</a>
                  </article>
               @endforeach
            </div>

            <div class="steps">
               <div class="step">
                  <span class="step__num">1</span>
                  <h4>Choose a plan</h4>
                  <p>Pick the plan and billing period that suits you.</p>
               </div>
               <div class="step">
                  <span class="step__num">2</span>
                  <h4>Tell us about your car</h4>
                  <p>Leave your contact details and the car you drive.</p>
               </div>
               <div class="step">
                  <span class="step__num">3</span>
                  <h4>We confirm it</h4>
                  <p>A manager calls you, agrees the start date and payment method.</p>
               </div>
            </div>
         @endif
      </div>
   </section>
</div>
@include('partials.contact-strip')
@endsection
