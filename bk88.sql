-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2026 at 11:04 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

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
  `address_id` int(11) NOT NULL,
  `street` varchar(100) DEFAULT NULL,
  `ward` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `id_article` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `time_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `content` text NOT NULL,
  `background` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id_article`, `title`, `description`, `time_modified`, `status`, `content`, `background`) VALUES
(1, 'Bài viết mẫu BK88', 'Giới thiệu', '2026-04-15 09:35:06', 1, 'Nội dung thử nghiệm...', '../../assets/img/mountain.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `id_article` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `text` text NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_edited` tinyint(1) DEFAULT 0,
  `replied` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(107, 1, 5, 'hay', '2026-04-23 12:16:38', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comment_votes`
--

CREATE TABLE `comment_votes` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `vote` enum('like','dislike') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(122, 106, 5, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `item_id` int(11) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_stock` int(11) DEFAULT 0,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `cost_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `item_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_stock`, `description`, `price`, `cost_price`, `item_image`) VALUES
(1, 'Giải tích 1', 88, 'Giáo trình Giải tích 1', 75000.00, 61000.00, '1777112063_gt1.png'),
(2, 'Giải tích 2', 99, 'Giáo trình Giải tích 2', 75000.00, 60000.00, '1777212188_gt2.png'),
(3, 'Đại số tuyến tính', 99, 'Giáo trình Đại số tuyến tính', 85000.00, 70000.00, '1777212218_dstt.png'),
(4, 'Hóa đại cương', 100, 'Giáo trình Hóa đại cương', 100000.00, 85000.00, '1777212252_hdc.png'),
(5, 'Kỹ thuật Lập trình', 99, 'Giáo trình Kỹ thuật Lập trình', 150000.00, 135000.00, '1777212284_ktlt.png'),
(6, 'Cấu trúc dữ liệu & Giải thuật', 100, 'Giáo trình CTDL&GT', 100000.00, 80000.00, '1777212312_ctdlgt.png'),
(7, 'Triết học Mác - Lênin', 100, 'Giáo trình Triết học Mác - Lênin', 85000.00, 70000.00, '1777212345_triethoc.png'),
(8, 'Kinh tế chính trị Mác - Lênin', 100, 'Giáo trình Kinh tế chính trị Mác - Lênin', 72000.00, 60000.00, '1777212383_ktct.png'),
(9, 'Chủ nghĩa Xã hội Khoa học', 100, 'Giáo trình CNXHKH', 77000.00, 60000.00, '1777212448_cnxhkh.png'),
(11, 'Lịch sử Đảng Cộng sản Việt Nam', 0, 'Giáo trình LSĐCSVN', 75000.00, 60000.00, '1777213030_lsd.png'),
(15, 'Tư tưởng Hồ Chí Minh', 98, 'Giáo trình TTHCM', 80000.00, 65000.00, '1777521969_tthcm.png');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `notification_comment_id` int(11) DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `notification_vote_comment_id` int(11) DEFAULT NULL,
  `notification_order_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `user_id`, `notification_comment_id`, `is_read`, `created_at`, `notification_vote_comment_id`, `notification_order_id`) VALUES
(1, 'vote_comment', 1, NULL, 0, '2026-04-17 10:27:50', 1, NULL),
(2, 'vote_comment', 1, NULL, 0, '2026-04-17 10:28:19', 2, NULL),
(3, 'vote_comment', 1, NULL, 0, '2026-04-17 10:28:30', 3, NULL),
(4, 'vote_comment', 1, NULL, 0, '2026-04-17 10:31:44', 4, NULL),
(5, 'comment', 1, 1, 0, '2026-04-17 10:33:39', NULL, NULL),
(6, 'reply_comment', 1, 2, 0, '2026-04-17 10:35:38', NULL, NULL),
(7, 'edit_comment', 1, 3, 0, '2026-04-17 10:37:42', NULL, NULL),
(8, 'comment', 1, 4, 0, '2026-04-19 14:08:47', NULL, NULL),
(9, 'reply_comment', 1, 5, 0, '2026-04-19 14:09:18', NULL, NULL),
(10, 'comment', 1, 6, 0, '2026-04-23 07:34:17', NULL, NULL),
(11, 'vote_comment', 1, NULL, 0, '2026-04-23 07:35:15', 5, NULL),
(12, 'vote_comment', 1, NULL, 0, '2026-04-23 07:35:17', 6, NULL),
(13, 'vote_comment', 1, NULL, 0, '2026-04-23 07:35:19', 7, NULL),
(14, 'vote_comment', 1, NULL, 0, '2026-04-23 07:35:24', 8, NULL),
(15, 'vote_comment', 6, NULL, 0, '2026-04-23 07:37:24', 9, NULL),
(16, 'vote_comment', 6, NULL, 0, '2026-04-23 07:37:28', 10, NULL),
(17, 'vote_comment', 6, NULL, 0, '2026-04-23 07:37:29', 11, NULL),
(18, 'vote_comment', 6, NULL, 0, '2026-04-23 07:37:29', 12, NULL),
(19, 'vote_comment', 6, NULL, 0, '2026-04-23 07:39:33', 13, NULL),
(20, 'vote_comment', 6, NULL, 0, '2026-04-23 07:39:34', 14, NULL),
(21, 'vote_comment', 6, NULL, 0, '2026-04-23 07:41:36', 15, NULL),
(22, 'vote_comment', 6, NULL, 0, '2026-04-23 07:41:44', 16, NULL),
(23, 'vote_comment', 6, NULL, 0, '2026-04-23 07:41:46', 17, NULL),
(24, 'vote_comment', 6, NULL, 0, '2026-04-23 07:41:47', 18, NULL),
(25, 'vote_comment', 6, NULL, 0, '2026-04-23 07:41:56', 19, NULL),
(26, 'vote_comment', 6, NULL, 0, '2026-04-23 07:41:58', 20, NULL),
(27, 'vote_comment', 6, NULL, 0, '2026-04-23 07:42:08', 21, NULL),
(28, 'vote_comment', 6, NULL, 0, '2026-04-23 07:42:53', 22, NULL),
(29, 'vote_comment', 6, NULL, 0, '2026-04-23 07:42:57', 23, NULL),
(30, 'vote_comment', 6, NULL, 0, '2026-04-23 07:43:20', 24, NULL),
(31, 'vote_comment', 6, NULL, 0, '2026-04-23 07:43:21', 25, NULL),
(32, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:39', 26, NULL),
(33, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:40', 27, NULL),
(34, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:42', 28, NULL),
(35, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:43', 29, NULL),
(36, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:44', 30, NULL),
(37, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:47', 31, NULL),
(38, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:48', 32, NULL),
(39, 'vote_comment', 6, NULL, 0, '2026-04-23 07:44:52', 33, NULL),
(40, 'comment', 6, 7, 0, '2026-04-23 07:46:11', NULL, NULL),
(41, 'vote_comment', 6, NULL, 0, '2026-04-23 07:46:18', 34, NULL),
(42, 'vote_comment', 6, NULL, 0, '2026-04-23 07:46:19', 35, NULL),
(43, 'vote_comment', 6, NULL, 0, '2026-04-23 07:46:21', 36, NULL),
(44, 'vote_comment', 6, NULL, 0, '2026-04-23 07:46:22', 37, NULL),
(45, 'vote_comment', 6, NULL, 0, '2026-04-23 07:46:25', 38, NULL),
(46, 'reply_comment', 6, 8, 0, '2026-04-23 07:49:12', NULL, NULL),
(47, 'edit_comment', 6, 9, 0, '2026-04-23 07:53:37', NULL, NULL),
(53, 'vote_comment', 6, NULL, 0, '2026-04-23 09:38:46', 40, NULL),
(54, 'vote_comment', 6, NULL, 0, '2026-04-23 09:38:47', 41, NULL),
(55, 'vote_comment', 6, NULL, 0, '2026-04-23 09:38:47', 42, NULL),
(56, 'vote_comment', 6, NULL, 0, '2026-04-23 09:39:10', 43, NULL),
(57, 'vote_comment', 6, NULL, 0, '2026-04-23 09:40:49', 44, NULL),
(58, 'vote_comment', 6, NULL, 0, '2026-04-23 09:40:51', 45, NULL),
(59, 'vote_comment', 6, NULL, 0, '2026-04-23 09:44:01', 46, NULL),
(60, 'vote_comment', 6, NULL, 0, '2026-04-23 09:44:02', 47, NULL),
(61, 'comment', 6, 14, 0, '2026-04-23 09:47:38', NULL, NULL),
(62, 'reply_comment', 6, 15, 0, '2026-04-23 09:49:24', NULL, NULL),
(63, 'edit_comment', 6, 16, 0, '2026-04-23 09:51:10', NULL, NULL),
(64, 'vote_comment', 5, NULL, 0, '2026-04-23 12:16:33', 48, NULL),
(65, 'comment', 5, 17, 0, '2026-04-23 12:16:38', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `notification_comment`
--

CREATE TABLE `notification_comment` (
  `id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `replied` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(17, 1, 107, 'hay', NULL, '2026-04-23 12:16:38');

-- --------------------------------------------------------

--
-- Table structure for table `notification_order`
--

CREATE TABLE `notification_order` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_status` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification_vote_comment`
--

CREATE TABLE `notification_vote_comment` (
  `id` int(11) NOT NULL,
  `comment_id` int(11) NOT NULL,
  `article_id` int(11) NOT NULL,
  `vote_type` enum('like','dislike') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(48, 106, 1, 'like', '2026-04-23 12:16:33');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(1) DEFAULT 0,
  `is_paid` tinyint(1) DEFAULT 0,
  `shipping_fee` decimal(10,2) NOT NULL DEFAULT 0.00,
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(14, 10, '2026-05-02 15:18:59', 1, 0, 22000.00, NULL),
(15, 10, '2026-05-02 15:19:18', 3, 1, 22000.00, NULL),
(16, 10, '2026-05-02 15:28:22', 3, 1, 22000.00, 'ABC'),
(17, 10, '2026-05-03 08:52:27', 0, 0, 0.00, '');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `detail_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(18, 17, 2, 1, 75000.00);

-- --------------------------------------------------------

--
-- Table structure for table `otp`
--

CREATE TABLE `otp` (
  `otp_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` char(6) NOT NULL,
  `time_expire` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_active` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
  `id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `average_rating` decimal(2,1) DEFAULT 0.0,
  `total_reviews` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_admin_replies`
--

CREATE TABLE `review_admin_replies` (
  `id` int(11) NOT NULL,
  `detail_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `reply_content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review_details`
--

CREATE TABLE `review_details` (
  `id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `content` text NOT NULL,
  `rating` tinyint(4) NOT NULL CHECK (`rating` between 1 and 5),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` tinyint(1) DEFAULT 0,
  `phone` varchar(20) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

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
  ADD KEY `fk_notifications_vote_comment` (`notification_vote_comment_id`);

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
  ADD KEY `fk_review_item` (`item_id`);

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT for table `comment_votes`
--
ALTER TABLE `comment_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=123;

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT for table `notification_comment`
--
ALTER TABLE `notification_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `notification_order`
--
ALTER TABLE `notification_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification_vote_comment`
--
ALTER TABLE `notification_vote_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_admin_replies`
--
ALTER TABLE `review_admin_replies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review_details`
--
ALTER TABLE `review_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `notifications_ibfk_2` FOREIGN KEY (`notification_comment_id`) REFERENCES `notification_comment` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `notification_comment`
--
ALTER TABLE `notification_comment`
  ADD CONSTRAINT `notification_comment_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `articles` (`id_article`),
  ADD CONSTRAINT `notification_comment_ibfk_2` FOREIGN KEY (`comment_id`) REFERENCES `comments` (`id_comment`) ON DELETE CASCADE,
  ADD CONSTRAINT `notification_comment_ibfk_3` FOREIGN KEY (`replied`) REFERENCES `comments` (`replied`);

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
  ADD CONSTRAINT `fk_review_item` FOREIGN KEY (`item_id`) REFERENCES `items` (`item_id`);

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
