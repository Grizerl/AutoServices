@extends('layouts.auto_layouts')

@section('title', 'Company News & FAQ - Auto Service')
@section('body-class', 'page-news')

@push('scripts')
<script src="{{ asset('assets/js/about/about.js') }}"></script>
@endpush


@section('content')
<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">News</h2>
         <div>
            <ul class="container-nav-item">
               <li>
                  <a  class="cont-list" href="{{ route('home_auto') }}">Home</a>
               </li>
               <li  class="cont-list"><i class="fas fa-angle-right"></i></li>
               <li>
                  <a  class="cont-list">Company news</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
<section>
   <div>
      <div class="container">
         <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; ">
         <h1 class="section-about-news-title">NEWS</h1>
         <p class="section-about-news-subtitle">Follow the Pro auto news</p>
         </div>
         <div class="swiper-news-container">
            <img src="/assets/images/disc.png" alt="Car disc">
            <!--  -->
            <div class="swiper-3 mySwiper-3">
               <div class="swiper-wrapper">
                  <div class="swiper-slide sw-3">
                  <h3 class="date-sw-slide">September 24, 2024</h3>
                  <p class="text-sw-slide">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we can no longer see through a dirty windshield. Keep an eye on your wipers and replace them every season, because safety on the road comes first!</p></div>
                  <div class="swiper-slide sw-3">
                  <h3 class="date-sw-slide">September 20, 2024</h3>
                  <p class="text-sw-slide">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we can no longer see through a dirty windshield. Keep an eye on your wipers and replace them every season, because safety on the road comes first!</p></div>
               </div>
            </div>
            <div>
               <div class="swiper-button-next"></div>
               <div class="swiper-button-prev"></div>
            </div>
         </div>
      </div>
   </div>
</section>
<section style="margin-top: 5vh;">
<div>
    <div class="backround-images">
        <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; ">
            <h1 class="section-faq-title">F. A. Q</h1>
            <span class="section-faq-subtitle">This section answers the questions our customers ask most often.</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; ">
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">How often should wiper blades be replaced?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we <br> can no longer see through a dirty windshield. Keep an eye on your wipers and replace <br> them every season, because safety on the road comes first!</p>
            </div>
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">How often should wiper blades be replaced?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we <br> can no longer see through a dirty windshield. Keep an eye on your wipers and replace <br> them every season, because safety on the road comes first!</p>
            </div>
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">How often should wiper blades be replaced?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we <br> can no longer see through a dirty windshield. Keep an eye on your wipers and replace <br> them every season, because safety on the road comes first!</p>
            </div>
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">How often should wiper blades be replaced?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we <br> can no longer see through a dirty windshield. Keep an eye on your wipers and replace <br> them every season, because safety on the road comes first!</p>
            </div>
            <div class="header-hidden-container hd-cont-hidden">
               <div class="main-hidden-container">
                <h3 class="title-hidden">How often should wiper blades be replaced?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">We are used to driving a car until something breaks. The same goes for wiper blades: we don't replace them until we <br> can no longer see through a dirty windshield. Keep an eye on your wipers and replace <br> them every season, because safety on the road comes first!</p>
            </div>
            <div style="margin-bottom: 5vh;">
               <a class="according-psevdo-btn" href="{{route('contacts')}}">ASK A QUESTION</a>
            </div>
        </div>
    </div>
</div>
@endsection
