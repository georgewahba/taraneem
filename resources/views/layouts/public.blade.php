<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#0a2117">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="description" content="@yield('meta-description', 'Hymns, lyrics and music, together in Taraneem.')">
    <title>@yield('title', 'Taraneem')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/mini-logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700,800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    @stack('styles')
</head>
<body class="@yield('body-class') {{ session('success') ? 'has-flash' : '' }}">
    <a class="skip-link" href="#main-content">Skip to content</a>

    <header class="site-header">
        <div class="site-shell site-header-inner">
            <a class="brand" href="{{ route('home') }}" aria-label="Taraneem home">
                <img class="brand-mark" src="{{ asset('images/mini-logo.png') }}" alt="">
                <span>Taraneem</span>
            </a>

            <div class="site-header-actions">
                <button
                    class="icon-button presentation-theme-toggle"
                    type="button"
                    data-presentation-theme-toggle
                    aria-label="Use illustrated presentation backgrounds"
                    aria-pressed="true"
                    title="Use illustrated presentation backgrounds"
                >
                    <i class="fa-solid fa-sun" aria-hidden="true"></i>
                </button>
                <button
                    class="icon-button site-nav-toggle"
                    type="button"
                    data-nav-toggle
                    aria-label="Open menu"
                    title="Open menu"
                    aria-controls="site-navigation"
                    aria-expanded="false"
                >
                    <i class="fa-solid fa-bars" aria-hidden="true"></i>
                </button>
            </div>

            <nav class="site-nav" id="site-navigation" aria-label="Main navigation">
                <a class="{{ request()->routeIs('home') ? 'is-active' : '' }}" href="{{ route('home') }}">Home</a>
                <a class="{{ request()->routeIs('browseall') ? 'is-active' : '' }}" href="{{ route('browseall') }}">Hymns</a>
                <a class="{{ request()->routeIs('tracks.player') ? 'is-active' : '' }}" href="{{ route('tracks.player') }}">Music</a>
                <a class="{{ request()->routeIs('suggestion') ? 'is-active' : '' }}" href="{{ route('suggestion') }}">Suggestions</a>
            </nav>
        </div>
    </header>

    <main id="main-content">
        @if (session('success'))
            <div class="site-shell">
                <div class="site-flash" role="status">
                    <i class="fa-solid fa-circle-check" aria-hidden="true"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="site-shell site-footer-inner">
            <div class="footer-brand">
                <img src="{{ asset('images/mini-logo.png') }}" alt="">
                <div>
                    <strong>Taraneem</strong>
                    <span>Hymns to bring us together.</span>
                </div>
            </div>
            <div class="footer-links">
                <a href="{{ route('browseall') }}">Hymns</a>
                <a href="{{ route('tracks.player') }}">Music</a>
                <a href="{{ route('suggestion') }}">Send a suggestion</a>
            </div>
            <span class="footer-copyright">© {{ now()->year }} Taraneem</span>
        </div>
    </footer>

    <script src="{{ asset('js/site.js') }}"></script>
    @stack('scripts')
</body>
</html>
