<?php
// Include header
include 'header.php';

// Include functions
include 'functions.php';

// Static product data
$products = [
    [
        'id' => 1,
        'name' => 'Chocolate Cake',
        'description' => 'Rich, moist chocolate cake with ganache frosting',
        'price' => 649.99, // Price in Rands
        'image' => 'https://via.placeholder.com/300x200',
        'category' => 'Cakes'
    ],
    [
        'id' => 2,
        'name' => 'Croissants',
        'description' => 'Buttery, flaky French pastries',
        'price' => 49.99, // Price in Rands
        'image' => 'https://via.placeholder.com/300x200',
        'category' => 'Pastries'
    ],
    [
        'id' => 3,
        'name' => 'Sourdough Bread',
        'description' => 'Artisanal sourdough bread baked fresh daily',
        'price' => 79.99, // Price in Rands
        'image' => 'https://via.placeholder.com/300x200',
        'category' => 'Bread'
    ],
    [
        'id' => 4,
        'name' => 'Blueberry Muffins',
        'description' => 'Moist muffins packed with fresh blueberries',
        'price' => 39.99, // Price in Rands
        'image' => 'https://via.placeholder.com/300x200',
        'category' => 'Pastries'
    ],
    [
        'id' => 5,
        'name' => 'Cinnamon Rolls',
        'description' => 'Soft rolls with cinnamon sugar and cream cheese frosting',
        'price' => 59.99, // Price in Rands
        'image' => 'https://via.placeholder.com/300x200',
        'category' => 'Pastries'
    ],
    [
        'id' => 6,
        'name' => 'Baguette',
        'description' => 'Traditional French bread with a crispy crust',
        'price' => 49.99, // Price in Rands
        'image' => 'https://via.placeholder.com/300x200',
        'category' => 'Bread'
    ]
];

// Get categories
$categories = array_unique(array_column($products, 'category'));

// Filter by category if set
$category = isset($_GET['category']) ? $_GET['category'] : '';
if (!empty($category)) {
    $products = array_filter($products, function($product) use ($category) {
        return $product['category'] === $category;
    });
}
?>

<main class="container">
    <section class="page-header">
        <h1>Our Products</h1>
    </section>

    <section class="product-filters">
        <h2>Categories</h2>
        <ul class="category-list">
            <li><a href="products.php" class="<?php echo empty($category) ? 'active' : ''; ?>">All Products</a></li>
            <?php foreach ($categories as $cat): ?>
                <li><a href="products.php?category=<?php echo urlencode($cat); ?>" class="<?php echo $category === $cat ? 'active' : ''; ?>"><?php echo htmlspecialchars($cat); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>

    <section class="product-listing">
        <div class="product-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <p class="price">R<?php echo number_format($product['price'], 2); ?></p>
                        <a href="product_detail.php?id=<?php echo $product['id']; ?>" class="btn">View Details</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-products">No products found in this category.</p>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php
// Include footer
include 'footer.php';
?>