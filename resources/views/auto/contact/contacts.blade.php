@extends('layouts.auto_layouts')

@section('title', 'Contacts - Auto Service')
@section('body-class', 'page-contacts')

@section('content')
<div class="wrapper">
   <x-page-banner title="Contact Us" :crumbs="[['Contact']]" />

   <section class="contact-info">
      <div class="container">
         <div class="sn-title-container">
            <h2 class="sn-title">GET IN TOUCH</h2>
            <h3 class="sn-subtitle">We are always happy to help</h3>
            <p class="catalog__lead">Call, write or visit us: our team answers questions about repairs, prices, cars for sale and subscriptions.</p>
         </div>

         <div class="info-grid">
            <article class="info-card">
               <span class="info-card__icon"><i class="fa-solid fa-phone"></i></span>
               <h4>Phone</h4>
               <p><a href="tel:+380950660959">+38 (095) 066 09 59</a></p>
               <p><a href="tel:+380950650385">+38 (095) 065 03 85</a></p>
            </article>
            <article class="info-card">
               <span class="info-card__icon"><i class="fa-solid fa-envelope"></i></span>
               <h4>E-mail</h4>
               <p><a href="mailto:autorepaire@gmail.com">autorepaire@gmail.com</a></p>
               <p class="info-card__muted">We reply within one working day</p>
            </article>
            <article class="info-card">
               <span class="info-card__icon"><i class="fa-solid fa-location-dot"></i></span>
               <h4>Address</h4>
               <p>Kyiv, Ukraine</p>
               <p class="info-card__muted">02000</p>
            </article>
            <article class="info-card">
               <span class="info-card__icon"><i class="fa-solid fa-clock"></i></span>
               <h4>Working hours</h4>
               <p>Monday–Saturday</p>
               <p class="info-card__muted">08:00–18:00, Sunday closed</p>
            </article>
         </div>
      </div>
   </section>

   <section class="contact-main" id="ask-question">
      <div class="container">
         <div class="contact-main__grid">
            <div class="map-card">
               <iframe class="contact-map" title="Our location in Kyiv"
                  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d194758.40101437262!2d30.367885572156325!3d50.402137935576306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x40d4cf4ee15a4505%3A0x764931d2170146fe!2z0JrQuNGX0LIsIDAyMDAw!5e1!3m2!1sen!2sua!4v1726648594973!5m2!1sen!2sua"
                  allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>

            <div class="form-card">
               <h2 class="form-card__title">Ask a question</h2>
               <p class="form-card__lead">Our managers will gladly answer your questions and help you choose.</p>

               @if (session('success'))
                  <div class="form-alert form-alert--success" role="status"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
               @endif
               @if ($errors->any())
                  <div class="form-alert form-alert--error" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Please correct the highlighted fields and try again.</div>
               @endif

               <form action="{{ route('contact.store') }}" method="post" novalidate data-ajax data-validate>
                  @csrf
                  <div class="form-row">
                     <label class="field-group">
                        <span>Your name <b>*</b></span>
                        <input @class(['is-invalid' => $errors->has('name')]) id="name" name="name" type="text" value="{{ old('name') }}" maxlength="60" autocomplete="name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                        @error('name')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                     </label>
                     <label class="field-group">
                        <span>Phone <b>*</b></span>
                        <input @class(['is-invalid' => $errors->has('phone')]) id="phone" name="phone" type="tel" value="{{ old('phone') }}" maxlength="20" autocomplete="tel" placeholder="+380 95 066 09 59" aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}">
                        @error('phone')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                     </label>
                  </div>

                  <label class="field-group">
                     <span>E-mail <small>(optional)</small></span>
                     <input @class(['is-invalid' => $errors->has('email')]) id="email" name="email" type="email" value="{{ old('email') }}" maxlength="255" autocomplete="email" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}">
                     @error('email')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                  </label>

                  <label class="field-group">
                     <span>Message <b>*</b></span>
                     <textarea @class(['is-invalid' => $errors->has('message')]) id="message" name="message" rows="5" maxlength="1000" aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}">{{ old('message') }}</textarea>
                     @error('message')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
                  </label>

                  <label class="check">
                     <input type="checkbox" id="consent" name="consent" value="1" @checked(old('consent')) @class(['is-invalid' => $errors->has('consent')])>
                     <span>I agree to the <b>processing of personal data</b></span>
                  </label>
                  @error('consent')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror

                  <div class="form-card__actions">
                     <small>* Required field</small>
                     <button type="submit" class="btn-car btn-car--lg">Send message</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection
