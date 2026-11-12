@extends('layouts.auto_layouts')

@section('title', 'Автосервіс - Car Services and Mechanic')
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
         <h1 class="section-about-news-title">НОВИНИ</h1>
         <p class="section-about-news-subtitle">Слідкуйте за новинами Pro auto</p>
         </div>
         <div class="swiper-news-container">
            <img src="/assets/images/disc.png" alt="Car disc">
            <!--  -->
            <div class="swiper-3 mySwiper-3">
               <div class="swiper-wrapper">
                  <div class="swiper-slide sw-3">
                  <h3 class="date-sw-slide">24 вересня 2024 року</h3>
                  <p class="text-sw-slide">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками та змінюйте їх кожен сезон, адже безпека на дорозі понад усе!</p></div>
                  <div class="swiper-slide sw-3">
                  <h3 class="date-sw-slide">20 вересня 2024 року</h3>
                  <p class="text-sw-slide">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками та змінюйте їх кожен сезон, адже безпека на дорозі понад усе!</p></div>
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
            <span class="section-faq-subtitle">У даному розділі наведені відповіді на запитання наших клієнтів.</span>
        </div>
        <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; ">
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">Як часто потрібно міняти щітки склоочисника?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім <br> не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками і змінюйте <br> їх на кожен сезон, адже безпека на дорозі понад усе!</p>
            </div>
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">Як часто потрібно міняти щітки склоочисника?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім <br> не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками і змінюйте <br> їх на кожен сезон, адже безпека на дорозі понад усе!</p>
            </div>
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">Як часто потрібно міняти щітки склоочисника?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім <br> не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками і змінюйте <br> їх на кожен сезон, адже безпека на дорозі понад усе!</p>
            </div>
            <div class="header-hidden-container">
               <div class="main-hidden-container">
                <h3 class="title-hidden">Як часто потрібно міняти щітки склоочисника?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім <br> не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками і змінюйте <br> їх на кожен сезон, адже безпека на дорозі понад усе!</p>
            </div>
            <div class="header-hidden-container hd-cont-hidden">
               <div class="main-hidden-container">
                <h3 class="title-hidden">Як часто потрібно міняти щітки склоочисника?</h3>
                <div class="according-bth">+</div>
                </div>
                <p class="content">Ми звикли експлуатувати автомобіль, поки щось не зламається. Так і зі щітками - не замінимо, поки зовсім <br> не втратимо можливість бачити перед собою через брудне лобове скло. Слідкуйте за своїми щітками і змінюйте <br> їх на кожен сезон, адже безпека на дорозі понад усе!</p>
            </div>
            <div style="margin-bottom: 5vh;">
               <a class="according-psevdo-btn" href="{{route('contacts')}}">ЗАДАТИ ПИТАННЯ</a>
            </div>
        </div>
    </div>
</div>
@endsection
