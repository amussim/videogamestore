<?php
session_start();
include 'db_connect.php';  // Ensure your database connection script is included

// Start output buffering at the very beginning of the script
ob_start();

// Check user role for permission
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : 'customer';

// Handle feedback submission (customer side)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    $customerId = $_SESSION['username'];
    $feedbackText = $_POST['feedback_text'];
    $rating = $_POST['rating'];

    // Insert feedback into the database
    $stmt = $mysqli->prepare("INSERT INTO Feedback (customer_id, feedback_text, rating, feedback_date) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("ssi", $customerId, $feedbackText, $rating);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Feedback submitted successfully!";
    } else {
        $_SESSION['message'] = "Failed to submit feedback: " . $stmt->error;
    }
    $stmt->close();
    header('Location: customer_feedback.php');
    exit();
}

// End of script
ob_end_flush();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Feedback</title>
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
        form, .feedback-list {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 80%;
            margin-bottom: 20px;
        }
        .feedback-item {
            padding: 10px;
            margin: 10px 0;
            border-bottom: 1px solid #ccc;
        }
        input[type="text"], textarea {
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
    </style>
</head>
<body>
    <h1>Customer Feedback</h1>

    <?php
    if ($userRole === 'customer'):  // Customer view for submitting feedback
    ?>
        <form method="post" action="">
            <textarea name="feedback_text" placeholder="Write your feedback here..." required></textarea>
            <input type="number" name="rating" min="1" max="5" placeholder="Rating (1-5)" required>
            <button type="submit" name="submit_feedback">Submit Feedback</button>
        </form>
    <?php
    endif;

    // Display existing feedback (admin side or for customers to view)
    if ($userRole === 'admin' || $userRole === 'customer'):
        echo '<div class="feedback-list"><h2>Customer Feedback</h2>';

        $feedbackQuery = "SELECT customer_id, feedback_text, rating, feedback_date FROM Feedback ORDER BY feedback_date DESC";
        $feedbackResult = $mysqli->query($feedbackQuery);

        if ($feedbackResult->num_rows > 0):
            while ($row = $feedbackResult->fetch_assoc()):
                echo "<div class='feedback-item'><strong>Customer: " . htmlspecialchars($row['customer_id']) . "</strong><br>Rating: " . $row['rating'] . "<br>Feedback: " . htmlspecialchars($row['feedback_text']) . "<br>Date: " . $row['feedback_date'] . "</div>";
            endwhile;
        else:
            echo "<p>No feedback available.</p>";
        endif;

        echo '</div>';
    endif;
    ?>

    <a href="customer_dashboard.php">Back to Dashboard</a>
</body>
</html>
