<?php
session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$error = '';

// Admin login
if (isset($_POST['adminlogin'])) {
    $email = trim($_POST['email']);
    $password = md5(trim($_POST['password'])); // MD5 hashed password

    // Query to check admin credentials
    $query = "SELECT * FROM users 
              WHERE email = '$email' 
              AND password = '$password' 
              AND deleted_at IS NULL 
              AND role = 'admin'";

    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        // Set session variables
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_name'] = $admin['name'];
        $_SESSION['admin_email'] = $admin['email'];
        $_SESSION['admin_role'] = $admin['role'];

        // Remember me functionality
        if (!empty($_POST['remember'])) {
            setcookie("admin_email", $email, time() + (86400 * 30), "/"); // 30 days
        } else {
            setcookie("admin_email", "", time() - 3600, "/");
        }

        // Redirect to dashboard
        header("Location: Admindashboard.php");
        exit();
    } else {
        $error = "Invalid admin credentials!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - MNInternational</title>
    <link rel="stylesheet" href="css/login.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>
    <div class="login-container">
        <form class="authForm" action="" method="post" novalidate>
            <h2>MNInternational</h2>

            <?php if ($error): ?>
                <p class="error-msg"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <div class="form-group">
                <input type="email" name="email" id="email" placeholder=" " required
                    value="<?= isset($_COOKIE['admin_email']) ? htmlspecialchars($_COOKIE['admin_email']) : '' ?>" />
                <label for="email">Email</label>
            </div>

            <div class="form-group password-group">
                <i class="bx bx-show toggle-icon" id="togglePassword"></i>
                <input type="password" name="password" id="password" placeholder=" " required />
                <label for="password">Password</label>
            </div>

            <div class="form-options">
                <label>
                    <input type="checkbox" name="remember" <?= isset($_COOKIE['admin_email']) ? 'checked' : '' ?> />
                    Remember me
                </label>
            </div>

            <div class="button-group">
                <button type="submit" name="adminlogin">Login</button>
            </div>
        </form>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById("togglePassword");
        const passwordInput = document.getElementById("password");

        togglePassword.addEventListener("click", () => {
            const type = passwordInput.type === "password" ? "text" : "password";
            passwordInput.type = type;
            togglePassword.classList.toggle('bx-show');
            togglePassword.classList.toggle('bx-hide');
        });
    </script>
</body>
</html>