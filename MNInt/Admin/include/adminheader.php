
  <link rel="stylesheet" href="css/adminheader.css">
<header class="topnav">
    <!-- Navbar Logo -->
    <div class="logo">
        <a href="Admindashboard.php">
            <img src="image/nevlogo.png"alt="Logo"class="logo-img">
            <span class="logo-text">MN International</span>
        </a>
    </div>

    <nav class="topnav-menu">
        <a href="Admindashboard.php" class="nav-link active">Home</a>
        <a href="logout.php" class="nav-link logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </nav>

    <?php
// Assuming $_SESSION['admin_email'] contains the logged-in admin email
$email = $_SESSION['admin_email'] ?? 'Admin';
$firstWord = explode('@', $email)[0];
?>
<div class="welcome-msg">
    <i class="fas fa-user-circle"></i> Welcome, <strong><?= htmlspecialchars($firstWord) ?></strong>
</div>
</header>
