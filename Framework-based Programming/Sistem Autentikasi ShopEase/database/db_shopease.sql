CREATE DATABASE IF NOT EXISTS db_shopease CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_shopease;

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('customer','admin','operator') NOT NULL DEFAULT 'customer',
    phone VARCHAR(30) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NULL,
    updated_at DATETIME NULL
);

CREATE TABLE categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(120) NOT NULL UNIQUE,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NULL
);

CREATE TABLE products (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NULL,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    description TEXT NULL,
    price DECIMAL(12,2) NOT NULL DEFAULT 0,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL,
    status ENUM('active','inactive') NOT NULL DEFAULT 'active',
    created_at DATETIME NULL,
    updated_at DATETIME NULL,
    CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

INSERT INTO categories(name,slug,description,is_active) VALUES
('Elektronik','elektronik','Produk elektronik',1),
('Fashion','fashion','Produk fashion',1),
('Rumah Tangga','rumah-tangga','Kebutuhan rumah',1),
('Aksesoris','aksesoris','Aksesoris',1),
('Kesehatan','kesehatan','Produk kesehatan',1),
('Lainnya','lainnya','Produk lain',1);

INSERT INTO products(category_id,name,slug,description,price,stock,image,status) VALUES
(1,'Wireless Headphone','wireless-headphone','Headphone wireless nyaman untuk aktivitas sehari-hari.',349000,15,NULL,'active'),
(2,'Casual Tote Bag','casual-tote-bag','Tas simpel untuk kegiatan sehari-hari.',129000,20,NULL,'active'),
(4,'Minimalist Watch','minimalist-watch','Jam tangan bergaya minimalis.',275000,12,NULL,'active'),
(3,'Desk Lamp','desk-lamp','Lampu meja untuk belajar dan bekerja.',99000,18,NULL,'active');
