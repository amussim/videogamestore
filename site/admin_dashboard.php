<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - GameSphere</title>
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
    .stats {
        margin-top: 40px;
        text-align: center;
    }
    .stats .stat {
        font-size: 24px;
        color: #333;
        margin: 10px 0;
    }
    .error {
        color: red;
        text-align: center;
    }
    </style>
</head>
<body>
    <h1>Admin Dashboard</h1>
    <div class="dashboard">
        <div class="card">
            <h2>Manage Users</h2>
            <p>View, edit, or remove user accounts. Ensure all users are up-to-date.</p>
            <a href="manage_users.php">Go to Manage Users</a>
        </div>
        <div class="card">
            <h2>Manage Products</h2>
            <p>Add, update, or delete products from the catalog. Keep the product listings fresh.</p>
            <a href="manage_products.php">Go to Manage Products</a>
        </div>
        <div class="card">
            <h2>Manage Inventory</h2>
            <p>Track stock levels and restock products. Stay informed about inventory status.</p>
            <a href="inventory.php">Go to Manage Inventory</a>
        </div>
        <div class="card">
            <h2>Sales Reports</h2>
            <p>View sales reports to track the business performance. Analyze recent trends.</p>
            <a href="sales_reports.php">View Sales Reports</a>
        </div>
        <div class="card">
            <h2>Customer Feedback</h2>
            <p>Review customer feedback and ratings. Address user concerns proactively.</p>
            <a href="customer_feedback.php">Check Feedback</a>
        </div>
    </div>

    <div class="stats">
        <div class="stat">Total Users: 150</div>
        <div class="stat">Total Products: 75</div>
        <div class="stat">Pending Orders: 12</div>
    </div>

    <!-- Logout Button -->
    <form action="" method="get">
        <button type="submit" class="logout-button" name="logout">Logout</button>
    </form>
</body>
</html>
