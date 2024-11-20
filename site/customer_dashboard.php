<?php
session_start();
include 'db_connect.php'; // Ensure this file has the correct database connection setup

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit();
}

// Handle logout action
if (isset($_GET['logout'])) {
    // Destroy the session
    session_destroy();
    // Redirect to login page
    header('Location: login.php');
    exit();
}

// Fetch products
$products = $mysqli->query("SELECT product_id, type, price, stock FROM Product WHERE stock > 0");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - GameSphere</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .dashboard {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            margin-top: 40px;
        }
        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            margin: 20px;
            text-align: center;
        }
        .card h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }
        a, button.logout-button {
            font-size: 18px;
            color: blue;
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
        }
        a:hover, button.logout-button:hover {
            text-decoration: underline;
        }
        button.logout-button {
            background: none;
            border: none;
            cursor: pointer;
            color: red;
        }
        button {
            width: 100%;
            background-color: #0056b3;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #003580;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 40px;
        }
        .product-item {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            width: 250px;
            text-align: center;
        }
        .product-item h3 {
            color: #0056b3;
            margin-bottom: 10px;
        }
        .product-item a {
            margin-top: 10px;
            display: inline-block;
            background-color: #0056b3;
            color: white;
            padding: 10px;
            border-radius: 4px;
            text-decoration: none;
        }
        .product-item a:hover {
            background-color: #003580;
        }
        .stats {
            margin-top: 40px;
            text-align: center;
        }
        .stats .stat {
            font-size: 24px;
            color: #333;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <h1>Customer Dashboard</h1>
    <div class="dashboard">
        <div class="card">
            <h2>View Your Orders</h2>
            <p>Check the status of your past orders and track new ones.</p>
            <a href="view_orders.php">View Orders</a>
        </div>
        <div class="card">
            <h2>Update Profile</h2>
            <p>Update your personal information and preferences.</p>
            <a href="update_profile.php">Update Profile</a>
        </div>
    </div>

    <h2>Available Products</h2>
    <div class="products">
        <?php while ($product = $products->fetch_assoc()): ?>
            <div class="product-item">
                <h3><?= htmlspecialchars($product['product_id']); ?></h3>
                <p>Price: $<?= htmlspecialchars($product['price']); ?></p>
                <p>Stock: <?= htmlspecialchars($product['stock']); ?></p>
                <a href="purchase.php?type=<?= htmlspecialchars($product['type']); ?>&product_id=<?= $product['product_id']; ?>">Buy Now</a>
            </div>
        <?php endwhile; ?>
    </div>

    <!-- Logout Button -->
    <form class="logout-form" action="" method="get">
        <button type="submit" class="logout-button" name="logout">Logout</button>
    </form>
</body>
</html>
