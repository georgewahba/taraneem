document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('browse-filter');
    var filterButtons = Array.from(document.querySelectorAll('[data-letter]'));
    var items = Array.from(document.querySelectorAll('[data-library-item]'));
    var count = document.getElementById('library-count');
    var noResults = document.getElementById('library-no-results');
    var activeLetter = 'all';

    function firstLetter(title) {
        var first = title.trim().normalize('NFD').replace(/[\u0300-\u036f]/g, '').charAt(0).toLocaleUpperCase('en');
        return /^[A-Z]$/.test(first) ? first : 'other';
    }

    function updateLibrary() {
        var term = input ? input.value.trim().toLocaleLowerCase() : '';
        var visibleCount = 0;

        items.forEach(function (item) {
            var titleElement = item.querySelector('.library-item-title');
            var title = (titleElement ? titleElement.textContent : item.textContent).trim().toLocaleLowerCase();
            var matchesTerm = title.includes(term);
            var matchesLetter = activeLetter === 'all' || firstLetter(title) === activeLetter;
            var visible = matchesTerm && matchesLetter;

            item.hidden = !visible;

            if (visible) {
                visibleCount += 1;
            }
        });

        if (count) {
            count.textContent = visibleCount === 1 ? '1 hymn found' : visibleCount + ' hymns found';
        }

        if (noResults) {
            noResults.hidden = visibleCount > 0;
        }
    }

    if (input) {
        input.addEventListener('input', updateLibrary);
        input.form.addEventListener('submit', function (event) {
            event.preventDefault();
        });
    }

    filterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            activeLetter = button.dataset.letter;

            filterButtons.forEach(function (filterButton) {
                filterButton.classList.toggle('is-active', filterButton === button);
                filterButton.setAttribute('aria-pressed', String(filterButton === button));
            });

            updateLibrary();
        });
    });

    updateLibrary();
});
