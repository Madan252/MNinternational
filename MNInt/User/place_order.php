<?php
session_start();

$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("DB Error");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: User/Login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$address = $_POST['address'];
$phone = $_POST['phone'];

$cart = $_SESSION['cart'];

/* 1. CREATE ORDER */
mysqli_query($con, "
    INSERT INTO orders (user_id, name, address, phone)
    VALUES ('$user_id', '$name', '$address', '$phone')
");

$order_id = mysqli_insert_id($con);

/* 2. INSERT ORDER ITEMS */
foreach ($cart as $item) {

    $product_name = $item['name'];
    $price = $item['price'];
    $qty = $item['qty'];

    mysqli_query($con, "
        INSERT INTO order_items (order_id, product_name, price, qty)
        VALUES ('$order_id', '$product_name', '$price', '$qty')
    ");
}

/* 3. CLEAR CART */
unset($_SESSION['cart']);

echo "<h2 style='text-align:center;'>Order Placed Successfully 🎉</h2>";
echo "<div style='text-align:center;'><a href='index.php'>Go Home</a></div>";
?>