<?php
include 'db_connect.php'; // Ensure this file has the correct database connection setup

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

include 'db_connect.php'; // Ensure this file handles the database connection

$query = "SELECT account_id, email, role FROM Account";
$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users - GameSphere</title>
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
        form, table {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
            margin: 20px auto;
        }
        ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }
        li {
            display: inline;
            margin-right: 10px;
        }
        a {
            font-size: 18px;
            color: blue;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        th, td {
            padding: 10px;
            text-align: left;
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
    </style>
</head>
<body>
    <h1>Manage Users</h1>
    <a href="admin_dashboard.php" style="display: block; text-align: center; margin-bottom: 20px;">Return to Dashboard</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['account_id']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['role']); ?></td>
                <td>
                    <a href="edit_user.php?account_id=<?= $row['account_id'] ?>">Edit</a> |
                    <a href="delete_user.php?delete=<?= $row['account_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
<?php
$mysqli->close();
?>
