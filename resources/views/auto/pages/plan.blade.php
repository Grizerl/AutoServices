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
         <h2 class="sc-ttl-cont">Pricing plan</h2>
         <div>
            <ul class="container-nav-item">
               <li>
                  <a  class="cont-list" href="{{ route('home_auto') }}">Home</a>
               </li>
               <li  class="cont-list"><i class="fas fa-angle-right"></i></li>
               <li>
                  <a  class="cont-list">Price</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
<section class="section-header">
<div>
     <div class="container">
        <div class="section-element-title-conteiner">
            <h2 class="title-element">Price</h2>
            <!--  -->
            <!--  -->
            <h3 class="subtitle-element">System Plan</h3>
        </div>
        <div class="section-element-navbar-conteiner">
            <ul class="section-element-nav">
                <li class="element-nav-item">
                    <a data-plan-tab="silver" href="#" id="btn-silver-plan" class="element-nav-link" ><strong>Silver Package</strong></a>
                </li>
                <li class="element-nav-item">
                    <a data-plan-tab="platinum" href="#" id="btn-platinum-plan" class="element-nav-link active" ><strong>Platinum Package</strong></a>
                </li>
                <li class="element-nav-item">
                    <a data-plan-tab="gold" href="#" id="btn-gold-plan" class="element-nav-link" ><strong>Gold Package</strong></a>
                </li>
            </ul>
        </div>
        <div>
        <div data-plan-panel="silver" id="card-silver" class="section-card-list-pricing">
            <div class="section-card-list-pricing-plan-content">
                <div  class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-snowflake"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Basic Plan </h4>
                    <!--  -->
                    <!--  -->
                    <h6>58$</h6>
                    <!--  -->
                    <h5><span>$</span>12.99<span>/m</span></h5>
                    <!--  -->
                    <div class="conditions-part">
                        <ul>
                            <li>
                                <a >Conventional Oil Change <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Visual Brake Inspection <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Transmission Fluid Service <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Fuel System Cleaning <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Battery Check <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Tire Rotation <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-regular fa-money-bill-1"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Advance Plan </h4>
                    <!--  -->
                    <!--  -->
                    <h6>80$</h6>
                    <!--  -->
                    <h5><span>$</span>29.99<span>/m</span></h5>
                    <!--  -->
                    <div  class="conditions-part">
                        <ul>
                            <li>
                                <a >Conventional Oil Change <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Visual Brake Inspection <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Transmission Fluid Service <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Fuel System Cleaning <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Battery Check <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Tire Rotation <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-star"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Premium Plan</h4>
                    <!--  -->
                    <!--  -->
                    <h6>120$</h6>
                    <!--  -->
                    <h5><span>$</span>63.99<span>/m</span></h5>
                    <!--  -->
                    <div  class="conditions-part">
                        <ul>
                            <li>
                                <a >Conventional Oil Change <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Visual Brake Inspection <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Transmission Fluid Service <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Fuel System Cleaning <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Battery Check <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Tire Rotation <i class="fa-solid fa-check"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
            </div>
        </div>
            <!--  -->
        <div data-plan-panel="platinum" id="card-platinum" class="section-card-list-pricing show">
           <div class="section-card-list-pricing-plan-content">
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-fire"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Basic Plan </h4>
                    <!--  -->
                    <!--  -->
                    <h6>125$</h6>
                    <!--  -->
                    <h5><span>$</span>80.99<span>/m</span></h5>
                    <!--  -->
                    <div class="conditions-part">
                        <ul>
                            <li>
                                <a >Belts and Hoses <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Suspension and Shock Absorbers <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Transmission Fluid Service <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Fuel System Cleaning <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Exhaust System <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Interior Components <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-bolt"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Advance Plan </h4>
                    <!--  -->
                    <!--  -->
                    <h6>250$</h6>
                    <!--  -->
                    <h5><span>$</span>200.99<span>/m</span></h5>
                    <!--  -->
                    <div  class="conditions-part">
                        <ul>
                            <li>
                                <a >Belts and Hoses <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Suspension and Shock Absorbers <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Transmission Fluid Service <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Fuel System Cleaning <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Exhaust System <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Interior Components <i class="fa-solid fa-check"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-star"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Premium Plan</h4>
                    <!--  -->
                    <!--  -->
                    <h6>300$</h6>
                    <!--  -->
                    <h5><span>$</span>299.99<span>/m</span></h5>
                    <!--  -->
                    <div  class="conditions-part">
                        <ul>
                            <li>
                                <a >Belts and Hoses <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Suspension and Shock Absorbers <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Transmission Fluid Service <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Fuel System Cleaning <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Exhaust System <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Interior Components <i class="fa-solid fa-check"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
           </div>
        </div>
        <div data-plan-panel="gold" id="card-gold" class="section-card-list-pricing">
            <div class="section-card-list-pricing-plan-content">
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-layer-group"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Basic Plan </h4>
                    <!--  -->
                    <!--  -->
                    <h6>400$</h6>
                    <!--  -->
                    <h5><span>$</span>359.99<span>/m</span></h5>
                    <!--  -->
                    <div class="conditions-part">
                        <ul>
                            <li>
                                <a >Conventional Oil Change <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Horn and Warning Lights <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Suspension Components <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Exhaust Smoke <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Power Steering <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Radiator and Cooling System <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-joint"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Advance Plan </h4>
                    <!--  -->
                    <!--  -->
                    <h6>500$</h6>
                    <!--  -->
                    <h5><span>$</span>498.99<span>/m</span></h5>
                    <!--  -->
                    <div  class="conditions-part">
                        <ul>
                            <li>
                                <a >Conventional Oil Change <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Horn and Warning Lights <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Suspension Components <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Exhaust Smoke  <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Power Steering <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li>
                                <a >Radiator and Cooling System <i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
                </div>
                <div class="card-items-pricing">
                    <div class="with-pricing-icon"><i class="fa-solid fa-star"></i></div>
                    <!--  -->
                    <!--  -->
                    <h4>Premium Plan</h4>
                    <!--  -->
                    <!--  -->
                    <h6>800$</h6>
                    <!--  -->
                    <h5><span>$</span>700.99<span>/m</span></h5>
                    <!--  -->
                    <div  class="conditions-part">
                        <ul>
                            <li>
                                <a >Conventional Oil Change <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Horn and Warning Lights <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Suspension Components <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Exhaust Smoke <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Power Steering <i class="fa-solid fa-check"></i></a>
                            </li>
                            <li>
                                <a >Radiator and Cooling System <i class="fa-solid fa-check"></i></a>
                            </li>
                        </ul>
                    </div>
                    <a class="btn-pricing-card" href="{{ route('home_auto') }}#contacts">Buy now</a>
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