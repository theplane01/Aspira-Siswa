-- ============================================
-- APLIKASI PENGADUAN SARANA SEKOLAH
-- Generated from Laravel Migrations
-- ============================================

-- Drop database jika ada (opsional, hati-hati)
-- DROP DATABASE IF EXISTS pengaduan_sekolah;
CREATE DATABASE pengaduan_sekolah;
USE pengaduan_sekolah;

-- ============================================
-- TABLES FROM LARAVEL DEFAULT MIGRATIONS
-- ============================================

-- 1. Tabel users (default Laravel)
CREATE TABLE `users` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `email_verified_at` TIMESTAMP NULL,
    `password` VARCHAR(255) NOT NULL,
    `remember_token` VARCHAR(100) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. Tabel password_reset_tokens
CREATE TABLE `password_reset_tokens` (
    `email` VARCHAR(255) NOT NULL,
    `token` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Tabel sessions
CREATE TABLE `sessions` (
    `id` VARCHAR(255) NOT NULL,
    `user_id` BIGINT UNSIGNED NULL,
    `ip_address` VARCHAR(45) NULL,
    `user_agent` TEXT NULL,
    `payload` LONGTEXT NOT NULL,
    `last_activity` INT NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `sessions_user_id_index` (`user_id`),
    INDEX `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Tabel cache
CREATE TABLE `cache` (
    `key` VARCHAR(255) NOT NULL,
    `value` MEDIUMTEXT NOT NULL,
    `expiration` BIGINT NOT NULL,
    PRIMARY KEY (`key`),
    INDEX `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Tabel cache_locks
CREATE TABLE `cache_locks` (
    `key` VARCHAR(255) NOT NULL,
    `owner` VARCHAR(255) NOT NULL,
    `expiration` BIGINT NOT NULL,
    PRIMARY KEY (`key`),
    INDEX `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Tabel jobs
CREATE TABLE `jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `queue` VARCHAR(255) NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `attempts` TINYINT UNSIGNED NOT NULL,
    `reserved_at` INT UNSIGNED NULL,
    `available_at` INT UNSIGNED NOT NULL,
    `created_at` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tabel job_batches
CREATE TABLE `job_batches` (
    `id` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `total_jobs` INT NOT NULL,
    `pending_jobs` INT NOT NULL,
    `failed_jobs` INT NOT NULL,
    `failed_job_ids` LONGTEXT NOT NULL,
    `options` MEDIUMTEXT NULL,
    `cancelled_at` INT NULL,
    `created_at` INT NOT NULL,
    `finished_at` INT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Tabel failed_jobs
CREATE TABLE `failed_jobs` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `uuid` VARCHAR(255) NOT NULL UNIQUE,
    `connection` TEXT NOT NULL,
    `queue` TEXT NOT NULL,
    `payload` LONGTEXT NOT NULL,
    `exception` LONGTEXT NOT NULL,
    `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- TABLES FOR ASPIRATION APPLICATION
-- ============================================

-- 9. Tabel admins
CREATE TABLE `admins` (
    `id_admin` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(25) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `nama_admin` VARCHAR(35) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 10. Tabel kategoris
CREATE TABLE `kategoris` (
    `id_kategori` INT NOT NULL,
    `ket_kategori` VARCHAR(30) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 11. Tabel siswas
CREATE TABLE `siswas` (
    `nis` INT NOT NULL,
    `nama` VARCHAR(35) NOT NULL,
    `kelas` VARCHAR(10) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`nis`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 12. Tabel aspirasis
CREATE TABLE `aspirasis` (
    `id_pelaporan` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nis` INT NOT NULL,
    `id_kategori` INT NOT NULL,
    `lokasi` VARCHAR(50) NOT NULL,
    `ket` VARCHAR(50) NOT NULL,
    `status` ENUM('Menunggu', 'Proses', 'Selesai') NOT NULL DEFAULT 'Menunggu',
    `feedback` VARCHAR(50) NULL,
    `foto` VARCHAR(255) NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id_pelaporan`),
    FOREIGN KEY (`nis`) REFERENCES `siswas`(`nis`) ON DELETE CASCADE,
    FOREIGN KEY (`id_kategori`) REFERENCES `kategoris`(`id_kategori`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 13. Tabel notifications
CREATE TABLE `notifications` (
    `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` VARCHAR(255) NOT NULL,
    `type` VARCHAR(255) NOT NULL,
    `title` VARCHAR(255) NOT NULL,
    `message` TEXT NOT NULL,
    `data` JSON NULL,
    `read_at` TIMESTAMP NULL,
    `created_at` TIMESTAMP NULL,
    `updated_at` TIMESTAMP NULL,
    PRIMARY KEY (`id`),
    INDEX `notifications_user_id_read_at_index` (`user_id`, `read_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================
-- SEEDING DATA (DATA AWAL)
-- ============================================

-- Insert data admin default (password: admin123)
-- Gunakan bcrypt hash: 'admin123' -> $2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi
INSERT INTO `admins` (`username`, `password`, `nama_admin`, `created_at`, `updated_at`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator Sekolah', NOW(), NOW());

-- Insert data kategori
INSERT INTO `kategoris` (`id_kategori`, `ket_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Sarana Kelas', NOW(), NOW()),
(2, 'Toilet', NOW(), NOW()),
(3, 'Laboratorium', NOW(), NOW()),
(4, 'Perpustakaan', NOW(), NOW()),
(5, 'Kantin', NOW(), NOW()),
(6, 'Olahraga', NOW(), NOW()),
(7, 'Lainnya', NOW(), NOW());

-- Insert contoh data siswa (password: siswa123)
-- Hash bcrypt untuk 'siswa123': $2y$10$eJjY4qKq9qKq9qKq9qKq9uOjOjOjOjOjOjOjOjOjOjOjOjOjOjO
INSERT INTO `siswas` (`nis`, `nama`, `kelas`, `password`, `created_at`, `updated_at`) VALUES
(1234567890, 'Ahmad Fauzi', 'XII RPL 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(1234567891, 'Siti Nurhaliza', 'XII RPL 2', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
(1234567892, 'Budi Santoso', 'XII RPL 1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- Insert contoh data aspirasi
INSERT INTO `aspirasis` (`nis`, `id_kategori`, `lokasi`, `ket`, `status`, `feedback`, `foto`, `created_at`, `updated_at`) VALUES
(1234567890, 1, 'Ruang Kelas XII RPL 1', 'Kursi belajar rusak 5 buah', 'Selesai', 'Kursi sudah diganti baru', NULL, NOW(), NOW()),
(1234567891, 2, 'Toilet Lantai 2', 'Air tidak mengalir', 'Proses', 'Sedang dalam perbaikan', NULL, NOW(), NOW()),
(1234567892, 3, 'Lab Komputer', 'Komputer no 10 tidak menyala', 'Menunggu', NULL, NULL, NOW(), NOW()),
(1234567890, 5, 'Kantin Sekolah', 'Harga makanan terlalu mahal', 'Menunggu', NULL, NULL, NOW(), NOW());

-- Insert contoh notifikasi
INSERT INTO `notifications` (`user_id`, `type`, `title`, `message`, `read_at`, `created_at`, `updated_at`) VALUES
('1234567890', 'status_update', 'Status Aspirasi Berubah', 'Aspirasi Anda tentang kursi rusak telah selesai', NULL, NOW(), NOW()),
('1234567891', 'status_update', 'Status Aspirasi Berubah', 'Aspirasi Anda tentang toilet sedang diproses', NULL, NOW(), NOW());

-- ============================================
-- QUERY VERIFIKASI
-- ============================================

-- Tampilkan semua data aspirasi lengkap
SELECT 
    a.id_pelaporan,
    s.nama AS nama_siswa,
    s.kelas,
    k.ket_kategori AS kategori,
    a.lokasi,
    a.ket AS keterangan,
    a.status,
    a.feedback,
    a.created_at AS tgl_pelaporan
FROM aspirasis a
JOIN siswas s ON a.nis = s.nis
JOIN kategoris k ON a.id_kategori = k.id_kategori
ORDER BY a.created_at DESC;

-- ============================================
-- SCRIPT SELESAI
-- ============================================