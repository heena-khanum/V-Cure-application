function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    const isDropdownVisible = dropdownMenu.style.display === "block";

    // Toggle display of dropdown
    dropdownMenu.style.display = isDropdownVisible ? "none" : "block";

    // If the dropdown is now visible, add a listener to close it when clicking outside
    if (!isDropdownVisible) {
        document.addEventListener("click", closeDropdownOnClickOutside);
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

let medicineCount = 0; // To track the number of medicine forms

// Function to handle medical store selection
function chooseMedical(medicalStore) {
    const medicineFormSection = document.getElementById("medicine-form-section");
    medicineFormSection.style.display = 'block'; // Show the form section
    document.getElementById("medicine-form-container").innerHTML = ''; // Clear any previous forms
    medicineCount = 0; // Reset medicine count
    document.getElementById("submit-button").disabled = true; // Disable the submit button

    // Ask for the number of medicines
    const numMedicines = prompt("How many medicines would you like to order?");
    
    if (numMedicines && !isNaN(numMedicines) && numMedicines > 0) {
        for (let i = 0; i < numMedicines; i++) {
            addMedicineForm(medicalStore); // Call function to add medicine forms
        }
        // Enable the submit button
        document.getElementById("submit-button").disabled = false;
    } else {
        alert("Please enter a valid number of medicines.");
    }
}

// Function to add a new medicine form
function addMedicineForm(medicalStore) {
    const medicineFormContainer = document.getElementById("medicine-form-container");
    
    const newForm = document.createElement("div");
    newForm.classList.add("medicine-form");

    newForm.innerHTML = `
        <h3>${medicalStore}</h3>
        <label>Medicine Name:</label>
        <input type="text" name="medicine-name-${medicineCount}" required>
        <label>Quantity:</label>
        <input type="number" name="medicine-quantity-${medicineCount}" required min="1">
        <label>Image (optional):</label>
        <input type="file" name="medicine-image-${medicineCount}">
    `;

    medicineFormContainer.appendChild(newForm);
    medicineCount++; // Increment count for the next medicine form
}

// Function to submit the order
function submitOrder() {
    const medicineForms = document.querySelectorAll(".medicine-form");
    let allFieldsFilled = true; // Track if all required fields are completed

    // Validate each form in the section
    medicineForms.forEach((form, index) => {
        const medicineName = form.querySelector(`input[name="medicine-name-${index}"]`);
        const quantity = form.querySelector(`input[name="medicine-quantity-${index}"]`);
        
        // Validate required fields
        if (!medicineName.value.trim()) {
            alert(`Please fill in the medicine name for item ${index + 1}.`);
            allFieldsFilled = false; // Mark as not filled
        }
        
        if (!quantity.value.trim() || quantity.value <= 0) {
            alert(`Please fill in a valid quantity for item ${index + 1}.`);
            allFieldsFilled = false; // Mark as not filled
        }
    });

    // Show thank you message if all required fields are filled
    if (allFieldsFilled) {
        document.getElementById("thank-you-popup").style.display = "flex";
        // Optionally, reset the forms and count after submission
        resetForms();
    }
}

// Function to reset forms after submission
function resetForms() {
    const medicineFormContainer = document.getElementById("medicine-form-container");
    medicineFormContainer.innerHTML = ''; // Clear all forms
    medicineCount = 0; // Reset the medicine count
    document.getElementById("submit-button").disabled = true; // Disable the submit button
}

function closePopup() {
    document.getElementById("thank-you-popup").style.display = "none";
    document.getElementById("medicine-form-section").style.display = "none"; // Hide form section after closing the popup
}
