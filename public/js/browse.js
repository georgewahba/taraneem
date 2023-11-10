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