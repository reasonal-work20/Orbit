<!-- Database Connection -->

<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "orbit_db";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("DB Connection failed: " . $conn->connect_error);
}
?>