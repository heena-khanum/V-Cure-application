// Toggle Dropdown Menu
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
// Handle dropdown location selection
document.querySelectorAll('.location-option').forEach(link => {
    link.addEventListener('click', function(event) {
        const selectedLocation = event.target.getAttribute('data-location');
        const parentDropdown = this.closest('.dropdown');

        // Update the display text for the selected location dropdown
        if (parentDropdown.querySelector('.dropdown-btn').id === "current-location-btn") {
            document.getElementById('current-location-display').innerText = `Selected Location: ${selectedLocation}`;
        } else if (parentDropdown.querySelector('.dropdown-btn').id === "preferred-location-btn") {
            document.getElementById('preferred-location-display').innerText = `Preferred Hospital: ${selectedLocation}`;
        }

        // Close dropdown after selection
        parentDropdown.querySelector('.dropdown-content').style.display = 'none';
    });
});

// Show/hide dropdown on hover (if you still want it)
document.querySelectorAll('.dropdown').forEach(dropdown => {
    dropdown.addEventListener('mouseenter', function() {
        this.querySelector('.dropdown-content').style.display = 'block';
    });

    dropdown.addEventListener('mouseleave', function() {
        this.querySelector('.dropdown-content').style.display = 'none';
    });
});

// Function to show dropdown content explicitly when the button is clicked
document.querySelectorAll('.dropdown-btn').forEach(button => {
    button.addEventListener('click', function() {
        const dropdownContent = this.nextElementSibling;
        dropdownContent.style.display = dropdownContent.style.display === 'block' ? 'none' : 'block';
    });
});

// Booking confirmation process
document.querySelectorAll('.book-btn').forEach(button => {
    button.addEventListener('click', function() {
        // Ask for contact number
        const contactNumber = prompt("Please enter your contact number (10 digits):");
        
        if (!/^\d{10}$/.test(contactNumber)) {
            alert("Invalid number. Please enter a 10-digit number.");
            return;
        }

        // Confirm booking
        const confirmBooking = confirm("Do you want to confirm your booking?");
        if (confirmBooking) {
            // Show confirmation message
            const confirmationMessage = document.getElementById('confirmation-message');
            confirmationMessage.innerText = "Booking was successful!";
            confirmationMessage.style.display = 'block';

            // Hide the confirmation message after 3 seconds
            setTimeout(() => {
                confirmationMessage.style.display = 'none';
            }, 3000);
        }
    });
});

function closeDropdownOnClickOutside(event) {
    const dropdownMenu = document.getElementById("dropdown-menu");
    const menuButton = document.querySelector(".menu");

    // Check if the click is outside both the dropdown and the menu button
    if (!dropdownMenu.contains(event.target) && !menuButton.contains(event.target)) {
        dropdownMenu.style.display = "none";
        document.removeEventListener("click", closeDropdownOnClickOutside);
    }
}