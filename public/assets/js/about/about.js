// News slider + FAQ accordion (About > Company news)
document.addEventListener('DOMContentLoaded', function () {
    var news = document.querySelector('.mySwiper-3');
    if (news && typeof Swiper !== 'undefined') {
        new Swiper(news, {
            navigation: {
                nextEl: '.swiper-news-container .swiper-button-next',
                prevEl: '.swiper-news-container .swiper-button-prev',
            },
        });
    }

    document.querySelectorAll('.according-bth').forEach(function (btn) {
        var content = btn.parentElement.nextElementSibling;
        if (!content) { return; }

        btn.setAttribute('role', 'button');
        btn.setAttribute('tabindex', '0');
        btn.setAttribute('aria-expanded', 'false');

        var toggle = function () {
            var open = !content.style.maxHeight;
            btn.classList.toggle('active', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
            content.style.maxHeight = open ? content.scrollHeight + 'px' : null;
        };

        btn.addEventListener('click', toggle);
        btn.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                toggle();
            }
        });
    });
});
