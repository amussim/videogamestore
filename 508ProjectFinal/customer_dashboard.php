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
        h1, h2 {
            color: #333;
            text-align: center;
        }
        form, .logout-form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: fit-content;
            margin: auto;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        a, button.logout-button {
            font-size: 18px; /* Consistent font size for links and buttons */
            color: blue;
            text-decoration: none;
        }
        a:hover, button.logout-button:hover {
            text-decoration: underline;
        }
        button.logout-button {
            display: block;
            background: none;
            border: none;
            cursor: pointer;
            color: blue;
            margin-top: 20px;
        }
        .products {
            margin-top: 20px;
        }
        .product-item {
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Welcome, Customer!</h1>
    <h2>Products</h2>
    <div class="products">
        <?php while ($product = $products->fetch_assoc()): ?>
            <div class="product-item">
                <?php echo htmlspecialchars($product['product_id']) . " - $" . $product['price'] . " - " . htmlspecialchars($product['type']); ?>
                <a href="purchase.php?type=<?= htmlspecialchars($product['type']); ?>&product_id=<?= $product['product_id']; ?>">
                    Buy <?= htmlspecialchars($product['type']); ?>
                </a>
            </div>
        <?php endwhile; ?>
    </div>
    <!-- Logout Button -->
    <form class="logout-form" action="" method="get">
        <button type="submit" class="logout-button" name="logout">Logout</button>
    </form>
</body>
</html>
