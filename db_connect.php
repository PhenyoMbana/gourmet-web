<?php
/**
 * Database connection function
 * 
 * @return PDO|false Returns database connection or false on failure
 */
function db_connect() {
    try {
        $serverName = "localhost\\SUFI"; // SQL Server instance name
        $connectionInfo = array(
            "Database" => "gourmet_db",
            "UID" => "sa", // SQL Server authentication username
            "PWD" => "YourStrongPassword123", // SQL Server authentication password
            "CharacterSet" => "UTF-8"
        );

        // Create connection using PDO
        $conn = new PDO(
            "sqlsrv:Server=$serverName;Database=gourmet_db",
            $connectionInfo["UID"],
            $connectionInfo["PWD"]
        );
        
        // Set error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $conn;
    } catch(PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        return false;
    }
}

/**
 * Create database tables if they don't exist
 */
function create_database_tables() {
    try {
        $conn = db_connect();
        
        if (!$conn) {
            return false;
        }

        // Users table
        $users_table = "IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='users' AND xtype='U')
            CREATE TABLE users (
                id INT IDENTITY(1,1) PRIMARY KEY,
                name NVARCHAR(100) NOT NULL,
                email NVARCHAR(100) NOT NULL UNIQUE,
                password NVARCHAR(255) NOT NULL,
                role NVARCHAR(20) NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'admin')),
                created_at DATETIME DEFAULT GETDATE(),
                updated_at DATETIME DEFAULT GETDATE()
            )";

        // Orders table
        $orders_table = "IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='orders' AND xtype='U')
            CREATE TABLE orders (
                id INT IDENTITY(1,1) PRIMARY KEY,
                user_id INT,
                order_reference NVARCHAR(20) NOT NULL UNIQUE,
                total_amount DECIMAL(10,2) NOT NULL,
                status NVARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (status IN ('pending', 'processing', 'completed', 'cancelled')),
                shipping_address NVARCHAR(MAX) NOT NULL,
                payment_status NVARCHAR(20) NOT NULL DEFAULT 'pending' CHECK (payment_status IN ('pending', 'paid', 'failed')),
                created_at DATETIME DEFAULT GETDATE(),
                updated_at DATETIME DEFAULT GETDATE(),
                CONSTRAINT FK_Orders_Users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
            )";

        // Order items table
        $order_items_table = "IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='order_items' AND xtype='U')
            CREATE TABLE order_items (
                id INT IDENTITY(1,1) PRIMARY KEY,
                order_id INT NOT NULL,
                product_id INT NOT NULL,
                quantity INT NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                created_at DATETIME DEFAULT GETDATE(),
                CONSTRAINT FK_OrderItems_Orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
            )";

        // Products table
        $products_table = "IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='products' AND xtype='U')
            CREATE TABLE products (
                id INT IDENTITY(1,1) PRIMARY KEY,
                name NVARCHAR(100) NOT NULL,
                description NVARCHAR(MAX),
                price DECIMAL(10,2) NOT NULL,
                image NVARCHAR(255),
                category NVARCHAR(50),
                featured BIT DEFAULT 0,
                stock INT DEFAULT 0,
                created_at DATETIME DEFAULT GETDATE(),
                updated_at DATETIME DEFAULT GETDATE()
            )";

        // Execute table creation queries
        $tables = [$users_table, $orders_table, $order_items_table, $products_table];
        
        foreach ($tables as $table) {
            $conn->exec($table);
        }

        return true;
    } catch(PDOException $e) {
        error_log("Error creating tables: " . $e->getMessage());
        return false;
    }
}

// Create database tables when this file is included
create_database_tables();
?>