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

// Add event listener to close menu when clicking outside the menu
document.addEventListener('click', function(event) {
var menu = document.getElementById("menu");
var menuIcon = document.getElementById("menu-icon");

// Check if the click is outside the menu and the menu is open
if (!menu.contains(event.target) && event.target !== menuIcon && menu.style.display === "block") {
    menu.style.display = "none";
}
});

// Prevent clicks inside the menu from closing it
document.getElementById("menu").addEventListener('click', function(event) {
event.stopPropagation();
});