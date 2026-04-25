<?php
include '../header.php';

$con = mysqli_connect("localhost", "root", "", "mn_international");

$id = (int) $_GET['id'];

$result = mysqli_query($con, "
    SELECT p.*, c.category_name 
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.id = $id
");

$row = mysqli_fetch_assoc($result);
?>

<link rel="stylesheet" href="../css/product_detail.css?v=<?php echo time(); ?>">

<div class="product-wrapper">

    <div class="product-box">

        <h2 class="product-name"><?= $row['name']; ?></h2>

        <p class="model">Model: <?= $row['model_number']; ?></p>

        <p class="category">Category: <?= $row['category_name']; ?></p>

        <img src="../uploads/<?= $row['image']; ?>" class="product-image">

        <p class="description"><?= $row['description']; ?></p>

        <p class="price">Rs. <?= $row['price']; ?></p>

        <a href="cart.php?add=<?= $row['id']; ?>" class="btn-cart">Add to Cart</a>

    </div>

</div>

<?php include '../footer.php'; ?>