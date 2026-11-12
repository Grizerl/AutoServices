@extends('layouts.auto_layouts')

@section('title', 'Автосервіс - Car Services and Mechanic')
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
                        <button class="btn-st-car" type="submit">Click here</button>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car2.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6 AMT Auto</h3>
                        <h1 class="car-price">3150$ <span class="old-price">2950$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <button  class="btn-st-car" type="submit">Click here</button>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car3.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Grand i10 Nios</h3>
                        <h1 class="car-price">650$ <span class="old-price">600$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <button  class="btn-st-car" type="submit">Click here</button>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car4.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Aura BS6</h3>
                        <h1 class="car-price">1100$ <span class="old-price">950$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <button  class="btn-st-car" type="submit">Click here</button>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car5.jpg" alt="">
                    <div>
                        <h2 class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6</h3>
                        <h1 class="car-price">1830$<span class="old-price">1700$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <button  class="btn-st-car" type="submit">Click here</button>
                    </div>
                </div>
                <div class="shop-car-card-container">
                    <img src="/assets/auto sale/car6.jpg" alt="">
                    <div>
                        <h2  class="car-brand">SANTRO</h2>
                        <h3 class="car-model">Model - Santro BS6</h3>
                        <h1 class="car-price">2000$ <span class="old-price">1550$</span></h1>
                        <p class="car-description">Get Exchange bonus up to worth $ 20,000/-</p>
                        <button  class="btn-st-car" type="submit">Click here</button>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section> 
<!-- Contact info section -->
   <div class="aside-container-main-info">
      <div class="container">
         <div class="gc-3">
            <div class="aside-content-info">
            <i class="fa-solid fa-map-location-dot fa-icon-info"></i>
            <div>
               <h3 class="aside-container-title">ADDRESS:</h3>
               <p class="aside-container-info">Mulatol Pakar Matha, Dhaka Bus<br> Stand Road, 5400</p>
            </div>
            </div>
            <div class="aside-content-info">
            <i class="fa-solid fa-phone-volume fa-icon-info"></i>
            <div>
               <h3 class="aside-container-title">PHONES:</h3>
               <p class="aside-container-info">
                  <a style="color:#fff" href="tel:0950660959">+380 95 066 09 59</a>
                  <a style="color:#fff; margin-left:10px;" href="tel:0950650385">+380 95 065 03 85</a>
                  <br>
                  <a style="color:#fff" href="tel:0950564505">+380 95 056 46 05</a>
               </p>
            </div>
            </div>
            <div class="aside-content-info">
            <i class="fa-solid fa-calendar-check fa-icon-info"></i>
            <div>
               <h3 class="aside-container-title">WORKING TIME:</h3>
               <p class="aside-container-info">Monday–Saturday: 08:00–18:00;<br> Friday - Closed</p>
            </div>
            </div>
         </div>
      </div>
   </div>
   @if ($errors->any())
       <div class="alert alert-danger">
           <ul>
               @foreach ($errors->all() as $error)
                   <li>{{ $error }}</li>
               @endforeach
           </ul>
       </div>
   @endif
</section>
@endsection