<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/cart.css">
    <title>Your cart</title>
</head>
<body>
    <?php
    session_start();
    include("connectionDB.php");

    // Nhận dữ liệu sản phẩm từ shoes.json
    // $shoes = file_get_contents('data/shoes.json');
    // $shoes = json_decode($shoes, true);

    // Kiểm tra xem giỏ hàng đã tồn tại trong phiên hay chưa
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Nếu người dùng nhấp vào nút `Add to cart`, hãy thêm sản phẩm vào giỏ hàng
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $query = mysqli_query($link, "SELECT * FROM products WHERE id = $id ");
        if ($query) {
            $product = mysqli_fetch_assoc($query);
        }

        $_SESSION['cart'][$id] = [
            'id' => $product['id'],
            'name' => $product['name'],
            'image' => $product['image'],
            'price' => $product['price'],
            'quantity' => 1
        ];
    }

    // Nếu người dùng nhấp vào nút `Cập nhật`, hãy cập nhật số lượng sản phẩm trong giỏ hàng
    if (isset($_POST['id']) && isset($_POST['quantity'])) {
        $id = $_POST['id'];
        $quantity = $_POST['quantity'];
        $_SESSION['cart'][$id]['quantity'] = $quantity;
    }

    // Nếu người dùng nhấp vào nút `Xóa`, hãy xóa sản phẩm khỏi giỏ hàng
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        unset($_SESSION['cart'][$id]);
    }

    // Kiểm tra xem giỏ hàng có rỗng hay không
    if (empty($_SESSION['cart'])) {
        // Hiển thị thông báo
        echo "<script>alert('Giỏ hàng của bạn trống')</script>";
    }

    // Hiển thị giỏ hàng
    $cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
    ?>

    <div class="container">
        <h1>Your cart</h1>

        <table border="1">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total_price = 0; 
                foreach ($cart as $keys => $row) {
					$total_price += ($row['price'] * $row['quantity']);
                }
				foreach ($_SESSION['cart'] as $product) {
                ?>
                    <tr>
                        <td><?php echo $keys++ ?></td>
                        <td><?= $product['name'] ?></td>
                        <td>
                            <img class="img_product" src="<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                        </td>
                        <td><?php echo number_format($product['price']) ?> $</td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <input type="number" name="quantity" value="<?= $product['quantity'] ?>">
                                <button type="submit">Cập nhật</button>
                            </form>
                        </td>
                        <td><?= $product['quantity'] * $product['price'] ?> $</td>
                        <td>
                            <form action="cart.php" method="post">
                                <input type="hidden" name="id" value="<?= $product['id'] ?>">
                                <button type="submit" class="delete">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
					<td><b>Tổng</b></td>
					<td colspan="7" class="text-center bg-info">
                        <?php echo number_format($total_price) ?> $
                    </td>
				</tr>
            </tbody>
        </table>
        <br>
        <button type="submit">Checkout</button>
    </div>

</body>
</html>