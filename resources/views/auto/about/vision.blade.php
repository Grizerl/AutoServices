@extends('layouts.auto_layouts')

@section('title', 'Company News & FAQ - Auto Service')
@section('body-class', 'page-news')

@push('scripts')
<script src="{{ asset('assets/js/about/about.js') }}"></script>
@endpush

@section('content')
<div class="wrapper">
   <x-page-banner title="News & FAQ" :crumbs="[['About', route('history')], ['News & FAQ']]" />

   <section class="news">
      <div class="container">
         <div class="news__head">
            <div>
               <h2 class="sn-title">LATEST NEWS</h2>
               <h3 class="sn-subtitle">Follow the Pro auto news</h3>
            </div>
            <div class="slider-nav" aria-label="News navigation">
               <button type="button" class="slider-nav__btn news-prev" aria-label="Previous news"><i class="fa-solid fa-arrow-left"></i></button>
               <button type="button" class="slider-nav__btn news-next" aria-label="Next news"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
         </div>

         <div class="swiper news-slider">
            <div class="swiper-wrapper">
               @foreach ([
                  ['September 24, 2024', 'Replace your wiper blades every season', 'We are used to driving a car until something breaks. The same goes for wiper blades: we don\'t replace them until we can no longer see through a dirty windshield. Keep an eye on your wipers and replace them every season, because safety on the road comes first!'],
                  ['September 20, 2024', 'Autumn tyre check is open', 'Cooler weather means less grip. Bring your car for a free tread depth and pressure check, and book the seasonal tyre change before the first frost to skip the queues.'],
                  ['September 12, 2024', 'New diagnostic equipment in the workshop', 'We have added a new multi-brand scanner. It reads error codes of most makes and models and lets our mechanics find hidden faults faster, so you pay only for the work that is really needed.'],
                  ['August 30, 2024', 'Monthly subscription plans are here', 'Pay a fixed amount per month and let us keep your car in shape: scheduled inspections, fluids and priority booking. Choose Basic, Standard or Premium on the Subscription page.'],
                  ['August 18, 2024', 'Check your air conditioning before summer ends', 'A weak A/C is often a sign of low refrigerant or a clogged cabin filter. Book a quick A/C check and keep your car comfortable all year round.'],
               ] as [$date, $title, $text])
                  <article class="swiper-slide news-card">
                     <span class="news-card__date"><i class="fa-regular fa-calendar"></i> {{ $date }}</span>
                     <h4 class="news-card__title">{{ $title }}</h4>
                     <p class="news-card__text">{{ $text }}</p>
                  </article>
               @endforeach
            </div>
            <div class="swiper-pagination news-pagination"></div>
         </div>
      </div>
   </section>

   <section class="faq">
      <div class="faq__inner container">
         <div class="faq__head">
            <h2 class="faq__title">F.A.Q.</h2>
            <p class="faq__subtitle">Answers to the questions our customers ask most often.</p>
         </div>

         <div class="faq__list" data-faq>
            @foreach ([
               ['How often should wiper blades be replaced?', 'We are used to driving a car until something breaks. The same goes for wiper blades: we don\'t replace them until we can no longer see through a dirty windshield. Replace them every season, because safety on the road comes first.'],
               ['How often should I change the engine oil?', 'Most cars need an oil and filter change every 10,000–15,000 km or once a year, whichever comes first. If you drive mostly in the city or in traffic, change it a little earlier. Your service book has the exact interval for your car.'],
               ['Do I need an appointment?', 'We work faster when you book: use the form on the home page or call us, and we will reserve a time for you. Urgent cases are accepted without an appointment whenever a bay is free.'],
               ['Is there a warranty on repairs and parts?', 'Yes. Every job and every installed part is covered by a written warranty. If the same problem comes back, we fix it free of charge. Warranty terms are written in your work order.'],
               ['How long does a diagnostic take?', 'A standard computer diagnostic takes about 30–40 minutes. If it shows a problem, the mechanic explains it, gives you a price and starts only after you agree.'],
            ] as $i => [$question, $answer])
               <details class="faq-item" @if ($i === 0) open @endif>
                  <summary class="faq-item__question">
                     <span>{{ $question }}</span>
                     <span class="faq-item__icon" aria-hidden="true"></span>
                  </summary>
                  <div class="faq-item__answer"><p>{{ $answer }}</p></div>
               </details>
            @endforeach
         </div>

         <div class="faq__cta">
            <a class="btn-car btn-car--lg" href="{{ route('contacts') }}#ask-question">Ask a question</a>
         </div>
      </div>
   </section>
</div>
@endsection
