document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const email = urlParams.get("email");

    fetch(`fetch_doctor.php?email=${email}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById("fullname").textContent = data.fullname;
            document.getElementById("email").textContent = data.email;
            document.getElementById("phone").textContent = data.phone;
            document.getElementById("medicalRegNumber").textContent = data.medical_reg_number;
            document.getElementById("experience").textContent = data.experience;
            document.getElementById("qualifications").textContent = data.qualifications;
            document.getElementById("hospital").textContent = data.hospital;
            document.getElementById("specialization").textContent = data.specialization;
        })
        .catch(error => console.error("Error fetching doctor data:", error));
});
