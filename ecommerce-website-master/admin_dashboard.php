<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php'); // Chuyển hướng nếu không phải admin
    exit();
}

// Kết nối đến cơ sở dữ liệu
require("includes/common.php");

// Lấy danh sách người dùng
$query = "SELECT id, email_id FROM users";
$result = mysqli_query($con, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Lấy danh sách sản phẩm
$query_products = "SELECT id, name, price FROM products";
$result_products = mysqli_query($con, $query_products);
$products = mysqli_fetch_all($result_products, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Thêm CSS nếu cần -->
</head>
<body>
    <header>
        <h1>Bảng Điều Khiển Quản Trị</h1>
        <nav>
            <a href="logout_script.php">Đăng Xuất</a>
            <a href="addproduct.php">Thêm Sản Phẩm</a> <!-- Thêm liên kết đến addproduct.php -->
        </nav>
    </header>

    <main>
        <section>
            <h2>Quản Lý Người Dùng</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['email_id']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <section>
            <h2>Quản Lý Sản Phẩm</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo number_format($product['price'], 2); ?> VND</td>
                            <td><?php echo $product['brand']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <p>Bản quyền © 2024</p>
    </footer>
</body>
</html>
