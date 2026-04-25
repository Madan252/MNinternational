<?php
session_start();

/* if no login */
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

/* redirect logic */
$redirect = $_SESSION['redirect_url'] ?? '../index.php';

/* safety check */
if (strpos($redirect, 'login.php') !== false) {
    $redirect = '../index.php';
}

unset($_SESSION['redirect_url']);

/* go back to previous page */
header("Location: " . $redirect);
exit;
?>