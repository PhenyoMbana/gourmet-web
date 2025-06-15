<?php
require_once 'config.php';
require_once 'functions.php';
include 'header.php';

// Get featured products
$featured_products = get_featured_products(3);
?>

<main class="container">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Welcome to GOURMET Bakery</h1>
            <p>Delicious pastries and baked goods made with the finest ingredients</p>
            <a href="products.php" class="btn">View Our Products</a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="featured-products">
        <h2>Featured Products</h2>
        <div class="product-grid">
            <?php foreach ($featured_products as $product): ?>
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
        </div>
    </section>

    <!-- Welcome Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Welcome to GOURMET</h2>
            <div class="welcome-content">
                <p>At GOURMET, we believe that every celebration deserves something extraordinary. Our master bakers craft each dessert with meticulous attention to detail, using time-honored recipes and the freshest ingredients.</p>
                <p>From elegant wedding cakes to delightful pastries for your morning coffee, we create edible works of art that taste as magnificent as they look.</p>
            </div>
        </div>
    </section>

    <!-- About Preview Section -->
    <section class="about-preview">
        <h2>About GOURMET Bakery</h2>
        <p>At GOURMET Bakery, we've been crafting delicious baked goods since 1995. Our commitment to quality ingredients and traditional baking methods ensures that every bite is a delight.</p>
        <a href="about.php" class="btn">Learn More</a>
    </section>

    <!-- Call to Action -->
    <section class="section">
        <div class="container">
            <div class="cta-content">
                <h2 class="section-title">Ready to Indulge?</h2>
                <p>Whether you're celebrating a special occasion or simply treating yourself, our gourmet creations are sure to delight your senses.</p>
                <a href="order.php" class="btn btn-secondary">Order Now</a>
            </div>
        </div>
    </section>
</main>

<?php include 'footer.php'; ?>