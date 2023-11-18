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

// Function to exit fullscreen
function exitFullscreen() {
    if (document.exitFullscreen) {
        document.exitFullscreen();
    } else if (document.webkitExitFullscreen) { /* Safari */
        document.webkitExitFullscreen();
    } else if (document.msExitFullscreen) { /* IE11 */
        document.msExitFullscreen();
    }

    // Show the filter
    var filter = document.getElementById("filter");
    filter.style.display = "flex";
}

// Listen for a click event on the document and request fullscreen when clicked
document.addEventListener('click', function () {
    openFullscreen();
});

var textdisplay = textarray[i].split("@");
document.getElementById("visibletext").innerHTML = textdisplay.join("<br>"); // Join with <br> to display sentences on separate lines

document.addEventListener('keydown', function (event) {
    if (event.keyCode == 39 || event.keyCode == 40 || event.keyCode == 34) {
        i++;
        if (i >= textarray.length) {
            i = textarray.length - 1;
            exitFullscreen(); // Exit fullscreen when reaching the last item
            location.replace("/")

        }
        textdisplay = textarray[i].split("@");
        document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
    }

    if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 33) {
        i--;
        if (i < 0) {
            i = 0;
        }
        textdisplay = textarray[i].split("@");
        document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
    }

    if (event.keyCode === 27) { // 27 is the key code for the 'Esc' key
        exitFullscreen();
        location.replace("/")

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
}

function handleTouchMove(evt) {
    if (!xDown || !yDown) {
        return;
    }

    var xUp = evt.touches[0].clientX;
    var yUp = evt.touches[0].clientY;

    var xDiff = xDown - xUp;
    var yDiff = yDown - yUp;

    if (Math.abs(xDiff) > Math.abs(yDiff)) {
        if (xDiff > 0) {
            i++;
            if (i >= textarray.length) {
                i = textarray.length - 1;
                exitFullscreen(); // Exit fullscreen when reaching the last item
                location.replace("/")

            }
            textdisplay = textarray[i].split("@");
            document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
        } else {
            i--;
            if (i < 0) {
                i = 0;
            }
            textdisplay = textarray[i].split("@");
            document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
        }
    }

    xDown = null;
    yDown = null;
};