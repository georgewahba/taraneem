document.addEventListener('DOMContentLoaded', function () {
    var body = document.body;
    var navToggle = document.querySelector('[data-nav-toggle]');
    var navigation = document.getElementById('site-navigation');

    function closeNavigation() {
        body.classList.remove('nav-open');

        if (navToggle) {
            navToggle.setAttribute('aria-expanded', 'false');
            navToggle.setAttribute('aria-label', 'Open menu');
            navToggle.setAttribute('title', 'Open menu');
            navToggle.querySelector('i').className = 'fa-solid fa-bars';
        }
    }

    if (navToggle && navigation) {
        navToggle.addEventListener('click', function () {
            var isOpen = body.classList.toggle('nav-open');
            navToggle.setAttribute('aria-expanded', String(isOpen));
            navToggle.setAttribute('aria-label', isOpen ? 'Close menu' : 'Open menu');
            navToggle.setAttribute('title', isOpen ? 'Close menu' : 'Open menu');
            navToggle.querySelector('i').className = isOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-bars';
        });

        navigation.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', closeNavigation);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeNavigation();
            }
        });

        document.addEventListener('click', function (event) {
            if (body.classList.contains('nav-open') && !navigation.contains(event.target) && !navToggle.contains(event.target)) {
                closeNavigation();
            }
        });
    }

    var themeToggle = document.querySelector('[data-presentation-theme-toggle]');
    var themeKey = 'taraneem-presentation-theme';
    var immersiveTheme = true;

    try {
        immersiveTheme = sessionStorage.getItem(themeKey) !== 'quiet';
    } catch (error) {
        immersiveTheme = true;
    }

    function syncThemeToggle() {
        if (!themeToggle) {
            return;
        }

        themeToggle.setAttribute('aria-pressed', String(immersiveTheme));
        themeToggle.querySelector('i').className = immersiveTheme ? 'fa-solid fa-sun' : 'fa-solid fa-moon';
    }

    if (themeToggle) {
        syncThemeToggle();

        themeToggle.addEventListener('click', function () {
            immersiveTheme = !immersiveTheme;
            try {
                sessionStorage.setItem(themeKey, immersiveTheme ? 'immersive' : 'quiet');
            } catch (error) {
                // The current page remains usable when browser storage is unavailable.
            }
            syncThemeToggle();
        });
    }
});
