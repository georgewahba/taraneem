<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse All Taraneem</title>

    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="32x32">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <!-- Apple Touch Icon for Safari on iOS devices -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/mini-logo.png') }}">
    <link rel="mask-icon" href="{{ asset('images/mini-logo.png') }}">
    
    <!-- Favicon for Safari on non-iOS devices -->
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="192x192">
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="512x512">
    
    <link rel="stylesheet" href="{{ asset("css/browse.css") }}">

</head>
<body>
    <div class="menu-icon" id="menu-icon" onclick="toggleMenu()">&#9776;</div>
    <div class="menu" id="menu">
        <ul>
            <li><a href="/">Home</a></li>
            <li><a href="/browseall">Bekijk Alle Taraneem</a></li>
        </ul>
    </div>

    <h1>Browse All Taraneem</h1>
    <div id="letter-row">
        <a href="#" onclick="showAll()">All</a>
        <a href="#" onclick="filterByLetter('#')"> # </a>
        @foreach (range('A', 'Z') as $letter)
            <a href="#" onclick="filterByLetter('{{$letter}}')">{{$letter}}</a>
        @endforeach
    </div>
    <p id="taraneemList">
        <!-- Display the taraneem list sorted by title in alphabetical order -->
        @foreach ($taraneem->sortBy('titel') as $tarnima)
            <a class="filtered" href="tarnima/{{$tarnima->id}}">{{$tarnima->titel}}</a><br>
        @endforeach
    </p>

    <script src="{{ asset('js/browse.js') }}"></script>

</body>
</html>
