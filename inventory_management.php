<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gameshere_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Constants
define("RESTOCK_THRESHOLD", 5);  // Stock threshold to trigger alerts

// Function to process an order
function processOrder($gameId, $quantity)
{
    global $conn;

    // Start transaction
    $conn->begin_transaction();

    try {
        // Fetch current stock level
        $sql = "SELECT stock FROM Games WHERE game_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $gameId);
        $stmt->execute();
        $stmt->bind_result($currentStock);
        $stmt->fetch();
        $stmt->close();

        // Check if enough stock is available
        if ($currentStock < $quantity) {
            throw new Exception("Not enough stock available to process the order.");
        }

        // Update stock level
        $newStock = $currentStock - $quantity;
        $sql = "UPDATE Games SET stock = ? WHERE game_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $newStock, $gameId);
        $stmt->execute();
        $stmt->close();

        // Insert order record
        $sql = "INSERT INTO Orders (game_id, quantity, order_date) VALUES (?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $gameId, $quantity);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();

        // Trigger restocking alert if stock is below threshold
        if ($newStock <= RESTOCK_THRESHOLD) {
            notifyAdmin($gameId, $newStock);
        }

        echo "Order processed successfully.";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// Function to notify admin for restocking
function notifyAdmin($gameId, $stock)
{
    // Fetch game title
    global $conn;
    $sql = "SELECT title FROM Games WHERE game_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $gameId);
    $stmt->execute();
    $stmt->bind_result($gameTitle);
    $stmt->fetch();
    $stmt->close();

    // Send restocking alert (simulated with echo here)
    $adminEmail = "admin@gameshere.com";
    $subject = "Restocking Alert: $gameTitle";
    $message = "The stock level for '$gameTitle' is now $stock. Please reorder soon.";
    
    // Simulate email sending (you could use mail() function in production)
    echo "Alert sent to admin: $message";
    // mail($adminEmail, $subject, $message);
}

// Function to add transitions to the website
function addTransitionsToWebsite() {
    echo "<style>
        body {
            opacity: 0;
            transition: opacity 0.5s ease-in-out;
        }
        body.loaded {
            opacity: 1;
        }
        button {
            transition: transform 0.2s ease-in-out, background-color 0.3s ease-in-out;
        }
        button:hover {
            transform: scale(1.05);
            background-color: #f39c12;
        }
        .card {
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.2);
        }
        .navbar {
            transition: background-color 0.4s ease;
        }
        .navbar.scrolled {
            background-color: #333;
        }
        .modal {
            opacity: 0;
            transition: opacity 0.5s ease;
            display: none;
        }
        .modal.open {
            opacity: 1;
            display: block;
        }
    </style>
    <script>
        window.addEventListener(\"load\", function() {
            document.body.classList.add(\"loaded\");
        });

        window.addEventListener(\"scroll\", function() {
            const navbar = document.querySelector(\".navbar\");
            if (window.scrollY > 50) {
                navbar.classList.add(\"scrolled\");
            } else {
                navbar.classList.remove(\"scrolled\");
            }
        });

        function openModal() {
            const modal = document.querySelector(\".modal\");
            modal.classList.add(\"open\");
        }

        function closeModal() {
            const modal = document.querySelector(\".modal\");
            modal.classList.remove(\"open\");
        }
    </script>";
}

// Example usage
processOrder(1, 3);
addTransitionsToWebsite();

$conn->close();
?>