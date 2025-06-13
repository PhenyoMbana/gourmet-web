<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
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
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        if ($conn->connect_error) {
            die('Database connection failed: ' . $conn->connect_error);
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
        'image' => 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        'category' => 'Cakes',
        'featured' => true
    ],
    2 => [
        'id' => 2,
        'name' => 'Strawberry Shortcake',
        'price' => 38.99,
        'description' => 'Light vanilla sponge cake layered with fresh strawberries and whipped cream.',
        'long_description' => 'Light vanilla sponge cake layered with fresh strawberries and whipped cream. Made with locally sourced strawberries when in season, this cake is the perfect balance of sweet and tangy flavors.',
        'image' => 'https://images.unsplash.com/photo-1464349095431-e9a21285b5f3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        'category' => 'Cakes',
        'featured' => true
    ],
    3 => [
        'id' => 3,
        'name' => 'Caramel Pecan Tart',
        'price' => 28.99,
        'description' => 'Buttery tart shell filled with rich caramel and topped with candied pecans.',
        'long_description' => 'Buttery tart shell filled with rich caramel and topped with candied pecans. The perfect combination of crunchy and chewy textures with a delightful caramel flavor.',
        'image' => 'https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        'category' => 'Pies & Tarts',
        'featured' => true
    ],
    4 => [
        'id' => 4,
        'name' => 'Red Velvet Cake',
        'price' => 40.99,
        'description' => 'Classic red velvet cake with cream cheese frosting.',
        'long_description' => 'Classic red velvet cake with cream cheese frosting. Moist, rich, and slightly tangy. Our red velvet cake has a hint of cocoa and is topped with our signature cream cheese frosting.',
        'image' => 'https://images.unsplash.com/photo-1586788680434-30d324626f4c?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        'category' => 'Cakes',
        'featured' => false
    ],
    5 => [
        'id' => 5,
        'name' => 'Lemon Meringue Pie',
        'price' => 32.99,
        'description' => 'Tangy lemon filling topped with fluffy meringue.',
        'long_description' => 'Tangy lemon filling topped with fluffy meringue. The perfect balance of sweet and tart flavors, with a light and airy meringue topping.',
        'image' => 'https://images.unsplash.com/photo-1551404973-761c83dab2d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
        'category' => 'Pies & Tarts',
        'featured' => false
    ],
    6 => [
        'id' => 6,
        'name' => 'French Macarons',
        'price' => 24.99,
        'description' => 'Delicate almond cookies with various fillings (12 pcs).',
        'long_description' => 'Delicate almond cookies with various fillings (12 pcs). Our macarons come in a variety of flavors including vanilla, chocolate, raspberry, pistachio, lemon, and caramel.',
        'image' => 'https://images.unsplash.com/photo-1569864358642-9d1684040f43?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80',
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
