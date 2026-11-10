CREATE DATABASE IF NOT EXISTS `db_tp7`;
USE `db_tp7`;

CREATE TABLE IF NOT EXISTS `customers` (
    `id_customer` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(100) NOT NULL,
    `no_telp` VARCHAR(25) NOT NULL,
    `nik` VARCHAR(20) NOT NULL,
    `ttg` VARCHAR(100) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cameras` (
    `id_camera` INT AUTO_INCREMENT PRIMARY KEY,
    `merek` VARCHAR(50) NOT NULL,
    `jenis` VARCHAR(50) NOT NULL,
    `tipe` VARCHAR(100) NOT NULL,
    `harga` INT NOT NULL,
    `status` ENUM('Tersedia', 'Disewa', 'Maintenance') DEFAULT 'Tersedia',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `rentals` (
    `id_rental` INT AUTO_INCREMENT PRIMARY KEY,
    `id_customer` INT NOT NULL,
    `id_camera` INT NOT NULL,
    `tgl_sewa` DATE NOT NULL,
    `tgl_kembali` DATE NOT NULL,
    `total` INT NOT NULL,
    `status_bayar` ENUM('Lunas', 'Belum Lunas', 'DP') DEFAULT 'Belum Lunas',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_rental_customer` 
        FOREIGN KEY (`id_customer`) REFERENCES `customers` (`id_customer`) 
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_rental_camera` 
        FOREIGN KEY (`id_camera`) REFERENCES `cameras` (`id_camera`) 
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed data awal untuk pengujian CRUD
INSERT INTO `customers` (`id_customer`, `nama`, `no_telp`, `nik`, `ttg`) VALUES
(1, 'Ahmad Fauzan', '081234567890', '3273012304950001', 'Bandung, 12 April 1998'),
(2, 'Siti Nurhaliza', '085712345678', '3273015508000002', 'Jakarta, 15 Agustus 2000');

INSERT INTO `cameras` (`id_camera`, `merek`, `jenis`, `tipe`, `harga`, `status`) VALUES
(1, 'Sony', 'Mirrorless', 'Sony Alpha A7 IV', 250000, 'Disewa'),
(2, 'Canon', 'DSLR', 'Canon EOS 5D Mark IV', 220000, 'Tersedia'),
(3, 'Fujifilm', 'Mirrorless', 'Fujifilm X-T5', 200000, 'Tersedia');

INSERT INTO `rentals` (`id_rental`, `id_customer`, `id_camera`, `tgl_sewa`, `tgl_kembali`, `total`, `status_bayar`) VALUES
(1, 1, 1, '2026-11-10', '2026-11-12', 500000, 'Lunas');
