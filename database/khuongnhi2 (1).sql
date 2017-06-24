-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1:3306
-- Generation Time: Mar 22, 2017 at 05:47 AM
-- Server version: 5.6.31-log
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `khuongnhi2`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE IF NOT EXISTS `addresses` (
  `id` int(10) NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_postcode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `town_city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `province_id` int(10) unsigned NOT NULL DEFAULT '0',
  `country_id` int(10) unsigned NOT NULL DEFAULT '0',
  `module_id` int(10) unsigned NOT NULL DEFAULT '0',
  `module_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '', '', 'Bình Thạnh', 29, 1, 1, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(2, '', '', 'Quận 9', 29, 1, 2, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(3, '', '', 'Tận Bình', 29, 1, 3, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(4, 'Thủ Đức', '', 'Thủ Đức', 29, 1, 4, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(5, '', '', 'Quận 10', 29, 1, 5, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(6, '', '', 'quận 5', 29, 1, 6, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(7, 'Quận 12', '', '', 29, 1, 7, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(8, '', '', 'Tây Ninh', 53, 1, 8, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(9, '', '', 'Bình Thạnh', 29, 1, 9, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(10, 'Bà Chiểu', '', '', 29, 1, 10, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(11, 'Bình Thạnh', '', 'Bình Thạnh', 29, 1, 11, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(12, '', '', '', 32, 1, 12, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(13, '224H Quang Trung', '', 'Bồng Sơn', 9, 1, 13, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(14, '', '', 'Gò Vấp', 29, 1, 14, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(15, 'Cam Ranh', '', 'Cam Ranh', 32, 1, 15, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(16, '', '', 'Bình Thạnh', 29, 1, 16, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(17, '', '', 'BÌNH THẠNH', 29, 1, 17, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(18, '', '', 'Quận 11', 29, 1, 18, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(19, '', '', 'Phú Thiện', 29, 1, 19, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(20, 'Vũng Tàu', '', 'Vũng Tàu', 2, 1, 20, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(21, '', '', 'Gò Vấp', 29, 1, 21, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(22, '', '', 'Gò Vấp', 29, 1, 22, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(23, '', '', 'Bình Thạnh', 29, 1, 23, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(24, 'Hà Nội', '', '', 24, 1, 24, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(25, '', '', '', 9, 1, 25, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(26, '', '', '', 29, 1, 26, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(27, '', '', 'Nha Trang', 32, 1, 27, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(28, 'Tam Đảo, P5', '', 'Quận 10', 29, 1, 28, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(29, '5 Đinh  Tiên Hoàng, P.5', '', 'Bình Thạnh', 29, 1, 29, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(30, '', '', 'Bình Thạnh', 29, 1, 30, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(31, '', '', '', 21, 1, 31, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(32, '408 Lê Trọng Tấn', '', 'Tân Phú', 29, 1, 32, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(33, '', '', '', 32, 1, 33, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(34, 'Nha Trang', '', 'Nha Trang', 32, 1, 34, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(35, '', '', 'Quận 10', 29, 1, 35, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(36, 'Bến Tre', '', 'Bến Tre', 7, 1, 36, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(37, '140 Trường Sa, P.15', '', 'BÌnh Thạnh', 29, 1, 37, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(38, '203 Ông Ích Khiêm', '', 'Hải Châu', 15, 1, 38, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(39, '', '', 'Bình Thạnh', 29, 1, 39, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(40, 'Quận 7', '', 'Quận 7', 29, 1, 40, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(41, 'An Giang', '', '', 1, 1, 41, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(42, 'Cao Bá Quát', '', 'Nha Trang', 32, 1, 42, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(43, '', '', '', 29, 1, 43, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(44, 'số 5 Đinh Tiên Hoàng, P.5', '', 'Bình Thạnh', 29, 1, 44, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(45, '5 Đinh  Tiên Hoàng, P.5', '', 'Bình Thạnh', 29, 1, 45, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(46, '223 Trương Vĩnh Ký', '', 'Tân Phú', 29, 1, 46, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(47, '', '', 'Bình Thạnh', 29, 1, 47, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(48, 'Gò Vấp', '', 'Gò Vấp', 29, 1, 48, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(49, '', '', '', 32, 1, 49, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(50, 'Diên Khánh', '', '', 32, 1, 50, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(51, 'Chợ Đakao', '', 'Bình Thạnh', 29, 1, 51, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(52, '', '', '', 32, 1, 52, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(53, '5 Đinh  Tiên Hoàng, P.5', '', 'Bình Thạnh', 29, 1, 53, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(54, 'Nha Trang', '', 'Nha Trang', 32, 1, 54, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(55, '', '', 'Gò Vấp', 29, 1, 55, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(56, '', '', 'Gò Vấp', 29, 1, 56, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(57, '', '', 'Gò Vấp', 29, 1, 57, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(58, 'Lê Quang Định', '', 'Q. Bình Thạnh', 29, 1, 58, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(59, '', '', '', 24, 1, 59, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(60, '', '', 'Quận TÂN PHÚ', 29, 1, 60, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(61, 'Chợ Tân Bình', '', 'Tân  Bình', 29, 1, 61, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(62, '408 Lê Trọng Tấn ', '', 'Tân Phú', 29, 1, 62, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(63, '', '', '', 29, 1, 63, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(64, 'Bình Định', '', '', 9, 1, 64, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(65, '5 Đinh  Tiên Hoàng, P.5', '', 'Bình Thạnh', 29, 1, 65, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(66, 'Số 07, Ngõ 95, Chùa Bộc', '', 'Đống Đa', 24, 1, 66, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(67, 'Tân Thới Hiệp', '', 'Quận 12', 29, 1, 67, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(68, 'Gò Vấp', '', 'Gò Vấp', 29, 1, 68, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(69, '33/6', '', 'Gò Vấp', 29, 1, 69, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(70, '', '', 'Bình Thạnh', 29, 1, 70, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(71, '', '', '', 32, 1, 71, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(72, '', '', 'Gò Vấp', 29, 1, 72, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(73, '', '', 'Quận 10', 29, 1, 73, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(74, '5 Đinh  Tiên Hoàng, P.5', '', 'Bình Thạnh', 29, 1, 74, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(75, 'Nha Trang', '', 'Nha Trang', 32, 1, 75, 'App-Company', 0, 0, '2015-08-04 19:48:21', '2015-08-04 19:48:21'),
(94, '', '', '', 29, 1, 76, 'App-Company', 0, 0, '2015-08-07 04:41:07', '2015-08-07 04:42:14'),
(95, '', '', '', 0, 0, 76, 'App-Company', 0, 0, '2015-08-07 04:41:07', '2015-08-07 04:41:07'),
(96, '', '', '', 29, 1, 77, 'App-Company', 0, 0, '2015-08-07 04:42:20', '2015-08-07 04:42:41'),
(97, '', '', '', 0, 0, 77, 'App-Company', 0, 0, '2015-08-07 04:42:20', '2015-08-07 04:42:20'),
(126, 'Tân Bình', '', '', 29, 1, 78, 'App-Company', 0, 0, '2015-08-20 01:32:39', '2015-08-20 01:33:08'),
(127, '', '', '', 0, 0, 78, 'App-Company', 0, 0, '2015-08-20 01:32:39', '2015-08-20 01:32:39'),
(130, 'Bình Dương', '', '', 8, 1, 79, 'App-Company', 0, 0, '2015-08-20 02:00:37', '2015-08-20 02:01:00'),
(131, '', '', '', 0, 0, 79, 'App-Company', 0, 0, '2015-08-20 02:00:37', '2015-08-20 02:00:37');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `company_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `phone` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `fax` varchar(12) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `web` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address_id` int(10) unsigned NOT NULL DEFAULT '0',
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `is_customer` tinyint(1) NOT NULL DEFAULT '0',
  `is_distribute` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `name`, `company_type_id`, `phone`, `fax`, `email`, `web`, `address_id`, `system`, `is_customer`, `is_distribute`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Hiền Bà Chiểu', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-03-24 10:23:59', '2015-03-24 10:23:59'),
(2, 'Liên Bình Triệu', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2014-09-15 10:08:24', '2014-09-15 10:08:24'),
(3, 'Hạnh', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2014-09-15 10:08:34', '2014-09-15 10:08:34'),
(4, 'Thư Thủ Đức', 0, '08-54090909', '', '', '', 0, 0, 1, 0, 0, 0, '2015-04-23 12:31:55', '2015-04-23 12:31:55'),
(5, 'Ái', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-03-26 05:08:40', '2015-03-26 05:08:40'),
(6, 'Hiền Tả', 1, '', '', '', '', 0, 0, 1, 1, 0, 0, '2014-09-29 07:27:09', '2017-03-22 02:29:08'),
(7, 'Thanh Quận 12', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-11 09:44:09', '2015-06-11 09:44:09'),
(8, 'Shop Ngò Rí', 0, '0916933331', '', '', '', 0, 0, 1, 0, 0, 0, '2015-02-03 02:41:04', '2015-02-03 02:41:04'),
(9, 'Út Bà Chiểu', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-04-14 02:32:02', '2015-04-14 02:32:02'),
(10, 'Chị Thu', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-07-29 01:40:05', '2015-07-29 01:40:05'),
(11, 'Chi Loan Bà Chiểu', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-12 08:10:00', '2015-06-12 08:10:00'),
(12, 'Camera', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-03-29 09:14:52', '2015-03-29 09:14:52'),
(13, 'Nhi Bình Định', 0, '0906449559', '', '', '', 0, 0, 1, 0, 0, 0, '2015-03-16 11:32:13', '2015-03-16 11:32:13'),
(14, 'Đại Lý Bình', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-06 02:55:15', '2015-05-06 02:55:15'),
(15, 'Phượng Mai', 0, '0905551447', '', '', '', 0, 0, 1, 0, 0, 0, '2015-02-03 02:40:24', '2015-02-03 02:40:24'),
(16, 'Chi', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-06-05 10:15:11', '2015-06-05 10:15:11'),
(17, 'Lài', 0, '', '', '', '', 0, 0, 0, 1, 0, 0, '2015-05-23 12:18:06', '2015-05-23 12:18:06'),
(18, 'Hồng Chuối', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-22 02:54:58', '2015-07-22 02:54:58'),
(19, 'Trinh DacLak', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-03-16 10:52:56', '2015-03-16 10:52:56'),
(20, 'Hồng Thanh', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-02-03 02:39:50', '2015-02-03 02:39:50'),
(21, 'Lê Mây', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-02-05 08:27:08', '2015-02-05 08:27:08'),
(22, 'Dì 4', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-02-15 03:10:05', '2015-02-15 03:10:05'),
(23, 'Tâm', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-05-19 12:44:46', '2015-05-19 12:44:46'),
(24, 'Phương Hà Nội', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-04-09 13:25:12', '2015-04-09 13:25:12'),
(25, 'Nhi Bình Định', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-03-29 10:20:31', '2015-03-29 10:20:31'),
(26, 'Chị Nga', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-04-28 06:51:48', '2015-04-28 06:51:48'),
(27, 'Mỹ Nha Trang', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-24 04:44:08', '2015-05-24 04:44:08'),
(28, 'Chiến Nuk', 0, '08.39708925', '', '', '', 0, 0, 1, 1, 0, 0, '2015-03-27 11:52:11', '2015-03-27 11:52:11'),
(29, 'MeVaBe Khương Nhi', 0, '35171589', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-01 03:53:02', '2015-05-01 03:53:02'),
(30, 'Khách Hạnh Nhi', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-24 04:43:26', '2015-05-24 04:43:26'),
(31, 'Trinh Gia Lai', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-03-29 10:21:36', '2015-03-29 10:21:36'),
(32, 'Đại Lý Hiền', 0, '0908360147', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-23 12:21:04', '2015-05-23 12:21:04'),
(33, 'Phú', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-05-21 12:02:28', '2015-05-21 12:02:28'),
(34, 'Hạnh Nha Trang', 0, '0918206522', '', '', '', 0, 0, 1, 0, 0, 0, '2015-03-29 10:38:27', '2015-03-29 10:38:27'),
(35, 'Hương', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-02-26 03:49:32', '2015-02-26 03:49:32'),
(36, 'Phục Bến Tre', 0, '0918203217', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-22 04:21:36', '2015-06-22 04:21:36'),
(37, 'Hà', 0, '0988847579', '', '', '', 0, 0, 1, 1, 0, 0, '2015-06-30 11:35:20', '2015-06-30 11:35:20'),
(38, 'TNHH Đá Chàm', 0, '(84-511) 3.8', '(84-511) 3.8', '', '', 0, 0, 1, 0, 0, 0, '2015-05-19 08:03:16', '2015-05-19 08:03:16'),
(39, 'Phương Nguyên Hồng', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-04-11 11:29:28', '2015-04-11 11:29:28'),
(40, 'Anh Kiên Q.7', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-29 13:36:34', '2015-05-29 13:36:34'),
(41, 'Dung An GIang', 0, '0939893218', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-22 04:20:40', '2015-06-22 04:20:40'),
(42, 'Trang Nha Trang', 0, '0987982098', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-29 05:01:41', '2015-05-29 05:01:41'),
(43, 'Là TP', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-19 08:09:13', '2015-05-19 08:09:13'),
(44, 'Kho shop', 0, '08-35171589', '', '', '', 0, 0, 1, 1, 0, 0, '2015-06-30 11:35:52', '2015-06-30 11:35:52'),
(45, 'MUA Shop Khương Nhi', 0, '35171589', '', '', '', 0, 0, 0, 1, 0, 0, '2015-05-23 12:23:52', '2015-05-23 12:23:52'),
(46, 'Phương Tân Phú', 0, '0909102238', '', '', '', 0, 0, 1, 0, 0, 0, '2015-05-22 03:50:30', '2015-05-22 03:50:30'),
(47, 'Hùng', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-05-29 13:03:58', '2015-05-29 13:03:58'),
(48, 'Chị Tú', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-22 02:58:04', '2015-07-22 02:58:04'),
(49, 'CHỊ HƯƠNG ROMANIA', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-30 11:28:07', '2015-06-30 11:28:07'),
(50, 'Chị Châu', 0, '0933264669', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-22 03:00:07', '2015-07-22 03:00:07'),
(51, 'Hồng Đakao', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-12 08:07:55', '2015-06-12 08:07:55'),
(52, 'DUNG XI SON', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-15 12:42:26', '2015-07-15 12:42:26'),
(53, 'Shop mẹ Và Bé Khương Nhi', 0, '35171589', '', '', '', 0, 0, 1, 1, 0, 0, '2015-05-30 11:19:12', '2015-05-30 11:19:12'),
(54, 'Út Nha Trang', 0, '0987979869', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-12 08:05:11', '2015-06-12 08:05:11'),
(55, 'Dung Nguyên Hồng', 0, '', '', '', '', 0, 0, 0, 1, 0, 0, '2015-05-23 12:46:06', '2015-05-23 12:46:06'),
(56, 'NPP Bình', 0, '', '', '', '', 0, 0, 0, 1, 0, 0, '2015-07-04 10:15:15', '2015-07-04 10:15:15'),
(57, 'Chị Anh Thư', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-07-04 10:21:40', '2015-07-04 10:21:40'),
(58, 'TÍ', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-06-12 08:30:57', '2015-06-12 08:30:57'),
(59, 'Hoàn Hà Nội', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-24 11:04:45', '2015-06-24 11:04:45'),
(60, 'Chị Hoa TQ', 0, '', '', '', '', 0, 0, 0, 1, 0, 0, '2015-07-14 09:23:32', '2015-07-14 09:23:32'),
(61, 'Diễm Tân Bình', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-15 12:42:08', '2015-07-15 12:42:08'),
(62, 'Chị Hiền Tân Phú', 0, '0908360147', '', '', '', 0, 0, 1, 1, 0, 0, '2015-05-24 06:49:49', '2015-05-24 06:49:49'),
(63, 'Hằng', 0, '', '', '', '', 0, 0, 1, 1, 0, 0, '2015-05-30 11:31:05', '2015-05-30 11:31:05'),
(64, 'Diệu Bình ĐỊnh', 0, '0986522090', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-12 08:05:39', '2015-06-12 08:05:39'),
(65, 'BÁN SHOP', 0, '35171589', '', '', '', 0, 0, 1, 0, 0, 0, '2015-08-03 03:18:45', '2015-08-03 03:18:45'),
(66, 'Huyền  Hà Nội', 0, '0936956069', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-22 06:23:17', '2015-07-22 06:23:17'),
(67, 'Thanh Sơn', 0, '0917466908', '', '', '', 0, 0, 0, 1, 0, 0, '2015-08-04 10:07:29', '2015-08-04 10:07:29'),
(68, 'Vũ Gò Vấp', 0, '0906855357', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-15 12:41:43', '2015-07-15 12:41:43'),
(69, 'May Khương Nhi', 0, '39858196', '', 'hanhnhi76@yahoo.com', '', 0, 0, 0, 1, 0, 0, '2015-07-22 02:52:36', '2015-07-22 02:52:36'),
(70, 'CHI Hoa Nhi An Đông', 0, '0862719248', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-22 04:19:01', '2015-06-22 04:19:01'),
(71, 'Chiến', 0, '0989197739', '', '', '', 0, 0, 1, 0, 0, 0, '2015-06-22 04:22:52', '2015-06-22 04:22:52'),
(72, 'Chị Linh', 0, '', '', '', '', 0, 0, 0, 1, 0, 0, '2015-07-15 12:39:52', '2015-07-15 12:39:52'),
(73, 'Má Tùng', 0, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-31 03:14:46', '2015-07-31 03:14:46'),
(74, 'MUA SHOP', 0, '35171589', '', '', '', 0, 0, 0, 1, 0, 0, '2015-07-15 12:38:34', '2015-07-15 12:38:34'),
(75, 'Thảo Nha Trang', 0, '0914072366', '', '', '', 0, 0, 1, 0, 0, 0, '2015-07-27 07:50:04', '2015-07-27 07:50:04'),
(76, 'Chi Nhi', 3, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-08-07 11:41:07', '2015-08-07 11:41:41'),
(77, 'Anh Nghĩa', 3, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-08-07 11:42:20', '2015-08-07 11:42:33'),
(78, 'Chị Thủy', 1, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-08-20 08:32:39', '2015-08-20 08:33:12'),
(79, 'Chị Nhung', 1, '', '', '', '', 0, 0, 1, 0, 0, 0, '2015-08-20 09:00:37', '2015-08-20 09:00:46');

--
-- Triggers `companies`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_Company_Address` AFTER INSERT ON `companies`
 FOR EACH ROW BEGIN
				INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
				VALUES (NULL, '', '', '', '0', '0', New.id, 'App-Company', '0', '0', NOW(), NOW());
	  END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_Company_Address` AFTER DELETE ON `companies`
 FOR EACH ROW BEGIN
				DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App-Company';
			END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `company_types`
--

CREATE TABLE IF NOT EXISTS `company_types` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `company_types`
--

INSERT INTO `company_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Công ty', 0, 0, '2017-03-20 03:57:20', '2017-03-20 03:57:20'),
(2, 'Cửa hàng', 0, 0, '2017-03-20 03:57:27', '2017-03-20 03:57:27'),
(3, 'Bán lẻ', 0, 0, '2017-03-20 03:57:35', '2017-03-20 03:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE IF NOT EXISTS `countries` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Việt Nam', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Canada', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(10) NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `module_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `logs`
--

INSERT INTO `logs` (`id`, `user_id`, `module_type`, `content`, `created_at`, `updated_at`) VALUES
(1, 1, 'App-\\Purchaseorder', 'Tạo mới đơn mua hàng số 1', '2017-03-20 07:02:50', '2017-03-20 07:02:50'),
(2, 1, 'App-\\Saleorder', 'Tạo mới đơn hàng số 1', '2017-03-20 07:03:01', '2017-03-20 07:03:01'),
(3, 1, 'App-\\ReturnSaleorder', 'Tạo mới đơn hàng đại lý trả số 1', '2017-03-20 07:03:08', '2017-03-20 07:03:08'),
(4, 1, 'App-\\ReturnPurchaseorder', 'Tạo mới đơn hàng trả nhà cung cấp số 1', '2017-03-20 07:03:12', '2017-03-20 07:03:12'),
(5, 1, 'App-\\Product', 'Tạo mới sản phẩm số 1', '2017-03-20 07:33:52', '2017-03-20 07:33:52'),
(6, 1, 'App-\\ReturnSaleorder', 'Tạo mới đơn hàng đại lý trả số 1', '2017-03-20 07:33:54', '2017-03-20 07:33:54'),
(7, 1, 'App-\\Purchaseorder', 'Tạo mới đơn mua hàng số 1', '2017-03-20 07:38:55', '2017-03-20 07:38:55'),
(8, 1, 'App-ReturnPurchaseorder', 'Tạo mới đơn hàng trả nhà cung cấp số 1', '2017-03-20 08:07:26', '2017-03-20 08:07:26'),
(9, 1, 'App-Purchaseorder', 'Tạo mới đơn mua hàng số 1', '2017-03-20 08:07:39', '2017-03-20 08:07:39'),
(10, 1, 'App-Saleorder', 'Tạo mới đơn hàng số 1', '2017-03-20 08:07:48', '2017-03-20 08:07:48'),
(11, 1, 'App-ReturnSaleorder', 'Tạo mới đơn hàng đại lý trả số 1', '2017-03-20 08:07:59', '2017-03-20 08:07:59'),
(12, 1, 'App-Product', 'Tạo mới sản phẩm số 1', '2017-03-20 08:08:04', '2017-03-20 08:08:04'),
(13, 1, 'App-Product', 'Tạo mới sản phẩm số 1', '2017-03-22 02:28:19', '2017-03-22 02:28:19'),
(14, 1, 'App-Product', 'Tạo mới sản phẩm số 1', '2017-03-22 02:45:38', '2017-03-22 02:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE IF NOT EXISTS `menus` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `icon_class` varchar(50) COLLATE utf8_unicode_ci DEFAULT 'fa fa-th-large',
  `link` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `order_no` int(10) unsigned NOT NULL DEFAULT '0',
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `name`, `icon_class`, `link`, `order_no`, `parent_id`, `active`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'CRM', 'fa fa-university', '', 1, 0, 1, 0, 0, '0000-00-00 00:00:00', '2015-07-14 03:54:09'),
(2, 'Công ty', 'fa fa-university', 'companies', 1, 1, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(3, 'Liên hệ', 'fa fa-envelope-o', 'contacts', 2, 1, 0, 0, 0, '0000-00-00 00:00:00', '2017-03-21 02:21:57'),
(4, 'Giao tiếp', 'fa fa-wechat', 'comunications', 3, 1, 0, 0, 0, '0000-00-00 00:00:00', '2017-03-21 02:28:29'),
(5, 'Tài liệu', 'fa fa-file', 'files', 4, 1, 0, 0, 0, '0000-00-00 00:00:00', '2017-03-21 02:28:33'),
(6, 'Công nợ', 'fa fa-usd', '', 5, 0, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(7, 'Tài khoản', 'fa fa-credit-card', 'accounts', 5, 6, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(8, 'Công nợ NCC', 'fa fa-calculator', 'receipts/distribute', 6, 6, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(9, 'Doanh thu', 'fa fa-usd', 'revenues', 8, 6, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(10, 'Kho', 'fa fa-cubes', '', 9, 0, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(11, 'Sản phẩm', 'fa fa-cube', 'products', 9, 10, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(12, 'Đại lý trả', 'fa fa-undo', 'returnsaleorders', 10, 10, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(13, 'Đơn hàng', 'fa fa-file-text-o', 'saleorders', 11, 10, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(14, 'Mua hàng', 'fa fa-cart-plus', 'purchaseorders', 12, 10, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(15, 'Trả hàng NCC', 'fa fa-undo', 'returnpurchaseorders', 13, 10, 1, 0, 0, '0000-00-00 00:00:00', '2017-03-21 01:49:44'),
(16, 'Công nợ KH', 'fi fi-016', 'receipts/customer', 7, 6, 1, 0, 0, '2015-07-14 03:54:03', '2017-03-21 01:49:44');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `m_products`
--

CREATE TABLE IF NOT EXISTS `m_products` (
  `id` int(10) NOT NULL,
  `module_type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `module_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `oum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `origin_price` double NOT NULL DEFAULT '0',
  `sell_price` double NOT NULL DEFAULT '0',
  `specification` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `invest` double NOT NULL DEFAULT '0',
  `m_product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `m_product_id_so` int(10) unsigned NOT NULL DEFAULT '0',
  `amount_interest` double NOT NULL DEFAULT '0',
  `quantity` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `order` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers `m_products`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_Mproduct_Productstock` AFTER INSERT ON `m_products`
 FOR EACH ROW BEGIN
					DECLARE status_po INT;
					IF(NEW.module_type = 'App-Purchaseorder') THEN
						SET status_po = (SELECT `status` from `purchaseorders` where `id`=New.module_id);
						IF(status_po=1) THEN
							INSERT INTO `product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
							VALUES (NULL, NEW.id, NEW.product_id, NEW.quantity*NEW.specification, '0', '0', NOW(), NOW());
						ELSE
							INSERT INTO `product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
							VALUES (NULL, NEW.id, NEW.product_id, '0', '0', '0', NOW(), NOW());
						END IF;
					END IF;
					
					IF(NEW.module_type = 'in_stock') THEN
						INSERT INTO `product_stocks` (`id`, `m_product_id`, `product_id`, `in_stock`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
						VALUES (NULL, NEW.id, NEW.product_id, NEW.quantity*NEW.specification, '0', '0', NOW(), NOW());
					END IF;
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_Mproduct_Productstock` AFTER DELETE ON `m_products`
 FOR EACH ROW BEGIN
					DELETE  FROM `product_stocks` WHERE `m_product_id`=OLD.id;
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_Mproduct_Order` AFTER UPDATE ON `m_products`
 FOR EACH ROW BEGIN
				IF NEW.module_type = 'App-Purchaseorder' THEN
				
					UPDATE `purchaseorders` o
					INNER JOIN
					(
					SELECT `module_id`, SUM(`invest`) sum_amount
					FROM `m_products`
					WHERE `module_type` = 'App-Purchaseorder'
					GROUP BY `module_id`
					) i ON o.id = i.module_id
					SET o.sum_amount = i.sum_amount
					WHERE o.id = NEW.module_id
					AND o.status = 1;
				END IF; 
				IF NEW.module_type = 'App-ReturnPurchaseorder' THEN
				
					UPDATE `return_purchaseorders` o
					INNER JOIN
					(
					SELECT `module_id`, SUM(`invest`) sum_amount
					FROM `m_products`
					WHERE `module_type` = 'App-ReturnPurchaseorder'
					GROUP BY `module_id`
					) i ON o.id = i.module_id
					SET o.sum_amount = i.sum_amount
					WHERE o.id = NEW.module_id
					AND o.status = 1;
				END IF; 
				IF NEW.module_type = 'App-Saleorder' THEN
				
					UPDATE `saleorders` o
					INNER JOIN
					(
					SELECT `module_id`, SUM(`amount`) sum_amount
					FROM `m_products`
					WHERE `module_type` = 'App-Saleorder'
					GROUP BY `module_id`
					) i ON o.id = i.module_id
					SET o.sum_amount = i.sum_amount
					WHERE o.id = NEW.module_id
					AND o.status = 1;
				END IF; 
				IF NEW.module_type = 'App-ReturnSaleorder' THEN
				
					UPDATE `return_saleorders` o
					INNER JOIN
					(
					SELECT `module_id`, SUM(`amount`) sum_amount
					FROM `m_products`
					WHERE `module_type` = 'App-ReturnSaleorder'
					GROUP BY `module_id`
					) i ON o.id = i.module_id
					SET o.sum_amount = i.sum_amount
					WHERE o.id = NEW.module_id
					AND o.status = 1;
				END IF; 
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_Mproduct_Order_Before` BEFORE UPDATE ON `m_products`
 FOR EACH ROW BEGIN
					IF(NEW.specification <> OLD.specification OR NEW.quantity <> OLD.quantity OR NEW.origin_price <> OLD.origin_price OR NEW.sell_price <> OLD.sell_price) THEN
						SET NEW.amount = NEW.specification * NEW.quantity * NEW.sell_price;
						SET NEW.invest = NEW.specification * NEW.quantity * NEW.origin_price;
					END IF;
				END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `oums`
--

CREATE TABLE IF NOT EXISTS `oums` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `oums`
--

INSERT INTO `oums` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Miếng', 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Cái', 0, 0, '2017-03-20 03:42:01', '2017-03-20 03:42:01'),
(3, 'Ri', 0, 0, '2017-03-20 03:44:02', '2017-03-20 03:44:02'),
(4, 'Chục', 0, 0, '2017-03-20 03:47:04', '2017-03-20 03:47:04'),
(5, 'Cuộn', 0, 0, '2017-03-20 03:47:29', '2017-03-20 03:47:29'),
(6, 'Bịch', 0, 0, '2017-03-20 03:47:44', '2017-03-20 03:47:44'),
(7, 'Bộ', 0, 0, '2017-03-20 03:47:58', '2017-03-20 03:47:58'),
(8, 'Hộp', 0, 0, '2017-03-20 03:48:11', '2017-03-20 03:48:11'),
(9, 'Chai', 0, 0, '2017-03-20 03:48:23', '2017-03-20 03:48:23'),
(10, 'Vĩ', 0, 0, '2017-03-20 03:48:30', '2017-03-20 03:48:30'),
(11, 'Cục', 0, 0, '2017-03-20 03:48:45', '2017-03-20 03:48:45'),
(12, 'Lốc', 0, 0, '2017-03-20 03:49:05', '2017-03-20 03:49:05'),
(13, 'Đôi', 0, 0, '2017-03-22 02:30:07', '2017-03-22 02:30:07');

-- --------------------------------------------------------

--
-- Table structure for table `paids`
--

CREATE TABLE IF NOT EXISTS `paids` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `hinh_thuc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `type_paid` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum_paid` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Triggers `paids`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_Paid_Receipt_Month` AFTER INSERT ON `paids`
 FOR EACH ROW BEGIN
					IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt=NEW.type_paid and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
						INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), NEW.type_paid, '0', NEW.sum_paid, '0', '0', NOW(), NOW(),NEW.company_id);
					ELSE
						UPDATE `receipt_months` SET 
						`paid`=`paid` + (NEW.sum_paid),
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE `month` = MONTH(NEW.date)
						AND `year` = YEAR(NEW.date)
						AND `type_receipt` = NEW.type_paid
						AND `company_id` = NEW.company_id;
					END IF;
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_Paid_Receipt_Month` AFTER DELETE ON `paids`
 FOR EACH ROW BEGIN
					UPDATE `receipt_months` SET 
						`paid`=`paid` - (OLD.sum_paid),
						`con_lai`= `sum_amount`+`no_cu`- `paid`
						WHERE `month` = MONTH(OLD.date)
						AND `year` = YEAR(OLD.date)
						AND `type_receipt` = OLD.type_paid
						AND `company_id` = OLD.company_id;
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_Paid_Receipt_Month` AFTER UPDATE ON `paids`
 FOR EACH ROW BEGIN
					UPDATE `receipt_months` SET 
					`paid`=`paid` + (NEW.sum_paid - OLD.sum_paid),
					`con_lai`= `sum_amount`+`no_cu`- `paid`
					WHERE `month` = MONTH(NEW.date)
					AND `year` = YEAR(NEW.date)
					AND `type_receipt` = NEW.type_paid
					AND `company_id` = NEW.company_id;
				END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pdf_templates`
--

CREATE TABLE IF NOT EXISTS `pdf_templates` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `oriental` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `pdf_templates`
--

INSERT INTO `pdf_templates` (`id`, `name`, `template`, `created_by`, `updated_by`, `created_at`, `updated_at`, `oriental`) VALUES
(1, 'Danh sách công ty', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Danh S&aacute;ch Đại L&yacute; Trả</strong></span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:19:19', '2017-03-21 03:39:27', 'potrait'),
(2, 'Danh sách sản phẩm', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Danh S&aacute;ch Sản Phẩm</strong></span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n\n<p>&nbsp;</p>\n', 0, 0, '2015-07-22 02:22:28', '2017-03-21 03:42:52', 'landscape'),
(3, 'Đơn trả nhà cung cấp', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:36px"><strong>Đơn&nbsp;Trả&nbsp;H&agrave;ng&nbsp;Số {{$id}}</strong></span><br />\n<span style="font-size:22px"><strong>Ng&agrave;y: {{$date}}</strong></span></p>\n\n<p><span style="font-size:20px"><strong>T&ecirc;n nh&agrave; cung cấp:</strong> {{$company_name}} - <strong>ĐC:</strong> {{$address}} - <strong>ĐT:</strong> {{$phone}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%">&nbsp;</td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Nợ cũ</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Toa mới</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Tổng cộng</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$no_cu}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$toa_moi}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$tong_cong}}</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người nhận h&agrave;ng</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người thu tiền</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người lập</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Trưởng đơn vị</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><br />\n			<br />\n			<br />\n			<br />\n			<span style="font-size:16px"><strong>Phan Thị Khuyến Hạnh</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n', 0, 0, '2015-07-22 02:36:03', '2017-03-21 04:06:02', 'potrait'),
(4, 'Đơn mua hàng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:36px"><strong>Đơn Mua H&agrave;ng Số {{$id}}</strong></span><br />\n<span style="font-size:22px"><strong>Ng&agrave;y: {{$date}}</strong></span></p>\n\n<p><span style="font-size:22px"><strong>T&ecirc;n nh&agrave; cung cấp:</strong> {{$company_name}} - <strong>ĐC:</strong> {{$address}} - <strong>ĐT:</strong> {{$phone}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%">&nbsp;</td>\n			<td style="text-align:center; width:25%"><span style="font-size:20px"><strong>Nợ cũ</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:20px"><strong>Toa mới</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:20px"><strong>Tổng cộng</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><span style="font-size:20px"><strong>{{$no_cu}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:20px"><strong>{{$toa_moi}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:20px"><strong>{{$tong_cong}}</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người nhận h&agrave;ng</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người thu tiền</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người lập</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Trưởng đơn vị</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><br />\n			<br />\n			<br />\n			<br />\n			<span style="font-size:16px"><strong>Phan Thị Khuyến Hạnh</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n', 0, 0, '2015-07-22 02:36:27', '2017-03-21 04:05:52', 'potrait'),
(5, 'Đơn hàng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:36px"><strong>Đơn H&agrave;ng {{$id}}</strong></span><br />\n<span style="font-size:22px"><strong>Ng&agrave;y: {{$date}}</strong></span></p>\n\n<p><span style="font-size:20px"><strong>T&ecirc;n nh&agrave; cung cấp:</strong> {{$company_name}} - <strong>ĐC:</strong> {{$address}} - <strong>ĐT:</strong> {{$phone}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%">&nbsp;</td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Nợ cũ</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Toa mới</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Tổng cộng</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$no_cu}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$toa_moi}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$tong_cong}}</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người nhận h&agrave;ng</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người thu tiền</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người lập</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Trưởng đơn vị</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><br />\n			<br />\n			<br />\n			<br />\n			<span style="font-size:16px"><strong>Phan Thị Khuyến Hạnh</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n', 0, 0, '2015-07-22 02:36:43', '2017-03-21 04:05:36', 'potrait'),
(6, 'Đơn hàng đại lý trả', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:36px"><strong>Đơn H&agrave;ng Đại L&yacute; Trả&nbsp;{{$id}}</strong></span><br />\n<span style="font-size:22px"><strong>Ng&agrave;y: {{$date}}</strong></span></p>\n\n<p><span style="font-size:20px"><strong>T&ecirc;n nh&agrave; cung cấp:</strong> {{$company_name}} - <strong>ĐC:</strong> {{$address}} - <strong>ĐT:</strong> {{$phone}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%">&nbsp;</td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Nợ cũ</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Toa mới</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:22px"><strong>Tổng cộng</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$no_cu}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$toa_moi}}</strong></span></td>\n			<td style="text-align:center"><span style="font-size:22px"><strong>{{$tong_cong}}</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<div style="text-align: center;">&nbsp;</div>\n\n<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người nhận h&agrave;ng</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người thu tiền</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Người lập</strong></span></td>\n			<td style="text-align:center; width:25%"><span style="font-size:16px"><strong>Trưởng đơn vị</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n			<td style="text-align:center"><span style="font-size:16px"><strong>(K&yacute;, họ t&ecirc;n)</strong></span></td>\n		</tr>\n		<tr>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center">&nbsp;</td>\n			<td style="text-align:center"><br />\n			<br />\n			<br />\n			<br />\n			<span style="font-size:16px"><strong>Phan Thị Khuyến Hạnh</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n', 0, 0, '2015-07-22 02:37:01', '2017-03-21 04:05:45', 'potrait'),
(7, 'Danh sách đại lý trả', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Danh S&aacute;ch Đại L&yacute; Trả</strong></span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:37:52', '2017-03-21 03:40:40', 'potrait'),
(8, 'Danh sách đơn hàng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Danh S&aacute;ch Đơn H&agrave;ng</strong></span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:38:01', '2017-03-21 03:41:13', 'potrait'),
(9, 'Danh sách mua hàng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Danh S&aacute;ch Mua&nbsp;H&agrave;ng</strong></span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:38:13', '2017-03-21 03:41:30', 'potrait'),
(10, 'Danh sách trả NCC', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Danh S&aacute;ch Trả H&agrave;ng NCC</strong></span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:38:21', '2017-03-21 03:43:17', 'potrait'),
(11, 'Công nợ NCC', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>C&ocirc;ng nợ&nbsp;nh&agrave; cung cấp {{$company_name}}</strong><br />\nTh&aacute;ng {{$month}} Năm {{$year}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:50:13', '2017-03-21 03:05:37', 'potrait'),
(12, 'Công nợ NCC tháng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">C&ocirc;ng nợ&nbsp;nh&agrave; cung cấp&nbsp;th&aacute;ng {{$month}} năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:50:45', '2017-03-21 03:38:27', 'potrait'),
(13, 'Công nợ NCC năm', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">C&ocirc;ng nợ&nbsp;nh&agrave; cung cấp năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:50:52', '2017-03-21 03:05:44', 'potrait'),
(14, 'Công nợ KH năm', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">C&ocirc;ng nợ&nbsp;kh&aacute;ch h&agrave;ng&nbsp;năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:51:05', '2017-03-21 03:05:16', 'potrait'),
(15, 'Công nợ KH tháng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">C&ocirc;ng nợ&nbsp;kh&aacute;ch h&agrave;ng&nbsp;th&aacute;ng {{$month}} năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:51:09', '2017-03-21 03:05:26', 'potrait'),
(16, 'Công nợ KH', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>C&ocirc;ng nợ&nbsp;kh&aacute;ch h&agrave;ng&nbsp;{{$company_name}}</strong><br />\nTh&aacute;ng {{$month}} Năm {{$year}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:51:14', '2017-03-21 03:03:27', 'potrait'),
(17, 'Doanh thu KH', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Doanh thu kh&aacute;ch h&agrave;ng&nbsp;{{$company_name}}</strong><br />\nTh&aacute;ng {{$month}} Năm {{$year}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:51:44', '2017-03-21 04:05:06', 'potrait'),
(18, 'Doanh thu KH tháng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">Doanh số&nbsp;nh&agrave; cung cấp&nbsp;th&aacute;ng {{$month}} năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:51:50', '2017-03-21 04:05:19', 'potrait'),
(19, 'Doanh thu KH năm', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">Doanh thu kh&aacute;ch h&agrave;ng&nbsp;năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:51:56', '2017-03-21 04:05:12', 'potrait'),
(20, 'Doanh số nhân viên', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Doanh số nh&acirc;n vi&ecirc;n&nbsp;{{$user_name}}</strong><br />\nTh&aacute;ng {{$month}} Năm {{$year}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:52:08', '2017-03-21 04:04:50', 'potrait'),
(21, 'Doanh số sản phẩm', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">Doanh số sản phẩm&nbsp;th&aacute;ng {{$month}} năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '2015-07-22 02:52:15', '2017-03-21 04:04:58', 'potrait'),
(22, 'Doanh số NCC', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><span style="font-size:28px"><strong>Doanh số nh&agrave; cung cấp&nbsp;{{$company_name}}</strong><br />\nTh&aacute;ng {{$month}} Năm {{$year}}</span></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '0000-00-00 00:00:00', '2017-03-21 04:00:23', 'potrait'),
(23, 'Doanh số NCC tháng', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">Doanh số&nbsp;nh&agrave; cung cấp&nbsp;th&aacute;ng {{$month}} năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '0000-00-00 00:00:00', '2017-03-21 04:04:41', 'potrait'),
(24, 'Doanh số NCC năm', '<table border="0" cellpadding="0" cellspacing="0" style="width:100%">\n	<tbody>\n		<tr>\n			<td style="height:151px; text-align:center; width:311px"><span style="font-size:20px"><img alt="" src="http://khuongnhi2.local.com/upload/4a18242a939a3fbece423be4cb6306b2.png" style="height:180px; width:180px" /></span></td>\n			<td style="vertical-align:baseline"><span style="font-size:24px"><strong>C&Ocirc;NG TY TNHH ANVY DIGITAL</strong></span><br />\n			<span style="font-size:20px">MST: 0312030987<br />\n			ĐC: 62C NGUY&Ecirc;N HỒNG, P11, B&Igrave;NH THẠNH, TP.HCM<br />\n			ĐT: <strong>(</strong><strong>08) 3516 0147</strong><br />\n			Li&ecirc;n hệ trực tiếp:&nbsp;<strong>KHƯƠNG NHI&nbsp;0903 681 447</strong><br />\n			Chăm s&oacute;c kh&aacute;ch h&agrave;ng:&nbsp;<strong>091 88 44 179</strong></span></td>\n		</tr>\n	</tbody>\n</table>\n\n<p style="text-align:center"><strong><span style="font-size:28px">Doanh số nh&agrave; cung cấp&nbsp;năm {{$year}}</span></strong></p>\n\n<p style="text-align:center"><span style="font-size:26px">{{$table_list}}</span></p>\n', 0, 0, '0000-00-00 00:00:00', '2017-03-21 04:04:31', 'potrait');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `display_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'create-purchaseorders', 'Tạo đơn mua hàng', 'Tạo đơn mua hàng', '2015-08-12 08:18:12', '2015-08-12 08:18:12'),
(2, 'create-saleorders', 'Tạo đơn hàng', 'Tạo đơn hàng', '2015-08-12 08:18:12', '2015-08-12 08:18:12'),
(3, 'create-returnpurchaseorders', 'Tạo đơn hàng trả NCC', 'Tạo đơn hàng trả NCC', '2015-08-12 08:18:12', '2015-08-12 08:18:12'),
(4, 'create-returnsaleorders', 'Tạo đơn hàng đại lý trả', 'Tạo đơn hàng đại lý trả', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(5, 'complete-purchaseorders', 'Hoàn thành đơn mua hàng', 'Hoàn thành đơn mua hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(6, 'complete-saleorders', 'Hoàn thành đơn hàng', 'Hoàn thành đơn hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(7, 'complete-returnpurchaseorders', 'Hoàn thành đơn hàng trả NCC', 'Hoàn thành đơn hàng trả NCC', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(8, 'complete-returnsaleorders', 'Hoàn thành đơn hàng đại lý trả', 'Hoàn thành đơn hàng đại lý trả', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(9, 'edit-purchaseorders', 'Cập nhật đơn mua hàng', 'Cập nhật đơn mua hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(10, 'edit-saleorders', 'Cập nhật đơn hàng', 'Cập nhật đơn hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(11, 'edit-returnpurchaseorders', 'Cập nhật đơn hàng trả NCC', 'Cập nhật đơn hàng trả NCC', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(12, 'edit-returnsaleorders', 'Cập nhật đơn hàng đại lý trả', 'Cập nhật đơn hàng đại lý trả', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(13, 'view-purchaseorders', 'Xem đơn mua hàng', 'Xem đơn mua hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(14, 'view-saleorders', 'Xem đơn hàng', 'Xem đơn hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(15, 'view-returnpurchaseorders', 'Xem đơn hàng trả NCC', 'Xem đơn hàng trả NCC', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(16, 'view-returnsaleorders', 'Xem đơn hàng đại lý trả', 'Xem đơn hàng đại lý trả', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(17, 'delete-purchaseorders', 'Xóa đơn mua hàng', 'Xóa đơn mua hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(18, 'delete-saleorders', 'Xóa đơn hàng', 'Xóa đơn hàng', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(19, 'delete-returnpurchaseorders', 'Xóa đơn hàng trả NCC', 'Xóa đơn hàng trả NCC', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(20, 'delete-returnsaleorders', 'Xóa đơn hàng đại lý trả', 'Xóa đơn hàng đại lý trả', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(21, 'create-products', 'Tạo sản phẩm', 'Tạo sản phẩm', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(22, 'delete-products', 'Xóa sản phẩm', 'Xóa sản phẩm', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(23, 'sellprice-products', 'Thêm giá bán sản phẩm', 'Thêm giá bán sản phẩm', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(24, 'view-products', 'Xem sản phẩm', 'Xem sản phẩm', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(25, 'edit-products', 'Cập nhật sản phẩm', 'Cập nhật sản phẩm', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(26, 'create-companies', 'Tạo công ty', 'Tạo công ty', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(27, 'delete-companies', 'Xóa công ty', 'Xóa công ty', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(28, 'view-companies', 'Xem công ty', 'Xem công ty', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(29, 'edit-companies', 'Cập nhật công ty', 'Cập nhật công ty', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(30, 'view-settings', 'Truy cập bảng điều khiển', 'Truy cập bảng điều khiển', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(31, 'view-receipts', 'Truy cập công nợ', 'Truy cập công nợ', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(32, 'view-revenues', 'Truy cập doanh thu', 'Truy cập doanh thu', '2015-08-12 08:18:13', '2015-08-12 08:18:13'),
(33, 'view-historys', 'Truy cập lịch sử', 'Truy cập lịch sử', '2015-08-12 08:18:13', '2015-08-12 08:18:13');

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `permission_role`
--

INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(10, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(1, 2),
(2, 2),
(3, 2),
(4, 2),
(9, 2),
(10, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(10) NOT NULL,
  `sku` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_type` int(10) unsigned NOT NULL DEFAULT '0',
  `check_in_stock` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `sku`, `name`, `product_type`, `check_in_stock`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, '', '', 0, 0, 0, 1, 0, '2017-03-22 02:45:38', '2017-03-22 02:45:38');

-- --------------------------------------------------------

--
-- Table structure for table `product_details`
--

CREATE TABLE IF NOT EXISTS `product_details` (
  `id` int(10) NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oum_id` int(10) unsigned NOT NULL DEFAULT '0',
  `specification` int(10) unsigned NOT NULL DEFAULT '1',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `in_stock` double unsigned NOT NULL DEFAULT '0',
  `invest` double unsigned NOT NULL DEFAULT '0',
  `origin_price` double unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE IF NOT EXISTS `product_options` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_child`
--

CREATE TABLE IF NOT EXISTS `product_option_child` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `parent_option_id` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_option_details`
--

CREATE TABLE IF NOT EXISTS `product_option_details` (
  `id` int(10) NOT NULL,
  `option_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE IF NOT EXISTS `product_stocks` (
  `id` int(10) NOT NULL,
  `m_product_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL DEFAULT '0',
  `in_stock` int(11) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_types`
--

CREATE TABLE IF NOT EXISTS `product_types` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `product_types`
--

INSERT INTO `product_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Quần áo', 0, 0, '2015-06-10 01:10:34', '2015-06-10 01:10:34'),
(2, 'Đồ dùng', 0, 0, '2015-06-10 01:10:45', '2015-06-10 01:10:45');

-- --------------------------------------------------------

--
-- Table structure for table `provinces`
--

CREATE TABLE IF NOT EXISTS `provinces` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `country_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `country_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'An Giang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Bà Rịa - Vũng Tàu', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Bắc Giang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Bắc Kạn', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Bạc Liêu', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'Bắc Ninh', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(7, 'Bến Tre', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(8, 'Bình Dương', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(9, 'Bình Định', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(10, 'Bình Phước', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(11, 'Bình Thuận', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 'Cà Mau', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(13, 'Cần Thơ', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(14, 'Cao Bằng', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(15, 'Đà Nẵng', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(16, 'Đắk Lắk', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(17, 'Đắk Nông', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(18, 'Điện Biên', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(19, 'Đồng Nai', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(20, 'Đồng Tháp', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(21, 'Gia Lai', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(22, 'Hà Giang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(23, 'Hà Nam', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(24, 'Hà Nội', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(25, 'Hà Tĩnh', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(26, 'Hải Dương', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(27, 'Hải Phòng', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(28, 'Hậu Giang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(29, 'Hồ Chí Minh', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(30, 'Hòa Bình', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(31, 'Hưng Yên', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(32, 'Khánh Hòa', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(33, 'Kiên Giang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(34, 'Kon Tum', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(35, 'Lai Châu', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(36, 'Lâm Đồng', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(37, 'Lạng Sơn', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(38, 'Lào Cai', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(39, 'Long An', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(40, 'Nam Định', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(41, 'Nghệ An', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(42, 'Ninh Bình', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(43, 'Ninh Thuận', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(44, 'Phú Thọ', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(45, 'Phú Yên', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(46, 'Quảng Bình', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(47, 'Quảng Nam', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(48, 'Quảng Ngãi', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(49, 'Quảng Ninh', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(50, 'Quảng Trị', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(51, 'Sóc Trăng', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(52, 'Sơn La', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(53, 'Tây Ninh', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(54, 'Thái Bình', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(55, 'Thái Nguyên', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(56, 'Thanh Hóa', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(57, 'Thừa Thiên Huế', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(58, 'Tiền Giang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(59, 'Trà Vinh', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(60, 'Tuyên Quang', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(61, 'Vĩnh Long', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(62, 'Vĩnh Phúc', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(63, 'Yên Bái', 1, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(64, 'Alberta', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(65, 'British Columbia', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(66, 'Manitoba', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(67, 'New Brunswick', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(68, 'Newfoundland and Labrador', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(69, 'Northwest Territories', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(70, 'Nova Scotia', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(71, 'Nunavut', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(72, 'Ontario', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(73, 'Prince Edward Island', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(74, 'Québec', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(75, 'Saskatchewan', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(76, 'Yukon', 2, 0, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorders`
--

CREATE TABLE IF NOT EXISTS `purchaseorders` (
  `id` int(10) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `address_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum_amount` double NOT NULL DEFAULT '0',
  `sum_invest` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `purchaseorders`
--

INSERT INTO `purchaseorders` (`id`, `company_id`, `company_name`, `user_id`, `status`, `date`, `address_id`, `company_phone`, `company_email`, `sum_amount`, `sum_invest`, `locked`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, '', 0, 0, '2017-03-20 15:07:39', 0, '', '', 0, 0, 0, 1, 0, '2017-03-20 08:07:39', '2017-03-20 08:07:39');

--
-- Triggers `purchaseorders`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_PO_Address` AFTER INSERT ON `purchaseorders`
 FOR EACH ROW BEGIN
					INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
					VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App-Purchaseorder', '0', '0', NOW(), NOW());

				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_PO_Address` AFTER DELETE ON `purchaseorders`
 FOR EACH ROW BEGIN
					DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App-Purchaseorder';
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_PO_Receipt_Month` AFTER UPDATE ON `purchaseorders`
 FOR EACH ROW BEGIN
					IF(NEW.status =1 AND OLD.status =0) THEN
						IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='distribute'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
							INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'distribute', NEW.sum_amount, '0', '0', NEW.sum_amount, NOW(), NOW(),NEW.company_id);
						ELSE

							UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` + NEW.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(NEW.date)
							AND `year` = YEAR(NEW.date)
							AND `type_receipt` = 'distribute'
							AND `company_id` = NEW.company_id;

						END IF;
					END IF;
					IF(NEW.status =0 AND OLD.status =1) THEN
						UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` - OLD.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(OLD.date)
							AND `year` = YEAR(OLD.date)
							AND `type_receipt` = 'distribute'
							AND `company_id` = OLD.company_id;
					END IF;
				END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `receipts`
--

CREATE TABLE IF NOT EXISTS `receipts` (
  `id` int(10) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `module_id` int(10) unsigned NOT NULL DEFAULT '0',
  `date_paid` datetime NOT NULL,
  `type_paid_id` int(10) unsigned NOT NULL DEFAULT '0',
  `amount` double NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_months`
--

CREATE TABLE IF NOT EXISTS `receipt_months` (
  `id` int(10) NOT NULL,
  `month` int(10) unsigned NOT NULL DEFAULT '0',
  `year` int(10) unsigned NOT NULL DEFAULT '0',
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `type_receipt` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum_amount` double NOT NULL DEFAULT '0',
  `paid` double NOT NULL DEFAULT '0',
  `no_cu` double NOT NULL DEFAULT '0',
  `con_lai` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_purchaseorders`
--

CREATE TABLE IF NOT EXISTS `return_purchaseorders` (
  `id` int(10) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `address_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum_amount` double NOT NULL DEFAULT '0',
  `sum_invest` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `return_purchaseorders`
--

INSERT INTO `return_purchaseorders` (`id`, `company_id`, `company_name`, `user_id`, `status`, `date`, `address_id`, `company_phone`, `company_email`, `sum_amount`, `sum_invest`, `locked`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, '', 0, 0, '2017-03-20 15:07:26', 0, '', '', 0, 0, 0, 1, 0, '2017-03-20 08:07:26', '2017-03-20 08:07:26');

--
-- Triggers `return_purchaseorders`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_RPO_Address` AFTER INSERT ON `return_purchaseorders`
 FOR EACH ROW BEGIN
					INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
					VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App-ReturnPurchaseorder', '0', '0', NOW(), NOW());
					
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_RPO_Address` AFTER DELETE ON `return_purchaseorders`
 FOR EACH ROW BEGIN
					DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App-ReturnPurchaseorder';
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_RPO_Receipt_Month` AFTER UPDATE ON `return_purchaseorders`
 FOR EACH ROW BEGIN
					IF(NEW.status =1 AND OLD.status =0) THEN
						IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='distribute'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
							INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'distribute', NEW.sum_amount, '0', '0', '0', NOW(), NOW(),NEW.company_id);
						ELSE

							UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` - NEW.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(NEW.date)
							AND `year` = YEAR(NEW.date)
							AND `type_receipt` = 'distribute'
							AND `company_id` = NEW.company_id;

						END IF;
					END IF;
					IF(NEW.status =0 AND OLD.status =1) THEN
						UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` + OLD.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(OLD.date)
							AND `year` = YEAR(OLD.date)
							AND `type_receipt` = 'distribute'
							AND `company_id` = OLD.company_id;
					END IF;
				END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `return_saleorders`
--

CREATE TABLE IF NOT EXISTS `return_saleorders` (
  `id` int(10) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `address_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum_amount` double NOT NULL DEFAULT '0',
  `sum_invest` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `return_saleorders`
--

INSERT INTO `return_saleorders` (`id`, `company_id`, `company_name`, `user_id`, `status`, `date`, `address_id`, `company_phone`, `company_email`, `sum_amount`, `sum_invest`, `locked`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, '', 0, 0, '2017-03-20 15:07:59', 0, '', '', 0, 0, 0, 1, 0, '2017-03-20 08:07:59', '2017-03-20 08:07:59');

--
-- Triggers `return_saleorders`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_RSO_Address` AFTER INSERT ON `return_saleorders`
 FOR EACH ROW BEGIN
					INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
					VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App-ReturnSaleorder', '0', '0', NOW(), NOW());
					
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_RSO_Address` AFTER DELETE ON `return_saleorders`
 FOR EACH ROW BEGIN
					DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App-ReturnSaleorder';
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_RSO_Receipt_Month` AFTER UPDATE ON `return_saleorders`
 FOR EACH ROW BEGIN
					IF(NEW.status =1 AND OLD.status =0) THEN
						IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='customer'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
							INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'customer', NEW.sum_amount, '0', '0', '0', NOW(), NOW(),NEW.company_id);
						ELSE

							UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` - NEW.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(NEW.date)
							AND `year` = YEAR(NEW.date)
							AND `type_receipt` = 'customer'
							AND `company_id` = NEW.company_id;

						END IF;
					END IF;
					IF(NEW.status =0 AND OLD.status =1) THEN
						UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` + OLD.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(OLD.date)
							AND `year` = YEAR(OLD.date)
							AND `type_receipt` = 'customer'
							AND `company_id` = OLD.company_id;
					END IF;
				END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `revenue_others`
--

CREATE TABLE IF NOT EXISTS `revenue_others` (
  `id` int(10) NOT NULL,
  `date` datetime NOT NULL,
  `ly_do` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `sum_amount` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `main` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `display_name`, `description`, `main`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Quản trị web', 'Toàn quyền trên hệ thống', 1, '2015-08-12 08:18:12', '2015-08-12 08:18:12'),
(2, 'user', 'Nhân viên', 'User chỉ được thực thi những quyền chỉ định', 1, '2015-08-12 08:18:12', '2015-08-12 08:18:12');

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`user_id`, `role_id`) VALUES
(1, 1),
(2, 2),
(3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `saleorders`
--

CREATE TABLE IF NOT EXISTS `saleorders` (
  `id` int(10) NOT NULL,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `date` datetime NOT NULL,
  `address_id` int(10) unsigned NOT NULL DEFAULT '0',
  `company_phone` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `company_email` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `sum_amount` double NOT NULL DEFAULT '0',
  `sum_invest` double NOT NULL DEFAULT '0',
  `locked` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `saleorders`
--

INSERT INTO `saleorders` (`id`, `company_id`, `company_name`, `user_id`, `status`, `date`, `address_id`, `company_phone`, `company_email`, `sum_amount`, `sum_invest`, `locked`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 0, '', 0, 0, '2017-03-20 15:07:48', 0, '', '', 0, 0, 0, 1, 0, '2017-03-20 08:07:48', '2017-03-20 08:07:48');

--
-- Triggers `saleorders`
--
DELIMITER $$
CREATE TRIGGER `tr_Create_SO_Address` AFTER INSERT ON `saleorders`
 FOR EACH ROW BEGIN
					INSERT INTO `addresses` (`id`, `address`, `zip_postcode`, `town_city`, `province_id`, `country_id`, `module_id`, `module_type`, `created_by`, `updated_by`, `created_at`, `updated_at`) 
					VALUES (NULL, '', '', '', '0', '0', NEW.id, 'App-Saleorder', '0', '0', NOW(), NOW());
					
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Delete_SO_Address` AFTER DELETE ON `saleorders`
 FOR EACH ROW BEGIN
					DELETE  FROM `addresses` WHERE `module_id`=OLD.id and `module_type` = 'App-Saleorder';
				END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `tr_Update_SO_Receipt_Month` AFTER UPDATE ON `saleorders`
 FOR EACH ROW BEGIN
					IF(NEW.status =1 AND OLD.status =0) THEN
						IF(SELECT EXISTS(SELECT 1 FROM receipt_months WHERE month = MONTH(NEW.date) and year = YEAR(NEW.date) and type_receipt='customer'  and `company_id`=NEW.company_id and NEW.company_id > 0 LIMIT 1)=0) THEN
							INSERT INTO `receipt_months` (`id`, `month`, `year`, `type_receipt`, `sum_amount`, `paid`, `no_cu`, `con_lai`, `created_at`, `updated_at`,`company_id`) VALUES (NULL, MONTH(NEW.date), YEAR(NEW.date), 'customer', NEW.sum_amount, '0', '0', NEW.sum_amount, NOW(), NOW(),NEW.company_id);
						ELSE

							UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` + NEW.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(NEW.date)
							AND `year` = YEAR(NEW.date)
							AND `type_receipt` = 'customer'
							AND `company_id` = NEW.company_id;

						END IF;
					END IF;
					IF(NEW.status =0 AND OLD.status =1) THEN
						UPDATE `receipt_months` SET 
							`sum_amount`=`sum_amount` - OLD.sum_amount,
							`con_lai`= `sum_amount`+`no_cu`- `paid`
							WHERE  `month` = MONTH(OLD.date)
							AND `year` = YEAR(OLD.date)
							AND `type_receipt` = 'customer'
							AND `company_id` = OLD.company_id;
					END IF;
				END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `sell_prices`
--

CREATE TABLE IF NOT EXISTS `sell_prices` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `price` double unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `m_product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `specification`
--

CREATE TABLE IF NOT EXISTS `specification` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ton_dau_thangs`
--

CREATE TABLE IF NOT EXISTS `ton_dau_thangs` (
  `m_product_id` int(10) NOT NULL,
  `month` int(10) unsigned NOT NULL,
  `year` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `type_paids`
--

CREATE TABLE IF NOT EXISTS `type_paids` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_type_id` int(10) unsigned NOT NULL DEFAULT '0',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `admin` tinyint(1) NOT NULL DEFAULT '1',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `primary_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#4EA0CF',
  `menu_color` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#383f48'
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `user_type_id`, `email`, `password`, `confirmation_code`, `confirmed`, `admin`, `remember_token`, `created_at`, `updated_at`, `primary_color`, `menu_color`) VALUES
(1, 'Admin User', 0, 'admin@admin.com', '$2y$10$tlWzkwLNa0YB4Z/mUUKrh.UuBYn/ePfBK2atHUESPdZN7yx.IcnyO', '5d677724fa035e156282a83224413280', 1, 1, 'Pc004wzO7tOTrvhSrsfl6WUn5RMDyhtTTkYdjspD14gefpPF5NREZEqF0skj', '2015-08-04 20:01:35', '2017-03-21 19:45:28', '#4EA0CF', '#383F48'),
(2, 'Test User', 0, 'user@user.com', '$2y$10$/90Wk6L7eI/HOi6Ni74Upu5WweDk6YVXLesc.6HJGMCDkYFgCozAq', '770e31c0f994bc2eb5d5618aa7fcf8e3', 1, 1, NULL, '2015-08-04 20:01:35', '2015-08-04 20:01:35', '#4EA0CF', '#383f48'),
(3, 'Lang', 1, 'tuanminh0703@gmail.com', '$2y$10$O6eM7sRizpcOIgu0td/QGeuW3PmrHKkzO24arpG8YnPIIBkFMvsHa', '', 1, 1, 'RgBmhYt39zmRbwpCizDVmpauESscwBrPV5cT03OfDtOgXkNrWyPvEJetKEpw', '2015-08-05 03:39:53', '2015-09-09 03:17:34', '#4EA0CF', '#383f48');

-- --------------------------------------------------------

--
-- Table structure for table `user_types`
--

CREATE TABLE IF NOT EXISTS `user_types` (
  `id` int(10) NOT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `created_by` int(11) NOT NULL DEFAULT '0',
  `updated_by` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `user_types`
--

INSERT INTO `user_types` (`id`, `name`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'admin', 0, 0, '2015-08-05 03:39:12', '2015-08-05 03:39:12'),
(2, 'user', 0, 0, '2015-08-05 03:39:23', '2015-08-05 03:39:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_types`
--
ALTER TABLE `company_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_parent_id_index` (`parent_id`);

--
-- Indexes for table `m_products`
--
ALTER TABLE `m_products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oums`
--
ALTER TABLE `oums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paids`
--
ALTER TABLE `paids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pdf_templates`
--
ALTER TABLE `pdf_templates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_unique` (`name`);

--
-- Indexes for table `permission_role`
--
ALTER TABLE `permission_role`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `permission_role_role_id_foreign` (`role_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_details`
--
ALTER TABLE `product_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_option_child`
--
ALTER TABLE `product_option_child`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_option_details`
--
ALTER TABLE `product_option_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_types`
--
ALTER TABLE `product_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipts`
--
ALTER TABLE `receipts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt_months`
--
ALTER TABLE `receipt_months`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_purchaseorders`
--
ALTER TABLE `return_purchaseorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_saleorders`
--
ALTER TABLE `return_saleorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `revenue_others`
--
ALTER TABLE `revenue_others`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_unique` (`name`);

--
-- Indexes for table `role_user`
--
ALTER TABLE `role_user`
  ADD PRIMARY KEY (`user_id`,`role_id`),
  ADD KEY `role_user_role_id_foreign` (`role_id`);

--
-- Indexes for table `saleorders`
--
ALTER TABLE `saleorders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sell_prices`
--
ALTER TABLE `sell_prices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `specification`
--
ALTER TABLE `specification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ton_dau_thangs`
--
ALTER TABLE `ton_dau_thangs`
  ADD PRIMARY KEY (`m_product_id`,`month`,`year`);

--
-- Indexes for table `type_paids`
--
ALTER TABLE `type_paids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_types`
--
ALTER TABLE `user_types`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=132;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=80;
--
-- AUTO_INCREMENT for table `company_types`
--
ALTER TABLE `company_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `m_products`
--
ALTER TABLE `m_products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `oums`
--
ALTER TABLE `oums`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `paids`
--
ALTER TABLE `paids`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `pdf_templates`
--
ALTER TABLE `pdf_templates`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=34;
--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `product_details`
--
ALTER TABLE `product_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_option_child`
--
ALTER TABLE `product_option_child`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_option_details`
--
ALTER TABLE `product_option_details`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `product_types`
--
ALTER TABLE `product_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=77;
--
-- AUTO_INCREMENT for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `receipts`
--
ALTER TABLE `receipts`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `receipt_months`
--
ALTER TABLE `receipt_months`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `return_purchaseorders`
--
ALTER TABLE `return_purchaseorders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `return_saleorders`
--
ALTER TABLE `return_saleorders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `revenue_others`
--
ALTER TABLE `revenue_others`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `saleorders`
--
ALTER TABLE `saleorders`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `sell_prices`
--
ALTER TABLE `sell_prices`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `specification`
--
ALTER TABLE `specification`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `type_paids`
--
ALTER TABLE `type_paids`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `user_types`
--
ALTER TABLE `user_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
