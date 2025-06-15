<?php
session_start();
require_once '../config.php';
require_once '../functions.php';

if (!is_admin()) {
    redirect('login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Settings | GOURMET</title>
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
            <li><a href="admin_products.php">Products</a></li>
            <li><a href="admin_customers.php">Customers</a></li>
            <li class="active"><a href="admin_settings.php">Settings</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h2 class="admin-title">Settings</h2>
        <p>Admin settings page content goes here.</p>
    </div>
</div>

<footer class="admin-footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> GOURMET Admin. All rights reserved.</p>
    </div>
</footer>
</body>
</html>