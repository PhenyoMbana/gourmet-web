<?php
require_once 'config.php';
require_once 'functions.php';

$page_title = 'Shopping Cart';

// Fetch cart items
$cart_items = get_cart_items();
$cart_total = get_cart_total();

include 'header.php';
?>

<!-- Cart Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Your Shopping Cart</h2>
        
        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <p>Your cart is empty.</p>
                <a href="products.php" class="btn btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="cart-table">
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td><?php echo format_price($item['unit_price']); ?></td>
                            <td><?php echo format_price($item['quantity'] * $item['unit_price']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <h3>Total: <?php echo format_price($cart_total); ?></h3>
                    <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>