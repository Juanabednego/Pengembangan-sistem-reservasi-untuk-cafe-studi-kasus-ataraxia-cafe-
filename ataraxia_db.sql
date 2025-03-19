CREATE DATABASE ataraxia_db;
USE ataraxia_db;
DROP DATABASE ataraxia_db;

-- Tabel Role
CREATE TABLE ROLE (
    id_role INT PRIMARY KEY AUTO_INCREMENT,
    nama_role VARCHAR(50)
);

-- Tabel User
CREATE TABLE USER (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nama_user VARCHAR(100),
    id_role INT,
    FOREIGN KEY (id_role) REFERENCES ROLE(id_role)
);

-- Tabel Autentikasi
CREATE TABLE autentikasi (
    id_autentikasi INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    username VARCHAR(50),
    PASSWORD VARCHAR(255),
    FOREIGN KEY (id_user) REFERENCES USER(id_user)
);

-- Tabel Pelanggan
CREATE TABLE pelanggan (
    id_pelanggan INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    nama_pelanggan VARCHAR(100),
    email VARCHAR(100),
    alamat VARCHAR(255),
    no_telepon VARCHAR(15),
    usia INT,
    FOREIGN KEY (id_user) REFERENCES USER(id_user)
);

-- Tabel Menu
CREATE TABLE menu (
    id_menu INT PRIMARY KEY,
    nama_menu VARCHAR(100),
    deskripsi_menu TEXT,
    harga_menu DECIMAL(10, 2),
    kategori VARCHAR(50),
    id_user INT,
    FOREIGN KEY (id_user) REFERENCES USER(id_user)
);

-- Tabel Kursi
CREATE TABLE kursi (
    id_kursi INT PRIMARY KEY AUTO_INCREMENT,
    nomor_kursi VARCHAR(10),
    lokasi VARCHAR(50),
    STATUS VARCHAR(50),
    harga DECIMAL(10, 2)
);

-- Tabel Event
CREATE TABLE EVENT (
    id_event INT PRIMARY KEY AUTO_INCREMENT,
    nama_event VARCHAR(100),
    deskripsi TEXT,
    jadwal DATETIME,
    STATUS VARCHAR(50),
    harga DECIMAL(10, 2)
);

-- Tabel Reservasi
CREATE TABLE reservasi (
    id_reservasi INT PRIMARY KEY,
    nama_pelanggan VARCHAR(100),
    tanggal_reservasi DATE,
    no_telepon VARCHAR(15),
    STATUS VARCHAR(50),
    harga DECIMAL(10, 2),
    id_event INT,  
    id_kursi INT, 
    FOREIGN KEY (id_event) REFERENCES EVENT(id_event),
    FOREIGN KEY (id_kursi) REFERENCES kursi(id_kursi)
);

-- Tabel Pembayaran
CREATE TABLE pembayaran (
    id_pembayaran INT PRIMARY KEY AUTO_INCREMENT,
    id_user INT,
    metode_pembayaran VARCHAR(50),
    status_pembayaran VARCHAR(50),
    tanggal_pembayaran DATE,
    harga DECIMAL(10, 2),
    FOREIGN KEY (id_user) REFERENCES USER(id_user)
);

-- Tabel Review
CREATE TABLE review (
    id_review INT PRIMARY KEY,
    tanggal_review DATE,
    rating INT,
    komentar TEXT,
    id_pelanggan INT,
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
);
