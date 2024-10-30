<?php
session_start();
require("includes/common.php");

// Kiểm tra xem người dùng đã đăng nhập và có vai trò là admin chưa
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header('location: index.php'); // Chuyển hướng về trang chính nếu không phải admin
    exit();
}

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($con, $_POST['product_price']);
    $productImage = $_FILES['product_image']['name'];

    // Xử lý upload hình ảnh
    $targetDir = "images/";
    $targetFile = $targetDir . basename($productImage);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile);

    // Thêm sản phẩm vào cơ sở dữ liệu
    $query = "INSERT INTO products (name, price, image) VALUES ('$productName', '$productPrice', '$productImage')";
    mysqli_query($con, $query);

    // Chuyển hướng về trang quản lý sản phẩm hoặc thông báo thành công
    header('location: admin_dashboard.php?success=Product added successfully');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm | Baker's Mart</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
<div class="container" style="margin-top: 50px;">
    <h2>Thêm Sản Phẩm Mới</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="product_name">Tên Sản Phẩm:</label>
            <input type="text" class="form-control" id="product_name" name="product_name" required>
        </div>
        <div class="form-group">
            <label for="product_price">Giá:</label>
            <input type="number" class="form-control" id="product_price" name="product_price" required>
        </div>
        <div class="form-group">
            <label for="product_image">Hình Ảnh:</label>
            <input type="file" class="form-control-file" id="product_image" name="product_image" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
    </form>
</div>
</body>
</html>