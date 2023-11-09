<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <!-- Standard favicon for most browsers -->
    <link rel="icon" type="image/png" href="{{ asset('images/mini-logo.png') }}" sizes="32x32">

    <!-- Apple Touch Icon for Safari on iOS devices (including iPads) -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/mini-logo.png') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121826;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            height: 100vh; /* Make the body take the full viewport height */
            justify-content: flex-start; /* Align content to the top */
        }

        h1 {
            margin-top: 70px; /* Adjust the top margin to create space for the fixed navbar */
        }

        #filter_form {
            margin-top: 20px;
        }

        #filter {
            border: 2px solid #212936;
            border-radius: 15px;
            padding: 10px;
            background-color: #121826;
            color: #fff;
            font-size: 16px;
            width: 80%; /* Adjust the width as needed */
        }

        p {
            display: none; /* Initially hide the list of taraneem */
            text-align: left; /* Align the text to the left */
            margin-top: 20px;
            font-size: 18px;
        }

        a.filtered {
            color: #fff;
            text-decoration: none;
            margin:10px;
        }

        a.filtered:hover {
            text-decoration: underline;
        }

        .menu-icon {
            position: absolute;
            top: 10px;
            left: 10px;
            cursor: pointer;
            font-size: 24px;
            color: #fff;
        }

        .menu {
            display: none;
            position: absolute;
            top: 40px;
            left: 10px;
            background: #333; /* Dark background color */
            border: 1px solid #666;
            padding: 10px;
            z-index: 1;
        }

        .menu ul {
            list-style: none;
            padding: 0;
        }

        .menu ul li {
            margin-bottom: 10px;
        }

        .menu ul li a {
            text-decoration: none;
            color: #fff;
        }

        #header {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            margin-top: 70px;
        }

        #logo {
            width: 350px; /* Adjust the width as needed to make the logo smaller */
            height: auto;
            margin-bottom: 0px; /* Add some margin below the logo */
        }
    </style>
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
            <input id="filter" name="filter" type="text" size="40" onkeyup="filter_pictures();" placeholder="Search">
        </form>
    </div>

    <p id="taraneemList">
        @foreach ($taraneem as $tarnima)
            <a class="filtered" href="tarnima/{{$tarnima->id}}">{{$tarnima->titel}}</a><br>
        @endforeach
    </p>

    <script>
        function filter_pictures() {
            var $filter = document.getElementById('filter').value.trim().toLowerCase();
            var $taraneemList = document.getElementById('taraneemList');
    
            // Hide all items initially
            for (var i = 0; i < $taraneemList.children.length; i++) {
                $taraneemList.children[i].style.display = 'none';
            }
    
            if ($filter === '') {
                // If the filter is empty, hide the list
                $taraneemList.style.display = 'none';
            } else {
                // Show the list
                $taraneemList.style.display = 'block';
    
                // Filter and display matching results
                for (var i = 0; i < $taraneemList.children.length; i++) {
                    var link = $taraneemList.children[i];
                    var linkText = link.textContent.toLowerCase();
                    if (linkText.includes($filter)) {
                        link.style.display = 'block';
                    }
                }
            }
        }

        document.getElementById("menu").style.display = "none";

        function toggleMenu() {
            var menu = document.getElementById("menu");
            if (menu.style.display === "block") {
                menu.style.display = "none";
            } else {
                menu.style.display = "block";
            }
        }
    </script>
    
</body>
</html>
