<?php
header('Content-Type: application/json');

// Connect to database
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed']);
    exit;
}

// Get category ID from POST request
$category_id = isset($_POST['id']) ? intval($_POST['id']) : 0;

if ($category_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid category ID']);
    exit;
}

// Soft delete - update deleted_at timestamp
$query = "UPDATE categories SET deleted_at = NOW() WHERE id = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);

if (mysqli_stmt_execute($stmt)) {
    if (mysqli_affected_rows($con) > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Category not found or already deleted']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Database error: ' . mysqli_error($con)]);
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>