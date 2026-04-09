<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_email']) || $_SESSION['admin_role'] !== 'admin') {
    header("Location: Adminlogin.php");
    exit();
}

// Connect to MNInternational database
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Dashboard Stats

// Total Products
$res = mysqli_query($con, "SELECT COUNT(*) AS total FROM products WHERE deleted_at IS NULL");
$totalProducts = mysqli_fetch_assoc($res)['total'] ?? 0;

// Total Users (customers)
$res = mysqli_query($con, "SELECT COUNT(*) AS total FROM users WHERE role = 'customer' AND deleted_at IS NULL");
$totalUsers = mysqli_fetch_assoc($res)['total'] ?? 0;

// Pending Orders
$res = mysqli_query($con, "SELECT COUNT(*) AS total FROM orders WHERE order_status='pending' AND deleted_at IS NULL");
$pendingOrders = mysqli_fetch_assoc($res)['total'] ?? 0;

// Total Revenue (Delivered orders)
$res = mysqli_query($con, "SELECT SUM(subtotal) AS total 
                           FROM order_details od 
                           JOIN orders o ON od.order_id = o.id 
                           WHERE o.deleted_at IS NULL 
                             AND o.order_status='delivered'");
$totalRevenue = mysqli_fetch_assoc($res)['total'] ?? 0;

$adminName = $_SESSION['admin_name'] ?? $_SESSION['admin_email'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />

    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>MNInternational Admin Dashboard</title>
    <?php include 'include/adminheader.php'; ?>
    <?php include 'include/sidebar.php'; ?>
    <link rel="stylesheet" href="css/sidebar.css" />
    <link rel="stylesheet" href="css/admindashboard.css" />    
  <link rel="stylesheet" href="css/adminheader.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

<main class="main-content">
    <h1>Dashboard Overview</h1>
    <div class="stats-container">
        <div class="stat-box">
            <i class="fas fa-box stat-icon"></i>
            <h3>Total Products</h3>
            <p><span class="count" data-target="<?= $totalProducts ?>">0</span></p>
        </div>
        <div class="stat-box">
            <i class="fas fa-users stat-icon"></i>
            <h3>Total Customers</h3>
            <p><span class="count" data-target="<?= $totalUsers ?>">0</span></p>
        </div>
        <div class="stat-box">
            <i class="fas fa-hourglass-half stat-icon"></i>
            <h3>Pending Orders</h3>
            <p><span class="count" data-target="<?= $pendingOrders ?>">0</span></p>
        </div>
        <div class="stat-box">
            <i class="fas fa-dollar-sign stat-icon"></i>
            <h3>Total Revenue</h3>
            <p>Rs. <span class="count" data-target="<?= (int)$totalRevenue ?>">0</span>.00</p>
        </div>
    </div>
</main>

<?php include 'include/adminfooter.php'; ?> 
 

</body>
</html>