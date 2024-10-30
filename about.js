/// Toggle Dropdown Menu
function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
}

// Close Dropdown Menu when clicking outside
window.onclick = function(event) {
    const dropdownMenu = document.getElementById("dropdown-menu");
    const menuIcon = document.querySelector(".menu");
    if (!menuIcon.contains(event.target) && dropdownMenu.style.display === "block") {
        dropdownMenu.style.display = "none";
    }
}

function closeDropdownOnClickOutside(event) {
    const dropdownMenu = document.getElementById("dropdown-menu");
    const menuButton = document.querySelector(".menu");

    // Check if the click is outside both the dropdown and the menu button
    if (!dropdownMenu.contains(event.target) && !menuButton.contains(event.target)) {
        dropdownMenu.style.display = "none";
        document.removeEventListener("click", closeDropdownOnClickOutside);
    }
}