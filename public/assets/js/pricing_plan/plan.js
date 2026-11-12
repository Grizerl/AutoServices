// Subscription plans: switch between monthly and yearly prices without reloading.
// Without JavaScript the toggle buttons are plain links (?period=yearly) and still work.
document.addEventListener('DOMContentLoaded', function () {
    var root = document.querySelector('[data-plans]');
    if (!root) { return; }

    var buttons = root.querySelectorAll('[data-period-btn]');
    var links = root.querySelectorAll('[data-checkout-link]');

    function setPeriod(period) {
        root.setAttribute('data-period', period);

        buttons.forEach(function (btn) {
            var active = btn.getAttribute('data-period-btn') === period;
            btn.classList.toggle('is-active', active);
            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        // keep the "Choose" buttons pointing at the selected period
        links.forEach(function (link) {
            link.setAttribute('href', link.getAttribute('data-base') + '?period=' + period);
        });

        if (window.history && window.history.replaceState) {
            var url = new URL(window.location.href);
            url.searchParams.set('period', period);
            window.history.replaceState(null, '', url);
        }
    }

    buttons.forEach(function (btn) {
        btn.addEventListener('click', function (event) {
            event.preventDefault();
            setPeriod(btn.getAttribute('data-period-btn'));
        });
    });
});
