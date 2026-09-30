@extends('layouts.public')

@section('title', 'Music | Taraneem')
@section('meta-description', 'Listen to music from the Taraneem collection.')
@section('body-class', 'player-page')

@section('content')
    @php($firstTrack = $tracks->first())

    <section class="player-intro" aria-labelledby="player-title">
        <div class="site-shell">
            <p class="eyebrow">Music</p>
            <h1 id="player-title">Let the music stay with you.</h1>
            <p>Melodies for quiet moments and voices lifted together.</p>
        </div>
    </section>

    <section class="site-shell" aria-label="Music player">
        <div class="player-layout">
            <aside class="track-browser">
                <div class="track-browser-header">
                    <h2>All tracks</h2>
                    <label class="track-search" for="track-search">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                        <span class="sr-only">Search by title or artist</span>
                        <input id="track-search" type="search" autocomplete="off" placeholder="Search by title or artist">
                    </label>
                </div>

                <div class="track-list" id="tracklist">
                    @forelse ($tracks as $index => $track)
                        <button
                            class="track-list-button {{ $index === 0 ? 'is-selected' : '' }}"
                            type="button"
                            data-track-button
                            data-title="{{ $track->title }}"
                            data-artist="{{ $track->artist ?? '' }}"
                            data-file="{{ asset('storage/' . $track->file) }}"
                            aria-pressed="{{ $index === 0 ? 'true' : 'false' }}"
                        >
                            <span class="track-list-number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span>
                                <span class="track-list-title">{{ $track->title }}</span>
                                @if ($track->artist)
                                    <span class="track-list-artist">{{ $track->artist }}</span>
                                @endif
                            </span>
                            <i class="fa-solid fa-play" aria-hidden="true"></i>
                        </button>
                    @empty
                        <p class="track-empty">No tracks have been added yet.</p>
                    @endforelse
                    <p class="track-empty" id="track-no-results" hidden>No tracks found.</p>
                </div>
            </aside>

            @if ($firstTrack)
                <section class="now-playing" aria-live="polite">
                    <div class="now-playing-mark">
                        <img src="{{ asset('images/mini-logo.png') }}" alt="">
                    </div>
                    <p class="eyebrow">Now selected</p>
                    <h2 id="player-track-title">{{ $firstTrack->title }}</h2>
                    <p class="now-playing-artist" id="player-track-artist">{{ $firstTrack->artist }}</p>
                    <audio id="player-audio" controls preload="metadata">
                        <source src="{{ asset('storage/' . $firstTrack->file) }}">
                        Your browser does not support audio playback.
                    </audio>
                    <p class="player-error" id="player-error" role="status" hidden>This track could not be loaded. Please choose another track.</p>
                </section>
            @else
                <section class="player-empty-state">
                    <p>The first tracks are on their way.</p>
                </section>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/player.js') }}"></script>
@endpush
