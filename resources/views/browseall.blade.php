<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse All Taraneem</title>
    <style>
        /* Use the same style as in your previous HTML */
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
            height: 100vh;
            justify-content: flex-start;
        }

        h1 {
            margin-top: 70px;
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
            width: 80%;
        }

        p {
            display: block;
            text-align: left;
            margin-top: 20px;
            font-size: 18px;
        }

        a.filtered {
            color: #fff;
            text-decoration: none;
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
            background: #333;
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

    <h1>Browse All Taraneem</h1>

    <p id="taraneemList">
        <!-- Display the taraneem list sorted by title in alphabetical order -->
        @foreach ($taraneem->sortBy('titel') as $tarnima)
            <a class="filtered" href="tarnima/{{$tarnima->id}}">{{$tarnima->titel}}</a><br>
        @endforeach
    </p>

    <script>
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
