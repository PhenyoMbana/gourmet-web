<?php
require_once 'functions.php';
require_once 'db_connect.php';

header('Content-Type: application/json');

// Get search query
$query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (empty($query)) {
    echo json_encode(['success' => false, 'message' => 'Search query is required']);
    exit;
}

try {
    $conn = connect_db();
    
    // Prepare the search query
    $sql = "SELECT * FROM products 
            WHERE LOWER(name) LIKE LOWER(:query) 
            OR LOWER(description) LIKE LOWER(:query)
            OR LOWER(category) LIKE LOWER(:query)
            ORDER BY name ASC";
            
    $stmt = oci_parse($conn, $sql);
    $search_term = '%' . $query . '%';
    oci_bind_by_name($stmt, ':query', $search_term);
    
    oci_execute($stmt);
    
    $results = [];
    while ($row = oci_fetch_assoc($stmt)) {
        $results[] = [
            'id' => $row['ID'],
            'name' => $row['NAME'],
            'description' => $row['DESCRIPTION'],
            'price' => $row['PRICE'],
            'image' => $row['IMAGE'],
            'category' => $row['CATEGORY']
        ];
    }
    
    echo json_encode([
        'success' => true,
        'results' => $results
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error searching products: ' . $e->getMessage()
    ]);
}
?> 