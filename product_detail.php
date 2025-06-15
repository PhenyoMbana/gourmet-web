<?php
require_once 'config.php';
require_once 'functions.php';

// Get product ID from URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details
$product = get_product($product_id);

// Redirect if product not found
if (!$product) {
    redirect('products.php');
}

$page_title = $product['name'];

include 'header.php';
?>

<!-- Product Detail Section -->
<section class="section">
    <div class="container">
        <div class="product-detail-grid">
            <div class="product-detail-image">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                     loading="lazy">
            </div>
            <div class="product-detail-content">
                <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="product-description"><?php echo htmlspecialchars($product['description']); ?></p>
                <?php if (isset($product['long_description'])): ?>
                    <p class="product-long-description"><?php echo htmlspecialchars($product['long_description']); ?></p>
                <?php endif; ?>
                <div class="product-price">R<?php echo number_format($product['price'], 2); ?></div>
                <div class="product-actions">
                    <a href="cart.php?add=<?php echo $product['id']; ?>" class="btn btn-primary">Add to Cart</a>
                    <a href="products.php" class="btn btn-outline">Back to Products</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>