<?php
// Connect to DB
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch categories
$categoryResult = mysqli_query($con, "SELECT id, category_name FROM categories WHERE deleted_at IS NULL");
$categories = [];
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $row;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submit"])) {

    // Upload path
    $upload_dir = "image/";

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $image = "";

    // ✅ GET FORM DATA (ADDED MODEL NUMBER)
    $name = mysqli_real_escape_string($con, $_POST["name"]);
    $model_number = mysqli_real_escape_string($con, $_POST["model_number"]); // ✅ NEW
    $desc = mysqli_real_escape_string($con, $_POST["description"]);
    $price = floatval($_POST["price"]);
    $stock = intval($_POST["stock"]);
    $category_id = intval($_POST["category_id"]);

    // Validation
    $errors = [];

    if (empty($name)) $errors[] = "Product name is required!";
    if (empty($model_number)) $errors[] = "Model number is required!"; // ✅ NEW
    if (empty($desc)) $errors[] = "Description is required!";
    if ($price < 0) $errors[] = "Price cannot be negative!";
    if ($stock < 0) $errors[] = "Stock cannot be negative!";
    if ($category_id <= 0) $errors[] = "Please select a category!";
    if (empty($_FILES['userfile']['name'])) $errors[] = "Image is required!";

    // Image upload
    if (empty($errors) && isset($_FILES['userfile']) && $_FILES['userfile']['error'] === 0) {

        $image = time() . "_" . basename($_FILES['userfile']['name']);
        $target_file = $upload_dir . $image;

        if (!move_uploaded_file($_FILES['userfile']['tmp_name'], $target_file)) {
            $errors[] = "Failed to upload image!";
        }
    }

    // Insert into database
    if (!empty($errors)) {
        echo "<script>alert('" . implode("\\n", $errors) . "');</script>";
    } else {

        $sql = "INSERT INTO products 
                (name, model_number, description, price, stock, image, category_id, brand_id, created_at)
                VALUES 
                ('$name', '$model_number', '$desc', $price, $stock, '$image', $category_id, NULL, NOW())";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Product added successfully!');</script>";
            echo "<script>window.location.href='" . $_SERVER['PHP_SELF'] . "';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>

<?php include 'include/adminheader.php'; ?>
<?php include 'include/sidebar.php'; ?>

<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css" />
<link rel="stylesheet" href="css/addproduct.css" />
 <link rel="stylesheet" href="css/footer.css" />
<section class="add-product-container">
    <form method="POST" enctype="multipart/form-data">

        <button type="button" class="close-btn"
            onclick="window.location.href='../admin/Admindashboard.php'">&times;</button>

        <h2><i class="fas fa-plus-circle"></i> Add Product</h2>

        <div class="inline-group">
            <div class="form-group">
                <input type="text" name="name" placeholder=" " required>
                <label>Product Name</label>
            </div>
            <div class="form-group">
                <input type="text" name="model_number" placeholder=" " required>
                <label>Model Number</label>
            </div>

            <div class="form-group">
                <input type="number" name="price" step="0.01" min="0" required>
                <label>Price</label>
            </div>

            <div class="form-group">
                <input type="number" name="stock" min="0" required>
                <label>Stock</label>
            </div>
        </div>

        <div class="form-group">
            <select name="category_id" required>
                <option value="" disabled selected>Select Category</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>">
                        <?php echo $cat['category_name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Category</label>
        </div>

        <div class="form-group">
            <textarea name="description" required></textarea>
            <label>Description</label>
        </div>

        <div class="form-group">
            <input type="file" name="userfile" required>
            <label>Upload Image</label>
        </div>

        <div class="button-group">
            <button type="submit" name="submit">Add Product</button>
            <button type="reset" class="cancel-btn">Clear</button>
        </div>

    </form>
</section>

<?php include 'include/adminfooter.php'; ?> 