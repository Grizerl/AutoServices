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

    ready(function () {
        initSliders();
        initMenu();
        initForms();
    });
})();
