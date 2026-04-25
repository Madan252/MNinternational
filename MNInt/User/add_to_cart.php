<?php
session_start();

/* INIT CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ADD PRODUCT */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += 1;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $_POST['product_name'],
            'price' => $_POST['product_price'],
            'image' => $_POST['product_image'],
            'qty' => 1
        ];
    }
}

/* BACK TO SAME PAGE */
header("Location: Product.php");
exit;
?>