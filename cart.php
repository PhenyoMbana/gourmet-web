<?php
require_once 'config.php';
require_once 'functions.php';

$page_title = 'Shopping Cart';

// Handle add to cart action
if (isset($_GET['add'])) {
    $product_id = intval($_GET['add']);
    $is_ajax = isset($_GET['ajax']) && $_GET['ajax'] === 'true';
    
    if (add_to_cart($product_id)) {
        $_SESSION['success_message'] = 'Product added to cart successfully!';
        if ($is_ajax) {
            // Return JSON response for AJAX request
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => get_cart_count()
            ]);
            exit;
        }
    } else {
        $_SESSION['error_message'] = 'Failed to add product to cart.';
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Failed to add product to cart.'
            ]);
            exit;
        }
    }
    
    if (!$is_ajax) {
        redirect('cart.php');
    }
}

// Handle remove from cart action
if (isset($_GET['remove'])) {
    $product_id = intval($_GET['remove']);
    remove_from_cart($product_id);
    $_SESSION['success_message'] = 'Product removed from cart.';
    redirect('cart.php');
}

// Handle update quantity action
if (isset($_POST['update_quantity']) && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    // Validate quantity
    if ($quantity > 0 && $quantity <= 10) {
        update_cart_quantity($product_id, $quantity);
        $_SESSION['success_message'] = 'Cart updated successfully!';
    } else {
        $_SESSION['error_message'] = 'Please enter a valid quantity (1-10).';
    }
    redirect('cart.php');
}

// Fetch cart items
$cart_items = get_cart_items();
$cart_total = get_cart_total();

// If this is an AJAX request, don't include the full page
if (isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
    exit;
}

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
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td>
                                <div class="cart-product">
                                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['name']); ?>"
                                         class="cart-product-image">
                                    <span class="cart-product-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                </div>
                            </td>
                            <td>
                                <form action="cart.php" method="POST" class="quantity-form">
                                    <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                                    <div class="quantity-controls">
                                        <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" 
                                               min="1" max="10" class="quantity-input">
                                        <button type="submit" name="update_quantity" class="btn btn-small">Update</button>
                                    </div>
                                </form>
                            </td>
                            <td>R<?php echo number_format($item['price'], 2); ?></td>
                            <td>R<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                            <td>
                                <a href="cart.php?remove=<?php echo $item['id']; ?>" 
                                   class="btn btn-small btn-danger">Remove</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="cart-total">
                    <h3>Total: R<?php echo number_format($cart_total, 2); ?></h3>
                    <div class="cart-actions">
                        <a href="products.php" class="btn btn-outline">Continue Shopping</a>
                        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>