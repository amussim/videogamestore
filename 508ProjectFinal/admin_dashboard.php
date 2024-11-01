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
    form {
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
        font-size: 24px; /* Increased font size for better visibility */
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
    input[type="text"],
    input[type="password"],
    input[type="number"] {
        width: calc(100% - 22px);
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }
    select {
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
    <h1>Admin Dashboard</h1>
    <ul>
        <li><a href="manage_users.php">Manage Users</a></li>
        <li><a href="manage_products.php">Manage Products</a></li>
        <li><a href="inventory.php">Manage Inventory</a></li>
    </ul>
    <!-- Logout Button -->
    <form action="" method="get">
        <button type="submit" class="logout-button" name="logout">Logout</button>
    </form>
</body>
</html>
