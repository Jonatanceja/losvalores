// Sticky navigation bar.
// The bar marked [data-nav-sticky] stays hidden (translated up) until the top
// navigation [data-nav-top] scrolls out of view, then it slides into place.

function initStickyNav() {
    const top = document.querySelector('[data-nav-top]');
    const sticky = document.querySelector('[data-nav-sticky]');

    if (!top || !sticky) {
        return;
    }

    const setVisible = (visible) => {
        sticky.classList.toggle('translate-y-0', visible);
        sticky.classList.toggle('-translate-y-full', !visible);
    };

    const observer = new IntersectionObserver(
        ([entry]) => setVisible(!entry.isIntersecting),
        { threshold: 0 }
    );

    observer.observe(top);
}

// Full-screen mobile menu: any [data-menu-open] opens the [data-menu] panel,
// [data-menu-close] (and any link inside) closes it; the page scroll is locked
// while it is open.
function initMobileMenu() {
    const menu = document.querySelector('[data-menu]');

    if (!menu) {
        return;
    }

    const open = () => {
        menu.classList.remove('translate-x-full');
        menu.classList.add('translate-x-0');
        document.documentElement.classList.add('overflow-hidden');
    };

    const close = () => {
        menu.classList.add('translate-x-full');
        menu.classList.remove('translate-x-0');
        document.documentElement.classList.remove('overflow-hidden');
    };

    document.querySelectorAll('[data-menu-open]').forEach((el) => el.addEventListener('click', open));
    document.querySelectorAll('[data-menu-close]').forEach((el) => el.addEventListener('click', close));
    menu.querySelectorAll('a[href]').forEach((el) => el.addEventListener('click', close));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            close();
        }
    });
}

function init() {
    initStickyNav();
    initMobileMenu();
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init();
}
