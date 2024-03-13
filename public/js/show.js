var text = document.getElementById("text").innerHTML;
var elem = document.documentElement;
var textarray = text.split("#");
var i = 0;
document.getElementById("visibletext").innerHTML = textarray[i];
const themeChecked = sessionStorage.getItem('themeChecked');

// Function to request fullscreen
function openFullscreen() {
    // Check if the document is already in fullscreen
    if (
        !document.fullscreenElement &&
        !document.webkitFullscreenElement &&
        !document.msFullscreenElement
    ) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) { /* Safari */
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) { /* IE11 */
            elem.msRequestFullscreen();
        }
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

var pageInfo = document.getElementById("pageInfo");

// Function to update page information
function updatePageInfo() {
    pageInfo.innerHTML = (i + 1) + " / " + textarray.length;
}

// Initial update
updatePageInfo();

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
        updatePageInfo();
    }

    if (event.keyCode == 37 || event.keyCode == 38 || event.keyCode == 33) {
        i--;
        if (i < 0) {
            i = 0;
        }
        textdisplay = textarray[i].split("@");
        document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
        updatePageInfo();
    }

    if (i == textarray.length - 2) { // Check if it's the penultimate page
        addImageToDiv(); // Function call to add an image
    } else {
        removeImageFromDiv(); // Function call to remove the image
    }

    if (event.keyCode === 27) { // 27 is the key code for the 'Esc' key
        exitFullscreen();
        location.replace("/")

    }
});

function addImageToDiv() {
    var imageDiv = document.getElementById("imageDiv");
    var existingImages = imageDiv.getElementsByTagName("img").length;
    var imagesToAdd = 3 - existingImages; // Calculate how many images need to be added to make it up to 3

    var img = document.createElement("img");
    for (var j = 0; j < imagesToAdd; j++) {
        var clonedImg = img.cloneNode(true);
        if (themeChecked === "true") {
            clonedImg.src = "../images/cross-black.png";
        } else {
            clonedImg.src = "../images/cross-white.png";
        }
        imageDiv.appendChild(clonedImg);
    }
}

function removeImageFromDiv() {
    var imageDiv = document.getElementById("imageDiv");
    imageDiv.innerHTML = "";
}


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
            updatePageInfo();
        } else {
            i--;
            if (i < 0) {
                i = 0;
            }
            textdisplay = textarray[i].split("@");
            document.getElementById("visibletext").innerHTML = textdisplay.join("<br>");
            updatePageInfo();
        }
    }

    xDown = null;
    yDown = null;
};


var cursorVisible = true;
var cursorTimeout;

// Function to hide the cursor after a certain period of inactivity
function hideCursor() {
    document.documentElement.style.cursor = "none";
    cursorVisible = false;
}

// Function to show the cursor
function showCursor() {
    document.documentElement.style.cursor = "auto";
    cursorVisible = true;
}

// Function to reset the cursor timeout
function resetCursorTimeout() {
    if (cursorTimeout) {
        clearTimeout(cursorTimeout);
    }
    cursorTimeout = setTimeout(hideCursor, 3000); // Hide cursor after 3 seconds of inactivity
}

document.addEventListener('mousemove', function (event) {
    event.preventDefault(); // Prevent default behavior
    showCursor();
    resetCursorTimeout();
});

// Listen for touchstart event to reset the cursor timeout and show the cursor
document.addEventListener('touchstart', function () {
    showCursor();
    resetCursorTimeout();
});

// Initial setup to hide the cursor after 3 seconds of inactivity
resetCursorTimeout();

