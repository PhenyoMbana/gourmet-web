<?php
session_start();
require_once '../config.php';
require_once '../functions.php';
require_once '../db_connect.php';

if (!is_admin()) {
    redirect('login.php');
}

$conn = connect_db();
$query = "SELECT * FROM customers ORDER BY name ASC";
$stmt = oci_parse($conn, $query);
oci_execute($stmt);

$customers = [];
while ($row = oci_fetch_assoc($stmt)) {
    $customers[] = $row;
}

oci_free_statement($stmt);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Customers | GOURMET</title>
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
            <li class="active"><a href="admin_customers.php">Customers</a></li>
            <li><a href="admin_settings.php">Settings</a></li>
        </ul>
    </div>

    <div class="admin-content">
        <h2 class="admin-title">Customers</h2>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($customers as $customer): ?>
                <tr>
                    <td><?php echo $customer['CUSTOMER_ID']; ?></td>
                    <td><?php echo $customer['NAME']; ?></td>
                    <td><?php echo $customer['EMAIL']; ?></td>
                    <td><?php echo $customer['PHONE_NUMBER']; ?></td>
                    <td><?php echo $customer['ADDRESS']; ?></td>
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