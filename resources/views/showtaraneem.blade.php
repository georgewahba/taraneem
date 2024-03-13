<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title>{{$taraneem->titel}}</title>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Create a link element
            var link = document.createElement('link');
            link.rel = 'stylesheet';

            // Check if the toggle switch was checked
            const themeChecked = sessionStorage.getItem('themeChecked');
        
            if (themeChecked === 'true') {
                // Set the href attribute to the theme.css path
                link.href = "{{ asset('css/themes/theme.css') }}";

                // Define an array of background image paths
                const backgrounds = [
                    'theme-1.jpg',
                    'theme-2.jpg',
                    'theme-3.jpg',
                    'theme-4.jpg',
                    'theme-5.jpg',
                    'theme-6.jpg',
                    'theme-7.jpg',
                    'theme-8.jpg',
                    'theme-9.jpg',
                    'theme-10.jpg',
                    'theme-11.jpg',
                    'theme-12.jpg',
                    'theme-13.jpg',
                    'theme-14.jpg',
                    'theme-15.jpg',
                    'theme-16.jpg',
                    'theme-17.jpg',
                    'theme-18.jpg',
                ];
        
                // Generate a random index to select a background image from the array
                const randomIndex = Math.floor(Math.random() * backgrounds.length);
        
                // Set the randomly selected background image class
                document.body.classList.add('theme-' + (randomIndex + 1));
            } else {
                // Set the href attribute to the theme-basic.css path
                link.href = "{{ asset('css/themes/theme-basic.css') }}";
            }

            // Append the link element to the head of the document
            document.head.appendChild(link);
        });
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
    
    <div id="pageInfo"></div>
    
    <div id="imageDiv"></div>

<script src="{{ asset('js/show.js') }}"></script>
</body>
</html>
