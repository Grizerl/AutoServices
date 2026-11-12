@extends('layouts.auto_layouts')

@section('title', 'Cars for Sale - Auto Service')
@section('body-class', 'page-offer')


@section('content')

<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">Offer</h2>
         <div>
            <ul class="container-nav-item">
               <li>
                  <a class="cont-list" href="{{ route('home_auto') }}">Home</a>
               </li>
               <li class="cont-list">
                    <i class="fas fa-angle-right"></i>
                </li>
               <li>
                  <a class="cont-list">Offer</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
<section>
    <div class="sn-offer-media-container">
        <div class="container">
            <div class="sn-title-container">
            <h2 class="sn-title">BIG OFFER</h2>
            <h3 class="sn-subtitle">Car Discount <span class="sn-discount">15%</span>Offers</h3>
            </div>
            <div class="shop_header">
                <div class="shop_container">
                    <div class="shop_content">
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car1.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6</h3>
                        <h1 class="car-price">9500$ <span class="old-price">9500$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <a class="btn-st-car" href="{{ route('home_auto') }}#contacts">Click here</a>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car2.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6 AMT Auto</h3>
                        <h1 class="car-price">3150$ <span class="old-price">2950$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <a class="btn-st-car" href="{{ route('home_auto') }}#contacts">Click here</a>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car3.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Grand i10 Nios</h3>
                        <h1 class="car-price">650$ <span class="old-price">600$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <a class="btn-st-car" href="{{ route('home_auto') }}#contacts">Click here</a>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car4.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Aura BS6</h3>
                        <h1 class="car-price">1100$ <span class="old-price">950$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <a class="btn-st-car" href="{{ route('home_auto') }}#contacts">Click here</a>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car5.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6</h3>
                        <h1 class="car-price">1830$<span class="old-price">1700$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <a class="btn-st-car" href="{{ route('home_auto') }}#contacts">Click here</a>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car6.jpg" alt="">
                    <div>
                        <h2  class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6</h3>
                        <h1 class="car-price">2000$ <span class="old-price">1550$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <a class="btn-st-car" href="{{ route('home_auto') }}#contacts">Click here</a>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('partials.contact-strip')
@endsection