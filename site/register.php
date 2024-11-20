<?php
session_start();
include 'db_connect.php';  // Ensure your database connection script is included

// Start output buffering at the very beginning of the script
ob_start();

// Registration logic here
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if username already exists
    $checkStmt = $mysqli->prepare("SELECT account_id FROM Account WHERE account_id = ?");
    $checkStmt->bind_param("s", $username);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<p>Registration failed: Username already exists. Please choose a different username.</p>";
    } else {
        // Insert user data into the database
        $stmt = $mysqli->prepare("INSERT INTO Account (account_id, email, password, join_date) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Registration successful!";
            header('Location: customer_dashboard.php');
            exit();
        } else {
            echo "<p>Registration failed: " . $stmt->error . "</p>";
        }
        $stmt->close();
    }
    $checkStmt->close();
}

// End of script
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
        }
        input[type="text"], input[type="email"], input[type="password"] {
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
    <h1>Register</h1>
    <form method="post" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
    <a href="login.php">Already have an account? Log in here.</a>
</body>
</html>
