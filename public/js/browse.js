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

function showAll() {
    removeLineBreaks()
    var taraneemList = document.getElementById("taraneemList").getElementsByTagName("a");

    for (var i = 0; i < taraneemList.length; i++) {
        taraneemList[i].style.display = "block";
    }
    reorderDisplayBlock()

}

function filterByLetter(letter) {
    removeLineBreaks()
    var taraneemList = document.getElementById("taraneemList").getElementsByTagName("a");

    for (var i = 0; i < taraneemList.length; i++) {
        var title = taraneemList[i].innerText.toUpperCase();

        if (letter === '#') {
            if (/^[^A-Z]/.test(title)) {
                taraneemList[i].style.display = "block";
            } else {
                taraneemList[i].style.display = "none";
            }
        } else if (title.startsWith(letter)) {
            taraneemList[i].style.display = "block";
        } else {
            taraneemList[i].style.display = "none";
        }
    }
    reorderDisplayBlock()
}

function reorderDisplayBlock() {
    var taraneemList = document.getElementById("taraneemList");
    var displayBlockItems = [];
  
    // Separate display block and display none items
    for (var i = 0; i < taraneemList.children.length; i++) {
      var item = taraneemList.children[i];
      if (item.style.display === "block") {
        displayBlockItems.push(item);
        item.style.display = "none"; // Hide the item for now
      }
    }
  
    // Append display block items to the top with line breaks
    displayBlockItems.forEach(function (item) {
      taraneemList.insertBefore(item, taraneemList.firstChild);
      taraneemList.insertBefore(document.createElement('br'), taraneemList.firstChild); // Add line break
      item.style.display = "block"; // Show the item
    });
  }
  
  function removeLineBreaks() {
    var taraneemList = document.getElementById("taraneemList");
    var lineBreaks = taraneemList.getElementsByTagName("br");
  
    for (var i = 0; i < lineBreaks.length; i++) {
      lineBreaks[i].parentNode.removeChild(lineBreaks[i]);
    }
  }
