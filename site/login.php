<?php
session_start();
include 'db_connect.php'; // Ensure this file has the correct database connection setup

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT role, password FROM Account WHERE account_id = ?";
    if ($stmt = $mysqli->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($role, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['account_id'] = $username;
                $_SESSION['role'] = $role;
                
                if ($role === 'admin') {
                    header('Location: admin_dashboard.php');
                } else if ($role === 'customer') {
                    header('Location: customer_dashboard.php');
                }
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "No account found with that username.";
        }
        $stmt->close();
    }
    $mysqli->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GameSphere</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333;
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* Include padding and border in input width */
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
        .register-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <form action="login.php" method="post">
        <h2>GameSphere: Your Portal to Gaming and Gear</h2>
        <?php if (!empty($login_error)): ?>
            <p class="error"><?= htmlspecialchars($login_error) ?></p>
        <?php endif; ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Login</button>
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </form>
</body>
</html>
