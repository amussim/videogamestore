<?php
// Allow database connection for Docker setup
$host = getenv('MYSQL_HOST') ?: 'cmsc508.com';
$username = getenv('MYSQL_USER') ?: '24fa_mussima';
$password = getenv('MYSQL_PASSWORD') ?: 'Shout4_mussima_JOY';
$database = getenv('MYSQL_DATABASE') ?: '24fa_hr_24fa_mussima';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
?>
