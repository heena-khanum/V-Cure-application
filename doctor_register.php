<?php
// Include the database connection file
include 'database_connection.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize input data
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $medical_reg_number = mysqli_real_escape_string($conn, $_POST['medical-reg-number']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $experience = mysqli_real_escape_string($conn, $_POST['experience']);
    $qualifications = mysqli_real_escape_string($conn, $_POST['qualifications']);
    $hospital = mysqli_real_escape_string($conn, $_POST['hospital']);
    $language = mysqli_real_escape_string($conn, $_POST['language']);
    $specialization = mysqli_real_escape_string($conn, $_POST['specialization']);
    $available_time_from = mysqli_real_escape_string($conn, $_POST['available-time-from']);
    $available_time_to = mysqli_real_escape_string($conn, $_POST['available-time-to']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    
    // Handle file upload (medical license)
    $license = $_FILES['medical-license'];
    $license_name = mysqli_real_escape_string($conn, $license['name']);
    $license_tmp_name = $license['tmp_name'];
    $upload_dir = 'uploads/';
    $license_path = $upload_dir . basename($license_name);

    // Move uploaded file to the specified directory
    if (!move_uploaded_file($license_tmp_name, $license_path)) {
        die("File upload failed.");
    }

    // Insert the data into the 'doctors' table
    $sql = "INSERT INTO doctors (fullname, email, phone, medical_reg_number, password, experience, qualifications, hospital, language, specialization, available_time_from, available_time_to, state, city, medical_license_path)
            VALUES ('$fullname', '$email', '$phone', '$medical_reg_number', '$password', '$experience', '$qualifications', '$hospital', '$language', '$specialization', '$available_time_from', '$available_time_to', '$state', '$city', '$license_path')";

    if (mysqli_query($conn, $sql)) {
        echo "Doctor registered successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
