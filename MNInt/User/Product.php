<?php
include '../header.php';

// DB CONNECTION
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

/* FETCH CATEGORIES */
$categories = [];
$catResult = mysqli_query($con, "SELECT * FROM categories WHERE deleted_at IS NULL");

while ($row = mysqli_fetch_assoc($catResult)) {
    $categories[] = $row;
}

/* IMAGE HANDLER */
function getImage($img) {
    $base = "../Admin/image/";
    $default = $base . "default.png";

    if (!empty($img) && file_exists($base . $img)) {
        return $base . $img;
    }
    return $default;
}
?>

<link rel="stylesheet" href="../css/product.css?v=<?php echo time(); ?>">

<script>
function filterProducts(id, btn) {

    document.querySelectorAll('.category-section').forEach(sec => {
        sec.classList.remove('active');
    });

    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('active');
    });

    document.getElementById('category-' + id).classList.add('active');
    btn.classList.add('active');
}
</script>

<style>
.category-section { display: none; }
.category-section.active { display: block; }
</style>

<div class="container">

<h1>Our Products</h1>

<!-- CATEGORY BUTTONS -->
<div class="category-tabs">

    <button class="tab-btn active" onclick="filterProducts('all', this)">
        All
    </button>

    <?php foreach ($categories as $cat): ?>
        <button class="tab-btn" onclick="filterProducts('<?php echo $cat['id']; ?>', this)">
            <?php echo htmlspecialchars($cat['category_name']); ?>
        </button>
    <?php endforeach; ?>

</div>

<!-- ================= ALL PRODUCTS ================= -->
<div id="category-all" class="category-section active">
<div class="product-grid">

<?php
$all = mysqli_query($con, "
    SELECT p.*, c.category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.deleted_at IS NULL
");

while ($p = mysqli_fetch_assoc($all)):
?>

<div class="product-card">

    <img src="<?php echo getImage($p['image']); ?>" alt="Product">

    <h3><?php echo htmlspecialchars($p['name']); ?></h3>

    <div class="price">Rs. <?php echo $p['price']; ?></div>

    <div class="stock">Stock: <?php echo $p['stock']; ?></div>

    <div class="actions">

        <a href="Product_detail.php?id=<?php echo $p['id']; ?>" class="view-btn">
            View
        </a>

        <!-- ✅ ADD TO CART FIXED -->
        <form method="POST" action="add_to_cart.php">

            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $p['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $p['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $p['image']; ?>">

            <button type="submit" class="cart-btn">
                Add to Cart
            </button>

        </form>

    </div>

</div>

<?php endwhile; ?>

</div>
</div>

<!-- ================= CATEGORY PRODUCTS ================= -->
<?php foreach ($categories as $cat): ?>

<div id="category-<?php echo $cat['id']; ?>" class="category-section">
<div class="product-grid">

<?php
$id = (int)$cat['id'];

$r = mysqli_query($con, "
    SELECT p.*, c.category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.category_id = $id AND p.deleted_at IS NULL
");

while ($p = mysqli_fetch_assoc($r)):
?>

<div class="product-card">

    <img src="<?php echo getImage($p['image']); ?>" alt="Product">

    <h3><?php echo htmlspecialchars($p['name']); ?></h3>

    <div class="price">Rs. <?php echo $p['price']; ?></div>

    <div class="stock">Stock: <?php echo $p['stock']; ?></div>

    <div class="actions">

        <a href="Product_detail.php?id=<?php echo $p['id']; ?>" class="view-btn">
            View
        </a>

        <!-- ✅ ADD TO CART FIXED -->
        <form method="POST" action="add_to_cart.php">

            <input type="hidden" name="product_id" value="<?php echo $p['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $p['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $p['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $p['image']; ?>">

            <button type="submit" class="cart-btn">
                Add to Cart
            </button>

        </form>

    </div>

</div>

<?php endwhile; ?>

</div>
</div>

<?php endforeach; ?>

</div>

<?php include '../footer.php'; ?>