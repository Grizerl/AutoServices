// Subscription plan tabs (Silver / Platinum / Gold)
document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('[data-plan-tab]');
    var panels = document.querySelectorAll('[data-plan-panel]');
    if (!tabs.length) { return; }

    function show(name) {
        tabs.forEach(function (tab) {
            tab.classList.toggle('active', tab.dataset.planTab === name);
        });
        panels.forEach(function (panel) {
            panel.classList.toggle('show', panel.dataset.planPanel === name);
        });
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function (event) {
            event.preventDefault();
            show(tab.dataset.planTab);
        });
    });
});
