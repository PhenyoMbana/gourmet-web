-- Create database if it doesn't exist
IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'gourmet_db')
BEGIN
    CREATE DATABASE gourmet_db;
END
GO

USE gourmet_db;
GO

-- Create users table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='users' AND xtype='U')
BEGIN
    CREATE TABLE users (
        id INT IDENTITY(1,1) PRIMARY KEY,
        name NVARCHAR(100) NOT NULL,
        email NVARCHAR(100) NOT NULL UNIQUE,
        password NVARCHAR(255) NOT NULL,
        role NVARCHAR(20) NOT NULL DEFAULT 'user' CHECK (role IN ('user', 'admin')),
        created_at DATETIME DEFAULT GETDATE(),
        updated_at DATETIME DEFAULT GETDATE()
    );
END
GO

-- Create orders table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='orders' AND xtype='U')
BEGIN
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
    );
END
GO

-- Create order items table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='order_items' AND xtype='U')
BEGIN
    CREATE TABLE order_items (
        id INT IDENTITY(1,1) PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        created_at DATETIME DEFAULT GETDATE(),
        CONSTRAINT FK_OrderItems_Orders FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    );
END
GO

-- Create products table
IF NOT EXISTS (SELECT * FROM sysobjects WHERE name='products' AND xtype='U')
BEGIN
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
    );
END
GO

-- Insert default admin user (password: admin123)
IF NOT EXISTS (SELECT * FROM users WHERE email = 'admin@gourmet.com')
BEGIN
    INSERT INTO users (name, email, password, role)
    VALUES ('Admin User', 'admin@gourmet.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');
END
GO

-- Insert sample products
IF NOT EXISTS (SELECT * FROM products WHERE name = 'Chocolate Cake')
BEGIN
    INSERT INTO products (name, description, price, category, featured, stock)
    VALUES 
    ('Chocolate Cake', 'Rich and moist chocolate cake with chocolate ganache', 299.99, 'Cakes', 1, 10),
    ('Red Velvet Cake', 'Classic red velvet cake with cream cheese frosting', 349.99, 'Cakes', 1, 8),
    ('Carrot Cake', 'Spiced carrot cake with walnuts and cream cheese frosting', 279.99, 'Cakes', 0, 5),
    ('Cheesecake', 'New York style cheesecake with berry compote', 329.99, 'Cakes', 1, 7),
    ('Tiramisu', 'Classic Italian dessert with coffee-soaked ladyfingers', 249.99, 'Desserts', 0, 6);
END
GO 