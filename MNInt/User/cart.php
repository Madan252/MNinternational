<?php
session_start();
 include '../header.php'; 

/* INIT CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cart = $_SESSION['cart'];
$total = 0;

/* REMOVE ITEM */
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }

    header("Location: cart.php");
    exit;
}
?>

<link rel="stylesheet" href="../css/cart.css?v=<?php echo time(); ?>">

<h2 class="cart-title">Your Cart</h2>

<div class="cart-container">

<?php if (empty($cart)): ?>

    <p class="empty-cart">🛒 Your cart is empty</p>

<?php else: ?>

    <?php foreach ($cart as $id => $item):

        $subtotal = $item['price'] * $item['qty'];
        $total += $subtotal;

    ?>

    <div class="cart-item">

        <img src="<?php echo htmlspecialchars($item['image']); ?>" class="cart-img">

        <div class="cart-details">

            <h3><?php echo htmlspecialchars($item['name']); ?></h3>

            <p>Price: Rs. <?php echo $item['price']; ?></p>

            <p>Quantity: <?php echo $item['qty']; ?></p>

            <p class="subtotal">Subtotal: Rs. <?php echo $subtotal; ?></p>

        </div>

        <a href="cart.php?remove=<?php echo $id; ?>" class="remove-btn">
            Remove
        </a>

    </div>

    <?php endforeach; ?>

    <div class="cart-total">
        Total: Rs. <?php echo $total; ?>
    </div>

    <div class="checkout-box">
        <a href="checkout.php" class="checkout-btn">
            Proceed to Buy
        </a>
    </div>

<?php endif; ?>

</div>

<?php include '../footer.php'; ?>