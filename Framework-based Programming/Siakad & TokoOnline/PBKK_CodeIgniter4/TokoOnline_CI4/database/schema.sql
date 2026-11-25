CREATE DATABASE IF NOT EXISTS toko_online_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE toko_online_db;

CREATE TABLE kategori (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nama VARCHAR(100) NOT NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL
);

CREATE TABLE produk (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 kategori_id INT UNSIGNED NULL,
 nama VARCHAR(150) NOT NULL,
 deskripsi TEXT NULL,
 harga DECIMAL(12,2) NOT NULL,
 stok INT UNSIGNED NOT NULL DEFAULT 0,
 gambar VARCHAR(500) NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL,
 CONSTRAINT fk_produk_kategori FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE SET NULL
);

CREATE TABLE pesanan (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nama_pelanggan VARCHAR(120) NOT NULL,
 email VARCHAR(120) NOT NULL,
 alamat TEXT NOT NULL,
 total DECIMAL(12,2) NOT NULL,
 status VARCHAR(30) NOT NULL DEFAULT 'Menunggu',
 created_at DATETIME NULL,
 updated_at DATETIME NULL
);

CREATE TABLE detail_pesanan (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 pesanan_id INT UNSIGNED NOT NULL,
 produk_id INT UNSIGNED NOT NULL,
 jumlah INT UNSIGNED NOT NULL,
 harga DECIMAL(12,2) NOT NULL,
 CONSTRAINT fk_detail_pesanan FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE,
 CONSTRAINT fk_detail_produk FOREIGN KEY (produk_id) REFERENCES produk(id)
);

INSERT INTO kategori (nama) VALUES ('Elektronik'), ('Aksesori'), ('Perlengkapan');
INSERT INTO produk (kategori_id,nama,deskripsi,harga,stok,gambar) VALUES
(1,'Headphone Wireless','Headphone nirkabel untuk aktivitas sehari-hari.',299000,15,''),
(2,'Mouse Wireless','Mouse wireless ergonomis.',125000,25,''),
(3,'Botol Minum','Botol minum stainless steel.',89000,20,'');
