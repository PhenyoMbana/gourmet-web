<?php
require_once 'config.php';
require_once 'functions.php';

$page_title = 'Checkout';

// Redirect to cart if cart is empty
if (empty(get_cart_items())) {
    redirect('cart.php');
}

// Get cart items and totals
$cart_items = get_cart_items();
$cart_total = get_cart_total();
$delivery_fee = 5.99;
$total = $cart_total + $delivery_fee;

// Handle form submission
$order_completed = false;
$order_reference = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $full_name = isset($_POST['full_name']) ? sanitize($_POST['full_name']) : '';
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    $address = isset($_POST['address']) ? sanitize($_POST['address']) : '';
    $city = isset($_POST['city']) ? sanitize($_POST['city']) : '';
    $zip = isset($_POST['zip']) ? sanitize($_POST['zip']) : '';
    $payment_method = isset($_POST['payment_method']) ? sanitize($_POST['payment_method']) : '';
    
    // Simple validation
    if (empty($full_name)) {
        $errors[] = 'Full name is required';
    }
    
    if (empty($email)) {
        $errors[] = 'Email address is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address';
    }
    
    if (empty($phone)) {
        $errors[] = 'Phone number is required';
    }
    
    if (empty($address)) {
        $errors[] = 'Address is required';
    }
    
    if (empty($city)) {
        $errors[] = 'City is required';
    }
    
    if (empty($zip)) {
        $errors[] = 'ZIP code is required';
    }
    
    if (empty($payment_method)) {
        $errors[] = 'Please select a payment method';
    }
    
    // If no errors, process the order
    if (empty($errors)) {
        // Prepare order data
        $order_data = [
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'zip' => $zip,
            'payment_method' => $payment_method,
            'items' => $cart_items,
            'subtotal' => $cart_total,
            'delivery_fee' => $delivery_fee,
            'total' => $total
        ];
        
        // Process the order
        $order_reference = process_order($order_data);
        
        if ($order_reference) {
            $order_completed = true;
            
            // Clear the cart
            clear_cart();
        } else {
            $errors[] = 'Failed to process your order. Please try again.';
        }
    }
}

include 'header.php';
?>

<!-- Checkout Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Checkout</h2>
        
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <?php if ($order_completed): ?>
            <div class="order-success">
                <h3>Thank You for Your Order!</h3>
                <p>Your order has been placed successfully.</p>
                <p class="order-reference">Order Reference: <strong><?php echo $order_reference; ?></strong></p>
                <p>We've sent a confirmation email to your email address. You will be contacted shortly regarding payment and delivery details.</p>
                <div class="success-actions">
                    <a href="index.php" class="btn btn-primary">Return to Home</a>
                </div>
            </div>
        <?php else: ?>
            <div class="checkout-container">
                <div class="checkout-form-container">
                    <form method="post" action="checkout.php" class="checkout-form">
                        <h3>Delivery Information</h3>
                        
                        <div class="form-group">
                            <label for="full_name" class="form-label">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="address" class="form-label">Address *</label>
                            <input type="text" id="address" name="address" class="form-control" required>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city" class="form-label">City *</label>
                                <input type="text" id="city" name="city" class="form-control" required>
                            </div>
                            
                            <div class="form-group">
                                <label for="zip" class="form-label">ZIP Code *</label>
                                <input type="text" id="zip" name="zip" class="form-control" required>
                            </div>
                        </div>
                        
                        <h3>Payment Method</h3>
                        
                        <div class="payment-methods">
                            <div class="payment-method">
                                <input type="radio" id="payment_cash" name="payment_method" value="cash" checked>
                                <label for="payment_cash">Cash on Delivery</label>
                            </div>
                            
                            <div class="payment-method">
                                <input type="radio" id="payment_card" name="payment_method" value="card">
                                <label for="payment_card">Credit/Debit Card</label>
                            </div>
                            
                            <div class="payment-method">
                                <input type="radio" id="payment_bank" name="payment_method" value="bank">
                                <label for="payment_bank">Bank Transfer</label>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Place Order</button>
                            <a href="cart.php" class="btn btn-outline">Back to Cart</a>
                        </div>
                    </form>
                </div>
                
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-items">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="summary-item">
                                <div class="item-info">
                                    <span class="item-quantity"><?php echo $item['quantity']; ?>×</span>
                                    <span class="item-name"><?php echo $item['name']; ?></span>
                                </div>
                                <span class="item-price"><?php echo format_price($item['price'] * $item['quantity']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="summary-totals">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span><?php echo format_price($cart_total); ?></span>
                        </div>
                        <div class="summary-row">
                            <span>Delivery Fee:</span>
                            <span><?php echo format_price($delivery_fee); ?></span>
                        </div>
                        <div class="summary-row total">
                            <span>Total:</span>
                            <span><?php echo format_price($total); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>
