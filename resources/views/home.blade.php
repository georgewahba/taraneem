<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
        }

        p {
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
    </style>
</head>
<body>
    <form id="filter_form">
        <label for="filter">Search:</label>
        <input id="filter" name="filter" type="text" size="40" onkeyup="filter_pictures();">
    </form>

    <p>
        @foreach ($taraneem as $tarnima)
            <a class="filtered" href="tarnima/{{$tarnima->id}}">{{$tarnima->titel}}</a><br>
        @endforeach
    </p>

    <script>
        function filter_pictures() {
            var $i = 0;

            // Get the text we use to filter
            var $filter = document.getElementById('filter').value.toLowerCase();

            // Get all links
            var $linksCollection = document.getElementsByClassName('filtered');

            // For every link, check if text contains filter and hide/show as needed.
            for ($i = 0; $i < $linksCollection.length; $i++) {
                var linkText = $linksCollection[$i].textContent.toLowerCase();
                if (linkText.includes($filter)) {
                    $linksCollection[$i].style.display = 'block';
                } else {
                    $linksCollection[$i].style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>
