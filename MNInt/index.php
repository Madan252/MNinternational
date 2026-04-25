<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// DB CONNECTION
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) die("Database connection failed");

// CART
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$cartCount = array_sum($_SESSION['cart']);

// =========================
// IMAGE FUNCTIONS
// =========================
function getProductImage($category, $image) {
    $category = strtolower(trim($category ?? 'default'));
    $image = trim($image ?? '');

    $path = "Admin/image/" . $category . "/" . $image;

    if (!empty($image) && file_exists($path)) {
        return $path;
    }
    return "image/default.png";
}

// =========================
// HERO IMAGE ROTATION
// =========================
function getAllImages($dir) {
    $images = [];
    if (!is_dir($dir)) return $images;

    foreach (scandir($dir) as $file) {
        if ($file === '.' || $file === '..') continue;
        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','webp'])) {
            $images[] = $dir . "/" . $file;
        }
    }
    sort($images);
    return $images;
}

$allHeroImages = getAllImages("Admin/image/Eizviz");

if (!isset($_SESSION['hero_index'])) $_SESSION['hero_index'] = 0;

$total = count($allHeroImages);

if ($total > 0) {
    $heroImage = $allHeroImages[$_SESSION['hero_index']];
    $_SESSION['hero_index'] = ($_SESSION['hero_index'] + 1) % $total;
} else {
    $heroImage = "image/default.png";
}

// =========================
// FETCH DATA
// =========================
$categories = [];
$res = mysqli_query($con, "SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY category_name");
while ($row = mysqli_fetch_assoc($res)) $categories[] = $row;

include 'header.php';
?>

<link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">

<!-- ========================= HERO ========================= -->
<section class="hero-section">
    <div class="hero-content">

        <div class="hero-text">
            <h1>MN International</h1>
            <p>Premium CCTV & surveillance solutions across Nepal.</p>
            <a href="products.php" class="btn-card">Explore Products →</a>
        </div>

        <div class="hero-image-grid">
            <img src="<?php echo $heroImage; ?>" class="hero-img">
        </div>

    </div>
</section>

<!-- ========================= PRODUCTS ========================= -->
<section class="products-banner">
<div class="container">

<h1>Our Products</h1>

<!-- 🔥 BEST SELLING -->
<h2 class="section-title">🔥 Best Selling</h2>
<div class="product-grid">

<?php
$best = mysqli_query($con, "
    SELECT * FROM products 
    WHERE deleted_at IS NULL
    ORDER BY stock ASC
    LIMIT 6
");

while ($p = mysqli_fetch_assoc($best)):
?>
<div class="product-card">
    <img src="<?php echo getProductImage($p['category_name'], $p['image']); ?>">
    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
    <div class="price">Rs. <?php echo $p['price']; ?></div>
</div>
<?php endwhile; ?>

</div>

<!-- 🆕 NEW ARRIVALS -->
<h2 class="section-title">🆕 New Arrivals</h2>
<div class="product-grid">

<?php
$new = mysqli_query($con, "
    SELECT * FROM products 
    WHERE deleted_at IS NULL
    ORDER BY id DESC
    LIMIT 6
");

while ($p = mysqli_fetch_assoc($new)):
?>
<div class="product-card">
    <img src="<?php echo getProductImage($p['category_name'], $p['image']); ?>">
    <h3><?php echo htmlspecialchars($p['name']); ?></h3>
    <div class="price">Rs. <?php echo $p['price']; ?></div>
</div>
<?php endwhile; ?>

</div>

<!-- CATEGORY TABS -->
<div class="category-tabs">

    <button class="tab-btn active" onclick="filterProducts('all', this)">All</button>

    <?php foreach ($categories as $c): ?>
        <button class="tab-btn" onclick="filterProducts('<?php echo $c['id']; ?>', this)">
            <?php echo htmlspecialchars($c['category_name']); ?>
        </button>
    <?php endforeach; ?>

</div>

<!-- ALL PRODUCTS (SLIDER) -->
<div id="category-all" class="category-section active">
<div class="slider-wrapper">
<button class="slider-btn left" onclick="scrollSlider(this,-1)">‹</button>

<div class="quality-cards">

<?php
$all = mysqli_query($con, "SELECT * FROM products WHERE deleted_at IS NULL");
while ($p = mysqli_fetch_assoc($all)):
?>
<div class="quality-card">
    <img src="<?php echo getProductImage($p['category_name'], $p['image']); ?>">
    <h3><?php echo $p['name']; ?></h3>
    <div class="product-price">Rs. <?php echo $p['price']; ?></div>
</div>
<?php endwhile; ?>

</div>

<button class="slider-btn right" onclick="scrollSlider(this,1)">›</button>
</div>
</div>

</div>
</section>

<!-- ========================= JS ========================= -->
<script>
function filterProducts(id, btn){
    document.querySelectorAll('.category-section').forEach(s=>s.classList.remove('active'));
    document.getElementById('category-'+id)?.classList.add('active');

    document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
}

function scrollSlider(btn, dir){
    const box = btn.parentElement.querySelector('.quality-cards');
    box.scrollBy({ left: dir*300, behavior:'smooth' });
}
</script>

<?php include 'footer.php'; ?>