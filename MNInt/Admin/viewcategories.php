<?php
include 'include/adminheader.php';
include 'include/sidebar.php';

// Connect to the database
$con = mysqli_connect("localhost", "root", "", "mn_international");
if (!$con) die("Database connection failed: " . mysqli_connect_error());

// Fetch categories (only not deleted)
$query = "SELECT * FROM categories WHERE deleted_at IS NULL ORDER BY created_at DESC";
$result = mysqli_query($con, $query);
$categories = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<link rel="stylesheet" href="css/adminheader.css">
<link rel="stylesheet" href="css/sidebar.css" />
<link rel="stylesheet" href="css/viewproduct.css" />

<div class="dashboard-content">

    <header class="page-header text-center">
        <h1><i class="fas fa-tags"></i> Categories</h1>
    </header>

    <!-- Search -->
    <div class="search-wrapper">
        <input type="search" id="searchInput" placeholder="Search by category name..." />
        <button id="searchBtn"><i class="fas fa-search"></i> Search</button>
    </div>

    <!-- Categories Table -->
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
                <?php if ($categories):
                    $sn = 1;
                    foreach ($categories as $cat):
                ?>
                <tr id="row-<?= $cat['id'] ?>">
                    <td><?= $sn++ ?></td>
                    <td><?= htmlspecialchars($cat['category_name']) ?></td>
                    <td><?= htmlspecialchars($cat['description'] ?: 'N/A') ?></td>
                    <td><?= date("Y-m-d", strtotime($cat['created_at'])) ?></td>
                    <td class="action-buttons">
                        <!-- Edit Button -->
                        <a href="addcategories.php?id=<?= $cat['id'] ?>" class="btn edit-btn">
                            <i class="fas fa-edit"></i> Edit
                        </a>

                        <!-- Delete Button -->
                        <button type="button" onclick="deleteCategory(<?= $cat['id'] ?>)" class="btn delete-btn">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="5" class="text-center">No categories found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <div class="pagination-controls">
            <button id="prevBtn" disabled>Previous</button>
            <span id="pageInfo">Page 1</span>
            <button id="nextBtn">Next</button>
        </div>
    </div>
</div>

<?php include 'include/adminfooter.php'; ?>

<script>
// =========================
// Search Functionality
// =========================
function searchCategories() {
    let value = document.getElementById('searchInput').value.toLowerCase();
    let rows = document.querySelectorAll('#categoryTable tbody tr');
    let visibleCount = 0;
    
    rows.forEach(row => {
        let categoryName = row.cells[1]?.innerText.toLowerCase() || '';
        let description = row.cells[2]?.innerText.toLowerCase() || '';
        
        if (categoryName.includes(value) || description.includes(value)) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    currentPage = 1;
    setupPagination();
}

document.getElementById('searchInput').addEventListener('keyup', searchCategories);
document.getElementById('searchBtn').addEventListener('click', searchCategories);

// =========================
// Pagination
// =========================
let rows = [];
let currentPage = 1;
const perPage = 8;

function setupPagination() {
    rows = Array.from(document.querySelectorAll('#categoryTable tbody tr'))
        .filter(row => row.style.display !== 'none');
    
    showPage(currentPage);
}

function showPage(page) {
    const start = (page - 1) * perPage;
    const end = start + perPage;
    
    rows.forEach(row => row.style.display = 'none');
    rows.slice(start, end).forEach(row => row.style.display = '');
    
    const totalPages = Math.ceil(rows.length / perPage);
    document.getElementById('prevBtn').disabled = page === 1;
    document.getElementById('nextBtn').disabled = page >= totalPages;
    document.getElementById('pageInfo').innerText = `Page ${page} of ${totalPages || 1}`;
}

document.getElementById('prevBtn').onclick = () => { if (currentPage > 1) { currentPage--; showPage(currentPage); } };
document.getElementById('nextBtn').onclick = () => { const totalPages = Math.ceil(rows.length / perPage); if (currentPage < totalPages) { currentPage++; showPage(currentPage); } };

// =========================
// Delete Category
// =========================
function deleteCategory(categoryId) {
    if (confirm('Are you sure you want to delete this category?')) {
        fetch('deletecategory.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'id=' + categoryId
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`row-${categoryId}`).remove();
                showMessage('Category deleted successfully!', 'success');
                setupPagination();
                renumberSerialNumbers();
            } else {
                showMessage(data.error || 'Failed to delete category!', 'error');
            }
        })
        .catch(() => showMessage('An error occurred!', 'error'));
    }
}

function renumberSerialNumbers() {
    let visibleRows = document.querySelectorAll('#categoryTable tbody tr:not([style*="display: none"])');
    let sn = 1;
    visibleRows.forEach(row => { row.cells[0].innerText = sn++; });
}

function showMessage(message, type) {
    const existingAlerts = document.querySelectorAll('.alert');
    existingAlerts.forEach(alert => alert.remove());
    
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type}`;
    alertDiv.innerHTML = message;
    alertDiv.style.cssText = `
        position: fixed; top: 80px; right: 20px; padding: 12px 20px;
        border-radius: 5px; z-index: 9999; animation: slideIn 0.3s ease;
        background-color: ${type==='success'?'#d4edda':'#f8d7da'};
        color: ${type==='success'?'#155724':'#721c24'};
        border: 1px solid ${type==='success'?'#c3e6cb':'#f5c6cb'};
    `;
    document.body.appendChild(alertDiv);
    setTimeout(() => alertDiv.remove(), 3000);
}

document.addEventListener('DOMContentLoaded', () => {
    setupPagination();
});

const style = document.createElement('style');
style.textContent = `
@keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
.action-buttons { display: flex; gap: 8px; flex-wrap: wrap; }
.btn:disabled { opacity: 0.6; cursor: not-allowed; }
`;
document.head.appendChild(style);
</script>