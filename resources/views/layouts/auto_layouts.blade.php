<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script>document.documentElement.classList.add('js');try{if(sessionStorage.getItem('preloaded')){document.documentElement.classList.add('no-preload');}else{sessionStorage.setItem('preloaded','1');}}catch(e){}</script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Everything is self-hosted: fonts, icons and Swiper are bundled by Vite -->
    @vite(['resources/js/site.js', 'resources/scss/site.scss'])

    <link rel="icon" type="image/png" href="{{ asset('assets/images/website-logo.png') }}">

    @yield('link')

    <title>@yield('title')</title>
</head>
<body class="@yield('body-class')">
<div class="App">
<!-- Preloader -->
    <div class="preload" data-preload>
        <div class="preloader-content">
            <p class="text">Loading</p>
            <img class="circle" src="{{ asset('assets/images/circle.png') }}" alt="Preload">
        </div>
    </div>
@include('partials.site-header')
    @yield('content')
<footer>
    <div class="footer-container">
        <div class="footer-flex">
            <div class="copy">
                <h3 class="copy-title">Skills</h3>
                    <div class="copy-list">
                        <a href="{{ route('offer') }}"><span class="copy-link">Sale of cars</span></a>
                        <a href="{{ route('home_auto') }}#contacts"><span class="copy-link">Car repair</span></a>
                    </div>
        <!-- Community Section -->
        <div>
            <h3 class="copy-title">Community</h3>
            <div class="copy-list">
                <span class="copy-link">B2B Ukraine (b2b.ukraine)</span>
                <span class="copy-link">Automechanika Ukraine</span>
                <span class="copy-link">Drive2.ua</span>
                <span class="copy-link">Avtoforum.ua</span>
            </div>
        </div>
            </div>
        <!-- Partners Section -->
            <div class="copy">
                <h3 class="copy-title">Partners</h3>
                <div class="copy-list">
                    <span class="copy-link">Arm Tek</span>
                    <span class="copy-link">Smotor</span>
                    <span class="copy-link">Bosch/Kyb</span>
                    <span class="copy-link">Smile</span>
                    <span class="copy-link">Sachs</span>
                    <span class="copy-link">AvtoExpert</span>
                </div>
            </div>
        <!-- Services Section -->
            <div class="copy">
                <h3 class="copy-title">Our Service Repairs</h3>
                <div class="copy-list">
                    <span class="copy-link">Belts and Hoses</span>
                    <span class="copy-link">Engine Diagnostics</span>
                    <span class="copy-link">Oil and Filters</span>
                    <span class="copy-link">Air Conditioning</span>
                    <span class="copy-link">Brake Repair</span>
                </div>
            </div>
        <!-- Contact Information Section -->
            <div class="copy">
                <h3 class="copy-title">Contact us</h3>
                <div class="copy-list">
                    <a href="tel:+380950660959"><span class="copy-link">Tel: +380 95 066 09 59</span></a>
                    <a href="tel:+380950650385"><span class="copy-link">Telegram: +380 95 065 03 85</span></a>
                    <a href="mailto:autorepaire@gmail.com"><span class="copy-link">autorepaire@gmail.com</span></a>
                    <span class="copy-link">Kyiv, Ukraine</span>
                    <span class="copy-link">Mon–Sat: 08:00–18:00</span>
                </div>
            </div>
        </div>
    </div>
<!-- Copyright Section -->
<aside style="display: flex; align-items: center; justify-content: space-around;">
    <div class="aside-copyright">
        <div>
            <p class="aside-copyright-text">
                Copyright © car service all rights reserved 
            </p>
        </div>
        <div>
            <ul class="aside-copyright-list">
                <li>
                    <a href="{{route('contacts')}}">Terms & Conditions</a>
                </li>
                <li>
                    <a href="{{route('home_auto')}}">Privacy Policy</a>
                </li>
                <li>
                    <a href="{{route('contacts')}}">Contact Us</a>
                </li>
            </ul>
        </div>
    </div>
</aside>
</footer>
</div>
<button type="button" class="to-top" aria-label="Back to top" data-to-top><i class="fa-solid fa-arrow-up"></i></button>
<script src="{{ asset('assets/js/index.js') }}"></script>
@stack('scripts')
</body>
</html>
