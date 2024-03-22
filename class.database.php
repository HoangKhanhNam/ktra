<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$db = "kiemtra";
global $conn;

// Thiết lập kết nối cơ sở dữ liệu
$conn = mysqli_connect($servername, $username, $password, $db);
if (mysqli_connect_errno()) {
    die('Could not connect: ' . mysqli_connect_error());
}
?>
