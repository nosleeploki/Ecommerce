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
$query_products = "SELECT id, name, price, brand FROM products";
$result_products = mysqli_query($con, $query_products);
$products = mysqli_fetch_all($result_products, MYSQLI_ASSOC);

// Xử lý form khi người dùng gửi dữ liệu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = mysqli_real_escape_string($con, $_POST['product_name']);
    $productPrice = mysqli_real_escape_string($con, $_POST['product_price']);
    $productBrand = mysqli_real_escape_string($con, $_POST['product_brand']);
    $productImage = $_FILES['product_image']['name'];

    // Xử lý upload hình ảnh
    $targetDir = "images/";
    $targetFile = $targetDir . basename($productImage);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile);

    // Thêm sản phẩm vào cơ sở dữ liệu
    $query = "INSERT INTO products (name, price, image, brand) VALUES ('$productName', '$productPrice', '$productImage', '$productBrand')";
    mysqli_query($con, $query);

    // Chuyển hướng về trang quản lý sản phẩm hoặc thông báo thành công
    $_SESSION['message'] = 'Product added successfully';
    header('location: admin_dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
         body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

header {
    background: #35424a;
    color: #ffffff;
    padding: 20px 0;
    text-align: center;
}

header h1 {
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

h2 {
    color: #35424a;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
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

.btndelete{
    background-color: #F60002;
}

button:hover {
    background-color: #c0392b;
}

.btnadd {
    background-color: #28a745; /* Màu xanh cho nút thêm sản phẩm */
    margin: 10px 0;
}

.btnadd:hover {
    background-color: #218838; /* Màu xanh đậm khi hover */
}

.popup {
    display: none; /* Ẩn popup mặc định */
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

.form-control-file {
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 5px;
}
    </style>
</head>
<body>
    <header>
        <h1>Bảng Điều Khiển Quản Trị</h1>
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
            <h2 style="display: inline-block; margin-right: 20px;">Quản Lý Sản Phẩm</h2>
            <button class="btnadd" onclick="showPopup()" style="display: inline-block;">Thêm Sản Phẩm</button>
            <br>
            <input type="text" id="search" placeholder="Tìm kiếm sản phẩm...">
            <button class="btnadd" onclick="searchProduct()">Tìm kiếm</button>
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
                                <button class="btnedit" onclick="showEditPopup('<?php echo $product['id']; ?>', '<?php echo addslashes($product['name']); ?>', '<?php echo $product['price']; ?>', '<?php echo addslashes($product['brand']); ?>')">Sửa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Popup them san pham -->
        <div class="popup" id="productPopup">
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
                        <label for="product_brand">Loại sản phẩm:</label>
                        <input type="text" class="form-control" id="product_brand" name="product_brand" required>
                    </div>
                    <div class="form-group">
                        <label for="product_image">Hình Ảnh:</label>
                        <input type="file" class="form-control-file" id="product_image" name="product_image" required>
                    </div>
                    <button class="btnadd" type="submit">Thêm Sản Phẩm</button>
                </form>
            </div>
        </div>

        <!-- Popup sửa sản phẩm -->
        <div class="popup" id="editProductPopup">
            <div class="popup-content">
                <span class="close" onclick="closeEditPopup()">&times;</span>
                <h2>Sửa Sản Phẩm</h2>
                <form method="POST" enctype="multipart/form-data" action="update_product.php">
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
                    <button class="btnedit" type="submit">Cập Nhật Sản Phẩm</button>
                </form>
            </div>
        </div>
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

        function showEditPopup(productId, productName, productPrice, productBrand) {
            document.getElementById('edit_product_id').value = productId;
            document.getElementById('edit_product_name').value = productName;
            document.getElementById('edit_product_price').value = productPrice;
            document.getElementById('edit_product_brand').value = productBrand;
            document.getElementById('editProductPopup').style.display = 'flex';
        }

        function closeEditPopup() {
            document.getElementById('editProductPopup').style.display = 'none';
        }

        function searchProduct() {
            // Implement search functionality here
        }

        // Show a popup if there’s a session message
        <?php if (isset($_SESSION['message'])): ?>
            alert('<?php echo $_SESSION['message']; ?>');
            <?php unset($_SESSION['message']); ?>
        <?php endif; ?>
    </script>
</body>
</html>
