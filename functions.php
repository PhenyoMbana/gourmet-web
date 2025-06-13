<?php
/**
 * Functions for the GOURMET website
 */

// Include database connection if not already included
if (!function_exists('db_connect')) {
    require_once 'db_connect.php';
}

/**
 * Convert USD to ZAR
 * 
 * @param float $usd Amount in USD
 * @return float Amount in ZAR
 */
function convert_usd_to_zar($usd) {
    $exchange_rate = 18.00; // Example exchange rate, update as needed
    return $usd * $exchange_rate;
}

/**
 * Format price with currency symbol
 * 
 * @param float $price Price to format
 * @param string $currency Currency symbol
 * @return string Formatted price
 */
function format_price($price, $currency = 'R') {
    if ($currency === 'R') {
        $price = convert_usd_to_zar($price);
    }
    return $currency . number_format($price, 2);
}

/**
 * Get all products
 * 
 * @return array Array of products
 */
function get_all_products() {
    global $products;
    return $products;
}

/**
 * Get product by ID
 * 
 * @param int $id Product ID
 * @return array|null Product data or null if not found
 */
function get_product($id) {
    global $products;
    
    if (isset($products[$id])) {
        return $products[$id];
    }
    
    return null;
}

/**
 * Get products by category
 * 
 * @param string $category Category name
 * @return array Array of products in the category
 */
function get_products_by_category($category) {
    global $products;
    
    if ($category === 'all') {
        return $products;
    }
    
    $filtered = [];
    
    foreach ($products as $id => $product) {
        if ($product['category'] === $category) {
            $filtered[$id] = $product;
        }
    }
    
    return $filtered;
}

/**
 * Get featured products
 * 
 * @param int $limit Maximum number of products to return
 * @return array Array of featured products
 */
function get_featured_products($limit = 3) {
    global $products;
    
    $featured = [];
    
    foreach ($products as $id => $product) {
        if (isset($product['featured']) && $product['featured']) {
            $featured[$id] = $product;
            
            if (count($featured) >= $limit) {
                break;
            }
        }
    }
    
    return $featured;
}

/**
 * Get related products
 * 
 * @param int $product_id Current product ID
 * @param int $limit Maximum number of products to return
 * @return array Array of related products
 */
function get_related_products($product_id, $limit = 3) {
    global $products;
    
    $current = get_product($product_id);
    
    if (!$current) {
        return [];
    }
    
    $category = $current['category'];
    $related = [];
    
    foreach ($products as $id => $product) {
        if ($id != $product_id && $product['category'] === $category) {
            $related[$id] = $product;
            
            if (count($related) >= $limit) {
                break;
            }
        }
    }
    
    // If we don't have enough related products in the same category, add some others
    if (count($related) < $limit) {
        foreach ($products as $id => $product) {
            if ($id != $product_id && !isset($related[$id])) {
                $related[$id] = $product;
                
                if (count($related) >= $limit) {
                    break;
                }
            }
        }
    }
    
    return $related;
}

/**
 * Generate a random order reference
 * 
 * @return string Order reference
 */
function generate_order_reference() {
    return 'GRM-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
}

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in, false otherwise
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Check if user is admin
 * 
 * @return bool True if admin, false otherwise
 */
function is_admin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

/**
 * Redirect to a URL
 * 
 * @param string $url URL to redirect to
 */
function redirect($url) {
    header("Location: $url");
    exit;
}

/**
 * Sanitize input
 * 
 * @param string $input Input to sanitize
 * @return string Sanitized input
 */
function sanitize($input) {
    return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
}

/**
 * Get current page name
 * 
 * @return string Current page name
 */
function get_current_page() {
    return basename($_SERVER['PHP_SELF']);
}

/**
 * Check if current page is the given page
 * 
 * @param string $page Page to check
 * @return bool True if current page, false otherwise
 */
function is_current_page($page) {
    return get_current_page() === $page;
}

/**
 * Add item to cart
 * 
 * @param int $product_id Product ID
 * @param int $quantity Quantity
 */
function add_to_cart($product_id, $quantity = 1) {
    $product = get_product($product_id);
    
    if (!$product) {
        return false;
    }
    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = [
            'id' => $product_id,
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $quantity,
            'image' => $product['image']
        ];
    }
    
    return true;
}

/**
 * Remove item from cart
 * 
 * @param int $product_id Product ID
 */
function remove_from_cart($product_id) {
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

/**
 * Update cart item quantity
 * 
 * @param int $product_id Product ID
 * @param int $quantity New quantity
 */
function update_cart_quantity($product_id, $quantity) {
    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity <= 0) {
            remove_from_cart($product_id);
        } else {
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
        }
    }
}

/**
 * Get cart items
 * 
 * @return array Cart items
 */
function get_cart_items() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

/**
 * Get cart total
 * 
 * @return float Cart total
 */
function get_cart_total() {
    $total = 0;
    
    foreach (get_cart_items() as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    
    return $total;
}

/**
 * Get cart item count
 * 
 * @return int Cart item count
 */
function get_cart_count() {
    $count = 0;
    
    foreach (get_cart_items() as $item) {
        $count += $item['quantity'];
    }
    
    return $count;
}

/**
 * Clear cart
 */
function clear_cart() {
    unset($_SESSION['cart']);
}

/**
 * Process order
 * 
 * @param array $order_data Order data
 * @return string|bool Order reference on success, false on failure
 */
function process_order($order_data) {
    $cart_items = get_cart_items();
    
    if (empty($cart_items)) {
        return false;
    }
    
    $order_ref = generate_order_reference();
    $order_data['order_ref'] = $order_ref;
    $order_data['order_date'] = date('Y-m-d H:i:s');
    $order_data['total_amount'] = get_cart_total();
    $order_data['status'] = 'pending';
    
    // In a real application, you would save the order to the database
    // For now, we'll just return the order reference
    
    // Clear the cart after successful order
    clear_cart();
    
    return $order_ref;
}
