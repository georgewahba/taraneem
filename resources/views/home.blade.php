<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="menu-icon" id="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/browseall">Bekijk Alle Taraneem</a></li>
        </ul>
    </div>

    <div id="header">
        <img id="logo" src="{{ asset('images/full-logo.png') }}" alt="">
        <form id="filter_form">
            <input id="filter" name="filter" type="text" size="40" onkeyup="filter_pictures();" placeholder="&#xF002;">
        </form>
    </div>

    <p id="taraneemList">
        @foreach ($taraneem as $tarnima)
            <a class="filtered" href="tarnima/{{$tarnima->id}}" tekst="{{$tarnima->lyrics}}">{{$tarnima->titel}}</a><br>
        @endforeach
    </p>

    <script src="{{ asset('js/home.js') }}"></script>
</body>
</html>
