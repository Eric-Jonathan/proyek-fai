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
  `nidn` VARCHAR(11) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
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
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `lecturers` */

INSERT INTO lecturers 
(username, `password`, email, `role`, full_name, lecturer_code, nidn, employment_status, start_date, end_date, is_certified, created_at, updated_at)
VALUES
('arya','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','aryatandyhermawan@gmail.com','rektor','Ir. Arya Tandy Hermawan, M.T.','LC0001','07200984018','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('gunawan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','gunawan@gmail.com','dosen','Dr. Ir. Gunawan, M.Kom.','LC0002','07200984019','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('herman','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','hermanbudianto@gmail.com','dosen','Dr. Ir. Herman Budianto, M.M.','LC0003','07200984020','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('ferdinandus','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','fxferdinandus@gmail.com','dekan','Dr. Ir. FX. Ferdinandus, M.T.','LC0004','07200984021','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('edwin','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','edwinpramana@gmail.com','dekan','Ir. Edwin Pramana, M.App.Sc., Ph.D.','LC0005','07200984022','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('hendrawan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','hendrawanarmanto@gmail.com','dosen','Hendrawan Armanto, S.Kom. M.Kom','LC0006','07200984023','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('yuliana','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','yulianamelita@gmail.com','bau','Yuliana Melita, S.Kom., M.Kom.','LC0007','07200984024','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('eka','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','ekarahayusetyaningsih@gmail.com','kaprodi','Eka Rahayu Setyaningsih, S.Kom., M.Kom.','LC0008','07200984025','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('lucy','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','lucy@gmail.com','sekretaris','Lucy, A.Md.','LC0009','07200984026','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('dwi','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','dwiyantihandayani@gmail.com','dosen','Dra. Mrr. Dwi Yanti Handayani, M.M.','LC0010','07200984027','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('jenny','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','jennyngo@gmail.com','dosen','Dr. Jenny Ngo, M.Sc.Ed','LC0011','07200984028','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('endangsri','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','endangsriwahyuni@gmail.com','dosen','Endang Sriwahyuni, S.S., M.Hum.','LC0012','07200984029','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('francisca','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','franciscachandra@gmail.com','kaprodi','Dr. Ir. Francisca Haryanti Chandra, M.T.','LC0013','07200984030','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('agus','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','agusgunawan@gmail.com','dosen','Ir. Agus Gunawan, MSEE.','LC0014','07200984031','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('budhy','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','budhysutanto@gmail.com','dosen','Ir. Budhy Sutanto','LC0015','07200984032','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('setya','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','setyaardhi@gmail.com','dosen','Setya Ardhi, S.T., M.Kom.','LC0016','07200984033','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('judi','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','judiprajetnosugiono@gmail.com','dosen','Ir. Judi Prajetno Sugiono, M.M.','LC0017','07200984034','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('andri','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','andrisuhartono@gmail.com','dosen','Andri Suhartono, ST. M.T','LC0018','07200984035','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('yosi','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','yosikristian@gmail.com','kaprodi','Dr. Yosi Kristian, S.Kom., M.Kom.','LC0019','07200984036','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('grace','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','gracelevinadewi@gmail.com','dosen','Grace Levina Dewi, S.Kom., M.Kom.','LC0020','07200984037','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('kevin','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','kevinsetiono@gmail.com','dosen','Kevin Setiono, S.Kom., M.Kom.','LC0021','07200984038','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('khinardi','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','khinardigunawan@gmail.com','dosen','Ir. Khinardi Gunawan','LC0022','07200984039','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('mikhael','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','mikhaelsetiawan@gmail.com','dosen','Mikhael Setiawan, S.Kom, M.Kom','LC0023','07200984040','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('iwan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','iwanchandra@gmail.com','dosen','Ir. Iwan Chandra, S.Kom, M.Kom.','LC0024','07200984041','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('oswald','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','oswaldbaskoro@gmail.com','dosen','Ir. Oswald Baskoro, M.Kom','LC0025','07200984042','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('reddy','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','reddyalexandroh@gmail.com','dosen','Reddy Alexandro H., S.Kom., M.Kom.','LC0026','07200984043','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('joan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','joansantoso@gmail.com','dosen','Dr. Ir. Joan Santoso, S.Kom., M.Kom','LC0027','07200984044','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('suhatati','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','suhatatitjandra@gmail.com','dosen','Ir. Suhatati Tjandra, M.Kom.','LC0028','07200984045','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('tjwanda','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','tjwandaputragunawan@gmail.com','dosen','Ir. Tjwanda Putra Gunawan, M.Pd.','LC0029','07200984046','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('evan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','evankusumasutanto@gmail.com','dosen','Evan Kusuma Sutanto, S.Kom, M.Kom','LC0030','07200984047','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('kelvin','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','kelvin@gmail.com','kaprodi','Kelvin, S.T., M.M.','LC0031','07200984048','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('pram','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','prameliyahyuliana@gmail.com','dosen','Pram Eliyah Yuliana, S.T., M.T.','LC0032','07200984049','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('sri','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','srirahayu@gmail.com','dosen','Sri Rahayu, S.T., M.T.','LC0033','07200984050','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('gusti','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','igustideviayu@gmail.com','dosen','I Gusti Deviayu, S.T, M.T.','LC0034','07200984051','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('ellen','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','ellenselynaardinata@gmail.com','dosen','Ellen Selyna Ardinata, S.T.','LC0035','07200984052','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('mattew','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','mattewlawrenta@gmail.com','dosen','Mattew Lawrenta, S.T.','LC0036','07200984053','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('esther','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','estherirawati@gmail.com','kaprodi','Dr. Ir. Esther Irawati, S.Kom., M.Kom.','LC0037','07200984054','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('hartarto','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','hartartojunaedi@gmail.com','dosen','Dr. Hartarto Junaedi, S.Kom., M.Kom.','LC0038','07200984055','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('audrey','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','audreyayudianaris@gmail.com','dosen','Audrey Ayu Dianaris, S.SI, M.Kom','LC0039','07200984056','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('eric','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','ericsugiharto@gmail.com','dosen','Eric Sugiharto, S.SI., M.Kom.','LC0040','07200984057','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('eunike','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','eunikeandrianikardinata@gmail.com','dosen','Eunike Andriani Kardinata, S.SI.','LC0041','07200984058','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('ong','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','onghansel@gmail.com','dosen','Ong Hansel, S.SI, M.Kom','LC0042','07200984059','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('thuan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','hermanthuantosaurik@gmail.com','dosen','Herman Thuan To Saurik, S.Kom, M.T.','LC0043','07200984060','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('yulius','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','yuliuswidinugroho@gmail.com','kaprodi','Yulius Widi Nugroho, S.Sn., M.Si.','LC0044','07200984061','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('lukman','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','lukmanzamanpcs@gmail.com','dosen','Dr. Lukman Zaman PCSW, S.Kom., M.Kom.','LC0045','07200984062','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('jacky','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','jackycahyadi@gmail.com','dosen','Jacky Cahyadi, S.Sn.','LC0046','07200984063','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('sufiana','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','sufiana@gmail.com','dosen','Dr. Sufiana, Dra., M.Sn','LC0047','07200984064','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('amelia','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','ameliaagustina@gmail.com','dosen','Amelia Agustina, S.Ds, M.Med.Kom.','LC0048','07200984065','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('naafi','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','naafinurrohma@gmail.com','dosen','Naafi Nur Rohma, S.Sn., M.Sn.','LC0049','07200984066','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('bonnifacia','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','bonnifaciabulana@gmail.com','dosen','Bonnifacia Bulan A., S.Ds., M.A.','LC0050','07200984067','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('farah','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','farahfauziah@gmail.com','dosen','Farah Fauziah, S.Hub.Int., M.A','LC0051','07200984068','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('decky','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','deckyavrilukitoismandoyo@gmail.com','kaprodi','Dr. Decky Avrilukito Ismandoyo, S.Sn., M.M.','LC0052','07200984069','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('alan','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','alandavidprayogi@gmail.com','dosen','Alan David Prayogi, S.T., M.T.','LC0053','07200984070','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('detyo','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','detyocampoko@gmail.com','dosen','Detyo Campoko, S.T., M.Sn.','LC0054','07200984071','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('yohanes','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','yohanesfiranantasetyo@gmail.com','dosen','Yohanes Firananta Setyo, S.T.,M.M.','LC0055','07200984072','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('sigit','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','sigitfirdaus@gmail.com','dosen','Sigit Firdaus, S.T., M.Ds.','LC0056','07200984073','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('endang','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','endangsetyati@gmail.com','kaprodi','Dr. Ir. Endang Setyati, M.T.','LC0057','07200984074','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('endah','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','endahanastasiawahas@gmail.com','bau','Endah Anastasia Wahas','LC0058','07200984075','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('ingrid','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','ingridpattisinai@gmail.com','bau','Ingrid Pattisinai','LC0059','07200984076','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('lianovena','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','lianovenakohar@gmail.com','bau','Lianovena Kohar','LC0060','07200984077','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('maria','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','mariaidaariana@gmail.com','bau','Maria Ida Ariana','LC0061','07200984078','active','2025-12-11',NULL,1,'2025-12-11','2025-12-11'),

('admin','$2y$12$lJLyHbihc.UPfJpdw1noQendng7GqcP0JGnQVdRJ4qBt9xm0LdYnG','admin@mail.com','admin','Administrator Utama','ADM001','999999','active',NULL,NULL,0,'2025-11-26 02:56:01','2025-11-26 02:56:01');


/*Table structure for table `positions` */

/*Data for the table `positions` */

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
(13,'DINF','Dosen S1-Teknik Informatika',4,3,NULL,NULL,NULL),
(14,'DSI','Dosen S2-Teknologi Informasi',5,3,NULL,NULL,NULL),
(15,'DSIB','Dosen S1-Sistem Informasi Bisnis',6,3,NULL,NULL,NULL),
(16,'DELK','Dosen S1-Teknik Elektro',7,3,NULL,NULL,NULL),
(17,'DIND','Dosen S1-Teknik Industri',8,3,NULL,NULL,NULL),
(18,'DMBD','Dosen S1-Manajemen Bisnis Digital',9,3,NULL,NULL,NULL),
(19,'DDKV','Dosen S1-Desain Komunikasi Visual',10,3,NULL,NULL,NULL),
(20,'DDES','Dosen S1-Desain Produk',11,3,NULL,NULL,NULL),
(21,'DSI3','Dosen D3-Sistem Informasi',12,3,NULL,NULL,NULL),
(22,'ADMIN','Admin',NULL,0,NULL,NULL,NULL),
(23,'BAU','BAU',NULL,0,NULL,NULL,NULL),
(24,'SEKRE','Sekretaris',NULL,0,NULL,NULL,NULL);


/*Table structure for table `position_assignments` */

DROP TABLE IF EXISTS position_assignments;

CREATE TABLE `position_assignments` (
  `position_assignment_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `position_id` INT UNSIGNED NOT NULL,
  `nidn` VARCHAR(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `decree_number` VARCHAR(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assignment_status` SMALLINT NOT NULL DEFAULT '1',
  PRIMARY KEY (`position_assignment_id`),
  KEY `fk_pa_lecturer` (`nidn`),
  KEY `fk_pa_position` (`position_id`),
  CONSTRAINT `fk_pa_lecturer` FOREIGN KEY (`nidn`) REFERENCES `lecturers` (`nidn`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_pa_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`position_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `position_assignments` */

INSERT INTO position_assignments 
(position_id, nidn, start_date, end_date, decree_number, assignment_status) 
VALUES
(1, '07200984018', '2025-12-11', '9999-12-31', NULL, 1),  -- Rektor Arya Tandy H
(13, '07200984019', '2025-12-11', '9999-12-31', NULL, 1), -- Gunawan - Dosen Informatika
(19, '07200984020', '2025-12-11', '9999-12-31', NULL, 1), -- Herman B - Dosen DKV
(3, '07200984021', '2025-12-11', '9999-12-31', NULL, 1),  -- Ferdinandus - Dekan Desain
(2, '07200984022', '2025-12-11', '9999-12-31', NULL, 1),  -- Edwin Pramana - Dekan FST
(13, '07200984023', '2025-12-11', '9999-12-31', NULL, 1), -- Hendrawan A - Dosen TI
(23, '07200984024', '2025-12-11', '9999-12-31', NULL, 1), -- Yuliana Melita - BAU
(12, '07200984025', '2025-12-11', '9999-12-31', NULL, 1), -- Eka Rahayu - Kaprodi D3 SI
(24, '07200984026', '2025-12-11', '9999-12-31', NULL, 1), -- Lucy - Sekretaris Rektor
(19, '07200984027', '2025-12-11', '9999-12-31', NULL, 1), -- Dwi Yanti - Dosen DKV
(13, '07200984028', '2025-12-11', '9999-12-31', NULL, 1), -- Jenny Ngo - Dosen TI
(17, '07200984029', '2025-12-11', '9999-12-31', NULL, 1), -- Endang Sriwahyuni - Dosen Industri
(7, '07200984030', '2025-12-11', '9999-12-31', NULL, 1),  -- Francisca - Kaprodi Elektro
(16, '07200984031', '2025-12-11', '9999-12-31', NULL, 1), -- Agus Gunawan - Dosen Elektro
(16, '07200984032', '2025-12-11', '9999-12-31', NULL, 1), -- Budhy Sutanto - Dosen Elektro
(16, '07200984033', '2025-12-11', '9999-12-31', NULL, 1), -- Setya Ardhi - Dosen Elektro
(16, '07200984034', '2025-12-11', '9999-12-31', NULL, 1), -- Judi P Sugiono - Dosen Elektro
(16, '07200984035', '2025-12-11', '9999-12-31', NULL, 1), -- Andri Suhartono - Dosen Elektro
(4, '07200984036', '2025-12-11', '9999-12-31', NULL, 1),  -- Yosi Kristian - Kaprodi Informatika
(13, '07200984037', '2025-12-11', '9999-12-31', NULL, 1), -- Grace Levina - Dosen TI
(13, '07200984038', '2025-12-11', '9999-12-31', NULL, 1), -- Kevin Setiono - Dosen TI
(13, '07200984039', '2025-12-11', '9999-12-31', NULL, 1), -- Khinardi Gunawan - Dosen TI
(13, '07200984040', '2025-12-11', '9999-12-31', NULL, 1), -- Mikhael Setiawan - Dosen TI
(13, '07200984041', '2025-12-11', '9999-12-31', NULL, 1), -- Iwan Chandra - Dosen TI
(13, '07200984042', '2025-12-11', '9999-12-31', NULL, 1), -- Oswald Baskoro - Dosen TI
(13, '07200984043', '2025-12-11', '9999-12-31', NULL, 1), -- Reddy Alexandro - Dosen TI
(13, '07200984044', '2025-12-11', '9999-12-31', NULL, 1), -- Joan Santoso - Dosen TI
(13, '07200984045', '2025-12-11', '9999-12-31', NULL, 1), -- Suhatati Tjandra - Dosen TI
(13, '07200984046', '2025-12-11', '9999-12-31', NULL, 1), -- Tjwanda Putra - Dosen TI
(13, '07200984047', '2025-12-11', '9999-12-31', NULL, 1), -- Evan Kusuma - Dosen TI
(8, '07200984048', '2025-12-11', '9999-12-31', NULL, 1),  -- Kelvin - Kaprodi Industri
(17, '07200984049', '2025-12-11', '9999-12-31', NULL, 1), -- Pram Eliyah - Dosen Industri
(17, '07200984050', '2025-12-11', '9999-12-31', NULL, 1), -- Sri Rahayu - Dosen Industri
(17, '07200984051', '2025-12-11', '9999-12-31', NULL, 1), -- I Gusti Deviayu - Dosen Industri
(17, '07200984052', '2025-12-11', '9999-12-31', NULL, 1), -- Ellen Selyna - Dosen Industri
(17, '07200984053', '2025-12-11', '9999-12-31', NULL, 1), -- Mattew Lawrenta - Dosen Industri
(6, '07200984054', '2025-12-11', '9999-12-31', NULL, 1),  -- Esther Irawati - Kaprodi SIB
(15, '07200984055', '2025-12-11', '9999-12-31', NULL, 1), -- Hartarto - Dosen SIB
(15, '07200984056', '2025-12-11', '9999-12-31', NULL, 1), -- Audrey - Dosen SIB
(15, '07200984057', '2025-12-11', '9999-12-31', NULL, 1), -- Eric Sugiharto - Dosen SIB
(15, '07200984058', '2025-12-11', '9999-12-31', NULL, 1), -- Eunike - Dosen SIB
(15, '07200984059', '2025-12-11', '9999-12-31', NULL, 1), -- Ong Hansel - Dosen SIB
(15, '07200984060', '2025-12-11', '9999-12-31', NULL, 1), -- Herman Saurik - Dosen SIB
(10, '07200984061', '2025-12-11', '9999-12-31', NULL, 1), -- Yulius W - Kaprodi DKV
(19, '07200984062', '2025-12-11', '9999-12-31', NULL, 1), -- Lukman - Dosen DKV
(19, '07200984063', '2025-12-11', '9999-12-31', NULL, 1), -- Jacky Cahyadi - DKV
(19, '07200984064', '2025-12-11', '9999-12-31', NULL, 1), -- Sufiana - DKV
(19, '07200984065', '2025-12-11', '9999-12-31', NULL, 1), -- Amelia Agustina - DKV
(19, '07200984066', '2025-12-11', '9999-12-31', NULL, 1), -- Naafi Nur Rohma - DKV
(19, '07200984067', '2025-12-11', '9999-12-31', NULL, 1), -- Bonnifacia Bulan - DKV
(19, '07200984068', '2025-12-11', '9999-12-31', NULL, 1), -- Farah Fauziah - DKV
(11, '07200984069', '2025-12-11', '9999-12-31', NULL, 1), -- Decky Ismandoyo - Kaprodi DP
(20, '07200984070', '2025-12-11', '9999-12-31', NULL, 1), -- Alan David - Dosen DP
(20, '07200984071', '2025-12-11', '9999-12-31', NULL, 1), -- Detyo Campoko - Dosen DP
(20, '07200984072', '2025-12-11', '9999-12-31', NULL, 1), -- Yohanes Firananta - Dosen DP
(20, '07200984073', '2025-12-11', '9999-12-31', NULL, 1), -- Sigit Firdaus - Dosen DP
(5, '07200984074', '2025-12-11', '9999-12-31', NULL, 1),  -- Endang Setyati - Kaprodi S2 TI
(23, '07200984075', '2025-12-11', '9999-12-31', NULL, 1), -- Endah A Wahas - BAU
(23, '07200984076', '2025-12-11', '9999-12-31', NULL, 1), -- Ingrid P - BAU
(23, '07200984077', '2025-12-11', '9999-12-31', NULL, 1), -- Lianovena - BAU
(23, '07200984078', '2025-12-11', '9999-12-31', NULL, 1);  -- Maria Ida - BAU


/*Table structure for table `permissions` */

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `permission_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `permission_name` VARCHAR(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` TEXT COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`permission_id`)
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `permissions` */

INSERT  INTO `permissions`(`permission_id`,`permission_name`,`description`) VALUES 
(1,'create_surat','Create Surat'),
(2,'lihat_surat','Lihat Surat'),
(3,'edit_surat','Edit Surat'),
(4,'acc_surat','ACC Surat'),
(5,'ttd_surat','TTD Surat'),
(6,'stempel_surat','Stempel Surat');


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
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `lecturers_permissions` */

INSERT  INTO `lecturers_permissions`(`lecturer_id`,`permission_id`) VALUES 
(1,2),
(1,4),
(1,5),

(2,1),
(2,2),
(2,3),

(3,1),
(3,2),
(3,3),

(4,1),
(4,2),
(4,3),
(4,4),
(4,5),

(5,1),
(5,2),
(5,3),
(5,4),
(5,5),

(6,1),
(6,2),
(6,3),

(7,1),
(7,2),
(7,3),
(7,4),
(7,5),
(7,6),

(8,1),
(8,2),
(8,3),
(8,4),
(8,5),


(9,1),
(9,2),
(9,3),
(9,4),
(9,5),
(9,6),

(13,1),
(13,2),
(13,3),
(13,4),


(14,1),
(14,2),
(14,3);



/*Table structure for table `log_aktivitas` */

DROP TABLE IF EXISTS `log_aktivitas`;

CREATE TABLE `log_aktivitas` (
  `log_id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(11) COLLATE utf8mb4_unicode_ci NOT NULL,
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
(2,2025,1);


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
  `surat_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nidn` VARCHAR(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template_id` INT UNSIGNED NOT NULL,
  `nomor_surat` VARCHAR(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_tugas` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dasar_tugas` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `sifat` VARCHAR(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tujuan` TEXT COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_pelaksanaan` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_mulai` DATE NOT NULL,
  `tanggal_selesai` DATE NOT NULL,
  `tanggal_surat` DATE NOT NULL,
  `lampiran_path` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status_surat` TINYINT(1) NOT NULL DEFAULT '1' COMMENT '-1=delete, 0=ditolak, 1=diproses_kaprodi, 2=diproses_sekretaris, 3=diproses_dekan, 4=diproses_rektor, 5=menunggu_stempel, 6=selesai',
  `nomor_surat_final` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `signed_by_position_id` INT UNSIGNED DEFAULT NULL,
  `alasan_penolakan` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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
