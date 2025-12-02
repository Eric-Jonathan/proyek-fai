CREATE DATABASE IF NOT EXISTS `proyek_fai`;
USE `proyek_fai`;

-- ======================================================================
-- 1. TABLE: lecturers
-- ======================================================================
CREATE TABLE `lecturers` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `role` ENUM('admin','sekretaris','kaprodi','rektor','bau','dosen') NOT NULL DEFAULT 'dosen',

    `full_name` VARCHAR(255),
    `lecturer_code` VARCHAR(10),
    `nidn` VARCHAR(10),

    `employment_status` ENUM('active','inactive') DEFAULT 'active',
    `start_date` DATE,
    `end_date` DATE,
    `is_certified` TINYINT(1) NOT NULL DEFAULT 0,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY `uk_lecturer_code` (`lecturer_code`),
    UNIQUE KEY `uk_nidn` (`nidn`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 2. TABLE: positions
-- ======================================================================
CREATE TABLE `positions` (
    `position_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `position_code` VARCHAR(10) NOT NULL,
    `position_name` VARCHAR(255) NOT NULL,
    `parent_position_id` INT UNSIGNED DEFAULT NULL,
    `hierarchy_level` SMALLINT DEFAULT NULL,
    `position_type` VARCHAR(20),
    `division_code` VARCHAR(3),
    `bureau_name` VARCHAR(25),

    UNIQUE KEY `uk_position_code` (`position_code`),

    CONSTRAINT `fk_positions_parent`
        FOREIGN KEY (`parent_position_id`) REFERENCES `positions`(`position_id`)
        ON DELETE SET NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 3. TABLE: position_assignments
-- ======================================================================
CREATE TABLE `position_assignments` (
    `position_assignment_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `position_id` INT UNSIGNED NOT NULL,
    `nidn` VARCHAR(10) NOT NULL,
    `start_date` DATE NOT NULL,
    `end_date` DATE NOT NULL,
    `decree_number` VARCHAR(25),
    `assignment_status` SMALLINT NOT NULL DEFAULT 1,

    CONSTRAINT `fk_pa_lecturer`
        FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`)
        ON UPDATE CASCADE ON DELETE CASCADE,

    CONSTRAINT `fk_pa_position`
        FOREIGN KEY (`position_id`) REFERENCES `positions`(`position_id`)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 4. TABLE: permissions + junction table
-- ======================================================================
CREATE TABLE `permissions` (
    `permission_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `permission_name` VARCHAR(100) NOT NULL,
    `description` TEXT
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `lecturers_permissions` (
    `lp_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `lecturer_id` INT NOT NULL,
    `permission_id` INT UNSIGNED NOT NULL,

    CONSTRAINT `fk_lp_lecturer`
        FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers`(`id`) ON DELETE CASCADE,
    CONSTRAINT `fk_lp_permission`
        FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`permission_id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 5. TABLE: nomor_surat
-- ======================================================================
CREATE TABLE `nomor_surat` (
    `nomor_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `tahun` YEAR NOT NULL UNIQUE,
    `nomor_terakhir` INT UNSIGNED NOT NULL DEFAULT 0
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 6. TABLE: surat_templates
-- ======================================================================
CREATE TABLE `surat_templates` (
    `template_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `template_name` VARCHAR(100) NOT NULL,
    `file_path` VARCHAR(255) NOT NULL,
    `template_type` ENUM('surat_tugas','surat_keluar') NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 7. TABLE: surat_tugas
-- ======================================================================
CREATE TABLE `surat_tugas` (
    `surat_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    `nidn` VARCHAR(10) NOT NULL,
    `template_id` INT UNSIGNED NOT NULL,

    `jenis_tugas` VARCHAR(255) NOT NULL,
    `dasar_tugas` TEXT NOT NULL,
    `sifat` VARCHAR(50) NOT NULL,
    `tujuan` TEXT NOT NULL,
    `waktu_pelaksanaan` VARCHAR(255) NOT NULL,

    `tanggal_mulai` DATE NOT NULL,
    `tanggal_selesai` DATE NOT NULL,
    `tanggal_surat` DATE NOT NULL,

    `lampiran_path` VARCHAR(255),

    `status_surat` ENUM(
        'diajukan','diproses','disetujui_kaprodi',
        'disetujui_dekan','ditandatangani','ditolak'
    ) NOT NULL DEFAULT 'diajukan',

    `nomor_surat_final` VARCHAR(255),
    `signed_by_position_id` INT UNSIGNED,

    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT `fk_st_lecturer`
        FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`)
        ON DELETE CASCADE ON UPDATE CASCADE,

    CONSTRAINT `fk_st_template`
        FOREIGN KEY (`template_id`) REFERENCES `surat_templates`(`template_id`)
        ON DELETE RESTRICT,

    CONSTRAINT `fk_st_signature_position`
        FOREIGN KEY (`signed_by_position_id`) REFERENCES `positions`(`position_id`)
        ON DELETE SET NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 8. TABLE: stempel
-- ======================================================================
CREATE TABLE `stempel` (
    `stempel_id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nidn` VARCHAR(10) NOT NULL,
    `stempel_image_path` VARCHAR(255) NOT NULL,
    `valid_until` DATE NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT `fk_stempel_lecturer`
        FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ======================================================================
-- 9. TABLE: log_aktivitas
-- ======================================================================
CREATE TABLE `log_aktivitas` (
    `log_id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `nidn` VARCHAR(10) NOT NULL,
    `aktivitas` VARCHAR(255) NOT NULL,
    `module` ENUM('surat_tugas','surat_keluar','template','stempel','auth') NOT NULL,
    `module_id` INT UNSIGNED,
    `keterangan` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT `fk_log_lecturer`
        FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;