@extends('layouts.auto_layouts')

@section('title', 'Автосервіс - Car Services and Mechanic')
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
            <h1 class="section-gallery-title">Автотовари: Аксесуари,<br> Розхідники та Багато Іншого</h1>
            <h3 class="section-gallery-subtitle">PROAuto - це спеціалізований інтернет магазин затребуваних <br> товарів для автомобілів.</h3>
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
            <h1 class="section-about-company-title">Про компанію</h1>
            <div class="section-form-container">
               <p>
               Ми раді вітати Вас на нашому сайті.<br><br>
               Компанія «PROавто» - це надійні, якісні акумулятори в широкому асортименті, різноманітні за формою та характеристиками, а також якісні масла та автохімія іменитих брендів.<br><br>
               Мережа магазинів «PROавто» понад 20 років займається продажем автомобільних акумуляторів, масел, витратних матеріалів, хімією та аксесуарів. Ми зарекомендували себе як надійна компанія, фахівці якої завжди готові проконсультувати з будь-якого питання: від підбору автощіток до рекомендацій щодо підбору акумулятора для Вашого автомобіля. Ми цінуємо свою репутацію та даємо гарантію на весь асортимент продукції, представленої на нашому сайті!<br><br>
               Переконайтеся у цьому самі!
               </p>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection