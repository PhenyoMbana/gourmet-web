<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' | ' . SITE_NAME : SITE_NAME; ?> | Exquisite Cakes & Desserts</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="main.js" defer></script>
</head>
<body>
    <?php
    require_once 'notifications.php';
    echo display_notifications();
    ?>
    
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="index.php" class="logo">GOURMET<span>.</span></a>
                <nav class="main-nav">
                    <ul class="nav-list">
                        <li><a href="index.php" class="nav-link <?php echo is_current_page('index.php') ? 'active' : ''; ?>">Home</a></li>
                        <li><a href="about.php" class="nav-link <?php echo is_current_page('about.php') ? 'active' : ''; ?>">About Us</a></li>
                        <li><a href="products.php" class="nav-link <?php echo is_current_page('products.php') || is_current_page('product_detail.php') ? 'active' : ''; ?>">Products</a></li>
                        <li><a href="order.php" class="nav-link <?php echo is_current_page('order.php') ? 'active' : ''; ?>">Order</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <div class="search-bar">
                        <input type="text" class="search-input" placeholder="Search products...">
                        <span class="search-icon">🔍</span>
                    </div>
                    <a href="cart.php" class="cart-link">
                        <span class="cart-icon">🛒</span>
                        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="cart-count"><?php echo get_cart_count(); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if (is_logged_in()): ?>
                        <a href="account.php" class="account-link">My Account</a>
                        <a href="logout.php" class="logout-link">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="login-link">Login</a>
                    <?php endif; ?>
                    <?php if (is_admin()): ?>
                        <a href="admin/dashboard.php" class="admin-link">Admin</a>
                    <?php endif; ?>
                    <button class="mobile-menu-toggle">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>
            </div>
        </div>
    </header>
