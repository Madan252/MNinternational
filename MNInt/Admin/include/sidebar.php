<?php
// Current page detection
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- Link to Sidebar CSS -->
<link rel="stylesheet" href="css/sidebar.css">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

<aside class="sidebar">
    <ul class="sidebar-menu">

        <!-- Dashboard -->
        <li>
            <a href="<?= $base ?>Admindashboard.php"
               class="sidebar-link <?= ($current_page == 'Admindashboard.php') ? 'active' : '' ?>">
                <i class="fas fa-chart-line"></i> <span>Dashboard</span>
            </a>
        </li>
        
        <!-- Products -->
        <li class="dropdown <?= in_array($current_page, ['addproduct.php','viewproduct.php','editproduct.php','deleteproduct.php']) ? 'open' : '' ?>">
            <a href="javascript:void(0);" class="sidebar-link dropdown-toggle" data-dropdown="products">
                <i class="fas fa-box-open"></i> <span>Products</span>
                <i class="fas fa-chevron-down arrow"></i>
            </a>
            <ul class="dropdown-menu" data-dropdown-menu="products">
                <li>
                    <a href="<?= $base ?>addproduct.php"
                       class="sidebar-sublink <?= ($current_page == 'addproduct.php') ? 'active' : '' ?>">
                        <span>Add Product</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base ?>viewproduct.php"
                       class="sidebar-sublink <?= ($current_page == 'viewproduct.php') ? 'active' : '' ?>">
                        <span>View Products</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Categories -->
        <li class="dropdown <?= in_array($current_page, ['addcategories.php','viewcategories.php','editcategories.php']) ? 'open' : '' ?>">
            <a href="javascript:void(0);" class="sidebar-link dropdown-toggle" data-dropdown="categories">
                <i class="fas fa-tags"></i> <span>Categories</span>
                <i class="fas fa-chevron-down arrow"></i>
            </a>
            <ul class="dropdown-menu" data-dropdown-menu="categories">
                <li>
                    <a href="<?= $base ?>addcategories.php"
                       class="sidebar-sublink <?= ($current_page == 'addcategories.php') ? 'active' : '' ?>">
                        <span>Add Category</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $base ?>viewcategories.php"
                       class="sidebar-sublink <?= ($current_page == 'viewcategories.php') ? 'active' : '' ?>">
                        <span>View Categories</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Customers -->
        <li>
            <a href="<?= $base ?>customers.php"
               class="sidebar-link <?= ($current_page == 'customers.php') ? 'active' : '' ?>">
                <i class="fas fa-users"></i> <span>Customers</span>
            </a>
        </li>

        <!-- Orders -->
        <li>
            <a href="<?= $base ?>Adminorders.php"
               class="sidebar-link <?= ($current_page == 'Adminorders.php') ? 'active' : '' ?>">
                <i class="fas fa-shopping-cart"></i> <span>Orders</span>
            </a>
        </li>

        <!-- Order Details -->
        <li>
            <a href="<?= $base ?>orderdetails.php"
               class="sidebar-link <?= ($current_page == 'orderdetails.php') ? 'active' : '' ?>">
                <i class="fas fa-clipboard-list"></i> <span>Order Details</span>
            </a>
        </li>

        <!-- Reviews -->
        <li>
            <a href="<?= $base ?>product_rating_review.php"
               class="sidebar-link <?= ($current_page == 'product_rating_review.php') ? 'active' : '' ?>">
                <i class="fas fa-comment-dots"></i> <span>Reviews</span>
            </a>
        </li>

        <!-- Settings -->
        <li>
            <a href="<?= $base ?>setting.php"
               class="sidebar-link <?= ($current_page == 'setting.php') ? 'active' : '' ?>">
                <i class="fas fa-cog"></i> <span>Settings</span>
            </a>
        </li>

    </ul>
</aside>
<script>
// Force dropdown functionality with direct event binding
(function() {
    // Function to handle dropdown clicks
    function setupDropdowns() {
        // Get all dropdown toggle elements
        var toggles = document.querySelectorAll('.dropdown-toggle');
        
        for (var i = 0; i < toggles.length; i++) {
            var toggle = toggles[i];
            
            // Remove old listener if exists
            if (toggle.hasAttribute('data-listener')) {
                continue;
            }
            
            // Mark as having listener
            toggle.setAttribute('data-listener', 'true');
            
            // Add click event
            toggle.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                // Find parent dropdown
                var parent = this.parentNode;
                while (parent && !parent.classList.contains('dropdown')) {
                    parent = parent.parentNode;
                }
                
                if (parent) {
                    // Close others
                    var allDropdowns = document.querySelectorAll('.dropdown');
                    for (var j = 0; j < allDropdowns.length; j++) {
                        if (allDropdowns[j] !== parent) {
                            allDropdowns[j].classList.remove('open');
                        }
                    }
                    
                    // Toggle this one
                    parent.classList.toggle('open');
                }
                
                return false;
            };
        }
    }
    
    // Run on page load
    window.addEventListener('load', setupDropdowns);
    document.addEventListener('DOMContentLoaded', setupDropdowns);
    
    // Also run immediately if DOM already loaded
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(setupDropdowns, 100);
    }
})();
</script>