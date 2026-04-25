<?php
session_start();

/* =========================
   CLEAR SESSION
========================= */
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_pic']);

session_unset();
session_destroy();

/* =========================
   REDIRECT TO HOME
========================= */
header("Location: /MNInternational/MNInt/index.php");
exit;
?>