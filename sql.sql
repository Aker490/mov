-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.32-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for movie
CREATE DATABASE IF NOT EXISTS `movie` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci */;
USE `movie`;

-- Dumping structure for table movie.account
CREATE TABLE IF NOT EXISTS `account` (
  `id_account` int(50) NOT NULL AUTO_INCREMENT,
  `username_account` varchar(40) DEFAULT NULL,
  `password_account` varchar(97) DEFAULT NULL,
  `salt_account` varchar(256) DEFAULT NULL,
  `role_account` varchar(6) DEFAULT NULL,
  `images_account` varchar(50) DEFAULT NULL,
  `login_cont_account` int(1) NOT NULL,
  `lock_account` int(1) NOT NULL,
  `ban_account` datetime DEFAULT NULL,
  `login_count_account` int(11) DEFAULT 0,
  PRIMARY KEY (`id_account`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table movie.account: ~0 rows (approximately)
DELETE FROM `account`;
INSERT INTO `account` (`id_account`, `username_account`, `password_account`, `salt_account`, `role_account`, `images_account`, `login_cont_account`, `lock_account`, `ban_account`, `login_count_account`) VALUES
	(1, 'Admin', '$argon2id$v=19$m=65536,t=4,p=1$Mk1iV1czd0U4d0NmblF4Zg$ASH2LBkhP/4Bl/QQMDaTzEwCsav03PJJ9iyGNz86AAk', '81e058a0463f2b030a9cf5ad844c20135006b13a7dba61e90230661344114af5583e7f9091c3f21b58db455d257345793842975effb41e6806e54451c1c91f150a309a3688e39e74b39d718a49d16fc2c56b35f92313fb028ed5b08ecc6ee4b89187eef49b', 'admin', 'default_images_account.jpg', 0, 0, '0000-00-00 00:00:00', 0);

-- Dumping structure for table movie.data_list
CREATE TABLE IF NOT EXISTS `data_list` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `main_id` int(3) NOT NULL,
  `name` text NOT NULL,
  `vdo` text NOT NULL,
  `episode` int(3) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table movie.data_list: ~13 rows (approximately)
DELETE FROM `data_list`;
INSERT INTO `data_list` (`id`, `main_id`, `name`, `vdo`, `episode`) VALUES
	(1, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'MTgxKSYN0ms', 1),
	(2, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'k8kugaeXhuQ', 2),
	(3, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', '9PL2vu6gAYQ', 3),
	(4, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'S_7VDwin12E', 4),
	(5, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'mZ70VVGaf1M', 5),
	(6, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'arrzbkOb91w', 6),
	(7, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'g9JGeR50G6A', 7),
	(8, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'vz5lVoWqzcY', 8),
	(9, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'TJuIB98sZks', 9),
	(10, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'thBT3GP46hI', 10),
	(11, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'OEa5KsDmvfg', 11),
	(12, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'PE0BfA00kK8', 12),
	(13, 1, 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'BV0Bw583M6E', 13);

-- Dumping structure for table movie.data_movie
CREATE TABLE IF NOT EXISTS `data_movie` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `img` text NOT NULL,
  `name` text NOT NULL,
  `vdo_ex` text NOT NULL,
  `vdo_main` text NOT NULL,
  `status` varchar(255) DEFAULT 'ongoing',
  `category` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- Dumping data for table movie.data_movie: ~2 rows (approximately)
DELETE FROM `data_movie`;
INSERT INTO `data_movie` (`id`, `img`, `name`, `vdo_ex`, `vdo_main`, `status`, `category`, `description`) VALUES
	(1, 'https://fairyanime.net/uploads/326589390792dc61d24cd2e81673b3583JwJNnx.jpg', 'ไปต่างโลกก็ต้องไปกับสมาร์ทโฟนสิ 2 ', 'uSWLA27WOzE', '', '	ongoing', 'action', NULL),
	(2, 'https://fairyanime.net/uploads/b15d96521919d4336f41150cf6721174Tp9QZXS.jpg', 'Shinmai Ossan Boukensha ตาลุงนักผจญภัยมือใหม่ ฝึกโหดจนไร้เทียมทานกับปาร์ตี้ในตำนานขั้นเทพ (เสียงไทย)', 'uSWLA27WOzE', '', 'ongoing', 'action', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
