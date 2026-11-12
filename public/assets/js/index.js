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
    // Hidden as soon as the DOM is ready (not on window load, which waits for every
    // image/iframe) and never later than 1.5 s, so the page can never look blank.
    function hidePreloader() {
        var preload = document.querySelector('[data-preload]');
        if (preload) {
            setTimeout(function () { preload.classList.add('loaded'); }, 150);
        }
    }
    ready(hidePreloader);
    setTimeout(hidePreloader, 1500);

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
        var reviews = document.querySelector('.review-slider');
        if (reviews) {
            var reviewCount = slideCount(reviews);
            new Swiper(reviews, {
                loop: reviewCount > 3,
                centerInsufficientSlides: true,
                spaceBetween: 24,
                speed: 700,
                autoplay: reviewCount > 1 ? { delay: 5000, disableOnInteraction: true, pauseOnMouseEnter: true } : false,
                navigation: { nextEl: '.review-next', prevEl: '.review-prev' },
                pagination: { el: '.review-pagination', clickable: true },
                breakpoints: {
                    0: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1100: { slidesPerView: 3 },
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
            if (window.innerWidth > 1180) { setOpen(false); }
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

    // ---------------------------------------------------------------- server-side validation UX
    // Forms use Laravel validation (novalidate). After a failed submit, focus the first
    // invalid field; clear a field's error as soon as the visitor edits it.
    function initValidation() {
        var forms = document.querySelectorAll('form[data-validate]');
        forms.forEach(function (form) {
            // jumping to the #fragment after load clears the focus, so focus again then
            var focusFirst = function () {
                var first = form.querySelector('.is-invalid');
                if (first && document.activeElement !== first) {
                    try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); }
                }
            };
            focusFirst();
            if (document.readyState !== 'complete') {
                window.addEventListener('load', function () { setTimeout(focusFirst, 60); });
            } else {
                setTimeout(focusFirst, 60);
            }

            var clear = function (event) {
                var field = event.target;
                if (!field.classList || !field.classList.contains('is-invalid')) { return; }
                field.classList.remove('is-invalid');
                field.setAttribute('aria-invalid', 'false');
                var message = findErrorNode(field);
                if (message) { message.remove(); }
            };
            form.addEventListener('input', clear);
            form.addEventListener('change', clear);
        });
    }

    // ---------------------------------------------------------------- AJAX forms
    // Forms marked [data-ajax] are sent with fetch(): Laravel validates the request and
    // answers 422 + JSON errors (highlighted next to each field) or 200 + a message.
    // Without JavaScript they still work as ordinary forms.
    function findErrorNode(field) {
        if (field.type === 'checkbox') {
            var check = field.closest('.check');
            var next = check && check.nextElementSibling;
            return next && next.classList.contains('field-error') ? next : null;
        }
        if (field.type === 'radio') {
            var group = field.closest('.period-picker, fieldset');
            return group ? group.querySelector('.field-error') : null;
        }
        var holder = field.closest('.field, .field-group') || field.parentElement;
        return holder ? holder.querySelector('.field-error') : null;
    }

    function addFieldError(form, name, message) {
        var field = form.querySelector('[name="' + name + '"]');
        if (!field) { return null; }
        field.classList.add('is-invalid');
        field.setAttribute('aria-invalid', 'true');

        var node = document.createElement('p');
        node.className = 'field-error';
        node.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ';
        node.appendChild(document.createTextNode(message));

        if (field.type === 'checkbox') {
            (field.closest('.check') || field).insertAdjacentElement('afterend', node);
        } else if (field.type === 'radio') {
            (field.closest('.period-picker, fieldset') || field.parentElement).appendChild(node);
        } else {
            var holder = field.closest('.field, .field-group');
            if (holder) { holder.appendChild(node); } else { field.insertAdjacentElement('afterend', node); }
        }
        return field;
    }

    function clearFormFeedback(form) {
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
            el.setAttribute('aria-invalid', 'false');
        });
        form.querySelectorAll('.field-error').forEach(function (el) { el.remove(); });
        // alerts rendered by the server or by a previous submit sit right before the form
        var prev = form.previousElementSibling;
        while (prev && prev.classList.contains('form-alert')) {
            var gone = prev;
            prev = prev.previousElementSibling;
            gone.remove();
        }
    }

    function showFormAlert(form, type, message) {
        var alert = document.createElement('div');
        alert.className = 'form-alert form-alert--' + type;
        alert.setAttribute('role', type === 'success' ? 'status' : 'alert');
        alert.innerHTML = '<i class="fa-solid ' + (type === 'success' ? 'fa-circle-check' : 'fa-triangle-exclamation') + '"></i> ';
        alert.appendChild(document.createTextNode(message));
        form.parentNode.insertBefore(alert, form);

        var rect = alert.getBoundingClientRect();
        if (rect.top < 90 || rect.bottom > window.innerHeight) {
            alert.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        return alert;
    }

    function initAjaxForms() {
        if (!window.fetch || !window.FormData) { return; }

        document.querySelectorAll('form[data-ajax]').forEach(function (form) {
            var busy = false;

            form.addEventListener('submit', function (event) {
                event.preventDefault();
                if (busy) { return; }

                var button = form.querySelector('button[type="submit"]');
                var label = button ? button.textContent : '';
                busy = true;
                clearFormFeedback(form);
                if (button) { button.disabled = true; button.textContent = 'Sending...'; }

                var done = function () {
                    busy = false;
                    if (button) { button.disabled = false; button.textContent = label; }
                };

                fetch(form.getAttribute('action'), {
                    method: 'POST',
                    body: new FormData(form),
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                }).then(function (response) {
                    return response.json().catch(function () { return {}; }).then(function (data) {
                        return { status: response.status, ok: response.ok, data: data };
                    });
                }).then(function (res) {
                    done();

                    if (res.status === 422 && res.data.errors) {
                        var first = null;
                        Object.keys(res.data.errors).forEach(function (name) {
                            var field = addFieldError(form, name, res.data.errors[name][0]);
                            if (field && !first) { first = field; }
                        });
                        var summary = Object.keys(res.data.errors).length === 1 && res.data.errors.car
                            ? res.data.errors.car[0]
                            : 'Please correct the highlighted fields.';
                        showFormAlert(form, 'error', summary);
                        if (first) { try { first.focus({ preventScroll: true }); } catch (e) { first.focus(); } }
                        return;
                    }

                    if (res.status === 429) {
                        showFormAlert(form, 'error', 'Too many attempts. Please wait a minute and try again.');
                        return;
                    }

                    if (res.status === 419) {
                        showFormAlert(form, 'error', 'Your session has expired. Please reload the page and try again.');
                        return;
                    }

                    if (!res.ok) {
                        showFormAlert(form, 'error', 'Something went wrong. Please try again in a moment.');
                        return;
                    }

                    // success
                    var target = form.getAttribute('data-ajax-replace');
                    var container = target ? document.querySelector(target) : null;
                    if (container && res.data.html) {
                        container.innerHTML = res.data.html;
                        container.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        return;
                    }

                    form.reset();
                    showFormAlert(form, 'success', res.data.message || 'Thank you! Your request has been sent.');
                }).catch(function () {
                    done();
                    showFormAlert(form, 'error', 'We could not reach the server. Check your connection and try again.');
                });
            });
        });
    }

    // ---------------------------------------------------------------- cars catalog filters without reload
    function initCatalogFilters() {
        var form = document.querySelector('form[data-ajax-filters]');
        var results = document.getElementById('catalog-results');
        if (!form || !results || !window.fetch || !window.DOMParser) { return; }

        var reset = form.querySelector('[data-filters-reset]');
        var timer = null;

        function queryString() {
            var params = new URLSearchParams();
            new FormData(form).forEach(function (value, key) {
                if (value !== '' && !(key === 'sort' && value === 'newest')) { params.append(key, value); }
            });
            return params.toString();
        }

        function load(url, push) {
            results.classList.add('is-loading');
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'text/html' }, credentials: 'same-origin' })
                .then(function (r) { return r.text(); })
                .then(function (html) {
                    var doc = new DOMParser().parseFromString(html, 'text/html');
                    var fresh = doc.getElementById('catalog-results');
                    if (!fresh) { window.location.href = url; return; }
                    results.innerHTML = fresh.innerHTML;
                    results.classList.remove('is-loading');
                    if (push) { window.history.pushState({ catalog: true }, '', url); }
                    if (reset) { reset.hidden = new URL(url, window.location.href).search === ''; }
                })
                .catch(function () { window.location.href = url; });
        }

        function apply() {
            var qs = queryString();
            load(form.getAttribute('action') + (qs ? '?' + qs : ''), true);
        }

        form.addEventListener('submit', function (event) { event.preventDefault(); apply(); });
        form.addEventListener('change', apply);
        form.addEventListener('input', function (event) {
            if (event.target.type === 'search' || event.target.type === 'number') {
                clearTimeout(timer);
                timer = setTimeout(apply, 450);
            }
        });

        if (reset) {
            reset.addEventListener('click', function (event) {
                event.preventDefault();
                form.reset();
                form.querySelectorAll('input[type="search"], input[type="number"]').forEach(function (i) { i.value = ''; });
                form.querySelectorAll('select').forEach(function (s) { s.selectedIndex = 0; });
                var checkbox = form.querySelector('input[type="checkbox"]');
                if (checkbox) { checkbox.checked = false; }
                apply();
            });
        }

        // pagination links inside the results
        results.addEventListener('click', function (event) {
            var link = event.target.closest('.pager a');
            if (!link) { return; }
            event.preventDefault();
            load(link.href, true);
            form.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });

        window.addEventListener('popstate', function () { load(window.location.href, false); });
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
        ['.page-home .section-support-content-title, .page-home .section-advantages-title, .page-home .reviews__head, .page-home .review-slider, .page-home .section-member-title, .page-home .sc-CoNtn', 'fade-up', 0],
        ['.page-home .sc-AbOgs > div:first-child', 'fade-right', 0],
        ['.page-home .sc-AbOgs > div:last-child', 'fade-left', 0],
        ['.page-home .sc-Fvrha', 'fade-right', 0],
        ['.page-home .section-contact-container-form', 'fade-left', 0],
                ['.car-grid .car-card', 'fade-up', 90],
        ['.page-home .section-featured .sn-title-container, .page-home .section-featured__more', 'fade-up', 0],
        ['.page-offer .sn-title-container, .page-offer .catalog-filters, .page-offer .empty-state', 'fade-up', 0],
        ['.page-plan .plans__head, .page-plan .steps, .page-plan .checkout__summary, .page-plan .checkout__form, .page-plan .thanks-card', 'fade-up', 0],
        ['.page-plan .plan-card', 'fade-up', 120],
        ['.page-plan .step', 'fade-up', 120],
        ['.page-partners .sn-title-container, .page-partners .partner-cta', 'fade-up', 0],
        ['.page-partners .license-card', 'fade-up', 90],
        ['.page-partners .partner-card', 'zoom-in', 80],
        ['.page-history .section-gallery-title, .page-history .section-gallery-subtitle, .page-history .section-about-company-title', 'fade-up', 0],
        ['.page-history .gallery-img', 'zoom-in', 70],
        ['.page-history .section-form-container', 'fade-up', 0],
        ['.page-news .news__head, .page-news .news-slider, .page-news .faq__head, .page-news .faq__cta', 'fade-up', 0],
        ['.page-news .faq-item', 'fade-up', 80],
        ['.page-contacts .contact-info .sn-title-container', 'fade-up', 0],
        ['.page-contacts .info-card', 'fade-up', 100],
        ['.page-contacts .map-card', 'fade-right', 0],
        ['.page-contacts .form-card', 'fade-left', 0],
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
        initValidation();
        initAjaxForms();
        initCatalogFilters();
        initScrollUi();
        initReveal();
    });
})();
