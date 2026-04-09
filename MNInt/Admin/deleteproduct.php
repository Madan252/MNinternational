<?php
session_start();

// DB connection
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: view.php");
    exit();
}

$id = intval($_GET['id']); // safer

// Soft delete (update deleted_at)
$query = "UPDATE products SET deleted_at = NOW() WHERE id = $id";

if (mysqli_query($con, $query)) {
    header("Location: view.php");
    exit();
} else {
    echo "Error: " . mysqli_error($con);
}
?>