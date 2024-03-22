<?php
include "class.database.php";

// Check login session
//session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== 'admin') {
    header("Location: index.php");
    exit; // Stop further execution
}

global $conn;

// Xác định số lượng bản ghi muốn hiển thị trên mỗi trang
$records_per_page = 5;

if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    // Query to get customer details
    $query = "SELECT * FROM Customers WHERE CustomerID = $customer_id";
    $result = mysqli_query($conn, $query);
    $customer = mysqli_fetch_assoc($result);
}

if (isset($_POST['update_customer'])) {
    // Retrieve form data
    $customer_id = $_POST['customer_id'];
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $luong = $_POST['luong'];

    // Update customer data in the database
    $update_query = "UPDATE Customers SET CustomerName = '$customer_name', Phone = '$phone', Address = '$address', City = '$city', Luong = '$luong' WHERE CustomerID = $customer_id";
    mysqli_query($conn, $update_query);
    header("Location: customers.php");
    exit; // Stop further execution
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="card-body">
        <h2>Edit Customer</h2>
        <form method="post">
            <input type="hidden" name="customer_id" value="<?= $customer['CustomerID'] ?>">
            <div class="mb-3">
                <label for="customer_name" class="form-label">Tên Nhân Viên</label>
                <input type="text" name="customer_name" class="form-control" id="customer_name" value="<?= $customer['CustomerName'] ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" id="phone" value="<?= $customer['Phone'] ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Nơi sinh</label>
                <input type="text" name="address" class="form-control" id="address" value="<?= $customer['Address'] ?>">
            </div>
            <div class="mb-3">
                <label for="city" class="form-label">Tên Phòng</label>
                <input type="text" name="city" class="form-control" id="city" value="<?= $customer['City'] ?>">
            </div>
            <div class="mb-3">
                <label for="luong" class="form-label">Lương</label>
                <input type="text" name="luong" class="form-control" id="luong" value="<?= $customer['Luong'] ?>">
            </div>
            <button type="submit" name="update_customer" class="btn btn-primary">Update</button>
        </form>
    </div>
    
</div>

</body>
</html>
