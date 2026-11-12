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
<section id="client-say"> 
<!-- Client testimonials section -->
   <div class="section-client-container">
      <div class="container">
         <div class="section-client-content">
            <h2 class="section-client-title">Testimonials</h2>
            <h3 class="section-client-subtitle">Our Client Says</h3>
               <p class="section-client-text">
                  Drivers trust us with their cars because we explain every repair, stick to the estimate and stand behind our work.
               </p>
         </div>
         <div class="swiper mySwiper sc-ClieSwip"> <!-- Swiper for client testimonials -->
            <div class="swiper-wrapper">
               @foreach ($client as $item)
                  <div class="swiper-slide">
                     <div class="swiper-slide-content">
                        <div class="slider-client-content">
                           <div class="img-slider-container">
                              <img class="swiper-img-box" src="/assets/images/hackery-user.png" alt="User Male Icon">
                           </div>
                        <div>
                           <h6 style="text-align: center;" class="swiper-name-box">{{ $item->name }}</h6>
                           <span class="swiper-role-box">{{ $item->role }}</span>
                        </div>
                        </div>
                        <p class="swiper-text-box">{{ $item->commentars }}</p>
                        <div class="star-container">
                           <h5 class="swiper-date-box">{{ $item->created_at?->format('M j, Y') }}</h5>
                              <ul class="star-content">
                                 <li><i class="fa-solid fa-star"></i></li>
                                 <li><i class="fa-solid fa-star"></i></li>
                                 <li><i class="fa-solid fa-star"></i></li>
                                 <li><i class="fa-solid fa-star"></i></li>
                                 <li><i class="fa-solid fa-star"></i></li>
                              </ul>
                        </div>
                     </div>
                  </div>
               @endforeach
            </div>
         </div>
      </div>
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
               <div class="form-alert form-alert--success" role="status">{{ session('success') }}</div>
            @endif
            <form action="{{ route('repair.store') }}" method="post" data-submit-once>
               @csrf
               <div class="field">
                  <input name="name" type="text" placeholder="Your name*" value="{{ old('name') }}" required minlength="2" maxlength="60" autocomplete="name" @class(['is-invalid' => $errors->has('name')])>
                  @error('name')<p class="field-error">{{ $message }}</p>@enderror
               </div>
               <div class="field">
                  <input name="phone" type="tel" placeholder="Your phone number*" value="{{ old('phone') }}" required maxlength="20" autocomplete="tel" @class(['is-invalid' => $errors->has('phone')])>
                  @error('phone')<p class="field-error">{{ $message }}</p>@enderror
               </div>
               <div class="field">
                  <input name="car" type="text" placeholder="Your car*" value="{{ old('car') }}" required minlength="2" maxlength="100" @class(['is-invalid' => $errors->has('car')])>
                  @error('car')<p class="field-error">{{ $message }}</p>@enderror
               </div>
               <div class="field">
                  <input name="comment" type="text" placeholder="Your problem*" value="{{ old('comment') }}" required minlength="6" maxlength="500" @class(['section-contact-form-comment', 'is-invalid' => $errors->has('comment')])>
                  @error('comment')<p class="field-error">{{ $message }}</p>@enderror
               </div>
               <button type="submit" class="section-contact-form-btn">Send Request</button>
            </form>
         </div>
      </div>
   </div>
</section>
@include('partials.contact-strip')
@endsection
