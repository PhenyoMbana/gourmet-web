<?php
session_start();
require_once '../config.php';
require_once '../functions.php';
require_once '../db_connect.php';

if (!is_admin()) {
    redirect('login.php');
}

$conn = connect_db();

// Fetch stats
$total_orders_query = "SELECT COUNT(*) AS TOTAL_ORDERS FROM orders";
$total_orders_stmt = oci_parse($conn, $total_orders_query);
oci_execute($total_orders_stmt);
$total_orders = oci_fetch_assoc($total_orders_stmt)['TOTAL_ORDERS'];

$pending_orders_query = "SELECT COUNT(*) AS PENDING_ORDERS FROM orders WHERE STATUS = 'Pending'";
$pending_orders_stmt = oci_parse($conn, $pending_orders_query);
oci_execute($pending_orders_stmt);
$pending_orders = oci_fetch_assoc($pending_orders_stmt)['PENDING_ORDERS'];

$confirmed_orders_query = "SELECT COUNT(*) AS CONFIRMED_ORDERS FROM orders WHERE STATUS = 'Confirmed'";
$confirmed_orders_stmt = oci_parse($conn, $confirmed_orders_query);
oci_execute($confirmed_orders_stmt);
$confirmed_orders = oci_fetch_assoc($confirmed_orders_stmt)['CONFIRMED_ORDERS'];

$delivered_orders_query = "SELECT COUNT(*) AS DELIVERED_ORDERS FROM orders WHERE STATUS = 'Delivered'";
$delivered_orders_stmt = oci_parse($conn, $delivered_orders_query);
oci_execute($delivered_orders_stmt);
$delivered_orders = oci_fetch_assoc($delivered_orders_stmt)['DELIVERED_ORDERS'];

oci_free_statement($total_orders_stmt);
oci_free_statement($pending_orders_stmt);
oci_free_statement($confirmed_orders_stmt);
oci_free_statement($delivered_orders_stmt);

// Fetch recent orders
$recent_orders_query = "SELECT * FROM orders ORDER BY order_date DESC FETCH FIRST 5 ROWS ONLY";
$recent_orders_stmt = oci_parse($conn, $recent_orders_query);
oci_execute($recent_orders_stmt);

$recent_orders = [];
while ($row = oci_fetch_assoc($recent_orders_stmt)) {
    $recent_orders[] = $row;
}

oci_free_statement($recent_orders_stmt);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | GOURMET</title>
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
            <li class="active"><a href="dashboard.php">Dashboard</a></li>
            <li><a href="admin_orders.php">Orders</a></li>
            <li><a href="admin_products.php">Products</a></li>
            <li><a href="admin_customers.php">Customers</a></li>
            <li><a href="admin_settings.php">Settings</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h2 class="admin-title">Dashboard</h2>

        <!-- Stats Summary -->
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Total Orders</h3>
                <p class="stat-number"><?php echo $total_orders; ?></p>
            </div>
            <div class="stat-card">
                <h3>Pending</h3>
                <p class="stat-number"><?php echo $pending_orders; ?></p>
            </div>
            <div class="stat-card">
                <h3>Confirmed</h3>
                <p class="stat-number"><?php echo $confirmed_orders; ?></p>
            </div>
            <div class="stat-card">
                <h3>Delivered</h3>
                <p class="stat-number"><?php echo $delivered_orders; ?></p>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="admin-section">
            <h3>Recent Orders</h3>
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
                    <?php foreach ($recent_orders as $order): ?>
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
</div>

<footer class="admin-footer">
    <div class="container">
        <p>&copy; <?php echo date('Y'); ?> GOURMET Admin. All rights reserved.</p>
    </div>
</footer>
</body>
</html>