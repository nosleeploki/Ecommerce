<?php
session_start();
require("includes/common.php"); // Kết nối cơ sở dữ liệu

// Lấy danh sách sản phẩm từ cơ sở dữ liệu
$category = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT DISTINCT brand, id, name, price, image FROM products WHERE brand = 'trangtri'" . ($category ? " AND category = '$category'" : ""); // Thay 'products' bằng tên bảng của bạn
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Baker's Mart | Online Shopping</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Delius Swash Caps' rel='stylesheet'>
    <link href='https://fonts.googleapis.com/css?family=Andika' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!--header -->
<?php
include 'includes/header_menu.php';
include 'includes/check-if-added.php';
?>
<!--header ends -->
<div class="container" style="margin-top:65px">
    <!--jumbotron start-->
    <div class="jumbotron text-center">
        <h1>Chào mừng đến Baker's Mart!</h1>
        <p>Chúng tôi có tất cả dụng cụ làm bánh cho bạn</p>
    </div>
    <!--jumbotron ends-->
    
    <!--breadcrumb start-->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item"><a href="products.php">Sản phẩm</a></li>
            <li class="breadcrumb-item active" aria-current="page">Trang trí</li>
        </ol>
    </nav>
    <!--breadcrumb end-->
    
    <hr/>
    
    <!--menu list-->
    <div class="row text-center" id="products">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-md-3 col-6 py-2">
                <div class="card">
                    <img src="images/<?php echo $row['image']; ?>" alt="" class="img-fluid pb-1">
                    <div class="figure-caption">
                        <h6><?php echo $row['name']; ?></h6>
                        <h6>Giá: <?php echo number_format($row['price'], 0, ',', '.'); ?>₫</h6>
                        <?php if (!isset($_SESSION['email'])) { ?>
                            <p><a href="index.php#login" role="button" class="btn btn-warning text-white">Thêm vào giỏ hàng</a></p>
                        <?php } else {
                            if (check_if_added_to_cart($row['id'])) {
                                echo '<p><a href="#" class="btn btn-warning text-white" disabled>Added to cart</a></p>';
                            } else { ?>
                                <p><a href="cart-add.php?id=<?php echo $row['id']; ?>" class="btn btn-warning text-white">Thêm vào giỏ hàng</a></p>
                            <?php }
                        } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <!--menu list ends-->
    
</div>
 <!-- footer-->
 <?php include 'includes/footer.php' ?>
    <!--footer ends-->
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
});
</script>
</html>
