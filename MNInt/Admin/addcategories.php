<?php
include 'include/adminheader.php';
include 'include/sidebar.php';

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize message variables
$success_msg = '';
$error_msg = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = trim(mysqli_real_escape_string($con, $_POST['name']));
    $desc = trim(mysqli_real_escape_string($con, $_POST['description']));

    // Validation
    if ($name === '' || $desc === '') {
        $error_msg = "Please fill in both Category Name and Description!";
    } else {
        $sql = "INSERT INTO categories (category_name, description, created_at) 
                VALUES ('$name', '$desc', NOW())";

        if (mysqli_query($con, $sql)) {
            $success_msg = "Category added successfully!";
            // Clear form values
            $_POST['name'] = '';
            $_POST['description'] = '';
        } else {
            $error_msg = "Error: " . mysqli_error($con);
        }
    }
}
?>

<link rel="stylesheet" href="css/addcategory.css">
<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css" />

<section class="add-category-container">
    <form id="addCategoryForm" method="POST" novalidate>
        <h2><i class="fas fa-plus-circle"></i> Add Category</h2>

        <!-- Success/Error Messages -->
        <?php if($success_msg): ?>
            <div class="alert success"><?= $success_msg ?></div>
        <?php endif; ?>
        <?php if($error_msg): ?>
            <div class="alert error"><?= $error_msg ?></div>
        <?php endif; ?>

        <div class="form-group">
            <input type="text" name="name" placeholder=" " value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            <label><i class="fas fa-tags"></i> Category Name</label>
        </div>

        <div class="form-group">
            <textarea name="description" placeholder=" " required><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
            <label><i class="fas fa-align-left"></i> Description</label>
        </div>

        <div class="button-group">
            <button type="submit" name="submit"><i class="fas fa-upload"></i> Add Category</button>
            <button type="reset" class="cancel-btn"><i class="fas fa-eraser"></i> Clear Form</button>
        </div>
    </form>
</section>


<?php include 'include/adminfooter.php'; ?> 