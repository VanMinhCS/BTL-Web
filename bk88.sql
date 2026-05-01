-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 26, 2026 at 03:03 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

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
(5, '', '', '');

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
(1, 'bk88', 'Giới thiệu', '2026-04-26 12:30:24', 1, '<ol><li data-list=\"ordered\"><span class=\"ql-ui\" contenteditable=\"false\"></span><u>sdsddsds</u></li></ol>', '/assets/img/article/mountain(2).jpg'),
(2, 'Khuyến mãi mùa hè', 'Giảm giá đặc biệt', '2026-04-24 11:21:22', 1, 'Nội dung khuyến mãi chi tiết...', '../../assets/img/summer.jpg'),
(4, 'Mẹo sức khỏe', 'Ăn uống lành mạnh', '2026-04-24 11:21:22', 1, 'Hướng dẫn chế độ ăn uống...', '../../assets/img/health.jpg'),
(5, 'Du lịch Đà Lạt', 'Trải nghiệm núi rừng', '2026-04-24 11:21:22', 1, 'Review chuyến đi Đà Lạt...', '../../assets/img/dalat.jpg'),
(9, 'Ẩm thực Việt', 'Món ngon ba miền', '2026-04-26 12:17:25', 0, 'Giới thiệu các món ăn truyền thống...', '../../assets/img/food.jpg'),
(12, 'Công nghệ AI', 'Ứng dụng trong đời sống', '2026-04-24 11:37:21', 1, 'AI đang thay đổi mọi lĩnh vực...', '../../assets/img/ai.jpg'),
(13, 'Sức khỏe cộng đồng', 'Phòng chống dịch bệnh', '2026-04-24 11:37:21', 1, 'Các biện pháp phòng chống dịch...', '../../assets/img/health2.jpg'),
(14, 'Giáo dục hiện đại', 'Đổi mới phương pháp học', '2026-04-24 11:37:21', 1, 'Ứng dụng công nghệ trong giáo dục...', '../../assets/img/education.jpg'),
(15, 'Âm nhạc trẻ', 'Top hit 2026', '2026-04-24 11:37:21', 1, 'Danh sách bài hát hot nhất...', '../../assets/img/music.jpg'),
(19, 'bk88', 'Giới thiệu', '2026-04-26 12:17:25', 0, '<ol><li data-list=\"ordered\"><span class=\"ql-ui\" co...', '/assets/img/article/mountain(2).jpg'),
(20, 'Khuyến mãi mùa hè', 'Giảm giá đặc biệt', '2026-04-24 11:21:22', 1, 'Nội dung khuyến mãi chi tiết...', '../../assets/img/summer.jpg'),
(21, 'Mẹo sức khỏe', 'Ăn uống lành mạnh', '2026-04-24 11:21:22', 1, 'Hướng dẫn chế độ ăn uống...', '../../assets/img/health.jpg'),
(22, 'Du lịch Đà Lạt', 'Trải nghiệm núi rừng', '2026-04-24 11:21:22', 1, 'Review chuyến đi Đà Lạt...', '../../assets/img/dalat.jpg'),
(23, 'Ẩm thực Việt', 'Món ngon ba miền', '2026-04-24 11:37:21', 1, 'Giới thiệu các món ăn truyền thống...', '../../assets/img/food.jpg'),
(24, 'Thời trang 2026', 'Xu hướng mới', '2026-04-24 11:37:21', 1, 'Phong cách thời trang hiện đại...', '../../assets/img/fashion.jpg'),
(25, 'Du lịch Phú Quốc', 'Trải nghiệm biển đảo', '2026-04-24 11:37:21', 1, 'Review chuyến đi Phú Quốc...', '../../assets/img/phuquoc.jpg'),
(26, 'Công nghệ AI', 'Ứng dụng trong đời sống', '2026-04-24 11:37:21', 1, 'AI đang thay đổi mọi lĩnh vực...', '../../assets/img/ai.jpg'),
(27, 'Sức khỏe cộng đồng', 'Phòng chống dịch bệnh', '2026-04-24 11:37:21', 1, 'Các biện pháp phòng chống dịch...', '../../assets/img/health2.jpg'),
(28, 'Giáo dục hiện đại', 'Đổi mới phương pháp học', '2026-04-24 11:37:21', 1, 'Ứng dụng công nghệ trong giáo dục...', '../../assets/img/education.jpg'),
(29, 'Âm nhạc trẻ', 'Top hit 2026', '2026-04-24 11:37:21', 1, 'Danh sách bài hát hot nhất...', '../../assets/img/music.jpg'),
(30, 'd', 'd', '2026-04-26 12:54:02', 1, '', '/assets/img/article/article30.png'),
(31, 'Bài viết mới', '', '2026-04-26 12:30:51', 0, '', '');

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
(107, 1, 5, 'hay', '2026-04-23 12:16:38', 0, NULL),
(109, 1, 5, 'd', '2026-04-24 13:40:50', 0, NULL),
(116, 1, 5, 'đe', '2026-04-25 10:04:42', 0, NULL),
(117, 1, 5, 'alo', '2026-04-25 10:13:14', 0, NULL),
(119, 1, 5, 'đ', '2026-04-25 10:14:30', 0, 117),
(120, 1, 5, 'd', '2026-04-25 10:14:34', 0, 117),
(121, 1, 5, 'đ', '2026-04-25 10:17:29', 1, NULL),
(122, 1, 5, 'j', '2026-04-25 10:37:37', 0, NULL),
(123, 1, 5, 'j', '2026-04-25 10:37:46', 0, NULL),
(124, 1, 5, 'd', '2026-04-25 10:57:03', 0, NULL),
(125, 1, 5, 'xc', '2026-04-25 11:05:17', 0, 124),
(126, 1, 5, 'đsd', '2026-04-26 06:07:24', 0, NULL),
(127, 1, 5, 'sdsd', '2026-04-26 06:07:26', 0, NULL),
(128, 1, 5, 'sdsd', '2026-04-26 06:07:27', 0, NULL),
(129, 1, 5, 'sdsds', '2026-04-26 06:07:29', 0, NULL),
(130, 1, 5, 'sd', '2026-04-26 06:18:42', 0, NULL),
(131, 1, 5, 'sd', '2026-04-26 06:19:11', 0, NULL),
(132, 1, 5, 'sdsd', '2026-04-26 06:19:13', 0, NULL),
(133, 1, 5, 'sds', '2026-04-26 06:19:14', 0, NULL),
(134, 1, 5, 'sds', '2026-04-26 06:19:15', 0, NULL),
(135, 1, 5, 'd', '2026-04-26 06:19:16', 0, NULL),
(136, 1, 5, 'dsd', '2026-04-26 06:21:09', 0, 2),
(137, 1, 5, 'd', '2026-04-26 09:28:32', 0, NULL),
(138, 1, 5, 'fs', '2026-04-26 09:28:54', 0, NULL),
(139, 1, 5, 'ff', '2026-04-26 09:29:04', 1, 138),
(140, 1, 5, 'f', '2026-04-26 09:29:48', 0, NULL),
(141, 1, 5, 'c', '2026-04-26 09:41:56', 0, NULL),
(142, 1, 5, 'd', '2026-04-26 09:47:23', 0, NULL),
(143, 1, 5, 'd', '2026-04-26 11:24:39', 0, NULL),
(144, 1, 5, 'd', '2026-04-26 11:25:01', 0, NULL),
(145, 1, 5, 'd', '2026-04-26 11:25:40', 0, NULL),
(146, 1, 5, 'đs', '2026-04-26 11:32:59', 0, NULL),
(147, 1, 5, 'd', '2026-04-26 11:33:00', 0, NULL),
(148, 1, 5, 'ds', '2026-04-26 11:33:37', 0, NULL),
(149, 1, 5, 'd', '2026-04-26 11:36:43', 0, NULL),
(150, 1, 5, 'đ', '2026-04-26 11:38:24', 0, 149),
(151, 1, 5, 'd', '2026-04-26 11:38:27', 0, NULL),
(152, 1, 5, 'd', '2026-04-26 11:38:48', 0, NULL),
(153, 1, 5, 'c', '2026-04-26 12:22:47', 0, NULL),
(154, 1, 5, 'đá', '2026-04-26 12:23:21', 0, NULL),
(155, 1, 5, 'ds', '2026-04-26 12:25:57', 0, NULL),
(156, 31, 5, 'd', '2026-04-26 12:26:09', 0, NULL),
(157, 1, 5, 'g', '2026-04-26 12:30:32', 0, NULL),
(158, 30, 5, 'c', '2026-04-26 12:31:27', 0, NULL),
(159, 30, 5, 'dssd', '2026-04-26 12:32:38', 1, 158);

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
(125, 106, 5, 'like'),
(127, 107, 5, 'like'),
(128, 118, 5, 'like'),
(129, 124, 5, 'like'),
(130, 139, 5, 'like'),
(131, 135, 5, 'like'),
(132, 132, 5, 'dislike'),
(133, 133, 5, 'like'),
(134, 134, 5, 'like'),
(135, 131, 5, 'like'),
(136, 142, 5, 'dislike'),
(137, 149, 5, 'like'),
(138, 151, 5, 'like'),
(153, 1, 5, 'like'),
(156, 156, 5, 'like');

-- --------------------------------------------------------

--
-- Table structure for table `information`
--

CREATE TABLE `information` (
  `info_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `payment_method` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `information`
--

INSERT INTO `information` (`info_id`, `user_id`, `address_id`, `firstname`, `lastname`, `payment_method`) VALUES
(1, 1, 1, 'Trung', 'Admin', 1),
(2, 2, 2, 'Ngọc', 'User', 0),
(5, 5, 3, 'T', 'N', 0),
(6, 6, 4, 't', 'n', 0),
(7, 7, 5, '2', '', 0);

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
  `item_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`item_id`, `item_name`, `item_stock`, `description`, `price`, `item_image`) VALUES
(1, 'Laptop Dell', 10, 'Laptop văn phòng', 1500.00, 'dell.jpg'),
(2, 'Chuột Logitech', 50, 'Chuột không dây', 25.00, 'logitech.jpg');

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
  `notification_vote_comment_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `user_id`, `notification_comment_id`, `is_read`, `created_at`, `notification_vote_comment_id`) VALUES
(1, 'vote_comment', 1, NULL, 1, '2026-04-17 10:27:50', 1),
(2, 'vote_comment', 1, NULL, 1, '2026-04-17 10:28:19', 2),
(3, 'vote_comment', 1, NULL, 1, '2026-04-17 10:28:30', 3),
(4, 'vote_comment', 1, NULL, 1, '2026-04-17 10:31:44', 4),
(5, 'comment', 1, 1, 1, '2026-04-17 10:33:39', NULL),
(6, 'reply_comment', 1, 2, 1, '2026-04-17 10:35:38', NULL),
(7, 'edit_comment', 1, 3, 1, '2026-04-17 10:37:42', NULL),
(8, 'comment', 1, 4, 1, '2026-04-19 14:08:47', NULL),
(9, 'reply_comment', 1, 5, 1, '2026-04-19 14:09:18', NULL),
(10, 'comment', 1, 6, 1, '2026-04-23 07:34:17', NULL),
(11, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:15', 5),
(12, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:17', 6),
(13, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:19', 7),
(14, 'vote_comment', 1, NULL, 1, '2026-04-23 07:35:24', 8),
(15, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:24', 9),
(16, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:28', 10),
(17, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:29', 11),
(18, 'vote_comment', 6, NULL, 1, '2026-04-23 07:37:29', 12),
(19, 'vote_comment', 6, NULL, 1, '2026-04-23 07:39:33', 13),
(20, 'vote_comment', 6, NULL, 1, '2026-04-23 07:39:34', 14),
(21, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:36', 15),
(22, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:44', 16),
(23, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:46', 17),
(24, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:47', 18),
(25, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:56', 19),
(26, 'vote_comment', 6, NULL, 1, '2026-04-23 07:41:58', 20),
(27, 'vote_comment', 6, NULL, 1, '2026-04-23 07:42:08', 21),
(28, 'vote_comment', 6, NULL, 1, '2026-04-23 07:42:53', 22),
(29, 'vote_comment', 6, NULL, 1, '2026-04-23 07:42:57', 23),
(30, 'vote_comment', 6, NULL, 1, '2026-04-23 07:43:20', 24),
(31, 'vote_comment', 6, NULL, 1, '2026-04-23 07:43:21', 25),
(32, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:39', 26),
(33, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:40', 27),
(34, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:42', 28),
(35, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:43', 29),
(36, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:44', 30),
(37, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:47', 31),
(38, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:48', 32),
(39, 'vote_comment', 6, NULL, 1, '2026-04-23 07:44:52', 33),
(40, 'comment', 6, 7, 1, '2026-04-23 07:46:11', NULL),
(41, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:18', 34),
(42, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:19', 35),
(43, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:21', 36),
(44, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:22', 37),
(45, 'vote_comment', 6, NULL, 1, '2026-04-23 07:46:25', 38),
(46, 'reply_comment', 6, 8, 1, '2026-04-23 07:49:12', NULL),
(47, 'edit_comment', 6, 9, 1, '2026-04-23 07:53:37', NULL),
(53, 'vote_comment', 6, NULL, 1, '2026-04-23 09:38:46', 40),
(54, 'vote_comment', 6, NULL, 1, '2026-04-23 09:38:47', 41),
(55, 'vote_comment', 6, NULL, 1, '2026-04-23 09:38:47', 42),
(56, 'vote_comment', 6, NULL, 1, '2026-04-23 09:39:10', 43),
(57, 'vote_comment', 6, NULL, 1, '2026-04-23 09:40:49', 44),
(58, 'vote_comment', 6, NULL, 1, '2026-04-23 09:40:51', 45),
(59, 'vote_comment', 6, NULL, 1, '2026-04-23 09:44:01', 46),
(60, 'vote_comment', 6, NULL, 1, '2026-04-23 09:44:02', 47),
(61, 'comment', 6, 14, 1, '2026-04-23 09:47:38', NULL),
(62, 'reply_comment', 6, 15, 1, '2026-04-23 09:49:24', NULL),
(63, 'edit_comment', 6, 16, 1, '2026-04-23 09:51:10', NULL),
(64, 'vote_comment', 5, NULL, 1, '2026-04-23 12:16:33', 48),
(65, 'comment', 5, 17, 1, '2026-04-23 12:16:38', NULL),
(66, 'vote_comment', 5, NULL, 1, '2026-04-24 11:10:22', 49),
(67, 'vote_comment', 5, NULL, 1, '2026-04-24 11:10:23', 50),
(68, 'vote_comment', 5, NULL, 1, '2026-04-24 11:10:25', 51),
(69, 'vote_comment', 5, NULL, 1, '2026-04-24 11:10:28', 52),
(70, 'vote_comment', 5, NULL, 1, '2026-04-24 11:10:30', 53),
(71, 'vote_comment', 5, NULL, 1, '2026-04-24 11:10:35', 54),
(72, 'vote_comment', 5, NULL, 1, '2026-04-24 11:11:07', 55),
(75, 'vote_comment', 5, NULL, 1, '2026-04-24 11:14:22', 56),
(76, 'comment', 5, 20, 1, '2026-04-24 13:40:50', NULL),
(78, 'comment', 1, 1, 1, '2026-04-25 09:51:35', NULL),
(79, 'comment', 1, 2, 1, '2026-04-25 10:00:11', NULL),
(80, 'comment', 1, 2, 1, '2026-04-25 10:01:24', NULL),
(81, 'comment', 5, 21, 1, '2026-04-25 10:04:42', NULL),
(82, 'comment', 5, 22, 1, '2026-04-25 10:13:14', NULL),
(86, 'reply_comment', 5, 25, 1, '2026-04-25 10:14:30', NULL),
(87, 'reply_comment', 5, 26, 1, '2026-04-25 10:14:34', NULL),
(88, 'comment', 5, 27, 1, '2026-04-25 10:14:42', NULL),
(89, 'edit_comment', 5, 28, 1, '2026-04-25 10:17:29', NULL),
(90, 'comment', 5, 29, 1, '2026-04-25 10:37:37', NULL),
(91, 'comment', 5, 30, 1, '2026-04-25 10:37:46', NULL),
(92, 'comment', 5, 31, 1, '2026-04-25 10:57:03', NULL),
(93, 'vote_comment', 5, NULL, 1, '2026-04-25 11:05:13', 58),
(94, 'reply_comment', 5, 32, 1, '2026-04-25 11:05:17', NULL),
(95, 'comment', 5, 33, 1, '2026-04-26 06:07:24', NULL),
(96, 'comment', 5, 34, 1, '2026-04-26 06:07:26', NULL),
(97, 'comment', 5, 35, 1, '2026-04-26 06:07:27', NULL),
(98, 'comment', 5, 36, 1, '2026-04-26 06:07:29', NULL),
(99, 'comment', 5, 37, 1, '2026-04-26 06:18:42', NULL),
(100, 'comment', 5, 38, 1, '2026-04-26 06:19:11', NULL),
(101, 'comment', 5, 39, 1, '2026-04-26 06:19:13', NULL),
(102, 'comment', 5, 40, 1, '2026-04-26 06:19:14', NULL),
(103, 'comment', 5, 41, 1, '2026-04-26 06:19:15', NULL),
(106, 'comment', 5, 44, 1, '2026-04-26 09:28:32', NULL),
(107, 'comment', 5, 45, 1, '2026-04-26 09:28:54', NULL),
(108, 'reply_comment', 5, 46, 1, '2026-04-26 09:28:58', NULL),
(109, 'edit_comment', 5, 47, 1, '2026-04-26 09:29:04', NULL),
(110, 'vote_comment', 5, NULL, 1, '2026-04-26 09:29:08', 59),
(111, 'comment', 5, 48, 1, '2026-04-26 09:29:48', NULL),
(112, 'vote_comment', 5, NULL, 1, '2026-04-26 09:31:09', 60),
(113, 'vote_comment', 5, NULL, 1, '2026-04-26 09:31:11', 61),
(114, 'vote_comment', 5, NULL, 1, '2026-04-26 09:31:12', 62),
(115, 'vote_comment', 5, NULL, 1, '2026-04-26 09:31:12', 63),
(116, 'vote_comment', 5, NULL, 1, '2026-04-26 09:31:15', 64),
(117, 'vote_comment', 5, NULL, 1, '2026-04-26 09:39:32', 65),
(118, 'vote_comment', 5, NULL, 1, '2026-04-26 09:39:33', 66),
(120, 'comment', 5, 50, 1, '2026-04-26 09:47:23', NULL),
(123, 'vote_comment', 5, NULL, 1, '2026-04-26 11:19:23', 69),
(124, 'comment', 5, 51, 1, '2026-04-26 11:24:39', NULL),
(125, 'comment', 5, 52, 1, '2026-04-26 11:25:01', NULL),
(126, 'comment', 5, 53, 1, '2026-04-26 11:25:40', NULL),
(127, 'comment', 5, 54, 1, '2026-04-26 11:32:59', NULL),
(128, 'comment', 5, 55, 1, '2026-04-26 11:33:00', NULL),
(129, 'comment', 5, 56, 1, '2026-04-26 11:33:37', NULL),
(130, 'comment', 5, 57, 1, '2026-04-26 11:36:43', NULL),
(131, 'vote_comment', 5, NULL, 1, '2026-04-26 11:38:15', 70),
(132, 'reply_comment', 5, 58, 1, '2026-04-26 11:38:24', NULL),
(133, 'comment', 5, 59, 1, '2026-04-26 11:38:27', NULL),
(134, 'vote_comment', 5, NULL, 1, '2026-04-26 11:38:30', 71),
(135, 'comment', 5, 60, 1, '2026-04-26 11:38:48', NULL),
(136, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:45', 72),
(137, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:47', 73),
(138, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:51', 74),
(139, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:52', 75),
(140, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:53', 76),
(141, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:56', 77),
(142, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:56', 78),
(143, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:57', 79),
(144, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:57', 80),
(145, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:58', 81),
(146, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:59', 82),
(147, 'vote_comment', 5, NULL, 0, '2026-04-26 12:21:59', 83),
(148, 'vote_comment', 5, NULL, 0, '2026-04-26 12:22:09', 84),
(149, 'vote_comment', 5, NULL, 0, '2026-04-26 12:22:09', 85),
(150, 'vote_comment', 5, NULL, 0, '2026-04-26 12:22:29', 86),
(151, 'vote_comment', 5, NULL, 0, '2026-04-26 12:22:31', 87),
(152, 'comment', 5, 61, 0, '2026-04-26 12:22:47', NULL),
(153, 'comment', 5, 62, 0, '2026-04-26 12:23:21', NULL),
(154, 'comment', 5, 63, 0, '2026-04-26 12:25:57', NULL),
(155, 'comment', 5, 64, 0, '2026-04-26 12:26:09', NULL),
(156, 'vote_comment', 5, NULL, 0, '2026-04-26 12:27:58', 88),
(157, 'vote_comment', 5, NULL, 0, '2026-04-26 12:28:00', 89),
(158, 'vote_comment', 5, NULL, 0, '2026-04-26 12:28:02', 90),
(159, 'vote_comment', 5, NULL, 0, '2026-04-26 12:28:02', 91),
(160, 'vote_comment', 5, NULL, 0, '2026-04-26 12:28:03', 92),
(161, 'comment', 5, 65, 0, '2026-04-26 12:30:33', NULL),
(162, 'comment', 5, 66, 0, '2026-04-26 12:31:27', NULL),
(163, 'reply_comment', 5, 67, 0, '2026-04-26 12:32:27', NULL),
(164, 'edit_comment', 5, 68, 0, '2026-04-26 12:32:38', NULL);

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
(17, 1, 107, 'hay', NULL, '2026-04-23 12:16:38'),
(20, 1, 109, 'd', NULL, '2026-04-24 13:40:50'),
(21, 1, 116, 'đe', NULL, '2026-04-25 10:04:42'),
(22, 1, 117, 'alo', NULL, '2026-04-25 10:13:14'),
(25, 1, 119, 'đ', 117, '2026-04-25 10:14:30'),
(26, 1, 120, 'd', 117, '2026-04-25 10:14:34'),
(27, 1, 121, 'd', NULL, '2026-04-25 10:14:42'),
(28, 1, 121, 'đ', NULL, '2026-04-25 10:17:29'),
(29, 1, 122, 'j', NULL, '2026-04-25 10:37:37'),
(30, 1, 123, 'j', NULL, '2026-04-25 10:37:46'),
(31, 1, 124, 'd', NULL, '2026-04-25 10:57:03'),
(32, 1, 125, 'xc', 124, '2026-04-25 11:05:17'),
(33, 1, 126, 'đsd', NULL, '2026-04-26 06:07:24'),
(34, 1, 127, 'sdsd', NULL, '2026-04-26 06:07:26'),
(35, 1, 128, 'sdsd', NULL, '2026-04-26 06:07:27'),
(36, 1, 129, 'sdsds', NULL, '2026-04-26 06:07:29'),
(37, 1, 130, 'sd', NULL, '2026-04-26 06:18:42'),
(38, 1, 131, 'sd', NULL, '2026-04-26 06:19:11'),
(39, 1, 132, 'sdsd', NULL, '2026-04-26 06:19:13'),
(40, 1, 133, 'sds', NULL, '2026-04-26 06:19:14'),
(41, 1, 134, 'sds', NULL, '2026-04-26 06:19:15'),
(42, 1, 135, 'd', NULL, '2026-04-26 06:19:16'),
(43, 1, 136, 'dsd', 2, '2026-04-26 06:21:09'),
(44, 1, 137, 'd', NULL, '2026-04-26 09:28:32'),
(45, 1, 138, 'fs', NULL, '2026-04-26 09:28:54'),
(46, 1, 139, 'f', 138, '2026-04-26 09:28:58'),
(47, 1, 139, 'ff', 138, '2026-04-26 09:29:04'),
(48, 1, 140, 'f', NULL, '2026-04-26 09:29:48'),
(49, 1, 141, 'c', NULL, '2026-04-26 09:41:56'),
(50, 1, 142, 'd', NULL, '2026-04-26 09:47:23'),
(51, 1, 143, 'd', NULL, '2026-04-26 11:24:39'),
(52, 1, 144, 'd', NULL, '2026-04-26 11:25:01'),
(53, 1, 145, 'd', NULL, '2026-04-26 11:25:40'),
(54, 1, 146, 'đs', NULL, '2026-04-26 11:32:59'),
(55, 1, 147, 'd', NULL, '2026-04-26 11:33:00'),
(56, 1, 148, 'ds', NULL, '2026-04-26 11:33:37'),
(57, 1, 149, 'd', NULL, '2026-04-26 11:36:43'),
(58, 1, 150, 'đ', 149, '2026-04-26 11:38:24'),
(59, 1, 151, 'd', NULL, '2026-04-26 11:38:27'),
(60, 1, 152, 'd', NULL, '2026-04-26 11:38:48'),
(61, 1, 153, 'c', NULL, '2026-04-26 12:22:47'),
(62, 1, 154, 'đá', NULL, '2026-04-26 12:23:21'),
(63, 1, 155, 'ds', NULL, '2026-04-26 12:25:57'),
(64, 31, 156, 'd', NULL, '2026-04-26 12:26:09'),
(65, 1, 157, 'g', NULL, '2026-04-26 12:30:33'),
(66, 30, 158, 'c', NULL, '2026-04-26 12:31:27'),
(67, 30, 159, 'dss', 158, '2026-04-26 12:32:27'),
(68, 30, 159, 'dssd', 158, '2026-04-26 12:32:38');

-- --------------------------------------------------------

--
-- Table structure for table `notification_setting`
--

CREATE TABLE `notification_setting` (
  `setting_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `is_enabled` tinyint(1) NOT NULL DEFAULT 1,
  `enable_comment` tinyint(1) DEFAULT 1,
  `enable_reply` tinyint(1) DEFAULT 1,
  `enable_edit` tinyint(1) DEFAULT 1,
  `enable_vote` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notification_setting`
--

INSERT INTO `notification_setting` (`setting_id`, `admin_id`, `is_enabled`, `enable_comment`, `enable_reply`, `enable_edit`, `enable_vote`) VALUES
(1, 1, 1, 1, 1, 1, 1),
(2, 5, 1, 1, 1, 1, 1);

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
(48, 106, 1, 'like', '2026-04-23 12:16:33'),
(49, 107, 1, 'dislike', '2026-04-24 11:10:22'),
(50, 107, 1, 'like', '2026-04-24 11:10:23'),
(51, 107, 1, 'dislike', '2026-04-24 11:10:25'),
(52, 106, 1, 'like', '2026-04-24 11:10:28'),
(53, 106, 1, 'like', '2026-04-24 11:10:30'),
(54, 107, 1, 'like', '2026-04-24 11:10:35'),
(55, 107, 1, 'like', '2026-04-24 11:11:07'),
(56, 107, 1, 'like', '2026-04-24 11:14:22'),
(58, 124, 1, 'like', '2026-04-25 11:05:13'),
(59, 139, 1, 'like', '2026-04-26 09:29:08'),
(60, 135, 1, 'like', '2026-04-26 09:31:09'),
(61, 132, 1, 'like', '2026-04-26 09:31:11'),
(62, 133, 1, 'like', '2026-04-26 09:31:12'),
(63, 134, 1, 'like', '2026-04-26 09:31:12'),
(64, 131, 1, 'like', '2026-04-26 09:31:15'),
(65, 134, 1, 'dislike', '2026-04-26 09:39:32'),
(66, 132, 1, 'dislike', '2026-04-26 09:39:33'),
(67, 134, 1, 'like', '2026-04-26 09:50:32'),
(68, 142, 1, 'like', '2026-04-26 09:55:41'),
(69, 142, 1, 'dislike', '2026-04-26 11:19:23'),
(70, 149, 1, 'like', '2026-04-26 11:38:15'),
(71, 151, 1, 'like', '2026-04-26 11:38:30'),
(72, 1, 1, 'dislike', '2026-04-26 12:21:45'),
(73, 1, 1, 'dislike', '2026-04-26 12:21:47'),
(74, 1, 1, 'dislike', '2026-04-26 12:21:51'),
(75, 1, 1, 'like', '2026-04-26 12:21:52'),
(76, 1, 1, 'like', '2026-04-26 12:21:53'),
(77, 2, 1, 'dislike', '2026-04-26 12:21:56'),
(78, 2, 1, 'dislike', '2026-04-26 12:21:56'),
(79, 2, 1, 'dislike', '2026-04-26 12:21:57'),
(80, 2, 1, 'dislike', '2026-04-26 12:21:57'),
(81, 2, 1, 'like', '2026-04-26 12:21:58'),
(82, 2, 1, 'like', '2026-04-26 12:21:59'),
(83, 2, 1, 'like', '2026-04-26 12:21:59'),
(84, 1, 1, 'dislike', '2026-04-26 12:22:09'),
(85, 1, 1, 'like', '2026-04-26 12:22:09'),
(86, 1, 1, 'like', '2026-04-26 12:22:29'),
(87, 1, 1, 'like', '2026-04-26 12:22:31'),
(88, 156, 31, 'like', '2026-04-26 12:27:58'),
(89, 156, 31, 'like', '2026-04-26 12:28:00'),
(90, 156, 31, 'like', '2026-04-26 12:28:02'),
(91, 156, 31, 'dislike', '2026-04-26 12:28:02'),
(92, 156, 31, 'like', '2026-04-26 12:28:03');

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
  `payment_method` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `user_id`, `order_date`, `status`, `is_paid`, `payment_method`) VALUES
(1, 1, '2026-04-13 09:30:00', 0, 1, 1),
(2, 2, '2026-04-13 09:40:00', 0, 0, 0);

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
(1, 1, 1, 1, 1500.00),
(2, 2, 2, 2, 25.00);

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
(5, 7, '811008', '2026-04-23 13:51:34', 0);

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
(7, 'theinspirer2004@gmail.com', '$2y$10$u8SKpul00xAo80c27bY/1Om9gVCeRc8YBZFEToupbbf4o8jAegTcS', 0, '12345678', 1);

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
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id_article` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=160;

--
-- AUTO_INCREMENT for table `comment_votes`
--
ALTER TABLE `comment_votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `information`
--
ALTER TABLE `information`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=165;

--
-- AUTO_INCREMENT for table `notification_comment`
--
ALTER TABLE `notification_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- AUTO_INCREMENT for table `notification_setting`
--
ALTER TABLE `notification_setting`
  MODIFY `setting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notification_vote_comment`
--
ALTER TABLE `notification_vote_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `detail_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `otp`
--
ALTER TABLE `otp`
  MODIFY `otp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

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
