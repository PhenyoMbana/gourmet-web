<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include required files
include 'config.php';
include 'functions.php';

// Get categories from config
global $categories;

// Filter by category if set
$category = isset($_GET['category']) ? $_GET['category'] : 'all';
$products = get_products_by_category($category);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products | Gourmet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <main class="container">
        <section class="page-header">
            <h1>Our Products</h1>
            <p>Discover our selection of freshly baked goods and desserts</p>
        </section>

        <section class="product-filters">
            <div class="filter-bar">
                <h2>Categories</h2>
                <div class="filter-buttons">
                    <?php foreach ($categories as $cat_key => $cat_name): ?>
                        <a href="products_minimal.php?category=<?php echo urlencode($cat_key); ?>" 
                           class="filter-btn <?php echo $category === $cat_key ? 'active' : ''; ?>">
                            <?php echo htmlspecialchars($cat_name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="product-listing">
            <div class="product-grid">
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     loading="lazy">
                            </div>
                            <div class="product-content">
                                <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                                <p><?php echo htmlspecialchars($product['description']); ?></p>
                                <div class="product-price">
                                    R<?php echo number_format($product['price'], 2); ?>
                                </div>
                                <div class="product-actions">
                                    <a href="product_detail.php?id=<?php echo $product['id']; ?>" 
                                       class="btn btn-outline">View Details</a>
                                    <a href="cart.php?add=<?php echo $product['id']; ?>" 
                                       class="btn btn-primary">Add to Cart</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="no-products">
                        <p>No products found in this category.</p>
                        <a href="products_minimal.php" class="btn btn-primary">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html> 