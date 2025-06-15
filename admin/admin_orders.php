<?php
session_start();
require_once '../config.php';
require_once '../functions.php';
require_once '../db_connect.php';

if (!is_admin()) {
    redirect('login.php');
}

$conn = connect_db();
$query = "SELECT * FROM orders ORDER BY order_date DESC";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$orders = [];
while ($row = oci_fetch_assoc($stmt)) {
    $orders[] = $row;
}

oci_free_statement($stmt);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders | GOURMET</title>
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
            <li class="active"><a href="admin_orders.php">Orders</a></li>
            <li><a href="admin_products.php">Products</a></li>
            <li><a href="admin_customers.php">Customers</a></li>
            <li><a href="admin_settings.php">Settings</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h2 class="admin-title">Orders</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer ID</th>
                    <th>Order Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['ORDER_ID']; ?></td>
                    <td><?php echo $order['CUSTOMER_ID']; ?></td>
                    <td><?php echo $order['ORDER_DATE']; ?></td>
                    <td>R<?php echo number_format($order['TOTAL_AMOUNT'], 2); ?></td>
                    <td><?php echo ucfirst($order['STATUS']); ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<footer class="admin-footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> GOURMET Admin. All rights reserved.</p>
    </div>
</footer>
</body>
</html>