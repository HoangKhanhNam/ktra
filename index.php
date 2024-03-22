<?php
//session_start(); // Khởi tạo session

include "class.database.php";
$records_per_page = 5;

// Tính toán tổng số trang
$total_records = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM Customers"));
$total_pages = ceil($total_records / $records_per_page);

// Xác định trang hiện tại
$page = isset($_GET['page']) ? $_GET['page'] : 1;

// Tính toán offset
$offset = ($page - 1) * $records_per_page;

// Sử dụng biến $query để thực hiện truy vấn phân trang
$query = "SELECT * FROM Customers LIMIT $offset, $records_per_page";
$result = mysqli_query($conn, $query);

// Check login session
if (!isset($_SESSION['login'])) {
    header("Location:login.php");
    exit; // Dừng việc thực thi tiếp
}

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
    $insert_result = mysqli_query($conn, $insert_query);
    if (!$insert_result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
}

?>

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
                        <th>Mã Nhân Viên
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
            <!-- Phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo ($page > 1) ? $page - 1 : 1; ?>" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <?php for($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?php if($page == $i) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                        <a class="page-link" href="?page=<?php echo ($page < $total_pages) ? $page + 1 : $total_pages; ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
        </div>
        <!-- Link Logout -->
    <a href="logout.php" class="btn btn-secondary">Logout</a>
</div>
