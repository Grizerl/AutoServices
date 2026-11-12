/**
 * Public website behaviour: preloader, sliders, mobile menu, form protection.
 * Every block is guarded so the script is safe on any page.
 */
(function () {
    'use strict';

    function ready(fn) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', fn);
        } else {
            fn();
        }
    }

    // ---------------------------------------------------------------- preloader
    function hidePreloader() {
        var preload = document.querySelector('[data-preload]');
        if (preload) {
            setTimeout(function () { preload.classList.add('loaded'); }, 300);
        }
    }
    if (document.readyState === 'complete') {
        hidePreloader();
    } else {
        window.addEventListener('load', hidePreloader);
        // never keep visitors waiting on a slow third-party asset
        setTimeout(hidePreloader, 4000);
    }

    // ---------------------------------------------------------------- sliders
    function slideCount(el) {
        return el.querySelectorAll(':scope > .swiper-wrapper > .swiper-slide').length;
    }

    function initSliders() {
        if (typeof Swiper === 'undefined') { return; }

        // Hero slider
        var hero = document.querySelector('.swiper-1');
        if (hero) {
            new Swiper(hero, {
                loop: slideCount(hero) > 1,
                effect: 'fade',
                fadeEffect: { crossFade: true },
                autoplay: { delay: 3500, disableOnInteraction: false },
                navigation: {
                    nextEl: hero.querySelector('.swiper-button-next'),
                    prevEl: hero.querySelector('.swiper-button-prev'),
                },
            });
        }

        // Testimonials
        var clients = document.querySelector('.sc-ClieSwip');
        if (clients) {
            var clientCount = slideCount(clients);
            new Swiper(clients, {
                loop: clientCount > 4,
                centerInsufficientSlides: true,
                spaceBetween: 25,
                speed: 800,
                autoplay: clientCount > 1 ? { delay: 3500, disableOnInteraction: false } : false,
                breakpoints: {
                    200: { slidesPerView: 1 },
                    600: { slidesPerView: 2 },
                    868: { slidesPerView: 3 },
                    1150: { slidesPerView: 4 },
                },
            });
        }

        // Team
        var team = document.querySelector('.SwiperTeam');
        if (team) {
            var teamCount = slideCount(team);
            new Swiper(team, {
                loop: teamCount > 3,
                centerInsufficientSlides: true,
                spaceBetween: 25,
                speed: 800,
                autoplay: teamCount > 1 ? { delay: 3500, disableOnInteraction: false } : false,
                breakpoints: {
                    200: { slidesPerView: 1 },
                    500: { slidesPerView: 2 },
                    760: { slidesPerView: 3 },
                },
            });
        }

        // Before / after
        var compare = document.querySelector('.swiper-2');
        if (compare) {
            new Swiper(compare, {
                effect: 'flip',
                flipEffect: { slideShadows: true, limitRotation: true },
                navigation: {
                    nextEl: '.swiper-button-next-2',
                    prevEl: '.swiper-button-prev-2',
                },
            });
        }
    }

    // ---------------------------------------------------------------- mobile menu
    function initMenu() {
        var burger = document.querySelector('.burger-menu');
        var menu = document.querySelector('.menu-container');
        var closeBtn = document.querySelector('.close-btn');
        var backdrop = document.querySelector('[data-menu-backdrop]');
        if (!burger || !menu) { return; }

        var setOpen = function (isOpen) {
            menu.classList.toggle('active', isOpen);
            document.body.classList.toggle('menu-open', isOpen);
            burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        };

        burger.addEventListener('click', function () { setOpen(true); });
        if (closeBtn) { closeBtn.addEventListener('click', function () { setOpen(false); }); }
        if (backdrop) { backdrop.addEventListener('click', function () { setOpen(false); }); }
        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') { setOpen(false); }
        });
        // close the drawer after choosing an in-page link (e.g. #contacts)
        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () { setOpen(false); });
        });
        // leaving the mobile breakpoint must not leave the page locked
        window.addEventListener('resize', function () {
            if (window.innerWidth > 1000) { setOpen(false); }
        });
    }

    // ---------------------------------------------------------------- forms
    // Prevent double submits: lock the submit button once a valid form is sent.
    function initForms() {
        document.querySelectorAll('form[data-submit-once]').forEach(function (form) {
            form.addEventListener('submit', function () {
                var button = form.querySelector('button[type="submit"]');
                if (!button || button.disabled) { return; }
                // disable after the event so the button value is still submitted
                setTimeout(function () {
                    button.dataset.label = button.textContent;
                    button.textContent = 'Sending...';
                    button.disabled = true;
                }, 0);
            });
        });

        // Browser "back" restores the page from cache with the button still locked
        window.addEventListener('pageshow', function (event) {
            if (!event.persisted) { return; }
            document.querySelectorAll('form[data-submit-once] button[type="submit"]').forEach(function (button) {
                button.disabled = false;
                if (button.dataset.label) { button.textContent = button.dataset.label; }
            });
        });
    }

    // ---------------------------------------------------------------- header + back to top
    function initScrollUi() {
        var header = document.querySelector('[data-site-header]');
        var toTop = document.querySelector('[data-to-top]');
        var ticking = false;

        var update = function () {
            var y = window.pageYOffset || document.documentElement.scrollTop;
            if (header) { header.classList.toggle('is-scrolled', y > 8); }
            if (toTop) { toTop.classList.toggle('is-visible', y > 600); }
            ticking = false;
        };

        window.addEventListener('scroll', function () {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(update);
            }
        }, { passive: true });
        update();

        if (toTop) {
            toTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        }
    }

    // ---------------------------------------------------------------- scroll reveal
    // [selector, animation, stagger in ms between siblings]
    var REVEAL = [
        ['.page-home .card', 'fade-up', 120],
        ['.page-home .card-support', 'fade-up', 90],
        ['.page-home .section-advantages-card-list', 'fade-up', 100],
        ['.page-home .section-support-content-title, .page-home .section-advantages-title, .page-home .section-client-content, .page-home .section-member-title, .page-home .sc-CoNtn', 'fade-up', 0],
        ['.page-home .sc-AbOgs > div:first-child', 'fade-right', 0],
        ['.page-home .sc-AbOgs > div:last-child', 'fade-left', 0],
        ['.page-home .sc-Fvrha', 'fade-right', 0],
        ['.page-home .section-contact-container-form', 'fade-left', 0],
        ['.page-offer .sn-title-container, .page-plan .section-element-title-conteiner', 'fade-up', 0],
        ['.page-offer .shop-car-card-container', 'fade-up', 110],
        ['.page-plan .section-element-navbar-conteiner', 'fade-up', 0],
        ['.page-plan .card-items-pricing', 'fade-up', 120],
        ['.page-partners .section-licenses-content, .page-partners .section-partners-title', 'fade-up', 0],
        ['.page-partners .charter-box-first-img, .page-partners .charter-box-second-img', 'zoom-in', 80],
        ['.page-partners .partners-box-first-img, .page-partners .partners-box-second-img', 'zoom-in', 80],
        ['.page-history .section-gallery-title, .page-history .section-gallery-subtitle, .page-history .section-about-company-title', 'fade-up', 0],
        ['.page-history .gallery-img', 'zoom-in', 70],
        ['.page-history .section-form-container', 'fade-up', 0],
        ['.page-news .section-about-news-title, .page-news .section-about-news-subtitle, .page-news .swiper-news-container', 'fade-up', 0],
        ['.page-news .section-faq-title, .page-news .section-faq-subtitle', 'fade-up', 0],
        ['.page-news .header-hidden-container', 'fade-up', 80],
        ['.page-contacts .title-contact-page, .page-contacts .subtitle-contact-page, .page-contacts .section-contact-header-container', 'fade-up', 0],
        ['.page-contacts .title-question-page, .page-contacts .subtitle-question-page, .page-contacts .form-ask-question', 'fade-up', 0],
        ['.page-error .section-media-container > *', 'fade-up', 120]
    ];

    function initReveal() {
        var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        if (reduce || !('IntersectionObserver' in window)) { return; }

        // tag the targets (stagger siblings that share a parent)
        REVEAL.forEach(function (rule) {
            var counters = new Map();
            document.querySelectorAll(rule[0]).forEach(function (el) {
                if (el.hasAttribute('data-animate')) { return; }
                var n = counters.get(el.parentElement) || 0;
                counters.set(el.parentElement, n + 1);
                el.setAttribute('data-animate', rule[1]);
                if (rule[2]) { el.style.setProperty('--delay', Math.min(n, 6) * rule[2] + 'ms'); }
            });
        });

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (!entry.isIntersecting) { return; }
                var el = entry.target;
                el.classList.add('is-visible');
                observer.unobserve(el);
                // hand the element back to its own hover transitions once revealed
                var delay = parseInt(el.style.getPropertyValue('--delay'), 10) || 0;
                setTimeout(function () {
                    el.removeAttribute('data-animate');
                    el.classList.remove('is-visible');
                    el.style.removeProperty('--delay');
                }, 900 + delay);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('[data-animate]').forEach(function (el) { observer.observe(el); });
    }

    ready(function () {
        initSliders();
        initMenu();
        initForms();
        initScrollUi();
        initReveal();
    });
})();
