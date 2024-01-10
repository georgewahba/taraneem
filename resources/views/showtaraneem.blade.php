<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title>{{$taraneem->titel}}</title>
    <link rel="stylesheet" href="{{ asset('css/show.css') }}">
</head>
<body>
    <div id="filter">
        <p>Click anywhere on the screen to go fullscreen</p>
    </div>

    <p id="text">
        {{$taraneem->lyrics}}
    </p>
    <div>
        <p id="visibletext"></p>
    </div>

    <div id="pageInfo">
    </div>
<script src="{{ asset('js/show.js') }}"></script>
</body>
</html>
