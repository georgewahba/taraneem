document.addEventListener('DOMContentLoaded', function () {
    var dataElement = document.getElementById('lyric-data');
    var lyricTarget = document.getElementById('visibletext');
    var stage = document.querySelector('.presenter-stage');
    var content = document.querySelector('.presenter-content');
    var countTarget = document.getElementById('pageInfo');
    var previousButton = document.getElementById('previous-slide');
    var nextButton = document.getElementById('next-slide');
    var fullscreenButton = document.getElementById('fullscreen-toggle');
    var endingMark = document.getElementById('imageDiv');
    var status = document.getElementById('presenter-status');
    var currentSlide = 0;
    var hideControlsTimer;
    var resizeFrame;
    var lyrics = '';

    if (!dataElement || !lyricTarget || !stage || !content) {
        return;
    }

    try {
        lyrics = JSON.parse(dataElement.textContent);
    } catch (error) {
        lyrics = dataElement.textContent;
    }

    var slides = String(lyrics || '').split('#').map(function (slide) {
        return slide.trim();
    }).filter(function (slide) {
        return slide.length > 0;
    });

    if (!slides.length) {
        slides.push('');
    }
    var lastSlide = slides.length - 1;

    function setPresentationTheme() {
        var immersive = true;
        try {
            immersive = sessionStorage.getItem('taraneem-presentation-theme') !== 'quiet';
        } catch (error) {
            immersive = true;
        }
        document.body.dataset.presentationTheme = immersive ? 'immersive' : 'quiet';
        document.body.dataset.backdrop = String(Math.floor(Math.random() * 6) + 1);
    }

    function fitLyrics() {
        if (lyricTarget.hidden) {
            return;
        }
        lyricTarget.style.removeProperty('font-size');
        var size = parseFloat(getComputedStyle(lyricTarget).fontSize);
        var stageStyle = getComputedStyle(stage);
        var availableHeight = stage.clientHeight - parseFloat(stageStyle.paddingTop) - parseFloat(stageStyle.paddingBottom);
        if (!endingMark.hidden) {
            availableHeight -= endingMark.offsetHeight + (parseFloat(getComputedStyle(content).rowGap) || 0);
        }
        while (size > 14 && (lyricTarget.scrollHeight > availableHeight || lyricTarget.scrollWidth > lyricTarget.clientWidth)) {
            size -= 1;
            lyricTarget.style.fontSize = size + 'px';
        }
    }

    function renderLyrics(text) {
        var lines = text.split('@').map(function (line) {
            return line.trim();
        });
        while (lines.length && !lines[lines.length - 1]) {
            lines.pop();
        }
        var fragment = document.createDocumentFragment();
        lines.forEach(function (line, index) {
            fragment.appendChild(document.createTextNode(line));
            if (index < lines.length - 1) {
                fragment.appendChild(document.createElement('br'));
            }
        });
        lyricTarget.replaceChildren(fragment);
    }

    function showControls() {
        clearTimeout(hideControlsTimer);
        document.body.classList.remove('is-idle');
        if (document.fullscreenElement) {
            hideControlsTimer = setTimeout(function () {
                document.body.classList.add('is-idle');
            }, 2000);
        }
    }

    function updateSlide() {
        var isEnding = currentSlide === lastSlide;
        endingMark.hidden = !isEnding;
        renderLyrics(slides[currentSlide]);
        lyricTarget.classList.remove('is-changing');
        fitLyrics();
        void lyricTarget.offsetWidth;
        lyricTarget.classList.add('is-changing');
        countTarget.textContent = String(currentSlide + 1) + ' / ' + String(lastSlide + 1);
        previousButton.disabled = currentSlide === 0;
        nextButton.disabled = isEnding;
        showControls();
    }

    function showPrevious() {
        if (currentSlide > 0) {
            currentSlide -= 1;
            updateSlide();
        }
    }

    function showNext() {
        if (currentSlide < lastSlide) {
            currentSlide += 1;
            updateSlide();
        }
    }

    async function toggleFullscreen() {
        try {
            status.hidden = true;
            if (document.fullscreenElement) {
                await document.exitFullscreen();
            } else if (document.documentElement.requestFullscreen) {
                await document.documentElement.requestFullscreen();
            } else {
                status.textContent = 'Fullscreen is not available in this browser.';
                status.hidden = false;
            }
        } catch (error) {
            status.textContent = 'Fullscreen could not be opened. You can continue presenting here.';
            status.hidden = false;
        }
    }

    previousButton.addEventListener('click', showPrevious);
    nextButton.addEventListener('click', showNext);
    fullscreenButton.addEventListener('click', toggleFullscreen);

    document.addEventListener('fullscreenchange', function () {
        var isFullscreen = Boolean(document.fullscreenElement);
        var label = isFullscreen ? 'Exit fullscreen' : 'Enter fullscreen';
        fullscreenButton.setAttribute('aria-label', label);
        fullscreenButton.setAttribute('title', label);
        fullscreenButton.querySelector('i').className = isFullscreen ? 'fa-solid fa-compress' : 'fa-solid fa-expand';
        showControls();
        requestAnimationFrame(fitLyrics);
    });

    document.addEventListener('pointermove', showControls, { passive: true });
    document.addEventListener('pointerdown', showControls, { passive: true });
    document.addEventListener('focusin', showControls);

    document.addEventListener('keydown', function (event) {
        showControls();
        if (event.altKey || event.ctrlKey || event.metaKey || /INPUT|TEXTAREA|SELECT/.test(event.target.tagName)) {
            return;
        }
        if (['ArrowRight', 'ArrowDown', 'PageDown'].includes(event.key)) {
            event.preventDefault();
            showNext();
        } else if (['ArrowLeft', 'ArrowUp', 'PageUp'].includes(event.key)) {
            event.preventDefault();
            showPrevious();
        } else if (event.key === 'Home') {
            event.preventDefault();
            currentSlide = 0;
            updateSlide();
        } else if (event.key === 'End') {
            event.preventDefault();
            currentSlide = lastSlide;
            updateSlide();
        } else if (event.key.toLowerCase() === 'f') {
            event.preventDefault();
            toggleFullscreen();
        }
    });

    var startTouch = null;
    document.addEventListener('touchstart', function (event) {
        startTouch = event.changedTouches[0];
        showControls();
    }, { passive: true });

    document.addEventListener('touchend', function (event) {
        if (!startTouch) {
            return;
        }
        var touch = event.changedTouches[0];
        var horizontalDistance = touch.clientX - startTouch.clientX;
        var verticalDistance = touch.clientY - startTouch.clientY;
        if (Math.abs(horizontalDistance) > 48 && Math.abs(horizontalDistance) > Math.abs(verticalDistance)) {
            if (horizontalDistance < 0) {
                showNext();
            } else {
                showPrevious();
            }
        }
        startTouch = null;
    }, { passive: true });

    document.addEventListener('touchcancel', function () {
        startTouch = null;
    }, { passive: true });

    window.addEventListener('resize', function () {
        cancelAnimationFrame(resizeFrame);
        resizeFrame = requestAnimationFrame(fitLyrics);
    });
    if (document.fonts) {
        document.fonts.ready.then(fitLyrics);
    }
    setPresentationTheme();
    updateSlide();
});
