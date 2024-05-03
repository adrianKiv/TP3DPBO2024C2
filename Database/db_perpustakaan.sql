/*
Navicat MySQL Data Transfer

Source Server         : coba01
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : db_perpustakaan

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-05-03 07:35:55
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `anggota`
-- ----------------------------
DROP TABLE IF EXISTS `anggota`;
CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL AUTO_INCREMENT,
  `nama_anggota` varchar(255) DEFAULT NULL,
  `alamat_anggota` varchar(255) DEFAULT NULL,
  `no_telpon_anggota` varchar(255) DEFAULT NULL,
  `email_anggota` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of anggota
-- ----------------------------
INSERT INTO `anggota` VALUES ('1', 'iyan', 'cilimus', '081563380214', 'iyan@gmail.com');
INSERT INTO `anggota` VALUES ('2', 'naufal', 'gagak', '086523643644', 'naufal@gmail.com');
INSERT INTO `anggota` VALUES ('3', 'abdul', 'ledeng', '086354726663', 'abdul@gmail.com');
INSERT INTO `anggota` VALUES ('4', 'iky', 'gerlong tengah', '085351253243', 'iky@gmail.com');
INSERT INTO `anggota` VALUES ('5', 'shidiq', 'rumah shidiq', '086355412243', 'shidiq@gmail.com');

-- ----------------------------
-- Table structure for `buku`
-- ----------------------------
DROP TABLE IF EXISTS `buku`;
CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL AUTO_INCREMENT,
  `judul_buku` varchar(255) DEFAULT NULL,
  `penulis_buku` varchar(255) DEFAULT NULL,
  `tahun_terbit_buku` int(12) DEFAULT NULL,
  `status_buku` varchar(255) DEFAULT NULL,
  `id_genre` int(11) DEFAULT NULL,
  `foto_buku` varchar(255) DEFAULT NULL,
  `id_peminjaman` int(11) DEFAULT NULL,
  `id_anggota` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_buku`),
  KEY `genre_key` (`id_genre`),
  KEY `peminjaman_key` (`id_peminjaman`),
  KEY `anggota_key` (`id_anggota`),
  CONSTRAINT `anggota_key` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `genre_key` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `peminjaman_key` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of buku
-- ----------------------------
INSERT INTO `buku` VALUES ('2', 'Kesehjateraan Sosial', 'Isbandi Rukminto Adi', '2015', 'tersedia', '1', 'buku1.jpg', '1', '1');
INSERT INTO `buku` VALUES ('3', 'Kumpulan Undang undang Sistem peradilan Pidana', 'Lincon Arsyad', '2007', 'tidak tersedia', '2', 'buku2.jpg', '2', '2');
INSERT INTO `buku` VALUES ('4', 'Lembaga keuangan Islam', 'Nurul Huda', '2016', 'tersedia', '3', 'buku3.jpg', '3', '3');
INSERT INTO `buku` VALUES ('5', 'Metode Riset Bisnis Edisi II', 'Suliyanto', '2009', 'tidak tersedia', '4', 'buku4.jpg', '2', '4');
INSERT INTO `buku` VALUES ('6', 'Patologi I (umum)', 'Sudarto Pringgoutomo', '2002', 'tersedia', '5', 'buku5.jpg', '3', '5');
INSERT INTO `buku` VALUES ('14', 'awwww', 'fordu', '2034', 'ada', '4', '6e0f056ef55103ab8beadc4426d53816.jpg', '1', '2');

-- ----------------------------
-- Table structure for `genre`
-- ----------------------------
DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL AUTO_INCREMENT,
  `nama_genre` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_genre`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of genre
-- ----------------------------
INSERT INTO `genre` VALUES ('1', 'action');
INSERT INTO `genre` VALUES ('2', 'thirler');
INSERT INTO `genre` VALUES ('3', 'gore');
INSERT INTO `genre` VALUES ('4', 'horror');
INSERT INTO `genre` VALUES ('5', 'sci-fi');

-- ----------------------------
-- Table structure for `peminjaman`
-- ----------------------------
DROP TABLE IF EXISTS `peminjaman`;
CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `kode_peminjaman` varchar(255) DEFAULT '',
  PRIMARY KEY (`id_peminjaman`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of peminjaman
-- ----------------------------
INSERT INTO `peminjaman` VALUES ('1', '2024-04-09', '2024-04-26', 'DDS1');
INSERT INTO `peminjaman` VALUES ('2', '2024-04-01', '2024-04-27', 'DFW5');
INSERT INTO `peminjaman` VALUES ('3', '2024-02-13', '2024-04-30', 'GGD2');
