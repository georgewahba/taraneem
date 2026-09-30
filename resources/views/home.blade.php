@extends('layouts.public')

@section('title', 'Taraneem | Hymns to bring us together')
@section('meta-description', 'Find hymn lyrics, present them on the big screen and listen to music with Taraneem.')
@section('body-class', 'home-page')

@section('content')
    @php($library = $taraneem->values())

    <section class="hero" aria-labelledby="hero-title">
        <div class="site-shell hero-content">
            <p class="eyebrow">Taraneem</p>
            <h1 id="hero-title">Hymns that bring us together.</h1>
            <p class="hero-lead">Find the words, share them on the big screen, and make room for music.</p>

            <form class="hero-search" id="library-search" role="search" novalidate>
                <label class="sr-only" for="filter">Search hymns</label>
                <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                <input id="filter" name="filter" type="search" autocomplete="off" placeholder="Search hymns" aria-controls="taraneemList">
                <button class="search-clear" id="clear-search" type="button" hidden aria-label="Clear search" title="Clear search">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </form>

            <div class="search-panel" id="taraneemList" hidden>
                <span class="search-panel-meta" id="search-result-count" aria-live="polite"></span>
                <div class="search-results">
                    @forelse ($library as $tarnima)
                        <a class="search-result" data-search-result href="{{ route('taraneem.show', $tarnima) }}">
                            <span>{{ $tarnima->titel }}</span>
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    @empty
                        <p class="search-no-results">The first hymns are on their way.</p>
                    @endforelse
                    <p class="search-no-results" id="search-no-results" hidden>No hymns found.</p>
                </div>
            </div>

            <div class="hero-actions">
                <a class="button button-primary" href="{{ route('browseall') }}">
                    <span>Explore hymns</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
                <a class="button button-secondary" href="{{ route('tracks.player') }}">
                    <i class="fa-solid fa-play" aria-hidden="true"></i>
                    <span>Listen to music</span>
                </a>
            </div>

            <dl class="hero-meta">
                <div>
                    <dt>{{ $library->count() }}</dt>
                    <dd>hymns in the collection</dd>
                </div>
                <div>
                    <dt>One place</dt>
                    <dd>for lyrics and music</dd>
                </div>
            </dl>
        </div>
    </section>

    <section class="collection-section" aria-labelledby="collection-title">
        <div class="site-shell">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">From the collection</p>
                    <h2 id="collection-title">Ready to sing together.</h2>
                </div>
                <a class="text-link" href="{{ route('browseall') }}">
                    <span>View all hymns</span>
                    <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>

            @if ($library->isNotEmpty())
                <div class="lyric-list">
                    @foreach ($library->take(6) as $index => $tarnima)
                        <a class="lyric-row" href="{{ route('taraneem.show', $tarnima) }}">
                            <span class="lyric-index">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            <span class="lyric-title">{{ $tarnima->titel }}</span>
                            <i class="fa-solid fa-arrow-right lyric-row-arrow" aria-hidden="true"></i>
                        </a>
                    @endforeach
                </div>
            @else
                <p class="empty-library">No hymns have been added yet.</p>
            @endif
        </div>
    </section>

    <section class="paths-section" aria-label="Explore Taraneem">
        <div class="site-shell path-grid">
            <a class="path-link" href="{{ route('browseall') }}">
                <i class="fa-solid fa-book-open" aria-hidden="true"></i>
                <strong>Hymns</strong>
                <span>Words for every moment of worship.</span>
            </a>
            <a class="path-link" href="{{ route('tracks.player') }}">
                <i class="fa-solid fa-headphones" aria-hidden="true"></i>
                <strong>Music</strong>
                <span>Melodies to return to, wherever you are.</span>
            </a>
            <a class="path-link" href="{{ route('suggestion') }}">
                <i class="fa-solid fa-pen-to-square" aria-hidden="true"></i>
                <strong>Suggestions</strong>
                <span>A collection shaped by our community.</span>
            </a>
        </div>
    </section>

    <section class="contribution-band" aria-labelledby="contribution-title">
        <div class="site-shell contribution-band-inner">
            <div>
                <p class="eyebrow">Better together</p>
                <h2 id="contribution-title">Know a hymn that belongs here?</h2>
            </div>
            <a class="button button-primary" href="{{ route('suggestion') }}">
                <span>Share a suggestion</span>
                <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/home.js') }}"></script>
@endpush
