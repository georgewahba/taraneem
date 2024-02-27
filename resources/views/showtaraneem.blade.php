<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title>{{$taraneem->titel}}</title>
    <script>
        // Check if the toggle switch was checked
        const themeChecked = sessionStorage.getItem('themeChecked');
    
        if (themeChecked === 'true') {
            // Define an array of theme file paths
            const themes = [
                '{{ asset('css/themes/theme-1.css') }}',
                '{{ asset('css/themes/theme-2.css') }}',
                '{{ asset('css/themes/theme-3.css') }}',
                '{{ asset('css/themes/theme-4.css') }}',
                '{{ asset('css/themes/theme-5.css') }}'
            ];
    
            // Generate a random index to select a theme from the array
            const randomIndex = Math.floor(Math.random() * themes.length);
    
            // Load the randomly selected theme
            document.write('<link rel="stylesheet" href="' + themes[randomIndex] + '">');
        } else {
            document.write('<link rel="stylesheet" href="{{ asset('css/themes/theme-basic.css') }}">');
        }
    </script>
    
    
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
