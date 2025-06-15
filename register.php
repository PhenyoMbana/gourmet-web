<?php
require_once 'config.php';
require_once 'functions.php';

// Initialize variables
$name = '';
$email = '';
$password = '';
$confirm_password = '';
$error = '';
$success = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters long.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if email already exists
        $conn = db_connect();
        if (!$conn) {
            $error = 'Database connection error. Please try again later.';
        } else {
            $email = mysqli_real_escape_string($conn, $email);
            $query = "SELECT id FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $error = 'Email address is already registered.';
            } else {
                // Hash password and create user
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $name = mysqli_real_escape_string($conn, $name);
                
                $query = "INSERT INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', 'user')";
                
                if (mysqli_query($conn, $query)) {
                    $success = 'Registration successful! You can now login.';
                    // Clear form data
                    $name = $email = $password = $confirm_password = '';
                } else {
                    $error = 'Registration failed. Please try again later.';
                }
            }
        }
    }
}

$page_title = 'Register';
require_once 'header.php';
?>

<main class="main-content">
    <div class="container">
        <div class="auth-container">
            <h1 class="page-title">Create Account</h1>
            
            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>

            <form method="POST" action="register.php" class="auth-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required minlength="8">
                    <small class="form-text">Password must be at least 8 characters long</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                </div>

                <button type="submit" class="btn btn-primary">Create Account</button>
            </form>

            <div class="auth-links">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</main>

<?php require_once 'footer.php'; ?> 