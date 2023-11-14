<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="public/css/products.css">
    <title>Products</title>
</head>
<body>
    <div class="container">
        <?php
        session_start();
        include("connectionDB.php");

        // Nhận dữ liệu sản phẩm từ shoes.json
        //$shoes = json_decode(file_get_contents('data/shoes.json'), true);
        
        // Thực hiện câu lệnh SELECT
        $sql = "SELECT * FROM products";

        // Tạo một vòng lặp để duyệt qua danh sách sản phẩm
        if ($result = mysqli_query($link, $sql)) {
            if (mysqli_num_rows($result) > 0) {
                while ($shoe = mysqli_fetch_array($result)) {
        // foreach ($shoes['shoes'] as $shoe) {
        ?>
                <form action="cart.php?id=<?php echo $shoe['id']; ?>" method="post">
                    <input type="hidden" name="id" value="<?= $shoe['id'] ?>">
                    <div class="products_container">
                        <img class="nike" src="assets/nike.png" />
                        <button class="add_cart" type="submit">Add to cart</button>
                        <p class="title">Our products</p>
                        <div class="img_container">
                            <img class="img_product" src="<?= $shoe['image'] ?>" alt="<?= $shoe['name'] ?>">
                        </div>
                        <p class="name_product"><?= $shoe['name'] ?></p>
                        <p class="price_product"><b>Price: </b><?= $shoe['price'] ?> $</p>
                        <p class="description_product"><?= $shoe['description'] ?></p>
                    </div>
                </form>
        <?php
                }
                // Giải phóng bộ nhớ của biến
                mysqli_free_result($result);
            } else {
        ?>
                <div>
                    <p>No Records.</p>
                </div>
        <?php
            }
        } else {
            echo "ERROR: Không thể thực thi câu lệnh $sql. " . mysqli_error($link);
        }
        // Đóng kết nối
        mysqli_close($link);
        ?>
    </div>
</body>
</html>
