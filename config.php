<?php
$servername = "localhost";
$username = "root"; // default username for phpMyAdmin
$password = "";     // default password is empty in XAMPP
$dbname = "clientDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
