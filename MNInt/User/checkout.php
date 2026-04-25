<?php
session_start();

/* LOGIN CHECK */
if (!isset($_SESSION['user_id'])) {
    header("Location: User/Login.php");
    exit;
}

/* DB CONNECTION */
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed");
}

/* CART */
$cart = $_SESSION['cart'] ?? [];

/* EMPTY CART CHECK */
if (empty($cart)) {
    include '../header.php';
    echo "<h3 style='text-align:center; margin-top:30px;'>Cart is empty</h3>";
    include '../footer.php';
    exit;
}

/* USER DATA */
$user_id = $_SESSION['user_id'];
$userQuery = mysqli_query($con, "SELECT * FROM users WHERE id = '$user_id'");
$user = mysqli_fetch_assoc($userQuery);


/* =========================
   PLACE ORDER LOGIC (RUN FIRST)
========================= */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['qty'];
    }

    /* SAFE INPUT HANDLING */
    $delivery_address = mysqli_real_escape_string($con, $_POST['delivery_address'] ?? '');
    $phone = mysqli_real_escape_string($con, $_POST['phone'] ?? '');

    /* DEFAULT VALUES */
    $order_status = "pending";
    $payment_status = "unpaid";
    $created_at = date("Y-m-d H:i:s");

    /* INSERT ORDER */
    $sql = "INSERT INTO orders 
        (user_id, total_amount, order_status, payment_status, created_at, deleted_at)
        VALUES 
        ('$user_id', '$total', '$order_status', '$payment_status', '$created_at', NULL)";

    if (mysqli_query($con, $sql)) {

        /* CLEAR CART */
        unset($_SESSION['cart']);

        /* CLEAN REDIRECT (IMPORTANT) */
        header("Location: ../index.php?order=success");
        exit;

    } else {
        die("Error: " . mysqli_error($con));
    }
}


/* =========================
   UI SECTION
========================= */
include '../header.php';
?>

<link rel="stylesheet" href="../css/checkout.css?v=<?php echo time(); ?>">

<?php
$total = 0;
?>

<h2 style="text-align:center; margin:20px;">Checkout</h2>

<div class="checkout-container">

    <!-- CART SUMMARY -->
    <div class="cart-summary">

        <h3>Your Order</h3>

        <?php foreach ($cart as $item): 
            $subtotal = $item['price'] * $item['qty'];
            $total += $subtotal;
        ?>

            <div>
                <?php echo htmlspecialchars($item['name']); ?> 
                (x<?php echo $item['qty']; ?>) 
                - Rs. <?php echo $subtotal; ?>
            </div>

        <?php endforeach; ?>

        <hr>

        <h3>Total: Rs. <?php echo $total; ?></h3>

    </div>

    <!-- CHECKOUT FORM -->
    <form method="POST" class="checkout-form">

        <label>Full Name</label>
        <input type="text"
               value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>"
               readonly>

        <label>Email</label>
        <input type="email"
               value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
               readonly>

        <label>Saved Address</label>
        <input type="text"
               value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>"
               readonly>

        <label>Delivery Address</label>
        <input type="text" name="delivery_address"
               placeholder="Enter delivery address"
               required>

        <label>Phone</label>
        <input type="text" name="phone" required>

        <button type="submit" class="btn">
            Place Order
        </button>

    </form>

</div>

<?php include '../footer.php'; ?>