CREATE DATABASE IF NOT EXISTS siakad_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE siakad_db;

CREATE TABLE mahasiswa (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 nim VARCHAR(20) NOT NULL UNIQUE,
 nama VARCHAR(120) NOT NULL,
 email VARCHAR(120) NOT NULL,
 jurusan VARCHAR(100) NOT NULL,
 angkatan YEAR NOT NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL
);

CREATE TABLE mata_kuliah (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 kode VARCHAR(20) NOT NULL UNIQUE,
 nama VARCHAR(120) NOT NULL,
 sks TINYINT UNSIGNED NOT NULL,
 semester TINYINT UNSIGNED NOT NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL
);

CREATE TABLE nilai (
 id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 mahasiswa_id INT UNSIGNED NOT NULL,
 mata_kuliah_id INT UNSIGNED NOT NULL,
 nilai_angka DECIMAL(5,2) NOT NULL,
 nilai_huruf CHAR(2) NOT NULL,
 created_at DATETIME NULL,
 updated_at DATETIME NULL,
 CONSTRAINT fk_nilai_mahasiswa FOREIGN KEY (mahasiswa_id) REFERENCES mahasiswa(id) ON DELETE CASCADE,
 CONSTRAINT fk_nilai_matkul FOREIGN KEY (mata_kuliah_id) REFERENCES mata_kuliah(id) ON DELETE CASCADE
);

INSERT INTO mahasiswa (nim,nama,email,jurusan,angkatan) VALUES
('5025201001','Andi Pratama','andi@example.com','Teknik Informatika',2025),
('5025201002','Budi Santoso','budi@example.com','Teknik Informatika',2025);
INSERT INTO mata_kuliah (kode,nama,sks,semester) VALUES
('PBKK','Pemrograman Berbasis Kerangka Kerja',3,5),
('PWEB','Pemrograman Web',3,3);
