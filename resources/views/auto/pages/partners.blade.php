@extends('layouts.auto_layouts')

@section('title', 'Partners - Auto Service')
@section('body-class', 'page-partners')

@section('content')
<div class="wrapper">
   <x-page-banner title="Partners" :crumbs="[['About', route('history')], ['Partners']]" />

   <section class="licenses">
      <div class="container">
         <div class="sn-title-container">
            <h2 class="sn-title">OFFICIAL STATUS</h2>
            <h3 class="sn-subtitle">Licenses &amp; certificates</h3>
            <p class="catalog__lead">We buy oils and materials directly from the manufacturers, so you always get genuine products with a warranty.</p>
         </div>

         <div class="license-grid">
            @foreach (['ELF', 'Moly', 'Castrol', 'Shell', 'Mobil', 'Motul'] as $brand)
               <article class="license-card">
                  <span class="license-card__icon"><i class="fa-solid fa-certificate"></i></span>
                  <img src="{{ asset('assets/partners/charter.png') }}" alt="{{ $brand }} certificate" loading="lazy">
                  <h4>{{ $brand }}</h4>
                  <p>Official distributor of {{ $brand }} materials</p>
               </article>
            @endforeach
         </div>
      </div>
   </section>

   <section class="partner-brands">
      <div class="container">
         <div class="sn-title-container sn-title-container--light">
            <h2 class="sn-title">TRUSTED BY US</h2>
            <h3 class="sn-subtitle">Our partners</h3>
            <p class="catalog__lead">Quality parts and equipment from companies we have worked with for years.</p>
         </div>

         <div class="partner-grid">
            @foreach ([
               ['ArmTek', 'ArmTek.png', 'ARMTEK'],
               ['Sachs', 'Sachs.png', 'Sachs'],
               ['Kyb', 'Kyb.png', 'Kyb'],
               ['SMotor', 'Smotor.png', 'SMotor'],
               ['AvtoExpert', 'avtoExperet.png', 'AvtoExpert'],
               ['Smile', 'Smile.png', 'Smile'],
            ] as [$alt, $file, $name])
               <article class="partner-card">
                  <div class="partner-card__logo">
                     <img src="{{ asset('assets/partners/partners-company/'.$file) }}" alt="{{ $alt }} logo" loading="lazy">
                  </div>
                  <h4>{{ $name }}</h4>
               </article>
            @endforeach
         </div>

         <div class="partner-cta">
            <h3>Want to become our partner?</h3>
            <p>Tell us about your company and we will get back to you.</p>
            <a class="btn-car btn-car--lg" href="{{ route('contacts') }}#ask-question">Contact us</a>
         </div>
      </div>
   </section>
</div>
@endsection
