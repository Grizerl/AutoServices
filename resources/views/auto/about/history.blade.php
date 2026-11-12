@extends('layouts.auto_layouts')

@section('title', 'About the Company - Auto Service')
@section('body-class', 'page-history')


@section('content')
<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">About us</h2>
         <div>
            <ul class="container-nav-item">
               <li>
                  <a class="cont-list" href="{{ route('home_auto') }}">Home</a>
               </li>
               <li class="cont-list"><i class="fas fa-angle-right"></i></li>
               <li>
                  <a class="cont-list">About the company</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
<section>
   <div class="gallery-container">
      <div>
         <div>
            <div style="display: flex; align-items: center; justify-content: center; flex-direction: column; ">
            <h1 class="section-gallery-title">Auto Goods: Accessories,<br> Consumables and Much More</h1>
            <h3 class="section-gallery-subtitle">PROAuto is a specialised online store of in-demand <br> products for cars.</h3>
            </div>
            <div class="grid-box">
               <div class="first-box">
                  <img class="gallery-img" src="/assets/images/gallery1.png" alt="gallery-img">
                  <img class="gallery-img" src="/assets/images/gallery2.png" alt="gallery-img">
                  <img class="gallery-img" src="/assets/images/gallery3.png" alt="gallery-img">
               </div>
               <div class="second-box">
                  <img class="gallery-img" src="/assets/images/gallery4.png" alt="gallery-img">
                  <img class="gallery-img" src="/assets/images/gallery5.png" alt="gallery-img">
                  <img class="gallery-img" src="/assets/images/gallery6.png" alt="gallery-img">
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section>
   <div>
      <div class="section-about-company">
         <div class="container">
            <h1 class="section-about-company-title">About the company</h1>
            <div class="section-form-container">
               <p>
               We are glad to welcome you to our website.<br><br>
               PROauto offers reliable, high-quality car batteries in a wide range of shapes and specifications, as well as quality oils and car chemicals from well-known brands.<br><br>
               The PROauto store network has been selling car batteries, oils, consumables, chemicals and accessories for more than 20 years. We have proven ourselves as a reliable company whose specialists are always ready to advise on any question: from choosing wiper blades to recommending the right battery for your car. We value our reputation and guarantee the entire range of products presented on our website!<br><br>
               See for yourself!
               </p>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection