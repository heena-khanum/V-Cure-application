function fetchDoctors(specialization) {
    fetch(`fetchDoctors.php?specialization=${encodeURIComponent(specialization)}`)
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById("doctor-details");
            container.innerHTML = ""; // Clear previous content

            if (data.length > 0) {
                data.forEach(doctor => {
                    const doctorDiv = document.createElement("div");
                    doctorDiv.classList.add("doctor-box");

                    doctorDiv.innerHTML = `
                        <p><strong>Full Name:</strong> ${doctor.full_name}</p>
                        <p><strong>Specialization:</strong> ${doctor.specialization}</p>
                        <p><strong>Email:</strong> ${doctor.email}</p>
                        <p><strong>Contact Number:</strong> ${doctor.contact_number}</p>
                        <p><strong>Years of Experience:</strong> ${doctor.years_of_experience}</p>
                        <p><strong>Qualifications:</strong> ${doctor.qualifications}</p>
                        <p><strong>Language:</strong> ${doctor.preferred_language}</p>
                        <p><strong>State:</strong> ${doctor.state}</p>
                        <p><strong>Status:</strong> ${isAvailable(doctor.available_time_from, doctor.available_time_to) ? '<span style="color: green;">Available</span>' : '<span style="color: red;">Not Available</span>'}</p>
                    `;

                    container.appendChild(doctorDiv);
                });
            } else {
                container.innerHTML = "<p>No doctors available in this specialization.</p>";
            }
        })
        .catch(error => console.error('Error fetching doctor data:', error));
}

function isAvailable(from, to) {
    const currentTime = new Date();
    const availableFrom = new Date();
    const availableTo = new Date();

    // Assume from and to are in HH:MM format
    const [fromHours, fromMinutes] = from.split(':');
    const [toHours, toMinutes] = to.split(':');

    availableFrom.setHours(fromHours, fromMinutes);
    availableTo.setHours(toHours, toMinutes);

    return currentTime >= availableFrom && currentTime <= availableTo;
}
