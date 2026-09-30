document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('filter');
    var panel = document.getElementById('taraneemList');
    var clearButton = document.getElementById('clear-search');
    var results = Array.from(document.querySelectorAll('[data-search-result]'));
    var count = document.getElementById('search-result-count');
    var noResults = document.getElementById('search-no-results');

    if (!input || !panel) {
        return;
    }

    function updateSearch() {
        var term = input.value.trim().toLocaleLowerCase();
        var visibleCount = 0;

        results.forEach(function (result) {
            var matches = result.textContent.toLocaleLowerCase().includes(term);
            result.hidden = !matches;

            if (matches) {
                visibleCount += 1;
            }
        });

        panel.hidden = term.length === 0;
        clearButton.hidden = term.length === 0;

        if (term.length > 0 && count) {
            count.textContent = visibleCount === 1 ? '1 hymn found' : visibleCount + ' hymns found';
        }

        if (noResults) {
            noResults.hidden = visibleCount > 0 || term.length === 0;
        }
    }

    input.addEventListener('input', updateSearch);

    input.form.addEventListener('submit', function (event) {
        event.preventDefault();
    });

    input.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            input.value = '';
            updateSearch();
        }
    });

    clearButton.addEventListener('click', function () {
        input.value = '';
        updateSearch();
        input.focus();
    });

    updateSearch();
});
