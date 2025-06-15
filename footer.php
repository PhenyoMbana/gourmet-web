<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <h2>GOURMET<span>.</span></h2>
                    <p>Exquisite cakes & desserts since 2010</p>
                    <div class="social-links">
                        <a href="#" class="social-link">FB</a>
                        <a href="#" class="social-link">IG</a>
                        <a href="#" class="social-link">TW</a>
                    </div>
                </div>
                <div class="footer-links">
                    <div class="footer-column">
                        <h3>Quick Links</h3>
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="order.php">Order</a></li>
                            <?php if (is_logged_in()): ?>
                                <li><a href="account.php">My Account</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            <?php else: ?>
                                <li><a href="login.php">Login</a></li>
                                <li><a href="register.php">Register</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="footer-column">
                        <h3>Contact Us</h3>
                        <ul>
                            <li>123 Baker Street, Sweetville</li>
                            <li>Phone: (123) 456-7890</li>
                            <li>Email: info@gourmet.com</li>
                            <li>Hours: Mon-Sat: 9AM-6PM</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> GOURMET. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Simple mobile menu toggle
        document.querySelector('.mobile-menu-toggle').addEventListener('click', function() {
            document.querySelector('.main-nav').classList.toggle('active');
        });
        
        // Add any other JavaScript functionality here
    </script>
</body>
</html>
