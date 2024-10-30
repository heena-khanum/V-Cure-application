<?php
include 'database_connection.php';

if (!isset($_GET['specialization'])) {
    header("Location: sos.html");
    exit();
}

$specialization = $_GET['specialization'];

$stmt = $conn->prepare("SELECT fullname, email, phone, experience, qualifications, language, state, available_time_from, available_time_to, photo FROM doctors WHERE specialization = ?");
$stmt->bind_param("s", $specialization);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctors in <?php echo htmlspecialchars($specialization); ?></title>
    <link rel="stylesheet" href="specialization.css">
</head>
<body>
    <header>
        <!-- Header Content -->
    </header>

    <main class="main-container">
        <h2>Doctors in <?php echo htmlspecialchars($specialization); ?></h2>

        <div class="doctor-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    // Get current time in H:i format
                    date_default_timezone_set('Asia/kolkata'); // Replace 'Your/Timezone' with your timezone, e.g., 'Asia/Kolkata'
                    $current_time_str = date("H:i");

                    // Get the available from and to times
                    $available_from = $row['available_time_from'];
                    $available_to = $row['available_time_to'];

                    // Check availability
                    $available = ($current_time_str >= $available_from && $current_time_str <= $available_to);
                    ?>
                    
                    <div class="doctor-card <?php echo $available ? 'available' : 'unavailable'; ?>">
                        <div class="doctor-info">
                            <img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Doctor Photo" class="doctor-photo">
                            <h3><?php echo htmlspecialchars($row['fullname']); ?></h3>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($row['email']); ?></p>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($row['phone']); ?></p>
                            <p><strong>Experience:</strong> <?php echo htmlspecialchars($row['experience']); ?> years</p>
                            <p><strong>Qualifications:</strong> <?php echo htmlspecialchars($row['qualifications']); ?></p>
                            <p><strong>Languages:</strong> <?php echo htmlspecialchars($row['language']); ?></p>
                            <p><strong>State:</strong> <?php echo htmlspecialchars($row['state']); ?></p>
                            <p class="availability"><?php echo $available ? 'Available' : 'Not Available'; ?></p>
                        </div>
                        <button onclick="window.location.href='<?php echo $available ? 'payment.html' : '#'; ?>'">
                            <?php echo $available ? 'Proceed to pay' : 'Doctor Not Available'; ?>
                        </button>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No doctors found in this specialization.</p>
            <?php endif; ?>
        </div>
    </main>
    <script src="special.js"></script>
</body>
</html>
