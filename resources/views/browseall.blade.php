@extends('layouts.public')

@section('title', 'All hymns | Taraneem')
@section('meta-description', 'Explore every hymn in the Taraneem collection.')

@section('content')
    @php($library = $taraneem->values())

    <section class="library-intro" aria-labelledby="library-title">
        <div class="site-shell">
            <p class="eyebrow">The collection</p>
            <h1 id="library-title">A hymn for every moment.</h1>
            <p>Familiar favourites and words waiting to become part of your worship.</p>

            <div class="library-tools">
                <form class="library-search" id="browse-search" role="search" novalidate>
                    <label class="sr-only" for="browse-filter">Search hymns</label>
                    <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    <input id="browse-filter" type="search" autocomplete="off" placeholder="Search by title">
                </form>

                <div class="letter-filters" aria-label="Filter by first letter">
                    <button class="letter-filter is-active" type="button" data-letter="all" aria-pressed="true">All</button>
                    <button class="letter-filter" type="button" data-letter="other" aria-pressed="false">0-9</button>
                    @foreach (range('A', 'Z') as $letter)
                        <button class="letter-filter" type="button" data-letter="{{ $letter }}" aria-pressed="false">{{ $letter }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="library-section" aria-labelledby="library-title">
        <div class="site-shell">
            <div class="library-summary">
                <span id="library-count" aria-live="polite">{{ $library->count() }} hymns</span>
                <span>Alphabetical order</span>
            </div>

            <div class="library-grid" id="taraneemList">
                @forelse ($library as $index => $tarnima)
                    <a class="library-item" data-library-item href="{{ route('taraneem.show', $tarnima) }}">
                        <span class="library-item-number">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                        <span class="library-item-title" dir="auto">{{ $tarnima->titel }}</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </a>
                @empty
                    <p class="library-empty">No hymns have been added yet.</p>
                @endforelse
                <p class="library-empty" id="library-no-results" hidden>No hymns found.</p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('js/browse.js') }}"></script>
@endpush
