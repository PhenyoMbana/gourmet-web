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

// Get products and handle potential errors
try {
    $products = get_products_by_category($category);
    if (!is_array($products)) {
        throw new Exception('Invalid products data returned');
    }
} catch (Exception $e) {
    error_log('Error in products.php: ' . $e->getMessage());
    $products = [];
}

// Include header
include 'header.php';
?>

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
                    <a href="products.php?category=<?php echo urlencode($cat_key); ?>" 
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
                                <button class="btn btn-primary add-to-cart" data-product-id="<?php echo $product['id']; ?>">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <p>No products found in this category.</p>
                    <a href="products.php" class="btn btn-primary">View All Products</a>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Include footer
include 'footer.php';
?>

<!-- Add this before the closing </body> tag -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            
            // Show loading state
            this.disabled = true;
            this.textContent = 'Adding...';
            
            // Make AJAX request
            fetch(`cart.php?add=${productId}&ajax=true`)
                .then(response => response.json())
                .then(data => {
                    // Show notification
                    const notification = document.createElement('div');
                    notification.className = `notification ${data.success ? 'success' : 'error'}`;
                    notification.textContent = data.message;
                    document.body.appendChild(notification);
                    
                    // Remove notification after 3 seconds
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                    
                    // Update cart count if available
                    if (data.cart_count !== undefined) {
                        const cartCount = document.querySelector('.cart-count');
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Show error notification
                    const notification = document.createElement('div');
                    notification.className = 'notification error';
                    notification.textContent = 'Failed to add product to cart.';
                    document.body.appendChild(notification);
                    
                    setTimeout(() => {
                        notification.remove();
                    }, 3000);
                })
                .finally(() => {
                    // Reset button state
                    this.disabled = false;
                    this.textContent = 'Add to Cart';
                });
        });
    });
});
</script>

<style>
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 15px 25px;
    border-radius: 4px;
    color: white;
    font-weight: 500;
    z-index: 1000;
    animation: slideIn 0.3s ease-out;
}

.notification.success {
    background-color: #4CAF50;
}

.notification.error {
    background-color: #f44336;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>