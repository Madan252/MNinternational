<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Database connection
$con = mysqli_connect("localhost", "root", "", "mn_international");

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Initialize cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$cartCount = array_sum($_SESSION['cart']);

/* =========================
   FETCH CATEGORIES
========================= */
$categoryQuery = "SELECT * FROM categories ORDER BY category_name";
$categoryResult = mysqli_query($con, $categoryQuery);

if (!$categoryResult) {
    die("Category Query Error: " . mysqli_error($con));
}

$categories = [];
while ($row = mysqli_fetch_assoc($categoryResult)) {
    $categories[] = $row;
}

/* =========================
   FETCH PRODUCTS
========================= */
$productsByCategory = [];

foreach ($categories as $category) {

    $productQuery = "SELECT p.*, c.category_name 
                     FROM products p
                     JOIN categories c ON p.category_id = c.id
                     WHERE p.category_id = {$category['id']}
                     ORDER BY p.created_at DESC";

    $productResult = mysqli_query($con, $productQuery);

    if (!$productResult) {
        die("Product Query Error: " . mysqli_error($con));
    }

    $products = [];
    while ($row = mysqli_fetch_assoc($productResult)) {
        $products[] = $row;
    }

    $productsByCategory[$category['id']] = [
        'category' => $category,
        'products' => $products
    ];
}

/* =========================
   FETCH ALL PRODUCTS
========================= */
$allProductsQuery = "SELECT p.*, c.category_name 
                     FROM products p
                     JOIN categories c ON p.category_id = c.id
                     ORDER BY p.created_at DESC";

$allProductsResult = mysqli_query($con, $allProductsQuery);

if (!$allProductsResult) {
    die("All Products Query Error: " . mysqli_error($con));
}

$allProducts = [];
while ($row = mysqli_fetch_assoc($allProductsResult)) {
    $allProducts[] = $row;
}

// HEADER
$page_css = '<link rel="stylesheet" href="css/index.css">';

include 'header.php';
?>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="hero-content">

        <div class="hero-image">
            <img src="image/home.jpeg" alt="MN International">
        </div>

        <div class="hero-text">
            <h1>MN International</h1>
            <p>
                Delivering premium CCTV and surveillance solutions across Nepal with 24/7 support and trusted technology.
            </p>
            <a href="products.php" class="btn-card">Explore Products →</a>
        </div>

    </div>
</section>

<!-- PRODUCTS SECTION -->
<section class="products-banner">
    <div class="container">

        <h1 class="banner-title">Our Products</h1>
        <p class="banner-subtitle">Explore CCTV and security solutions</p>

        <!-- CATEGORY TABS -->
        <div class="category-tabs">
            <button class="tab-btn active" onclick="filterProducts('all')">All Products</button>

            <?php foreach ($categories as $category): ?>
                <button class="tab-btn" onclick="filterProducts('<?php echo $category['id']; ?>')">
                    <?php echo htmlspecialchars($category['category_name']); ?>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- PRODUCTS BY CATEGORY -->
        <?php foreach ($productsByCategory as $categoryData): ?>
            <?php if (count($categoryData['products']) > 0): ?>

                <div id="category-<?php echo $categoryData['category']['id']; ?>" class="category-section">

                    <h3 class="section-title">
                        <?php echo htmlspecialchars($categoryData['category']['category_name']); ?>
                    </h3>

                    <div class="quality-cards">

                        <?php foreach ($categoryData['products'] as $product): ?>

                            <?php
                            $image = !empty($product['image']) ? $product['image'] : 'default.png';
                            $imagePath = "image/" . $image;

                            if (!file_exists($imagePath)) {
                                $imagePath = "image/default.png";
                            }
                            ?>

                            <div class="quality-card">

                                <img src="<?php echo $imagePath; ?>" alt="product">

                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>

                                <p>
                                    <?php echo htmlspecialchars(substr($product['description'], 0, 100)) . '...'; ?>
                                </p>

                                <div class="product-price">
                                    Rs. <?php echo number_format($product['price'], 2); ?>
                                </div>

                                <div class="product-stock">
                                    <?php echo ($product['stock'] > 0) ? '✓ In Stock' : '✗ Out of Stock'; ?>
                                </div>

                                <div class="product-buttons">

                                    <?php if ($product['stock'] > 0): ?>
                                        <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn-add-cart">
                                            Add to Cart
                                        </button>
                                    <?php else: ?>
                                        <button class="btn-add-cart disabled" disabled>
                                            Out of Stock
                                        </button>
                                    <?php endif; ?>

                                    <a href="product-details.php?id=<?php echo $product['id']; ?>" class="btn-view-more">
                                        View More
                                    </a>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>

            <?php endif; ?>
        <?php endforeach; ?>

    </div>
</section>

<?php include 'footer.php'; ?>