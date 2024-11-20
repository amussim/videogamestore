<?php
session_start();
include 'db_connect.php';  // Ensure your database connection script is included

// Start output buffering at the very beginning of the script
ob_start();

// Check user role for permission (assuming only admins can manage products)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handling the form submission for adding a product
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $productId = $_POST['product_id'];
    $productPrice = $_POST['product_price'];
    $productType = $_POST['product_type'];
    $productStock = $_POST['product_stock'];

    // Prepare and bind
    $stmt = $mysqli->prepare("INSERT INTO Product (product_id, price, type, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsi", $productId, $productPrice, $productType, $productStock);
    if ($stmt->execute()) {
        echo "<p>Product added successfully!</p>";
    } else {
        echo "<p>Error adding product: " . $stmt->error . "</p>";
    }
    $stmt->close();
    header("Refresh:2; url=manage_products.php");
    exit;
}

// Handling a product deletion
if (isset($_GET['delete'])) {
    $productId = $_GET['delete'];
    $stmt = $mysqli->prepare("DELETE FROM Product WHERE product_id = ?");
    $stmt->bind_param("s", $productId);
    if ($stmt->execute()) {
        header("Location: manage_products.php?message=deleted");
        exit();
    } else {
        echo "<p>Error deleting product: " . $stmt->error . "</p>";
    }
    $stmt->close();
    header("Refresh:2; url=manage_products.php");
    exit;
}

// End of script
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Manage Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }
        form, .product-list {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
            margin-bottom: 20px;
        }
        .product-item {
            padding: 10px;
            margin: 10px 0;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        input[type="text"], input[type="number"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #0056b3;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #003580;
        }
        a {
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h1>Manage Products</h1>
    <form method="post">
        <input type="text" name="product_id" placeholder="Product ID" required>
        <input type="number" step="0.01" name="product_price" placeholder="Price" required>
        <input type="text" name="product_type" placeholder="Type" required>
        <input type="number" name="product_stock" placeholder="Stock" required>
        <button type="submit" name="add_product">Add Product</button>
    </form>
    <div class="product-list">
        <h2>Current Products</h2>
        <?php
        $result = $mysqli->query("SELECT product_id, type, price, stock FROM Product");
        while ($row = $result->fetch_assoc()):
            echo "<div class='product-item'>" . htmlspecialchars($row['product_id']) . " - " . htmlspecialchars($row['type']) . " - $" . $row['price'] . " - Stock: " . $row['stock'] .
                 " <a href='?delete=" . $row['product_id'] . "' onclick='return confirm(\"Are you sure you want to delete this product?\");'>Delete</a></div>";
        endwhile;
        ?>
    </div>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
