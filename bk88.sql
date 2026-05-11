-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 11, 2026 at 06:02 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bk88`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `address_id` int NOT NULL,
  `street` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `ward` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`address_id`, `street`, `ward`, `city`) VALUES
(1, '12 Nguyễn Huệ', 'Phường Bến Nghé', 'TP.HCM'),
(2, '45 Lê Lợi', 'Phường Bến Thành', 'TP.HCM'),
(3, '', '', ''),
(4, '', '', ''),
(5, '', '', ''),
(6, '1/2/13 Đường 5E', 'Phường Bình Hưng Hòa', 'TP.HCM'),
(7, '', '', ''),
(8, '1/2/13 Đường 5E', 'Bình Hưng Hòa', 'TP.HCM');

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id_article` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `time_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `background` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id_article`, `title`, `description`, `time_modified`, `status`, `content`, `background`) VALUES
(1, 'Bài viết mẫu BK88', 'Giới thiệu', '2026-05-04 07:49:10', 1, 'Nội dung thử nghiệm...', '/assets/img/article/article1.png'),
(2, 'Bài viết mới', '', '2026-05-04 07:28:01', 1, '<iframe class=\"ql-video\" frameborder=\"0\" allowfullscreen=\"true\" src=\"https://www.youtube.com/embed/XbGs_qK2PQA?showinfo=0\"></iframe><p class=\"ql-align-center\"><br></p>', 'assets/img/article/article2.png');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int NOT NULL,
  `id_article` int NOT NULL,
  `id_user` int NOT NULL,
  `text` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_edited` tinyint(1) DEFAULT '0',
  `replied` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `comments`
--

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
(108, 1, 5, 'k', '2026-05-04 08:00:28', 0, NULL),
(109, 1, 5, 'eqw', '2026-05-11 15:48:37', 0, NULL),
(110, 1, 5, '5654645656', '2026-05-11 15:49:36', 0, NULL),
(111, 1, 5, 'hahaha', '2026-05-11 15:59:09', 0, NULL),
(112, 1, 5, 'adsadadasdsad', '2026-05-11 16:03:04', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment_votes`
--

CREATE TABLE `comment_votes` (
  `id` int NOT NULL,
  `comment_id` int NOT NULL,
  `user_id` int NOT NULL,
  `vote` enum('like','dislike') COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `comment_votes`
--

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
(122, 106, 5, 'like'),
(123, 110, 5, 'dislike');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `customer_name`, `customer_email`, `subject`, `message`, `status`, `created_at`) VALUES
(1, 'Nguyễn Văn Minh', 'd@l.m', 'Quá xuất sắc', 'Quá mạnh', 0, '2026-05-03 03:11:11'),
(2, 'Pablo Jenkins PhD', 'Kadin46@hotmail.com', 'Dynamic Infrastructure Orchestrator', 'Adipisci vitae non vacuus comparo.', 1, '2026-05-03 03:18:01'),
(32, 'Nguyễn Văn Minh', 'minh@nguyen.com', 'Halo', 'FOR TEST ONLY', 0, '2026-05-11 08:01:53');

-- --------------------------------------------------------

--
-- Table structure for table `contact_info_fields`
--

CREATE TABLE `contact_info_fields` (
  `id` int NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_info_fields`
--

INSERT INTO `contact_info_fields` (`id`, `label`, `value`, `icon`, `sort_order`, `is_active`, `updated_at`) VALUES
(5, 'Bruh', 'Wait for me', '', 1, 0, '2026-05-04 09:58:26'),
(8, 'Địa chỉ', '123 Ngô Quyền', '', 0, 1, '2026-05-04 09:57:28'),
(9, 'Số điện thoại', '19008198', '', 1, 1, '2026-05-04 09:57:46'),
(10, 'Giờ làm việc', 'Thứ 2 - thứ 6, 7h - 16h50', '', 3, 1, '2026-05-04 09:58:22'),
(11, 'Email', 'bk88@hcmut.edu.vn', '', 4, 1, '2026-05-11 08:01:39');

-- --------------------------------------------------------

--
-- Table structure for table `home_featured_products`
--

CREATE TABLE `home_featured_products` (
  `id` int NOT NULL,
  `item_id` int NOT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_featured_products`
--

INSERT INTO `home_featured_products` (`id`, `item_id`, `sort_order`, `is_active`, `updated_at`) VALUES
(1, 1, 1, 1, '2026-05-04 08:11:56'),
(2, 2, 2, 1, '2026-05-04 08:11:56'),
(3, 3, 3, 1, '2026-05-04 08:11:56'),
(4, 4, 4, 1, '2026-05-04 08:11:56'),
(6, 7, 6, 1, '2026-05-11 16:59:10');

-- --------------------------------------------------------

--
-- Table structure for table `home_quotes`
--

CREATE TABLE `home_quotes` (
  `id` int NOT NULL,
  `quote_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_quotes`
--

INSERT INTO `home_quotes` (`id`, `quote_text`, `author`, `image`, `sort_order`, `is_active`, `updated_at`) VALUES
(1, 'Sách là nguồn tri thức vô tận.', 'Nguyễn Văn Minh - Co-founder của BK88', 'avt/nvm.png', 1, 1, '2026-05-04 09:43:04'),
(2, 'Đầu tư vào kiến thức là khoản đầu tư lãi nhất.', 'Hồ Ngọc Anh Tuấn - Co-founder của BK88', 'avt/HNAT.png', 2, 1, '2026-05-04 09:43:10'),
(3, 'Kiến thức dẫn lối con người.', 'Nông Văn Trung - Co-founder của BK88', 'avt/Trung Nông.png', 3, 1, '2026-05-04 09:42:13'),
(4, 'Kiến thức là kết tinh của tạo hóa.', 'Phan Huy Trung - Co-founder của BK88', 'avt/Trung Phan.png', 4, 1, '2026-05-04 09:42:52');

-- --------------------------------------------------------

--
-- Table structure for table `home_reasons`
--

CREATE TABLE `home_reasons` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_reasons`
--

INSERT INTO `home_reasons` (`id`, `title`, `description`, `sort_order`, `is_active`, `updated_at`) VALUES
(1, 'Giáo trình chất lượng', 'Cung cấp các bộ giáo trình được biên soạn và kiểm duyệt kỹ lưỡng bởi các chuyên gia hàng đầu trong ngành.', 1, 1, '2026-05-04 08:11:56'),
(3, 'Hỗ trợ 24/7', 'Đội ngũ hỗ trợ chuyên nghiệp luôn sẵn sàng giải đáp mọi thắc mắc của bạn mọi lúc, mọi nơi.', 2, 1, '2026-05-04 09:45:13'),
(6, 'Lắng nghe', 'Luôn luôn lắng nghe, lâu lâu mới hiểu', 3, 0, '2026-05-11 07:59:15'),
(7, 'Giá cả phải chăng', 'Chúng tôi mang đến giáo trình chất lượng với giá cả tốt nhất', 5, 1, '2026-05-11 17:56:14'),
(8, 'Cập nhật liên tục', 'Chúng tôi luôn luôn cập nhật mới giáo trình để bắt kịp kiến thức mới mỗi ngày.', 6, 1, '2026-05-11 17:56:55');

-- --------------------------------------------------------

--
-- Table structure for table `home_sections`
--

CREATE TABLE `home_sections` (
  `id` int NOT NULL,
  `section_key` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) DEFAULT '1',
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_sections`
--

INSERT INTO `home_sections` (`id`, `section_key`, `title`, `subtitle`, `is_active`, `updated_at`) VALUES
(1, 'quote', 'Quote', NULL, 1, '2026-05-04 08:11:56'),
(2, 'reason', 'Tại sao lại chọn chúng tôi?', 'Những giá trị cốt lõi mà BK88 mang lại cho bạn.', 1, '2026-05-04 09:02:51'),
(3, 'product', 'Một số sản phẩm tiêu biểu', 'Tham khảo một số giáo trình tiêu biểu của chúng tôi', 1, '2026-05-04 08:11:56');

-- --------------------------------------------------------

--
-- Table structure for table `home_settings`
--

CREATE TABLE `home_settings` (
  `id` int NOT NULL,
  `setting_key` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `setting_value` text COLLATE utf8mb4_unicode_ci,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_settings`
--

INSERT INTO `home_settings` (`id`, `setting_key`, `setting_value`, `updated_at`) VALUES
(1, 'site_logo', 'logo88.png', '2026-05-11 17:55:36');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `info_id` int NOT NULL,
  `user_id` int NOT NULL,
  `address_id` int NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `lastname` varchar(50) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`info_id`, `user_id`, `address_id`, `firstname`, `lastname`) VALUES
(1, 1, 1, 'Trung', 'Admin'),
(2, 2, 2, 'Ngọc', 'User'),
(5, 5, 3, 'T', 'N'),
(6, 6, 4, 't', 'n'),
(7, 7, 5, '2', ''),
(8, 8, 6, 'Tuấn', 'Hồ Ngọc Anh'),
(9, 9, 7, 'Tuan', 'Ho Ngoc Anh'),
(10, 10, 8, 'Tuan', 'Ho Ngoc Anh');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `item_id` int NOT NULL,
  `item_name` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `item_stock` int DEFAULT '0',
  `sold_qty` int DEFAULT '0',
  `description` text COLLATE utf8mb3_unicode_ci,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_image` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_stock`, `sold_qty`, `description`, `price`, `cost_price`, `item_image`) VALUES
(1, 'Giải tích 1', 88, 3, 'Giáo trình Giải tích 1', 75000.00, 61000.00, '1777112063_gt1.png'),
(2, 'Giải tích 2', 98, 0, 'Giáo trình Giải tích 2', 75000.00, 60000.00, '1777212188_gt2.png'),
(3, 'Đại số tuyến tính', 97, 2, 'Giáo trình Đại số tuyến tính', 85000.00, 70000.00, '1777212218_dstt.png'),
(4, 'Hóa đại cương', 100, 0, 'Giáo trình Hóa đại cương', 100000.00, 85000.00, '1777212252_hdc.png'),
(5, 'Kỹ thuật Lập trình', 98, 1, 'Giáo trình Kỹ thuật Lập trình', 150000.00, 135000.00, '1777212284_ktlt.png'),
(6, 'Cấu trúc dữ liệu & Giải thuật', 99, 0, 'Giáo trình CTDL&GT', 100000.00, 80000.00, '1777212312_ctdlgt.png'),
(7, 'Triết học Mác - Lênin', 100, 0, 'Giáo trình Triết học Mác - Lênin', 85000.00, 70000.00, '1777212345_triethoc.png'),
(8, 'Kinh tế chính trị Mác - Lênin', 100, 0, 'Giáo trình Kinh tế chính trị Mác - Lênin', 72000.00, 60000.00, '1777212383_ktct.png'),
(9, 'Chủ nghĩa Xã hội Khoa học', 100, 0, 'Giáo trình CNXHKH', 77000.00, 60000.00, '1777212448_cnxhkh.png'),
(11, 'Lịch sử Đảng Cộng sản Việt Nam', 0, 0, 'Giáo trình LSĐCSVN', 75000.00, 60000.00, '1777213030_lsd.png'),
(15, 'Tư tưởng Hồ Chí Minh', 98, 0, 'Giáo trình TTHCM', 80000.00, 65000.00, '1777521969_tthcm.png');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `type` varchar(50) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` int NOT NULL,
  `notification_comment_id` int DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notification_vote_comment_id` int DEFAULT NULL,
  `notification_order_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `notifications`
--

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
(71, 'order', 10, NULL, 1, '2026-05-04 12:53:32', NULL, 5),
(72, 'comment', 5, 19, 0, '2026-05-11 15:48:37', NULL, NULL),
(73, 'comment', 5, 20, 0, '2026-05-11 15:49:36', NULL, NULL),
(74, 'vote_comment', 5, NULL, 0, '2026-05-11 15:49:39', 49, NULL),
(75, 'comment', 5, 21, 0, '2026-05-11 15:59:09', NULL, NULL),
(76, 'comment', 5, 22, 0, '2026-05-11 16:03:04', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_comment`
--

CREATE TABLE `notification_comment` (
  `id` int NOT NULL,
  `article_id` int NOT NULL,
  `comment_id` int NOT NULL,
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `replied` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `notification_comment`
--

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
(18, 1, 108, 'k', NULL, '2026-05-04 08:00:28'),
(19, 1, 109, 'eqw', NULL, '2026-05-11 15:48:37'),
(20, 1, 110, '5654645656', NULL, '2026-05-11 15:49:36'),
(21, 1, 111, 'hahaha', NULL, '2026-05-11 15:59:09'),
(22, 1, 112, 'adsadadasdsad', NULL, '2026-05-11 16:03:04');

-- --------------------------------------------------------

--
-- Table structure for table `notification_order`
--

CREATE TABLE `notification_order` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `order_status` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification_order`
--

INSERT INTO `notification_order` (`id`, `order_id`, `order_status`, `created_at`) VALUES
(1, 18, 'chờ xác nhận', '2026-05-04 03:39:53'),
(2, 19, 'chờ xác nhận', '2026-05-04 06:49:24'),
(3, 20, 'chờ xác nhận', '2026-05-04 08:06:51'),
(4, 21, 'chờ xác nhận', '2026-05-04 08:07:23'),
(5, 22, 'chờ xác nhận', '2026-05-04 12:53:32');

-- --------------------------------------------------------

--
-- Table structure for table `notification_setting`
--

CREATE TABLE `notification_setting` (
  `setting_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT '1',
  `enable_comment` tinyint(1) DEFAULT '1',
  `enable_reply` tinyint(1) DEFAULT '1',
  `enable_edit` tinyint(1) DEFAULT '1',
  `enable_vote` tinyint(1) DEFAULT '1',
  `enable_order` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `notification_setting`
--

INSERT INTO `notification_setting` (`setting_id`, `admin_id`, `is_enabled`, `enable_comment`, `enable_reply`, `enable_edit`, `enable_vote`, `enable_order`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1),
(2, 5, 1, 1, 1, 1, 1, 1);

--
-- Triggers `notification_setting`
--
DELIMITER $$
CREATE TRIGGER `check_admin_role` BEFORE INSERT ON `notification_setting` FOR EACH ROW BEGIN
    DECLARE user_role INT;
    SELECT role INTO user_role FROM users WHERE user_id = NEW.admin_id;
    IF user_role <> 1 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'User is not an admin, cannot create notification setting';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `notification_vote_comment`
--

CREATE TABLE `notification_vote_comment` (
  `id` int NOT NULL,
  `comment_id` int NOT NULL,
  `article_id` int NOT NULL,
  `vote_type` enum('like','dislike') COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `notification_vote_comment`
--

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
(48, 106, 1, 'like', '2026-04-23 12:16:33'),
(49, 110, 1, 'dislike', '2026-05-11 15:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int NOT NULL,
  `user_id` int NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` tinyint(1) DEFAULT '0',
  `is_paid` tinyint(1) DEFAULT '0',
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT '0.00',
  `note` text COLLATE utf8mb3_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `orders`
--

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
(14, 10, '2026-05-02 15:18:59', 4, 0, 22000.00, NULL),
(15, 10, '2026-05-02 15:19:18', 3, 1, 22000.00, NULL),
(16, 10, '2026-05-02 15:28:22', 3, 1, 22000.00, 'ABC'),
(17, 10, '2026-05-03 08:52:27', 0, 0, 0.00, ''),
(18, 10, '2026-05-04 03:39:53', 3, 1, 22000.00, ''),
(19, 10, '2026-05-04 06:49:24', 0, 0, 22000.00, ''),
(20, 10, '2026-05-04 08:06:51', 0, 0, 22000.00, ''),
(21, 10, '2026-05-04 08:07:23', 1, 0, 22000.00, ''),
(22, 10, '2026-05-04 12:53:32', 0, 0, 22000.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int NOT NULL,
  `order_id` int NOT NULL,
  `item_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `order_details`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `otp_id` int NOT NULL,
  `user_id` int NOT NULL,
  `code` char(6) COLLATE utf8mb3_unicode_ci NOT NULL,
  `time_expire` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_active` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `otp`
--

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

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `user_id` int NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT '5' COMMENT 'Từ 1 đến 5 sao',
  `comment` text COLLATE utf8mb3_unicode_ci COMMENT 'Nội dung bình luận, có thể để trống',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 9, 10, 5, 'Sách tốt sách tốt', '2026-05-04 13:55:57', '2026-05-04 13:55:57'),
(2, 9, 8, 4, 'Sách tạm ổn', '2026-05-04 13:57:44', '2026-05-04 13:57:44');

-- --------------------------------------------------------

--
-- Table structure for table `review_admin_replies`
--

CREATE TABLE `review_admin_replies` (
  `id` int NOT NULL,
  `detail_id` int NOT NULL,
  `admin_id` int NOT NULL,
  `reply_content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_details`
--

CREATE TABLE `review_details` (
  `id` int NOT NULL,
  `review_id` int NOT NULL,
  `user_id` int NOT NULL,
  `content` text COLLATE utf8mb3_unicode_ci NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `email` varchar(100) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
  `role` tinyint(1) DEFAULT '0',
  `phone` varchar(20) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT '0',
  `is_banned` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `email`, `password`, `role`, `phone`, `is_verified`, `is_banned`) VALUES
(1, 'newmail@example.com', '1', 1, '0909123456', 1, 0),
(2, 'user@example.com', '1', 0, '0912345678', 1, 0),
(3, 'test@example.com', '$2y$10$bCcrrIMwvAzNm9CPBd7QF.mvlC53Z1rv5V5JS.17CROJwA1CMU1o.', 0, '0909123456', 1, 0),
(4, 'test@example.com', '$2y$10$4kPsaF0qN6uyNwsQ9lGVr.5vdG0nW0JLKOA/EajQEHy9QJaP/AXSy', 0, '0909123456', 1, 0),
(5, '1@gmail.com', '$2y$10$ATPBYZkLnUraXPXIYs5nVeU8ZBqfn3srgpCe77Y7PrO8DOjL/T4QW', 1, '1234567891', 1, 0),
(6, 'trung.nong7z@gmail.com', '$2y$10$RQfT1Ad7HJSR/xs1DKcex.7rIsHIDoJQtJ3hzU0Vv2eCo17eldJ3W', 0, '1234567890', 1, 0),
(7, 'theinspirer2004@gmail.com', '$2y$10$u8SKpul00xAo80c27bY/1Om9gVCeRc8YBZFEToupbbf4o8jAegTcS', 0, '12345678', 1, 0),
(8, 'honatuan2004@gmail.com', '$2y$10$CuGdMneVmEOo8fbx31ppj.NU/3mbTTnjm8qDdoy.A6HWuAplxDoly', 0, '0937980725', 1, 0),
(9, 'hongocanhtuannoob@gmail.com', '$2y$10$Pssp/..WT6YhbeSadGSEsOPF5gg5Hxs3pvaxz6JSA56yHlV7cuadG', 0, '0937980725', 0, 0),
(10, 'hongocanhtuan1301@gmail.com', '$2y$10$srN7DyUX5JvRs6ZTUadtGenOq9oXw4VRCR5wRUgs5h7V98peLphO6', 0, '0937980725', 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`);

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id_article`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`),
  ADD KEY `id_article` (`id_article`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `replied` (`replied`);

--
-- Indexes for table `comment_votes`
--
ALTER TABLE `comment_votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`comment_id`,`user_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indexes for table `contact_info_fields`
--
ALTER TABLE `contact_info_fields`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_featured_products`
--
ALTER TABLE `home_featured_products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uniq_home_featured_item` (`item_id`);

--
-- Indexes for table `home_quotes`
--
ALTER TABLE `home_quotes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_reasons`
--
ALTER TABLE `home_reasons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- Indexes for table `home_settings`
--
ALTER TABLE `home_settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `information`
--
ALTER TABLE `information`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `notifications_ibfk_2` (`notification_comment_id`),
  ADD KEY `fk_notifications_vote_comment` (`notification_vote_comment_id`),
  ADD KEY `notification_order_id` (`notification_order_id`);

--
-- Indexes for table `notification_comment`
--
ALTER TABLE `notification_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `replied` (`replied`),
  ADD KEY `notification_comment_ibfk_2` (`comment_id`);

--
-- Indexes for table `notification_order`
--
ALTER TABLE `notification_order`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification_setting`
--
ALTER TABLE `notification_setting`
  ADD PRIMARY KEY (`setting_id`),
  ADD KEY `fk_admin_user` (`admin_id`);

--
-- Indexes for table `notification_vote_comment`
--
ALTER TABLE `notification_vote_comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `article_id` (`article_id`),
  ADD KEY `notification_vote_comment_ibfk_1` (`comment_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`detail_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `otp`
--
ALTER TABLE `otp`
  ADD PRIMARY KEY (`otp_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_review_item` (`product_id`);

--
-- Indexes for table `review_admin_replies`
--
ALTER TABLE `review_admin_replies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reply_detail` (`detail_id`),
  ADD KEY `fk_reply_admin` (`admin_id`);

--
-- Indexes for table `review_details`
--
ALTER TABLE `review_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_detail_review` (`review_id`),
  ADD KEY `fk_detail_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `address_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `comment_votes`
--
ALTER TABLE `comment_votes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `contact_info_fields`
--
ALTER TABLE `contact_info_fields`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `home_featured_products`
--
ALTER TABLE `home_featured_products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `home_quotes`
--
ALTER TABLE `home_quotes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `home_reasons`
--
ALTER TABLE `home_reasons`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `home_settings`
--
ALTER TABLE `home_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `info_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `notification_comment`
--
ALTER TABLE `notification_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notification_order`
--
ALTER TABLE `notification_order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notification_setting`
--
ALTER TABLE `notification_setting`
  MODIFY `setting_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notification_vote_comment`
--
ALTER TABLE `notification_vote_comment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `otp_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `review_admin_replies`
--
ALTER TABLE `review_admin_replies`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_details`
--
ALTER TABLE `review_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_article`) REFERENCES `articles` (`id_article`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`replied`) REFERENCES `comments` (`id_comment`);

--
-- Constraints for table `home_featured_products`
--
ALTER TABLE `home_featured_products`
  ADD CONSTRAINT `fk_featured_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `information`
--
ALTER TABLE `information`
  ADD CONSTRAINT `information_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `information_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`address_id`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `fk_notifications_vote_comment` FOREIGN KEY (`notification_vote_comment_id`) REFERENCES `notification_vote_comment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`notification_comment_id`) REFERENCES `notification_comment` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `notifications_ibfk_3` FOREIGN KEY (`notification_order_id`) REFERENCES `notification_order` (`id`);

--
-- Constraints for table `notification_comment`
--
ALTER TABLE `notification_comment`
  ADD CONSTRAINT `notification_comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`),
  ADD CONSTRAINT `notification_comment_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id_comment`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_comment_ibfk_3` FOREIGN KEY (`replied`) REFERENCES `comments` (`replied`);

--
-- Constraints for table `notification_setting`
--
ALTER TABLE `notification_setting`
  ADD CONSTRAINT `fk_admin_user` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_vote_comment`
--
ALTER TABLE `notification_vote_comment`
  ADD CONSTRAINT `notification_vote_comment_ibfk_1` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id_comment`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_vote_comment_ibfk_2` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `otp`
--
ALTER TABLE `otp`
  ADD CONSTRAINT `otp_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `fk_review_item` FOREIGN KEY (`product_id`) REFERENCES `items` (`item_id`);

--
-- Constraints for table `review_admin_replies`
--
ALTER TABLE `review_admin_replies`
  ADD CONSTRAINT `fk_reply_admin` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `fk_reply_detail` FOREIGN KEY (`detail_id`) REFERENCES `review_details` (`id`);

--
-- Constraints for table `review_details`
--
ALTER TABLE `review_details`
  ADD CONSTRAINT `fk_detail_review` FOREIGN KEY (`review_id`) REFERENCES `product_reviews` (`id`),
  ADD CONSTRAINT `fk_detail_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
