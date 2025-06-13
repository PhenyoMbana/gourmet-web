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
                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
            </div>
            <div class="product-detail-content">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <span class="product-price"><?php echo format_price($product['price']); ?></span>
                <a href="cart.php?action=add&id=<?php echo $product['product_id']; ?>" class="btn btn-primary">Add to Cart</a>
            </div>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>