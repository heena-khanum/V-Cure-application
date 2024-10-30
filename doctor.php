<?php
session_start();
include 'database_connection.php';

if (!isset($_SESSION['doctor_id'])) {
    // Redirect to login if not logged in
    header("Location: index.html");
    exit();
}

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
    $doctor_id = $_SESSION['doctor_id'];
    $target_dir = "doctors/";
    $file_name = basename($_FILES["profile_photo"]["name"]);
    $target_file = $target_dir . $doctor_id . "_" . $file_name;
    $upload_ok = true;
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is an actual image
    $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
    if ($check === false) {
        $_SESSION['message'] = "File is not an image.";
        $upload_ok = false;
    }

    // Allow only specific image formats
    if (!in_array($image_file_type, ['jpg', 'jpeg', 'png', 'gif'])) {
        $_SESSION['message'] = "Only JPG, JPEG, PNG & GIF files are allowed.";
        $upload_ok = false;
    }

    // Move file to the target directory
    if ($upload_ok && move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
        // Update the doctor's profile picture in the database
        $stmt = $conn->prepare("UPDATE doctors SET photo = ? WHERE id = ?");
        $stmt->bind_param("si", $target_file, $doctor_id);
        $stmt->execute();
        
        // Update the session variable
        $_SESSION['photo'] = $target_file;
        $_SESSION['message'] = "Profile photo uploaded successfully.";
    } else if ($upload_ok) {
        $_SESSION['message'] = "Sorry, there was an error uploading your file.";
    }
}

// Retrieve the doctor's current photo if available
$photo_path = isset($_SESSION['photo']) ? $_SESSION['photo'] : "existing/th.jpg";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Profile</title>
    <link rel="stylesheet" href="doctor.css">
</head>
<body>
    <div class="profile-container">
        <h1>Doctor Profile</h1>
        
        <!-- Display Success Message -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message"><?php echo $_SESSION['message']; ?></div>
            <?php unset($_SESSION['message']); // Clear the message after displaying ?>
        <?php endif; ?>
        
        <!-- Display Profile Picture -->
        <div class="profile-photo">
            <img src="<?php echo htmlspecialchars($photo_path); ?>" alt="Profile Photo">
        </div>
        
        <!-- Form to Upload New Profile Photo -->
        <form action="doctor.php" method="POST" enctype="multipart/form-data">
            <label for="profile_photo">Upload Profile Photo:</label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*" required>
            <button type="submit">Upload Photo</button>
        </form>

        <p><strong>Full Name:</strong> <?php echo $_SESSION['doctor_name']; ?></p>
        <p><strong>Medical Registration Number:</strong> <?php echo $_SESSION['medical_reg_number']; ?></p>
        <p><strong>Specialization:</strong> <?php echo $_SESSION['specialization']; ?></p>
        <p><strong>Email:</strong> <?php echo $_SESSION['email']; ?></p>
        <p><strong>Phone:</strong> <?php echo $_SESSION['phone']; ?></p>
        <p><strong>Experience:</strong> <?php echo $_SESSION['experience']; ?> years</p>
        <p><strong>Qualifications:</strong> <?php echo $_SESSION['qualifications']; ?></p>
        <p><strong>Hospital/Clinic:</strong> <?php echo $_SESSION['hospital']; ?></p>
        <p><strong>Available Time:</strong> <?php echo $_SESSION['available_time_from'] . ' to ' . $_SESSION['available_time_to']; ?></p>
        <p><strong>Location:</strong> <?php echo $_SESSION['city'] . ", " . $_SESSION['state']; ?></p>
    </div>
</body>
</html>  
