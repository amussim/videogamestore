<?php
session_start();
include 'db_connect.php';  // Make sure this path is correct

ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_GET['account_id'])) {
    echo "Account ID is required";
    exit;
}

$account_id = $_GET['account_id'];

$stmt = $mysqli->prepare("SELECT account_id, email, role FROM Account WHERE account_id = ?");
$stmt->bind_param("s", $account_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Display form or details for editing
    ?>
    <form action="update_user.php" method="post">
        Email: <input type="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>"><br>
        Role: <input type="text" name="role" value="<?php echo htmlspecialchars($row['role']); ?>"><br>
        <input type="hidden" name="account_id" value="<?php echo htmlspecialchars($row['account_id']); ?>">
        <button type="submit">Update</button>
    </form>
    <?php
} else {
    echo "No user found with that ID.";
}
$stmt->close();
$mysqli->close();
?>
