<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$taraneem->titel}}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(to bottom, #000000, #000000); /* Gradient background */
            font-family: "Arial", sans-serif;
            color: #fff;
            text-align: center;
            font-size: 36px; /* Increase font size */
            line-height: 1.6; /* Increase line spacing */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #visibletext {
            font-weight: bold;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px #ffffff000;
        }

        #text {
            display: none;
        }

        /* Light filter style */
        #filter {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3); /* Light filter color */
            color:red;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
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

    <script>
        var text = document.getElementById("text").innerHTML;
        var elem = document.documentElement;
        var textarray = text.split("#");
        var i = 0;
        document.getElementById("visibletext").innerHTML = textarray[i];

        // Function to request fullscreen
        function openFullscreen() {
            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }

            // Remove the filter after going into fullscreen
            var filter = document.getElementById("filter");
            filter.style.display = "none";
        }

        // Listen for a click event on the document and request fullscreen when clicked
        document.addEventListener('click', function () {
            openFullscreen();
        });
        var textdisplay = textarray[i].split("@");

        document.getElementById("visibletext").innerHTML = textdisplay.join("<br>"); // Join with <br> to display sentences on separate lines

        document.addEventListener('keydown', function (event) {
            if (event.keyCode == 39 || event.keyCode == 40  ) {
            i++;
            if (i >= textarray.length) {
                i = textarray.length - 1;
            }
            textdisplay = textarray[i].split("@");
            document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
        }

            if (event.keyCode == 37 || event.keyCode == 38) {
            i--;
            if (i < 0) {
                i = 0;
            }
            textdisplay = textarray[i].split("@");
            document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
        }
        });


        document.addEventListener('touchstart', handleTouchStart, false);        
        document.addEventListener('touchmove', handleTouchMove, false);

        var xDown = null;                                                        
        var yDown = null;

        function getTouches(evt) {
        return evt.touches ||             // browser API
                evt.originalEvent.touches; // jQuery
        }                                                     
                                                                                
        function handleTouchStart(evt) {
            const firstTouch = getTouches(evt)[0];                                      
            xDown = firstTouch.clientX;                                      
            yDown = firstTouch.clientY;                                      
        };                                                
                                                                                
        function handleTouchMove(evt) {
            if ( ! xDown || ! yDown ) {
                return;
            }

            var xUp = evt.touches[0].clientX;                                    
            var yUp = evt.touches[0].clientY;

            var xDiff = xDown - xUp;
            var yDiff = yDown - yUp;
                                                                                
            if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {/*most significant*/
                if ( xDiff > 0 ) {
                    i++;
                    if (i >= textarray.length) {
                        i = textarray.length - 1;
                    }
                    textdisplay = textarray[i].split("@");
                    document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
                } else {
                    i--
                    if (i < 0) {
                        i = 0;
                    }
                    textdisplay = textarray[i].split("@");
                    document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
                }                       
            } else {
                if ( yDiff > 0 ) {
                    i--
                    if (i < 0) {
                        i = 0;
                    }
                    textdisplay = textarray[i].split("@");
                    document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
                } else { 
                    i++;
                    if (i >= textarray.length) {
                        i = textarray.length - 1;
                    }
                    textdisplay = textarray[i].split("@");
                    document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
                }                                                                 
            }
            /* reset values */
            xDown = null;
            yDown = null;                                             
        };




    </script>
</body>
</html>
