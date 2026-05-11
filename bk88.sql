-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bk88
CREATE DATABASE IF NOT EXISTS `bk88` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bk88`;

-- Dumping structure for table bk88.addresses
CREATE TABLE IF NOT EXISTS `addresses` (
  `address_id` int NOT NULL AUTO_INCREMENT,
  `street` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ward` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.addresses: ~8 rows (approximately)
INSERT INTO `addresses` (`address_id`, `street`, `ward`, `city`) VALUES
	(1, '12 Nguyễn Huệ', 'Phường Bến Nghé', 'TP.HCM'),
	(2, '45 Lê Lợi', 'Phường Bến Thành', 'TP.HCM'),
	(3, '', '', ''),
	(4, '', '', ''),
	(5, '', '', ''),
	(6, '1/2/13 Đường 5E', 'Phường Bình Hưng Hòa', 'TP.HCM'),
	(7, '', '', ''),
	(8, '1/2/13 Đường 5E', 'Bình Hưng Hòa', 'TP.HCM');

-- Dumping structure for table bk88.articles
CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `background` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.articles: ~2 rows (approximately)
INSERT INTO `articles` (`id_article`, `title`, `description`, `time_modified`, `status`, `content`, `background`) VALUES
	(1, 'Bài viết mẫu BK88', 'Giới thiệu', '2026-05-04 07:49:10', 1, 'Nội dung thử nghiệm...', '/assets/img/article/article1.png'),
	(2, 'Bài viết mới', '', '2026-05-04 07:28:01', 1, '<iframe class="ql-video" frameborder="0" allowfullscreen="true" src="https://www.youtube.com/embed/XbGs_qK2PQA?showinfo=0"></iframe><p class="ql-align-center"><br></p>', 'assets/img/article/article2.png');

-- Dumping structure for table bk88.comments
CREATE TABLE IF NOT EXISTS `comments` (
  `id_comment` int NOT NULL AUTO_INCREMENT,
  `id_article` int NOT NULL,
  `id_user` int NOT NULL,
  `text` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_edited` tinyint(1) DEFAULT '0',
  `replied` int DEFAULT NULL,
  PRIMARY KEY (`id_comment`),
  KEY `id_article` (`id_article`),
  KEY `id_user` (`id_user`),
  KEY `replied` (`replied`),
  CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`),
  CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`),
  CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`replied`) REFERENCES `comments` (`id_comment`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.comments: ~32 rows (approximately)
INSERT INTO `comments` (`id_comment`, `id_article`, `id_user`, `text`, `date_modified`, `is_edited`, `replied`) VALUES
	(1, 1, 1, 'Bài viết rất hữu ích!', '2026-04-15 07:40:59', 0, NULL),
	(2, 1, 2, 'Mình thấy phần hướng dẫn khá rõ ràng.', '2026-04-15 12:04:15', 0, NULL),
	(3, 1, 3, 'Thông tin khá đầy đủ.', '2026-04-15 12:04:19', 0, NULL),
	(44, 1, 1, 'Nội dung bình luận thử nghiệm', '2026-04-15 14:17:30', 0, NULL),
	(46, 1, 1, 'd', '2026-04-15 14:19:28', 0, NULL),
	(47, 1, 1, 'd', '2026-04-15 14:29:03', 0, NULL),
	(48, 1, 1, 'd', '2026-04-15 14:30:03', 0, NULL),
	(49, 1, 1, 'hello', '2026-04-15 14:48:57', 0, NULL),
	(50, 1, 1, 'xin chào', '2026-04-15 14:49:19', 0, NULL),
	(51, 1, 1, 'alo', '2026-04-15 14:49:51', 0, NULL),
	(52, 1, 1, 'có đó khong', '2026-04-15 14:51:46', 0, NULL),
	(53, 1, 1, 'xin chào', '2026-04-15 14:55:08', 0, NULL),
	(54, 1, 1, 'dsd', '2026-04-15 14:58:11', 0, NULL),
	(55, 1, 1, 'sdsd', '2026-04-15 14:58:16', 0, NULL),
	(58, 1, 1, 'Nội dung phản hồi ở đây', '2026-04-15 15:34:29', 0, 3),
	(59, 1, 1, 'alo', '2026-04-15 16:06:19', 0, 58),
	(60, 1, 1, 'Không', '2026-04-15 16:07:50', 0, 59),
	(61, 1, 1, 'Không', '2026-04-15 16:07:51', 0, 59),
	(62, 1, 1, 'Không', '2026-04-15 16:07:52', 0, 59),
	(64, 1, 1, 'Không', '2026-04-15 16:07:55', 0, 59),
	(68, 1, 1, 'chắc chắn rồi', '2026-04-15 16:37:39', 0, 3),
	(95, 1, 1, 'd', '2026-04-17 10:33:39', 0, NULL),
	(96, 1, 1, 'đ', '2026-04-17 10:37:41', 1, 95),
	(97, 1, 1, 'hello', '2026-04-19 14:08:47', 0, NULL),
	(98, 1, 1, 'hay', '2026-04-19 14:09:18', 0, 44),
	(99, 1, 1, 'hello', '2026-04-23 07:34:17', 0, NULL),
	(100, 1, 6, 'hel', '2026-04-23 07:53:37', 1, NULL),
	(101, 1, 6, 'hello', '2026-04-23 07:49:12', 0, 99),
	(105, 1, 6, 'đa', '2026-04-23 09:47:38', 0, NULL),
	(106, 1, 6, 'đe', '2026-04-23 09:51:10', 1, 105),
	(107, 1, 5, 'hay', '2026-04-23 12:16:38', 0, NULL),
	(108, 1, 5, 'k', '2026-05-04 08:00:28', 0, NULL);

-- Dumping structure for table bk88.comment_votes
CREATE TABLE IF NOT EXISTS `comment_votes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vote` enum('like','dislike') COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_vote` (`comment_id`,`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.comment_votes: ~12 rows (approximately)
INSERT INTO `comment_votes` (`id`, `comment_id`, `user_id`, `vote`) VALUES
	(1, 1, 2, 'like'),
	(2, 1, 3, 'like'),
	(3, 1, 4, 'dislike'),
	(5, 2, 3, 'like'),
	(6, 3, 2, 'dislike'),
	(62, 3, 1, 'like'),
	(66, 1, 1, 'dislike'),
	(69, 55, 1, 'like'),
	(70, 82, 1, 'dislike'),
	(86, 98, 1, 'dislike'),
	(110, 102, 6, 'dislike'),
	(122, 106, 5, 'like');

-- Dumping structure for table bk88.contacts
CREATE TABLE IF NOT EXISTS `contacts` (
  `contact_id` int NOT NULL AUTO_INCREMENT,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.contacts: ~27 rows (approximately)
INSERT INTO `contacts` (`contact_id`, `customer_name`, `customer_email`, `subject`, `message`, `status`, `created_at`) VALUES
	(1, 'Nguyễn Văn Minh', 'd@l.m', 'Quá xuất sắc', 'Quá mạnh', 0, '2026-05-03 10:11:11'),
	(2, 'Pablo Jenkins PhD', 'Kadin46@hotmail.com', 'Dynamic Infrastructure Orchestrator', 'Adipisci vitae non vacuus comparo. Admitto abundans sit conforto stultus colligo. Aliqua suspendo addo cura volup acsi.', 1, '2026-05-03 10:18:01'),
	(6, 'Wayne Labadie', 'Kaci.Lesch97@yahoo.com', 'Global Communications Technician', 'Dens sed cohaero vis basium volubilis blandior combibo. Sodalitas animi aetas canonicus tego quasi avaritia hic summa aestivus. Esse caste aegrus sophismata turba.', 1, '2026-05-03 10:18:01'),
	(7, 'Ms. Anne Bauch', 'Abdul82@yahoo.com', 'Legacy Integration Designer', 'Velit ultra teres currus tersus repellat vociferor. Cedo tibi tergo ut dolor causa quisquam acervus dens id. Utique blanditiis denego ventito.', 0, '2026-05-03 10:18:01'),
	(8, 'Mrs. Lorena Howe', 'Michelle.Durgan@yahoo.com', 'Senior Response Coordinator', 'Ascit maxime vitae clibanus vicissitudo tonsor fuga universe cohors quasi. Vere paulatim stips talio vulgaris tolero ustulo censura aliquam complectus. Videlicet doloremque comprehendo credo defungo atque adulescens tumultus.', 0, '2026-05-03 10:18:01'),
	(9, 'Peter Connelly', 'Lowell.Altenwerth32@gmail.com', 'Human Branding Supervisor', 'Neque curatio cunctatio. Subseco adeptio amplitudo. Tribuo tero admitto cibus vulnero impedit corroboro voluntarius desipio.', 0, '2026-05-03 10:18:01'),
	(10, 'Chad Parisian', 'Harmony.Simonis@gmail.com', 'Regional Applications Agent', 'In sed caveo venio debeo aestas vicinus decretum curto. Uxor subiungo corporis aggero sto. Et succedo vetus trepide arx tergeo bestia ambulo.', 0, '2026-05-03 10:18:01'),
	(11, 'Eva Von MD', 'Lucie92@hotmail.com', 'Customer Communications Consultant', 'A sollers acidus coniecto audeo repudiandae voluptatum. Tonsor decet ipsum corporis spectaculum. Fuga in sed tandem totidem torrens cultellus apostolus suadeo.', 0, '2026-05-03 10:18:01'),
	(12, 'Dr. Jessica Schmeler', 'Rigoberto22@hotmail.com', 'National Creative Manager', 'Tibi defendo talus tredecim vigilo deprecator. Admiratio magnam vicinus desparatus infit vorax coerceo. Quo agnitio vehemens hic spargo creta cornu deripio.', 1, '2026-05-03 13:41:43'),
	(14, 'Marcos Goodwin', 'Bernadette33@gmail.com', 'Dynamic Interactions Specialist', 'Perspiciatis iste sum degusto. Cupiditate valetudo defero claro alo deficio. Libero bis iusto.', 0, '2026-05-03 13:41:43'),
	(15, 'Gene Hilpert', 'Owen57@hotmail.com', 'Principal Mobility Administrator', 'Tubineus quasi caries ars defungo stultus aggredior pariatur. Et certe sustineo comburo sumo cuppedia capto tamdiu decumbo valetudo. Degenero ventito considero.', 1, '2026-05-03 13:41:43'),
	(16, 'Brooke Wolf', 'Cortez84@gmail.com', 'Central Program Technician', 'Amoveo angulus aperiam cursim textilis ancilla peccatus desolo. Certus acidus venustas ustulo depraedor. Ocer triduana defendo.', 1, '2026-05-03 13:41:43'),
	(17, 'Ernest MacGyver DVM', 'Dewayne.Mueller@yahoo.com', 'Direct Identity Representative', 'Molestiae pecto vapulus suscipit illum averto desparatus vulticulus ago. Strues advoco velut thesis enim temperantia volubilis sublime causa placeat. Quo carbo spectaculum ventus.', 1, '2026-05-03 13:41:43'),
	(18, 'Sherry Bode', 'Kitty.Walsh92@gmail.com', 'Product Quality Liaison', 'Soleo artificiose at confero soluta cognomen voluptates ver atrox. Laborum dedico valde cruciamentum utique cogo vestigium vigor audax. Ullus defetiscor patior.', 1, '2026-05-03 13:41:43'),
	(19, 'Lillie Crooks', 'Rozella.Monahan@hotmail.com', 'Customer Markets Liaison', 'Deprimo sufficio stultus vetus arx. Admiratio iure adulescens casus coaegresco valde solutio verbum. Turba optio cursus.', 1, '2026-05-03 13:41:43'),
	(20, 'Mrs. Sophie Barrows', 'Bettye_Cronin@yahoo.com', 'Forward Program Designer', 'Vulgivagus amplitudo studio excepturi complectus cribro vilitas. Attonbitus quia decimus amoveo arma eius assumenda. Tricesimus deludo aspicio molestias accusamus cavus vespillo.', 1, '2026-05-03 13:41:43'),
	(21, 'Margie Bogan', 'Ward_Heaney37@yahoo.com', 'Legacy Branding Developer', 'Nemo stipes videlicet tamdiu. Pectus strenuus thema tener tamen advenio creptio aedificium. Vigor consequuntur suggero totidem cornu curvo.', 1, '2026-05-03 13:41:43'),
	(22, 'Dr. Guillermo Hintz', 'Aileen_Stark@yahoo.com', 'Product Configuration Architect', 'Tepesco tui cervus compello ambitus ater recusandae universe cervus cito. Clam vito vicinus absum triduana velit. Volo contabesco termes adeptio.', 0, '2026-05-03 13:41:43'),
	(23, 'Mrs. Kari Nicolas', 'Alexandria.Schaefer78@hotmail.com', 'Global Solutions Director', 'Clarus curo verecundia tantillus. Basium blanditiis apostolus. Arma ubi ambulo quia ter strenuus.', 1, '2026-05-03 13:41:43'),
	(24, 'Olga Franecki', 'Saul_Larson42@gmail.com', 'Regional Factors Architect', 'Cubitum vetus alii assentator surculus acceptus accusator. Alii deleniti similique. Termes appello tremo vulnus aeneus carmen bos cultura caput iste.', 0, '2026-05-03 13:41:43'),
	(25, 'Jeffrey Padberg I', 'Aliya.Hoeger@yahoo.com', 'Direct Assurance Executive', 'Utrimque cohibeo desparatus saepe corpus tergo. Armarium comedo umerus cubicularis culpa terreo synagoga suscipit amo tamquam. Deprecator cavus viridis numquam tantillus vulnus.', 1, '2026-05-03 13:41:43'),
	(26, 'Phil Schamberger', 'Leonie71@yahoo.com', 'Customer Paradigm Engineer', 'Excepturi statua carmen communis debilito denuncio patior benigne. Absum anser utilis cursim ventosus tergum est ipsam illo cedo. Solium defetiscor trepide substantia defessus earum.', 0, '2026-05-03 13:41:43'),
	(27, 'Julio Powlowski', 'Evangeline81@hotmail.com', 'Global Intranet Manager', 'Conatus debilito cur. Vulariter vehemens utrimque fuga comparo compono modi condico. Cedo assentator denego aranea maxime apud carcer adipiscor cultura supellex.', 0, '2026-05-03 13:41:43'),
	(28, 'Dr. Aaron Walter', 'Brent.Steuber@hotmail.com', 'Direct Metrics Planner', 'Vindico temptatio utor suffoco ter vester. Currus amplitudo provident. Suscipio sapiente suffoco.', 0, '2026-05-03 13:41:43'),
	(29, 'Velma Quigley', 'Lazaro_Barton@yahoo.com', 'Direct Group Agent', 'Ultra subvenio talio triumphus appositus cogo tutis rerum. Supellex quasi tripudio vinitor totidem coaegresco. Crur considero una denuo via adiuvo.', 0, '2026-05-03 13:41:43'),
	(30, 'Ollie Steuber', 'Minerva_Gleichner87@hotmail.com', 'Future Brand Officer', 'Contego accusantium comis acies doloremque toties tubineus deleniti. Vero alius itaque celo vulariter blandior turba thermae subseco. Balbus desparatus adulescens volup utrum adimpleo caput vis decerno clibanus.', 0, '2026-05-03 13:41:43'),
	(31, 'Donald Moore', 'Dawn_Cremin@gmail.com', 'Regional Assurance Representative', 'Vel utor aperio pecto repellat cimentarius balbus voluptatum terra usque. Speculum abbas trucido videlicet condico allatus magni. Solum bellicus defleo confero.', 1, '2026-05-03 13:41:43');

-- Dumping structure for table bk88.contact_info_fields
CREATE TABLE IF NOT EXISTS `contact_info_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.contact_info_fields: ~4 rows (approximately)
INSERT INTO `contact_info_fields` (`id`, `label`, `value`, `icon`, `sort_order`, `is_active`, `updated_at`) VALUES
	(5, 'Bruh', 'Wait for me', '', 1, 0, '2026-05-04 16:58:26'),
	(8, 'Địa chỉ', '123 Ngô Quyền', '', 0, 1, '2026-05-04 16:57:28'),
	(9, 'Số điện thoại', '19008198', '', 1, 1, '2026-05-04 16:57:46'),
	(10, 'Giờ làm việc', 'Thứ 2 - thứ 6, 7h - 16h50', '', 3, 1, '2026-05-04 16:58:22');

-- Dumping structure for table bk88.home_featured_products
CREATE TABLE IF NOT EXISTS `home_featured_products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `item_id` int NOT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_home_featured_item` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.home_featured_products: ~5 rows (approximately)
INSERT INTO `home_featured_products` (`id`, `item_id`, `sort_order`, `is_active`, `updated_at`) VALUES
	(1, 1, 1, 1, '2026-05-04 15:11:56'),
	(2, 2, 2, 1, '2026-05-04 15:11:56'),
	(3, 3, 3, 1, '2026-05-04 15:11:56'),
	(4, 4, 4, 1, '2026-05-04 15:11:56'),
	(6, 7, 5, 1, '2026-05-04 15:59:07');

-- Dumping structure for table bk88.home_info_fields
CREATE TABLE IF NOT EXISTS `home_info_fields` (
  `id` int NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.home_info_fields: ~0 rows (approximately)

-- Dumping structure for table bk88.home_quotes
CREATE TABLE IF NOT EXISTS `home_quotes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quote_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.home_quotes: ~4 rows (approximately)
INSERT INTO `home_quotes` (`id`, `quote_text`, `author`, `image`, `sort_order`, `is_active`, `updated_at`) VALUES
	(1, 'Sách là nguồn tri thức vô tận.', 'Nguyễn Văn Minh - Co-founder của BK88', 'avt/nvm.png', 1, 1, '2026-05-04 16:43:04'),
	(2, 'Đầu tư vào kiến thức là khoản đầu tư lãi nhất.', 'Hồ Ngọc Anh Tuấn - Co-founder của BK88', 'avt/HNAT.png', 2, 1, '2026-05-04 16:43:10'),
	(3, 'Kiến thức dẫn lối con người.', ' Nông Văn Trung - Co-founder của BK88', 'avt/Trung Nông.png', 3, 1, '2026-05-04 16:42:13'),
	(4, 'Kiến thức là kết tinh của tạo hóa.', 'Phan Huy Trung - Co-founder của BK88', 'avt/Trung Phan.png', 4, 1, '2026-05-04 16:42:52');

-- Dumping structure for table bk88.home_reasons
CREATE TABLE IF NOT EXISTS `home_reasons` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.home_reasons: ~3 rows (approximately)
INSERT INTO `home_reasons` (`id`, `title`, `description`, `sort_order`, `is_active`, `updated_at`) VALUES
	(1, 'Giáo trình chất lượng', 'Cung cấp các bộ giáo trình được biên soạn và kiểm duyệt kỹ lưỡng bởi các chuyên gia hàng đầu trong ngành.', 1, 1, '2026-05-04 15:11:56'),
	(3, 'Hỗ trợ 24/7', 'Đội ngũ hỗ trợ chuyên nghiệp luôn sẵn sàng giải đáp mọi thắc mắc của bạn mọi lúc, mọi nơi.', 2, 1, '2026-05-04 16:45:13'),
	(6, 'Lắng nghe', 'Luôn luôn lắng nghe, lâu lâu mới hiểu', 3, 1, '2026-05-04 16:45:08');

-- Dumping structure for table bk88.home_sections
CREATE TABLE IF NOT EXISTS `home_sections` (
  `id` int NOT NULL AUTO_INCREMENT,
  `section_key` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `section_key` (`section_key`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.home_sections: ~3 rows (approximately)
INSERT INTO `home_sections` (`id`, `section_key`, `title`, `subtitle`, `is_active`, `updated_at`) VALUES
	(1, 'quote', 'Quote', NULL, 1, '2026-05-04 15:11:56'),
	(2, 'reason', 'Tại sao lại chọn chúng tôi?', 'Những giá trị cốt lõi mà BK88 mang lại cho bạn.', 1, '2026-05-04 16:02:51'),
	(3, 'product', 'Một số sản phẩm tiêu biểu', 'Tham khảo một số giáo trình tiêu biểu của chúng tôi', 1, '2026-05-04 15:11:56');

-- Dumping structure for table bk88.home_settings
CREATE TABLE IF NOT EXISTS `home_settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `setting_key` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Dumping data for table bk88.home_settings: ~1 rows (approximately)
INSERT INTO `home_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
	(1, 'site_logo', 'logo88.png', '2026-05-05 09:34:15');

-- Dumping structure for table bk88.information
CREATE TABLE IF NOT EXISTS `information` (
  `info_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `address_id` int NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`info_id`),
  KEY `user_id` (`user_id`),
  KEY `address_id` (`address_id`),
  CONSTRAINT `information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `information_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.information: ~8 rows (approximately)
INSERT INTO `information` (`info_id`, `user_id`, `address_id`, `firstname`, `lastname`) VALUES
	(1, 1, 1, 'Trung', 'Admin'),
	(2, 2, 2, 'Ngọc', 'User'),
	(5, 5, 3, 'T', 'N'),
	(6, 6, 4, 't', 'n'),
	(7, 7, 5, '2', ''),
	(8, 8, 6, 'Tuấn', 'Hồ Ngọc Anh'),
	(9, 9, 7, 'Tuan', 'Ho Ngoc Anh'),
	(10, 10, 8, 'Tuan', 'Ho Ngoc Anh');

-- Dumping structure for table bk88.items
CREATE TABLE IF NOT EXISTS `items` (
  `item_id` int NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `item_stock` int DEFAULT '0',
  `description` text COLLATE utf8mb3_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.items: ~11 rows (approximately)
INSERT INTO `items` (`item_id`, `item_name`, `item_stock`, `description`, `price`, `cost_price`, `item_image`) VALUES
	(1, 'Giải tích 1', 87, 'Giáo trình Giải tích 1', 75000.00, 61000.00, '1777112063_gt1.png'),
	(2, 'Giải tích 2', 98, 'Giáo trình Giải tích 2', 75000.00, 60000.00, '1777212188_gt2.png'),
	(3, 'Đại số tuyến tính', 97, 'Giáo trình Đại số tuyến tính', 85000.00, 70000.00, '1777212218_dstt.png'),
	(4, 'Hóa đại cương', 100, 'Giáo trình Hóa đại cương', 100000.00, 85000.00, '1777212252_hdc.png'),
	(5, 'Kỹ thuật Lập trình', 98, 'Giáo trình Kỹ thuật Lập trình', 150000.00, 135000.00, '1777212284_ktlt.png'),
	(6, 'Cấu trúc dữ liệu & Giải thuật', 99, 'Giáo trình CTDL&GT', 100000.00, 80000.00, '1777212312_ctdlgt.png'),
	(7, 'Triết học Mác - Lênin', 100, 'Giáo trình Triết học Mác - Lênin', 85000.00, 70000.00, '1777212345_triethoc.png'),
	(8, 'Kinh tế chính trị Mác - Lênin', 100, 'Giáo trình Kinh tế chính trị Mác - Lênin', 72000.00, 60000.00, '1777212383_ktct.png'),
	(9, 'Chủ nghĩa Xã hội Khoa học', 100, 'Giáo trình CNXHKH', 77000.00, 60000.00, '1777212448_cnxhkh.png'),
	(11, 'Lịch sử Đảng Cộng sản Việt Nam', 0, 'Giáo trình LSĐCSVN', 75000.00, 60000.00, '1777213030_lsd.png'),
	(15, 'Tư tưởng Hồ Chí Minh', 98, 'Giáo trình TTHCM', 80000.00, 65000.00, '1777521969_tthcm.png');

-- Dumping structure for table bk88.notifications
CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int NOT NULL AUTO_INCREMENT,
  `type` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `notification_comment_id` int DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notification_vote_comment_id` int DEFAULT NULL,
  `notification_order_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `notifications_ibfk_2` (`notification_comment_id`),
  KEY `fk_notifications_vote_comment` (`notification_vote_comment_id`),
  CONSTRAINT `fk_notifications_vote_comment` FOREIGN KEY (`notification_vote_comment_id`) REFERENCES `notification_vote_comment` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`notification_comment_id`) REFERENCES `notification_comment` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.notifications: ~66 rows (approximately)
INSERT INTO `notifications` (`id`, `type`, `user_id`, `notification_comment_id`, `is_read`, `created_at`, `notification_vote_comment_id`, `notification_order_id`) VALUES
	(1, 'vote_comment', 1, NULL, 1, '2026-04-17 10:27:50', 1, NULL),
	(2, 'vote_comment', 1, NULL, 1, '2026-04-17 10:28:19', 2, NULL),
	(3, 'vote_comment', 1, NULL, 1, '2026-04-17 10:28:30', 3, NULL),
	(4, 'vote_comment', 1, NULL, 1, '2026-04-17 10:31:44', 4, NULL),
	(5, 'comment', 1, 1, 1, '2026-04-17 10:33:39', NULL, NULL),
	(6, 'reply_comment', 1, 2, 1, '2026-04-17 10:35:38', NULL, NULL),
	(7, 'edit_comment', 1, 3, 1, '2026-04-17 10:37:42', NULL, NULL),
	(8, 'comment', 1, 4, 1, '2026-04-19 14:08:47', NULL, NULL),
	(9, 'reply_comment', 1, 5, 1, '2026-04-19 14:09:18', NULL, NULL),
	(10, 'comment', 1, 6, 1, '2026-04-23 07:34:17', NULL, NULL),
	(11, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:15', 5, NULL),
	(12, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:17', 6, NULL),
	(13, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:19', 7, NULL),
	(14, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:24', 8, NULL),
	(15, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:24', 9, NULL),
	(16, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:28', 10, NULL),
	(17, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:29', 11, NULL),
	(18, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:29', 12, NULL),
	(19, 'vote_comment', 6, NULL, 1, '2026-04-23 07:39:33', 13, NULL),
	(20, 'vote_comment', 6, NULL, 1, '2026-04-23 07:39:34', 14, NULL),
	(21, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:36', 15, NULL),
	(22, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:44', 16, NULL),
	(23, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:46', 17, NULL),
	(24, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:47', 18, NULL),
	(25, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:56', 19, NULL),
	(26, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:58', 20, NULL),
	(27, 'vote_comment', 6, NULL, 1, '2026-04-23 07:42:08', 21, NULL),
	(28, 'vote_comment', 6, NULL, 1, '2026-04-23 07:42:53', 22, NULL),
	(29, 'vote_comment', 6, NULL, 1, '2026-04-23 07:42:57', 23, NULL),
	(30, 'vote_comment', 6, NULL, 1, '2026-04-23 07:43:20', 24, NULL),
	(31, 'vote_comment', 6, NULL, 1, '2026-04-23 07:43:21', 25, NULL),
	(32, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:39', 26, NULL),
	(33, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:40', 27, NULL),
	(34, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:42', 28, NULL),
	(35, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:43', 29, NULL),
	(36, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:44', 30, NULL),
	(37, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:47', 31, NULL),
	(38, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:48', 32, NULL),
	(39, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:52', 33, NULL),
	(40, 'comment', 6, 7, 1, '2026-04-23 07:46:11', NULL, NULL),
	(41, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:18', 34, NULL),
	(42, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:19', 35, NULL),
	(43, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:21', 36, NULL),
	(44, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:22', 37, NULL),
	(45, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:25', 38, NULL),
	(46, 'reply_comment', 6, 8, 1, '2026-04-23 07:49:12', NULL, NULL),
	(47, 'edit_comment', 6, 9, 1, '2026-04-23 07:53:37', NULL, NULL),
	(53, 'vote_comment', 6, NULL, 1, '2026-04-23 09:38:46', 40, NULL),
	(54, 'vote_comment', 6, NULL, 1, '2026-04-23 09:38:47', 41, NULL),
	(55, 'vote_comment', 6, NULL, 1, '2026-04-23 09:38:47', 42, NULL),
	(56, 'vote_comment', 6, NULL, 1, '2026-04-23 09:39:10', 43, NULL),
	(57, 'vote_comment', 6, NULL, 1, '2026-04-23 09:40:49', 44, NULL),
	(58, 'vote_comment', 6, NULL, 1, '2026-04-23 09:40:51', 45, NULL),
	(59, 'vote_comment', 6, NULL, 1, '2026-04-23 09:44:01', 46, NULL),
	(60, 'vote_comment', 6, NULL, 1, '2026-04-23 09:44:02', 47, NULL),
	(61, 'comment', 6, 14, 1, '2026-04-23 09:47:38', NULL, NULL),
	(62, 'reply_comment', 6, 15, 1, '2026-04-23 09:49:24', NULL, NULL),
	(63, 'edit_comment', 6, 16, 1, '2026-04-23 09:51:10', NULL, NULL),
	(64, 'vote_comment', 5, NULL, 1, '2026-04-23 12:16:33', 48, NULL),
	(65, 'comment', 5, 17, 1, '2026-04-23 12:16:38', NULL, NULL),
	(66, 'order', 10, NULL, 1, '2026-05-04 03:39:53', NULL, 1),
	(67, 'order', 10, NULL, 1, '2026-05-04 06:49:24', NULL, 2),
	(68, 'comment', 5, 18, 1, '2026-05-04 08:00:28', NULL, NULL),
	(69, 'order', 10, NULL, 1, '2026-05-04 08:06:51', NULL, 3),
	(70, 'order', 10, NULL, 1, '2026-05-04 08:07:23', NULL, 4),
	(71, 'order', 10, NULL, 1, '2026-05-04 12:53:32', NULL, 5);

-- Dumping structure for table bk88.notification_comment
CREATE TABLE IF NOT EXISTS `notification_comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `article_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `replied` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `replied` (`replied`),
  KEY `notification_comment_ibfk_2` (`comment_id`),
  CONSTRAINT `notification_comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`),
  CONSTRAINT `notification_comment_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id_comment`) ON DELETE CASCADE,
  CONSTRAINT `notification_comment_ibfk_3` FOREIGN KEY (`replied`) REFERENCES `comments` (`replied`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.notification_comment: ~14 rows (approximately)
INSERT INTO `notification_comment` (`id`, `article_id`, `comment_id`, `content`, `replied`, `created_at`) VALUES
	(1, 1, 95, 'd', NULL, '2026-04-17 10:33:39'),
	(2, 1, 96, 'đs', 95, '2026-04-17 10:35:38'),
	(3, 1, 96, 'đ', 95, '2026-04-17 10:37:42'),
	(4, 1, 97, 'hello', NULL, '2026-04-19 14:08:47'),
	(5, 1, 98, 'hay', 44, '2026-04-19 14:09:18'),
	(6, 1, 99, 'hello', NULL, '2026-04-23 07:34:17'),
	(7, 1, 100, 'hello', NULL, '2026-04-23 07:46:11'),
	(8, 1, 101, 'hello', 99, '2026-04-23 07:49:12'),
	(9, 1, 100, 'hel', NULL, '2026-04-23 07:53:37'),
	(14, 1, 105, 'đa', NULL, '2026-04-23 09:47:38'),
	(15, 1, 106, 'de', 105, '2026-04-23 09:49:24'),
	(16, 1, 106, 'đe', 105, '2026-04-23 09:51:10'),
	(17, 1, 107, 'hay', NULL, '2026-04-23 12:16:38'),
	(18, 1, 108, 'k', NULL, '2026-05-04 08:00:28');

-- Dumping structure for table bk88.notification_order
CREATE TABLE IF NOT EXISTS `notification_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table bk88.notification_order: ~5 rows (approximately)
INSERT INTO `notification_order` (`id`, `order_id`, `order_status`, `created_at`) VALUES
	(1, 18, 'chờ xác nhận', '2026-05-04 03:39:53'),
	(2, 19, 'chờ xác nhận', '2026-05-04 06:49:24'),
	(3, 20, 'chờ xác nhận', '2026-05-04 08:06:51'),
	(4, 21, 'chờ xác nhận', '2026-05-04 08:07:23'),
	(5, 22, 'chờ xác nhận', '2026-05-04 12:53:32');

-- Dumping structure for table bk88.notification_setting
CREATE TABLE IF NOT EXISTS `notification_setting` (
  `setting_id` int NOT NULL AUTO_INCREMENT,
  `admin_id` int NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `enable_comment` tinyint(1) DEFAULT '1',
  `enable_reply` tinyint(1) DEFAULT '1',
  `enable_edit` tinyint(1) DEFAULT '1',
  `enable_vote` tinyint(1) DEFAULT '1',
  `enable_order` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`setting_id`),
  KEY `fk_admin_user` (`admin_id`),
  CONSTRAINT `fk_admin_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.notification_setting: ~2 rows (approximately)
INSERT INTO `notification_setting` (`setting_id`, `admin_id`, `is_enabled`, `enable_comment`, `enable_reply`, `enable_edit`, `enable_vote`, `enable_order`) VALUES
	(1, 1, 1, 1, 1, 1, 1, 1),
	(2, 5, 1, 1, 1, 1, 1, 1);

-- Dumping structure for table bk88.notification_vote_comment
CREATE TABLE IF NOT EXISTS `notification_vote_comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_id` int NOT NULL,
  `article_id` int NOT NULL,
  `vote_type` enum('like','dislike') COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `article_id` (`article_id`),
  KEY `notification_vote_comment_ibfk_1` (`comment_id`),
  CONSTRAINT `notification_vote_comment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id_comment`) ON DELETE CASCADE,
  CONSTRAINT `notification_vote_comment_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.notification_vote_comment: ~47 rows (approximately)
INSERT INTO `notification_vote_comment` (`id`, `comment_id`, `article_id`, `vote_type`, `created_at`) VALUES
	(1, 68, 1, 'like', '2026-04-17 10:27:50'),
	(2, 68, 1, 'dislike', '2026-04-17 10:28:19'),
	(3, 68, 1, 'dislike', '2026-04-17 10:28:30'),
	(4, 68, 1, 'like', '2026-04-17 10:31:44'),
	(5, 98, 1, 'like', '2026-04-23 07:35:15'),
	(6, 98, 1, 'dislike', '2026-04-23 07:35:16'),
	(7, 99, 1, 'dislike', '2026-04-23 07:35:19'),
	(8, 99, 1, 'like', '2026-04-23 07:35:24'),
	(9, 98, 1, 'dislike', '2026-04-23 07:37:24'),
	(10, 99, 1, 'dislike', '2026-04-23 07:37:28'),
	(11, 99, 1, 'dislike', '2026-04-23 07:37:29'),
	(12, 99, 1, 'dislike', '2026-04-23 07:37:29'),
	(13, 99, 1, 'like', '2026-04-23 07:39:33'),
	(14, 99, 1, 'dislike', '2026-04-23 07:39:34'),
	(15, 99, 1, 'like', '2026-04-23 07:41:36'),
	(16, 99, 1, 'dislike', '2026-04-23 07:41:44'),
	(17, 99, 1, 'like', '2026-04-23 07:41:46'),
	(18, 99, 1, 'like', '2026-04-23 07:41:47'),
	(19, 99, 1, 'dislike', '2026-04-23 07:41:56'),
	(20, 98, 1, 'like', '2026-04-23 07:41:58'),
	(21, 99, 1, 'like', '2026-04-23 07:42:08'),
	(22, 99, 1, 'like', '2026-04-23 07:42:53'),
	(23, 99, 1, 'dislike', '2026-04-23 07:42:57'),
	(24, 99, 1, 'like', '2026-04-23 07:43:20'),
	(25, 99, 1, 'dislike', '2026-04-23 07:43:21'),
	(26, 99, 1, 'like', '2026-04-23 07:44:39'),
	(27, 99, 1, 'dislike', '2026-04-23 07:44:40'),
	(28, 99, 1, 'dislike', '2026-04-23 07:44:42'),
	(29, 99, 1, 'like', '2026-04-23 07:44:43'),
	(30, 99, 1, 'like', '2026-04-23 07:44:44'),
	(31, 99, 1, 'dislike', '2026-04-23 07:44:47'),
	(32, 99, 1, 'like', '2026-04-23 07:44:48'),
	(33, 99, 1, 'like', '2026-04-23 07:44:52'),
	(34, 100, 1, 'like', '2026-04-23 07:46:18'),
	(35, 100, 1, 'dislike', '2026-04-23 07:46:19'),
	(36, 100, 1, 'like', '2026-04-23 07:46:21'),
	(37, 100, 1, 'dislike', '2026-04-23 07:46:22'),
	(38, 100, 1, 'dislike', '2026-04-23 07:46:25'),
	(40, 100, 1, 'like', '2026-04-23 09:38:46'),
	(41, 100, 1, 'like', '2026-04-23 09:38:47'),
	(42, 100, 1, 'dislike', '2026-04-23 09:38:47'),
	(43, 100, 1, 'like', '2026-04-23 09:39:10'),
	(44, 100, 1, 'dislike', '2026-04-23 09:40:49'),
	(45, 100, 1, 'like', '2026-04-23 09:40:51'),
	(46, 100, 1, 'dislike', '2026-04-23 09:44:01'),
	(47, 100, 1, 'like', '2026-04-23 09:44:02'),
	(48, 106, 1, 'like', '2026-04-23 12:16:33');

-- Dumping structure for table bk88.orders
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '0',
  `is_paid` tinyint(1) DEFAULT '0',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `note` text COLLATE utf8mb3_unicode_ci,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.orders: ~22 rows (approximately)
INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `status`, `is_paid`, `shipping_fee`, `note`) VALUES
	(1, 8, '2026-04-26 04:46:43', 4, 0, 22000.00, NULL),
	(2, 8, '2026-04-26 04:47:18', 3, 1, 0.00, NULL),
	(3, 8, '2026-04-26 10:27:50', 4, 0, 22000.00, NULL),
	(4, 8, '2026-04-26 10:28:21', 4, 0, 0.00, NULL),
	(5, 8, '2026-04-26 13:57:15', 3, 1, 22000.00, NULL),
	(6, 8, '2026-04-26 13:57:47', 4, 0, 22000.00, NULL),
	(7, 8, '2026-04-26 14:26:10', 4, 0, 22000.00, NULL),
	(8, 8, '2026-04-26 15:02:04', 4, 0, 22000.00, NULL),
	(9, 8, '2026-04-26 15:16:22', 4, 0, 22000.00, NULL),
	(10, 10, '2026-05-02 13:11:21', 1, 0, 22000.00, NULL),
	(11, 10, '2026-05-02 14:41:34', 1, 0, 22000.00, NULL),
	(12, 10, '2026-05-02 14:45:23', 1, 0, 0.00, NULL),
	(13, 10, '2026-05-02 14:56:58', 1, 0, 22000.00, NULL),
	(14, 10, '2026-05-02 15:18:59', 1, 0, 22000.00, NULL),
	(15, 10, '2026-05-02 15:19:18', 3, 1, 22000.00, NULL),
	(16, 10, '2026-05-02 15:28:22', 3, 1, 22000.00, 'ABC'),
	(17, 10, '2026-05-03 08:52:27', 0, 0, 0.00, ''),
	(18, 10, '2026-05-04 03:39:53', 3, 1, 22000.00, ''),
	(19, 10, '2026-05-04 06:49:24', 0, 0, 22000.00, ''),
	(20, 10, '2026-05-04 08:06:51', 0, 0, 22000.00, ''),
	(21, 10, '2026-05-04 08:07:23', 1, 0, 22000.00, ''),
	(22, 10, '2026-05-04 12:53:32', 0, 0, 22000.00, '');

-- Dumping structure for table bk88.order_details
CREATE TABLE IF NOT EXISTS `order_details` (
  `detail_id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`detail_id`),
  KEY `order_id` (`order_id`),
  KEY `item_id` (`item_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.order_details: ~24 rows (approximately)
INSERT INTO `order_details` (`detail_id`, `order_id`, `item_id`, `quantity`, `price`) VALUES
	(1, 1, 1, 1, 75000.00),
	(2, 2, 1, 1, 75000.00),
	(3, 3, 1, 1, 75000.00),
	(4, 4, 1, 1, 75000.00),
	(5, 5, 1, 2, 75000.00),
	(6, 6, 1, 1, 75000.00),
	(7, 7, 11, 1, 75000.00),
	(8, 8, 2, 1, 75000.00),
	(9, 9, 2, 1, 75000.00),
	(10, 10, 1, 2, 75000.00),
	(11, 10, 15, 2, 80000.00),
	(12, 11, 1, 5, 75000.00),
	(13, 12, 1, 1, 75000.00),
	(14, 13, 1, 1, 75000.00),
	(15, 14, 1, 1, 75000.00),
	(16, 15, 3, 1, 85000.00),
	(17, 16, 5, 1, 150000.00),
	(18, 17, 2, 1, 75000.00),
	(19, 18, 3, 1, 85000.00),
	(20, 19, 1, 1, 75000.00),
	(21, 19, 3, 1, 85000.00),
	(22, 20, 6, 1, 100000.00),
	(23, 21, 5, 1, 150000.00),
	(24, 22, 2, 1, 75000.00);

-- Dumping structure for table bk88.otp
CREATE TABLE IF NOT EXISTS `otp` (
  `otp_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `code` char(6) COLLATE utf8mb3_unicode_ci NOT NULL,
  `time_expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`otp_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `otp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.otp: ~9 rows (approximately)
INSERT INTO `otp` (`otp_id`, `user_id`, `code`, `time_expire`, `is_active`) VALUES
	(1, 1, '123456', '2026-04-13 10:00:00', 0),
	(2, 2, '654321', '2026-04-13 10:00:00', 0),
	(3, 5, '479881', '2026-04-23 06:58:10', 1),
	(4, 6, '297742', '2026-04-23 06:56:57', 0),
	(5, 7, '811008', '2026-04-23 13:51:34', 0),
	(6, 8, '955697', '2026-04-26 04:17:59', 0),
	(7, 9, '515256', '2026-04-27 03:11:25', 1),
	(8, 10, '347422', '2026-04-27 09:09:46', 0),
	(9, 10, '201916', '2026-05-03 02:55:47', 1);

-- Dumping structure for table bk88.product_reviews
CREATE TABLE IF NOT EXISTS `product_reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT '5' COMMENT 'Từ 1 đến 5 sao',
  `comment` text COLLATE utf8mb3_unicode_ci COMMENT 'Nội dung bình luận, có thể để trống',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_review_item` (`product_id`),
  CONSTRAINT `fk_review_item` FOREIGN KEY (`product_id`) REFERENCES `items` (`item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.product_reviews: ~2 rows (approximately)
INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
	(1, 9, 10, 5, 'Sách tốt sách tốt', '2026-05-04 13:55:57', '2026-05-04 13:55:57'),
	(2, 9, 8, 4, 'Sách tạm ổn', '2026-05-04 13:57:44', '2026-05-04 13:57:44');

-- Dumping structure for table bk88.review_admin_replies
CREATE TABLE IF NOT EXISTS `review_admin_replies` (
  `id` int NOT NULL AUTO_INCREMENT,
  `detail_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `reply_content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_reply_detail` (`detail_id`),
  KEY `fk_reply_admin` (`admin_id`),
  CONSTRAINT `fk_reply_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `fk_reply_detail` FOREIGN KEY (`detail_id`) REFERENCES `review_details` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.review_admin_replies: ~0 rows (approximately)

-- Dumping structure for table bk88.review_details
CREATE TABLE IF NOT EXISTS `review_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_detail_review` (`review_id`),
  KEY `fk_detail_user` (`user_id`),
  CONSTRAINT `fk_detail_review` FOREIGN KEY (`review_id`) REFERENCES `product_reviews` (`id`),
  CONSTRAINT `fk_detail_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `review_details_chk_1` CHECK ((`rating` between 1 and 5))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.review_details: ~0 rows (approximately)

-- Dumping structure for table bk88.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` tinyint(1) DEFAULT '0',
  `phone` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Dumping data for table bk88.users: ~10 rows (approximately)
INSERT INTO `users` (`user_id`, `email`, `password`, `role`, `phone`, `is_verified`) VALUES
	(1, 'newmail@example.com', '1', 1, '0909123456', 1),
	(2, 'user@example.com', '1', 0, '0912345678', 1),
	(3, 'test@example.com', '$2y$10$bCcrrIMwvAzNm9CPBd7QF.mvlC53Z1rv5V5JS.17CROJwA1CMU1o.', 0, '0909123456', 1),
	(4, 'test@example.com', '$2y$10$4kPsaF0qN6uyNwsQ9lGVr.5vdG0nW0JLKOA/EajQEHy9QJaP/AXSy', 0, '0909123456', 1),
	(5, '1@gmail.com', '$2y$10$ATPBYZkLnUraXPXIYs5nVeU8ZBqfn3srgpCe77Y7PrO8DOjL/T4QW', 1, '1234567891', 1),
	(6, 'trung.nong7z@gmail.com', '$2y$10$RQfT1Ad7HJSR/xs1DKcex.7rIsHIDoJQtJ3hzU0Vv2eCo17eldJ3W', 0, '1234567890', 1),
	(7, 'theinspirer2004@gmail.com', '$2y$10$u8SKpul00xAo80c27bY/1Om9gVCeRc8YBZFEToupbbf4o8jAegTcS', 0, '12345678', 1),
	(8, 'honatuan2004@gmail.com', '$2y$10$CuGdMneVmEOo8fbx31ppj.NU/3mbTTnjm8qDdoy.A6HWuAplxDoly', 0, '0937980725', 1),
	(9, 'hongocanhtuannoob@gmail.com', '$2y$10$Pssp/..WT6YhbeSadGSEsOPF5gg5Hxs3pvaxz6JSA56yHlV7cuadG', 0, '0937980725', 0),
	(10, 'hongocanhtuan1301@gmail.com', '$2y$10$srN7DyUX5JvRs6ZTUadtGenOq9oXw4VRCR5wRUgs5h7V98peLphO6', 0, '0937980725', 1);

-- Dumping structure for trigger bk88.check_admin_role
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
DELIMITER //
CREATE TRIGGER `check_admin_role` BEFORE INSERT ON `notification_setting` FOR EACH ROW BEGIN
    DECLARE user_role INT;
    SELECT role INTO user_role FROM users WHERE user_id = NEW.admin_id;
    IF user_role <> 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'User is not an admin, cannot create notification setting';
    END IF;
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
