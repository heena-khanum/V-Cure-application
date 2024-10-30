<?php
include 'database_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['login-email'];
    $password = $_POST['login-password'];

    $stmt = $conn->prepare("SELECT id, password, fullname, medical_reg_number, specialization, phone, experience, qualifications, hospital, state, city, available_time_from, available_time_to FROM doctors WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $hashed_password, $fullname, $medical_reg_number, $specialization, $phone, $experience, $qualifications, $hospital, $state, $city, $available_time_from, $available_time_to);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            session_start();
            $_SESSION['doctor_id'] = $id;
            $_SESSION['doctor_name'] = $fullname;
            $_SESSION['medical_reg_number'] = $medical_reg_number;
            $_SESSION['specialization'] = $specialization;
            $_SESSION['email'] = $email; // Store the email for display
            $_SESSION['phone'] = $phone;
            $_SESSION['experience'] = $experience;
            $_SESSION['qualifications'] = $qualifications;
            $_SESSION['hospital'] = $hospital;
            $_SESSION['state'] = $state;
            $_SESSION['city'] = $city;
            $_SESSION['available_time_from'] = $available_time_from;
            $_SESSION['available_time_to'] = $available_time_to;
            
            header("Location: doctor.php");
        } else {
            echo "Invalid email or password!";
        }
    } else {
        echo "No user found with this email!";
    }

    $stmt->close();
    $conn->close();
}
?>
