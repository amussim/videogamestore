<?php
session_start();
include 'db_connect.php';  // Ensure this file has the correct database connection setup

// Check if the user is logged in and has the right role
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['account_id'])) {
    $account_id = $_POST['account_id'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Prepare and bind
    $stmt = $mysqli->prepare("UPDATE Account SET email = ?, role = ? WHERE account_id = ?");
    $stmt->bind_param("sss", $email, $role, $account_id);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $message = "User updated successfully.";
    } else {
        $message = "Error updating user: " . $stmt->error;
    }

    $stmt->close();
} else {
    $message = "Invalid request.";
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User - GameSphere</title>
    <link rel="stylesheet" href="styles.css"> <!-- assuming you have a CSS file -->
</head>
<body>
    <p><?php echo $message; ?></p>
    <!-- Return to Dashboard Button -->
    <form action="admin_dashboard.php">
        <button type="submit">Return to Dashboard</button>
    </form>
</body>
</html>
