<?php
// Allow database connection for Docker setup
$host = getenv('MYSQL_HOST') ?: 'cmsc508.com';
$username = getenv('MYSQL_USER') ?: '24SP_mussima';
$password = getenv('MYSQL_PASSWORD') ?: 'V00912804';
$database = getenv('MYSQL_DATABASE') ?: '24SP_mussima_pr';

$mysqli = new mysqli($host, $username, $password, $database);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
