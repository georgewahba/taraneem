document.addEventListener('DOMContentLoaded', function () {
    var searchInput = document.getElementById('track-search');
    var trackButtons = Array.from(document.querySelectorAll('[data-track-button]'));
    var title = document.getElementById('player-track-title');
    var artist = document.getElementById('player-track-artist');
    var audio = document.getElementById('player-audio');
    var noResults = document.getElementById('track-no-results');
    var errorMessage = document.getElementById('player-error');

    function selectTrack(button) {
        if (!audio || !title || !artist) {
            return;
        }

        trackButtons.forEach(function (trackButton) {
            var selected = trackButton === button;
            trackButton.classList.toggle('is-selected', selected);
            trackButton.setAttribute('aria-pressed', String(selected));
        });

        title.textContent = button.dataset.title || '';
        artist.textContent = button.dataset.artist || '';
        audio.pause();
        audio.querySelector('source').setAttribute('src', button.dataset.file || '');
        if (errorMessage) {
            errorMessage.hidden = true;
        }
        audio.load();
    }

    trackButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            selectTrack(button);
        });
    });

    if (audio && errorMessage) {
        function showAudioError() {
            errorMessage.hidden = false;
        }

        audio.addEventListener('error', showAudioError);
        audio.querySelector('source').addEventListener('error', showAudioError);
        audio.addEventListener('loadedmetadata', function () {
            errorMessage.hidden = true;
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            var term = searchInput.value.trim().toLocaleLowerCase();
            var visibleCount = 0;

            trackButtons.forEach(function (button) {
                var titleValue = (button.dataset.title || '').toLocaleLowerCase();
                var artistValue = (button.dataset.artist || '').toLocaleLowerCase();
                var visible = titleValue.includes(term) || artistValue.includes(term);

                button.hidden = !visible;

                if (visible) {
                    visibleCount += 1;
                }
            });

            if (noResults) {
                noResults.hidden = visibleCount > 0 || trackButtons.length === 0;
            }
        });
    }
});
