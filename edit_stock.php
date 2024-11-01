<?php
session_start();
include 'db_connect.php'; // Ensure the database connection is correctly handled

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$message = ''; // To hold success or error message

// Update stock if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_stock'])) {
    $product_id = $_POST['product_id'];
    $new_stock = $_POST['stock'];

    // Prepare update statement
    $stmt = $mysqli->prepare("UPDATE Product SET stock = ? WHERE product_id = ?");
    $stmt->bind_param("is", $new_stock, $product_id);
    if ($stmt->execute()) {
        $message = "Stock updated successfully.";
        // Redirect back to inventory management or stay on the page
        header("Refresh:2; url=inventory.php"); // Redirect after 2 seconds to inventory management
    } else {
        $message = "Error updating stock: " . $stmt->error;
    }
    $stmt->close();
}

// Get current product details
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $stmt = $mysqli->prepare("SELECT product_id, type, price, stock FROM Product WHERE product_id = ?");
    $stmt->bind_param("s", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($product = $result->fetch_assoc()) {
        // Product found
    } else {
        $message = "Product not found.";
    }
    $stmt->close();
} else {
    header('Location: inventory.php'); // Redirect if no product ID is given
    exit();
}

$mysqli->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Stock - GameSphere</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        label {
            margin-top: 10px;
        }
        input[type="number"],
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
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
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <form action="edit_stock.php?product_id=<?= htmlspecialchars($product_id) ?>" method="post">
        <h1>Edit Stock for Product</h1>
        <?php if ($message): ?>
        <p><?= $message; ?></p>
        <?php endif; ?>
        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']); ?>">
        <label for="type">Product Type:</label>
        <input type="text" id="type" value="<?= htmlspecialchars($product['type']); ?>" readonly>
        <label for="price">Price:</label>
        <input type="text" id="price" value="$<?= number_format($product['price'], 2); ?>" readonly>
        <label for="stock">Current Stock:</label>
        <input type="number" id="stock" name="stock" value="<?= $product['stock']; ?>" required>
        <button type="submit" name="update_stock">Update Stock</button>
    </form>
</body>
</html>
