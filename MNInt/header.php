<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   BASE URL
========================= */
define('BASE_URL', '/MNInternational/MNInt/');

/* CART COUNT (SAFE VERSION) */
$cartCount = 0;

if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        if (isset($item['qty'])) {
            $cartCount += $item['qty'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MN International</title>

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/header.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/footer.css?v=<?php echo time(); ?>">
</head>

<body>

<!-- HEADER -->
<header class="header">

    <!-- LOGO -->
    <div class="logo">
        <a href="<?php echo BASE_URL; ?>index.php">
            MN International
        </a>
    </div>

    <!-- NAVIGATION -->
    <nav class="nav">
        <ul>

            <li>
                <a href="<?php echo BASE_URL; ?>index.php"
                   class="<?php echo basename($_SERVER['PHP_SELF'])=='index.php'?'active':''; ?>">
                    Home
                </a>
            </li>

            <li>
                <a href="<?php echo BASE_URL; ?>User/Product.php"
                   class="<?php echo basename($_SERVER['PHP_SELF'])=='Product.php'?'active':''; ?>">
                    Products
                </a>
            </li>

            <li>
                <a href="<?php echo BASE_URL; ?>User/About.php"
                   class="<?php echo basename($_SERVER['PHP_SELF'])=='About.php'?'active':''; ?>">
                    About
                </a>
            </li>

            <li>
                <a href="<?php echo BASE_URL; ?>User/Contact.php"
                   class="<?php echo basename($_SERVER['PHP_SELF'])=='Contact.php'?'active':''; ?>">
                    Contact
                </a>
            </li>

            <!-- CART ICON -->
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <a href="<?php echo BASE_URL; ?>User/cart.php" class="cart-icon">
                        🛒

                        <?php if ($cartCount > 0): ?>
                            <span class="cart-count"><?php echo $cartCount; ?></span>
                        <?php endif; ?>

                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>

    <!-- AUTH SECTION -->
    <div class="auth">

        <?php if (isset($_SESSION['user_id'])): ?>

            <div class="user-info">

                <!-- PROFILE IMAGE -->
                <?php if (!empty($_SESSION['user_pic'])): ?>
                    <img src="<?php echo htmlspecialchars($_SESSION['user_pic']); ?>" 
                         alt="Profile" 
                         class="profile-img">
                <?php endif; ?>

                <!-- NAME -->
                <span class="welcome-msg">
                    Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>

                <!-- LOGOUT -->
                <a href="<?php echo BASE_URL; ?>User/Logout.php" class="btn logout">
                    Logout
                </a>

            </div>

        <?php else: ?>

            <!-- ONLY LOGIN -->
            <a href="<?php echo BASE_URL; ?>User/Login.php" class="btn login">
                Login
            </a>

        <?php endif; ?>

    </div>

</header>