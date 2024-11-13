<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$message = "No user specified for deletion.";

if (isset($_GET['delete'])) {
    $account_id = $_GET['delete'];

    // Prepare deletion query
    $stmt = $mysqli->prepare("DELETE FROM Account WHERE account_id = ?");
    $stmt->bind_param("s", $account_id);

    if ($stmt->execute()) {
        $message = "User deleted successfully.";
    } else {
        $message = "Error deleting user: " . $stmt->error;
    }
    $stmt->close();
}
$mysqli->close();

// Redirect back to user management page or show message
header("Location: manage_users.php?message=" . urlencode($message));
exit();
?>
