<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0a2117">
    <title>{{ $taraneem->titel }} | Taraneem</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/presentation.css') }}">
</head>
<body class="presenter-page">
    <main class="presentation-shell">
        <header class="presenter-header">
            <a class="presenter-close" href="{{ route('home') }}" aria-label="Close presentation" title="Close presentation">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            </a>

            <div class="presenter-brand">
                <img src="{{ asset('images/mini-logo.png') }}" alt="">
                <span>{{ $taraneem->titel }}</span>
            </div>

            <button class="presenter-fullscreen" id="fullscreen-toggle" type="button" aria-label="Enter fullscreen" title="Enter fullscreen">
                <i class="fa-solid fa-expand" aria-hidden="true"></i>
            </button>
        </header>

        <section class="presenter-stage" aria-label="Hymn presentation">
            <div class="presenter-count" id="pageInfo" aria-live="polite"></div>
            <div class="presenter-content">
                <article class="presenter-lyrics" id="visibletext" dir="auto" aria-live="polite" aria-atomic="true"></article>
                <div class="presenter-ending-mark" id="imageDiv" hidden>
                    <img src="{{ asset('images/mini-logo.png') }}" alt="Taraneem, end of hymn">
                </div>
            </div>
            <p class="presenter-status" id="presenter-status" role="status" hidden></p>
        </section>

        <nav class="presenter-controls" aria-label="Presentation controls">
            <button id="previous-slide" type="button" aria-label="Previous slide" title="Previous slide">
                <i class="fa-solid fa-chevron-left" aria-hidden="true"></i>
            </button>
            <button id="next-slide" type="button" aria-label="Next slide" title="Next slide">
                <i class="fa-solid fa-chevron-right" aria-hidden="true"></i>
            </button>
        </nav>
    </main>

    <script id="lyric-data" type="application/json">@json($taraneem->lyrics)</script>
    <script src="{{ asset('js/show.js') }}"></script>
</body>
</html>
