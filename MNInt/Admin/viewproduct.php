<?php
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT p.*, c.category_name 
          FROM products p
          LEFT JOIN categories c ON p.category_id = c.id
          WHERE p.deleted_at IS NULL
          ORDER BY p.id ASC";   // ✅ FIXED: oldest first

$result = mysqli_query($con, $query);
$products = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<?php include 'include/adminheader.php'; ?>
<?php include 'include/sidebar.php'; ?>

<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css">
<link rel="stylesheet" href="css/viewproduct.css">
 <link rel="stylesheet" href="css/footer.css" />

<div class="dashboard-content">

    <header class="page-header text-center">
        <h1><i class="fas fa-box-open"></i> Products</h1>
    </header>

    <!-- Search -->
    <div class="search-wrapper">
        <input type="search" id="searchInput" placeholder="Search product..." />
    </div>

    <!-- Table -->
    <div class="table-container">
        <table id="productTable" class="product-table">

            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Model No</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($products): ?>
                    <?php $sn = 1; foreach ($products as $p): 
                        $img = "../assets/images/" . $p['image'];
                    ?>
                    <tr id="row-<?= $p['id'] ?>">

                        <td><?= $sn++ ?></td>

                        <td>
                            <?php if (!empty($p['image']) && file_exists($img)): ?>
                                <img src="<?= $img ?>" class="table-img">
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </td>

                        <td><?= htmlspecialchars($p['name']) ?></td>
                        <td><?= htmlspecialchars($p['model_number']) ?></td>
                        <td><?= htmlspecialchars($p['category_name'] ?? 'N/A') ?></td>
                        <td>Rs <?= number_format($p['price'], 2) ?></td>
                        <td><?= htmlspecialchars($p['stock']) ?></td>
                        <td><?= date("Y-m-d", strtotime($p['created_at'])) ?></td>

                        <td>
                            <a href="addproduct.php?id=<?= $p['id'] ?>" class="btn edit-btn">Edit</a>

                            <a href="#" class="btn delete-btn"
                               onclick="deleteProduct(<?= $p['id'] ?>)">
                                Delete
                            </a>
                        </td>

                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No products found</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>

        <!-- Pagination -->
        <div class="pagination-controls">
            <button id="prevBtn">Previous</button>
            <button id="nextBtn">Next</button>
        </div>

    </div>
</div>


<?php include 'include/adminfooter.php'; ?> 

<script>
 

// ================= PAGINATION =================
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

document.getElementById('prevBtn').onclick = () => {
    currentPage--;
    showPage(currentPage);
};

document.getElementById('nextBtn').onclick = () => {
    currentPage++;
    showPage(currentPage);
};

showPage(currentPage);

// ================= AJAX DELETE =================
function deleteProduct(id) {

    if (confirm("Are you sure you want to delete this product?")) {

        fetch("deleteproduct.php?id=" + id)
            .then(res => res.json())
            .then(data => {

                if (data.status === "success") {
                    alert(data.message);
                    document.getElementById("row-" + id).remove();
                } else {
                    alert(data.message);
                }

            })
            .catch(error => {
                console.log(error);
                alert("Something went wrong!");
            });
    }
}
</script>