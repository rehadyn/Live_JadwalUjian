<?php
$servername = "localhost";
$username = "reza_kuliah";
$password = "XOvFtOogAdwy";
$database = "reza_kuliah";
// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
