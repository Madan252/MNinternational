<?php
// Connect to DB
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Fetch products with category names
$query = "SELECT p.*, c.category_name 
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.id
          WHERE p.deleted_at IS NULL
          ORDER BY p.created_at DESC";
$result = mysqli_query($con, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<?php include 'include/adminheader.php'; ?>
<?php include 'include/sidebar.php'; ?>
<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css" />
<link rel="stylesheet" href="css/viewproduct.css" />

<div class="dashboard-content">
    <header class="page-header text-center">
        <h1><i class="fas fa-box-open"></i> Products</h1>
    </header>

    <!-- Search -->
    <div class="search-wrapper">
        <input type="search" id="searchInput" placeholder="Search by name..." />
    </div>

    <!-- Table -->
    <div class="table-container">
        <table id="productTable" class="product-table">
            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (Rs)</th>
                    <th>Stock</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($products):
                    $sn = 1;
                    foreach ($products as $p):
                        $img = "../assets/images/" . htmlspecialchars($p['image']);
                ?>
                <tr>
                    <td><?= $sn++ ?></td>
                    <td>
                        <?php if (!empty($p['image']) && file_exists($img)): ?>
                            <img src="<?= $img ?>" class="table-img" alt="<?= htmlspecialchars($p['name']) ?>">
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td><?= htmlspecialchars($p['category_name'] ?? 'N/A') ?></td>
                    <td>Rs <?= number_format($p['price'], 2) ?></td>
                    <td><?= htmlspecialchars($p['stock']) ?></td>
                    <td><?= date("Y-m-d", strtotime($p['created_at'])) ?></td>
                    <td>
                        <a href="addproduct.php?id=<?= $p['id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="delete.php?id=<?= $p['id'] ?>" class="btn delete-btn" onclick="return confirm('Delete this product?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                    <tr><td colspan="8" class="text-center">No products found</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <button id="prevBtn">Previous</button>
            <button id="nextBtn">Next</button>
        </div>
    </div>
</div>

<?php include 'include/adminfooter.php'; ?>

<script>
// Search
document.getElementById('searchInput').addEventListener('keyup', function () {
    let value = this.value.toLowerCase();
    document.querySelectorAll('#productTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
    });
});

// Pagination
const rows = Array.from(document.querySelectorAll('#productTable tbody tr'));
let currentPage = 1;
const perPage = 8;

function showPage(page) {
    const start = (page - 1) * perPage;
    const end = start + perPage;

    rows.forEach((row, i) => {
        row.style.display = (i >= start && i < end) ? '' : 'none';
    });

    document.getElementById('prevBtn').disabled = page === 1;
    document.getElementById('nextBtn').disabled = end >= rows.length;
}

document.getElementById('prevBtn').onclick = () => { currentPage--; showPage(currentPage); };
document.getElementById('nextBtn').onclick = () => { currentPage++; showPage(currentPage); };

showPage(currentPage);
</script>