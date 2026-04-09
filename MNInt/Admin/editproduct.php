<?php
include 'include/adminheader.php';
include 'include/sidebar.php';

// Connect to database
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Get product ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: viewproduct.php");
    exit;
}

// Fetch product
$query = "SELECT * FROM products WHERE id = $id AND deleted_at IS NULL";
$result = mysqli_query($con, $query);
$product = $result ? mysqli_fetch_assoc($result) : null;

if (!$product) {
    echo "<p>Product not found.</p>";
    exit;
}

// Fetch categories
$categories = [];
$catResult = mysqli_query($con, "SELECT * FROM categories WHERE deleted_at IS NULL");
while ($cat = mysqli_fetch_assoc($catResult)) {
    $categories[] = $cat;
}

// Image upload settings
$upload_dir = "../assets/images/";
$image = $product['image']; // current image filename

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $name = trim($_POST['name']);
    $description = str_replace("'", "", trim($_POST['description']));
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    // Handle image upload
    if (!empty($_FILES['userfile']['name'])) {
        $image = basename($_FILES['userfile']['name']);
        $upload_file = $upload_dir . $image;
        move_uploaded_file($_FILES['userfile']['tmp_name'], $upload_file);
    }

    // Update product
    $sql_update = "UPDATE products SET 
        name = '".mysqli_real_escape_string($con, $name)."',
        description = '".mysqli_real_escape_string($con, $description)."',
        image = '".mysqli_real_escape_string($con, $image)."',
        price = $price,
        stock = $stock,
        category_id = $category_id
        WHERE id = $id";

    if (mysqli_query($con, $sql_update)) {
        header("Location: viewproduct.php");
        exit;
    } else {
        $error_msg = "Error updating product: " . mysqli_error($con);
    }
}
?>

  <link rel="stylesheet" href="css/addproduct.css" />
<section class="add-product-container" style="max-width: 700px; margin: 40px auto;">
    <form method="POST" enctype="multipart/form-data" novalidate>
        <button type="button" class="close-btn" onclick="window.location.href='viewproduct.php'">&times;</button>
        <h2><i class="fas fa-edit"></i> Edit Product</h2>

        <!-- Error Message -->
        <?php if (!empty($error_msg)): ?>
            <div class="alert error"><?= $error_msg ?></div>
        <?php endif; ?>

        <div class="form-group">
            <input type="text" name="name" placeholder=" " value="<?= htmlspecialchars($product['name']) ?>" required>
            <label><i class="fas fa-tag"></i> Product Name</label>
        </div>

        <div class="form-group">
            <input type="number" name="price" step="0.01" min="0" placeholder=" " value="<?= htmlspecialchars($product['price']) ?>" required>
            <label><i class="fas fa-dollar-sign"></i> Price</label>
        </div>

        <div class="form-group">
            <input type="number" name="stock" min="0" placeholder=" " value="<?= htmlspecialchars($product['stock']) ?>" required>
            <label><i class="fas fa-boxes"></i> Stock</label>
        </div>

        <div class="form-group">
            <select name="category_id" required>
                <option value="" disabled>Select category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['category_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label><i class="fas fa-list"></i> Category</label>
        </div>

        <div class="form-group">
            <textarea name="description" placeholder=" " required><?= htmlspecialchars($product['description']) ?></textarea>
            <label><i class="fas fa-align-left"></i> Description</label>
        </div>

        <div class="form-group">
            <label><i class="fas fa-image"></i> Current Image</label><br>
            <?php if (!empty($image) && file_exists($upload_dir . $image)) : ?>
                <img src="<?= $upload_dir . htmlspecialchars($image) ?>" alt="Product Image" style="max-width:180px; margin-bottom:10px;">
            <?php else: ?>
                <p>No image uploaded.</p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="userfile"><i class="fas fa-upload"></i> Change Image (optional)</label><br>
            <input type="file" name="userfile" id="userfile" accept="image/*">
            <small>Leave empty to keep existing image.</small>
        </div>

        <div class="button-group" style="margin-top: 25px;">
            <button type="submit" name="submit"><i class="fas fa-save"></i> Update Product</button>
        </div>
    </form>
</section>

<?php include 'include/adminfooter.php'; ?>