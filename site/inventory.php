<?php
session_start();
include 'db_connect.php'; // Ensure the database connection is correctly handled

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$products = $mysqli->query("SELECT product_id, price, type, stock FROM Product");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Inventory - GameSphere</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 80%; /* Responsive width */
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #0056b3;
            color: white;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .back-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Manage Inventory</h1>
    <h2>Products</h2>
    <table>
        <tr><th>ID</th><th>Type</th><th>Price</th><th>Stock</th><th>Action</th></tr>
        <?php while ($product = $products->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($product['product_id']); ?></td>
            <td><?= htmlspecialchars($product['type']); ?></td>
            <td>$<?= number_format($product['price'], 2); ?></td>
            <td><?= $product['stock']; ?></td>
            <td><a href="edit_stock.php?product_id=<?= $product['product_id']; ?>">Edit Stock</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="admin_dashboard.php" class="back-link">Back to Dashboard</a>
</body>
</html>
