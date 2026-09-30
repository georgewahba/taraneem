@extends('layouts.public')

@section('title', 'Share a suggestion | Taraneem')
@section('meta-description', 'Help the Taraneem collection grow with hymn lyrics or a correction.')

@section('content')
    <section class="form-intro" aria-labelledby="suggestion-title">
        <div class="site-shell">
            <p class="eyebrow">Better together</p>
            <h1 id="suggestion-title">Share a hymn that belongs here.</h1>
            <p>A new hymn or a small correction can mean a lot to someone.</p>
        </div>
    </section>

    <section class="form-section">
        <div class="site-shell">
            <form class="contribution-form" action="{{ route('storesuggestion') }}" method="POST">
                @csrf

                <div class="form-field">
                    <label for="titel">Title</label>
                    <input id="titel" name="titel" type="text" value="{{ old('titel') }}" maxlength="255" required>
                    @error('titel')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-field">
                    <label for="lyrics">Lyrics</label>
                    <textarea id="lyrics" name="lyrics" required>{{ old('lyrics') }}</textarea>
                    @error('lyrics')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-actions">
                    <p class="form-note">Thank you for helping our collection grow.</p>
                    <button class="button button-primary" type="submit">
                        <span>Send suggestion</span>
                        <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
