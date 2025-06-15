<?php
require_once 'config.php';
require_once 'functions.php';

$page_title = 'Place Your Order';

// Get product ID from URL if available
$product_id = isset($_GET['product']) ? intval($_GET['product']) : 0;

// Handle form submission
$order_submitted = false;
$order_reference = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    $full_name = isset($_POST['full_name']) ? sanitize($_POST['full_name']) : '';
    $email = isset($_POST['email']) ? sanitize($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? sanitize($_POST['phone']) : '';
    $product = isset($_POST['product']) ? sanitize($_POST['product']) : '';
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;
    $date = isset($_POST['date']) ? sanitize($_POST['date']) : '';
    $instructions = isset($_POST['instructions']) ? sanitize($_POST['instructions']) : '';
    
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
    
    if (empty($product)) {
        $errors[] = 'Please select a product';
    }
    
    if (empty($date)) {
        $errors[] = 'Please select a date';
    }
    
    // If no errors, process the order
    if (empty($errors)) {
        // In a real application, you would save the order to a database
        // For now, we'll just simulate a successful order submission
        $order_submitted = true;
        $order_reference = generate_order_reference();
    }
}

include 'header.php';
?>

<!-- Order Section -->
<section class="section">
    <div class="container">
        <h2 class="section-title">Place Your Order</h2>
        <div class="order-content">
            <p class="order-intro">Please fill out the form below to place your order. We'll contact you to confirm details and arrange payment.</p>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo $error; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if (!$order_submitted): ?>
                <form id="orderForm" class="order-form" method="post" action="order.php">
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
                        <label for="product" class="form-label">Select Product *</label>
                        <select id="product" name="product" class="form-control" required>
                            <option value="">-- Select a Product --</option>
                            <?php foreach (get_all_products() as $prod): ?>
                                <option value="<?php echo $prod['id']; ?>" <?php echo ($product_id == $prod['id']) ? 'selected' : ''; ?>>
                                    <?php echo $prod['name']; ?> - <?php echo format_price($prod['price']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="quantity" class="form-label">Quantity *</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" min="1" value="1" required>
                    </div>

                    <div class="form-group">
                        <label for="date" class="form-label">Preferred Pickup/Delivery Date *</label>
                        <input type="date" id="date" name="date" class="form-control" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="instructions" class="form-label">Special Instructions</label>
                        <textarea id="instructions" name="instructions" class="form-control" placeholder="Any special requests, dietary requirements, or delivery instructions?"></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Submit Order</button>
                    </div>
                </form>
            <?php else: ?>
                <div id="orderConfirmation" class="order-confirmation">
                    <h3>Thank You for Your Order!</h3>
                    <p>Your order has been received. We'll contact you shortly to confirm details and arrange payment.</p>
                    <p class="order-reference">Order Reference: <span id="orderReference"><?php echo $order_reference; ?></span></p>
                    <p>Please save this reference number for future inquiries.</p>
                    <div class="confirmation-actions">
                        <a href="index.php" class="btn btn-primary">Return to Home</a>
                        <a href="products.php" class="btn btn-outline">Browse More Products</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'footer.php'; ?>
