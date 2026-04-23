<?php
header("Content-Type: application/json");

$con = mysqli_connect("localhost", "root", "", "mn_international");

if (!$con) {
    echo json_encode([
        "status" => "error",
        "message" => "Database connection failed"
    ]);
    exit;
}

$id = intval($_GET['id']);

// check if exists
$check = mysqli_query($con, "SELECT id FROM products WHERE id=$id AND deleted_at IS NULL");

if (mysqli_num_rows($check) == 0) {
    echo json_encode([
        "status" => "error",
        "message" => "Product not found"
    ]);
    exit;
}

// soft delete
$query = "UPDATE products SET deleted_at = NOW() WHERE id = $id";

if (mysqli_query($con, $query)) {
    echo json_encode([
        "status" => "success",
        "message" => "Product deleted successfully!"
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Unable to delete product"
    ]);
}
?>