-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 08 يونيو 2025 الساعة 19:28
-- إصدار الخادم: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- بنية الجدول `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `blood_inventory`
--

CREATE TABLE `blood_inventory` (
  `id` int(11) NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `donor_name` varchar(255) DEFAULT NULL,
  `donation_date` date NOT NULL,
  `expiry_date` date NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `blood_requests`
--

CREATE TABLE `blood_requests` (
  `id` int(11) NOT NULL,
  `hospital_name` varchar(255) NOT NULL,
  `contact_person` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `quantity` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `blood_requests`
--

INSERT INTO `blood_requests` (`id`, `hospital_name`, `contact_person`, `phone`, `blood_type`, `quantity`, `notes`, `request_date`, `status`) VALUES
(1, 'xbbx', 'bxbx', 'bxbx', 'A-', 555, '', '2025-06-08 17:43:43', 'approved'),
(2, 'xbbx', 'bxbx', 'bxbx', 'A-', 555, '', '2025-06-08 17:45:35', 'approved'),
(3, 'xbbx', 'bxbx', 'bxbx', 'A-', 555, '', '2025-06-08 17:45:43', 'rejected'),
(4, 'xbbx', 'bxbx', 'bxbx', 'A-', 555, '', '2025-06-08 17:50:02', 'approved'),
(5, 'mm', 'nn', 'jm', 'O+', 2147483647, '', '2025-06-08 18:55:02', 'pending');

-- --------------------------------------------------------

--
-- بنية الجدول `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `blood_type` varchar(5) DEFAULT NULL,
  `appointment` datetime DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Scheduled',
  `donation_date` date NOT NULL,
  `governorate` varchar(100) DEFAULT NULL,
  `location_name` varchar(255) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `amount` int(11) DEFAULT NULL,
  `donation_type` varchar(100) DEFAULT NULL,
  `item_description` text DEFAULT NULL,
  `payment_method` varchar(100) DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `donations`
--

INSERT INTO `donations` (`id`, `user_id`, `name`, `blood_type`, `appointment`, `status`, `donation_date`, `governorate`, `location_name`, `quantity`, `amount`, `donation_type`, `item_description`, `payment_method`, `points`, `created_at`, `image`) VALUES
(10, 33, NULL, 'A+', NULL, 'Scheduled', '2025-04-12', NULL, NULL, NULL, 2222, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(11, 33, NULL, 'A-', NULL, 'Scheduled', '2025-04-12', NULL, NULL, NULL, 22, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(12, 33, NULL, 'A-', NULL, 'Scheduled', '2025-04-12', NULL, NULL, NULL, 200, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(13, 33, NULL, 'A+', NULL, 'Scheduled', '2025-04-12', NULL, NULL, NULL, 9, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(14, 34, NULL, 'A-', NULL, 'Scheduled', '2025-04-12', NULL, NULL, NULL, 2000, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(16, 32, NULL, 'A+', NULL, 'Completed', '2025-04-13', NULL, NULL, NULL, 100, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(17, 32, NULL, 'A-', NULL, 'Completed', '2025-04-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(18, 32, NULL, 'A-', NULL, 'Completed', '2025-04-23', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(19, 32, NULL, 'A-', NULL, 'Completed', '2025-04-14', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(20, 32, NULL, 'A+', NULL, 'Completed', '2025-04-08', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(21, 32, NULL, 'A-', NULL, 'Completed', '2025-04-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-13 15:07:06', NULL),
(22, 32, NULL, NULL, NULL, 'completed', '0000-00-00', NULL, NULL, NULL, 100, 'تبرع مالي', '', 'بطاقة فيزا', 10, '2025-04-13 15:07:18', NULL),
(23, 32, NULL, NULL, NULL, 'completed', '0000-00-00', NULL, NULL, NULL, 100, 'تبرع مالي', '', 'بطاقة فيزا', 10, '2025-04-13 15:50:44', NULL),
(24, 36, NULL, 'A+', NULL, 'Completed', '2025-04-09', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-13 22:13:23', NULL),
(25, 37, NULL, 'A+', NULL, 'Scheduled', '2025-04-15', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-15 11:50:49', NULL),
(26, 40, NULL, 'AB+', NULL, 'Completed', '2025-04-16', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-15 12:00:57', NULL),
(27, 41, NULL, 'A+', NULL, 'Completed', '2025-04-03', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2025-04-15 12:51:39', NULL),
(37, 32, 'jjdfjkdsjksjjsjsajksa', 'A', NULL, 'Completed', '2025-04-30', 'المنيا', 'بنك الدم بالمنيا', NULL, NULL, NULL, NULL, NULL, 0, '2025-04-28 18:34:04', NULL),
(38, 32, 'ahmed fouad', 'A', NULL, 'Scheduled', '2025-06-16', 'المنصورة', 'مستشفى المنصورة الجامعي', NULL, NULL, NULL, NULL, NULL, 0, '2025-06-08 20:03:57', NULL);

-- --------------------------------------------------------

--
-- بنية الجدول `donations_money`
--

CREATE TABLE `donations_money` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `donation_type` varchar(50) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `item_description` text DEFAULT NULL,
  `payment_method` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'Pending',
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `donations_money`
--

INSERT INTO `donations_money` (`id`, `user_id`, `donation_type`, `amount`, `item_description`, `payment_method`, `status`, `donation_date`) VALUES
(1, 32, 'تبرع مالي', 1000.00, '', 'بطاقة فيزا', 'Pending', '2025-04-13 12:11:40');

-- --------------------------------------------------------

--
-- بنية الجدول `donation_locations`
--

CREATE TABLE `donation_locations` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `governorate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `donation_locations`
--

INSERT INTO `donation_locations` (`id`, `name`, `address`, `latitude`, `longitude`, `governorate`) VALUES
(1, 'مستشفى بنها التعليمي', 'بنها، القليوبية', 30.4663, 31.1842, 'القليوبية'),
(2, 'مستشفى ناصر العام', 'شبرا الخيمة، القليوبية', 30.1273, 31.2421, 'القليوبية'),
(3, 'مستشفى الهلال الأحمر', 'القاهرة', 30.0419, 31.2361, 'القاهرة'),
(4, 'مستشفى الجامعة - أسيوط', 'أسيوط', 27.1867, 31.1837, 'أسيوط'),
(5, 'مستشفى الزقازيق العام', 'الزقازيق، الشرقية', 30.5862, 31.502, 'الشرقية');

-- --------------------------------------------------------

--
-- بنية الجدول `donation_schedule`
--

CREATE TABLE `donation_schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `donation_date` date DEFAULT NULL,
  `donation_time` time DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `status` enum('Pending','Approved','Rejected') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `hospitals`
--

CREATE TABLE `hospitals` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `latitude` double NOT NULL,
  `longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `hospitals`
--

INSERT INTO `hospitals` (`id`, `name`, `phone`, `blood_type`, `latitude`, `longitude`) VALUES
(1, 'مستشفى النيل التخصصي', '01000111222', 'A+', 30.0478, 31.2336),
(2, 'مستشفى الحياة', '01111222333', 'O-', 30.0606, 31.2497),
(3, 'مستشفى الأمل', '01212345678', 'B+', 30.0333, 31.22),
(4, 'مستشفى الشفاء', '01555666777', 'AB+', 30.05, 31.26),
(5, 'مستشفى النور', '01099887766', 'O+', 30.08, 31.23),
(6, 'مستشفى المنار', '01090000000', 'B-', 30.0755, 31.29),
(7, 'مستشفى الزهور', '01111998877', 'A-', 30.0888, 31.21);

-- --------------------------------------------------------

--
-- بنية الجدول `locations`
--

CREATE TABLE `locations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `type` enum('hospital','mobile') DEFAULT 'hospital',
  `address` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `locations`
--

INSERT INTO `locations` (`id`, `name`, `type`, `address`, `latitude`, `longitude`, `city`) VALUES
(1, 'مستشفى القاهرة الجديدة', 'hospital', 'القاهرة الجديدة', 30.0181, 31.4992, 'القاهرة'),
(2, 'عربة تبرع متحركة - المعادي', 'mobile', 'المعادي - شارع 9', 29.9603, 31.2599, 'القاهرة');

-- --------------------------------------------------------

--
-- بنية الجدول `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_email` varchar(100) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `monetary_donations`
--

CREATE TABLE `monetary_donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `donation_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `monetary_donations`
--

INSERT INTO `monetary_donations` (`id`, `user_id`, `amount`, `donation_date`) VALUES
(1, 32, 8.00, '2025-04-13 00:42:34'),
(2, 32, 1000.00, '2025-04-13 02:40:45'),
(3, 32, 1.00, '2025-04-13 13:48:00'),
(4, 36, 1000.00, '2025-04-13 22:14:07'),
(5, 37, 1000.00, '2025-04-15 11:51:04'),
(6, 41, 10000.00, '2025-04-15 12:51:51'),
(7, 42, 100000.00, '2025-04-18 22:41:45'),
(8, 42, 10000.00, '2025-04-21 01:08:18'),
(9, 42, 100000.00, '2025-04-21 01:34:04'),
(10, 32, 1.00, '2025-06-08 20:04:57');

-- --------------------------------------------------------

--
-- بنية الجدول `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `is_read`, `created_at`) VALUES
(1, 42, '📅 تم جدولة موعد تبرع بتاريخ <strong>2025-04-09</strong> لفصيلة الدم <strong>A</strong>.', 0, '2025-04-22 21:33:38'),
(2, 42, '📅 تم جدولة موعد تبرع بتاريخ <strong>2025-04-23</strong> لفصيلة الدم <strong>A</strong>.', 0, '2025-04-22 21:35:28'),
(3, 42, '📅 تم جدولة موعد تبرع بتاريخ <strong>2025-04-30</strong> لفصيلة الدم <strong>A</strong>.', 0, '2025-04-24 03:12:32'),
(4, 32, '✅ تم إتمام تبرعك بتاريخ <strong>2025-04-23</strong> بنجاح. شكرًا لعطائك!', 0, '2025-04-24 03:34:13'),
(5, 32, '✅ تم إتمام تبرعك بتاريخ <strong>2025-04-16</strong> بنجاح. شكرًا لعطائك!', 0, '2025-04-24 03:34:14'),
(6, 32, '✅ تم إتمام تبرعك بتاريخ <strong>2025-04-14</strong> بنجاح. شكرًا لعطائك!', 0, '2025-04-24 03:34:15'),
(7, 32, '✅ تم إتمام تبرعك بتاريخ <strong>2025-04-13</strong> بنجاح. شكرًا لعطائك!', 0, '2025-04-24 03:34:15'),
(8, 32, 'ℹ️ تحديث جديد على تبرعك بتاريخ <strong>2025-04-08</strong>.', 0, '2025-04-24 03:34:15'),
(9, 32, 'ℹ️ تحديث جديد على تبرعك بتاريخ <strong>0000-00-00</strong>.', 0, '2025-04-24 03:34:15'),
(10, 32, '📅 تم جدولة موعد تبرع بتاريخ <strong>2025-04-30</strong> لفصيلة الدم <strong>A</strong>.', 0, '2025-04-28 18:38:13'),
(11, 32, '📅 تم جدولة موعد تبرع بتاريخ <strong>2025-06-16</strong> لفصيلة الدم <strong>A</strong>.', 0, '2025-06-08 20:04:12'),
(12, 32, '✅ تم إتمام تبرعك بتاريخ <strong>2025-04-30</strong> بنجاح. شكرًا لعطائك!', 0, '2025-06-08 20:04:12'),
(13, 32, '✅ تم إتمام تبرعك بتاريخ <strong>2025-04-08</strong> بنجاح. شكرًا لعطائك!', 0, '2025-06-08 20:04:12');

-- --------------------------------------------------------

--
-- بنية الجدول `other_donations`
--

CREATE TABLE `other_donations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `donation_type` varchar(255) NOT NULL,
  `details` text NOT NULL,
  `donation_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `redemption_log`
--

CREATE TABLE `redemption_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reward_id` int(11) DEFAULT NULL,
  `redeemed_at` datetime DEFAULT current_timestamp(),
  `reward_name` varchar(100) DEFAULT NULL,
  `points_used` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `blood_type` varchar(10) NOT NULL,
  `units_needed` int(11) NOT NULL,
  `hospital_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `needed_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rewards`
--

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `reward_item` varchar(255) DEFAULT NULL,
  `points_used` int(11) DEFAULT NULL,
  `redeemed_at` datetime DEFAULT current_timestamp(),
  `reward_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `rewards_log`
--

CREATE TABLE `rewards_log` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_name` varchar(255) DEFAULT NULL,
  `exchanged_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `schedule`
--

INSERT INTO `schedule` (`id`, `user_id`, `date`, `created_at`) VALUES
(9, 32, '2025-04-18', '2025-04-12 17:52:53'),
(10, 32, '2025-04-17', '2025-04-12 17:52:59'),
(11, 32, '2025-04-29', '2025-04-12 17:53:04'),
(12, 32, '2025-05-27', '2025-04-12 17:53:14'),
(13, 32, '2025-04-29', '2025-04-12 17:53:21'),
(14, 33, '2025-04-29', '2025-04-12 18:54:15'),
(15, 33, '2025-04-23', '2025-04-12 18:54:20'),
(16, 33, '2025-04-17', '2025-04-12 18:58:06'),
(17, 33, '2025-04-23', '2025-04-12 19:14:58'),
(18, 34, '2025-04-10', '2025-04-12 19:22:51');

-- --------------------------------------------------------

--
-- بنية الجدول `schedules`
--

CREATE TABLE `schedules` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `donation_date` date DEFAULT NULL,
  `governorate` varchar(100) DEFAULT NULL,
  `donation_time` time DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- بنية الجدول `support_messages`
--

CREATE TABLE `support_messages` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `support_messages`
--

INSERT INTO `support_messages` (`id`, `name`, `address`, `message`, `created_at`) VALUES
(2, 'ssksksks', 'skskksks', 'الرجاء قبول التبرع', '2025-04-25 03:21:06'),
(3, 'kkeks', 'sksksks', 'sksksksklakllkskls', '2025-04-25 03:27:06'),
(4, 'jdjdjdjksjkdsjdsjdsjkdsjdsjk', 'ewiusdjkdsjkdsjkdsjdjdjksjkdsjkds', 'سعد عبدالرازق ', '2025-04-28 15:40:49'),
(5, 'سعد ', 'سعد', 'سعد><', '2025-04-28 16:18:31');

-- --------------------------------------------------------

--
-- بنية الجدول `support_requests`
--

CREATE TABLE `support_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `support_requests`
--

INSERT INTO `support_requests` (`id`, `user_id`, `subject`, `message`, `created_at`) VALUES
(1, 32, 'xhhx', 'xhxhxhx', '2025-04-13 00:50:46'),
(2, 36, 'jdmmzmsms', 'smmsmmxmmxm', '2025-04-13 22:17:36'),
(3, 42, 'تثصبتنسيمنيسمنيسب', 'نمقمنقمنمنب', '2025-04-18 22:44:15');

-- --------------------------------------------------------

--
-- بنية الجدول `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `availability` enum('Available','Unavailable') DEFAULT 'Available',
  `full_name` varchar(100) NOT NULL,
  `blood_type` varchar(10) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `points` int(11) DEFAULT 0,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- إرجاع أو استيراد بيانات الجدول `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `availability`, `full_name`, `blood_type`, `phone`, `points`, `latitude`, `longitude`) VALUES
(24, 'iphone', 'AHMED@yahoo.com', '$2y$10$enRZBmraZX8/7WKkJ3QkEu7buj2k6Puv2nCb1qpw27q56e6ZEH3cC', '2025-04-12 01:23:38', 'Available', '', 'B-', '+20 01017841685', 0, NULL, NULL),
(25, 'ahmed fouad', 'nahed@gmail.com', '$2y$10$osTUiRzJpeYSRvfdzzp/TuTEsIprwsa0vUnZ1pdt0jADRGmXgcQcO', '2025-04-12 01:27:58', 'Available', '', 'A+', '+20 01017841685', 0, NULL, NULL),
(26, 'yara', 'yara@gmail.com', '$2y$10$3bvoSPKoxNJ76dR3dABcMuS8W5lohqIONLN.3MLCJtLx1faCYH9LS', '2025-04-12 02:18:40', 'Available', '', 'B-', '+20 01017841685', 0, NULL, NULL),
(27, 'nader', 'nader@gmail.com', '$2y$10$.pw7ozALs518VW/yqAHrGeIx/EnSU43/bIzVcTgxTG/X4/vySUOmS', '2025-04-12 11:07:55', 'Available', '', 'AB+', '+20 01017841685', 0, NULL, NULL),
(28, 'ahmed', 'ao@gmail.com', '$2y$10$vj3.dXdQ3XMgSK7a2yzwZumB53BrP4PGwKwaGEHgxTK3GECDVTP/q', '2025-04-12 11:24:53', 'Available', '', 'A+', '+20 01017841685', 0, NULL, NULL),
(30, 'Admin', 'admin@bloodbank.com', '<كلمة_المرور_مشفرة>', '2025-04-12 12:53:43', 'Available', '', 'O+', '0000000000', 0, NULL, NULL),
(31, 'nahed', 'a@gmail.com', '$2y$10$5N9XyEnXbJGkbjNXouaOA.5x1N/4pKJFI4zXtqjHZZXYBcXIJkUWi', '2025-04-12 13:14:24', 'Available', '', 'A+', '+2001017841685', 0, NULL, NULL),
(32, 'ahmed fouad', 'nn@gmail.com', '11', '2025-04-12 17:35:33', 'Available', '', NULL, NULL, 0, NULL, NULL),
(33, 'kero', 'kero@gmail.com', '11', '2025-04-12 18:39:46', 'Available', '', 'AB-', '+20 01017841685', 0, NULL, NULL),
(34, 'kero', 'kerosameh@gmail.com', '11', '2025-04-12 19:22:03', 'Available', '', 'B+', '01225555', 0, NULL, NULL),
(36, 'khoulod', 'kholood@gmail.com', '11', '2025-04-13 20:12:18', 'Available', '', 'B-', '01225555', 0, NULL, NULL),
(37, 'gamal', 'gamal@gmail.com', '11', '2025-04-15 09:49:28', 'Available', '', 'B+', '+20 01017841685', 0, NULL, NULL),
(40, 'gemi', 'gemi@gmail.com', '11', '2025-04-15 10:00:36', 'Available', '', 'B+', '+20 01017841685', 0, NULL, NULL),
(41, 'naser', 'naser@gmail.com', '11', '2025-04-15 10:49:42', 'Available', '', 'B-', '0105666', 0, NULL, NULL),
(42, 'saad', 'saad@gmail.com', '11', '2025-04-18 20:36:31', 'Available', '', 'A-', '0105666', 0, NULL, NULL),
(43, 'mahmoud ismail', 'ii@gmail.com', '11', '2025-04-18 22:43:00', 'Available', '', 'AB+', NULL, 0, NULL, NULL),
(45, 'bola', 'bola@gmail.com', '11', '2025-04-28 21:29:15', 'Available', '', 'AB-', NULL, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blood_requests`
--
ALTER TABLE `blood_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donations_ibfk_1` (`user_id`);

--
-- Indexes for table `donations_money`
--
ALTER TABLE `donations_money`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation_locations`
--
ALTER TABLE `donation_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `donation_schedule`
--
ALTER TABLE `donation_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hospitals`
--
ALTER TABLE `hospitals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `monetary_donations`
--
ALTER TABLE `monetary_donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `other_donations`
--
ALTER TABLE `other_donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `redemption_log`
--
ALTER TABLE `redemption_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reward_id` (`reward_id`);

--
-- Indexes for table `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rewards_log`
--
ALTER TABLE `rewards_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `support_messages`
--
ALTER TABLE `support_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_requests`
--
ALTER TABLE `support_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_inventory`
--
ALTER TABLE `blood_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `blood_requests`
--
ALTER TABLE `blood_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `donations_money`
--
ALTER TABLE `donations_money`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `donation_locations`
--
ALTER TABLE `donation_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `donation_schedule`
--
ALTER TABLE `donation_schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hospitals`
--
ALTER TABLE `hospitals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `monetary_donations`
--
ALTER TABLE `monetary_donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `other_donations`
--
ALTER TABLE `other_donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `redemption_log`
--
ALTER TABLE `redemption_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rewards_log`
--
ALTER TABLE `rewards_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_messages`
--
ALTER TABLE `support_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `support_requests`
--
ALTER TABLE `support_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- قيود الجداول المُلقاة.
--

--
-- قيود الجداول `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `donation_schedule`
--
ALTER TABLE `donation_schedule`
  ADD CONSTRAINT `donation_schedule_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `monetary_donations`
--
ALTER TABLE `monetary_donations`
  ADD CONSTRAINT `monetary_donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- قيود الجداول `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `other_donations`
--
ALTER TABLE `other_donations`
  ADD CONSTRAINT `other_donations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `redemption_log`
--
ALTER TABLE `redemption_log`
  ADD CONSTRAINT `redemption_log_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `redemption_log_ibfk_2` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`);

--
-- قيود الجداول `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `rewards`
--
ALTER TABLE `rewards`
  ADD CONSTRAINT `rewards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- قيود الجداول `schedules`
--
ALTER TABLE `schedules`
  ADD CONSTRAINT `schedules_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
