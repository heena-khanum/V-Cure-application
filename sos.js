function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
}

function redirectToDoctors(specialization) {
    window.location.href = `doctors_by_specialization.php?specialization=${encodeURIComponent(specialization)}`;
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