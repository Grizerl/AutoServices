<!-- Top bar -->
<div class="topbar">
    <div class="container topbar__inner">
        <ul class="topbar__info">
            <li><i class="fa-solid fa-location-dot"></i> Kyiv, Ukraine</li>
            <li><i class="fa-regular fa-clock"></i> Mon–Sat 08:00–18:00</li>
            <li class="topbar__hide-sm"><a href="mailto:autorepaire@gmail.com"><i class="fa-regular fa-envelope"></i> autorepaire@gmail.com</a></li>
        </ul>
        <ul class="topbar__social" aria-label="Social networks">
            <li><a title="Facebook" aria-label="Facebook" href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li><a title="X" aria-label="X" href="#"><i class="fab fa-x-twitter"></i></a></li>
            <li><a title="Instagram" aria-label="Instagram" href="#"><i class="fab fa-instagram"></i></a></li>
            <li><a title="Telegram" aria-label="Telegram" href="#"><i class="fab fa-telegram"></i></a></li>
        </ul>
    </div>
</div>

<!-- Main navigation -->
<header class="site-header" data-site-header>
    <div class="container">
        <div class="navbar-content">
            <div class="main-logo">
                <a class="logo-slogan" href="{{ route('home_auto') }}"><i class="fa-solid fa-car-side"></i> Auto <span>Service</span></a>
            </div>

            <nav class="nav-bar-collapse" aria-label="Main navigation">
                <ul class="nav-content">
                    <li class="nav-item">
                        <a @class(['nav-link', 'is-active' => request()->routeIs('home_auto')]) href="{{ route('home_auto') }}">Home</a>
                    </li>
                    <li class="nav-item menu-item">
                        <a @class(['nav-link', 'is-active' => request()->routeIs('vision', 'history', 'partners')]) href="{{ route('history') }}">About <i class="fa-solid fa-chevron-down nav-caret"></i></a>
                        <ul class="sub-menu">
                            <li><a href="{{ route('history') }}">About the company</a></li>
                            <li><a href="{{ route('vision') }}">News &amp; FAQ</a></li>
                            <li><a href="{{ route('partners') }}">Partners</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'is-active' => request()->routeIs('offer', 'car.show')]) href="{{ route('offer') }}">Cars for sale</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'is-active' => request()->routeIs('plan', 'plan.checkout', 'plan.thanks')]) href="{{ route('plan') }}">Subscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home_auto') }}#client-say">Reviews</a>
                    </li>
                    <li class="nav-item">
                        <a @class(['nav-link', 'is-active' => request()->routeIs('contacts')]) href="{{ route('contacts') }}">Contact</a>
                    </li>
                </ul>
            </nav>

            <div class="header-cta">
                <a class="header-cta__phone" href="tel:+380950660959">
                    <span class="header-cta__icon"><i class="fa-solid fa-phone"></i></span>
                    <span><small>Call us</small><strong>+380 95 066 09 59</strong></span>
                </a>
                <a class="btn-nav" href="{{ route('home_auto') }}#contacts">Book a repair</a>
            </div>

            <!-- Burger menu (mobile) -->
            <button type="button" class="burger-menu" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu">
                <i class="fa-solid fa-bars"></i>
            </button>
            <div class="menu-backdrop" data-menu-backdrop></div>
            <nav class="menu-container" id="mobile-menu" aria-label="Mobile menu">
                <div class="adaptive-logo">
                    <a class="logo-slogan" href="{{ route('home_auto') }}"><i class="fa-solid fa-car-side"></i> Auto <span>Service</span></a>
                    <button type="button" class="close-btn" aria-label="Close menu">&times;</button>
                </div>
                <ul class="menu">
                    <li class="adaptive-item">
                        <a class="nav-link sc-FDFgh" href="{{ route('home_auto') }}">Home</a>
                    </li>
                    <li class="adaptive-item">
                        <details>
                            <summary class="nav-link sc-FDFgh">About</summary>
                            <ul class="adaptive-sub">
                                <li><a href="{{ route('history') }}">About the company</a></li>
                                <li><a href="{{ route('vision') }}">News &amp; FAQ</a></li>
                                <li><a href="{{ route('partners') }}">Partners</a></li>
                            </ul>
                        </details>
                    </li>
                    <li class="adaptive-item">
                        <a class="nav-link sc-FDFgh" href="{{ route('offer') }}">Cars for sale</a>
                    </li>
                    <li class="adaptive-item">
                        <a class="nav-link sc-FDFgh" href="{{ route('plan') }}">Subscription</a>
                    </li>
                    <li class="adaptive-item">
                        <a class="nav-link sc-FDFgh" href="{{ route('home_auto') }}#client-say">Reviews</a>
                    </li>
                    <li class="adaptive-item">
                        <a class="nav-link sc-FDFgh" href="{{ route('contacts') }}">Contact</a>
                    </li>
                    <li class="adaptive-item adaptive-item--sales">
                        <a class="btn-nav btn-nav--block" href="{{ route('home_auto') }}#contacts">Book a repair</a>
                        <span class="adaptive-link">Call us</span>
                        <a href="tel:+380950660959" class="adaptive-link-number">+380 95 066 09 59</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>
