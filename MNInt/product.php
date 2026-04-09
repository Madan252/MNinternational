<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hikvision & Ezviz Product Catalog | Security Solutions</title>

    <!-- Product CSS -->
    <link rel="stylesheet" href="css/product.css">
</head>

<body>

<!-- ✅ HEADER (Correct position) -->
<?php include 'header.php'; ?>

<!-- ✅ MAIN CONTENT -->
<div class="container">
    <div class="catalog-header">
        <h1>📹 SecureVision Pro Catalog</h1>
        <p>Hikvision · Ezviz · Professional Surveillance & Access Control</p>
    </div>

    <div class="category-tabs" id="categoryTabs">
        <button class="tab-btn active" data-cat="all">✨ All Products</button>
        <button class="tab-btn" data-cat="analog-cam">📷 Analog Cameras</button>
        <button class="tab-btn" data-cat="ip-cam">🌐 IP Cameras</button>
        <button class="tab-btn" data-cat="dvr-nvr">💾 DVR / NVR / eDVR</button>
        <button class="tab-btn" data-cat="ezviz">🔋 EZVIZ (Battery/POE)</button>
        <button class="tab-btn" data-cat="access">🔑 Access Control</button>
        <button class="tab-btn" data-cat="accessories">🔌 Cables & PSU</button>
    </div>

    <div id="productsContainer" class="products-grid"></div>
</div>

<!-- ✅ FOOTER -->
<?php include 'footer.php'; ?>

<!-- JS -->
<script src="script.js"></script>

</body>
</html>