<?php
// Database configuration
define('DB_HOST', 'localhost\\SQLEXPRESS'); // SQL Server instance name
define('DB_USER', 'sa'); // SQL Server username
define('DB_PASS', 'YourStrongPassword123'); // SQL Server password
define('DB_NAME', 'gourmet_db');

// Website configuration
define('SITE_NAME', 'GOURMET');
define('SITE_URL', 'http://localhost/gourmet');
define('ADMIN_EMAIL', 'admin@gourmet.com');

// Session configuration
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Error reporting (set to 0 in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Time zone
date_default_timezone_set('Africa/Johannesburg');

// Database connection
function db_connect() {
    static $conn;
    
    if ($conn === NULL) {
        try {
            $conn = new PDO(
                "sqlsrv:Server=" . DB_HOST . ";Database=" . DB_NAME,
                DB_USER,
                DB_PASS
            );
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }
    
    return $conn;
}

// For now, we'll use a simple array for products until database is set up
$products = [
    1 => [
        'id' => 1,
        'name' => 'Chocolate Truffle Cake',
        'price' => 42.99,
        'description' => 'Rich chocolate cake layered with smooth truffle ganache and covered in chocolate shavings.',
        'long_description' => 'Our signature Chocolate Truffle Cake is a chocolate lover\'s dream come true. This decadent dessert features three layers of moist chocolate cake, each separated by a layer of smooth chocolate truffle ganache. The cake is covered in a rich chocolate glaze and decorated with chocolate shavings and a dusting of cocoa powder.',
        'image' => 'images/products/chocolate-truffle-cake.jpg',
        'category' => 'Cakes',
        'featured' => true
    ],
    2 => [
        'id' => 2,
        'name' => 'Strawberry Shortcake',
        'price' => 38.99,
        'description' => 'Light vanilla sponge cake layered with fresh strawberries and whipped cream.',
        'long_description' => 'Light vanilla sponge cake layered with fresh strawberries and whipped cream. Made with locally sourced strawberries when in season, this cake is the perfect balance of sweet and tangy flavors.',
        'image' => 'images/products/strawberry-shortcake.jpg',
        'category' => 'Cakes',
        'featured' => true
    ],
    3 => [
        'id' => 3,
        'name' => 'Caramel Pecan Tart',
        'price' => 28.99,
        'description' => 'Buttery tart shell filled with rich caramel and topped with candied pecans.',
        'long_description' => 'Buttery tart shell filled with rich caramel and topped with candied pecans. The perfect combination of crunchy and chewy textures with a delightful caramel flavor.',
        'image' => 'images/products/caramel-pecan-tart.jpg',
        'category' => 'Pies & Tarts',
        'featured' => true
    ],
    4 => [
        'id' => 4,
        'name' => 'Red Velvet Cake',
        'price' => 40.99,
        'description' => 'Classic red velvet cake with cream cheese frosting.',
        'long_description' => 'Classic red velvet cake with cream cheese frosting. Moist, rich, and slightly tangy. Our red velvet cake has a hint of cocoa and is topped with our signature cream cheese frosting.',
        'image' => 'images/products/red-velvet-cake.jpg',
        'category' => 'Cakes',
        'featured' => false
    ],
    5 => [
        'id' => 5,
        'name' => 'Lemon Meringue Pie',
        'price' => 32.99,
        'description' => 'Tangy lemon filling topped with fluffy meringue.',
        'long_description' => 'Tangy lemon filling topped with fluffy meringue. The perfect balance of sweet and tart flavors, with a light and airy meringue topping.',
        'image' => 'images/products/lemon-meringue-pie.jpg',
        'category' => 'Pies & Tarts',
        'featured' => false
    ],
    6 => [
        'id' => 6,
        'name' => 'French Macarons',
        'price' => 24.99,
        'description' => 'Delicate almond cookies with various fillings (12 pcs).',
        'long_description' => 'Delicate almond cookies with various fillings (12 pcs). Our macarons come in a variety of flavors including vanilla, chocolate, raspberry, pistachio, lemon, and caramel.',
        'image' => 'images/products/french-macarons.jpg',
        'category' => 'Pastries',
        'featured' => false
    ],
    7 => [
        'id' => 7,
        'name' => 'Tiramisu',
        'price' => 36.99,
        'description' => 'Classic Italian dessert with layers of coffee-soaked ladyfingers and mascarpone cream.',
        'long_description' => 'Our Tiramisu is made with authentic Italian ingredients, featuring layers of espresso-soaked ladyfingers, rich mascarpone cream, and a dusting of cocoa powder. Each bite is a perfect balance of coffee, cream, and sweetness.',
        'image' => 'images/products/tiramisu.jpg',
        'category' => 'Cakes',
        'featured' => false
    ],
    8 => [
        'id' => 8,
        'name' => 'Apple Pie',
        'price' => 29.99,
        'description' => 'Traditional apple pie with flaky crust and spiced apple filling.',
        'long_description' => 'Our Apple Pie features a buttery, flaky crust filled with tender, spiced apples. The filling is made with a blend of sweet and tart apples, cinnamon, nutmeg, and a touch of vanilla.',
        'image' => 'images/products/apple-pie.jpg',
        'category' => 'Pies & Tarts',
        'featured' => false
    ],
    9 => [
        'id' => 9,
        'name' => 'Croissants',
        'price' => 19.99,
        'description' => 'Buttery, flaky French pastries (6 pcs).',
        'long_description' => 'Our Croissants are made using traditional French techniques, with layers of buttery, flaky pastry. Each croissant is baked to golden perfection, with a crisp exterior and tender, buttery interior.',
        'image' => 'images/products/croissants.jpg',
        'category' => 'Pastries',
        'featured' => false
    ]
];

// Categories
$categories = [
    'all' => 'All Products',
    'Cakes' => 'Cakes',
    'Pies & Tarts' => 'Pies & Tarts',
    'Pastries' => 'Pastries'
];
