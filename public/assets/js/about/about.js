// News slider + FAQ (News & FAQ page)
document.addEventListener('DOMContentLoaded', function () {
    var news = document.querySelector('.news-slider');
    if (news && typeof Swiper !== 'undefined') {
        new Swiper(news, {
            slidesPerView: 1,
            spaceBetween: 24,
            speed: 600,
            autoHeight: false,
            autoplay: { delay: 6000, disableOnInteraction: true },
            navigation: { nextEl: '.news-next', prevEl: '.news-prev' },
            pagination: { el: '.news-pagination', clickable: true },
            breakpoints: {
                768: { slidesPerView: 2 },
                1100: { slidesPerView: 3 },
            },
        });
    }

    // FAQ: native <details>; keep a single answer open at a time
    var faq = document.querySelector('[data-faq]');
    if (faq) {
        faq.addEventListener('toggle', function (event) {
            var opened = event.target;
            if (!opened.open) { return; }
            faq.querySelectorAll('details[open]').forEach(function (item) {
                if (item !== opened) { item.removeAttribute('open'); }
            });
        }, true);
    }
});
