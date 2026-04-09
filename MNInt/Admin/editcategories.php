<?php
include 'include/adminheader.php';
include 'include/sidebar.php';

// Connect to database
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get category ID
$category_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($category_id <= 0) {
    header("Location: viewcategories.php?error=not_found");
    exit;
}

// Fetch category details
$query = "SELECT * FROM categories WHERE id = ? AND deleted_at IS NULL";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $category_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$category = mysqli_fetch_assoc($result);

if (!$category) {
    header("Location: viewcategories.php?error=not_found");
    exit;
}

// Update category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_name = mysqli_real_escape_string($con, $_POST['category_name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    
    $update_query = "UPDATE categories SET category_name = ?, description = ? WHERE id = ?";
    $update_stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($update_stmt, "ssi", $category_name, $description, $category_id);
    
    if (mysqli_stmt_execute($update_stmt)) {
        header("Location: viewcategories.php?success=updated");
        exit;
    } else {
        $error = "Failed to update category: " . mysqli_error($con);
    }
}

$base = "/MNInternational/MNInt/Admin/";
?>

  <link rel="stylesheet" href="css/addcategories.css" />
<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css" />
<link rel="stylesheet" href="css/editcategory.css" />

<div class="dashboard-content">
    <div class="edit-category-container">
        <header class="page-header">
            <h1><i class="fas fa-edit"></i> Edit Category</h1>
        </header>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" class="edit-category-form">
            <div class="form-group">
                <label for="category_name">Category Name *</label>
                <input type="text" id="category_name" name="category_name" 
                       value="<?= htmlspecialchars($category['category_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5"><?= htmlspecialchars($category['description']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn save-btn">
                    <i class="fas fa-save"></i> Update Category
                </button>
                <a href="viewcategories.php" class="btn cancel-btn">
                    <i class="fas fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'include/adminfooter.php'; ?>