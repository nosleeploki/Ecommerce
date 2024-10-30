<?php
require "includes/common.php";
session_start();
if (!isset($_SESSION['email'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Baker's Mart | Giỏ hàng</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'includes/header_menu.php'; ?>
<div class="d-flex justify-content-center">
    <div class="col-md-6 my-5 table-responsive p-5">
        <?php
        // Hiển thị thông báo nếu có
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
            unset($_SESSION['message']); // Xóa thông báo sau khi hiển thị
        }
        ?>
        <table class="table table-striped table-bordered table-hover">
            <?php
            $sum = 0;
            $user_id = $_SESSION['user_id'];
            $query = "SELECT products.price AS Price, products.id, products.name AS Name, users_products.quantity AS Quantity 
                      FROM users_products 
                      JOIN products ON users_products.item_id = products.id 
                      WHERE users_products.user_id='$user_id' AND status='Added To Cart'";
            $result = mysqli_query($con, $query);
            if (mysqli_num_rows($result) >= 1) {
            ?>
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                while ($row = mysqli_fetch_array($result)) {
                    $total_price = $row["Price"] * $row["Quantity"];
                    $sum += $total_price;
                    echo "<tr>
                            <td>" . "#" . $row["id"] . "</td>
                            <td>" . $row["Name"] . "</td>
                            <td>
                                <input type='number' class='quantity' value='{$row['Quantity']}' min='1' data-price='{$row['Price']}' style='width: 60px;'>
                            </td>
                            <td class='price'>" . $total_price . " VND</td>
                            <td><a href='cart-remove.php?id={$row['id']}' class='remove_item_link'>Remove</a></td>
                          </tr>";
                }
                echo "<tr>
                        <td></td>
                        <td>Thành tiền</td>
                        <td></td>
                        <td class='total'>" . $sum . " VND</td>
                        <td><a href='success.php' class='btn btn-primary'>Đặt hàng</a></td>
                      </tr>";
                ?>
                </tbody>
            <?php
            } else {
                echo "<div><img src='images/emptycart.png' class='image-fluid' height='150' width='150'></div><br/>";
                echo "<div class='text-bold h5'>Hãy thêm mặt hàng trước!</div>";
            }
            ?>
        </table>
        <a href="products.php" class="btn btn-secondary">Quay về trang sản phẩm</a>
    </div>
</div>
<!--footer -->
<?php include 'includes/footer.php'; ?>
<!--footer end-->

</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</html>
