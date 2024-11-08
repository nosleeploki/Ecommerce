<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

require("includes/common.php");

// Lấy danh sách người dùng
$query = "SELECT id, email_id FROM users";
$result = mysqli_query($con, $query);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Xử lý tìm kiếm
$searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
$searchField = isset($_POST['searchField']) ? $_POST['searchField'] : 'name';

$query_products = "SELECT id, name, price, brand FROM products";
if ($searchTerm) {
    if ($searchField == 'name') {
        $query_products .= " WHERE name LIKE '%$searchTerm%'";
    } else if ($searchField == 'brand') {
        $query_products .= " WHERE brand LIKE '%$searchTerm%'";
    }
}
$result_products = mysqli_query($con, $query_products);
$products = mysqli_fetch_all($result_products, MYSQLI_ASSOC);

<<<<<<< HEAD
// Thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_name'])) {
=======
// Thêm danh sách sản phẩm
// Kiểm tra xem người dùng đã đăng nhập và có vai trò là admin chưa
if (!isset($_SESSION['email']) || $_SESSION['role'] != 'admin') {
    header('location: index.php'); // Chuyển hướng về trang chính nếu không phải admin
    exit();
}

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
>>>>>>> parent of 880c4d9 (Fixed edit button)
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($con, $_POST['product_price']);
    $productBrand = mysqli_real_escape_string($con, $_POST['product_brand']);
    $productImage = $_FILES['product_image']['name'];
    $targetDir = "images/";
    $targetFile = $targetDir . basename($productImage);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile);
    $query = "INSERT INTO products (name, price, image, brand) VALUES ('$productName', '$productPrice', '$productImage', '$productBrand')";
    mysqli_query($con, $query);
<<<<<<< HEAD
=======

    // Chuyển hướng về trang quản lý sản phẩm hoặc thông báo thành công
>>>>>>> parent of 880c4d9 (Fixed edit button)
    header('location: admin_dashboard.php?success=Product added successfully');
    exit();
}

<<<<<<< HEAD
// Cập nhật sản phẩm
=======
>>>>>>> parent of 880c4d9 (Fixed edit button)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $productId = mysqli_real_escape_string($con, $_POST['product_id']);
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($con, $_POST['product_price']);
    $productBrand = mysqli_real_escape_string($con, $_POST['product_brand']);
<<<<<<< HEAD
=======
    
    // Kiểm tra xem có hình ảnh mới không
>>>>>>> parent of 880c4d9 (Fixed edit button)
    if ($_FILES['product_image']['name']) {
        $productImage = $_FILES['product_image']['name'];
        $targetDir = "images/";
        $targetFile = $targetDir . basename($productImage);
        move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile);
<<<<<<< HEAD
        $query = "UPDATE products SET name = '$productName', price = '$productPrice', image = '$productImage', brand = '$productBrand' WHERE id = '$productId'";
    } else {
        $query = "UPDATE products SET name = '$productName', price = '$productPrice', brand = '$productBrand' WHERE id = '$productId'";
    }
=======
        
        // Cập nhật sản phẩm với hình ảnh mới
        $query = "UPDATE products SET name = '$productName', price = '$productPrice', image = '$productImage', brand = '$productBrand' WHERE id = '$productId'";
    } else {
        // Cập nhật sản phẩm mà không thay đổi hình ảnh
        $query = "UPDATE products SET name = '$productName', price = '$productPrice', brand = '$productBrand' WHERE id = '$productId'";
    }
    
>>>>>>> parent of 880c4d9 (Fixed edit button)
    mysqli_query($con, $query);
    header('Location: admin_dashboard.php?success=Product updated successfully');
    exit();
}

<<<<<<< HEAD
=======


>>>>>>> parent of 880c4d9 (Fixed edit button)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- Thêm CSS nếu cần -->
<<<<<<< HEAD
    <link href='https://fonts.googleapis.com/css?family=Delius+Swash+Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <style>
        body {
            font-family: 'Andika', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
=======
    <style>
    body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}
>>>>>>> parent of 880c4d9 (Fixed edit button)

        header {
            background: #35424a;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        header h1 {
            font-family: 'Delius Swash Caps', cursive;
            /* Áp dụng font cho tiêu đề */
            margin: 0;
        }

        nav {
            margin: 20px 0;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 15px;
        }

        nav a:hover {
            text-decoration: underline;
        }

        main {
            padding: 20px;
        }

        section {
            margin-bottom: 40px;
            background: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2,
        input,
        button {
            font-family: 'Andika', sans-serif;
            /* Áp dụng font cho các tiêu đề h2 */
            color: #35424a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        table th {
            background-color: #35424a;
            color: #ffffff;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #eaeaea;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background: #35424a;
            color: #ffffff;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        button {
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btndelete {
            background-color: #F60002;
        }

button:hover {
    background-color: #c0392b;
}

        .btnadd {
            background-color: #28a745;
            /* Màu xanh cho nút thêm sản phẩm */
            margin: 10px 0;
        }

        .btnadd:hover {
            background-color: #218838;
            /* Màu xanh đậm khi hover */
        }

        .popup {
            display: none;
            /* Ẩn popup mặc định */
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
        }

        .close {
            cursor: pointer;
            color: #e74c3c;
            float: right;
            font-size: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-control {
            width: 95%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

<<<<<<< HEAD
        .form-control-file {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px;
        }
    </style>
=======
.form-control-file {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
}
</style>
>>>>>>> parent of 880c4d9 (Fixed edit button)
</head>

<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="logout_script.php">Đăng Xuất</a>
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
<<<<<<< HEAD
            <h2 style="display: inline-block; margin-right: 20px;">Quản Lý Sản Phẩm</h2>
            <button class="btnadd" onclick="showPopup()">Thêm Sản Phẩm</button> <br>
            <form method="POST" action="" style="display: inline-block;">
                <input type="text" name="searchTerm" placeholder="Tìm kiếm sản phẩm..." value="<?php echo $searchTerm; ?>" style="font-size: 15px;">
                <label><input type="radio" name="searchField" value="name" <?php echo $searchField === 'name' ? 'checked' : ''; ?>> Tên sản phẩm</label>
                <label><input type="radio" name="searchField" value="brand" <?php echo $searchField === 'brand' ? 'checked' : ''; ?>> Loại sản phẩm</label>
                <button class="btnadd" type="submit">Tìm kiếm</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Giá</th>
                        <th>Loại sản phẩm</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo $product['id']; ?></td>
                            <td><?php echo $product['name']; ?></td>
                            <td><?php echo number_format($product['price'], 2); ?> VND</td>
                            <td><?php echo $product['brand']; ?></td>
                            <td>
                                <form action="delete_product.php" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button class="btndelete" type="submit">Xóa</button>
                                </form>
                                <button class="btnedit" type="submit" onclick="editProduct(<?php echo $product['id']; ?>)">Sửa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <div class="popup" id="productPopup">
=======
    <h2 style="display: inline-block; margin-right: 20px;">Quản Lý Sản Phẩm</h2>
    <button class="btnadd" onclick="showPopup()" style="display: inline-block;">Thêm Sản Phẩm</button> <br>
    <input type="text" id="search" placeholder="Tìm kiếm sản phẩm..." value="<?php echo $searchTerm; ?>">
    <button class="btnadd" onclick="searchProduct()">Tìm kiếm</button>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên Sản Phẩm</th>
                <th>Giá</th>
                <th>Loại sản phẩm</th>
                <th>Hành động</th> <!-- Cột hành động -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['id']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['price'], 2); ?> VND</td>
                    <td><?php echo $product['brand']; ?></td>
                    <td>
                        <form action="delete_product.php" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <button class="btndelete" type="submit">Xóa</button>
                        </form>
                        <button class="btnedit" type="submit">Sửa</button>

                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


<!--popup-->
<div class="popup" id="productPopup">
>>>>>>> parent of 880c4d9 (Fixed edit button)
            <div class="popup-content">
                <span class="close" onclick="closePopup()">&times;</span>
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
                    <label for="product_image">Loại sản phẩm:</label>
                    <input type="text" class="form-control" id="product_brand" name="product_brand" required>
                </div>
                <div class="form-group">
                    <label for="product_image">Hình Ảnh:</label>
                    <input type="file" class="form-control-file" id="product_image" name="product_image" required>
                </div>
                <button class="btnadd" type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
            </form>
                    </div>
        </div>
<<<<<<< HEAD
=======

        <!-- Popup sửa sản phẩm -->
        <div class="popup" id="editProductPopup">
            <div class="popup-content">
                <span class="close" onclick="closeEditPopup()">&times;</span>
                <h2>Sửa Sản Phẩm</h2>
                <form method="POST" enctype="multipart/form-data" id="editProductForm">
                    <input type="hidden" id="edit_product_id" name="product_id">
                    <div class="form-group">
                        <label for="edit_product_name">Tên Sản Phẩm:</label>
                        <input type="text" class="form-control" id="edit_product_name" name="product_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_price">Giá:</label>
                        <input type="number" class="form-control" id="edit_product_price" name="product_price" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_brand">Loại sản phẩm:</label>
                        <input type="text" class="form-control" id="edit_product_brand" name="product_brand" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_product_image">Hình Ảnh (nếu muốn thay đổi):</label>
                        <input type="file" class="form-control-file" id="edit_product_image" name="product_image">
                    </div>
                    <button class="btnadd" type="submit">Cập Nhật Sản Phẩm</button>
                </form>
            </div>
        </div>
>>>>>>> parent of 880c4d9 (Fixed edit button)
    </main>
    <footer>
        <p>Bản quyền © 2024</p>
    </footer>

    <script>
        function showPopup() {
            document.getElementById('productPopup').style.display = 'flex';
        }

        function closePopup() {
            document.getElementById('productPopup').style.display = 'none';
        }
    </script>

</body>

</html>