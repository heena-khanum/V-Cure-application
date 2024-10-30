<?php
$servername = "localhost"; // Your database server
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "clientdb"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the specialization from the URL
$specialization = isset($_GET['specialization']) ? $_GET['specialization'] : '';

// Prepare and execute the query
$sql = "SELECT * FROM doctors WHERE specialization = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $specialization);
$stmt->execute();
$result = $stmt->get_result();

// Prepare an array to hold doctor details
$doctors = [];
while ($row = $result->fetch_assoc()) {
    $doctors[] = $row;
}

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($doctors);

$stmt->close();
$conn->close();
?>
