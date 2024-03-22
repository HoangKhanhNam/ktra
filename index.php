<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Management</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional CSS styles */
        .card-body {
            margin: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /* Form thêm khách hàng */
        #addCustomerForm {
            display: none;
        }
    </style>
</head>
<body>

<?php
include "class.database.php";

// Check login session
if (!$_SESSION['login']) {
    header("Location:login.php");
    exit; // Stop further execution
}

global $conn;

// Add new customer
if (isset($_POST['add_customer'])) {
    // Retrieve form data
    $customer_name = $_POST['customer_name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $luong = $_POST['luong'];

    // Insert data into database
    $insert_query = "INSERT INTO Customers (CustomerName, Phone, Address, City, Luong) VALUES ('$customer_name', '$phone', '$address', '$city', '$luong')";
    mysqli_query($conn, $insert_query);
}

$result = mysqli_query($conn, "SELECT * FROM Customers");
?>

<div class="container">
    <div class="card-body">
        <!-- Form thêm khách hàng -->
        <form id="addCustomerForm" method="post">
            <div class="mb-3">
                <input type="text" name="customer_name" class="form-control" placeholder="Customer Name">
            </div>
            <div class="mb-3">
                <input type="text" name="phone" class="form-control" placeholder="Phone">
            </div>
            <div class="mb-3">
                <input type="text" name="address" class="form-control" placeholder="Address">
            </div>
            <div class="mb-3">
                <input type="text" name="city" class="form-control" placeholder="City">
            </div>
            <div class="mb-3">
                <input type="text" name="luong" class="form-control" placeholder="Luong">
            </div>
            <button type="submit" name="add_customer" class="btn btn-primary">Add Customer</button>
        </form>

        <!-- Bảng hiển thị danh sách khách hàng -->
        <div class="table-responsive mt-3">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>Mã Nhân Viên</th>
                        <th>Tên Nhân Viên</th>
                        <th>Giới tính</th>
                        <th>Nơi Sinh</th>
                        <th>Tên Phòng</th>
                        <th>Lương</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $row['CustomerID'] ?></td>
                            <td><?= $row['CustomerName'] ?></td>
                            <td>
                                <?php if ($row['Phone'] === 'NAM') : ?>
                                    <img src="man.jpg" alt="NAM"> <!-- Hình ảnh của "man" -->
                                <?php elseif ($row['Phone'] === 'NU') : ?>
                                    <img src="lady.jpg" alt="NU"> <!-- Hình ảnh của "lady" -->
                                <?php endif; ?>
                            </td>
                            <td><?= $row['Address'] ?></td>
                            <td><?= $row['City'] ?></td>
                            <td><?= $row['Luong'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Link Logout -->
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>
</div>

<!-- JavaScript để điều khiển hiển thị form thêm khách hàng -->
<script>
    function toggleAddCustomerForm() {
        var addCustomerForm = document.getElementById("addCustomerForm");
        if (addCustomerForm.style.display === "none") {
            addCustomerForm.style.display = "block";
        } else {
            addCustomerForm.style.display = "none";
        }
    }
    
</script>

</body>
</html>
