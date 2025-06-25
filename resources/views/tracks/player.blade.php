<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Muziekspeler</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="32x32">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <link rel="stylesheet" href="{{ asset('css/browse.css') }}">
    <link rel="stylesheet" href="{{ asset('css/tracks.css') }}">

</head>
<body>
    <div class="menu-icon" id="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/browseall">Bekijk Alle Taraneem</a></li> 
            <li><a href="/public-musicplayer">Muziekspeler</a></li>
        </ul>
    </div>

    <h1 style="text-align:center;margin-top:2rem;margin-bottom:1.2rem;">Muziekspeler</h1>
    <div class="musicplayer-main">
        <!-- Sidebar met zoekbox en tracks -->
        <aside class="musicplayer-sidebar">
            <h2>Alle tracks</h2>
            <div class="sidebar-searchbox">
                <input
                    type="text"
                    id="track-search"
                    placeholder="Zoek op titel of artiest…"
                    autocomplete="off"
                >
            </div>
            <div class="tracklist" id="tracklist">
                @foreach($tracks as $i => $track)
                    <button class="tracklist-btn{{ $i === 0 ? ' selected' : '' }}"
                        data-index="{{ $i }}"
                        data-title="{{ strtolower($track->title) }}"
                        data-artist="{{ strtolower($track->artist) }}"
                        data-file="{{ asset('storage/' . $track->file) }}"
                    >
                        <div>
                            <div class="tracklist-title">{{ $track->title }}</div>
                            @if($track->artist)
                                <div class="tracklist-artist">{{ $track->artist }}</div>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>
        </aside>

        <!-- Player card rechts -->
        <main class="musicplayer-content">
            @php
                $first = $tracks->first();
            @endphp
            <div class="player-card" id="player-card">
                <div class="player-cover">
                    <img src="{{ asset('images/mini-logo.png') }}" alt="cover">
                </div>
                <div class="player-title" id="player-title">{{ $first?->title ?? '-' }}</div>
                <div class="player-artist" id="player-artist">{{ $first?->artist ?? '' }}</div>
                <audio class="player-audio" id="player-audio" controls preload="none">
                    @if($first)
                        <source src="{{ asset('storage/' . $first->file) }}" type="audio/mpeg">
                    @endif
                    Je browser ondersteunt geen audio.
                </audio>
            </div>
        </main>
    </div>
    <script>
        // Menu toggle
        function toggleMenu() {
            const menu = document.getElementById('menu');
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('menu');
            const icon = document.getElementById('menu-icon');
            if (!menu.contains(event.target) && event.target !== icon) {
                menu.style.display = 'none';
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const trackBtns = document.querySelectorAll('.tracklist-btn');
            const title = document.getElementById('player-title');
            const artist = document.getElementById('player-artist');
            const audio = document.getElementById('player-audio');

            // Player logic
            trackBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    trackBtns.forEach(b => b.classList.remove('selected'));
                    btn.classList.add('selected');
                    title.textContent = btn.getAttribute('data-title');
                    artist.textContent = btn.getAttribute('data-artist');
                    audio.pause();
                    audio.currentTime = 0;
                    audio.querySelector('source').setAttribute('src', btn.getAttribute('data-file'));
                    audio.load();
                });
            });

            // SEARCH
            const searchInput = document.getElementById('track-search');
            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const term = searchInput.value.trim().toLowerCase();
                    trackBtns.forEach(btn => {
                        const title = btn.getAttribute('data-title');
                        const artist = btn.getAttribute('data-artist');
                        if (title.includes(term) || artist.includes(term)) {
                            btn.style.display = '';
                        } else {
                            btn.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>
