<?php
session_start();
header('Content-Type: application/json');

$con = mysqli_connect("localhost", "root", "", "mn_international");

if (!$con) {
    echo json_encode([
        "success" => false,
        "message" => "Database connection failed"
    ]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$id_token = $data['id_token'] ?? '';

if (!$id_token) {
    echo json_encode([
        "success" => false,
        "message" => "No token received"
    ]);
    exit;
}

/* VERIFY GOOGLE TOKEN */
$google_url = "https://oauth2.googleapis.com/tokeninfo?id_token=" . $id_token;
$response = file_get_contents($google_url);
$userInfo = json_decode($response, true);

if (!isset($userInfo['email'])) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid Google token"
    ]);
    exit;
}

/* USER DATA FROM GOOGLE */
$email   = $userInfo['email'];
$name    = $userInfo['name'] ?? '';
$picture = $userInfo['picture'] ?? '';

/* OPTIONAL: CHECK USER IN DATABASE */
$query = mysqli_query($con, "SELECT id FROM users WHERE email='$email' LIMIT 1");

if (mysqli_num_rows($query) > 0) {
    $row = mysqli_fetch_assoc($query);
    $user_id = $row['id'];
} else {
    // INSERT NEW USER
    mysqli_query($con, "INSERT INTO users (name, email) VALUES ('$name', '$email')");
    $user_id = mysqli_insert_id($con);
}

/* STORE SESSION (IMPORTANT FOR HEADER) */
$_SESSION['user_id']   = $user_id;
$_SESSION['user_name'] = $name;
$_SESSION['user_pic']  = $picture;

/* REDIRECT BACK */
$redirect = $_SESSION['redirect_url'] ?? '../index.php';

if (strpos($redirect, 'Login.php') !== false) {
    $redirect = '../index.php';
}

unset($_SESSION['redirect_url']);

/* RETURN RESPONSE */
echo json_encode([
    "success" => true,
    "redirect" => $redirect
]);
exit;
?>