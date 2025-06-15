<?php
session_start();
require_once 'functions.php';
require_once 'notifications.php';

header('Content-Type: application/json');

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['product_id']) || !isset($data['quantity'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Missing required parameters'
    ]);
    exit;
}

$product_id = $data['product_id'];
$quantity = (int)$data['quantity'];

if ($quantity < 1) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid quantity'
    ]);
    exit;
}

try {
    if (add_to_cart($product_id, $quantity)) {
        echo json_encode([
            'success' => true,
            'message' => 'Product added to cart',
            'cart_count' => get_cart_count()
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to add product to cart'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error adding product to cart: ' . $e->getMessage()
    ]);
}
?> 