CREATE DATABASE `proyek_fai`;
USE `proyek_fai`;

-- ============================================================
-- 1. TABLE: lecturers
-- ============================================================

CREATE TABLE `lecturers` (
  id INT AUTO_INCREMENT PRIMARY KEY,

  -- Data akun (dari tabel user)
  username VARCHAR(100) UNIQUE NOT NULL,
  PASSWORD VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,

  -- Relasi struktural (dari user)
  `role` ENUM('admin','sekretaris', 'kaprodi', 'rektor', 'bau'),
  atasan_id INT DEFAULT NULL,	

  -- Data dosen (dari lecturers)
  full_name VARCHAR(255) DEFAULT NULL,
  lecturer_code VARCHAR(10) DEFAULT NULL,
  nidn VARCHAR(10) DEFAULT NULL,
  employment_status VARCHAR(20) DEFAULT 'active',
  start_date DATE DEFAULT NULL,
  end_date DATE DEFAULT NULL,
  is_certified TINYINT(1) NOT NULL DEFAULT 0,

  -- Timestamp
  created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  -- Unique constraints
  UNIQUE KEY uk_lecturer_code (lecturer_code),
  UNIQUE KEY uk_employee_nidn (nidn),

  FOREIGN KEY (atasan_id) REFERENCES `lecturers`(id) ON DELETE SET NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO lecturers 
(username, PASSWORD, email, ROLE, atasan_id, full_name, lecturer_code, nidn, employment_status, start_date, end_date, is_certified)
VALUES
('admin001', 'password123', 'admin@kampus.ac.id', 'admin', NULL, 'Dr. Andi Wijaya', 'LC001', 'NIDN90001', 'active', '2020-01-01', '2030-01-01', 1),

('sekre002', 'password123', 'sekre@kampus.ac.id', 'sekretaris', 1, 'Maria Santoso, M.Kom', 'LC002', 'NIDN90014', 'active', '2021-01-01', '2030-01-01', 0),

('kapro003', 'password123', 'kaprodi@kampus.ac.id', 'kaprodi', 1, 'Budi Hartono, S.T., M.T.', 'LC003', 'NIDN90022', 'active', '2022-06-01', '2030-01-01', 1);

-- ============================================================
-- 2. TABLE: positions
-- ============================================================
CREATE TABLE `positions` (
  `position_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_code` VARCHAR(10) NOT NULL,
  `position_name` VARCHAR(255) NOT NULL,
  `parent_position_id` INT UNSIGNED DEFAULT NULL,
  `hierarchy_level` SMALLINT DEFAULT NULL,
  `position_type` VARCHAR(20) DEFAULT NULL,
  `division_code` VARCHAR(3) DEFAULT NULL,
  `bureau_name` VARCHAR(25) DEFAULT NULL,
  PRIMARY KEY (`position_id`),
  UNIQUE KEY `uk_position_code` (`position_code`),
  CONSTRAINT `fk_position_parent`
    FOREIGN KEY (`parent_position_id`) REFERENCES `positions`(`position_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `positions`
(`position_id`, `position_code`, `position_name`, `parent_position_id`, `hierarchy_level`, `position_type`, `division_code`, `bureau_name`) VALUES
  (1,'ROOT','University Root',NULL,0,'governance','00','executive'),
  (2,'CHANC','Chancellor',1,1,'governance','77','executive'),
  (3,'OPS1','Operations Lead',2,2,'operations','45','services');


-- ============================================================
-- 3. TABLE: position_assignments
-- ============================================================
CREATE TABLE `position_assignments` (
  `position_assignment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_id` INT UNSIGNED NOT NULL,
  `nidn` VARCHAR(11) NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `decree_number` VARCHAR(25) DEFAULT NULL,
  `assignment_status` SMALLINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`position_assignment_id`),
  
  CONSTRAINT `fk_nidn`
    FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`),
  CONSTRAINT `fk_assignment_position`
    FOREIGN KEY (`position_id`) REFERENCES `positions`(`position_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `position_assignments`
(`position_assignment_id`, `position_id`, `nidn`, `start_date`, `end_date`, `decree_number`, `assignment_status`) VALUES
  (1,2,'NIDN90001','2023-01-01','2024-12-31','DEC-009',1),
  (2,3,'NIDN90014','2023-06-01','2024-12-31','DEC-014',1),
  (3,3,'NIDN90022','2025-01-01','2026-12-31','DEC-020',1);


-- ============================================================
-- 4. TABLE: permissions
-- ============================================================
CREATE TABLE `permissions` (
  `permission_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`permission_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `permissions`(`permission_name`, `description`) VALUES
('create_surat', 'Create Surat'),
('lihat_surat', 'Lihat Surat'),
('edit_surat', 'Edit Surat'),
('acc_surat', 'ACC Surat'),
('ttd_surat', 'TTD Surat'),
('stempel_surat', 'Stempel Surat');

CREATE TABLE `lecturers_permissions` (
  `lp_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  lecturer_id INT NOT NULL,
  permission_id INT UNSIGNED NOT NULL,
  PRIMARY KEY (`lp_id`),
  CONSTRAINT `fk_lecturer_id`
    FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers`(`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_permission_id`
    FOREIGN KEY (`permission_id`) REFERENCES `permissions`(`permission_id`) ON DELETE CASCADE
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


INSERT INTO lecturers_permissions (lecturer_id, permission_id)
VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 1),
(3, 2);

-- ============================================================
-- 5. TABLE: nomor_surat (FINAL FIXED)
-- ============================================================
-- nomor surat hanya 1 sequence per tahun
CREATE TABLE `nomor_surat` (
  `nomor_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` YEAR NOT NULL,
  `nomor_terakhir` INT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`nomor_id`),
  UNIQUE KEY `uk_tahun` (`tahun`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO nomor_surat (tahun, nomor_terakhir)
VALUES
(2024, 12),
(2025, 3);


-- ============================================================
-- 6. TABLE: surat_templates (needed by surat_tugas)
-- ============================================================
CREATE TABLE `surat_templates` (
  `template_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_name` VARCHAR(100) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `template_type` ENUM('surat_tugas','surat_keluar') NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`template_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO surat_templates (template_name, file_path, template_type)
VALUES
('Template Surat Tugas Default', 'templates/surat_tugas_default.docx', 'surat_tugas'),
('Template Surat Keluar Default', 'templates/surat_keluar_default.docx', 'surat_keluar');


-- ============================================================
-- 7. TABLE: surat_tugas
-- ============================================================
DROP TABLE IF EXISTS `surat_tugas`;

CREATE TABLE `surat_tugas` (
  `surat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(11) NOT NULL,
  `template_id` INT UNSIGNED NOT NULL,

  `nama_kegiatan` VARCHAR(255) NOT NULL,
  `jenis_tugas` VARCHAR(255) NOT NULL,
  `dasar_tugas` TEXT NOT NULL,
  `sifat` VARCHAR(50) NOT NULL,
  `tujuan` TEXT NOT NULL,
  `waktu_pelaksanaan` VARCHAR(255) NOT NULL,

  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,

  `tanggal_surat` DATE NOT NULL,          -- tanggal surat dibuat
  `lampiran_path` VARCHAR(255) DEFAULT NULL,

  `status_surat` ENUM(
      'diajukan',
      'diproses',
      'disetujui_kaprodi',
      'disetujui_dekan',
      'ditandatangani',
      'ditolak'
  ) NOT NULL DEFAULT 'diajukan',

  `alasan_penolakan` TEXT NULL DEFAULT NULL,   -- kolom baru

  `nomor_surat_final` VARCHAR(255) DEFAULT NULL,
  `signed_by_position_id` INT UNSIGNED DEFAULT NULL,

  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  PRIMARY KEY (`surat_id`),

  CONSTRAINT `fk_surat_tugas_lecturer`
    FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`),

  CONSTRAINT `fk_surat_tugas_template`
    FOREIGN KEY (`template_id`) REFERENCES `surat_templates`(`template_id`),

  CONSTRAINT `fk_surat_tugas_signed_position`
    FOREIGN KEY (`signed_by_position_id`) REFERENCES `positions`(`position_id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO surat_tugas 
(nidn, template_id, nama_kegiatan, jenis_tugas, dasar_tugas, sifat, tujuan, waktu_pelaksanaan,
 tanggal_mulai, tanggal_selesai, tanggal_surat, status_surat)
VALUES
('NIDN90001', 1,
 'Pelatihan Big Data',
 'Narasumber',
 'Surat Undangan ABC',
 'Penting',
 'Memberi pelatihan big data kepada mahasiswa',
 '08.00 - 16.00 WIB',
 '2024-10-05', '2024-10-05', '2024-10-04', 'diajukan');

-- ============================================================
-- 8. TABLE: stempel
-- ============================================================
CREATE TABLE `stempel` (
  `stempel_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(11) NOT NULL,
  `stempel_image_path` VARCHAR(255) NOT NULL,
  `valid_until` DATE NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`stempel_id`),

  CONSTRAINT `fk_stempel_issuer`
    FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO stempel (nidn, stempel_image_path, valid_until)
VALUES
('NIDN90001', 'stempel/andi.png', '2025-12-31'),
('NIDN90014', 'stempel/maria.png', '2026-12-31');

-- ============================================================
-- 9. TABLE: log_aktivitas
-- ============================================================
CREATE TABLE `log_aktivitas` (
  `log_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(11) NOT NULL,
  `aktivitas` VARCHAR(255) NOT NULL,
  `module` ENUM('surat_tugas','surat_keluar','template','stempel','auth') NOT NULL,
  `module_id` INT UNSIGNED NULL,
  `keterangan` TEXT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),

  CONSTRAINT `fk_log_user`
    FOREIGN KEY (`nidn`) REFERENCES `lecturers`(`nidn`)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO log_aktivitas (nidn, aktivitas, module, module_id, keterangan)
VALUES
('NIDN90001', 'Mengajukan surat tugas', 'surat_tugas', 1, 'Surat tugas pelatihan Big Data'),
('NIDN90014', 'Melihat surat tugas', 'surat_tugas', 1, 'Review dari sekretaris');
