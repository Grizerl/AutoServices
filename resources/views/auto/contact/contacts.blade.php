@extends('layouts.auto_layouts')

@section('title', 'Contacts - Auto Service')
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
            <h1 class="title-contact-page">CONTACTS</h1>
            <h3 class="subtitle-contact-page">Car service and auto oils in Kyiv</h3>
         </div>
         <div class="section-contact-header-container">
            <div class="section-contact-googl-maps">
               <iframe class="contact-map"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d194758.40101437262!2d30.367885572156325!3d50.402137935576306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf4ee15a4505%3A0x764931d2170146fe!2z0JrQuNGX0LIsIDAyMDAw!5e1!3m2!1suk!2sua!4v1726648594973!5m2!1suk!2sua" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
               </iframe>
            </div>
            <div class="section-contact-info-container">
               <h3 class="contact-title-main-info">How can you reach us?</h3>
               <ul class="contact-info-list">
                  <li>
                     <i class="fa-solid fa-phone fa-contac"></i>
                     <a href="tel:0950660959">+38(095)-066-09-59</a>
                  </li>
                  <li>
                     <i class="fa-solid fa-envelope fa-contac"></i><a href="mailto:autorepaire@gmail.com">autorepaire@gmail.com</a>
                  </li>
                  <li>
                     <i class="fa-solid fa-hotel fa-contac"></i><a>Kyiv, Ukraine, 02000</a>
                  </li>
               </ul>
               <h3 class="contact-title-main-info">Working hours</h3>
               <span class="work-schedule"><i class="fa-solid fa-clock fa-contac"></i>Monday–Saturday: 08:00–18:00;</span>
            </div>
         </div>
      </div>
   </div>
</section>
<section id="ask-question">
   <div>
      <div class="section-header-ask-question-banner">
         <div class="container">
            <div style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
               <h1 class="title-question-page">ASK A QUESTION</h1>
               <h3 class="subtitle-question-page">Our managers will gladly answer your <br> questions and help you choose.</h3>
            </div>
            <div class="section-ask-question-form">
               <form class="form-ask-question" action="{{ route('contact.store') }}" method="post" data-submit-once>
                  @csrf

                  @if (session('success'))
                     <div class="form-alert form-alert--success" role="status">{{ session('success') }}</div>
                  @endif

                  <label class="ask-question-form-title" for="name">Your name:<span>*</span></label>
                  <input @class(['ask-question-form-input', 'is-invalid' => $errors->has('name')]) id="name" name="name" type="text" value="{{ old('name') }}" required minlength="2" maxlength="60" autocomplete="name">
                  @error('name')<p class="field-error">{{ $message }}</p>@enderror

                  <label class="ask-question-form-title" for="phone">Phone:<span>*</span></label>
                  <input @class(['ask-question-form-input', 'is-invalid' => $errors->has('phone')]) id="phone" name="phone" type="tel" value="{{ old('phone') }}" required maxlength="20" autocomplete="tel" placeholder="+380 95 066 09 59">
                  @error('phone')<p class="field-error">{{ $message }}</p>@enderror

                  <label class="ask-question-form-title" for="email">E-mail:</label>
                  <input @class(['ask-question-form-input', 'is-invalid' => $errors->has('email')]) id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email">
                  @error('email')<p class="field-error">{{ $message }}</p>@enderror

                  <label class="ask-question-form-title" for="message">Message:<span>*</span></label>
                  <textarea @class(['ask-question-form-input', 'ask-question-form-textarea', 'is-invalid' => $errors->has('message')]) id="message" name="message" rows="4" required minlength="5" maxlength="1000">{{ old('message') }}</textarea>
                  @error('message')<p class="field-error">{{ $message }}</p>@enderror

                  <div class="ask-question-consent">
                     <input class="ask-question-form-checkbox" id="consent" name="consent" value="1" type="checkbox" @checked(old('consent')) required>
                     <label class="ask-question-form-title ask-ques-check-tit" for="consent">I agree to the <span>processing of personal data</span></label>
                  </div>
                  @error('consent')<p class="field-error">{{ $message }}</p>@enderror

                  <div class="section-form-btn">
                     <span>* Required field</span>
                     <button class="btn-form" type="submit">Send</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection
