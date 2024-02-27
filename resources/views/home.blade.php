<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <title>Taraneem</title>
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="32x32">
    
    <!-- Apple Touch Icon for Safari on iOS devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/mini-logo.png') }}">
    <link rel="mask-icon" href="{{ asset('images/mini-logo.png') }}">
    
    <!-- Favicon for Safari on non-iOS devices -->
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="192x192">
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="512x512">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="menu-icon" id="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/browseall">Bekijk Alle Taraneem</a></li>
        </ul>
    </div>

    {{-- This is the switch for the theme --}}
    <div id="theme-toggle" style="position: fixed; top: 10px; right: 10px;">
        <label for="theme-checkbox">Theme</label>
        <label class="switch">
            <input type="checkbox" id="theme-checkbox">
            <span class="slider round"></span>
        </label>
    </div>

    <div id="header">
        <img id="logo" src="{{ asset('images/full-logo.png') }}" alt="">
        <form id="filter_form">
            <input id="filter" name="filter" type="text" size="40" onkeyup="filter_pictures();" placeholder="&#xF002;">
        </form>
    </div>
    

    <p id="taraneemList">
        @foreach ($taraneem as $tarnima)
            <a class="filtered" href="tarnima/{{$tarnima->id}}">{{$tarnima->titel}}</a><br>
        @endforeach
    </p>

    <footer>
        <a href="/suggestion">Staat er een tarnima niet tussen maar wil je die er wel tussen zien of zie je een fout in een tekst, doe HIER een suggestie</a>
    </footer>

    <script src="{{ asset('js/home.js') }}"></script>
    
</body>
</html>
