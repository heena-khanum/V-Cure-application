function toggleDropdown() {
    const dropdownMenu = document.getElementById("dropdown-menu");
    dropdownMenu.style.display = dropdownMenu.style.display === "block" ? "none" : "block";
}

function selectRecommendation(element) {
    const recommendationText = element.textContent;
    document.getElementById('symptoms-input').value = recommendationText;
}
