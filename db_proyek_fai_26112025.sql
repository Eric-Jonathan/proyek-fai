/*
SQLyog Community v13.3.1 (64 bit)
MySQL - 8.4.3 : Database - proyek_fai
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE `proyek_fai`;

USE `proyek_fai`;

/*Table structure for table `lecturers` */

DROP TABLE IF EXISTS `lecturers`;

CREATE TABLE `lecturers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` ENUM('admin','sekretaris','kaprodi','rektor','dekan','bau','dosen') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dosen',
  `full_name` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lecturer_code` VARCHAR(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nidn` VARCHAR(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `employment_status` ENUM('active','inactive') COLLATE utf8mb4_unicode_ci DEFAULT 'active',
  `start_date` DATE DEFAULT NULL,
  `end_date` DATE DEFAULT NULL,
  `is_certified` TINYINT(1) NOT NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `uk_lecturer_code` (`lecturer_code`),
  UNIQUE KEY `uk_nidn` (`nidn`)
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `lecturers` */

INSERT  INTO `lecturers`(`id`,`username`,`password`,`email`,`role`,`full_name`,`lecturer_code`,`nidn`,`employment_status`,`start_date`,`end_date`,`is_certified`,`created_at`,`updated_at`) VALUES 
(1,'andi','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','andi@example.com','dosen','Andi Wijaya','LC001','NIDN90001','active',NULL,NULL,1,'2025-11-26 09:35:09','2025-11-26 09:59:08'),
(2,'maria','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','maria@example.com','sekretaris','Maria Susanto','LC014','NIDN90014','active',NULL,NULL,0,'2025-11-26 09:35:09','2025-11-26 09:59:05'),
(3,'admin','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','admin@mail.com','admin','Administrator Utama','ADM001','999999','active',NULL,NULL,0,'2025-11-26 02:56:01','2025-11-26 02:56:01');

/*Table structure for table `lecturers_permissions` */

DROP TABLE IF EXISTS `lecturers_permissions`;

CREATE TABLE `lecturers_permissions` (
  `lp_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `lecturer_id` INT NOT NULL,
  `permission_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`lp_id`),
  KEY `fk_lp_lecturer` (`lecturer_id`),
  KEY `fk_lp_permission` (`permission_id`),
  CONSTRAINT `fk_lp_lecturer` FOREIGN KEY (`lecturer_id`) REFERENCES `lecturers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_lp_permission` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `lecturers_permissions` */

INSERT  INTO `lecturers_permissions`(`lp_id`,`lecturer_id`,`permission_id`) VALUES 
(1,1,1),
(2,1,2),
(3,1,3),
(4,2,1),
(5,2,2),
(6,2,3),
(8,2,4),
(9,3,1),
(10,3,2),
(11,3,3),
(12,3,4);

/*Table structure for table `log_aktivitas` */

DROP TABLE IF EXISTS `log_aktivitas`;

CREATE TABLE `log_aktivitas` (
  `log_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aktivitas` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `module` ENUM('surat_tugas','surat_keluar','template','stempel','auth') COLLATE utf8mb4_unicode_ci NOT NULL,
  `module_id` INT UNSIGNED DEFAULT NULL,
  `keterangan` TEXT COLLATE utf8mb4_unicode_ci,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`),
  KEY `fk_log_lecturer` (`nidn`),
  CONSTRAINT `fk_log_lecturer` FOREIGN KEY (`nidn`) REFERENCES `lecturers` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `log_aktivitas` */

INSERT  INTO `log_aktivitas`(`log_id`,`nidn`,`aktivitas`,`module`,`module_id`,`keterangan`,`created_at`) VALUES 
(1,'NIDN90001','Mengajukan surat tugas','surat_tugas',1,'Surat tugas pelatihan Big Data','2025-11-26 09:35:09'),
(2,'NIDN90014','Melihat surat tugas','surat_tugas',1,'Review dari sekretaris','2025-11-26 09:35:09');

/*Table structure for table `nomor_surat` */

DROP TABLE IF EXISTS `nomor_surat`;

CREATE TABLE `nomor_surat` (
  `nomor_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tahun` YEAR NOT NULL,
  `nomor_terakhir` INT UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`nomor_id`),
  UNIQUE KEY `tahun` (`tahun`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `nomor_surat` */

INSERT  INTO `nomor_surat`(`nomor_id`,`tahun`,`nomor_terakhir`) VALUES 
(1,2024,12),
(2,2025,3);

/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_name` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` TEXT COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`permission_id`)
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

INSERT  INTO `permissions`(`permission_id`,`permission_name`,`description`) VALUES 
(1,'create_surat','Create Surat'),
(2,'lihat_surat','Lihat Surat'),
(3,'edit_surat','Edit Surat'),
(4,'acc_surat','ACC Surat'),
(5,'ttd_surat','TTD Surat'),
(6,'stempel_surat','Stempel Surat');

/*Table structure for table `position_assignments` */

DROP TABLE IF EXISTS `position_assignments`;

CREATE TABLE `position_assignments` (
  `position_assignment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_id` INT UNSIGNED NOT NULL,
  `nidn` VARCHAR(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `decree_number` VARCHAR(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_status` SMALLINT NOT NULL DEFAULT '1',
  PRIMARY KEY (`position_assignment_id`),
  KEY `fk_pa_lecturer` (`nidn`),
  KEY `fk_pa_position` (`position_id`),
  CONSTRAINT `fk_pa_lecturer` FOREIGN KEY (`nidn`) REFERENCES `lecturers` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pa_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `position_assignments` */

INSERT  INTO `position_assignments`(`position_assignment_id`,`position_id`,`nidn`,`start_date`,`end_date`,`decree_number`,`assignment_status`) VALUES 
(1,4,'NIDN90001','2024-01-01','2025-01-01','SK-001',1),
(2,2,'NIDN90014','2024-01-01','2025-01-01','SK-014',1),
(3,1,'999999','2025-11-26','2025-11-26',NULL,1),
(4,2,'999999','2025-11-26','2025-11-26',NULL,1),
(5,3,'999999','2025-11-26','2025-11-26',NULL,1),
(6,4,'999999','2025-11-26','2025-11-26',NULL,1);

/*Table structure for table `positions` */

DROP TABLE IF EXISTS `positions`;

CREATE TABLE `positions` (
  `position_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_code` VARCHAR(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `position_name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_position_id` INT UNSIGNED DEFAULT NULL,
  `hierarchy_level` SMALLINT DEFAULT NULL,
  `position_type` VARCHAR(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `division_code` VARCHAR(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bureau_name` VARCHAR(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`position_id`),
  UNIQUE KEY `uk_position_code` (`position_code`),
  KEY `fk_positions_parent` (`parent_position_id`),
  CONSTRAINT `fk_positions_parent` FOREIGN KEY (`parent_position_id`) REFERENCES `positions` (`position_id`) ON DELETE SET NULL
) ENGINE=INNODB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `positions` */

INSERT  INTO `positions`(`position_id`,`position_code`,`position_name`,`parent_position_id`,`hierarchy_level`,`position_type`,`division_code`,`bureau_name`) VALUES 
(1,'REK1','Rektor',NULL,0,NULL,NULL,NULL),
(2,'DKFST','Dekan Fakultas Sains dan Teknologi',1,1,NULL,NULL,NULL),
(3,'DKFD','Dekan Fakultas Desain',1,1,NULL,NULL,NULL),
(4,'KINF','Kaprodi S1-Teknik Informatika',2,2,NULL,NULL,NULL),
(5,'KTI','Kaprodi S2-Teknologi Informasi',2,2,NULL,NULL,NULL),
(6,'KSIB','Kaprodi S1-Sistem Informasi Bisnis',2,2,NULL,NULL,NULL),
(7,'KELK','Kaprodi S1-Teknik Elektro',2,2,NULL,NULL,NULL),
(8,'KIND','Kaprodi S1-Teknik Industri',2,2,NULL,NULL,NULL),
(9,'KMBD','Kaprodi S1-Manajemen Bisnis Digital',2,2,NULL,NULL,NULL),
(10,'KDKV','Kaprodi S1-Desain Komunikasi Visual',3,2,NULL,NULL,NULL),
(11,'KDES','Kaprodi S1-Desain Produk',3,2,NULL,NULL,NULL),
(12,'KSI','Kaprodi D3-Sistem Informasi',2,2,NULL,NULL,NULL),
(13,'DINF','Dosen S1-Teknik Informatika',2,3,NULL,NULL,NULL),
(14,'DSI','Dosen S2-Teknologi Informasi',2,3,NULL,NULL,NULL),
(15,'DSIB','Dosen S1-Sistem Informasi Bisnis',2,3,NULL,NULL,NULL),
(16,'DELK','Dosen S1-Teknik Elektro',2,3,NULL,NULL,NULL),
(17,'DIND','Dosen S1-Teknik Industri',2,3,NULL,NULL,NULL),
(18,'DMBD','Dosen S1-Manajemen Bisnis Digital',2,3,NULL,NULL,NULL),
(19,'DDKV','Dosen S1-Desain Komunikasi Visual',3,3,NULL,NULL,NULL),
(20,'DDES','Dosen S1-Desain Produk',3,3,NULL,NULL,NULL),
(21,'DSI3','Dosen D3-Sistem Informasi',2,3,NULL,NULL,NULL);

/*Table structure for table `stempel` */

DROP TABLE IF EXISTS `stempel`;

CREATE TABLE `stempel` (
  `stempel_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `stempel_image_path` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valid_until` DATE NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`stempel_id`),
  KEY `fk_stempel_lecturer` (`nidn`),
  CONSTRAINT `fk_stempel_lecturer` FOREIGN KEY (`nidn`) REFERENCES `lecturers` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `stempel` */

INSERT  INTO `stempel`(`stempel_id`,`nidn`,`stempel_image_path`,`valid_until`,`created_at`) VALUES 
(1,'NIDN90001','stempel/andi.png','2025-12-31','2025-11-26 09:35:09'),
(2,'NIDN90014','stempel/maria.png','2026-12-31','2025-11-26 09:35:09');

/*Table structure for table `surat_templates` */

DROP TABLE IF EXISTS `surat_templates`;

CREATE TABLE `surat_templates` (
  `template_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `template_name` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_type` ENUM('surat_tugas','surat_keluar') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`template_id`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `surat_templates` */

INSERT  INTO `surat_templates`(`template_id`,`template_name`,`file_path`,`template_type`,`created_at`) VALUES 
(1,'Template Surat Tugas Default','templates/surat_tugas_default.docx','surat_tugas','2025-11-26 09:35:09'),
(2,'Template Surat Keluar Default','templates/surat_keluar_default.docx','surat_keluar','2025-11-26 09:35:09');

/*Table structure for table `surat_tugas` */

DROP TABLE IF EXISTS `surat_tugas`;

CREATE TABLE `surat_tugas` (
  `surat_id` int unsigned NOT NULL AUTO_INCREMENT,
  `nidn` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` int unsigned NOT NULL,
  `nomor_surat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_tugas` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dasar_tugas` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_pelaksanaan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `tanggal_surat` date NOT NULL,
  `lampiran_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_surat` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '-1=`delete`, 0=ditolak, 1=diajukan, 2=diproses, 3=disetujui_dekan, 4=disetujui_kaprodi, 5=ditandatangani',
  `nomor_surat_final` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signed_by_position_id` int unsigned DEFAULT NULL,
  `alasan_penolakan` TEXT NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`surat_id`),
  KEY `fk_st_lecturer` (`nidn`),
  KEY `fk_st_template` (`template_id`),
  KEY `fk_st_signature_position` (`signed_by_position_id`),
  CONSTRAINT `fk_st_lecturer` FOREIGN KEY (`nidn`) REFERENCES `lecturers` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_st_signature_position` FOREIGN KEY (`signed_by_position_id`) REFERENCES `positions` (`position_id`) ON DELETE SET NULL,
  CONSTRAINT `fk_st_template` FOREIGN KEY (`template_id`) REFERENCES `surat_templates` (`template_id`) ON DELETE RESTRICT
) ENGINE=INNODB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `surat_tugas` */

INSERT  INTO `surat_tugas`(`surat_id`,`nidn`,`template_id`,`nomor_surat`,`jenis_tugas`,`dasar_tugas`,`sifat`,`tujuan`,`waktu_pelaksanaan`,`tanggal_mulai`,`tanggal_selesai`,`tanggal_surat`,`lampiran_path`,`status_surat`,`nomor_surat_final`,`signed_by_position_id`,`created_at`,`updated_at`) VALUES 
(1,'NIDN90001',1,NULL,'Narasumber','Surat Undangan ABC','Penting','Memberi pelatihan big data kepada mahasiswa','08.00 - 16.00 WIB','2024-10-05','2024-10-05','2024-10-04',NULL,'diajukan',NULL,NULL,'2025-11-26 09:35:09','2025-11-26 09:35:09'),
(2,'999999',1,NULL,'abc','def','Non-Dinas','test','2025-11-28 s/d 2025-11-29','2025-11-28','2025-11-29','2025-11-26','lampiran_surat/alJfHSC46cGOA3YW0Fl5AvGVMPN8mfGtw1hBbefO.pdf','diajukan',NULL,NULL,'2025-11-26 03:53:23','2025-11-26 03:53:23'),
(3,'999999',1,NULL,'abc','def','Non-Dinas','test','2025-11-28 s/d 2025-11-29','2025-11-28','2025-11-29','2025-11-26','lampiran_surat/wIIvIxTX8QTV8IsMv8yHrerVTx50jMtSzJ4drKcm.pdf','diajukan',NULL,NULL,'2025-11-26 03:58:13','2025-11-26 03:58:13');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
