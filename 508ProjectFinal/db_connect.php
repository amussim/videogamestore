<?php
// Only allow the database connection if the script is running on a local server
if ($_SERVER['SERVER_NAME'] !== 'localhost' && $_SERVER['SERVER_ADDR'] !== '127.0.0.1') {
    die('This application is only operable on a local server.');
}

$host = 'localhost';
$username = 'root';
$password = 'siri';  // Default password for local server (usually empty)
$database = 'videogame_store';  // Your local database name

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>

