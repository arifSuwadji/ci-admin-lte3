-- MySQL dump 10.14  Distrib 5.5.64-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: manajemen_aset
-- ------------------------------------------------------
-- Server version	5.5.64-MariaDB
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `hak_akses_menu`
--

INSERT INTO `hak_akses_menu` VALUES (1,1);
INSERT INTO `hak_akses_menu` VALUES (1,2);
INSERT INTO `hak_akses_menu` VALUES (1,3);
INSERT INTO `hak_akses_menu` VALUES (1,4);
INSERT INTO `hak_akses_menu` VALUES (1,5);
INSERT INTO `hak_akses_menu` VALUES (1,6);
INSERT INTO `hak_akses_menu` VALUES (1,7);
INSERT INTO `hak_akses_menu` VALUES (1,8);
INSERT INTO `hak_akses_menu` VALUES (1,9);
INSERT INTO `hak_akses_menu` VALUES (1,10);
INSERT INTO `hak_akses_menu` VALUES (1,11);
INSERT INTO `hak_akses_menu` VALUES (1,12);
INSERT INTO `hak_akses_menu` VALUES (1,13);
INSERT INTO `hak_akses_menu` VALUES (1,14);
INSERT INTO `hak_akses_menu` VALUES (1,15);
INSERT INTO `hak_akses_menu` VALUES (1,16);
INSERT INTO `hak_akses_menu` VALUES (1,17);
INSERT INTO `hak_akses_menu` VALUES (1,18);
INSERT INTO `hak_akses_menu` VALUES (1,19);
INSERT INTO `hak_akses_menu` VALUES (1,20);
INSERT INTO `hak_akses_menu` VALUES (1,21);
INSERT INTO `hak_akses_menu` VALUES (1,22);

--
-- Dumping data for table `halaman_menu`
--

INSERT INTO `halaman_menu` VALUES (1,'Kelola Menu','Data Menu','admin/menu','zmdi zmdi-menu','ya');
INSERT INTO `halaman_menu` VALUES (2,'Kelola Menu','Tambah Menu','admin/tambahMenu','zmdi zmdi-menu','tidak');
INSERT INTO `halaman_menu` VALUES (3,'Kelola Menu','Tambah Menu (Aksi)','admin/tambahMenuBaru','zmdi zmdi-menu','tidak');
INSERT INTO `halaman_menu` VALUES (4,'Kelola Menu','Edit Menu','admin/editMenu','zmdi zmdi-menu','tidak');
INSERT INTO `halaman_menu` VALUES (5,'Kelola Menu','Edit Menu (Aksi)','admin/updateMenu','zmdi zmdi-menu','tidak');
INSERT INTO `halaman_menu` VALUES (6,'Kelola Menu','Hapus Menu','admin/hapusMenu','zmdi zmdi-menu','tidak');
INSERT INTO `halaman_menu` VALUES (7,'Pengguna','Data Pengguna','admin/pengguna','zmdi zmdi-accounts-alt','ya');
INSERT INTO `halaman_menu` VALUES (8,'Pengguna','Tambah Pengguna','admin/tambahPengguna','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (9,'Pengguna','Tambah Pengguna (Aksi)','admin/tambahPenggunaBaru','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (10,'Pengguna','Edit Pengguna','admin/editPengguna','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (11,'Pengguna','Edit Pengguna (Aksi)','admin/updatePengguna','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (12,'Pengguna','Hapus Pengguna','admin/hapusPengguna','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (13,'Pengguna','Data Grup','admin/penggunaGrup','zmdi zmdi-group-work','ya');
INSERT INTO `halaman_menu` VALUES (14,'Pengguna','Tambah Grup','admin/tambahGrup','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (15,'Pengguna','Tambah Grup (Aksi)','admin/tambahGrupBaru','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (16,'Pengguna','Edit Grup','admin/editGrup','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (17,'Pengguna','Edit Grup (Aksi)','admin/updateGrup','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (18,'Pengguna','Hapus Grup','admin/hapusGrup','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (19,'Pengguna','Ganti Password','admin/gantiPassword','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (20,'Pengguna','Ganti Password (Aksi)','admin/updatePassword','zmdi zmdi-accounts-alt','tidak');
INSERT INTO `halaman_menu` VALUES (21,'Pengguna','Hak Akses','admin/hakAkses','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (22,'Pengguna','Hak Akses (Aksi)','admin/updateHakAkses','zmdi zmdi-group-work','tidak');
INSERT INTO `halaman_menu` VALUES (23,'Pengguna','PDF - Data Pengguna','admin/pdfPengguna','nav-icon fas fa-user','tidak');
INSERT INTO `halaman_menu` VALUES (24,'Pengguna','Excel - Data Pengguna','admin/excelPengguna','nav-icon fas fa-user','tidak');

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` VALUES (1,1,'Admin Utama','admin','admin@admin.com','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8','2020-02-12 09:56:09','0000-00-00 00:00:00');

--
-- Dumping data for table `pengguna_grup`
--

INSERT INTO `pengguna_grup` VALUES (1,'Administrator');
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-12 13:13:53
