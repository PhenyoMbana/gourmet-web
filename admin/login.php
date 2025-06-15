<?php
// Start session
session_start();

// Include configuration and functions
require_once '../config.php';
require_once '../functions.php';

// Check if already logged in
if (is_admin()) {
    redirect('dashboard.php');
}

// Initialize variables
$error_message = '';
$login_successful = false;

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Simple authentication (in a real app, you would check against a database)
    if ($username === 'admin' && $password === 'password') {
        // Set session variables
        $_SESSION['user_id'] = 1;
        $_SESSION['username'] = $username;
        $_SESSION['is_admin'] = true;
        
        // Redirect to dashboard
        redirect('dashboard.php');
    } else {
        $error_message = 'Invalid username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | GOURMET</title>
    <link rel="stylesheet" href="../styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Simple Header -->
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="../index.php" class="logo">GOURMET<span>.</span></a>
                <a href="../index.php" class="back-link">Back to Website</a>
            </div>
        </div>
    </header>

    <!-- Login Form -->
    <div class="admin-login-container">
        <div class="admin-login-header">
            <h2>Admin Login</h2>
            <p>Enter your credentials to access the dashboard</p>
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>

        <form id="loginForm" class="admin-login-form" method="post" action="login.php">
            <div class="form-group">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-full">Login</button>
            </div>
        </form>
        
        <div class="login-help">
            <p>Default credentials: admin / password</p>
        </div>
    </div>

    <!-- Simple Footer -->
    <footer class="admin-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> GOURMET Admin. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
