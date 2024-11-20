<?php
session_start();
include 'db_connect.php';  // Ensure your database connection script is included

// Start output buffering at the very beginning of the script
ob_start();

// Check user role for permission (assuming only admins can view sales reports)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Query to get customer sales data
$salesQuery = "SELECT sale_id, product_id, quantity, price, sale_date, customer_email FROM CustomerSalesReport";
$salesResult = $mysqli->query($salesQuery);

// End of script
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
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
        .sales-report {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
        }
        .sales-item {
            padding: 10px;
            margin: 10px 0;
            border-bottom: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
            align-items: center;
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
    <h1>Sales Report</h1>
    <div class="sales-report">
        <h2>Product Sales Overview</h2>
        <?php
        if ($salesResult->num_rows > 0):
            while ($row = $salesResult->fetch_assoc()):
                echo "<div class='sales-item'>Sale ID: " . htmlspecialchars($row['sale_id']) . " - Product ID: " . htmlspecialchars($row['product_id']) . " - Quantity Sold: " . $row['quantity'] . " - Total Price: $" . number_format($row['price'] * $row['quantity'], 2) . " - Sale Date: " . $row['sale_date'] . " - Customer Email: " . htmlspecialchars($row['customer_email']) . "</div>";
            endwhile;
        else:
            echo "<p>No sales data available.</p>";
        endif;
        ?>
    </div>
    <a href="admin_dashboard.php">Back to Dashboard</a>
</body>
</html>
