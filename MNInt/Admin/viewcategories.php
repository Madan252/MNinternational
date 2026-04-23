<?php
include 'include/adminheader.php';
include 'include/sidebar.php';

// DB CONNECTION
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) die("Database connection failed: " . mysqli_connect_error());

// ✅ FIXED ORDER (oldest first like product page)
$query = "SELECT * FROM categories 
          WHERE deleted_at IS NULL 
          ORDER BY id ASC";

$result = mysqli_query($con, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css" />
<link rel="stylesheet" href="css/viewproduct.css" />
 <link rel="stylesheet" href="css/footer.css" />

<div class="dashboard-content">

    <header class="page-header text-center">
        <h1><i class="fas fa-tags"></i> Categories</h1>
    </header>

    <!-- SEARCH -->
    <div class="search-wrapper">
        <input type="search" id="searchInput" placeholder="Search category..." />
        <button id="searchBtn">Search</button>
    </div>

    <!-- TABLE -->
    <div class="table-container">
        <table id="categoryTable" class="product-table">

            <thead>
                <tr>
                    <th>S.N.</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($categories): ?>
                    <?php $sn = 1; foreach ($categories as $cat): ?>
                    <tr id="row-<?= $cat['id'] ?>">
                        <td><?= $sn++ ?></td>
                        <td><?= htmlspecialchars($cat['category_name']) ?></td>
                        <td><?= htmlspecialchars($cat['description'] ?: 'N/A') ?></td>
                        <td><?= date("Y-m-d", strtotime($cat['created_at'])) ?></td>

                        <td class="action-buttons">
                            <a href="addcategories.php?id=<?= $cat['id'] ?>" class="btn edit-btn">
                                Edit
                            </a>

                            <button type="button"
                                onclick="deleteCategory(<?= $cat['id'] ?>)"
                                class="btn delete-btn">
                                Delete
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No categories found</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>

        <!-- PAGINATION -->
        <div class="pagination-controls">
            <button id="prevBtn">Previous</button>
            <span id="pageInfo"></span>
            <button id="nextBtn">Next</button>
        </div>

    </div>
</div>

<?php include 'include/adminfooter.php'; ?> 

<script>

// ================= PAGINATION =================
let rows = Array.from(document.querySelectorAll('#categoryTable tbody tr'));
let currentPage = 1;
const perPage = 8;

function showPage(page) {
    const start = (page - 1) * perPage;
    const end = start + perPage;

    rows.forEach((row, i) => {
        row.style.display = (i >= start && i < end) ? '' : 'none';
    });

    const totalPages = Math.ceil(rows.length / perPage);
    document.getElementById('prevBtn').disabled = page === 1;
    document.getElementById('nextBtn').disabled = page >= totalPages;
    document.getElementById('pageInfo').innerText = `Page ${page} of ${totalPages || 1}`;
}

document.getElementById('prevBtn').onclick = () => {
    if (currentPage > 1) {
        currentPage--;
        showPage(currentPage);
    }
};

document.getElementById('nextBtn').onclick = () => {
    const totalPages = Math.ceil(rows.length / perPage);
    if (currentPage < totalPages) {
        currentPage++;
        showPage(currentPage);
    }
};

showPage(currentPage);

// ================= DELETE CATEGORY =================
function deleteCategory(id) {
    if (confirm("Are you sure?")) {
        fetch("deletecategory.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "id=" + id
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById("row-" + id).remove();

                // refresh rows
                rows = Array.from(document.querySelectorAll('#categoryTable tbody tr'));
                showPage(currentPage);
            } else {
                alert("Delete failed");
            }
        });
    }
}
</script>