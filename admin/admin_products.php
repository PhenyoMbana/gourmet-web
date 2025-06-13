<?php
session_start();
require_once '../config.php';
require_once '../functions.php';
require_once '../db_connect.php';

if (!is_admin()) {
    redirect('login.php');
}

$conn = connect_db();

// Handle Create Product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_url = $_POST['image_url'];
    $category = $_POST['category'];
    $is_available = isset($_POST['is_available']) ? 1 : 0;

    $query = "INSERT INTO products (product_id, name, description, price, image_url, category, is_available) 
              VALUES (products_seq.NEXTVAL, :name, :description, :price, :image_url, :category, :is_available)";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':name', $name);
    oci_bind_by_name($stmt, ':description', $description);
    oci_bind_by_name($stmt, ':price', $price);
    oci_bind_by_name($stmt, ':image_url', $image_url);
    oci_bind_by_name($stmt, ':category', $category);
    oci_bind_by_name($stmt, ':is_available', $is_available);
    oci_execute($stmt);
    oci_free_statement($stmt);
    header('Location: admin_products.php');
    exit;
}

// Handle Delete Product
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $query = "DELETE FROM products WHERE product_id = :product_id";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':product_id', $product_id);
    oci_execute($stmt);
    oci_free_statement($stmt);
    header('Location: admin_products.php');
    exit;
}

// Fetch Products
$query = "SELECT * FROM products ORDER BY name ASC";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$products = [];
while ($row = oci_fetch_assoc($stmt)) {
    $products[] = $row;
}

oci_free_statement($stmt);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Products | GOURMET</title>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<header class="header admin-header">
    <div class="container">
        <div class="header-content">
            <a href="dashboard.php" class="logo">GOURMET<span>.</span> Admin</a>
            <div class="admin-nav">
                <a href="../index.php" class="admin-nav-link">View Website</a>
                <a href="logout.php" class="admin-nav-link">Logout</a>
            </div>
        </div>
    </div>
</header>

<div class="admin-container">
    <div class="admin-sidebar">
        <ul class="admin-menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="admin_orders.php">Orders</a></li>
            <li class="active"><a href="admin_products.php">Products</a></li>
            <li><a href="admin_customers.php">Customers</a></li>
            <li><a href="admin_settings.php">Settings</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h2 class="admin-title">Manage Products</h2>

        <!-- Create Product Form -->
        <div class="admin-section">
            <h3>Add New Product</h3>
            <form method="POST" action="admin_products.php">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" id="price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="image_url">Image URL</label>
                    <input type="text" id="image_url" name="image_url" required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select id="category" name="category" required>
                        <option value="cake">Cake</option>
                        <option value="pie">Pie</option>
                        <option value="dessert">Dessert</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_available">Available</label>
                    <input type="checkbox" id="is_available" name="is_available" checked>
                </div>
                <button type="submit" class="btn btn-primary">Add Product</button>
            </form>
        </div>

        <!-- Products Table -->
        <div class="admin-section">
            <h3>Products List</h3>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['PRODUCT_ID']; ?></td>
                        <td><?php echo $product['NAME']; ?></td>
                        <td><?php echo ucfirst($product['CATEGORY']); ?></td>
                        <td>R<?php echo number_format($product['PRICE'], 2); ?></td>
                        <td>
                            <a href="admin_edit_product.php?id=<?php echo $product['PRODUCT_ID']; ?>" class="btn btn-outline">Edit</a>
                            <a href="admin_products.php?action=delete&id=<?php echo $product['PRODUCT_ID']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="admin-footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> GOURMET Admin. All rights reserved.</p>
    </div>
</footer>
</body>
</html>