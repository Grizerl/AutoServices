@extends('layouts.auto_layouts')

@section('title', 'Автосервіс - Car Services and Mechanic')
@section('body-class', 'page-contacts')


@section('content')
<div class="wrapper">
   <div class="banner-area">
      <div class="container-area">
         <h2 class="sc-ttl-cont">Contact</h2>
         <div>
            <ul class="container-nav-item">
               <li>
                  <a  class="cont-list" href="{{ route('home_auto') }}">Home</a>
               </li>
               <li class="cont-list"><i class="fas fa-angle-right"></i></li>
               <li>
                  <a class="cont-list">Contact</a>
               </li>
            </ul>
         </div>
      </div>
   </div>
<section style="margin-top: 6vh; margin-bottom: 8vh">
   <div>
      <div class="container">
         <div style=" display: flex; align-items: center; justify-content: center; flex-direction: column;">
            <h1 class="title-contact-page">КОНТАКТИ</h1>
            <h3 class="subtitle-contact-page">Автосервіс та автомастила в Києві</h3>
         </div>
         <div class="section-contact-header-container">
            <div class="section-contact-googl-maps">
               <iframe class="contact-map"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d194758.40101437262!2d30.367885572156325!3d50.402137935576306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf4ee15a4505%3A0x764931d2170146fe!2z0JrQuNGX0LIsIDAyMDAw!5e1!3m2!1suk!2sua!4v1726648594973!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
               </iframe>
            </div>
            <div class="section-contact-info-container">
               <h3 class="contact-title-main-info">Як з нами зв'язатися?</h3>
               <ul class="contact-info-list">
                  <li>
                     <i class="fa-solid fa-phone fa-contac"></i>
                     <a href="tel:0950660959">+38(095)-066-09-59</a>
                  </li>
                  <li>
                     <i class="fa-solid fa-envelope fa-contac"></i><a href="mailto:autorepaire@gmail.com">autorepaire@gmail.com</a>
                  </li>
                  <li>
                     <i class="fa-solid fa-hotel fa-contac"></i><a>Mulatol Pakar Matha 5400</a>
                  </li>
               </ul>
               <h3 class="contact-title-main-info">Режим роботи</h3>
               <span class="work-schedule"><i class="fa-solid fa-clock fa-contac"></i>Monday–Saturday: 08:00–18:00;</span>
            </div>
         </div>
      </div>
   </div>
</section>
<section>
   <div>
      <div class="section-header-ask-question-banner">
         <div class="container">
            <div style=" display: flex; align-items: center; justify-content: center; flex-direction: column;">
               <h1 class="title-question-page">ЗАДАТИ ПИТАННЯ</h1>
               <h3 class="subtitle-question-page">Менеджери компанії з радістю дадуть відповіді на ваші <br> запитання і допоможуть з вибором.</h3>
            </div>
            <div class="section-ask-question-form">
               <form class="form-ask-question" action="{{route('contact.store')}}" method="post" novalidate>
                  @csrf
                  <label class="ask-question-form-title" for="name">Ваше ім'я:<span>*</span></label>
                  <input class="ask-question-form-input" id="name" name="name" required type="text">

                  <label class="ask-question-form-title" for="phone">Телефон:<span>*</span></label>
                  <input class="ask-question-form-input" id="phone" name="phone" required type="tel">

                  <label class="ask-question-form-title" for="email">E-mail:</label>
                  <input class="ask-question-form-input" id="email" name="email" required type="email">

                  <label class="ask-question-form-title" for="message">Повідомлення:<span>*</span></label>
                  <input class="ask-question-form-input" id="message" name="message" required type="text">

                  <div style="display: flex; align-items: center; width: 100%; margin-top:15px;">
                     <input class="ask-question-form-checkbox" id="checkbox"  name="subscribe" value="1" type="checkbox">
                     <label class="ask-question-form-title ask-ques-check-tit" for="checkbox">Я згоден на <span>обробку персональних даних</span></label>
                  </div>
                  <div class="section-form-btn">
                     <span>* Обов'язкове поле</span>
                     <button class="btn-form" type="submit">Відправити</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection