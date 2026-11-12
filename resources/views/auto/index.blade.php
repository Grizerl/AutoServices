@extends('layouts.auto_layouts') <!-- Base layout -->

@section('title', 'Auto Service - Car Repair and Maintenance') <!-- Page title -->
@section('body-class', 'page-home')

@section('content') <!-- Main content -->
<aside>
    <div class="aside-container"> 
        <div class="aside-content"> 
            <div class="swiper-1"> <!-- Swiper for slides -->
                <div class="swiper-wrapper"> 
                    <!-- First slide -->
                    <div class="swiper-slide sc-ban-slide"> 
                        <div class="back-img-slide-1">
                           <div class="container">
                              <div class="slide-1-content"> 
                                 <h2 class="slide-1-title">Technicians<br>for service</h2>
                                 <p class="slide-1-text">Certified mechanics, honest prices and a written<br>warranty on every job we do.</p>
                                 <a class="slide-1-btn" href="#contacts">Book An Appointment</a>
                            </div>
                           </div>
                        </div>
                    </div>
                    <!-- Second slide -->
                    <div class="swiper-slide sc-ban-slide"> 
                        <div class="back-img-slide-2"> 
                           <div class="container">
                              <div class="slide-2-content"> 
                                <h2 class="slide-2-title">Best mechanical<br>for service</h2>
                                <p class="slide-2-text">Modern diagnostic equipment and quality parts<br>for any make and model.</p>
                                <a class="slide-2-btn" href="{{route('vision')}}">More Information +</a>
                              </div>
                           </div>
                        </div>
                    </div>
                </div>
                <!-- Navigation buttons -->
                <div class="swiper-button-prev sc-Banprev"></div> 
                <div class="swiper-button-next sc-Bannext"></div> 
            </div>
        </div>
    </div>
</aside>
<section id="about"> <!-- About section -->
   <div class="section-about-card-content">
      <div class="container">
         <div class="card-list"> 
            <!-- Appointment Card -->
            <div class="card"> 
               <div>
                  <i class="fa-solid fa-car-rear"></i>
               </div> 
                <h2>Appointment</h2>
                <p class="card-p">Pick a convenient time and our team will take care of your car.</p>
                <div class="card-btn-active">
                  <div class="card-pseudo-btn">
                     <a href="#contacts">Booking Now</a>
                  </div>
                </div>
            </div>
            <!-- Service Packages Card -->
            <div class="card"> 
               <div>
                  <i class="fa-solid fa-gear"></i>
               </div> 
                <h2>Service Packages</h2>
                <p class="card-p">Browse cars for sale and monthly maintenance plans.</p>
                <div class="card-btn-active">
                  <div class="card-pseudo-btn">
                     <a href="{{route('offer')}}">Offer Now</a>
                  </div>
                </div>
            </div>
            <!-- Find A Repair Card -->
            <div class="card"> 
               <div>
                  <i class="fa-solid fa-screwdriver-wrench"></i>
               </div> 
                <h2>Find A Repair</h2>
                <p class="card-p">Describe the problem and get a quick, transparent estimate.</p>
                <div class="card-btn-active">
                    <div class="card-pseudo-btn"><a href="{{route('contacts')}}">Contact Us</a></div>
                </div>
            </div>
         </div>
      </div>
   </div>
<aside>
<!-- Aside section with animation -->
   <div class="aside-container-section-card">
      <div class="container">
         <div class="sc-AbOgs">
            <div>
               <span class="aside-subtitle">About the company</span>
                  @foreach ($post as $posts) 
                     <h1 class="aside-title">{{ $posts->title }}</h1>
                     <p class="aside-text">{{ $posts->content }}</p>
                  @endforeach
               <div>
                  <a href="{{route('history')}}" class="aside-btn animation-btn"><span>About More </span></a>
               </div>
            </div>
            <div>
                <img class="img-aside-one" src="/assets/images/circle-one.jpg" alt="a man who cuts a car">
                <img class="img-aside-two" src="/assets/images/circle-two.jpg" alt="tools">
            </div>
         </div>
      </div>
   </div>
</aside>
</section>
<section id="support">
<!-- Support section -->
   <div class="section-support-container">
      <div class="section-support-content">
         <div class="container">
            <div class="section-support-content-title">
               <h2 class="section-support-title">OUR SUPPORT</h2>
               <h3 class="section-support-subtitle">Our Provided Service</h3>
            </div>
            <div class="card-support-list">
               <div class="card-support">
                  <i class="fa-solid fa-screwdriver-wrench"></i>
                  <h2>Repair & Change</h2>
                  <p class="card-p cd-p">From quick fixes to full overhauls, done on time and to spec.</p>
               </div>
               <div class="card-support">
                  <i class="fa-regular fa-compass"></i>
                  <h2>Body Repair</h2>
                  <p class="card-p cd-p">Dent removal, welding and painting that restores the original look.</p>
               </div>
               <div class="card-support">
                  <i class="fa-solid fa-car-rear"></i>
                  <h2>Fast Booking</h2>
                  <p class="card-p cd-p">Confirm your visit online and skip the waiting line.</p>
               </div>
               <div class="card-support">
               <i class="fa-solid fa-hammer"></i>
               <h2>Warranty on Service</h2>
               <p class="card-p cd-p">Every job is covered by a written warranty.</p>
               </div>
               <div class="card-support">
                  <i class="fa-solid fa-gears"></i>
                  <h2>Free Diagnosis</h2>
                  <p class="card-p cd-p">Computer diagnostics at no cost when you repair with us.</p>
               </div>
               <div class="card-support">
                  <i class="fa-solid fa-life-ring"></i>
                  <h2>Roadside Support</h2>
                  <p class="card-p cd-p">Stuck on the road? Call us and we will help you get moving.</p>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<section> 
<!-- Advantages section -->
   <div>
      <div class="section-advantages-conteiner">
         <div class="container">
            <div>
               <h1 class="section-advantages-title">OUR ADVANTAGES</h1>
            </div>
            <div class="section-advantages-card-content">
               <div class="section-advantages-card-list">
                  <div>
                     <i class="fa-solid fa-headset fa-i"></i>
                  </div>
               <div>
                  <h3 class="section-advantages-card-title">QUALITY SUPPORT</h3>
                  <p class="section-advantages-card-p">Friendly specialists answer your questions and keep you informed at every step.</p>
               </div>
               </div>
               <div class="section-advantages-card-list">
                  <div>
                     <i class="fa-solid fa-gears fa-i"></i>
                  </div>
               <div>
                  <h3 class="section-advantages-card-title">SERVICE VARIETY</h3>
                  <p class="section-advantages-card-p">Engine, brakes, suspension, A/C and electronics: one workshop for every job.</p>
               </div>
               </div>
               <div class="section-advantages-card-list">
                  <div>
                     <i class="fa-solid fa-life-ring fa-i"></i>
                  </div>
               <div>
                  <h3 class="section-advantages-card-title">WRITTEN WARRANTY</h3>
                  <p class="section-advantages-card-p">All work and installed parts come with a written warranty.</p>
               </div>
               </div>
               <div class="section-advantages-card-list">
                  <div>
                     <i class="fa-solid fa-car-rear fa-i"></i>
                  </div>
               <div>
                  <h3 class="section-advantages-card-title">CAR MAKES</h3>
                  <p class="section-advantages-card-p">We service everything from compact city cars to SUVs and light commercial vehicles.</p>
               </div>
               </div>
            </div>
            <div class="sc-CoNtn">
               <a class="section-advantages-card-btn" href="{{route('history')}}">ADVANTAGES MORE</a>
            </div>
         </div>
      </div>
   </div>
</section>
@if ($featuredCars->isNotEmpty())
<section class="section-featured" id="cars">
   <div class="container">
      <div class="sn-title-container">
         <h2 class="sn-title">CARS FOR SALE</h2>
         <h3 class="sn-subtitle">Checked by our mechanics</h3>
         <p class="catalog__lead">A selection of cars we have inspected and prepared for a new owner.</p>
      </div>
      <div class="car-grid">
         @foreach ($featuredCars as $car)
            @include('auto.cars._card', ['car' => $car])
         @endforeach
      </div>
      <div class="section-featured__more">
         <a class="btn-car btn-car--lg" href="{{ route('offer') }}">See all cars</a>
      </div>
   </div>
</section>
@endif
<section id="client-say" class="reviews">
<!-- Client testimonials -->
   <div class="container">
      <div class="reviews__head">
         <div>
            <h2 class="sn-title">TESTIMONIALS</h2>
            <h3 class="sn-subtitle">What our clients say</h3>
            <p class="catalog__lead catalog__lead--left">Drivers trust us with their cars because we explain every repair, stick to the estimate and stand behind our work.</p>
         </div>
         @if ($client->count() > 1)
            <div class="slider-nav" aria-label="Reviews navigation">
               <button type="button" class="slider-nav__btn review-prev" aria-label="Previous review"><i class="fa-solid fa-arrow-left"></i></button>
               <button type="button" class="slider-nav__btn review-next" aria-label="Next review"><i class="fa-solid fa-arrow-right"></i></button>
            </div>
         @endif
      </div>

      @if ($client->isEmpty())
         <div class="empty-state">
            <i class="fa-regular fa-comments"></i>
            <h3>No reviews yet</h3>
            <p>Be the first to share your experience with us.</p>
         </div>
      @else
         <div class="swiper review-slider">
            <div class="swiper-wrapper">
               @foreach ($client as $item)
                  <article class="swiper-slide review-card">
                     <i class="fa-solid fa-quote-right review-card__quote" aria-hidden="true"></i>
                     <ul class="review-card__stars" aria-label="5 out of 5 stars">
                        @for ($i = 0; $i < 5; $i++)<li><i class="fa-solid fa-star"></i></li>@endfor
                     </ul>
                     <p class="review-card__text">{{ $item->commentars }}</p>
                     <div class="review-card__author">
                        <span class="review-card__avatar" aria-hidden="true">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($item->name, 0, 1)) }}</span>
                        <span class="review-card__who">
                           <strong>{{ $item->name }}</strong>
                           <small>{{ $item->role }}</small>
                        </span>
                        <time class="review-card__date" datetime="{{ $item->created_at?->toDateString() }}">{{ $item->created_at?->format('M j, Y') }}</time>
                     </div>
                  </article>
               @endforeach
            </div>
            <div class="swiper-pagination review-pagination"></div>
         </div>
      @endif
   </div>
</section>
<section class="car-section">
<!-- Before and after image slider -->
   <div class="swiper-2">
      <div class="swiper-wrapper">
         <div class="swiper-slide">
            <div>
               <img src="/assets/images/before.jpg" alt="Car before">
            </div>
         </div>
         <div class="swiper-slide">
            <div>
               <img src="/assets/images/after.jpg" alt="Car after">
            </div>
         </div>
      </div>
      <div>
         <button class="swiper-button-prev swiper-button-prev-2">Before</button>
      </div>
      <div>
         <button class="swiper-button-next swiper-button-next-2">After</button>
      </div>
   </div>
</section>
<section> 
<!-- Team members section -->
   <div class="section-member-container">
      <div class="container">
         <h3 class="section-member-title">Our Talent Member</h3>
         <div class="swiper mySwiper SwiperTeam">
            <div class="swiper-wrapper">
               @foreach ($members as $member)
                  <div class="swiper-slide">
                     <div class="team-container">
                        <div>
                           <img class="member-img" src="{{ $member->image_url }}" alt="{{ $member->name }}">
                        </div>
                        <div class="media-team-container">
                           <h3>{{ $member->name }}</h3>
                           <span class="section-member-role">{{ $member->role }}</span>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
   </div>
</section>
<section id="contacts">
<!-- Contact form section -->
   <div class="section-contact-container">
      <div class="section-contact-content">
         <div class="sc-Fvrha">
            <img style="width: 80%;" src="/assets/images/Contact.png" alt="Car Mercedes-Benz">
         </div>
         <div class="section-contact-container-form">
            <h1 class="section-contact-container-title">Contact us</h1>
            <h2 class="section-contact-container-subtitle">Get In Touch</h2>
            @if (session('success'))
               <div class="form-alert form-alert--success" role="status"><i class="fa-solid fa-circle-check"></i> {{ session('success') }}</div>
            @endif
            @if ($errors->any())
               <div class="form-alert form-alert--error" role="alert"><i class="fa-solid fa-triangle-exclamation"></i> Please correct the highlighted fields.</div>
            @endif
            <form action="{{ route('repair.store') }}" method="post" novalidate data-ajax data-validate>
               @csrf
               <div class="field">
                  <input name="name" type="text" placeholder="Your name*" value="{{ old('name') }}" maxlength="60" autocomplete="name" aria-label="Your name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}" @class(['is-invalid' => $errors->has('name')])>
                  @error('name')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
               </div>
               <div class="field">
                  <input name="phone" type="tel" placeholder="Your phone number*" value="{{ old('phone') }}" maxlength="20" autocomplete="tel" aria-label="Your phone number" aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}" @class(['is-invalid' => $errors->has('phone')])>
                  @error('phone')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
               </div>
               <div class="field">
                  <input name="car" type="text" placeholder="Your car*" value="{{ old('car') }}" maxlength="100" aria-label="Your car" aria-invalid="{{ $errors->has('car') ? 'true' : 'false' }}" @class(['is-invalid' => $errors->has('car')])>
                  @error('car')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
               </div>
               <div class="field">
                  <input name="comment" type="text" placeholder="Your problem*" value="{{ old('comment') }}" maxlength="500" aria-label="Your problem" aria-invalid="{{ $errors->has('comment') ? 'true' : 'false' }}" @class(['section-contact-form-comment', 'is-invalid' => $errors->has('comment')])>
                  @error('comment')<p class="field-error"><i class="fa-solid fa-circle-exclamation"></i> {{ $message }}</p>@enderror
               </div>
               <button type="submit" class="section-contact-form-btn">Send Request</button>
            </form>
         </div>
      </div>
   </div>
</section>
@include('partials.contact-strip')
@endsection
