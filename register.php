<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $city = $_POST['city'];
    $state = $_POST['state'];
    $age = $_POST['age'];
    $country = $_POST['country'];
    $gender = $_POST['gender'];

    $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, password, city, state, age, country, gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $fullname, $email, $phone, $password, $city, $state, $age, $country, $gender);

    if ($stmt->execute()) {
        echo "Registration successful!";
        header("location: homenew.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
