<?php
session_start();
include 'db_connect.php'; // Ensure this file handles the database connection

if (!isset($_GET['type']) || !isset($_GET['product_id'])) {
    echo "<div class='container'><p>Error: Product type and ID are required.</p></div>";
    exit();
}

$type = $_GET['type'];
$product_id = $_GET['product_id'];

// Fetch product details
$query = "SELECT product_id, type, price, stock FROM Product WHERE product_id = ? AND type = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $product_id, $type);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<div class='container'><p>Product not found.</p></div>";
    exit();
}

$product = $result->fetch_assoc();

// Attempt to purchase if stock is available
if ($product['stock'] > 0) {
    $update_query = "UPDATE Product SET stock = stock - 1 WHERE product_id = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param("s", $product_id);
    $update_stmt->execute();
    $message = "Purchase successful! Bought: " . htmlspecialchars($product['type']);
} else {
    $message = "Sorry, this item is out of stock.";
}

$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase - GameSphere</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            width: 350px;
        }
        h1 {
            color: #333;
            margin-bottom: 20px;
        }
        p {
            margin-top: 10px;
            color: #555;
        }
        a {
            display: block;
            margin-top: 20px;
            color: #0056b3;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Purchase Details</h1>
        <p><?= isset($message) ? $message : "Processing your purchase..."; ?></p>
        <a href="customer_dashboard.php">Return to Dashboard</a>
    </div>
</body>
</html>
