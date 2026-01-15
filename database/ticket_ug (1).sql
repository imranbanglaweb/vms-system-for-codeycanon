-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 28, 2023 at 09:25 AM
-- Server version: 10.6.12-MariaDB-0ubuntu0.22.04.1
-- PHP Version: 8.1.2-1ubuntu2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticket_ug`
--

-- --------------------------------------------------------

--
-- Table structure for table `assigntasks`
--

CREATE TABLE `assigntasks` (
  `id` int(10) UNSIGNED NOT NULL,
  `issue_register_id` int(11) DEFAULT NULL,
  `assign_date` datetime DEFAULT NULL,
  `assign_task_fron` int(11) DEFAULT NULL,
  `assign_task_to` int(11) DEFAULT NULL,
  `assigntasks_status` varchar(255) DEFAULT NULL,
  `assigntasks_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `mac_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assigntasks`
--

INSERT INTO `assigntasks` (`id`, `issue_register_id`, `assign_date`, `assign_task_fron`, `assign_task_to`, `assigntasks_status`, `assigntasks_oder`, `remarks`, `status`, `ip_address`, `mac_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, '2023-03-09 05:28:47', 1, 1, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-08 23:28:47', '2023-03-08 23:28:47'),
(3, 1, '2023-03-09 05:30:07', 1, 1, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-08 23:30:07', '2023-03-08 23:30:07'),
(5, 1, '2023-03-09 05:58:25', 1, 2, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-08 23:58:25', '2023-03-08 23:58:25'),
(6, 2, '2023-03-09 06:29:33', 1, 2, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-09 00:29:33', '2023-03-09 00:29:33'),
(7, 3, '2023-03-09 06:56:25', 1, 1, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-09 00:56:25', '2023-03-09 00:56:25'),
(8, 3, '2023-03-09 06:56:38', 1, 2, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-09 00:56:38', '2023-03-09 00:56:38'),
(9, 2, '2023-03-09 06:57:52', 2, 1, NULL, 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-09 00:57:52', '2023-03-09 00:57:52'),
(10, 3, '2023-03-09 06:58:52', 2, 1, NULL, 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-09 00:58:52', '2023-03-09 00:58:52'),
(11, 4, '2023-03-09 07:00:29', 2, 1, NULL, 1, 'Assign Task to admin User', 1, NULL, NULL, 2, NULL, NULL, '2023-03-09 01:00:29', '2023-03-09 01:00:29'),
(12, 2, '2023-03-11 04:38:08', 1, 2, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-10 22:38:08', '2023-03-10 22:38:08'),
(13, 2, '2023-03-11 04:38:57', 2, 1, NULL, 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-10 22:38:57', '2023-03-10 22:38:57'),
(14, 9, '2023-03-12 08:31:00', 1, 2, NULL, 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-12 02:31:00', '2023-03-12 02:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT 0,
  `category_name` varchar(150) NOT NULL,
  `category_slug` varchar(100) NOT NULL,
  `category_type` varchar(100) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `category_url` varchar(250) DEFAULT NULL,
  `category_oder` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `category_name`, `category_slug`, `category_type`, `remarks`, `category_url`, `category_oder`, `menu_id`, `page_id`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 0, 'IT infrastructure', 'it-infrastructure', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:47:49', '2023-03-01 02:47:49'),
(2, 0, 'Server Configuration', 'server-configuration', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:48:59', '2023-03-01 02:48:59'),
(3, 0, 'ISP Maintanence', 'isp-maintanence', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:49:18', '2023-03-01 02:49:18'),
(4, 0, 'Office 365 Admin', 'office-365-admin', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:49:43', '2023-03-01 02:49:43'),
(5, 0, 'Biometric Solution', 'biometric-solution', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:50:01', '2023-03-01 02:50:01'),
(6, 0, 'End User Support', 'end-user-support', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:50:14', '2023-03-01 02:50:14'),
(7, 0, 'Other Jobs', 'other-jobs', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, NULL, NULL, '2023-03-01 02:50:23', '2023-03-01 02:50:23');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(300) NOT NULL,
  `company_code` varchar(255) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `company_name`, `company_code`, `unit_id`, `company_oder`, `remarks`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2, 'The Westin', 'westin', 4, 1, NULL, 1, 1, NULL, NULL, '2023-01-15 03:27:59', '2023-01-15 03:27:59'),
(3, 'Hotel Sheraton', 'Hotel Sheraton', 4, 1, 'Hotel Sheraton', 1, 1, NULL, NULL, '2023-01-15 03:53:34', '2023-01-15 03:53:34'),
(4, 'Hansa Hotel', 'Hansa Hotel', 4, 1, 'Hansa Hotel', 1, 1, NULL, NULL, '2023-01-15 03:56:48', '2023-01-15 03:56:48');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(10) UNSIGNED NOT NULL,
  `contact_name` varchar(400) NOT NULL,
  `contact_mobile` int(11) DEFAULT NULL,
  `contact_email` text DEFAULT NULL,
  `contact_content` text DEFAULT NULL,
  `ip_address` int(11) DEFAULT NULL,
  `mac_address` int(11) DEFAULT NULL,
  `event_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(10) UNSIGNED NOT NULL,
  `department_name` varchar(300) NOT NULL,
  `department_code` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_oder` int(11) DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `department_name`, `department_code`, `unit_id`, `company_id`, `department_oder`, `remarks`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'IT Department', NULL, 4, 4, NULL, NULL, 1, 1, NULL, NULL, '2023-01-15 21:57:31', '2023-01-15 22:42:19'),
(2, 'Academic', NULL, 7, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:45:28', '2023-03-15 00:45:28'),
(3, 'Admin & General', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:45:59', '2023-03-15 00:45:59'),
(4, 'Administration', NULL, 12, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:47:17', '2023-03-15 00:47:17'),
(5, 'Adv. & ED Secretariat', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:47:50', '2023-03-15 00:47:50'),
(6, 'Back Office', NULL, 6, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:48:13', '2023-03-15 00:48:13'),
(7, 'Commercial', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:48:37', '2023-03-15 00:48:37'),
(8, 'Company Secretariat', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:48:56', '2023-03-15 00:48:56'),
(9, 'Construction', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:49:24', '2023-03-15 00:49:24'),
(10, 'Corporate Affairs', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:50:29', '2023-03-15 00:50:29'),
(11, 'Corporate Finance', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:50:48', '2023-03-15 00:50:48'),
(12, 'COVID19 Registration', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:51:17', '2023-03-15 00:51:17'),
(13, 'Customer Service', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:51:57', '2023-03-15 00:51:57'),
(14, 'Design Development', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:52:23', '2023-03-15 00:52:23'),
(15, 'Diagnostic Lab', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:53:28', '2023-03-15 00:53:28'),
(16, 'Doctor\'s Chamber', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:54:06', '2023-03-15 00:54:06'),
(17, 'Engineering', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:54:32', '2023-03-15 00:54:32'),
(18, 'Facility Management', NULL, 12, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:55:03', '2023-03-15 00:55:03'),
(19, 'Finance & Accounts', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:56:31', '2023-03-15 00:56:31'),
(20, 'Food & Beverage (Production)', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:58:14', '2023-03-15 00:58:14'),
(21, 'Food & Beverage (Service)', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 00:58:56', '2023-03-15 00:58:56'),
(22, 'Front Office', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:00:24', '2023-03-15 02:00:24'),
(23, 'Housekeeping', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:00:44', '2023-03-15 02:00:44'),
(24, 'HR & Admin', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:01:22', '2023-03-15 02:01:22'),
(25, 'Human Resource', NULL, 1, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:01:54', '2023-03-15 02:01:54'),
(26, 'Information Technology', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:02:17', '2023-03-15 02:02:17'),
(27, 'Internal Audit', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:03:06', '2023-03-15 02:03:06'),
(28, 'Internal Control Compliance Process Re-Engineering', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:03:54', '2023-03-15 02:03:54'),
(29, 'Laboratory', NULL, 15, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:04:33', '2023-03-15 02:04:33'),
(30, 'Land', NULL, 9, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:05:19', '2023-03-15 02:05:19'),
(31, 'Legal', NULL, 9, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:06:05', '2023-03-15 02:06:05'),
(32, 'Logistics', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:06:36', '2023-03-15 02:06:36'),
(33, 'Marketing & Branding', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:07:01', '2023-03-15 02:07:01'),
(34, 'MD Secreteriat', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:07:36', '2023-03-15 02:07:36'),
(35, 'MD\'s Facility Management', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:08:12', '2023-03-15 02:08:12'),
(36, 'Medical', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:09:34', '2023-03-15 02:09:34'),
(37, 'MEP', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:09:50', '2023-03-15 02:09:50'),
(38, 'Migrams', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:10:10', '2023-03-15 02:10:10'),
(39, 'Molecular Lab', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:10:23', '2023-03-15 02:10:23'),
(40, 'One Stop Service', NULL, 6, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:10:43', '2023-03-15 02:10:43'),
(41, 'Operations', NULL, 16, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:11:13', '2023-03-15 02:11:13'),
(42, 'Physical Checkup', NULL, 3, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:11:37', '2023-03-15 02:11:37'),
(43, 'Power Plant', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:11:54', '2023-03-15 02:11:54'),
(44, 'Procurement', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:12:15', '2023-03-15 02:12:15'),
(45, 'Production', NULL, 15, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:12:53', '2023-03-15 02:12:53'),
(46, 'Project Management', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:13:10', '2023-03-15 02:13:10'),
(47, 'Revenue & Customer Service', NULL, 12, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:13:42', '2023-03-15 02:13:42'),
(48, 'Safety & Security', NULL, 14, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:14:05', '2023-03-15 02:14:05'),
(49, 'Sales & Marketing', NULL, 14, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:15:06', '2023-03-15 02:15:06'),
(50, 'Share Management', NULL, 13, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:15:47', '2023-03-15 02:15:47'),
(51, 'Tax & VAT', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:16:12', '2023-03-15 02:16:12'),
(52, 'Top Management', NULL, 5, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:16:29', '2023-03-15 02:16:29'),
(53, 'Transport Pool', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:17:44', '2023-03-15 02:17:44'),
(54, 'Trust Office', NULL, 4, NULL, NULL, NULL, 1, 2, NULL, NULL, '2023-03-15 02:18:55', '2023-03-15 02:18:55');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `employee_id` text DEFAULT NULL,
  `employee_name` varchar(255) DEFAULT NULL,
  `designation` text DEFAULT NULL,
  `employee_description` text DEFAULT NULL,
  `gender` text DEFAULT NULL,
  `employee_email` varchar(255) DEFAULT NULL,
  `employee_phone` text DEFAULT NULL,
  `employee_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `unit_id`, `company_id`, `department_id`, `location_id`, `employee_id`, `employee_name`, `designation`, `employee_description`, `gender`, `employee_email`, `employee_phone`, `employee_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(870, 5, NULL, 48, 4, '273', 'Md. Abdul Latif Sarkar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(871, 7, NULL, 2, 4, '43', 'Bemol Chandra Das', 'Senior Chief Instructor', NULL, NULL, 'bimal@uniquevocationalbd.com', '1763951504', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(872, 7, NULL, 2, 4, '92', 'Md. Maksadur Rahman (Wakil)', 'Chief Instructor', NULL, NULL, 'anwar@uniquevocationalbd.com', '1611978673', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(873, 7, NULL, 2, 4, '126', 'Muhammad Salauddin', 'Chief Instructor', NULL, NULL, 'ranauvtc@gmail.com', '1768355214', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(874, 7, NULL, 2, 4, '189', 'Zahedul Hoque Tusar', 'Assistant General Manager', NULL, NULL, 'zhtusar@uniquevocationalbd.com', '1717124203', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(875, 7, NULL, 2, 4, '149', 'Utpal Kumar Sarkar', 'Chief Instructor', NULL, NULL, 'anwar@uniquevocationalbd.com', '17166666601', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(876, 7, NULL, 2, 4, '209', 'Md.Shajahan Ali', 'Hostel Super', NULL, NULL, 'anwar@uniquevocationalbd.com', '1710617500', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(877, 7, NULL, 2, 4, '243', 'Md.Mejanur Rahman', 'Training Supervisor', NULL, NULL, 'mejanurrahman635@gmail.com', '1719946949', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(878, 7, NULL, 2, 4, '392', 'Billal Hossain', 'Carpenter', NULL, NULL, 'anwar@uniquevocationalbd.com', '1746905305', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(879, 7, NULL, 2, 4, '451', 'Md.Saiful Islam', 'Instructor', NULL, NULL, 'anwar@uniquevocationalbd.com', '1723572864', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(880, 7, NULL, 2, 4, '548', 'Md Nadim Ali', 'Instructor', NULL, NULL, 'nadimali017@gmail.com', '1674626882', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(881, 7, NULL, 2, 4, '552', 'Mohammad Ali', 'Instructor', NULL, NULL, 'anwar@uniquevocationalbd.com', '1919654202', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(882, 7, NULL, 2, 4, '563', 'Syed Anayet Hossain', 'Training Supervisor', NULL, NULL, 'anayet760@gmail.com', '1779522920', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(883, 7, NULL, 2, 4, '1110', 'Md.Shihabuddin', 'Instructor', NULL, NULL, 'shihabmd2016@gmail.com', '1919661402', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(884, 7, NULL, 2, 4, '4132', 'Md Harun Rashid', 'Training Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(885, 7, NULL, 4, 4, '3496', 'Mir Hossain', 'Executive', NULL, NULL, NULL, '01731-103418', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(886, 7, NULL, 4, 4, '3861', 'Md Saddam Iqbal', 'Executive (Processing)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(887, 7, NULL, 4, 4, '4155', 'Md Rased Mia', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(888, 7, NULL, 6, 4, '81', 'Mr.Shahidul Islam', 'Office Boy', NULL, NULL, 'anwar@uniquevocationalbd.com', '1757053225', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(889, 7, NULL, 6, 4, '118', 'Md. Rahmatullah', 'Senior Officer (Accounts & Store)', NULL, NULL, 'rahmatullah@uniquevocationalbd.com', '1719552109', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(890, 7, NULL, 6, 4, '140', 'Anwar Hossain', 'Assiatant Manager (Admin)', NULL, NULL, 'anwar@uniquevocationalbd.com', '1769501402', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(891, 7, NULL, 6, 4, '1014', 'Md.Abir Hossain Bhuiyan', 'Executive (Processing)', NULL, NULL, 'abir@uniquevocationalbd.com', '1784533811', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(892, 7, NULL, 6, 4, '1034', 'Md.Jahangir Alam', 'Electrician', NULL, NULL, 'anwar@uniquevocationalbd.com', '01923703412, 01708800718', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(893, 7, NULL, 6, 4, '3407', 'Mahabub Rahman', 'Senior Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(894, 7, NULL, 6, 4, '3460', 'Mustafizur Rahman', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(895, 7, NULL, 19, 4, '222', 'Md.Rafiqul Alam', 'Assistant Manager (Accounts)', NULL, NULL, 'rafiqul.alam@uniquevocationalbd.com', '1769501409', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(896, 7, NULL, 19, 4, '1103', 'Md.Mohiuddin Hossain Chisty', 'Assiatant Manager (Accounts)', NULL, NULL, 'chisty@uniqueeastern.com', '01911277796, 01913508663', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(897, 7, NULL, 19, 4, '3967', 'Syed Maksudur Rahman', 'Assistant Manager (Accounts)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(898, 7, NULL, 48, 4, '58', 'Md.Akbar Ali', 'Security Guard', NULL, NULL, NULL, '1990229611', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(899, 7, NULL, 48, 4, '129', 'Md.Fazlul Haque', 'Security Guard', NULL, NULL, NULL, '1782334325', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(900, 7, NULL, 48, 4, '159', 'Tuhin Sikder', 'Security Guard', NULL, NULL, NULL, '1743168685', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(901, 7, NULL, 48, 4, '261', 'Md. Saiful Islam', 'Security Guard', NULL, NULL, NULL, '1743602184', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(902, 7, NULL, 48, 4, '284', 'Md.Shabdul Hossain', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(903, 7, NULL, 48, 4, '291', 'Md.Shahidul Islam', 'Security Guard', NULL, NULL, NULL, '1731895495', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(904, 7, NULL, 48, 4, '421', 'Md. Royal Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(905, 7, NULL, 48, 4, '1137', 'Md.Masudur Rahman', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(906, 7, NULL, 48, 4, '622', 'Md. Soahrab Ali Mondal', 'Security Guard', NULL, NULL, NULL, '1745416570', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(907, 7, NULL, 48, 4, '736', 'Md. Alam Majumder', 'Security Guard', NULL, NULL, NULL, '1849811653', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(908, 7, NULL, 48, 4, '964', 'Abdul Mannan Khan', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(909, 7, NULL, 48, 4, '1041', 'Md.Suhel Rana', 'Security Guard', NULL, NULL, NULL, '1739534187', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(910, 7, NULL, 48, 4, '1148', 'Md.Salim Mia', 'Security Guard', NULL, NULL, NULL, '1738849735', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(911, 7, NULL, 48, 4, '1483', 'Md.Masar Ali', 'Security Guard', NULL, NULL, NULL, '1713524799', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(912, 7, NULL, 48, 4, '2000', 'Md. Dulal Howlader', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(913, 7, NULL, 48, 4, '2116', 'Md. Bablu Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(914, 7, NULL, 48, 4, '2779', 'Md. Nahid Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(915, 7, NULL, 48, 4, '3039', 'Amin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(916, 7, NULL, 48, 4, '3317', 'Md Sohidul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(917, 7, NULL, 48, 4, '3426', 'Md Sakibul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(918, 7, NULL, 48, 4, '3454', 'Habib Sheikhg', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(919, 7, NULL, 48, 4, '3505', 'Md Ataur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(920, 7, NULL, 48, 4, '3543', 'Md Tafeger Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(921, 7, NULL, 48, 4, '3547', 'Md Hakim', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(922, 7, NULL, 48, 4, '3623', 'Md Abdur Sattar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(923, 7, NULL, 48, 4, '3696', 'Md Mosharof Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(924, 7, NULL, 48, 4, '3642', 'Md Limon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(925, 7, NULL, 48, 4, '3697', 'Shaikh Mijanur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(926, 7, NULL, 48, 4, '3794', 'Md Abu Salman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(927, 7, NULL, 48, 4, '3786', 'Md Mafil Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(928, 7, NULL, 48, 4, '3850', 'Sagor', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(929, 7, NULL, 48, 4, '4045', 'Mahfujur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(930, 7, NULL, 48, 4, '4066', 'Abdul Alim', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(931, 7, NULL, 48, 4, '4086', 'Sumon Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(932, 7, NULL, 48, 4, '4145', 'Md Asif Faisal Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(933, 12, NULL, 18, 5, '2885', 'Md. Moienuddin Khan', 'Facility Supervisor (Cleaning)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(934, 12, NULL, 18, 5, '3250', 'Razu', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(935, 12, NULL, 18, 5, '3252', 'Md Monirul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(936, 12, NULL, 18, 5, '3556', 'Md Forkan Ali', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(937, 12, NULL, 18, 5, '3662', 'Md Fahim Mustasir Tutul', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(938, 12, NULL, 18, 5, '3896', 'Md Nahid Hasan Rony', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(939, 12, NULL, 18, 5, '4156', 'Md Faridul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(940, 12, NULL, 18, 5, '4157', 'Shahonous Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(941, 12, NULL, 37, 5, '3051', 'Md. Mahabur Akunjee', 'Lift Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(942, 12, NULL, 41, 5, '3391', 'Omar Faruk', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(943, 12, NULL, 48, 5, '169', 'Albert Rozario', 'Security Guard', NULL, NULL, NULL, '1721546224', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(944, 12, NULL, 48, 5, '2541', 'Md. rabiul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(945, 12, NULL, 48, 5, '3350', 'Md Sohel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(946, 12, NULL, 48, 5, '3456', 'Md Sujon Shardar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(947, 12, NULL, 48, 5, '3500', 'Jamil Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(948, 12, NULL, 48, 5, '3561', 'Md Rakibul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(949, 12, NULL, 48, 5, '3695', 'Abu Shid Fokir', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(950, 12, NULL, 48, 5, '3631', 'Md Arafat Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(951, 12, NULL, 48, 5, '3672', 'Abdul Hossain Kha', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(952, 12, NULL, 48, 5, '3675', 'Md Badal Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(953, 12, NULL, 48, 5, '3796', 'Md Al-Amin Mollik', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(954, 12, NULL, 18, 6, '2377', 'Md. Golam Rabbi', 'Plumber', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(955, 12, NULL, 18, 6, '3549', 'Md Joni Hossain', 'Lift Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(956, 12, NULL, 18, 6, '4067', 'Md Abu Haris', 'Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(957, 12, NULL, 18, 6, '3344', 'Md A. Motaleb', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(958, 12, NULL, 18, 6, '4072', 'Opu Das', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(959, 12, NULL, 18, 6, '4076', 'Md Riaz Molla', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(960, 12, NULL, 23, 6, '2705', 'Md. Shohel', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(961, 12, NULL, 37, 6, '3929', 'Alim Farazi', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(962, 12, NULL, 37, 6, '4063', 'Md Riaz Molla', 'Lift Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(963, 12, NULL, 41, 6, '3392', 'Shuvo Vartacharjo', 'Facility Supervisor (Cleaning)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(964, 12, NULL, 48, 6, '1771', 'Md. Nizam Uddin', 'Security Guard', NULL, NULL, NULL, '1729938169', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(965, 12, NULL, 18, 7, '3996', 'Mst. Setu Akter Mim', 'Front Desk Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(966, 12, NULL, 23, 7, '3998', 'Md Moniruzzaman', 'Housekeeping Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(967, 12, NULL, 48, 7, '3873', 'Md Al-Amin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(968, 12, NULL, 48, 7, '3956', 'Md Abdulla Al-Noman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(969, 12, NULL, 48, 7, '3874', 'Md Omar Faruk', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(970, 12, NULL, 48, 7, '3957', 'Md Alif Zaman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(971, 12, NULL, 48, 7, '3955', 'Sourav Pal', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(972, 12, NULL, 48, 7, '3985', 'Md Habibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(973, 12, NULL, 48, 7, '3984', 'Mohiuddin Ovi', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(974, 5, NULL, 48, 8, '83', 'Bablu Mia', 'Security Guard', NULL, NULL, NULL, '1741679832', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(975, 5, NULL, 48, 8, '729', 'Md.Mizanur Rahman', 'Security Guard', NULL, NULL, NULL, '1934217809', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(976, 5, NULL, 48, 8, '1844', 'Md. Amirul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(977, 11, NULL, 2, 9, '1963', 'Md. Shapiqul Islam', 'Instructor', NULL, NULL, 'cmt@borakpolytechnic.edu.bd', '1723741777', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(978, 11, NULL, 2, 9, '2074', 'Foujia Afroj', 'Instructor (Electrical)', NULL, NULL, NULL, '1733649985', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(979, 11, NULL, 2, 9, '2072', 'Md. Nuruzzaman', 'Junior Instructor', NULL, NULL, NULL, '1684131513', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(980, 11, NULL, 2, 9, '2712', 'Md. Jewel Rana', 'Instructor (Electrical)', NULL, NULL, NULL, '1674247039', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(981, 11, NULL, 2, 9, '2793', 'Asiquzaman', 'Instructor', NULL, NULL, NULL, '1723204281', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(982, 11, NULL, 2, 9, '2855', 'Md. Muktadir Hossain', 'Senior Instructor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(983, 11, NULL, 2, 9, '3134', 'Noornobi Mridha', 'Senior Instructor', NULL, NULL, NULL, '1736596880', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(984, 11, NULL, 2, 9, '3286', 'Sayed Nayeem Hossain', 'Instructor (Electrical)', NULL, NULL, NULL, '1915687122', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(985, 11, NULL, 2, 9, '3394', 'Md Sohel Rana', 'Instructor', NULL, NULL, NULL, '1755711201', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(986, 11, NULL, 2, 9, '3402', 'Habib Un Noby Nerob', 'Junior Instructor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(987, 11, NULL, 2, 9, '3399', 'Md Nazmul Haq', 'Instructor', NULL, NULL, NULL, '01786-810691', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(988, 11, NULL, 2, 9, '3397', 'Md. Ibrahim Shikdar', 'Instructor', NULL, NULL, NULL, '1927024420', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(989, 11, NULL, 2, 9, '3398', 'Atun Moni', 'Instructor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(990, 11, NULL, 2, 9, '3401', 'Md Atikur Rahman', 'Instructor', NULL, NULL, NULL, '1719045809', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(991, 11, NULL, 2, 9, '3400', 'Seemanta Debnath', 'Instructor', NULL, NULL, NULL, '1934547497', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(992, 11, NULL, 2, 9, '3405', 'Md Hasan Ali ', 'Instructor', NULL, NULL, NULL, '1517814516', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(993, 11, NULL, 2, 9, '3406', 'Aklema Khanam Retu', 'Instructor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(994, 11, NULL, 2, 9, '2091', 'Syed Nazim Obayed', 'Principal (Acting)', NULL, NULL, 'vp@borakpolytechnic.edu.bd', '1611101289', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(995, 11, NULL, 2, 9, '2711', 'Masuma Khatun', 'Admission Officer cum Instructor, Relations Subjects (RS)', NULL, NULL, NULL, '1622458440', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(996, 11, NULL, 2, 9, '2713', 'Md. Joherul Islam', 'Instructor (Coordinator), Mechanical Technology', NULL, NULL, NULL, '1710899909', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(997, 11, NULL, 2, 9, '2710', 'Md. Sohel Molla', 'Asst. Registrar cum Instructor, Computer Technology', NULL, NULL, NULL, '1928973719', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(998, 11, NULL, 6, 9, '2077', 'Md. Jakaria Hossain', 'Peon', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(999, 11, NULL, 6, 9, '2078', 'Md. Kamruzzaman', 'Lab Assistant (Electrical)', NULL, NULL, NULL, '1949124608', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1000, 11, NULL, 6, 9, '2231', 'Mst. Helena Khatun', 'Office Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1001, 11, NULL, 6, 9, '3893', 'Iffat Ara Murtoza', 'Admin cum Liaison Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1002, 11, NULL, 6, 9, '3129', 'Nazmul Hassan', 'Program Development Officer (PDO) Cum Admin Officer', NULL, NULL, 'inf@borakpolytechnique.edu.bd', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1003, 11, NULL, 19, 9, '3733', 'Suvro Saha ', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1004, 11, NULL, 19, 9, '4000', 'Afsar Hossain', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1005, 11, NULL, 53, 9, '424', 'Md. Zohirul Islam Shohel', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1722559517', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1006, 5, NULL, 48, 9, '3118', 'Md Masum Hossain', 'Security Inspector (Gunman, Special Security Team)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1007, 16, NULL, 41, 10, '21', 'Mohammed Jashimuddin', 'Assiatant Manager (Sales & Reservation)', NULL, NULL, 'jashimuddin@uniquegroupbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1008, 16, NULL, 41, 10, '3708', 'Md Rashidur Rahman', 'Executive (Accounts)', NULL, NULL, NULL, '1756866922', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1009, 5, NULL, 9, 11, '427', 'Nurul Islam', 'Electrician', NULL, NULL, 'bzt@borakbd.com', '1939239194', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1010, 5, NULL, 9, 11, '667', 'Md. Ataur Rahman', 'Site Engineer', NULL, NULL, 'ataur.addin@gmail.com', '1923813387', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1011, 5, NULL, 9, 11, '2155', 'Md. Aminul Islam', 'Storekeeper', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1012, 5, NULL, 9, 11, '2828', 'Md. Mafuzul Hasan Khan', 'Project Engineer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1013, 5, NULL, 48, 11, '425', 'Suvir Howlader', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1014, 5, NULL, 48, 11, '1482', 'Md.Humayuan Kabir', 'Security Guard', NULL, NULL, NULL, '1721676051', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1015, 5, NULL, 48, 11, '2800', 'Md. Polash Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1016, 5, NULL, 48, 11, '3079', 'Md Abdur Razzaque', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1017, 5, NULL, 48, 11, '3212', 'Md Juel', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1018, 5, NULL, 48, 11, '3491', 'Md Abdul Goni Fitu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1019, 5, NULL, 48, 11, '3610', 'Md Sofiqul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1020, 5, NULL, 48, 11, '3611', 'Md Johurul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1021, 5, NULL, 48, 11, '3609', 'Abdul Malek', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1022, 5, NULL, 48, 11, '3608', 'Md Suruz', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1023, 5, NULL, 48, 11, '3559', 'Md Billal Hosen Dhali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1024, 5, NULL, 48, 11, '3637', 'Md Jahangir Aziz', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:05', '2023-03-15 05:09:05'),
(1025, 5, NULL, 48, 11, '4118', 'Farhaduzzaman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1026, 5, NULL, 48, 11, '4128', 'Md Ponik Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1027, 5, NULL, 48, 11, '4153', 'Md Mintu Hossen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1028, 5, NULL, 48, 11, '4164', 'Md Saddam Hossen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1029, 12, NULL, 18, 11, '289', 'Md.Saddam Hossain', 'Lift Operator', NULL, NULL, 'monzu@uniquehansa.com', '1727362518', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1030, 12, NULL, 18, 11, '3828', 'Md Shihab', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1031, 12, NULL, 18, 11, '3910', 'Md Salman ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1032, 12, NULL, 18, 11, '4021', 'Mehedi Hasan Sajid', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1033, 12, NULL, 23, 11, '2859', 'MD.Rana Ahmed Bhuiya', 'Housekeeping Attendant', NULL, NULL, NULL, '1977637295', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1034, 12, NULL, 37, 11, '2858', 'Kader Ahmed', 'Plumber', NULL, NULL, NULL, '1311240652', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1035, 12, NULL, 48, 11, '141', 'Md.Tahid', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1036, 12, NULL, 48, 11, '3791', 'Md Mostajul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1037, 12, NULL, 48, 11, '3837', 'Md Rafik Mondol', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1038, 12, NULL, 48, 11, '3836', 'Md Rofikul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1039, 12, NULL, 48, 11, '3851', 'Shuktar Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1040, 12, NULL, 48, 11, '3829', 'Hasib', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1041, 12, NULL, 48, 11, '3871', 'Tania Begum', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1042, 12, NULL, 48, 11, '3872', 'Md Kamrul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1043, 12, NULL, 48, 11, '3934', 'Md Polash Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1044, 12, NULL, 48, 11, '3935', 'Polash Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1045, 4, NULL, 48, 11, '3346', 'Raufir Ahmmad Nirob', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1046, 12, NULL, 18, 12, '3908', 'Abdul Samad ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1047, 12, NULL, 18, 12, '3902', 'Md Ismail ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1048, 12, NULL, 18, 12, '3911', 'Md Rakib Hossain ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1049, 12, NULL, 18, 12, '3898', 'Md Tamim Hosen ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1050, 12, NULL, 18, 12, '3899', 'Md. Faruk', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1051, 12, NULL, 18, 12, '3913', 'Mohammad Hasibul Hasan ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1052, 12, NULL, 18, 12, '3904', 'Riyad Mia ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1053, 12, NULL, 18, 12, '4027', 'Amir Hossain', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1054, 12, NULL, 18, 12, '4026', 'Md Jubayed Mia', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1055, 12, NULL, 18, 12, '4029', 'Sagor Mia', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1056, 12, NULL, 18, 12, '4028', 'Joy Hasan', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1057, 12, NULL, 18, 12, '4032', 'Rasal Ahmed', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1058, 12, NULL, 18, 12, '4078', 'Nion Howlader', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1059, 12, NULL, 18, 12, '4138', 'Md Liton', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1060, 12, NULL, 37, 12, '3928', 'Aolad Hossain', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1061, 12, NULL, 48, 12, '3878', 'Ashadul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1062, 12, NULL, 48, 12, '3924', 'Md Hafizul Howlader ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1063, 12, NULL, 48, 12, '3880', 'Ms Sha Alom Molla', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1064, 12, NULL, 48, 12, '3879', 'Robimur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1065, 12, NULL, 48, 12, '3938', 'Md Sohag Molla', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1066, 12, NULL, 48, 12, '3937', 'Md Ibad Ali', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1067, 12, NULL, 48, 12, '4152', 'Sohan Khan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1068, 12, NULL, 48, 12, '4151', 'Tahid Fokir', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1069, 5, NULL, 48, 13, '121', 'Md.Abul Kashem', 'Security Guard', NULL, NULL, NULL, '1732649528', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1070, 5, NULL, 48, 13, '370', 'Md.Aktar Hossain', 'Security Supervisor', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1071, 5, NULL, 48, 13, '936', 'Md.Rafiqul Islam', 'Security Guard', NULL, NULL, NULL, '1766549919', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1072, 5, NULL, 48, 13, '1471', 'Md.Parvesh Islam', 'Security Guard', NULL, NULL, NULL, '1756874914', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1073, 5, NULL, 48, 13, '3698', 'Md Masum Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1074, 12, NULL, 48, 14, '606', 'Md. Kamal Hossain', 'Security Guard', NULL, NULL, NULL, '1763606080', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1075, 12, NULL, 48, 14, '3203', 'Md Sakhaoyt Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1076, 12, NULL, 48, 14, '3213', 'Md Rayhan Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1077, 12, NULL, 18, 15, '1980', 'Md. Ashraful Alam', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1078, 12, NULL, 18, 15, '1979', 'Shuvra Mahamud', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1079, 12, NULL, 18, 15, '3667', 'Md Omar Ali', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1080, 12, NULL, 48, 15, '251', 'Md.Nurul Islam', 'Security Guard', NULL, NULL, NULL, '1989148476', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1081, 12, NULL, 48, 15, '926', 'Md. Mojibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1082, 12, NULL, 48, 15, '928', 'Md. Abdul Karim', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1083, 12, NULL, 48, 15, '702', 'Md. Afzal Uddin Mollah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1084, 12, NULL, 48, 15, '1710', 'Md. Motiur Rahman', 'Security Guard', NULL, NULL, NULL, '1733518916', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1085, 12, NULL, 48, 15, '3420', 'Md Sahadat Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1086, 12, NULL, 48, 15, '3540', 'Md Sakil Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1087, 12, NULL, 48, 15, '3692', 'Rifat Howlader', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1088, 5, NULL, 17, 16, '3617', 'Md Al-Amin', 'Senior Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1089, 5, NULL, 46, 16, '1834', 'Md. Shahinuzzaman Shahin', 'Draftsman', NULL, NULL, 'shahin@borakbd.com', '1914691293', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1090, 5, NULL, 48, 16, '1952', 'Md. Rashed Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1091, 12, NULL, 22, 16, '3827', 'Dina Mankhin', 'SPA Therapist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1092, 12, NULL, 48, 16, '195', 'Md. Nazim Uddin Sonar', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '1723309450', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1093, 12, NULL, 48, 16, '581', 'Md.Ruhul Amin Sarder', 'Security Guard', NULL, NULL, NULL, '1912733841', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1094, 12, NULL, 48, 16, '663', 'Md. Asaduzzaaman', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '1757738995', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1095, 12, NULL, 48, 16, '698', 'Md.Babul Mollah', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1096, 12, NULL, 48, 16, '888', 'Syed Arafat Ali', 'Security Guard', NULL, NULL, NULL, '1991758345', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1097, 12, NULL, 48, 16, '1642', 'Md Amir Hossain', 'Security Guard', NULL, NULL, NULL, '1712476140', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1098, 12, NULL, 48, 16, '1865', 'Md. Rakib', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1099, 12, NULL, 48, 16, '1998', 'Robin Sadar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1100, 12, NULL, 48, 16, '2070', 'Md. Ariful Isalm', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1101, 12, NULL, 48, 16, '2080', 'Md. Tofazzal', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1102, 12, NULL, 48, 16, '2098', 'Alamin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1103, 12, NULL, 48, 16, '2117', 'Md. Anwar Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1104, 12, NULL, 48, 16, '2121', 'Md. Sabuj Babu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1105, 12, NULL, 48, 16, '2275', 'Md. Naeem Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1106, 12, NULL, 48, 16, '2324', 'Md. Babul Akter', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1107, 12, NULL, 48, 16, '2382', 'Md. Kawsarul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1108, 12, NULL, 48, 16, '2383', 'Md. Shohidul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1109, 12, NULL, 48, 16, '2408', 'Md. Golam Rasul', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1110, 12, NULL, 48, 16, '2498', 'Md. Josim Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1111, 12, NULL, 48, 16, '2499', 'Md. Ripon Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1112, 12, NULL, 48, 16, '2540', 'Md. Rafiqul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1113, 12, NULL, 48, 16, '2562', 'Md. Amran Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1114, 12, NULL, 48, 16, '2579', 'Md. Saiful Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1115, 12, NULL, 48, 16, '2607', 'Md. Jashim Uddin', 'Security Guard', NULL, NULL, NULL, '1816132976', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1116, 12, NULL, 48, 16, '2614', 'Md. Jamir Hossain', 'Security Guard', NULL, NULL, NULL, '1717701694', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1117, 12, NULL, 48, 16, '2643', 'Md. Sujan Howlader', 'Security Guard', NULL, NULL, NULL, '1993124049', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1118, 12, NULL, 48, 16, '2715', 'Md. Harunur Or Rashid', 'Security Guard', NULL, NULL, NULL, '1965157147', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1119, 12, NULL, 48, 16, '2749', 'Imran Ahmed', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1120, 12, NULL, 48, 16, '2750', 'Md. Rafiqul Islam', 'Security Inspector', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1121, 12, NULL, 48, 16, '2772', 'Md. Parvej', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1122, 12, NULL, 48, 16, '2773', 'Md. Sazib Khan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1123, 12, NULL, 48, 16, '2777', 'Md. Kamrul Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1124, 12, NULL, 48, 16, '2774', 'Md. Nur Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1125, 12, NULL, 48, 16, '2862', 'Md. Ashiqur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1126, 12, NULL, 48, 16, '2872', 'MD. Alamgir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1127, 12, NULL, 48, 16, '2903', 'Ms. Taslima Akter', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1128, 12, NULL, 48, 16, '2906', 'Milan Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1129, 12, NULL, 48, 16, '3015', 'Md Ariful Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1130, 12, NULL, 48, 16, '3008', 'Md Ansar Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1131, 12, NULL, 48, 16, '3038', 'Md Majharul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1132, 12, NULL, 48, 16, '3050', 'Md Rabin Napti', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1133, 12, NULL, 48, 16, '3158', 'Md Salman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1134, 12, NULL, 48, 16, '3156', 'Md Arif Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1135, 12, NULL, 48, 16, '3198', 'Kazi Ibrahim Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1136, 12, NULL, 48, 16, '3215', 'Md Mehedi Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1137, 12, NULL, 48, 16, '3208', 'Merilin Beauty Soren', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1138, 12, NULL, 48, 16, '3221', 'Sherajum Monira', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1139, 12, NULL, 48, 16, '3234', 'Moushume Akther', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1140, 12, NULL, 48, 16, '3241', 'Most. Sakila Aktar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1141, 12, NULL, 48, 16, '3305', 'Md Rabiul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1142, 12, NULL, 48, 16, '3358', 'Md Harun or Rashid', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1143, 12, NULL, 48, 16, '3375', 'Arif Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1144, 12, NULL, 48, 16, '3377', 'Ismail Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06');
INSERT INTO `employees` (`id`, `unit_id`, `company_id`, `department_id`, `location_id`, `employee_id`, `employee_name`, `designation`, `employee_description`, `gender`, `employee_email`, `employee_phone`, `employee_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1145, 12, NULL, 48, 16, '3379', 'Md Arju Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1146, 12, NULL, 48, 16, '3418', 'Hasnain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1147, 12, NULL, 48, 16, '3419', 'Marufa Akter', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1148, 12, NULL, 48, 16, '3415', 'Md Rakib Al-Hasan Rakib', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1149, 12, NULL, 48, 16, '3430', 'Rumana Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1150, 12, NULL, 48, 16, '3424', 'Amit Mojomder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1151, 12, NULL, 48, 16, '3421', 'Shahin Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1152, 12, NULL, 48, 16, '3452', 'Md Alam Husen ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1153, 12, NULL, 48, 16, '3453', 'Md Imran Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1154, 12, NULL, 48, 16, '3457', 'Md Juwel Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1155, 12, NULL, 48, 16, '3458', 'Md Riyad', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1156, 12, NULL, 48, 16, '3449', 'Bashudev', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1157, 12, NULL, 48, 16, '3450', 'Md Fahim Hasan All Amin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1158, 12, NULL, 48, 16, '3447', 'Md Sohan Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1159, 12, NULL, 48, 16, '3446', 'Mostafezur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1160, 12, NULL, 48, 16, '3448', 'Munna Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1161, 12, NULL, 48, 16, '3451', 'Sagor Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1162, 12, NULL, 48, 16, '3479', 'Ismail Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1163, 12, NULL, 48, 16, '3478', 'Md Abdur Razzak', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1164, 12, NULL, 48, 16, '3501', 'Monir Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1165, 12, NULL, 48, 16, '3530', 'Lamia Begum', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1166, 12, NULL, 48, 16, '3531', 'Saidi Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1167, 12, NULL, 48, 16, '3537', 'Helal Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1168, 12, NULL, 48, 16, '3538', 'Md Samsul Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1169, 12, NULL, 48, 16, '3536', 'Suktara', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1170, 12, NULL, 48, 16, '3541', 'Md Abu Hasan Munna', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1171, 12, NULL, 48, 16, '3544', 'Md Miju Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1172, 12, NULL, 48, 16, '3606', 'Ms.Jesmin Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1173, 12, NULL, 48, 16, '3564', 'Md Yousuf Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1174, 12, NULL, 48, 16, '3628', 'Bulbul Ahammad', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1175, 12, NULL, 48, 16, '3627', 'Md Mehedi Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1176, 12, NULL, 48, 16, '3630', 'Shukur Mahbub', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1177, 12, NULL, 48, 16, '3632', 'Mahmudul Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1178, 12, NULL, 48, 16, '3641', 'Sharmin Nahar', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1179, 12, NULL, 48, 16, '3644', 'Khoshed Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1180, 12, NULL, 48, 16, '3645', 'Md Rasel Hassan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1181, 12, NULL, 48, 16, '3686', 'Taibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1182, 12, NULL, 48, 16, '3799', 'Md Masud Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1183, 12, NULL, 48, 16, '3798', 'Md Ashikur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1184, 12, NULL, 48, 16, '3779', 'Md Kamrul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1185, 12, NULL, 48, 16, '3809', 'Md Dulal Ahmed', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1186, 12, NULL, 48, 16, '3780', 'Md Shamsut Tabreej Shoikot', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1187, 12, NULL, 48, 16, '3782', 'Md Shazzad Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1188, 12, NULL, 48, 16, '3785', 'Maynul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1189, 12, NULL, 48, 16, '3790', 'Md Rajib Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1190, 12, NULL, 48, 16, '3821', 'Md Sazzad Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1191, 12, NULL, 48, 16, '3869', 'Md Abdul Mannan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1192, 12, NULL, 48, 16, '3866', 'Md Billal Hossain Sheikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1193, 12, NULL, 48, 16, '3870', 'Md Yousuf', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1194, 12, NULL, 48, 16, '3867', 'Mohadib Roy', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1195, 12, NULL, 48, 16, '3865', 'Sohel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1196, 12, NULL, 48, 16, '3868', 'Ratul Biswas', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1197, 12, NULL, 48, 16, '3946', 'Abdus Salam Shaikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1198, 12, NULL, 48, 16, '3950', 'Md Konok Sheikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1199, 12, NULL, 48, 16, '3949', 'Md Rasel Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1200, 12, NULL, 48, 16, '3947', 'Sujon Kumar Shikder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1201, 12, NULL, 48, 16, '3943', 'Habibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1202, 12, NULL, 48, 16, '3944', 'Md Hasanur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1203, 12, NULL, 48, 16, '3926', 'Md Maruf Hosen ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1204, 12, NULL, 48, 16, '3923', 'Md Rajib ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1205, 12, NULL, 48, 16, '3945', 'Md Shahajalal', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1206, 12, NULL, 48, 16, '3922', 'Taslima Khatun ', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1207, 12, NULL, 48, 16, '3954', 'Md Moniruzzaman Papon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1208, 12, NULL, 48, 16, '4064', 'Tanzim Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1209, 12, NULL, 48, 16, '3974', 'Kamruzzaman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1210, 12, NULL, 48, 16, '3983', 'Md Amit Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1211, 12, NULL, 48, 16, '3981', 'Md Eaheshan Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1212, 12, NULL, 48, 16, '3982', 'Mst Rumana Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1213, 12, NULL, 48, 16, '4007', 'Mohammad Kamal Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1214, 12, NULL, 48, 16, '4053', 'Mehedi Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1215, 12, NULL, 48, 16, '4061', 'Md Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1216, 12, NULL, 48, 16, '4082', 'Md Naim Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1217, 12, NULL, 48, 16, '4111', 'Md Abdullah Al Mamun', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1218, 12, NULL, 48, 16, '4110', 'Md Hafizur Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1219, 12, NULL, 48, 16, '4143', 'Md Torikul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1220, 12, NULL, 48, 16, '4144', 'Mirazul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1221, 12, NULL, 48, 16, '4147', 'Razu Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1222, 12, NULL, 48, 16, '4146', 'Shakil Ahmed', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1223, 12, NULL, 48, 16, '3948', 'Md Mainuddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1224, 12, NULL, 48, 16, '4159', 'Md Murad Hossen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1225, 12, NULL, 48, 16, '4160', 'Mst. Zabia Yesmin', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1226, 12, NULL, 48, 16, '4050', 'Soumik Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1227, 12, NULL, 48, 16, '3363', 'Md Shahidul Haque', 'Bouncer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1228, 12, NULL, 48, 16, '4121', 'Md Salim Reza', 'Bouncer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1229, 4, NULL, 5, 16, '3969', 'Jahid Hosen Shuvo', 'Storekeeper', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1230, 4, NULL, 9, 16, '511', 'Md. Ahsan', 'Canteen Assistant', NULL, NULL, 'mohammad19810101@gmail.com', '1780869343', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1231, 4, NULL, 9, 16, '1136', 'Abdul Hasem', 'Mechanic (MEP)', NULL, NULL, 'mohammad19810101@gmail.com', '1796358977', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1232, 4, NULL, 9, 16, '1409', 'Shahadat Hossain', 'Welder', NULL, NULL, 'mohammad19810101@gmail.com', '1767242495', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1233, 4, NULL, 9, 16, '1694', 'Md.Abu Zafor', 'Senior Manager', NULL, NULL, 'zafor@uhrlbd.com', '1715657751', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1234, 4, NULL, 9, 16, '1860', 'Shah Mahmood', 'Officer (Store)', NULL, NULL, 'audacious.bappybd@gmail.com', '1712654451', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1235, 4, NULL, 17, 16, '1967', 'Md. Sujon Ali', 'Project Engineer (MEP)', NULL, NULL, 'sujon@uhrlbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1236, 4, NULL, 17, 16, '1992', 'Md. Mohid Hossain', 'Project Engineer', NULL, NULL, 'mohid@uhrlbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1237, 4, NULL, 17, 16, '3620', 'Md. Arif Mahmud', 'Assistant Manager (Electrical)', NULL, NULL, NULL, '01682-514120', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1238, 4, NULL, 17, 16, '2283', 'Mijanur Rare', 'Junior Engineer (Civil)', NULL, NULL, NULL, '1723370821', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1239, 4, NULL, 26, 16, '1745', 'Abdul Kuddus', 'Supervisor (IT)', NULL, NULL, 'mohammad19810101@gmail.com', '1621014848', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1240, 4, NULL, 41, 16, '3408', 'Md Shakawat Hossain', 'Chief Executive Officer', NULL, NULL, 'shakawath.hossain@uhrlbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1241, 4, NULL, 46, 16, '229', 'Hamayet Hossain Rasel', 'General Manager', NULL, NULL, 'rasel@borakbd.com', '1715253066', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1242, 4, NULL, 46, 16, '4042', 'Aktaruzzaman', 'Project Engineer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1243, 4, NULL, 46, 16, '1523', 'Md. Shahinur Islam Razib', 'Deputy Project Engineer', NULL, NULL, 'doc.controller@uhrlbd.com', '1737138859', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1244, 4, NULL, 48, 16, '2358', 'Md. Sakim Miya', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1245, 3, NULL, 4, 17, '3839', 'Mohammad Jamil Hossain', 'Coordination Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1246, 3, NULL, 4, 17, '4135', 'Md Dakinul Islam Pasha', 'In-Charge (Molecular Lab)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1247, 3, NULL, 6, 17, '1311', 'Md.Anamul Haque', 'Executive (Purchase & Accounts)', NULL, NULL, 'anamul.uniquegroup@gmail.com', '1712444722', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1248, 3, NULL, 12, 17, '2839', 'Mahbubur Rahaman', 'Bell Captain', NULL, NULL, NULL, '1632926282', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1249, 3, NULL, 12, 17, '2918', 'Shofiul Jadid', 'Bell Boy', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1250, 3, NULL, 13, 17, '1417', 'Masud Parvez', 'Executive', NULL, NULL, 'mpmasum91@gmail.com', '1725902591', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1251, 3, NULL, 13, 17, '2991', 'Abu Sayeem', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1252, 3, NULL, 13, 17, '2934', 'Mustafizur Sharif', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1253, 3, NULL, 13, 17, '3140', 'Farhad Hossain', 'Report Delivery', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1254, 3, NULL, 15, 17, '2919', 'Md. Asikur Rahman', 'Bell Boy', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1255, 3, NULL, 15, 17, '3655', 'Md Kamran Hossain', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1256, 3, NULL, 15, 17, '3656', 'Monirul Islam Chowdhury', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1257, 3, NULL, 15, 17, '3736', 'Bishal Barua ', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1258, 3, NULL, 15, 17, '3737', 'Md. Mostafizur Rahman', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1259, 3, NULL, 15, 17, '3766', 'Said rahman Shifat', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1260, 3, NULL, 15, 17, '3765', 'Tanin Hossain', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1261, 3, NULL, 15, 17, '2878', 'Sumiya', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1262, 3, NULL, 15, 17, '3366', 'Md Sanaullah', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1263, 3, NULL, 15, 17, '3411', 'Kheleda Akter', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1264, 3, NULL, 15, 17, '3726', 'Anik Hasan Noyon', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1265, 3, NULL, 15, 17, '3747', 'Anik Hasan Noyon', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1266, 3, NULL, 15, 17, '3738', 'Imrul Kayesh Emon', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1267, 3, NULL, 15, 17, '3739', 'Md. Jahirul Islam', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1268, 3, NULL, 15, 17, '3748', 'Nitish Gain', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1269, 3, NULL, 15, 17, '3749', 'Uttam Kumar', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1270, 3, NULL, 15, 17, '3769', 'Md Mirazul Islam', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1271, 3, NULL, 15, 17, '3772', 'Md Ariful Islam', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1272, 3, NULL, 15, 17, '3802', 'Ridoy Khan ', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1273, 3, NULL, 15, 17, '3804', 'Md Shariful Islam', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1274, 3, NULL, 15, 17, '3951', 'Sarmin Ahammad Lima', 'Report Delivery', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1275, 3, NULL, 16, 17, '2588', 'Professor Dr. Forhad Monjur', 'Director', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1276, 3, NULL, 16, 17, '2584', 'Md. Iftekher Ahmed', 'AC Technician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1277, 3, NULL, 16, 17, '2617', 'Saddam Hossain', 'Bell Captain', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1278, 3, NULL, 16, 17, '2626', 'Mst. Shammi Akter', 'AC Technician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1279, 3, NULL, 16, 17, '2600', 'Rajia Parvin Surove', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1280, 3, NULL, 16, 17, '2628', 'Soniya Najmeen', 'Report Delivery', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1281, 3, NULL, 16, 17, '4103', 'Salima Khanam', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1282, 3, NULL, 19, 17, '3024', 'Mahatab Howlader', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1283, 3, NULL, 19, 17, '3177', 'Moazzem Hossain Bhuiyan', 'Executive', NULL, NULL, NULL, '1928336195', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1284, 3, NULL, 19, 17, '3647', 'Md. Jahangir Alam', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1285, 3, NULL, 21, 17, '3654', 'Md. Amirul Islam', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1286, 3, NULL, 26, 17, '2845', 'Md. Habibur Rahman', 'Electrical Engineer', NULL, NULL, NULL, '1719417618', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1287, 3, NULL, 29, 17, '3552', 'Ratna Akter', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1288, 3, NULL, 29, 17, '3703', 'Shishir Chandra Gonophati', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1289, 3, NULL, 29, 17, '3727', 'Md Motiur Rahman', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1290, 3, NULL, 29, 17, '3742', 'Md. Imrul kayes', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1291, 3, NULL, 29, 17, '3744', 'Md. Nahid Hasan', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1292, 3, NULL, 29, 17, '3743', 'Khadiza Akter', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1293, 3, NULL, 29, 17, '3745', 'Animesh Sharma Shishir', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1294, 3, NULL, 29, 17, '3740', 'Tanzia Akter', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1295, 3, NULL, 29, 17, '3770', 'Badhan Kumar Muzumder', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1296, 3, NULL, 29, 17, '3771', 'Singdha Monira Sarker', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1297, 3, NULL, 29, 17, '3895', 'Hamida Sultana Ahona', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1298, 3, NULL, 29, 17, '3953', 'Hamida Sultana Ahona', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1299, 3, NULL, 33, 17, '3104', 'Helal Uddin', 'Duty Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1300, 3, NULL, 33, 17, '3105', 'Md Abu Saim', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1301, 3, NULL, 33, 17, '3524', 'Md Jakir Hossain', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1302, 3, NULL, 33, 17, '3362', 'Joysen Marma', 'Graphic Desinger', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1303, 3, NULL, 36, 17, '3658', 'Md. Rafiqul Islam', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1304, 3, NULL, 36, 17, '3657', 'Noman Siddik', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1305, 3, NULL, 36, 17, '3803', 'Sumaiya Ridita', 'Report Delivery', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1306, 3, NULL, 38, 17, '3650', 'Asraful Alam Anik', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1307, 3, NULL, 38, 17, '3648', 'Shamim Hossain Fami', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1308, 3, NULL, 38, 17, '3649', 'Titu Kumar Shil', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1309, 3, NULL, 39, 17, '2853', 'Asaduzzaman', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1310, 3, NULL, 39, 17, '2932', 'Tanvir Ahmed', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1311, 3, NULL, 39, 17, '2947', 'Zannaton Naeem', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1312, 3, NULL, 39, 17, '2425', 'Md. Arifur Rahman', 'In-Charge (Molecular Lab)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1313, 3, NULL, 41, 17, '841', 'Apurba Mridha', 'Assistant Lab Techologist', NULL, NULL, 'apumridha22@gmail.com', '1736297169', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1314, 3, NULL, 41, 17, '845', 'Dewan Abdul Kayum', 'Assistant X-Ray Technician', NULL, NULL, 'mdkayumgcl@gmail.com', '1916036956', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1315, 3, NULL, 41, 17, '864', 'Md. Mizanur Rahman', 'Lab In-charge', NULL, NULL, 'saqiluepl.ug@gmail.com', '1714417072', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1316, 3, NULL, 41, 17, '1462', 'Dr. Nigar Sultana', 'Doctor (Physical Test)', NULL, NULL, 'nigarsultana756@gmail.com', '1762549956', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1317, 3, NULL, 41, 17, '1634', 'Shakh Sadi', 'Data Entry Operator', NULL, NULL, 'shadi.gcl@gmail.com', '1919596468', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1318, 3, NULL, 41, 17, '2527', 'Nazmun Nahar Pata', 'Blood Sample Collector', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1319, 3, NULL, 41, 17, '3714', 'Bijoy Chowdhury', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1320, 3, NULL, 41, 17, '3725', 'Habibur Rahman', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1321, 3, NULL, 41, 17, '3715', 'Md Mehebub Hassa', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1322, 3, NULL, 41, 17, '3710', 'Md Rifat Hossen Sarker', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1323, 3, NULL, 41, 17, '3711', 'Riad Mahmud', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1324, 3, NULL, 41, 17, '3712', 'Riful Islam', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1325, 3, NULL, 41, 17, '3713', 'Surojit Barua', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1326, 3, NULL, 41, 17, '3750', 'Abdur Razzak', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1327, 3, NULL, 41, 17, '3730', 'Mehedi Hasan', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1328, 3, NULL, 41, 17, '3729', 'Rakibul Hasan', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1329, 3, NULL, 41, 17, '3732', 'Hasibul Islam ', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1330, 3, NULL, 41, 17, '3735', 'Satyajit Saha Rony ', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1331, 3, NULL, 41, 17, '3763', 'Md Shamsul Islam', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1332, 3, NULL, 41, 17, '4104', 'Miraz Hossain', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1333, 3, NULL, 41, 17, '208', 'A.M.Moniruzzaman', 'Assistant General Manager & Incharge', NULL, NULL, 'rubel@uniquegroupbd.com', '1915111000', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1334, 3, NULL, 41, 17, '862', 'Dr. M. M. Monzur Hassan', 'Consultant', NULL, NULL, 'saqiluepl.ug@gmail.com', '1711542112', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1335, 3, NULL, 41, 17, '2431', 'Hajera Akter', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1336, 3, NULL, 41, 17, '2429', 'Md. Hazzaz Bin Motin', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1337, 3, NULL, 41, 17, '2437', 'Rita Akhtar', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1338, 3, NULL, 41, 17, '2427', 'Shakil Ahmed Kanon', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1339, 3, NULL, 41, 17, '2426', 'Dr. Md. Monirul Islam', 'Head of the Department - Molecular Lab', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1340, 3, NULL, 41, 17, '2449', 'Sajal Chandra Biswash', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1341, 3, NULL, 41, 17, '2448', 'Shapla Khatun', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1342, 3, NULL, 41, 17, '2509', 'Farzana Islam Choity', 'Customer Service Coordinator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1343, 3, NULL, 41, 17, '2510', 'Umme Habiba', 'Customer Service Coordinator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1344, 3, NULL, 41, 17, '2591', 'Jannatul Ferdose', 'Billing Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1345, 3, NULL, 41, 17, '2752', 'Md. Anwar Hossain', 'Medical Technologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1346, 3, NULL, 41, 17, '2759', 'Md. Manik Mia', 'Phlebotomist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1347, 3, NULL, 41, 17, '1249', 'Moshiur Rahman', 'Medical Assistant', NULL, NULL, 'milon.mia.222@gmail.com', '1726599796', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1348, 3, NULL, 41, 17, '3112', 'Choton Kanti', 'Report Delivery', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1349, 3, NULL, 42, 17, '3659', 'Md. Mazedul Islam', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1350, 3, NULL, 42, 17, '3707', 'Juel Mia', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1351, 3, NULL, 42, 17, '3741', 'Moklesur rahman Sarker', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1352, 3, NULL, 42, 17, '3767', 'Shah Poran', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1353, 3, NULL, 42, 17, '3768', 'Wahidul Islam Rabbi', 'Medical Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1354, 3, NULL, 49, 17, '3029', 'Md. Aminul Islam', 'Executive (Marketing)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1355, 3, NULL, 49, 17, '3444', 'Dr Khandakar Md Rayhanul Kabir', 'Senior Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1356, 3, NULL, 49, 17, '4130', 'Mohammad Kamruzzaman ', 'Assiatant Manager (Sales & Reservation)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1357, 3, NULL, 49, 17, '2814', 'Md. Matiur Rahman', 'Marketing Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1358, 3, NULL, 53, 17, '1793', 'Md. Anik', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1935920137', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1359, 3, NULL, 53, 17, '1917', 'Md. Emran Ali', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1360, 12, NULL, 4, 17, '3259', 'Md. Masud Rana', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1361, 12, NULL, 4, 17, '3258', 'Md. Moinul Islam', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1362, 12, NULL, 4, 17, '3260', 'Nazmul Haque', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1363, 12, NULL, 4, 17, '3805', 'Syed Mahedi Hasan Roman', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1364, 12, NULL, 18, 17, '2998', 'Md. Miraj Ahmed Jewel', 'Office Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1365, 12, NULL, 18, 17, '3192', 'Md.Kamal Hossain', 'Housekeeping Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1366, 12, NULL, 18, 17, '3327', 'Hossain Ahmed Babu', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1367, 12, NULL, 18, 17, '3498', 'Salman Samir Habibullah', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1368, 12, NULL, 18, 17, '3557', 'Md Shawon', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1369, 12, NULL, 18, 17, '3565', 'Md Rasel', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1370, 12, NULL, 18, 17, '3807', 'Md Robiul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1371, 12, NULL, 18, 17, '3812', 'Md Rabbi Mia', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1372, 12, NULL, 18, 17, '3813', 'Md Rakib Howlader', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1373, 12, NULL, 18, 17, '3814', 'Mst. Sahina Begum', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1374, 12, NULL, 18, 17, '3816', 'Md Morsedur Rahman Mosarof', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1375, 12, NULL, 18, 17, '3817', 'Md Rasel', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1376, 12, NULL, 18, 17, '3914', 'Md Galib Hossain ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1377, 12, NULL, 18, 17, '3905', 'Md Lion', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1378, 12, NULL, 18, 17, '3903', 'Md Rasel Miah ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1379, 12, NULL, 18, 17, '3900', 'Shawon', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1380, 12, NULL, 18, 17, '4024', 'Iqbal Hossain Ador', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1381, 12, NULL, 18, 17, '4025', 'Md Fardows amal', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1382, 12, NULL, 18, 17, '4073', 'Sobuz Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1383, 12, NULL, 18, 17, '4075', 'Jaharul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1384, 12, NULL, 18, 17, '4139', 'Parvez Mosharof', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1385, 12, NULL, 18, 17, '4142', 'Mosammad Halima Akter', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1386, 12, NULL, 23, 17, '2652', 'Md. Arif Hossain', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1387, 12, NULL, 48, 17, '199', 'Md. Yakub Ali', 'Security Guard', NULL, NULL, NULL, '1764442620', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1388, 12, NULL, 48, 17, '237', 'Md.Abu Sahid Bishas', 'Security Supervisor', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1389, 12, NULL, 48, 17, '2959', 'Md. Abu Bokor Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1390, 12, NULL, 48, 17, '3014', 'Biswajit Ghagra', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1391, 12, NULL, 48, 17, '3075', 'Md Firoz Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1392, 12, NULL, 48, 17, '3797', 'Md Shamim Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1393, 12, NULL, 48, 17, '3781', 'Md Mostafizur Rahman', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1394, 12, NULL, 48, 17, '3831', 'Al-Amin Matubber', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1395, 12, NULL, 48, 17, '3830', 'Md Mosharaf Hossain Chowdhury', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1396, 12, NULL, 48, 17, '3887', 'Sojib Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1397, 12, NULL, 48, 17, '3886', 'Md Sojib Sheikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1398, 12, NULL, 48, 17, '4084', 'Golam Rosul Yeasin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1399, 12, NULL, 48, 18, '3643', 'Md Sabuj Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1400, 4, NULL, 3, 18, '2086', 'Muhammad Abul Kalam Talukdar', 'Resident Manager', NULL, NULL, 'kalam@hansa.com.bd', '8801711586465', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1401, 4, NULL, 17, 18, '1578', 'Haroshit Poddeer', 'General Electrician', NULL, NULL, 'haroshitp@gmail.com', '1771438819', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1402, 4, NULL, 17, 18, '1596', 'Proshanto Kumer Roy', 'Assistant Engineer', NULL, NULL, 'engineering@hansa.com.bd', '1726864147', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1403, 4, NULL, 17, 18, '1615', 'Kazi Abul Bashar', 'Assistant Engineer', NULL, NULL, 'engineering@hansa.com.bd', '1770262064', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1404, 4, NULL, 17, 18, '1699', 'Al Mamun', 'General Electrician', NULL, NULL, 'mamun.ur.rahman734@gmail.com', '1778888734', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1405, 4, NULL, 17, 18, '1914', 'Md. Abdullah', 'Plumber', NULL, NULL, NULL, '1932359639', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1406, 4, NULL, 17, 18, '2326', 'Abdulla Al Noman', 'Painter Cum Sr. General Technician', NULL, NULL, NULL, '1815489542', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1407, 4, NULL, 17, 18, '3393', 'Bappy Shil', 'General Technician', NULL, NULL, NULL, '1768055333', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1408, 4, NULL, 18, 18, '1612', 'Rajul Islam', 'Public Area Attendant', NULL, NULL, 'm.chy@hansa.com.bd', '1620766260', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1409, 4, NULL, 18, 18, '1610', 'Mintu Mia', 'Public Area Attendant', NULL, NULL, 'm.chy@hansa.com.bd', '1783382526', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1410, 4, NULL, 18, 18, '2058', 'Asaduzzaman', 'Public Area Attendant', NULL, NULL, NULL, '01626-553688', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1411, 4, NULL, 18, 18, '2332', 'Md. Moynul Islam', 'Public Area Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1412, 4, NULL, 18, 18, '2365', 'Md. Rubel Hossain', 'Public Area Attendant', NULL, NULL, NULL, '1724863095', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1413, 4, NULL, 18, 18, '3111', 'Md Shamim Hossain', 'Steward', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1414, 4, NULL, 18, 18, '3437', 'Sumon Mondal', 'Room Attendant', NULL, NULL, NULL, '10770290831', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1415, 4, NULL, 18, 18, '3622', 'Abdur Rahim', 'Gardener', NULL, NULL, NULL, '1746763498', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1416, 4, NULL, 18, 18, '3462', 'Md Lutfar Rahman', 'Housekeeping Attendant', NULL, NULL, NULL, '1781477244', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1417, 4, NULL, 19, 18, '1752', 'Kamal Hossain', 'General Cashier', NULL, NULL, 'kamalhossain382@yahoo.com', '1878914945', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1418, 4, NULL, 19, 18, '1877', 'Md. Ali Akbar', 'Assistant Manager (Purchase & Store)', NULL, NULL, 'aliakbarmi256@gmail.com', '1682821322', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1419, 4, NULL, 19, 18, '2350', 'Md. Sohel Chowdhury', 'Assistant Manager', NULL, NULL, NULL, '1833627868', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06');
INSERT INTO `employees` (`id`, `unit_id`, `company_id`, `department_id`, `location_id`, `employee_id`, `employee_name`, `designation`, `employee_description`, `gender`, `employee_email`, `employee_phone`, `employee_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1420, 4, NULL, 19, 18, '2980', 'Shajib Hossain', 'Senior Executive', NULL, NULL, 'sajib@hansa.com.bd', '8801923595857', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1421, 4, NULL, 19, 18, '1504', 'Md. Mamun Ar Rashid', 'Assistant Finance Manager', NULL, NULL, 'm.rashid@hansa.com.bd', '01921539285, 01739660018', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1422, 4, NULL, 19, 18, '2042', 'Md. Saddam Hossain', 'Assistant Officer (Store)', NULL, NULL, NULL, '1315389065', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1423, 4, NULL, 19, 18, '2848', 'Rahat Ara Nijhum', 'Income Auditor - Finance', NULL, NULL, NULL, '1884611604', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1424, 4, NULL, 20, 18, '1656', 'Liton Mozumder', 'Demi Chef de Partie', NULL, NULL, 'm.chy@hansa.com.bd', '1752229290', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1425, 4, NULL, 20, 18, '1658', 'Muhammad Saiful Islam', 'Commis II', NULL, NULL, 'm.chy@hansa.com.bd', '1677159133', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1426, 4, NULL, 20, 18, '1747', 'Md. Farid Ahmed Mazumder', 'Executive Chef', NULL, NULL, 'e.chef@hansa.com.bd', '1912023451', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1427, 4, NULL, 20, 18, '1840', 'Mohammad Shariful Islam', 'Chef de Partie', NULL, NULL, NULL, '1988851051', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1428, 4, NULL, 20, 18, '1994', 'Iqbal Miah', 'Demi Chef de Partie', NULL, NULL, NULL, '1616661702', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1429, 4, NULL, 20, 18, '2544', 'Uzzal Charles Gomes', 'Steward', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1430, 4, NULL, 20, 18, '2733', 'Syed Raihan Hasan', 'Commis I', NULL, NULL, NULL, '1916008556', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1431, 4, NULL, 20, 18, '2744', 'Tomal Gomes', 'Commis I', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1432, 4, NULL, 20, 18, '3002', 'Moazzem Hossain Missan', 'Commis II', NULL, NULL, NULL, '1752559539', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1433, 4, NULL, 20, 18, '3139', 'Safikulakon', 'Commis II', NULL, NULL, NULL, '1770141930', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1434, 4, NULL, 20, 18, '1501', 'Ayub Hossain Khan', 'Senior Steward', NULL, NULL, 'm.chy@hansa.com.bd', '1747679202', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1435, 4, NULL, 21, 18, '1599', 'Md. Mohoshin Alam Rasel', 'Senior Waiter', NULL, NULL, 'm.chy@hansa.com.bd', '1679739101', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1436, 4, NULL, 21, 18, '1601', 'Palash Dey', 'Supervisor.', NULL, NULL, 'palasdey.joy@gmail.com', '1711223188', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1437, 4, NULL, 21, 18, '1529', 'Md. Rakibul Hossain', 'Assistant Restaurant Manager', NULL, NULL, 'r.hossain@hansa.com.bd', '1717566872', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1438, 4, NULL, 21, 18, '2664', 'Soikat Mridha', 'Waiter', NULL, NULL, NULL, '1628000351', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1439, 4, NULL, 21, 18, '2758', 'Mohammad Abu Saker', 'Senior Supervisor', NULL, NULL, NULL, '1736795434', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1440, 4, NULL, 21, 18, '3492', 'Pavel Ahmed', 'Senior Waiter', NULL, NULL, NULL, '1757039969', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1441, 4, NULL, 21, 18, '3621', 'Golam Habib Fahim', 'Waiter', NULL, NULL, NULL, '1627738719', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1442, 4, NULL, 21, 18, '3894', 'Amir Ahmed', 'Commis I', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1443, 4, NULL, 21, 18, '2894', 'Firuz Ahamed', 'F & B Service Captain', NULL, NULL, NULL, '1776407883', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1444, 4, NULL, 21, 18, '2912', 'Giko Hossain', 'F & B Service Captain', NULL, NULL, NULL, '1918563442', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1445, 4, NULL, 21, 18, '2914', 'Sitesh Dewan', 'Bartender', NULL, NULL, NULL, '1716648688', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1446, 4, NULL, 22, 18, '1696', 'Md. Shakhawat Hossain Talukdar', 'Duty Manager', NULL, NULL, 'shakha.talukder@gmail.com', '1752464178', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1447, 4, NULL, 22, 18, '1875', 'Makhing U Marma', 'SPA Therapist', NULL, NULL, 'N/A', '8801767726679', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1448, 4, NULL, 22, 18, '2035', 'Polita Hajong', 'SPA Therapist', NULL, NULL, NULL, '1304775916', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1449, 4, NULL, 22, 18, '2162', 'Salman Yousuf Kamal', 'Assistant Front Office Manager', NULL, NULL, NULL, '1772144076', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1450, 4, NULL, 22, 18, '2215', 'Asif Ahmed', 'Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1451, 4, NULL, 22, 18, '2629', 'Moshfiqur Rahman', 'Guest Service Agent', NULL, NULL, NULL, '1675108084', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1452, 4, NULL, 22, 18, '2653', 'Saieda Afroja', 'Guest Service Agent', NULL, NULL, NULL, '1793908972', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1453, 4, NULL, 22, 18, '2985', 'Srity Akter', 'SPA Therapist', NULL, NULL, NULL, '1772059104', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1454, 4, NULL, 22, 18, '3403', 'Mohammad Mashfique Kabir', 'Bell Captain', NULL, NULL, NULL, '017300620921;01624710535', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1455, 4, NULL, 22, 18, '3488', 'Yousuf Jamil Shaon', 'Duty Manager', NULL, NULL, NULL, '1717315261', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1456, 4, NULL, 22, 18, '1964', 'Willeam Nitu Roni', 'GYM Trainer', NULL, NULL, NULL, '1724150301', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1457, 4, NULL, 23, 18, '1526', 'Md. Anishur Rahman', 'Housekeeping Supervisor', NULL, NULL, 'hk@hansa.com.bd', '1821210820', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1458, 4, NULL, 23, 18, '1537', 'Abul Kalam Azad', 'Shift Leader', NULL, NULL, 'abulkalamakhon36@gmail.com', '1966635269', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1459, 4, NULL, 23, 18, '1742', 'Shahadat Hossain', 'Housekeeping Supervisor', NULL, NULL, 'shahadatshepon@gmail.com', '1847097491', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1460, 4, NULL, 23, 18, '1758', 'Md. Mahamudul Hasan', 'Shift Leader', NULL, NULL, 'mahamudulhasan1114@gmail.com', '1712762473', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1461, 4, NULL, 23, 18, '1759', 'Md. Nazrul Islam', 'Shift Leader', NULL, NULL, 'nazrulislamanik123@gmail.com', '1828584747', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1462, 4, NULL, 23, 18, '2720', 'Md. Noornabi Ahmed', 'Room Attendant', NULL, NULL, NULL, '1684673439', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1463, 4, NULL, 23, 18, '2742', 'Saidu Rahman', 'Room Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1464, 4, NULL, 23, 18, '2808', 'Ripon Sarkar', 'Shift Leader', NULL, NULL, NULL, '1766417988', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1465, 4, NULL, 23, 18, '4101', 'Md Hamim', 'Room Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1466, 4, NULL, 25, 18, '2054', 'Md. Rezwanul Haque', 'Senior Executive', NULL, NULL, 'rezwanul@hansa.com.bd', '1534404041', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1467, 4, NULL, 26, 18, '2630', 'Mohammad Johir Uddin', 'Manager', NULL, NULL, 'johir@hansa.com.bd', '1771998855', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1468, 4, NULL, 41, 18, '2505', 'Priya Mondol', 'SPA Therapist', NULL, NULL, 'N/A', '1886861050', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1469, 4, NULL, 48, 18, '202', 'Md.Aowal Mia', 'Security Guard', NULL, NULL, NULL, '1918353941', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1470, 4, NULL, 48, 18, '288', 'Md.Humayun Kabir', 'Security Guard', NULL, NULL, NULL, '1745798361', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1471, 4, NULL, 48, 18, '693', 'Masud Rana', 'Security Guard', NULL, NULL, NULL, '1947347497', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1472, 4, NULL, 48, 18, '1116', 'Md.Ahsan Ullah', 'Security Guard', NULL, NULL, 'ahsanullah49921@gmail.com', '1715371668', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1473, 4, NULL, 48, 18, '1122', 'Md.Bulbul Ahmmad', 'Security Guard', NULL, NULL, NULL, '1770713445', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1474, 4, NULL, 48, 18, '2904', 'Md. Hafizul Joadder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1475, 4, NULL, 48, 18, '3016', 'Md Motafa Kamal Juel', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1476, 4, NULL, 48, 18, '3097', 'Md Kamal Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1477, 4, NULL, 48, 18, '4020', 'Md Akash', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1478, 4, NULL, 49, 18, '1604', 'Rintu Chandra Saha', 'Manager', NULL, NULL, 'r.saha@hansa.com.bd', '1793560474', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1479, 4, NULL, 49, 18, '1734', 'Iftekhar Aam', 'Deputy Manager', NULL, NULL, 'iftekhar@alam@hansa.com.bd', '1685821038', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1480, 4, NULL, 49, 18, '1910', 'Md. Raihan Khan', 'Assistant Manager', NULL, NULL, 'r.khan@hansa.com.bd', '1729967468', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1481, 4, NULL, 49, 18, '3731', 'Md Tuhin Hossain ', 'Senior Executive', NULL, NULL, 'tuhin@hansa.com.bd', '8801780202828', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1482, 4, NULL, 49, 18, '2039', 'Md. P.H. Khan', 'Graphics Designer', NULL, NULL, 'pavel@hansa.com.bd', '1710250524', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1483, 4, NULL, 53, 18, '1617', 'Sirajul Haq', 'Driver.', NULL, NULL, 'm.chy@hansa.com.bd', '1820207303', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1484, 4, NULL, 53, 18, '2014', 'Md. Manjurul Islam Shahin', 'Mixture Machine Operator', NULL, NULL, NULL, '1717876002', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1485, 4, NULL, 53, 18, '2172', 'Rafiqe', 'Guest Driver', NULL, NULL, NULL, '1758148666', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1486, 4, NULL, 53, 18, '2854', 'Md. Towhid', 'Driver', NULL, NULL, NULL, '1952711424', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1487, 5, NULL, 48, 19, '253', 'Md.Younus Ali', 'Security Guard', NULL, NULL, NULL, '1756905550', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1488, 5, NULL, 48, 19, '725', 'Genarel Hossen', 'Security Guard', NULL, NULL, NULL, '1748180554', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1489, 15, NULL, 19, 19, '313', 'Md. Ashif', 'Senior Manager (Accounts & SAP FICO Coordinator)', NULL, NULL, 'ashif@borakbd.com', '1717168830', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1490, 15, NULL, 19, 19, '708', 'Sonia Akter', 'Assistant Manager', NULL, NULL, 'soniaakter@uniquegroupbd.com', '1721094063', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1491, 15, NULL, 19, 19, '3484', 'Mubinur Alam Chowdhury', 'Officer (Accounts)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1492, 15, NULL, 48, 19, '3988', 'Md Shakil Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1493, 5, NULL, 4, 19, '4017', 'Ranjan Biswas', 'Assiatant Manager (Admin)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1494, 5, NULL, 9, 19, '238', 'Md.Nazrul Islam', 'Surveyor', NULL, NULL, NULL, '1710628549', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1495, 5, NULL, 9, 19, '1161', 'A.K.M. Shajjad Alam', 'Sanitary & Plumbing Engineer', NULL, NULL, 'shajjadbd@yahoo.com', '1914418656', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1496, 5, NULL, 9, 19, '2157', 'Md. Anwar Hossain', 'Plumbing Assistant', NULL, NULL, NULL, '1770394814', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1497, 5, NULL, 10, 19, '419', 'Md. Emdadul Haque', 'Assistant Manager', NULL, NULL, 'emdadul@borakbd.com', '1760619493', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1498, 5, NULL, 14, 19, '471', 'Nahid Faisal Robin', 'General Manager', NULL, NULL, 'arch.robin@uniquegroupbd.com', '1717182526', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1499, 5, NULL, 14, 19, '1673', 'Maidul Islam', 'Manager', NULL, NULL, 'maidul@borakbd.com', '1912557915', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1500, 5, NULL, 14, 19, '2021', 'Md. Iftakhar Uddin', 'Manager', NULL, NULL, NULL, '1919812988', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1501, 5, NULL, 14, 19, '4133', 'Maynul Islam', 'Assistant Manager', NULL, NULL, NULL, '1629943336', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1502, 5, NULL, 14, 19, '32', 'Md. Belayet Hossain Patwary', 'CAD Operator', NULL, NULL, 'belayet@borakbd.com', '1741331270', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1503, 5, NULL, 14, 19, '190', 'Mahbubur Rahman ', 'Senior Manager (Structural Engineer)', NULL, NULL, 'mahbubur.rahman@borakbd.com', '1711154706', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1504, 5, NULL, 17, 19, '3085', 'Md Shahajahan Ali', 'Plumber', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1505, 5, NULL, 17, 19, '3719', 'Anup Kumar Biswas', 'Manager', NULL, NULL, NULL, '1711024852', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1506, 5, NULL, 17, 19, '3135', 'Mohammed Hanif', 'Deputy Manager (Contract & Billing)', NULL, NULL, NULL, '1716186235', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1507, 5, NULL, 17, 19, '3523', 'Md Nurun Nabi', 'Assistant Plumbing', NULL, NULL, NULL, '1757075448', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1508, 5, NULL, 18, 19, '558', 'Md. Abu Syed', 'AC Technician', NULL, NULL, 'bishwas@uniquehansa.com', '1712924700', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1509, 5, NULL, 19, 19, '73', 'Tanvir Ahmed Mamun', 'Assistant General Manager', NULL, NULL, 'tanvir.ahmed@borakbd.com', '1712613797', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1510, 5, NULL, 19, 19, '276', 'Md.Jamal Uddin', 'Senior Manager', NULL, NULL, 'jamal.uddin@uniquegroupbd.com', '1715081458', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1511, 5, NULL, 19, 19, '311', 'Mohammad Ripon Mia', 'Deputy Manager', NULL, NULL, 'ripon@uhrlbd.com', '1714671097', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1512, 5, NULL, 19, 19, '3493', 'Md Rasheduzzaman', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1513, 5, NULL, 19, 19, '4131', 'Md Abdullah Al-Mamun', 'Assiatant Manager (Accounts)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1514, 5, NULL, 25, 19, '1886', 'Aminul Hayder Chandan', 'Deputy General Manager', NULL, NULL, 'ahayder@uniquegroupbd.com', '1814659114', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1515, 5, NULL, 25, 19, '4037', 'Partha Paul', 'Executive - Data Analyst', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1516, 5, NULL, 26, 19, '3045', 'Md Nazmul Hossain Khan', 'Senior Executive', NULL, NULL, NULL, '1921156886', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1517, 5, NULL, 26, 19, '3046', 'Arifur Rahman', 'Assistant General Manager', NULL, NULL, NULL, '1613374953', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1518, 5, NULL, 26, 19, '3979', 'Mohammad Nahidul Islam', 'Assistant Manager (SAP)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1519, 5, NULL, 27, 19, '196', 'Nikhil Chandra Chakraborty', 'Assistant Manager', NULL, NULL, 'nikhil@uniquegroupbd.com', '1714639885', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1520, 5, NULL, 27, 19, '257', 'S.M.Mosabbirul Islam', 'General Manager', NULL, NULL, 'mosabbirul.islam@uniquegroupbd.com', '1711249426', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1521, 5, NULL, 27, 19, '3243', 'Minhaz Ahmed', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1522, 5, NULL, 27, 19, '3722', 'Saikat Mohammad Imran', 'Executive', NULL, NULL, NULL, '1836454968', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1523, 5, NULL, 27, 19, '3751', 'Sujan Kumar Kundu ', 'Executive', NULL, NULL, NULL, '1746492068', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1524, 5, NULL, 28, 19, '4089', 'Khaled Bin Kamal', 'General Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1525, 5, NULL, 30, 19, '256', 'Sheikh Ratan', 'Deputy General Manager', NULL, NULL, 'sheikh.ratan@borakbd.com', '1917094433', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1526, 5, NULL, 30, 19, '287', 'Md.Musharraf Hossain Choudhury', 'Deputy Manager', NULL, NULL, 'musharraf@borakbd.com', '1672089710', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1527, 5, NULL, 30, 19, '3616', 'Mohammad Jalal Uddin Ahmed', 'Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1528, 5, NULL, 30, 19, '348', 'Md. Amir Hossain', 'Assistant Officer (Land)', NULL, NULL, NULL, '1734540118', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1529, 5, NULL, 31, 19, '57', 'Md. Shajahan Sardar', 'Executive to MD', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1530, 5, NULL, 31, 19, '91', 'Abu Taleb', 'Advocate', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1531, 5, NULL, 31, 19, '494', 'Md.Rafiqul Islam', 'Manager (Legal & Corporate Affairs)', NULL, NULL, 'rafiq.legal@borakbd.com', '1915165516', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1532, 5, NULL, 32, 19, '45', 'Mr. Safiqul Alam', 'Senior Manager', NULL, NULL, 'safiq@borakbd.com', '1769501543', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1533, 5, NULL, 32, 19, '54', 'Mohammad Shamsul Arefin (Milton)', 'Deputy General Manager (Logistics)', NULL, NULL, 'milton@borakbd.com', '1726427978', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1534, 5, NULL, 37, 19, '3525', 'Md Babul Islam', 'Assistant Manager (Electrical)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1535, 5, NULL, 41, 19, '3660', 'Iftekharul Islma', 'Technician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1536, 5, NULL, 44, 19, '44', 'Mr. Asaduzzaman', 'Senior Executive', NULL, NULL, 'asad@borakbd.com', '1741195214', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1537, 5, NULL, 44, 19, '860', 'Md. Hafizar Rahman', 'Procurement Assistant', NULL, NULL, 'procurementug@borakbd.com ', '1947620636', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1538, 5, NULL, 44, 19, '1753', 'Saliul Rakib', 'Senior Executive', NULL, NULL, 'saliul@borakbd.com', '1557726794', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1539, 5, NULL, 44, 19, '2910', 'Shakilur Islam Tuhin ', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1540, 5, NULL, 44, 19, '4070', 'Kamrul Hasan Pias', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1541, 5, NULL, 46, 19, '1223', 'Nur Alam', 'Deputy Manager', NULL, NULL, 'nuralam@borakbd.com', '1912105719', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1542, 5, NULL, 46, 19, '2027', 'Jimmy Benedict Baroi', 'Architect', NULL, NULL, 'jimmy@borakbd.com', '1779475165', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1543, 5, NULL, 48, 19, '3120', 'Imran Hossain Shikder', 'Security Inspector (Gunman, Special Security Team)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1544, 5, NULL, 48, 19, '3119', 'Md Mahbub Rahman', 'Security Inspector (Gunman, Special Security Team)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1545, 5, NULL, 48, 19, '3173', 'Omar Faruk', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1546, 5, NULL, 49, 19, '403', 'Shahajada Alam', 'Deputy Manager', NULL, NULL, 'shahajada@borakbd.com', '1711581874', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1547, 5, NULL, 49, 19, '404', 'Liton Chandra Sutradhar', 'Assistant Manager', NULL, NULL, 'liton@borakbd.com', '1721595011', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1548, 5, NULL, 49, 19, '445', 'Md.Sarower Hossain Arif', 'Assistant General Manager', NULL, NULL, 'arif@borakbd.com', '1713142195', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1549, 5, NULL, 51, 19, '166', 'Md. Suzaul Hoque', 'Senior Executive', NULL, NULL, 'suzaul@uniquegroupbd.com', '1909027620', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1550, 5, NULL, 51, 19, '2856', 'Khalid Bin Shahid ACA', 'General Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1551, 5, NULL, 51, 19, '2857', 'Shiekh Farid', 'Deputy Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1552, 5, NULL, 51, 19, '3166', 'Kasro Mohammad Ata Ullah', 'Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1553, 5, NULL, 52, 19, '16', 'Uttam Kumar Saha', 'General Manager', NULL, NULL, 'uttam@borakbd.com', '1713379451', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1554, 5, NULL, 52, 19, '2106', 'Md. Nurey Alam Siddik', 'Director (Construction)', NULL, NULL, 'nurey.alam@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1555, 5, NULL, 52, 19, '25', 'Gazi Md. Shakhawat Hossain', 'CEO (Finance, Procurement & Power Plant)', NULL, NULL, 'shakhawat@borakbd.com', '1713178887', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1556, 5, NULL, 52, 19, '420', 'Md. Mominul Haque', ' GM- Business Development, Brand & Revenue ', NULL, NULL, 'mominul@borakbd.com', '1711230054', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1557, 5, NULL, 52, 19, '2606', 'Mr. Khondaker Showkat Hossain', 'Advisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1558, 5, NULL, 53, 19, '357', 'Asha Mondol', 'Assistant Transport Mechanic', NULL, NULL, 'mto@uniquegroupbd.com', '1717048466', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1559, 5, NULL, 53, 19, '364', 'Md. Sohag', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1736917655', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1560, 5, NULL, 53, 19, '3041', 'Md Mamun Khan', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1561, 5, NULL, 53, 19, '3267', 'Md Faruk Sarkar', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1562, 5, NULL, 53, 19, '3269', 'Md Sukhin Kazi', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1563, 5, NULL, 53, 19, '3274', 'Alamin', 'Mechanic', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1564, 5, NULL, 53, 19, '3275', 'Md Fahim Mia', 'Mechanic', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1565, 5, NULL, 53, 19, '3410', 'Mamun Sardar', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1566, 5, NULL, 53, 19, '3483', 'Sakib Mia', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1567, 5, NULL, 53, 19, '3973', 'Md Shadat Hossain Shaon', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1568, 5, NULL, 53, 19, '3978', 'Rezaul Karim', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1569, 5, NULL, 53, 19, '4034', 'Md Sumon Mia', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1570, 5, NULL, 53, 19, '4038', 'Monir Hosain', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1571, 5, NULL, 53, 19, '4097', 'Md Delowar Hossain', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1572, 5, NULL, 53, 19, '4107', 'Md Farhad', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1573, 5, NULL, 53, 19, '4105', 'Md Rasel Mia', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1574, 5, NULL, 53, 19, '4106', 'Md Sohag Hawlader', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1575, 5, NULL, 53, 19, '2923', 'Mohammad Aminul Islam', 'Motor Transport Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1576, 5, NULL, 53, 19, '3361', 'Shakil', 'Assistant Motor Transport Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1577, 12, NULL, 4, 19, '178', 'Md. Mintu Mia', 'Office Assistant', NULL, NULL, NULL, '1731162933', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1578, 12, NULL, 4, 19, '4068', 'Jannatul Ferdous Eti', 'Front Desk Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1579, 12, NULL, 4, 19, '156', 'Md. Rafiq', 'Service Assistant', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1580, 12, NULL, 4, 19, '179', 'Md. Milon Mia', 'Service Assistant', NULL, NULL, NULL, '1716557187', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1581, 12, NULL, 4, 19, '275', 'Md.Abdul Mannan', 'Service Assistant', NULL, NULL, NULL, '1710330505', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1582, 12, NULL, 4, 19, '418', 'Md. Mamun', 'Service Assistant', NULL, NULL, NULL, '1689702295', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1583, 12, NULL, 4, 19, '1096', 'Md.Deloar Hosain', 'Service Assistant', NULL, NULL, NULL, '1626403125', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1584, 12, NULL, 4, 19, '3759', 'Mohammad Atiqur Rahman', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1585, 12, NULL, 4, 19, '4123', 'Md Abdur Rahman', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1586, 12, NULL, 18, 19, '1106', 'Petison Daring', 'Gardener cum Cleaner', NULL, NULL, 'bishwas@uniquehansa.com', '1709928074', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1587, 12, NULL, 18, 19, '1896', 'Md. Arif Mia', 'Lift Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1588, 12, NULL, 18, 19, '2110', 'S. M. Zahirul Islam', 'Housekeeping Inspector', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1589, 12, NULL, 18, 19, '2158', 'Md. Titas Mia', 'Lift Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1590, 12, NULL, 18, 19, '2740', 'Redwan', 'Assistant Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1591, 12, NULL, 18, 19, '2822', 'Md. Faysal', 'Plumber', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1592, 12, NULL, 18, 19, '3550', 'Kamrul Islam Ridoy', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1593, 12, NULL, 18, 19, '743', 'Tapabarta Bishwas', 'Assistant Manager (Operations & Business Development)', NULL, NULL, 'bishwas@uniquehansa.com', '1716189700', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1594, 12, NULL, 18, 19, '1878', 'Ariful Islam', 'Operator (Parking Management System)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1595, 12, NULL, 18, 19, '1882', 'Md. Rabiul Islam Akhand', 'Senior Executive (Facility Management)', NULL, NULL, 'rabiul@uniquehansa.com', '1735399549', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1596, 12, NULL, 18, 19, '2173', 'Abul Bashar Azad', 'Director of Housekeeping', NULL, NULL, 'basharazad@uniquehansa.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1597, 12, NULL, 18, 19, '2704', 'Md. Jihad', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1598, 12, NULL, 18, 19, '2817', 'Md. Nobi Hosen', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1599, 12, NULL, 18, 19, '3292', 'Rezaul Karim', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1600, 12, NULL, 18, 19, '3354', 'Riaz', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1601, 12, NULL, 18, 19, '3417', 'Khorshed Alam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1602, 12, NULL, 18, 19, '3464', 'Md Mehedi Hasan', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1603, 12, NULL, 18, 19, '3467', 'Md Robiul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1604, 12, NULL, 18, 19, '3468', 'Md Raasid Khan', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1605, 12, NULL, 18, 19, '3466', 'Md Rashed Miah', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1606, 12, NULL, 18, 19, '3607', 'Md. Shoriful Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1607, 12, NULL, 18, 19, '3668', 'Tamim', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1608, 12, NULL, 18, 19, '3670', 'Md Firoz Forazi', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1609, 12, NULL, 18, 19, '3678', 'Tanvir', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1610, 12, NULL, 18, 19, '3679', 'Ariful Haq Rasel', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1611, 12, NULL, 18, 19, '3810', 'Gony Shah', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1612, 12, NULL, 18, 19, '3852', 'Md Riajul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1613, 12, NULL, 18, 19, '3811', 'Sumon', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1614, 12, NULL, 18, 19, '3930', 'Md Arif', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1615, 12, NULL, 18, 19, '3931', 'Md Rasel Miah', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1616, 12, NULL, 18, 19, '3932', 'Mohammed Rasel', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1617, 12, NULL, 18, 19, '3997', 'Md Abid', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1618, 12, NULL, 18, 19, '4019', 'Fatema', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1619, 12, NULL, 18, 19, '4074', 'Zia Uddin', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1620, 12, NULL, 18, 19, '4077', 'Jihadul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1621, 12, NULL, 18, 19, '1589', 'Md.  Parvez', 'Guest Service Attendant', NULL, NULL, 'bishwas@uniquehansa.com', '01766006131, 01940351379', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1622, 12, NULL, 18, 19, '3995', 'Md Tazul Islam Suzon', 'Assistant In-Charge', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1623, 12, NULL, 25, 19, '2791', 'Fouzia Akther', 'Senior Executive', NULL, NULL, NULL, '1675548059', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1624, 12, NULL, 25, 19, '4001', 'Ahnaf Tazwar', 'HR Coordinator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1625, 12, NULL, 47, 19, '2476', 'Suraya Akter Sharmin', 'Executive', NULL, NULL, NULL, '1881334235', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1626, 12, NULL, 48, 19, '467', 'Md.Ruhul Amin Sardar', 'Security Guard', NULL, NULL, NULL, '1924151435', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1627, 12, NULL, 48, 19, '2165', 'Idrish Kabir Shikder', 'Manager', NULL, NULL, 'kabir@uniquehansa.com', '1673991376', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1628, 12, NULL, 48, 19, '2503', 'Md. Asraful Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1629, 12, NULL, 48, 19, '2575', 'Md. Salman Ahmed', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1630, 12, NULL, 48, 19, '2716', 'Md. Abdul Wahab', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1631, 12, NULL, 48, 19, '3072', 'Md Hanifa', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1632, 12, NULL, 48, 19, '3229', 'Jobaye Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1633, 12, NULL, 48, 19, '3206', 'Md Saiful Sikder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1634, 12, NULL, 48, 19, '3318', 'Nazim Hossen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1635, 12, NULL, 48, 19, '3384', 'Shilpy Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1636, 12, NULL, 48, 19, '3427', 'Kanika Mazumder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1637, 12, NULL, 48, 19, '3475', 'Prosanto Kumar Emon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1638, 12, NULL, 48, 19, '3485', 'Nurul Islam', 'Security Inspector', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1639, 12, NULL, 48, 19, '3511', 'Amio Kumar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1640, 12, NULL, 48, 19, '3560', 'Sowrab', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1641, 12, NULL, 48, 19, '3633', 'Taslima Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1642, 12, NULL, 48, 19, '3636', 'Shapla Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1643, 12, NULL, 48, 19, '3677', 'Md Masum Parvez', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1644, 12, NULL, 48, 19, '3691', 'Shipan Sheikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1645, 12, NULL, 48, 19, '3693', 'Md Mehedi Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1646, 12, NULL, 48, 19, '3777', 'Md Sherajul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1647, 12, NULL, 48, 19, '3757', 'Anusur Rahman', 'Deputy Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1648, 12, NULL, 48, 19, '3787', 'Sheshir Biswas', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1649, 12, NULL, 48, 19, '4095', 'Sojon Saha', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1650, 12, NULL, 48, 19, '4116', 'Amdhadul Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1651, 12, NULL, 48, 19, '4113', 'Md Jahid Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1652, 12, NULL, 48, 19, '4161', 'Md Imran Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1653, 12, NULL, 52, 19, '1488', 'Mohammad Shahedul Haque', 'Chief Operating Officer', NULL, NULL, 'shahed@uniquehansa.com', '1680009000', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1654, 9, NULL, 19, 19, '2811', 'Masud Alam', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1655, 9, NULL, 25, 19, '1995', 'Mohammad Shifat Ahmed', 'Senior Executive', NULL, NULL, 'shifat@uniquegroupbd.com', '1676717766', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1656, 9, NULL, 30, 19, '207', 'Md.Fayaz Ahamed Mazumder', 'Assistant Manager', NULL, NULL, 'fayez@sez.com.bd', '1708800778', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1657, 9, NULL, 30, 19, '3330', 'Mohammed Mahfujul Hoque', 'Manager', NULL, NULL, NULL, '1710656130', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1658, 9, NULL, 30, 19, '1853', 'Advocate Tarok Chandra Roy', 'Consultant (Land)', NULL, NULL, 'Tarak@sez.com.bd', '1720590295', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1659, 9, NULL, 30, 19, '3487', 'Abdul Based', 'Consultant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1660, 9, NULL, 52, 19, '3892', 'Major Khan Muhamed Alauddin', 'Project Director', NULL, NULL, 'alauddin@sez.com.bd', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1661, 14, NULL, 19, 19, '3086', 'Subrata Das', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1662, 14, NULL, 19, 19, '3838', 'Kallal Nandi', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1663, 14, NULL, 19, 19, '2094', 'Proshanta Mallick', 'Deputy Manager (Finance & Accounts)', NULL, NULL, 'mallick@uniqueceramicbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1664, 14, NULL, 26, 19, '2760', 'K. M. Farhad Alam', 'Assistant Manager', NULL, NULL, 'farhad@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1665, 14, NULL, 26, 19, '2897', 'Moinul Hossain', 'Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1666, 14, NULL, 26, 19, '3044', 'Md Golam Sorowar', 'Senior Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1667, 14, NULL, 26, 19, '3080', 'Md Mukul Hossain', 'Assistant General Manager', NULL, NULL, NULL, '1717715864', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1668, 14, NULL, 26, 19, '2809', 'Kowsiq Ahmed', 'Head of IT & SAP', NULL, NULL, 'kowsiq@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1669, 14, NULL, 48, 19, '228', 'Md.Hannan Biswas', 'Security Supervisor', NULL, NULL, NULL, '1723285142', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1670, 14, NULL, 49, 19, '30', 'Md. Mamun Hossen', 'Manager', NULL, NULL, 'mamun@uniqueceramicbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1671, 14, NULL, 49, 19, '37', 'Md. Akter Pervez', 'Assistant General Manager', NULL, NULL, 'akterpervez@uniqueceramicbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1672, 14, NULL, 49, 19, '1562', 'Md. Mahfuzur Rahman', 'Senior Executive', NULL, NULL, 'mahfuz@uniqueceramicbd.com', '1674799411', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1673, 14, NULL, 49, 19, '2895', 'Md. Fazle Ali ', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1674, 14, NULL, 53, 19, '1332', 'Md.Rafiqul Islam', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1798611533', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1675, 6, NULL, 19, 19, '2836', 'Opu Sultan', 'General Manager', NULL, NULL, 'opu.sultan@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1676, 6, NULL, 19, 19, '3760', 'Md Razu Ahmed', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1677, 6, NULL, 25, 19, '332', 'Md. Belal Hossain', 'Messenger', NULL, NULL, NULL, '1731920192', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1678, 6, NULL, 25, 19, '3339', 'Sumaiya Nawaz', 'Executive', NULL, NULL, 'sumaiya.nawaz@uniquegroupbd.com', '1775987701', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1679, 6, NULL, 25, 19, '3977', 'Mahmuda Sultana', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1680, 6, NULL, 34, 19, '859', 'Mohammad Iftekharul Islam', 'Deputy General Manager', NULL, NULL, 'iftekharulislam@uniquegroupbd.com', '1711288261', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1681, 6, NULL, 34, 19, '4039', 'Md Abdullah Al Mamun', 'General Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1682, 6, NULL, 38, 19, '3752', 'Sazzad Shahriar ', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1683, 6, NULL, 40, 19, '3976', 'Mohammad Mahabub Hasan ', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1684, 6, NULL, 40, 19, '3764', 'Md Omith Hasan', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06');
INSERT INTO `employees` (`id`, `unit_id`, `company_id`, `department_id`, `location_id`, `employee_id`, `employee_name`, `designation`, `employee_description`, `gender`, `employee_email`, `employee_phone`, `employee_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1685, 6, NULL, 40, 19, '4040', 'Md Shamsul Islam', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1686, 6, NULL, 41, 19, '3720', 'Manbub Kabir', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1687, 6, NULL, 52, 19, '1132', 'Mohammad Golam Sarwar', 'Chief Executive Officer', NULL, NULL, 'sarwar@uniquegroupbd.com', '1920711409', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1688, 6, NULL, 53, 19, '3021', 'Md. Tushar Kazi', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1689, 1, NULL, 25, 19, 'AZ-0001', 'System Admin', 'Manager', NULL, NULL, NULL, '1715132169', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1690, 1, NULL, 52, 19, '2', 'Mohammed Noor Ali', 'Managing Director', NULL, NULL, 'noorali@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1691, 4, NULL, 7, 19, '93', 'Md. Shahriar', 'Deputy General Manager', NULL, NULL, 'roman@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1692, 4, NULL, 7, 19, '3167', 'Md HasanMahamud Bhuiyan', 'Assistant  Manager (Commercial)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1693, 4, NULL, 8, 19, '329', 'Md. Abdul Kaiwm Sikder', 'Manager (Share)', NULL, NULL, 'kaiwm.sikder@uhrlbd.com', '1769501607', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1694, 4, NULL, 8, 19, '2565', 'Khatuna Jannat Juthi', 'Senior Executive', NULL, NULL, 'jannat@uhrlbd.com', '1749789234', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1695, 4, NULL, 9, 19, '50', 'Md. Ziaul Amin', 'Coordination Officer', NULL, NULL, 'ziaulamin@borakbd.com', '1720027030', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1696, 4, NULL, 9, 19, '442', 'Md.Hasan Ali', 'Quantity Surveyor', NULL, NULL, 'hasanali@uhrlbd.com', '1771023758', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1697, 4, NULL, 11, 19, '2913', 'Hosain Mohammad Shalah Shahriar', 'Senior Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1698, 4, NULL, 19, 19, '168', 'Md. Zahid Hossain', 'Deputy Manager', NULL, NULL, 'zahid@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1699, 4, NULL, 19, 19, '1403', 'Abu Shakil', 'Deputy Manager', NULL, NULL, 'sakil@uhrlbd.com', '1716588425', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1700, 4, NULL, 19, 19, '1704', 'Farzana Rabeya Mery', 'Senior Executive (Finance & Accounts)', NULL, NULL, 'farzana@uhrlbd.com', '1621000500', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1701, 4, NULL, 19, 19, '2175', 'Md. Mizanur Rahman', 'Executive', NULL, NULL, 'mizan@uhrlbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1702, 4, NULL, 19, 19, '2604', 'Zannatul Ferdous Leza', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1703, 4, NULL, 19, 19, '2829', 'Tasfia Tabassum Mahbub', 'Senior Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1704, 4, NULL, 19, 19, '2846', 'Riad Hossain CMA, CIPA, ACS', 'Director', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1705, 4, NULL, 19, 19, '3613', 'Jone Kumar Gupta FCA', 'Chief Finance Officer', NULL, NULL, 'gupta@uhrlbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1706, 4, NULL, 19, 19, '3966', 'Sonjib Mondal', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1707, 4, NULL, 19, 19, '3699', 'Shah Mohammad Fysal', 'Intern', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1708, 4, NULL, 24, 19, '3000', 'Major Nasimul Huque (Retd.)', 'General Manager', NULL, NULL, 'nasim@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1709, 4, NULL, 25, 19, '1514', 'Md. Jishan Ahmed', 'Manager (Human Resources)', NULL, NULL, 'jishan@uniquegroupbd.com', '1682078892', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1710, 4, NULL, 25, 19, '3043', 'Zahid Mahmud', 'Assiatant Manager (Admin)', NULL, NULL, NULL, '1685661275', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1711, 4, NULL, 26, 19, '322', 'Md. Nizam Uddin', 'Senior Manager', NULL, NULL, 'nizam@uniquegroupbd.com', '1711000913', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1712, 4, NULL, 26, 19, '2085', 'Imran Rahaman', 'Assistant Manager', NULL, NULL, 'imran@uniquegroupbd.com', '1918329829', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1713, 4, NULL, 26, 19, '2366', 'Md. Amirul Islam', 'Manager', NULL, NULL, 'amirul@uniquegroupbd.com', '1533550962', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1714, 4, NULL, 26, 19, '2922', 'Syeda Mehnaz Monsur', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1715, 4, NULL, 26, 19, '3855', 'Abu Bakar Siddik', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1716, 4, NULL, 26, 19, '1458', 'Anisuzzaman', 'Senior System Administrator', NULL, NULL, 'anis@uniquegroupbd.com', '1932897035', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1717, 4, NULL, 27, 19, '1618', 'Rumana Islam', 'Manager', NULL, NULL, 'rumana@uniquegroupbd.com', '1918429343', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1718, 4, NULL, 27, 19, '1833', 'Najmul Siddikee', 'Deputy Manager', NULL, NULL, 'najmul@uniquegroupbd.com', '1711166553', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1719, 4, NULL, 27, 19, '1858', 'Md. Mazharul Islam', 'Manager', NULL, NULL, 'mazhar@uniquegroupbd.com', '1781330716', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1720, 4, NULL, 27, 19, '1874', 'Md. Monirul Islam', 'Deputy Manager', NULL, NULL, 'monir@uniquegroupbd.com', '1916277420', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1721, 4, NULL, 27, 19, '2785', 'Md. Mamunur Rashid', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1722, 4, NULL, 27, 19, '2810', 'Md. Rasel', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1723, 4, NULL, 27, 19, '3329', 'Fatema Tuz Zohra', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1724, 4, NULL, 27, 19, '3721', 'Ifran Uddin Ahmed', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1725, 4, NULL, 32, 19, '4033', 'Syed Tanib Md Boneyeamin', 'Manager (Logistics)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1726, 4, NULL, 34, 19, '26', 'Mr. Tapash Mazumder', 'APS to MD', NULL, NULL, 'tapashug@gmail.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1727, 4, NULL, 44, 19, '2166', 'Md. Nazmul Islam', 'Deputy General Manager', NULL, NULL, 'nazmul.islam@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1728, 4, NULL, 44, 19, '2337', 'Md. Harunur Rashid Khan', 'Executive', NULL, NULL, 'rashid@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1729, 4, NULL, 44, 19, '2500', 'Mohammad Rakibul Islam', 'Assistant Manager', NULL, NULL, 'rakibul.islam@uniquegroupbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1730, 4, NULL, 44, 19, '2682', 'Mohammad Shahjahan', 'Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1731, 4, NULL, 44, 19, '3001', 'Mehedi Hasan', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1732, 4, NULL, 51, 19, '2480', 'Shabuddin Ahmed', 'Assistant Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1733, 4, NULL, 51, 19, '2837', 'Kumar Shoumendra Sutradhar', 'Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1734, 4, NULL, 52, 19, '67', 'Mohammad Abdul Jalil', 'General Manager (Corporate Affairs)', NULL, NULL, 'jalil@uhrlbd.com', '1713178877', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1735, 4, NULL, 52, 19, '626', 'Md. Sharif Hasan FCS', 'Company Secretary', NULL, NULL, 'sharif@uhrlbd.com', '1730318096', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1736, 4, NULL, 52, 19, '1808', 'Mohammad Abu Naser', 'General Manager (Accounts & Finance)', NULL, NULL, 'abu.naser@uhrlbd.com', '1534551438', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1737, 4, NULL, 52, 19, '3133', 'Syed Sanowarul Hoque', 'CEO - Trust Office', NULL, NULL, 'sshoque@uniquegroupbd.com', '1711850721', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1738, 4, NULL, 53, 19, '1777', 'Muzahidur Rahman', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1849334700', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1739, 4, NULL, 53, 19, '2129', 'Md. Tutul', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1740, 4, NULL, 54, 19, '3520', 'Md Saifuzzaman', 'Manager', NULL, NULL, NULL, '8801703544478', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1741, 4, NULL, 54, 19, '4036', 'Israt Jhan Sayma ', 'Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1742, 4, NULL, 54, 19, '4124', 'Amil Sadekin', 'Business Planning Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1743, 13, NULL, 4, 19, '2920', 'Md. Tareak Mahmud Riad', 'Executive (Admin)', NULL, NULL, NULL, '7675989922', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1744, 13, NULL, 19, 19, '3396', 'Md Mahabub Hasan', 'Senior Executive', NULL, NULL, NULL, '1322901804', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1745, 13, NULL, 50, 19, '267', 'Md.Hasbul Zia', 'Deputy Manager (Accounts)', NULL, NULL, 'hasbulzia@yahoo.com', '1902707209', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1746, 13, NULL, 50, 19, '351', 'Mohammad Touhidur Rahman Khalifa', 'Manager (Share)', NULL, NULL, 'touhid.usml@yahoo.com', '1712242189', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1747, 13, NULL, 50, 19, '2107', 'Md. Shahriar Islam', 'Senior Executive (Accounts)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1748, 13, NULL, 50, 19, '2989', 'Akibul Adnan Robin', 'Executive', NULL, NULL, NULL, '1621548608', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1749, 13, NULL, 50, 19, '220', 'Mohammad Naimul Hossain', 'Senior Manager (In-charge)', NULL, NULL, 'naimul.hossain@usmlbd.com', '1818468960', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1750, 7, NULL, 52, 19, '85', 'Salauddin Khan', 'Director', NULL, NULL, 'salauddin@uniquegroupbd.com', '1817035559', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1751, 5, NULL, 48, 20, '591', 'Md. Hossen Shikder', 'Security Guard', NULL, NULL, NULL, '1679863238', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1752, 22, NULL, 41, 21, '2619', 'Md. Jamal Sarder', 'Shepherd', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1753, 5, NULL, 35, 21, '19', 'Md. Showkot Ali', 'Caretaker', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1754, 5, NULL, 48, 21, '2319', 'Amirul Huq', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1755, 12, NULL, 48, 21, '3990', 'Md Asraf Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1756, 12, NULL, 48, 22, '3480', 'Md Sumon Khan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1757, 12, NULL, 48, 22, '3499', 'Abdul Aziz Howlader', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1758, 12, NULL, 48, 22, '3546', 'Tarek', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1759, 12, NULL, 48, 22, '3566', 'Kholilur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1760, 12, NULL, 48, 22, '3784', 'Md Rafiqul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1761, 12, NULL, 48, 22, '3792', 'Md Kayum Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1762, 12, NULL, 48, 22, '3885', 'Obydur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1763, 12, NULL, 48, 22, '3994', 'Md Habibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1764, 12, NULL, 48, 22, '4005', 'Abul Hasnat', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1765, 22, NULL, 6, 23, '3482', 'Shamim Ahmed', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1766, 22, NULL, 41, 23, '2680', 'Md. Sajedul Islam', 'Supervisor', NULL, NULL, 'sajedul@uniqueceramicbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1767, 22, NULL, 48, 23, '349', 'Md.Mamunur Rashad', 'Security Guard', NULL, NULL, NULL, '1770150535', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1768, 15, NULL, 4, 23, '3489', 'Md Mahmudur Rashid', 'Officer (Admin)', NULL, NULL, NULL, '1911907640', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1769, 15, NULL, 9, 23, '1380', 'Md.Shafiqul Islam', 'Senior Accounts Officer cum Store Officer', NULL, NULL, 'shafiq@uhrlbd.com', '1680704593', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1770, 15, NULL, 17, 23, '3276', 'Md Ariful Islam', 'Lab Assistant', NULL, NULL, NULL, '1734139253', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1771, 15, NULL, 29, 23, '3513', 'Md Shamsul Alma', 'Laboratory Technician', NULL, NULL, NULL, '1738400056', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1772, 15, NULL, 29, 23, '3567', 'Md Sohag', 'Payloader Operator', NULL, NULL, NULL, '1320941452', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1773, 15, NULL, 29, 23, '3514', 'Md Abdus Sobur Sorkar', 'Concrete Pump and Tranport Control Engineer', NULL, NULL, NULL, '1740282859', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1774, 15, NULL, 41, 23, '3333', 'Md Abu Isa Palash', 'Assistant Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1775, 15, NULL, 41, 23, '3518', 'Md Hasanuj Jaman ', 'Plant Operator', NULL, NULL, NULL, '1729601517', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1776, 15, NULL, 45, 23, '2016', 'Md. Rakib Hasan', 'Payloader Operator', NULL, NULL, NULL, '1852140020', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1777, 15, NULL, 45, 23, '3494', 'Al Mahmud Riaz', 'Plant Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1778, 15, NULL, 48, 23, '4119', 'Hossain Mohammad Dalim', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1779, 15, NULL, 49, 23, '3404', 'Md Shohan Ahmed', 'Assiatant Manager (Sales & Reservation)', NULL, NULL, NULL, '1710507358', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1780, 15, NULL, 49, 23, '3441', 'Md Rakibul Islam', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1781, 15, NULL, 49, 23, '3661', 'Md Mizanur Rahman', 'Executive', NULL, NULL, NULL, '1314665696', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1782, 15, NULL, 49, 23, '4136', 'Md Abdul Mozid', 'Assistant Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1783, 15, NULL, 53, 23, '2065', 'Md. Harun or Rashid', 'Mixture Truck Driver', NULL, NULL, NULL, '1710233472', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1784, 15, NULL, 53, 23, '2792', 'Md. Abdullah', 'Mixture Truck Driver', NULL, NULL, NULL, '1788971343', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1785, 15, NULL, 53, 23, '3054', 'Md. Shepon', 'Mixture Truck Driver', NULL, NULL, NULL, '1781367349', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1786, 15, NULL, 53, 23, '3093', 'Md Arshad Mia', 'Mixture Truck Driver', NULL, NULL, NULL, '1921441437', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1787, 15, NULL, 53, 23, '3223', 'Md. Sumon Ali ', 'Mixture Truck Driver', NULL, NULL, NULL, '1884881666', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1788, 15, NULL, 53, 23, '3278', 'Md Mosabber Rohman', 'Mechanic', NULL, NULL, NULL, '1705115608', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1789, 15, NULL, 53, 23, '3442', 'Md Nahid Hossain', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1790, 15, NULL, 53, 23, '3521', 'Md Rana', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1791, 15, NULL, 53, 23, '3718', 'Md Mithun', 'Mixture Truck Driver', NULL, NULL, NULL, '1965123534', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1792, 15, NULL, 53, 23, '3717', 'Mozibur Rahman', 'Mixture Truck Driver', NULL, NULL, NULL, '1772505010', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1793, 12, NULL, 48, 23, '3919', 'Md Mafijur Rahman Mintu ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1794, 4, NULL, 9, 24, '522', 'Rashel Jomaddar', 'Caretaker', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1795, 12, NULL, 18, 25, '4141', 'Jannatul Ferdousi', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1796, 12, NULL, 18, 25, '4140', 'Md Roman Mia', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1797, 12, NULL, 18, 25, '4162', 'Rakib Hasan', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1798, 12, NULL, 18, 25, '4165', 'Sumon Miah', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1799, 12, NULL, 18, 26, '1171', 'Khokon Nengminja', 'Gardener cum Cleaner', NULL, NULL, 'redwan@uniquehansa.com', '1780154959', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1800, 12, NULL, 18, 26, '2245', 'Mohammad Aiyub Khan', 'Plumber', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1801, 12, NULL, 18, 26, '4122', 'Asadul Islam', 'Facility Supervisor (Cleaning)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1802, 12, NULL, 18, 26, '2203', 'Md. Yeasin', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1803, 12, NULL, 18, 26, '3202', 'Mursalin', 'Front Desk Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1804, 12, NULL, 18, 26, '3562', 'Tamim', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1805, 12, NULL, 18, 26, '4088', 'Farid Sheikh', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1806, 12, NULL, 37, 26, '4058', 'Shahin Alam', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1807, 12, NULL, 48, 26, '966', 'Md.Nowsher Munsi', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1808, 12, NULL, 48, 26, '2576', 'Md. Rasel Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1809, 12, NULL, 48, 26, '3098', 'Md Anowar Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1810, 12, NULL, 48, 26, '3321', 'Md Bokul Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1811, 12, NULL, 48, 26, '3532', 'Md Hamayat Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1812, 12, NULL, 48, 26, '4112', 'Md Faruk Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1813, 15, NULL, 6, 27, '984', 'Billal Hossain', 'Junior Officer (Account & Collection)', NULL, NULL, 'billal@borakrmc.com', '1726818897', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1814, 15, NULL, 6, 27, '1546', 'Md. Fazlul Haque', 'Senior Executive (Collection & Recovery)', NULL, NULL, 'fazlul@borakrmc.com', '1721085338', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1815, 15, NULL, 9, 27, '2293', 'Md. Israfil Shekh', 'Welder', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1816, 15, NULL, 9, 27, '2336', 'Md. Safiqul Islam', 'Welder', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1817, 15, NULL, 17, 27, '2251', 'Fuadur Rahman', 'Assistant Engineer', NULL, NULL, 'civil@borakrmc.com', '1625895631', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1818, 15, NULL, 17, 27, '2753', 'Matilal Chondro Ray', 'Laboratory Technician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1819, 15, NULL, 17, 27, '3084', 'Md Habil Uddin', 'Assistant Lab Techologist', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1820, 15, NULL, 17, 27, '3614', 'Taposh Chandra Barman', 'Crane Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1821, 15, NULL, 17, 27, '2526', 'Ariful Islam', 'Assistant Manager (Maintenance)', NULL, NULL, 'plant@borakrmc.com', '1732298672', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1822, 15, NULL, 19, 27, '3724', 'Md Masud Rana', 'Officer (TAX)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1823, 15, NULL, 41, 27, '2252', 'Nirmol Chandra ', 'Plant Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1824, 15, NULL, 41, 27, '3282', 'Khokon Mia', 'Pump Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1825, 15, NULL, 41, 27, '3280', 'Md Shahjalal Miah', 'Assiatant Manager (Admin)', NULL, NULL, 'shahjalal@borakrmc.com', '1711300071', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1826, 15, NULL, 41, 27, '3372', 'Md Babor Ali', 'Deputy Manager', NULL, NULL, NULL, '1737948232', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1827, 15, NULL, 45, 27, '117', 'Abddul Mannan', 'Tower Hoist Operator', NULL, NULL, 'bzt@borakbd.com', '1732646184', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1828, 15, NULL, 45, 27, '649', 'Sree Lal Chan Chondro Ray', 'Senior Mechanic', NULL, NULL, 'golamrabbani@uniquegroupbd.com ', '1921213367', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1829, 15, NULL, 45, 27, '660', 'Md. Golam Mortuza', 'Plant Engineer', NULL, NULL, 'mortuza@borakrmc.com', '1911555030', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1830, 15, NULL, 45, 27, '979', 'Md. Anisur Rahman', 'Laboratory Technician', NULL, NULL, 'golamrabbani@uniquegroupbd.com', '1724716916', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1831, 15, NULL, 45, 27, '991', 'Md. Iman Hossain', 'Pipe Fitter', NULL, NULL, 'golamrabbani@uniquegroupbd.com', '1743216835', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1832, 15, NULL, 45, 27, '1356', 'Md.Mosharof Hossain Konok', 'Assistant Payloader Operator', NULL, NULL, 'golamrabbani@uniquegroupbd.com', '1932967877', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1833, 15, NULL, 45, 27, '1740', 'Md. Belal Hossain', 'Concrete Pump Operator', NULL, NULL, 'golamrabbani@uniquegroupbd.com ', '1731127429', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1834, 15, NULL, 45, 27, '1928', 'Monoronjon Roy', 'Laboratory Technician', NULL, NULL, NULL, '1612615741', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1835, 15, NULL, 45, 27, '1972', 'Keshob Chandro', 'Plant Assistant', NULL, NULL, NULL, '1302724241', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1836, 15, NULL, 45, 27, '2019', 'Md. Arif', 'Plant Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1837, 15, NULL, 45, 27, '2020', 'Md. Omar Faruk', 'Plant Operator', NULL, NULL, NULL, '1753245769', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1838, 15, NULL, 45, 27, '2171', 'Md. Abdul Alim', 'Assistant General Manager', NULL, NULL, 'ce.abdulalim@borakbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1839, 15, NULL, 45, 27, '2345', 'Md. Imamul Islam', 'Plant Operator', NULL, NULL, NULL, '1753270232', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1840, 15, NULL, 48, 27, '962', 'Md.Aslam', 'Security Guard', NULL, NULL, NULL, '1761412959', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1841, 15, NULL, 48, 27, '1120', 'Md.Bablu Pramanik', 'Security Guard', NULL, NULL, NULL, '1781901725', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1842, 15, NULL, 48, 27, '1804', 'Md. Shahidul Islam Talukder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1843, 15, NULL, 48, 27, '1841', 'Abul Hasem', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1844, 15, NULL, 48, 27, '2636', 'Md. Anowar Hossian', 'Security Guard', NULL, NULL, NULL, '1821768807', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1845, 15, NULL, 48, 27, '2737', 'Md. Abul Bashar Monshi', 'Security Guard', NULL, NULL, NULL, '1743177773', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1846, 15, NULL, 48, 27, '3019', 'Md Obydur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1847, 15, NULL, 48, 27, '3164', 'Md Kabir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1848, 15, NULL, 48, 27, '3548', 'Ali Hassan Siam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1849, 15, NULL, 48, 27, '4046', 'Sopon Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1850, 15, NULL, 48, 27, '4052', 'Sahadat Husain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1851, 15, NULL, 48, 27, '4081', 'Md Adil Hossain ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1852, 15, NULL, 49, 27, '971', 'Muhammad Rashedul Hasan', 'Assistant General Manager', NULL, NULL, 'rashedul.hasan@borakrmc.com', '1721095117', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1853, 15, NULL, 49, 27, '2310', 'Bibhu Bhowmik', 'Senior Executive', NULL, NULL, 'bibhu@borakbd.com', '1829306105', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1854, 15, NULL, 53, 27, '1971', 'Md. Khirul Alam', 'Pick-up Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1855, 15, NULL, 53, 27, '2370', 'Md. Rimon Ima', 'Mixture Truck Driver', NULL, NULL, NULL, '1766041037', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1856, 15, NULL, 53, 27, '2485', 'Belal Hossain', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1857, 15, NULL, 53, 27, '2524', 'Arshad Ali ', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1858, 15, NULL, 53, 27, '2726', 'Md . Rubel Sarkar ', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1859, 15, NULL, 53, 27, '2787', 'Md. Kawsar Ahmed', 'Mixture Truck Driver', NULL, NULL, NULL, '1712329341', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1860, 15, NULL, 53, 27, '2891', 'Rubel Bepari', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1861, 15, NULL, 53, 27, '3115', 'Md Abdul', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1862, 15, NULL, 53, 27, '3122', 'Md Shohel Ahmmed', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1863, 15, NULL, 53, 27, '3224', 'Md Ruble Hossain', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1864, 15, NULL, 53, 27, '3256', 'Md Shahabuddin', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1865, 15, NULL, 53, 27, '3311', 'Md Heru', 'Auto Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1866, 15, NULL, 53, 27, '3412', 'Md Saidur Rahman', 'Pick-up Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1867, 15, NULL, 53, 27, '3443', 'Md Saidul Islam', 'Mixture Truck Driver', NULL, NULL, NULL, '1907232903', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1868, 15, NULL, 53, 27, '3756', 'Md  Yusuf Ahmed ', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1869, 15, NULL, 53, 27, '3754', 'Md Jahidul Islam Mamun ', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1870, 15, NULL, 53, 27, '3753', 'Md Tarikul Islam ', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1871, 15, NULL, 53, 27, '3761', 'Md Zikrul', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1872, 15, NULL, 53, 27, '3857', 'Md Halim Mia', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1873, 15, NULL, 53, 27, '3858', 'Md Nayon Hossain', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1874, 15, NULL, 53, 27, '3859', 'Md Ripon Ali', 'Senior Mechanic', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1875, 15, NULL, 53, 27, '3862', 'Md Shohag Hossain', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1876, 15, NULL, 53, 27, '3952', 'Md Limon Mia', 'Pick-up Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1877, 15, NULL, 53, 27, '4041', 'Md Dulal Hossain Forazi', 'Training Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1878, 15, NULL, 53, 27, '3975', 'Md Shadik Ali', 'Pick-up Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1879, 15, NULL, 53, 27, '3971', 'Md Alom Mia', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1880, 15, NULL, 53, 27, '4044', 'Md Jashim Uddin Arman', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1881, 15, NULL, 53, 27, '4043', 'Md Osman Molla', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1882, 15, NULL, 53, 27, '4100', 'Sahabuddin Sabu', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1883, 15, NULL, 53, 27, '4137', 'Md Ashraf Howlader', 'Mixture Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1884, 15, NULL, 53, 27, '4069', 'Md Muktar Hossain ', 'Assistant Maintenance Engineer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1885, 12, NULL, 48, 27, '3925', 'Md Dil Fizer Rahman ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1886, 12, NULL, 48, 28, '3601', 'Abdul Samad', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1887, 12, NULL, 48, 28, '3577', 'Abdullah Shek', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1888, 12, NULL, 48, 28, '3585', 'Md Alal Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1889, 12, NULL, 48, 28, '3583', 'Md Anu Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1890, 12, NULL, 48, 28, '3602', 'Md Azim Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1891, 12, NULL, 48, 28, '3597', 'Md Farid Uddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1892, 12, NULL, 48, 28, '3600', 'Md Fayshal Khan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1893, 12, NULL, 48, 28, '3590', 'Md Fazle Rabby Mondul', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1894, 12, NULL, 48, 28, '3596', 'Md Foridul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1895, 12, NULL, 48, 28, '3603', 'Md Hasibul', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1896, 12, NULL, 48, 28, '3599', 'Md Mahfuzar Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1897, 12, NULL, 48, 28, '3587', 'Md Mamun Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1898, 12, NULL, 48, 28, '3584', 'Md Milon Khandaker', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1899, 12, NULL, 48, 28, '3570', 'Md Piarul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1900, 12, NULL, 48, 28, '3582', 'Md Rabbi', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1901, 12, NULL, 48, 28, '3569', 'Md Ranaul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1902, 12, NULL, 48, 28, '3591', 'Md Razu Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1903, 12, NULL, 48, 28, '3581', 'Md Rocky Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1904, 12, NULL, 48, 28, '3594', 'Md Serajul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1905, 12, NULL, 48, 28, '3575', 'Md Shafiul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1906, 12, NULL, 48, 28, '3593', 'Md Shahin Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1907, 12, NULL, 48, 28, '3598', 'Md Shajahan Siraj', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1908, 12, NULL, 48, 28, '3588', 'Md Shamim Fokir', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1909, 12, NULL, 48, 28, '3595', 'Md Shohel Shikdar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1910, 12, NULL, 48, 28, '3592', 'Md Sumon Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1911, 12, NULL, 48, 28, '3576', 'Md Tusar Abdullah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1912, 12, NULL, 48, 28, '3574', 'Mehedi Sheikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1913, 12, NULL, 48, 28, '3571', 'Minarul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1914, 12, NULL, 48, 28, '3589', 'Mita Singha', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1915, 12, NULL, 48, 28, '3579', 'Moheuddin Moni', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1916, 12, NULL, 48, 28, '3580', 'Mubarak Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1917, 12, NULL, 48, 28, '3578', 'Rubel Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1918, 12, NULL, 48, 28, '3573', 'Shahidul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1919, 12, NULL, 48, 28, '3624', 'Hridhy Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1920, 12, NULL, 48, 28, '3625', 'Md Rayhan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1921, 12, NULL, 48, 28, '3701', 'Md Yeasin Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1922, 12, NULL, 48, 28, '3702', 'Usman Goni', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1923, 12, NULL, 48, 28, '3673', 'Ashik Ahmed Sujon', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1924, 12, NULL, 48, 28, '3687', 'Mohammad Yasin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1925, 12, NULL, 48, 28, '3586', 'Kazi Murshid Hassan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1926, 12, NULL, 48, 28, '3604', 'Shiful Islam', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1927, 12, NULL, 48, 28, '3680', 'Josna Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1928, 12, NULL, 48, 28, '3689', 'Rofiqul Islam Montu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:06', '2023-03-15 05:09:06'),
(1929, 12, NULL, 48, 28, '3605', 'Md Shafiqul Islam', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1930, 12, NULL, 48, 28, '3800', 'Md Ahsan Habib', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1931, 12, NULL, 48, 28, '3793', 'Md Zahirul Islam Lablu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1932, 12, NULL, 48, 28, '3795', 'Piya Sultana', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1933, 12, NULL, 48, 28, '3778', 'Soraiya', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1934, 12, NULL, 48, 28, '3843', 'Sabbir Sheikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1935, 12, NULL, 48, 28, '3783', 'Easin Molla', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1936, 12, NULL, 48, 28, '3834', 'Md Shefat', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1937, 12, NULL, 48, 28, '3853', 'Md Zunaid Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1938, 12, NULL, 48, 28, '3854', 'Md Sazedul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1939, 12, NULL, 48, 28, '3844', 'Md Shahin Sarkar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1940, 12, NULL, 48, 28, '3835', 'Shabbir Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1941, 12, NULL, 48, 28, '3846', 'Md Shamim Miya', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1942, 12, NULL, 48, 28, '3823', 'Md Rajib Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1943, 12, NULL, 48, 28, '3845', 'Shaikh Mokammel Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1944, 12, NULL, 48, 28, '3842', 'Md Abu Rayhan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1945, 12, NULL, 48, 28, '3847', 'Dadon Madbar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1946, 12, NULL, 48, 28, '3849', 'Md Motiur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1947, 12, NULL, 48, 28, '3848', 'Md Nazmul Hasan ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1948, 12, NULL, 48, 28, '3841', 'Md Shadum Hossan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1949, 12, NULL, 48, 28, '3884', 'Md Al-Amin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1950, 12, NULL, 48, 28, '3917', 'Md Majibur Rahman ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1951, 12, NULL, 48, 28, '3882', 'Md Masud Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1952, 12, NULL, 48, 28, '3939', 'Ibrahim Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1953, 12, NULL, 48, 28, '3918', 'Md Limon Miah ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1954, 12, NULL, 48, 28, '3927', 'Md Sohidul Islam ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1955, 12, NULL, 48, 28, '3883', 'Liza Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07');
INSERT INTO `employees` (`id`, `unit_id`, `company_id`, `department_id`, `location_id`, `employee_id`, `employee_name`, `designation`, `employee_description`, `gender`, `employee_email`, `employee_phone`, `employee_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1956, 12, NULL, 48, 28, '3959', 'Md Golam Mostofa', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1957, 12, NULL, 48, 28, '3881', 'Md Salim Mia', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1958, 12, NULL, 48, 28, '3942', 'Kamal Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1959, 12, NULL, 48, 28, '3940', 'Md Al-Amin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1960, 12, NULL, 48, 28, '3960', 'Md Rajib', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1961, 12, NULL, 48, 28, '3961', 'Saddam Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1962, 12, NULL, 48, 28, '3941', 'Md Imran Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1963, 12, NULL, 48, 28, '3920', 'Md Saiful Islam Gazi ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1964, 12, NULL, 48, 28, '3921', 'Md Adil Hossain ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1965, 12, NULL, 48, 28, '3986', 'Md Ali Akbar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1966, 12, NULL, 48, 28, '3987', 'Md Foysal Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1967, 12, NULL, 48, 28, '4015', 'Juwel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1968, 12, NULL, 48, 28, '4016', 'Md Ridoy Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1969, 12, NULL, 48, 28, '4014', 'Md Shakil Khan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1970, 12, NULL, 48, 28, '4013', 'Rubel Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1971, 12, NULL, 48, 28, '4062', 'Md Masum', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1972, 12, NULL, 48, 28, '4060', 'Md Ripon Miah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1973, 12, NULL, 48, 28, '4091', 'Md Shakib Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1974, 12, NULL, 48, 28, '4083', 'Raju Sarkar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1975, 12, NULL, 48, 28, '4087', 'Md Mustafizur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1976, 12, NULL, 48, 28, '4092', 'Kowsar Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1977, 12, NULL, 48, 28, '4090', 'Md Rabin Mridha', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1978, 12, NULL, 48, 28, '4093', 'Md Shakib Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1979, 12, NULL, 48, 28, '4115', 'Md Shakil Hosain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1980, 12, NULL, 48, 28, '4109', 'Md Zulfikar Molla', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1981, 12, NULL, 48, 28, '4117', 'Md Lemon Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1982, 12, NULL, 48, 28, '4120', 'Sahin Alom', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1983, 12, NULL, 48, 28, '4149', 'Abdul Momin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1984, 12, NULL, 48, 28, '4148', 'Md Easha Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1985, 12, NULL, 48, 28, '4150', 'Bappy', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1986, 12, NULL, 48, 28, '4048', 'Md Shohel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1987, 12, NULL, 48, 28, '4049', 'Fakrul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1988, 4, NULL, 17, 29, '143', 'S. M Jamil Hossain', 'Shift Engineer', NULL, NULL, 'shepon695@gmail.com', '1711821942', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1989, 4, NULL, 17, 29, '249', 'Mr. Abu Hasan', 'Site Engineer', NULL, NULL, 'shepon695@gmail.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1990, 4, NULL, 17, 29, '248', 'Nasir Ahmed', 'Shift Engineer.', NULL, NULL, 'shepon695@gmail.com', '1816669467', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1991, 4, NULL, 17, 29, '417', 'Mir Moniruzzaman', 'Storekeeper', NULL, NULL, 'shepon695@gmail.com', '1917960695', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1992, 4, NULL, 17, 29, '473', 'Salauddin Ahmed Monir', 'Shift Engineer', NULL, NULL, 'shepon695@gmail.com', '1916949084', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1993, 4, NULL, 17, 29, '478', 'Md. Mofazzal Hossain', 'Shift Engineer', NULL, NULL, 'shepon695@gmail.com', '1912303989', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1994, 4, NULL, 17, 29, '624', 'Md. Golam Mostafa', 'Shift Operator', NULL, NULL, 'shepon695@gmail.com', '1717030628', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1995, 4, NULL, 17, 29, '803', 'Md. Sajedul Islam', 'Site Engineer', NULL, NULL, 'shepon695@gmail.com', '1746936469', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1996, 4, NULL, 43, 29, '1035', 'Md.Siragul Islam', 'Office Boy', NULL, NULL, 'shepon695@gmail.com', '1920923737', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1997, 4, NULL, 43, 29, '4071', 'Tajuddin Ahmed Nahid', 'Intern', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1998, 4, NULL, 48, 29, '192', 'Md.Abdur Rashid', 'Security Guard', NULL, NULL, NULL, '1932992481', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(1999, 4, NULL, 48, 29, '1150', 'Md.Milon Hossain', 'Security Guard', NULL, NULL, NULL, '1714722515', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2000, 4, NULL, 52, 29, '63', 'Gazi Khalil Uddin', 'General Manager', NULL, NULL, 'gazikhalil@uhrlbd.com', '1713178871', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2001, 5, NULL, 35, 30, '17', 'Md. Mezbhauddin Benu', 'Housekeeper', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2002, 14, NULL, 48, 30, '324', 'Md.Arshadul Haque', 'Security Guard', NULL, NULL, NULL, '1778437569', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2003, 14, NULL, 48, 30, '330', 'Md.Abul Kasam', 'Security Guard', NULL, NULL, NULL, '1762675397', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2004, 14, NULL, 48, 30, '1166', 'Md.Nur Nobi', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2005, 9, NULL, 30, 31, '3285', 'Md Nazrul Islam Sarker', 'Surveyor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2006, 9, NULL, 30, 31, '3360', 'Nurul Islam', 'Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2007, 9, NULL, 30, 31, '4030', 'Mohammad Mofazzol Hossain', 'Project Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2008, 9, NULL, 48, 31, '2601', 'Elius Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2009, 9, NULL, 48, 31, '3031', 'Md Kayes', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2010, 9, NULL, 48, 31, '3509', 'Md Sabir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2011, 9, NULL, 48, 31, '3676', 'Asraf Hossain Hirok', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2012, 9, NULL, 48, 31, '3694', 'Md Himel Khan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2013, 9, NULL, 48, 31, '3825', 'Md Rabby Talukder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2014, 9, NULL, 48, 31, '4004', 'Md Asikur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2015, 9, NULL, 48, 31, '4031', 'Md Abbas Sk ', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2016, 9, NULL, 48, 31, '4094', 'Md Anowar Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2017, 9, NULL, 48, 31, '4047', 'Md Jahidul', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2018, 12, NULL, 48, 32, '3889', 'Abdul Kayume', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2019, 12, NULL, 48, 32, '3963', 'Md Nymur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2020, 4, NULL, 9, 32, '279', 'Md.Roman Sikdar', 'Senior Electrician', NULL, NULL, '1950269565', '1950269565', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2021, 4, NULL, 9, 32, '879', 'Md. Abdullah', 'Assistant Storekeeper', NULL, NULL, 'abdullah.borak.bd@gmail.com', '1930094029', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2022, 4, NULL, 9, 32, '1744', 'Md. Shabuj', 'Electrician', NULL, NULL, 'mohammad19810101@gmail.com', '1710355953', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2023, 4, NULL, 9, 32, '2380', 'Md. Shamim Hossain', 'Deputy Project Manager', NULL, NULL, NULL, '1716921584', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2024, 4, NULL, 9, 32, '2685', 'Md Hasan-uz-Zaman', 'Project Engineer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2025, 4, NULL, 9, 32, '2684', 'Naser Foysal', 'Project Engineer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2026, 4, NULL, 9, 32, '2844', 'Md. Mamun Mia', 'Welder', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2027, 4, NULL, 9, 32, '2921', 'Md Farhad Mia', 'Welder', NULL, NULL, NULL, '1977422766', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2028, 4, NULL, 9, 32, '2988', 'Md. Khairuzzaman Khokon', 'Deputy Project Manager', NULL, NULL, NULL, '1918085523', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2029, 4, NULL, 9, 32, '1493', 'Joy Chouhan', 'Engineer (Interior Design)', NULL, NULL, 'chouhan20453@gmail.com', '1686235474', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2030, 4, NULL, 9, 32, '3132', 'Md Mosharaf Ali', 'Rope Hoist Operator', NULL, NULL, NULL, '1950137263', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2031, 4, NULL, 17, 32, '2013', 'Md. Raju', 'Lathe Machine Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2032, 4, NULL, 17, 32, '2523', 'Sheikh Humayun Azad', 'Project Engineer', NULL, NULL, NULL, '1716665628', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2033, 4, NULL, 17, 32, '3309', 'Gazi Md Arifuzzman', 'Trainee', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2034, 4, NULL, 17, 32, '3970', 'Parvez Sheikh', 'Welder', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2035, 4, NULL, 17, 32, '4102', 'F.M. Mynur Rahman', 'Project Engineer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2036, 4, NULL, 17, 32, '3100', 'Md Robin Miah', 'Assistant Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2037, 4, NULL, 41, 32, '3289', 'Wahidur Rahman Mamun', 'Storekeeper', NULL, NULL, NULL, '1931405426', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2038, 4, NULL, 48, 32, '2387', 'Md. Humayun Kabir', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2039, 4, NULL, 48, 32, '3154', 'Nerab Panday', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2040, 4, NULL, 48, 32, '3445', 'Md Emon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2041, 4, NULL, 48, 32, '3671', 'Korban Ali Sakil', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2042, 4, NULL, 48, 32, '3690', 'Kazi Faruk', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2043, 4, NULL, 48, 32, '4006', 'Md Imran Hasan Joy', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2044, 5, NULL, 48, 33, '373', 'Md.Rokib Uddin', 'Security Guard', NULL, NULL, NULL, '1716669854', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2045, 5, NULL, 48, 33, '3347', 'Md Tarek', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2046, 12, NULL, 48, 33, '105', 'Md. Mustafizur Rahman', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2047, 12, NULL, 48, 33, '226', 'Md. Hanif Ali', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2048, 12, NULL, 48, 33, '241', 'Md. Raju Ahmmed', 'Security Inspector', NULL, NULL, 'nazim@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2049, 12, NULL, 48, 33, '274', 'Md. Abu Hanif', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2050, 12, NULL, 48, 33, '391', 'Md.Mukul Miah', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '193026982', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2051, 12, NULL, 48, 33, '470', 'Rashidul Islam', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '1737678737', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2052, 12, NULL, 48, 33, '557', 'Forhad Hossain', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '1785674640', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2053, 12, NULL, 48, 33, '632', 'Md.Shariful Islam', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '1788216028', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2054, 12, NULL, 48, 33, '675', 'Forkan Uddin', 'Security Guard', NULL, NULL, 'nazim@uhrlbd.com', '1814187899', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2055, 12, NULL, 48, 33, '2167', 'Md. Sazzad Hossain', 'Security Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2056, 12, NULL, 48, 33, '2204', 'Sanzida Akter Eva', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2057, 12, NULL, 48, 33, '2388', 'Forid Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2058, 12, NULL, 48, 33, '2608', 'Md. Rubel Sarder', 'Security Guard', NULL, NULL, NULL, '1912163932', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2059, 12, NULL, 48, 33, '2926', 'Md. Asif Zaman Rocky', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2060, 12, NULL, 48, 33, '3077', 'Md.Rakibul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2061, 12, NULL, 48, 33, '3076', 'Mst.Sathi Akter', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2062, 12, NULL, 48, 33, '3205', 'Md Hasan Mahmud', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2063, 12, NULL, 48, 33, '3207', 'Md Hanif Howlader', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2064, 12, NULL, 48, 33, '3210', 'Md Sabbir Hossen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2065, 12, NULL, 48, 33, '3237', 'Md Abdul Halim', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2066, 12, NULL, 48, 33, '3245', 'Al-Mamun', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2067, 12, NULL, 48, 33, '3246', 'Minhazul Abedin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2068, 12, NULL, 48, 33, '3324', 'Most. Surma Khatun', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2069, 12, NULL, 48, 33, '3323', 'Runa Akther', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2070, 12, NULL, 48, 33, '3325', 'Md Sah Alom', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2071, 12, NULL, 48, 33, '3359', 'Md Meherul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2072, 12, NULL, 48, 33, '3351', 'Md Masidur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2073, 12, NULL, 48, 33, '3382', 'Md Aliul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2074, 12, NULL, 48, 33, '3381', 'Md Jakirul Islam Jun', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2075, 12, NULL, 48, 33, '3380', 'Md Rasheduzzaman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2076, 12, NULL, 48, 33, '3383', 'Sikta Rongdi', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2077, 12, NULL, 48, 33, '3385', 'Sohel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2078, 12, NULL, 48, 33, '3416', 'Md Nayeem Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2079, 12, NULL, 48, 33, '3431', 'Md Rumon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2080, 12, NULL, 48, 33, '3422', 'Md Akir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2081, 12, NULL, 48, 33, '3423', 'Md Ibrahim Mirdha', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2082, 12, NULL, 48, 33, '3473', 'Sajjad Hossain Sayed', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2083, 12, NULL, 48, 33, '3474', 'Most. Amena Khatun', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2084, 12, NULL, 48, 33, '3486', 'Md Sohan Sarker', 'Security Inspector', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2085, 12, NULL, 48, 33, '3503', 'Md Emran Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2086, 12, NULL, 48, 33, '3502', 'Md Mirajul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2087, 12, NULL, 48, 33, '3527', 'Mosaddek Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2088, 12, NULL, 48, 33, '3507', 'Md Arif Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2089, 12, NULL, 48, 33, '3528', 'Md Jahidul Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2090, 12, NULL, 48, 33, '3529', 'Md Ruhul Amin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2091, 12, NULL, 48, 33, '3490', 'Md Shariar Emon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2092, 12, NULL, 48, 33, '3545', 'Saruar Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2093, 12, NULL, 48, 33, '3640', 'Hafizul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2094, 12, NULL, 48, 33, '3666', 'Md Emamul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2095, 12, NULL, 48, 33, '3669', 'Saddam Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2096, 12, NULL, 48, 33, '3801', 'Md Riazul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2097, 12, NULL, 48, 33, '3626', 'Md Rosul Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2098, 12, NULL, 48, 33, '3775', 'Md Samrat Molla', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2099, 12, NULL, 48, 33, '3808', 'Md Naeem Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2100, 12, NULL, 48, 33, '3822', 'Raju Kundu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2101, 12, NULL, 48, 33, '3824', 'Al-Bahadur Shaikh', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2102, 12, NULL, 48, 33, '3832', 'Md Ripon Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2103, 12, NULL, 48, 33, '3833', 'Md Amran Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2104, 12, NULL, 48, 33, '3891', 'Md Tarekul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2105, 12, NULL, 48, 33, '3936', 'Mamun Or Rashid', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2106, 12, NULL, 48, 33, '3991', 'Sojibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2107, 12, NULL, 48, 33, '4012', 'Md Sobuj Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2108, 12, NULL, 48, 33, '4011', 'Md Tanvir Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2109, 12, NULL, 48, 33, '4051', 'Sirazul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2110, 12, NULL, 48, 33, '4056', 'Md Mustafizur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2111, 12, NULL, 48, 33, '4114', 'Md Al Mamun Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2112, 12, NULL, 48, 33, '4127', 'Md Rashedul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2113, 12, NULL, 48, 33, '4126', 'Md Shahin Alom Mintu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2114, 12, NULL, 48, 33, '4010', 'Sumaiya Begum', 'Lady Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2115, 12, NULL, 48, 33, '3364', 'Redwan Ahmed', 'Bouncer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2116, 12, NULL, 48, 33, '3365', 'Md Juwel Rana', 'Bouncer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2117, 4, NULL, 53, 33, '163', 'Abdul Jabbar', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1715325457', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2118, 4, NULL, 53, 33, '173', 'Md. Anamul Hasan', 'Manager', NULL, NULL, 'hasan.westin@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2119, 4, NULL, 53, 33, '187', 'Mohd. Kamrul Hassan', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1712567758', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2120, 4, NULL, 53, 33, '231', 'Md.Khalil Rahman', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1712059200', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2121, 4, NULL, 53, 33, '230', 'Md.Yasin Ali', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '17171413438', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2122, 4, NULL, 53, 33, '309', 'Md. Tofazzal Hossain', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1710824088', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2123, 4, NULL, 53, 33, '457', 'Md.Kashem Ali', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2124, 4, NULL, 53, 33, '526', 'Md. Asad Mia', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1716643856', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2125, 4, NULL, 53, 33, '525', 'Md. Shah Alam', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1712350644', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2126, 4, NULL, 53, 33, '597', 'Md Al Mobin', 'Transport Desk Associate', NULL, NULL, 'nazim@uhrlbd.com', '1911566770', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2127, 4, NULL, 53, 33, '772', 'Foysal Khan', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1922933900', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2128, 4, NULL, 53, 33, '771', 'Syed Nazrul Islam', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1913723642', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2129, 4, NULL, 53, 33, '809', 'Md. Wahiduzzaman', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1718310779', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2130, 4, NULL, 53, 33, '1344', 'Md.Mokul Hossain', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1727196000', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2131, 4, NULL, 53, 33, '2160', 'Utso Rema', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2132, 4, NULL, 53, 33, '2280', 'Toufiq Hasan', 'Transport Desk Associate', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2133, 4, NULL, 53, 33, '2161', 'Prodip Roy', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2134, 4, NULL, 53, 33, '3087', 'Lalon Fakir', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2135, 4, NULL, 53, 33, '263', 'Md.Sumon Gazi', 'Guest Driver', NULL, NULL, 'hasan.westin@uhrlbd.com', '1741084488', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2136, 4, NULL, 53, 33, '3088', 'Md Ariful Islam', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2137, 4, NULL, 53, 33, '3117', 'Md Humaun Kabir', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2138, 4, NULL, 53, 33, '3288', 'Md Ismail Hossain', 'Transport Desk Associate', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2139, 4, NULL, 53, 33, '3332', 'Md Anaet Ullah Khokon', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2140, 4, NULL, 53, 33, '3334', 'Polton Baroy', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2141, 4, NULL, 53, 33, '3373', 'Manuel Chambugong', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2142, 4, NULL, 53, 33, '3438', 'Md Amanullah Aman', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2143, 4, NULL, 53, 33, '3517', 'Md Ashraful Islam ', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2144, 4, NULL, 53, 33, '3516', 'Belal Hossain', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2145, 4, NULL, 53, 33, '3522', 'Mithul D\'\'\'\'Costa', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2146, 4, NULL, 53, 33, '3515', 'Adnis Rozario', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2147, 4, NULL, 53, 33, '3612', 'Tonmoy Das ', 'Transport Desk Associate', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2148, 4, NULL, 53, 33, '4125', 'Md Jamal Uddin', 'Guest Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2149, 4, NULL, 41, 34, '3338', 'S.M.A.K Bahauddin', 'Liaison Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2150, 4, NULL, 41, 34, '3413', 'Shawon Mahmud Shohag', 'Coordination Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2151, 5, NULL, 9, 35, '529', 'Mahammad Nazrul Islam', 'Senior Executive', NULL, NULL, 'mdnazrulislam.01818@gmail.com', '1818373604', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2152, 5, NULL, 9, 35, '666', 'Md. Nazmul Hasan', 'Storekeeper', NULL, NULL, 'nazmul008135@gmail.com', '01723592611/01708800784', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2153, 5, NULL, 9, 35, '880', 'Md. Ali Akbar', 'Plumber', NULL, NULL, 'aliakbar25041988@gmail.com', '1706421218', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2154, 5, NULL, 9, 35, '1000', 'Md. Mozibur Rahman', 'Surveyor', NULL, NULL, 'moziburrahman001000@gnail.com', '01770566003, 01929809382', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2155, 5, NULL, 9, 35, '957', 'Nasir Khan', 'Safety Supervisor', NULL, NULL, 'acropolis@borakbd.com', '1963820578', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2156, 5, NULL, 9, 35, '1159', 'Mohammad Borhan Uddin', 'Supervisor', NULL, NULL, 'mdborhanuddin699@gmail.com', '1718356670', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2157, 5, NULL, 9, 35, '1253', 'Md.Ragya Miah', 'Welder', NULL, NULL, 'acropolis@borakbd.com ', '1948447069', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2158, 5, NULL, 9, 35, '1607', 'Sumon Hossain', 'Safety Supervisor', NULL, NULL, 'sumon_hossain@hotmail.com', '1799617030', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2159, 5, NULL, 9, 35, '1764', 'Sharaft Hossain', 'Mechanic', NULL, NULL, 'acropolis@borakbd.com ', '19852119006', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2160, 5, NULL, 9, 35, '1829', 'Md. Masud Rana', 'Operator (Rope Hoist, Tower Hoist, Mixture Machine and Safety)', NULL, NULL, 'acropolis@borakbd.com', '1718482211', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2161, 5, NULL, 9, 35, '317', 'Md. Amzad Hossain', 'Rope Hoist Operator', NULL, NULL, 'acropolis@borakbd.com', '1821265242', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2162, 5, NULL, 9, 35, '2285', 'Md. Ronzu', 'Welder Helper', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2163, 5, NULL, 17, 35, '1457', 'Md. Sujon Khan', 'Crane Operator', NULL, NULL, 'sujonkhan01011984@gmail.com', '1741234780', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2164, 5, NULL, 17, 35, '3089', 'Md Nurzaman Islam Faruq', 'Plumber', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2165, 5, NULL, 17, 35, '3341', 'Md Safiul Alam', 'Lift Operator', NULL, NULL, NULL, '1722934629', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2166, 5, NULL, 17, 35, '3615', 'Awolad Hossen', 'Senior Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2167, 5, NULL, 17, 35, '3618', 'Monir Khan', 'Senior Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2168, 5, NULL, 17, 35, '2834', 'Md Milon Islam', 'Welder Helper', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2169, 5, NULL, 17, 35, '3619', 'Md Sabuj Mollah', 'Assistant Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2170, 5, NULL, 18, 35, '1876', 'S. M. Ariful Islam', 'Operator (Parking Management System)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2171, 5, NULL, 48, 35, '104', 'Abdur Satter', 'Security Guard', NULL, NULL, NULL, '1932684094', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2172, 5, NULL, 48, 35, '127', 'Md.Manik Mondal', 'Security Guard', NULL, NULL, NULL, '1944602127', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2173, 5, NULL, 48, 35, '341', 'Md. Anwar Hossain', 'Security Guard', NULL, NULL, NULL, '1949315781', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2174, 5, NULL, 48, 35, '538', 'Md.Milon Ahmed', 'Security Supervisor', NULL, NULL, NULL, '1681890303', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2175, 5, NULL, 48, 35, '893', 'Cpl. Retd. Md. Anisur Rahman', 'Security Guard', NULL, NULL, NULL, '1713516788', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2176, 5, NULL, 48, 35, '1671', 'Md Abdul Hannan Sarkar', 'Security Supervisor', NULL, NULL, NULL, '1728284439', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2177, 5, NULL, 48, 35, '3146', 'Md Kawser Hosen', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2178, 5, NULL, 48, 35, '3232', 'Md Rakit Al Hassan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2179, 5, NULL, 48, 35, '3506', 'Habibur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2180, 5, NULL, 48, 35, '3535', 'Abdullah Al Noman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2181, 5, NULL, 48, 35, '3629', 'Fajor Ali Shakil', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2182, 5, NULL, 52, 35, '443', 'Md.Shofikur Rahman', 'General Manager (Construction)', NULL, NULL, 'shofikentu@borakbd.com', '1712532235', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2183, 12, NULL, 18, 35, '3681', 'Zubayer Al Mamun', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2184, 12, NULL, 18, 35, '3915', 'Md Rakib Howlader ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2185, 12, NULL, 18, 35, '3916', 'Md Sagor Hossain ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2186, 12, NULL, 18, 35, '4079', 'Alamin Hossain', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2187, 12, NULL, 18, 35, '4080', 'Alif', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2188, 12, NULL, 48, 35, '2549', 'Md. Abu Hanif', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2189, 12, NULL, 48, 35, '3826', 'Md Hafizul Joaddar', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2190, 12, NULL, 48, 35, '3888', 'Md Omar Faruk', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2191, 4, NULL, 9, 35, '71', 'Nazrul Islam (Shamim)', 'Safety Supervisor', NULL, NULL, 'mohammad19810101@gmail.com', '1911172696', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2192, 4, NULL, 17, 35, '3367', 'Engr. Khandakar Mozammel Hossan', 'Chief Engineer - UHRL', NULL, NULL, NULL, '1557791187', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2193, 4, NULL, 48, 35, '2794', 'Md. Saiful Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2194, 14, NULL, 4, 36, '4002', 'Md Moniruzzaman', 'Assistant Manager', NULL, NULL, NULL, '1721203764', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2195, 14, NULL, 6, 36, '28', 'Mr.Eakub Ali', 'Fire Electrician', NULL, NULL, 'khaled@uniqueceramicbd.com', '1913880826', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2196, 14, NULL, 6, 36, '389', 'Mohammad Monsur Hossain', 'Supervisor (Store)', NULL, NULL, 'monsurhossain195@gmail.com', '1875183507', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2197, 14, NULL, 6, 36, '608', ' Sujan ', 'Fire Electrician', NULL, NULL, 'khaled@uniqueceramicbd.com', '1917558884', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2198, 14, NULL, 6, 36, '1125', 'Md. Khaleduzzaman', 'Senior Executive (Accounts)', NULL, NULL, 'khaled@uniqueceramicbd.com', '1913444991', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2199, 14, NULL, 6, 36, '1299', 'Shamim Hossain Mojumder', 'Emam', NULL, NULL, 'khaled@uniqueceramicbd.com', '1994579168', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2200, 14, NULL, 6, 36, '1334', 'Mohammad Ferdousur Rahman', 'Clerk', NULL, NULL, 'ferdousrahman198@gmail.com', '1682672206', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2201, 14, NULL, 6, 36, '1561', 'Rusho  Ahmed', 'Store Assistant', NULL, NULL, 'store@uniqueceramicbd.com', '1717254966', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2202, 14, NULL, 6, 36, '2090', 'Md. Mainul Islam Moin', 'Storekeeper', NULL, NULL, NULL, '1734445218', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2203, 14, NULL, 19, 36, '3758', 'Md Nazmul Hasan ', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2204, 14, NULL, 19, 36, '4035', 'Md Ashikur Rahman', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2205, 14, NULL, 41, 36, '2632', 'Md. Chan Mia', 'Fireman Helper', NULL, NULL, NULL, '1312862781', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2206, 14, NULL, 41, 36, '3102', 'Md Manik Mia', 'Fireman Helper', NULL, NULL, NULL, '1763764096', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2207, 14, NULL, 41, 36, '4098', 'Md Mamun Islam', 'Fireman Helper', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2208, 14, NULL, 41, 36, '4099', 'Md Papel Miya', 'Fireman Helper', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2209, 14, NULL, 45, 36, '53', 'Md. Kawcchar Ali Khan', 'Factory Plant and Machineries Mechanic', NULL, NULL, 'khaled@uniqueceramicbd.com', '1918983120', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2210, 14, NULL, 45, 36, '68', 'Md. Tofazzal Hossain', 'Block Machine Operator', NULL, NULL, 'khaled@uniqueceramicbd.com ', '1851839126', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2211, 14, NULL, 45, 36, '69', 'Md. Anwar Hossain', 'Supervisor', NULL, NULL, 'khaled@uniqueceramicbd.com ', '1769501631', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2212, 14, NULL, 45, 36, '86', 'Md. Maznu', 'Junior Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1746996249', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2213, 14, NULL, 45, 36, '99', 'Md. Jakir Hossain', 'Truck Mechanic', NULL, NULL, 'mohammad19810101@gmail.com', '1933384918', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2214, 14, NULL, 45, 36, '103', 'Mr.Abdul Khaleque', 'Clean Mistri', NULL, NULL, 'mohammad19810101@gmail.com', '1827141264', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2215, 14, NULL, 45, 36, '109', 'Md. Riazul Islam', 'Junior Fireman', NULL, NULL, 'mohammad19810101@gmail.com', '1918897410', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2216, 14, NULL, 45, 36, '122', 'Jashim Uddin', 'Senior Electrician', NULL, NULL, 'mohammad19810101@gmail.com', '1712582377', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2217, 14, NULL, 45, 36, '164', 'Mr. Nuruzzman', 'Junior Fireman', NULL, NULL, 'mohammad19810101@gmail.com', '1768036199', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2218, 14, NULL, 45, 36, '183', 'Md. Alamgir Sheikh', 'Welder', NULL, NULL, 'khaled@uniqueceramicbd.com', '1621331844', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2219, 14, NULL, 45, 36, '184', 'Md. Osman Ali', 'Supervisor', NULL, NULL, 'khaled@uniqueceramicbd.com', '1918937352', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2220, 14, NULL, 45, 36, '269', 'Md. Metul Khan', 'Payloader Driver', NULL, NULL, 'khaled@uniqueceramicbd.com', '1735307812', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2221, 14, NULL, 45, 36, '271', 'Md. Abu Sayed', 'Lathe Machine Operator', NULL, NULL, 'khaled@uniqueceramicbd.com', '1746310042', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2222, 14, NULL, 45, 36, '303', 'Md. Abu Sayeed', 'Chain Dozzer Operator', NULL, NULL, 'khaled@uniqueceramicbd.com', '1941362998', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2223, 14, NULL, 45, 36, '307', 'Alam Mia', 'Senior Truck Mechanic', NULL, NULL, 'khaled@uniqueceramicbd.com', '1915793358', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2224, 14, NULL, 45, 36, '399', 'Md. Azizul Islam', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1625807461', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2225, 14, NULL, 45, 36, '433', 'Md. Lokman Hossain', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1780446563', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07');
INSERT INTO `employees` (`id`, `unit_id`, `company_id`, `department_id`, `location_id`, `employee_id`, `employee_name`, `designation`, `employee_description`, `gender`, `employee_email`, `employee_phone`, `employee_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(2226, 14, NULL, 45, 36, '437', 'Mr. Lalmia', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1723942807', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2227, 14, NULL, 45, 36, '561', 'Mr. Safiqul Islam', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1757631685', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2228, 14, NULL, 45, 36, '588', 'Rejaul Karim', 'Junior Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '177237682', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2229, 14, NULL, 45, 36, '1163', 'Mr. Ronju Ahmed', 'Fire Incharge', NULL, NULL, 'khaled@uniqueceramicbd.com ', '1960572128', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2230, 14, NULL, 45, 36, '825', 'Md. Momin Miah', 'Factory Truck Driver', NULL, NULL, 'khaled@uniqueceramicbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2231, 14, NULL, 45, 36, '1046', 'Mohammad Nazmul Haque', 'Officer (Quality Control)', NULL, NULL, 'nazmul2077@gmail.com', '1732932960', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2232, 14, NULL, 45, 36, '1206', ' Md.Abdul Halim', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1968178438', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2233, 14, NULL, 45, 36, '1200', 'Mohammad Faruk', 'Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1763163949', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2234, 14, NULL, 45, 36, '1208', 'Md.Ariful Islam Arif', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1716746225', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2235, 14, NULL, 45, 36, '1199', 'Md.Ariful Mollah (Nedu)', 'Senior Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1930226404', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2236, 14, NULL, 45, 36, '1211', 'Md.Jafor', 'Junior Mechanic', NULL, NULL, 'khaled@uniqueceramicbd.com', '1746009902', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2237, 14, NULL, 45, 36, '1210', 'Md.Lablu Miah', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1920724976', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2238, 14, NULL, 45, 36, '1204', 'Md.Mojnu Mia', 'Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1745246967', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2239, 14, NULL, 45, 36, '1209', 'Md.Nur Alam', 'Fireman Helper', NULL, NULL, NULL, '1710722508', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2240, 14, NULL, 45, 36, '1201', 'Md.Rafikul Islam', 'Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1729803531', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2241, 14, NULL, 45, 36, '1207', 'Md.Sujon Miah', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1725425668', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2242, 14, NULL, 45, 36, '1202', 'Robiul Islam', 'Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1946737533', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2243, 14, NULL, 45, 36, '1340', 'Md.Abdul Mazid', 'Truck Driver', NULL, NULL, 'khaled@uniqueceramicbd.com ', '1716839307', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2244, 14, NULL, 45, 36, '1362', 'Md.Jakaria Hossain', 'Production Supervisor', NULL, NULL, 'khaled@uniqueceramicbd.com ', '1706673430', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2245, 14, NULL, 45, 36, '1432', 'Md. Mokhlechur Rahman', 'Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1773434101', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2246, 14, NULL, 45, 36, '1433', 'Md. Solaiman Ali Sarker', 'Fireman', NULL, NULL, 'khaled@uniqueceramicbd.com', '1783106501', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2247, 14, NULL, 45, 36, '1437', 'Md. Akbar', 'Driver', NULL, NULL, 'khaled@uniqueceramicbd.com', '1733549485', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2248, 14, NULL, 45, 36, '1390', 'Md. Shofiqul Islam', 'Deputy General Manager', NULL, NULL, 'shofiq@uniqueceramicbd.com', '1711974241', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2249, 14, NULL, 45, 36, '1576', 'Md. Kamal', 'Truck Driver', NULL, NULL, 'khaled@uniqueceramicbd.com', NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2250, 14, NULL, 45, 36, '1577', 'Md. Samirul Islam', 'Junior Dozer Operator', NULL, NULL, 'khaled@uniqueceramicbd.com', '1761088329', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2251, 14, NULL, 45, 36, '1635', 'Md Rubel Mia', 'Fireman Helper', NULL, NULL, 'khaled@uniqueceramicbd.com', '1721822348', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2252, 14, NULL, 45, 36, '1935', 'Mofazzal Hossain', 'Fireman', NULL, NULL, NULL, '1775323162', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2253, 14, NULL, 48, 36, '41', 'Md.Shahidur Rahman', 'Security Guard', NULL, NULL, NULL, '1995190185', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2254, 14, NULL, 48, 36, '151', 'Md.Helal Uddin', 'Security Guard', NULL, NULL, NULL, '1722736162', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2255, 14, NULL, 48, 36, '1241', 'Md.Munjurul Islam', 'Security Guard', NULL, NULL, NULL, '1747419811', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2256, 14, NULL, 48, 36, '354', 'Md Dulal Hossen', 'Security Guard', NULL, NULL, NULL, '1738648465', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2257, 14, NULL, 48, 36, '416', 'Md.Aminul', 'Security Guard', NULL, NULL, NULL, '1836330773', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2258, 14, NULL, 48, 36, '516', 'Md. Afzal Hossain', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2259, 14, NULL, 48, 36, '524', 'Md. Shahidul Islam', 'Security Guard', NULL, NULL, NULL, '1760978423', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2260, 14, NULL, 48, 36, '1063', 'Md.Rashidul Islam Suman', 'Security Supervisor', NULL, NULL, NULL, '1719891156', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2261, 14, NULL, 48, 36, '1068', 'Abdur Rakib', 'Security Guard', NULL, NULL, NULL, '1790633619', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2262, 14, NULL, 48, 36, '1396', 'Md.Habibur Rahman', 'Security Guard', NULL, NULL, NULL, '1710617500', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2263, 14, NULL, 48, 36, '1869', 'Md. Alamgir', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2264, 14, NULL, 48, 36, '2099', 'Safiqul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2265, 14, NULL, 48, 36, '2235', 'Md. Amdadul Hoqe', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2266, 14, NULL, 48, 36, '2296', 'Md. Esahak Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2267, 14, NULL, 48, 36, '2361', 'Md. Mokarom Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2268, 14, NULL, 48, 36, '2488', 'Komol Chandra Das', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2269, 14, NULL, 48, 36, '2827', 'Shah Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2270, 14, NULL, 48, 36, '2867', 'Md. Jasim Uddin', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2271, 14, NULL, 48, 36, '3301', 'Md Zahangir', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2272, 14, NULL, 48, 36, '3635', 'Md Gaddapi Molla', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2273, 14, NULL, 48, 36, '3634', 'Md Golam Rabbi', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2274, 14, NULL, 48, 36, '3688', 'Md Amdadul Huq', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2275, 14, NULL, 48, 36, '3788', 'Md Monjurul Alom Parmanik', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2276, 14, NULL, 48, 36, '3789', 'Arshed Ali', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2277, 14, NULL, 48, 36, '4065', 'Sohel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2278, 14, NULL, 48, 36, '3980', 'Sohel Rana', 'Security Officer', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2279, 14, NULL, 48, 36, '4018', 'Md Ahadul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2280, 14, NULL, 48, 36, '4054', 'Fozlul Karim', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2281, 14, NULL, 48, 36, '4055', 'Md Rabbi Sarder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2282, 14, NULL, 48, 36, '4057', 'Rashal Sarder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2283, 14, NULL, 48, 36, '4059', 'Md Emdadul Haque Melon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2284, 14, NULL, 48, 36, '4158', 'Md Rasal Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2285, 14, NULL, 48, 36, '4163', 'Md Mizu Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2286, 14, NULL, 49, 36, '2765', 'Jabiul Ahmed', 'Senior Executive (Sales & Marketing)', NULL, NULL, NULL, '+8801713-823063', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2287, 14, NULL, 53, 36, '916', 'Md. Amarot Hossain', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1910784624', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2288, 14, NULL, 53, 36, '1339', 'Md.Askender Shardar', 'Driver', NULL, NULL, 'khaled@uniqueceramicbd.com ', '1924941028', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2289, 14, NULL, 53, 36, '1826', 'Md. Rofiqul Islam', 'Driver', NULL, NULL, NULL, '1705587727', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2290, 14, NULL, 53, 36, '2127', 'Jakir Hossain', 'Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2291, 14, NULL, 53, 36, '2317', 'Sumon Bepare', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2292, 14, NULL, 53, 36, '2398', 'Rafiqul Islam', 'Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2293, 14, NULL, 53, 36, '2909', 'Rabiul Islam', 'Truck Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2294, 14, NULL, 53, 36, '3136', 'Md Izibor Sheikh', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2295, 12, NULL, 4, 37, '3262', 'Mahful Islam', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2296, 12, NULL, 4, 37, '3263', 'Md. Romjan Ali', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2297, 12, NULL, 4, 37, '3264', 'Tareq Ali', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2298, 12, NULL, 4, 37, '3653', 'Md Moynul Islam', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2299, 12, NULL, 18, 37, '3563', 'Md Anowar Hosen', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2300, 12, NULL, 18, 37, '3663', 'Sri Subas', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2301, 12, NULL, 18, 37, '3815', 'Md Rofiqul Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2302, 12, NULL, 18, 37, '3818', 'Md Fordulla Mia', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2303, 12, NULL, 18, 37, '3819', 'Md Shipon Ali', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2304, 12, NULL, 18, 37, '3906', 'Al Mahfuj Shikder ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2305, 12, NULL, 18, 37, '3907', 'Md Arif Hossain ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2306, 12, NULL, 18, 37, '3897', 'Md Shamim ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2307, 12, NULL, 18, 37, '4022', 'Md Momin Hossain', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2308, 12, NULL, 18, 37, '4023', 'Nirob Mozumdar', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2309, 12, NULL, 48, 37, '500', 'Md.Atoar', 'Security Guard', NULL, NULL, NULL, '1751364888', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2310, 12, NULL, 48, 37, '655', 'Md.Ansar Ali', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2311, 12, NULL, 48, 37, '2115', 'Md. Jahangir Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2312, 12, NULL, 48, 37, '3510', 'Shakir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2313, 6, NULL, 4, 37, '3860', 'Md Mostafizur Rahman', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2314, 6, NULL, 6, 37, '23', 'Nazmul Hossain', 'Manager (Accounts)', NULL, NULL, 'htanzirul@gmail.com ', '1769501451', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2315, 6, NULL, 6, 37, '111', 'Faruk Ahamed Khan', 'Associate (IT)', NULL, NULL, 'fakhan@uniqueeastern.com', '1769501432', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2316, 6, NULL, 6, 37, '485', 'Md.Nurul Haque', 'Office Executive (File Management)', NULL, NULL, 'htanzirul@gmail.com', '1557370039', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2317, 6, NULL, 6, 37, '752', 'Md. Sahidul Islam', 'Executive (IT)', NULL, NULL, 'mesajib7@gmail.com', '1681210974', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2318, 6, NULL, 6, 37, '1431', 'Arafat Hossain', 'Accounts Officer (Cash)', NULL, NULL, 'arafat4625@gmail.com', '1818294625', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2319, 6, NULL, 6, 37, '1453', 'Sheikh Muhammad Mobaswirul Islam', 'Deputy Manager', NULL, NULL, 'mobaswir@uniqueeastern.com', '1753517068', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2320, 6, NULL, 6, 37, '1531', 'Md. Osman Goni', 'Senior Executive (Finance & Accounts)', NULL, NULL, 'osman@uniqueeastern.com', '1919577375', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2321, 6, NULL, 6, 37, '2028', 'Nayeem Uddin', 'Senior Executive', NULL, NULL, NULL, '1812329915', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2322, 6, NULL, 6, 37, '2566', 'Md. Shihab Rayhan', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2323, 6, NULL, 6, 37, '188', 'Mozaffar Dewan', 'Associate (IT)', NULL, NULL, 'mozaffar@uniqueeastern.com', '1819152186', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2324, 6, NULL, 6, 37, '174', 'Md. Lutfor Rahman', 'Senior Office Executive', NULL, NULL, 'lutfur@uniqueeastern.com', '1712414602', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2325, 6, NULL, 19, 37, '3762', 'Md Mahibbullah Rasel', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2326, 6, NULL, 19, 37, '3863', 'Md Mahibbullah Rasel', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2327, 6, NULL, 19, 37, '3864', 'Md Al-Mamun', 'Senior Executive', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2328, 6, NULL, 36, 37, '3716', 'D.M. Ratul Arafat', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2329, 6, NULL, 41, 37, '203', 'Ismail Hossain Dulal', 'Officer (Processing)', NULL, NULL, 'htanzirul@gmail.com', '1715152872', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2330, 6, NULL, 41, 37, '372', 'Sairul Islam', 'Executive (Processing)', NULL, NULL, 'htanzirul@gmail.com', '1770180017', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2331, 6, NULL, 41, 37, '564', 'Md. Jasim Uddin', 'Executive', NULL, NULL, 'juddin0706@gmail.com', '1682800400', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2332, 6, NULL, 41, 37, '630', 'Md. Selim Shahriar', 'General Manager', NULL, NULL, 'shahriarsalim78@gmail.com ', '1713035156', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2333, 6, NULL, 41, 37, '968', 'Kanchon Bhuiyan', 'Executive (Processing)', NULL, NULL, 'kanchan@uniqueeastern.com', '1672323885', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2334, 6, NULL, 41, 37, '1302', 'Masudur Rahman', 'Visa Coordinator', NULL, NULL, 'visa@uniqueeastern.com', '1730922282', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2335, 6, NULL, 41, 37, '1375', 'Md.Zahid Alam', 'Executive', NULL, NULL, 'alamstyler@gmail.com', '1710990999', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2336, 6, NULL, 41, 37, '1388', 'Shoel Rana', 'Executive (Processing.)', NULL, NULL, 'bdsohelrana@gmail.com', '1737247164', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2337, 6, NULL, 41, 37, '1439', 'Md. Mostafizur Rahman', 'Data Entry Operator', NULL, NULL, 'mrrahman505@gmail.com', '1629878696', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2338, 6, NULL, 41, 37, '1532', 'Rashmin Ara Popi', 'Senior Executive', NULL, NULL, 'rashmin@uniqueeastern.com', '1717160044', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2339, 6, NULL, 41, 37, '3651', 'Md Mamun Hawlader', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2340, 6, NULL, 41, 37, '3652', 'Muhammad Kawser Patwary', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2341, 6, NULL, 41, 37, '3683', 'Md Humayun Kabir', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2342, 6, NULL, 41, 37, '3684', 'Md Riaj Howlader', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2343, 6, NULL, 41, 37, '3704', 'Shebak Kumar Sahah', 'Accounts Officer (Cash)', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2344, 6, NULL, 41, 37, '3705', 'Mohibul Islam', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2345, 6, NULL, 41, 37, '3706', 'Sharmin Akter', 'Open Position', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2346, 6, NULL, 41, 37, '3723', 'Md Al-Amin', 'Data Entry Operator', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2347, 6, NULL, 48, 37, '2051', 'Md. Sahabuddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2348, 6, NULL, 48, 37, '3356', 'Abhijit Howlader', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2349, 6, NULL, 48, 37, '3357', 'Md Sujon Mollah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2350, 6, NULL, 48, 37, '3476', 'Raihanul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2351, 6, NULL, 48, 37, '3542', 'Md Nayem', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2352, 6, NULL, 48, 37, '4129', 'Md Sohidul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2353, 6, NULL, 52, 37, '739', 'Md. Emdadul Bari', 'General Manager', NULL, NULL, 'bari@uniqueeastern.com', '1713178873', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2354, 5, NULL, 48, 38, '4154', 'Md Tufayel Alam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2355, 12, NULL, 4, 38, '3999', 'Md Mashud Gazi', 'Service Assistant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2356, 6, NULL, 6, 38, '834', 'Md. Shahan Ullah', 'Welding Supervisor', NULL, NULL, NULL, '1717132532', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2357, 6, NULL, 19, 38, '476', 'Md.Nahid Ul Islam', 'General Manager (Finance & Accounts)', NULL, NULL, 'nahid@uniquevocationalbd.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2358, 6, NULL, 41, 38, '112', 'Musfiqur Rahaman Palash', 'Assistant Manager (Processing)', NULL, NULL, 'musfiqurrahaman707@gmail.com', '1818154085', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2359, 6, NULL, 41, 38, '242', 'Md.Ershad Hakim', 'In-charge', NULL, NULL, 'ershad@uniquevocationalbd.com', '1717050300', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2360, 6, NULL, 41, 38, '142', 'Md. Zobair Dewan', 'Instructor', NULL, NULL, 'zobairue@gmail.com', '1716580819', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2361, 6, NULL, 48, 38, '336', 'Md Abdul Khaleq', 'Security Guard', NULL, NULL, NULL, '1926482863', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2362, 6, NULL, 48, 38, '390', 'Abdur Razzaque', 'Security Guard', NULL, NULL, NULL, '1726227129', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2363, 6, NULL, 48, 38, '460', 'Bhabatosh Chakraborty', 'Security Supervisor', NULL, NULL, 'nazim@uhrlbd.com', '1712061964', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2364, 6, NULL, 48, 38, '1393', 'Muddaqusrul Huq', 'Security Guard', NULL, NULL, NULL, '1706468926', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2365, 6, NULL, 48, 38, '2047', 'Sayeed Talukder Montu', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2366, 6, NULL, 52, 38, '2983', 'Mohiuddin Ahmed', 'General Manager', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2367, 12, NULL, 18, 39, '36', 'Asm Abdullaha (Monzu)', 'Deputy Facility Manager', NULL, NULL, 'monzu@uniquehansa.com', '1912100568', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2368, 12, NULL, 18, 39, '161', 'Md. Khairul Sarder', 'Lift Operator', NULL, NULL, 'monzu@uniquehansa.com', '1731404852', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2369, 12, NULL, 18, 39, '321', 'Md. Enamul Haque', 'Electrician', NULL, NULL, 'monzu@uniquehansa.com', '1817116400', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2370, 12, NULL, 18, 39, '801', 'Md. Enamul Haque', 'Receptionist', NULL, NULL, 'shakil@uniquehansa.com ', '1780155190', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2371, 12, NULL, 18, 39, '956', 'Md. Shimol Miah', 'Plumber', NULL, NULL, 'shakil@uniquehansa.com', '1985086920', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2372, 12, NULL, 18, 39, '1978', 'Md. Mehedi Hasan', 'Electrician', NULL, NULL, NULL, '1714504310', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2373, 12, NULL, 18, 39, '1997', 'Md. Momenul Haque', 'Deputy Facility Manager', NULL, NULL, 'momenul.haque@uniquehansa.com', '1722736645', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2374, 12, NULL, 18, 39, '2812', 'Md. Heron Khan', 'Gardener', NULL, NULL, NULL, '1608835832', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2375, 12, NULL, 18, 39, '3109', 'kamruzzaman', 'Housekeeping Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2376, 12, NULL, 18, 39, '757', 'Md. Monir Hossen', 'Housekeeping Attendant', NULL, NULL, 'monzu@uniquehansa.com', '1849224112', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2377, 12, NULL, 18, 39, '1130', 'Md.Ramjan Miah', 'Housekeeping Attendant', NULL, NULL, 'monzu@uniquehansa.com', '1775221824', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2378, 12, NULL, 18, 39, '1912', 'Mehedi Hasan', 'Front Desk Executive', NULL, NULL, NULL, '1739163238', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2379, 12, NULL, 18, 39, '2294', 'Md. Dulal Hossain', 'Housekeeping Attendant', NULL, NULL, NULL, '1830701558', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2380, 12, NULL, 18, 39, '3664', 'Elpa Saimon', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2381, 12, NULL, 18, 39, '3909', 'Md Ali', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2382, 12, NULL, 18, 39, '3912', 'Md Sarif Ahmed ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2383, 12, NULL, 18, 39, '4085', 'Saiful Islam', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2384, 12, NULL, 18, 39, '213', 'Md.Nasir Ullah (Labu)', 'Guest Service Attendant', NULL, NULL, NULL, '1556367935', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2385, 12, NULL, 23, 39, '2768', 'Md Selim Mia', 'Housekeeping Attendant', NULL, NULL, NULL, '1798085684', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2386, 12, NULL, 41, 39, '3126', 'Md Kaosar Sarder', 'Lift Operator', NULL, NULL, NULL, '1756711975', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2387, 12, NULL, 48, 39, '160', 'Md.Rakebul Hasan Molla', 'Security Supervisor', NULL, NULL, NULL, '1718832723', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2388, 12, NULL, 48, 39, '464', 'Liton Howlader', 'Security Guard', NULL, NULL, NULL, '1774721085', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2389, 12, NULL, 48, 39, '687', 'Abdur Razzak', 'Security Guard', NULL, NULL, NULL, '1747249324', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2390, 12, NULL, 48, 39, '1422', 'Md.Salim Imran', 'Security Guard', NULL, NULL, NULL, '1773369684', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2391, 12, NULL, 48, 39, '1626', 'Md Mizanur Rahaman', 'Security Guard', NULL, NULL, NULL, '1914765630', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2392, 12, NULL, 48, 39, '3349', 'Sohorab Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2393, 12, NULL, 48, 39, '3639', 'Sohel Rana', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2394, 12, NULL, 48, 39, '3646', 'Tajriean Islam Marjan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2395, 12, NULL, 48, 39, '3876', 'Md Abu Bakkar Siddik', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2396, 12, NULL, 48, 39, '3875', 'Md Raihanul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2397, 12, NULL, 48, 39, '3877', 'Shaidur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2398, 12, NULL, 48, 39, '3992', 'Md Anivhur Rahman', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2399, 12, NULL, 53, 40, '3685', 'Md Lutfar Rahman', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2400, 12, NULL, 53, 40, '3964', 'Abu Sayed', 'Driver', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2401, 5, NULL, 48, 41, '682', 'Md.Sakender Ali', 'Security Guard', NULL, NULL, NULL, '1736915020', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2402, 5, NULL, 48, 41, '1320', 'Shahin', 'Security Guard', NULL, NULL, NULL, '1747743140', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2403, 5, NULL, 48, 41, '3989', 'Md Liton Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2404, 12, NULL, 18, 41, '38', 'Mr.Lutfor Mollah', 'Lift Operator', NULL, NULL, 'shakil@uniquehansa.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2405, 12, NULL, 18, 41, '70', 'Mr.Abdul Jalil', 'Lift Operator', NULL, NULL, 'shakil@uniquehansa.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2406, 12, NULL, 18, 41, '616', 'Md. Sagor Howlader', 'Lift Operator', NULL, NULL, 'shakil@uniquehansa.com', '1675279331', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2407, 12, NULL, 18, 41, '1461', 'Hridaoy Sheikh', 'Electrician', NULL, NULL, 'monzu@uniquehansa.com', '1858942151', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2408, 12, NULL, 18, 41, '2821', 'Sagor Howlader', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2409, 12, NULL, 18, 41, '49', 'Mr.Gazi Muktar', 'Housekeeping Attendant', NULL, NULL, 'shakil@uniquehansa.com', '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2410, 12, NULL, 18, 41, '1593', 'Sangran  Mree', 'Housekeeping Attendant', NULL, NULL, 'shakil@uniquehansa.com', '1948797558', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2411, 12, NULL, 18, 41, '3032', 'Md Shepon', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2412, 12, NULL, 18, 41, '3901', 'Md Rezaul Karim ', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2413, 12, NULL, 23, 41, '2968', 'Bokul Mankhin', 'Housekeeping Attendant', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2414, 12, NULL, 48, 41, '65', 'Mr.Md.Mahbub Alam Saju', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2415, 12, NULL, 48, 41, '114', 'Md. Saidul Islam', 'Security Guard', NULL, NULL, NULL, '1746398488', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2416, 12, NULL, 48, 41, '200', 'Md.Abdul Kuddus', 'Security Guard', NULL, NULL, NULL, '1825684892', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2417, 12, NULL, 48, 41, '483', 'Md.Tarek Mondol', 'Security Guard', NULL, NULL, NULL, '0', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2418, 12, NULL, 48, 41, '1904', 'Jakir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:07', '2023-03-15 05:09:07'),
(2419, 12, NULL, 48, 41, '2362', 'Md. Saiduzzaman', 'Security Supervisor', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2420, 12, NULL, 48, 41, '2538', 'Md. Fazle Rabbi', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2421, 12, NULL, 48, 41, '2563', 'Md. Abdul Jalil Mollah', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2422, 12, NULL, 48, 41, '2735', 'Md. Abu Sayed Ansari', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2423, 12, NULL, 48, 41, '3455', 'Manik Bala', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2424, 12, NULL, 48, 41, '3534', 'Md Mohiuddin', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2425, 12, NULL, 48, 41, '3674', 'Shabe Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2426, 12, NULL, 48, 41, '3774', 'Md Jahid Hassan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2427, 12, NULL, 48, 41, '3962', 'Saidur Rahman Sarder', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2428, 12, NULL, 48, 41, '3890', 'Md Abu Jafor', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2429, 12, NULL, 48, 41, '3993', 'Md Shohag Prodhann Shohan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2430, 12, NULL, 48, 41, '4096', 'Amdadul Hoque Milon', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2431, 12, NULL, 48, 41, '4108', 'Md Sakib Al Hasan', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2432, 10, NULL, 2, 42, '924', 'Saiful Islam', 'Principal', NULL, NULL, 'principal@updatecollege.edu.bd', '1816593194', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2433, 10, NULL, 2, 42, '1559', 'Gayatri  Saha', 'Lecturer', NULL, NULL, 'gayatrisaha2013@gmail.com', '1783415100', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2434, 10, NULL, 2, 42, '1894', 'Taslima Akter', 'Lecturer', NULL, NULL, NULL, '1620415973', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2435, 10, NULL, 2, 42, '1142', 'Md.Arif Hasan', 'Assistant Professor', NULL, NULL, 'hasan.du10@gmail.com', '1911569686', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2436, 10, NULL, 4, 42, '3526', 'Md Nazmul Islam Sharker', 'Officer (Admin)', NULL, NULL, NULL, '1688823661', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2437, 10, NULL, 2, 42, '358', 'Alamin Howlader', 'Office Assistant', NULL, NULL, 'uzzalhawlader4@gmail.com', '1716951053', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2438, 10, NULL, 2, 42, '1146', 'Md.Mahmudullah Al Mamun', 'Senior Instructor', NULL, NULL, 'mamun_diu85@yahoo.com', '1911915425', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2439, 10, NULL, 2, 42, '1147', 'Pulak Sarker', 'Instructor', NULL, NULL, 'pulak123456@gmail.com', '1920578499', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2440, 10, NULL, 2, 42, '2605', 'Afsana Mimi', 'Executive (Accounts)', NULL, NULL, NULL, '1888713463', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2441, 10, NULL, 2, 42, '1008', 'Md. Sopon Mia', 'Library Assistant', NULL, NULL, 'dj.sopon@yahoo.com', '1765714386', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2442, 10, NULL, 6, 42, '1780', 'Chris D Rozario', 'Assistant Manager', NULL, NULL, 'chrisdrozario987@gmail.com', '1777181258', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2443, 10, NULL, 41, 42, '3389', 'MD Abdul Alim', 'Cleaner', NULL, NULL, NULL, '1892577247', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2444, 10, NULL, 53, 42, '1645', 'Md Sohel', 'Driver', NULL, NULL, 'mto@uniquegroupbd.com', '1816015181', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2445, 5, NULL, 17, 43, '3972', 'Dipu Sultan', 'Electrician', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2446, 5, NULL, 48, 43, '94', 'Md.Obaidullah', 'Security Guard', NULL, NULL, NULL, '1963520418', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2447, 5, NULL, 48, 43, '3539', 'Md Joni', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2448, 12, NULL, 48, 44, '3933', 'Enabi Mia', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2449, 12, NULL, 48, 44, '4009', 'Md Abdur Roshid', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2450, 12, NULL, 48, 44, '4008', 'Md Kabir Hossain', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2451, 5, NULL, 48, 45, '498', 'Md.Saidur Rahman', 'Security Guard', NULL, NULL, NULL, '1761176896', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2452, 5, NULL, 48, 45, '508', 'Md Abdul Halim', 'Security Guard', NULL, NULL, NULL, '1752227471', 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08'),
(2453, 5, NULL, 48, 45, '3477', 'Md Johorul Islam', 'Security Guard', NULL, NULL, NULL, NULL, 1, NULL, 1, NULL, NULL, NULL, NULL, '2023-03-15 05:09:08', '2023-03-15 05:09:08');

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(10) UNSIGNED NOT NULL,
  `event_name` varchar(300) NOT NULL,
  `event_category` int(11) DEFAULT NULL,
  `event_content` text DEFAULT NULL,
  `mobile` int(11) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `event_main_image` text DEFAULT NULL,
  `event_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `frontends`
--

CREATE TABLE `frontends` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `galleries`
--

CREATE TABLE `galleries` (
  `id` int(10) UNSIGNED NOT NULL,
  `gallery_name` varchar(250) DEFAULT NULL,
  `gallery_description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `gallery_image` text DEFAULT NULL,
  `gallery_oder` int(11) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issueregister_logs`
--

CREATE TABLE `issueregister_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `issue_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `support_status` varchar(255) DEFAULT NULL,
  `status_changed_by` varchar(255) DEFAULT NULL,
  `changed_date` datetime DEFAULT NULL,
  `issueregister_logs_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `mac_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issueregister_logs`
--

INSERT INTO `issueregister_logs` (`id`, `issue_id`, `title`, `support_status`, `status_changed_by`, `changed_date`, `issueregister_logs_oder`, `remarks`, `status`, `ip_address`, `mac_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, NULL, '1', '2023-03-04 11:15:49', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 05:15:49', '2023-03-04 05:15:49'),
(2, 5, NULL, NULL, '1', '2023-03-04 11:16:32', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 05:16:32', '2023-03-04 05:16:32'),
(3, 14, NULL, 'Pending', '1', '2023-03-05 05:03:45', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:03:45', '2023-03-04 23:03:45'),
(4, 14, NULL, 'Pending', '1', '2023-03-05 05:04:08', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:04:08', '2023-03-04 23:04:08'),
(5, 14, NULL, 'Pending', '1', '2023-03-05 05:06:55', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:06:55', '2023-03-04 23:06:55'),
(6, 14, NULL, 'Completed', '1', '2023-03-05 05:08:47', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:08:47', '2023-03-04 23:08:47'),
(7, 14, NULL, 'Pending', '1', '2023-03-05 05:10:45', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:10:45', '2023-03-04 23:10:45'),
(8, 14, NULL, 'Completed', '1', '2023-03-05 05:10:59', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:10:59', '2023-03-04 23:10:59'),
(9, 14, NULL, 'Pending', '1', '2023-03-05 05:13:29', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:13:29', '2023-03-04 23:13:29'),
(10, 14, NULL, 'Pending', '1', '2023-03-05 05:13:45', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:13:45', '2023-03-04 23:13:45'),
(11, 14, NULL, 'Completed', '1', '2023-03-05 05:14:03', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:14:03', '2023-03-04 23:14:03'),
(12, 14, NULL, 'Pending', '1', '2023-03-05 05:14:58', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:14:58', '2023-03-04 23:14:58'),
(13, 15, NULL, 'Completed', '1', '2023-03-05 05:15:13', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:15:13', '2023-03-04 23:15:13'),
(14, 14, NULL, 'Completed', '1', '2023-03-05 05:17:55', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:17:55', '2023-03-04 23:17:55'),
(15, 14, NULL, 'Pending', '1', '2023-03-05 05:18:59', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:18:59', '2023-03-04 23:18:59'),
(16, 15, NULL, 'Completed', '1', '2023-03-05 05:19:06', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:19:06', '2023-03-04 23:19:06'),
(17, 14, NULL, 'Completed', '1', '2023-03-05 05:19:11', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:19:11', '2023-03-04 23:19:11'),
(18, 14, NULL, NULL, '1', '2023-03-05 05:20:28', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:20:28', '2023-03-04 23:20:28'),
(19, 14, NULL, 'Pending', '1', '2023-03-05 05:21:33', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:21:33', '2023-03-04 23:21:33'),
(20, 14, NULL, 'Completed', '1', '2023-03-05 05:21:51', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:21:51', '2023-03-04 23:21:51'),
(21, 14, NULL, 'Pending', '1', '2023-03-05 05:21:57', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:21:57', '2023-03-04 23:21:57'),
(22, 17, NULL, 'Completed', '1', '2023-03-05 05:22:05', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:22:05', '2023-03-04 23:22:05'),
(23, 14, NULL, 'Completed', '1', '2023-03-05 05:23:15', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:23:15', '2023-03-04 23:23:15'),
(24, 14, NULL, 'Pending', '1', '2023-03-05 05:23:37', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:23:37', '2023-03-04 23:23:37'),
(25, 14, NULL, 'Completed', '1', '2023-03-05 05:23:54', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:23:54', '2023-03-04 23:23:54'),
(26, 14, NULL, 'Pending', '1', '2023-03-05 05:24:37', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:24:37', '2023-03-04 23:24:37'),
(27, 14, NULL, 'Completed', '1', '2023-03-05 05:25:43', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:25:43', '2023-03-04 23:25:43'),
(28, 15, NULL, 'Pending', '1', '2023-03-05 05:25:48', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:25:48', '2023-03-04 23:25:48'),
(29, 15, NULL, 'Completed', '1', '2023-03-05 05:25:54', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:25:54', '2023-03-04 23:25:54'),
(30, 15, NULL, 'Pending', '1', '2023-03-05 05:25:58', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:25:58', '2023-03-04 23:25:58'),
(31, 14, NULL, 'Pending', '1', '2023-03-05 05:26:14', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:26:14', '2023-03-04 23:26:14'),
(32, 14, NULL, 'Completed', '1', '2023-03-05 05:59:08', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:59:08', '2023-03-04 23:59:08'),
(33, 14, NULL, 'Pending', '1', '2023-03-05 05:59:35', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-04 23:59:35', '2023-03-04 23:59:35'),
(34, 14, NULL, NULL, '1', '2023-03-05 06:13:59', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:13:59', '2023-03-05 00:13:59'),
(35, 14, NULL, NULL, '1', '2023-03-05 06:14:42', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:14:42', '2023-03-05 00:14:42'),
(36, 14, NULL, NULL, '1', '2023-03-05 06:17:44', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:17:44', '2023-03-05 00:17:44'),
(37, 14, NULL, NULL, '1', '2023-03-05 06:20:05', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:20:05', '2023-03-05 00:20:05'),
(38, 14, NULL, 'Pending', '1', '2023-03-05 06:21:49', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:21:49', '2023-03-05 00:21:49'),
(39, 14, NULL, 'Completed', '1', '2023-03-05 06:22:17', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:22:17', '2023-03-05 00:22:17'),
(40, 15, NULL, 'Completed', '1', '2023-03-05 06:22:27', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:22:27', '2023-03-05 00:22:27'),
(41, 14, NULL, NULL, '1', '2023-03-05 06:23:32', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:23:32', '2023-03-05 00:23:32'),
(42, 14, NULL, NULL, '1', '2023-03-05 06:25:25', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:25:25', '2023-03-05 00:25:25'),
(43, 14, NULL, NULL, '1', '2023-03-05 06:25:32', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:25:32', '2023-03-05 00:25:32'),
(44, 14, NULL, NULL, '1', '2023-03-05 06:26:38', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:26:38', '2023-03-05 00:26:38'),
(45, 15, NULL, NULL, '1', '2023-03-05 06:26:44', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:26:44', '2023-03-05 00:26:44'),
(46, 14, NULL, NULL, '1', '2023-03-05 06:33:32', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:33:32', '2023-03-05 00:33:32'),
(47, 14, NULL, NULL, '1', '2023-03-05 06:34:53', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:34:53', '2023-03-05 00:34:53'),
(48, 14, NULL, NULL, '1', '2023-03-05 06:37:51', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:37:51', '2023-03-05 00:37:51'),
(49, 14, NULL, NULL, '1', '2023-03-05 06:50:35', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:50:35', '2023-03-05 00:50:35'),
(50, 14, NULL, NULL, '1', '2023-03-05 06:50:43', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:50:43', '2023-03-05 00:50:43'),
(51, 14, NULL, NULL, '1', '2023-03-05 06:50:57', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:50:57', '2023-03-05 00:50:57'),
(52, 14, NULL, 'Completed', '1', '2023-03-05 06:51:02', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:51:02', '2023-03-05 00:51:02'),
(53, 14, NULL, NULL, '1', '2023-03-05 06:51:36', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:51:36', '2023-03-05 00:51:36'),
(54, 15, NULL, NULL, '1', '2023-03-05 06:54:30', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:54:30', '2023-03-05 00:54:30'),
(55, 15, NULL, NULL, '1', '2023-03-05 06:55:07', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:55:07', '2023-03-05 00:55:07'),
(56, 14, NULL, NULL, '1', '2023-03-05 06:56:42', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 00:56:42', '2023-03-05 00:56:42'),
(57, 14, NULL, NULL, '1', '2023-03-05 07:54:23', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 01:54:23', '2023-03-05 01:54:23'),
(58, 14, NULL, 'Completed', '1', '2023-03-05 07:54:28', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 01:54:28', '2023-03-05 01:54:28'),
(59, 14, NULL, 'Completed', '1', '2023-03-05 07:54:33', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 01:54:33', '2023-03-05 01:54:33'),
(60, 14, NULL, NULL, '1', '2023-03-05 08:04:07', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 02:04:07', '2023-03-05 02:04:07'),
(61, 14, NULL, 'Completed', '1', '2023-03-05 08:04:16', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 02:04:16', '2023-03-05 02:04:16'),
(62, 15, NULL, 'Pending', '1', '2023-03-05 08:04:23', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 02:04:23', '2023-03-05 02:04:23'),
(63, 14, NULL, 'Pending', '1', '2023-03-06 04:41:30', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-03-05 22:41:31', '2023-03-05 22:41:31');

-- --------------------------------------------------------

--
-- Table structure for table `issue_logs`
--

CREATE TABLE `issue_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `issue_id` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `issue_date` varchar(255) DEFAULT NULL,
  `raised_by` varchar(255) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `issue_come_from` varchar(255) DEFAULT NULL,
  `support_id` int(11) NOT NULL,
  `issue_type_id` int(11) NOT NULL,
  `solved_process_id` int(11) NOT NULL,
  `issue_status` varchar(255) DEFAULT NULL,
  `status_changed_by` varchar(255) DEFAULT NULL,
  `changed_date` varchar(255) DEFAULT NULL,
  `issue_register_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `mac_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issue_registers`
--

CREATE TABLE `issue_registers` (
  `id` int(10) UNSIGNED NOT NULL,
  `task_id` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `issue_date` datetime DEFAULT NULL,
  `raised_by` int(11) DEFAULT NULL,
  `assigned_to` varchar(255) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `issue_come_from` int(11) DEFAULT NULL,
  `support_id` int(11) DEFAULT NULL,
  `assign_task_status` int(11) DEFAULT NULL,
  `issue_type_id` text DEFAULT NULL,
  `task_details` longtext DEFAULT NULL,
  `solved_process_id` longtext DEFAULT NULL,
  `issue_status` varchar(255) DEFAULT NULL,
  `status_changed_by` varchar(255) DEFAULT NULL,
  `task_completed_date` datetime DEFAULT NULL,
  `changed_date` datetime DEFAULT NULL,
  `issue_register_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` longtext DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `mac_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `issue_registers`
--

INSERT INTO `issue_registers` (`id`, `task_id`, `category_id`, `title`, `issue_date`, `raised_by`, `assigned_to`, `employee_id`, `unit_id`, `company_id`, `department_id`, `location_id`, `issue_come_from`, `support_id`, `assign_task_status`, `issue_type_id`, `task_details`, `solved_process_id`, `issue_status`, `status_changed_by`, `task_completed_date`, `changed_date`, `issue_register_oder`, `remarks`, `status`, `ip_address`, `mac_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(34, '#23-07-04-001', 1, NULL, '2023-07-04 00:00:00', 2, '2', 1712, NULL, NULL, NULL, NULL, 1712, 1, 1, 'Emergency', 'Test Task', 'By Phone', 'Pending', '1', NULL, '2023-07-04 05:08:12', 1, 'Test Task', 1, NULL, NULL, 1, NULL, NULL, '2023-07-04 05:08:12', '2023-07-04 05:08:12'),
(35, '#23-07-04-035', 1, NULL, '2023-07-04 00:00:00', 2, '2', 1024, NULL, NULL, NULL, NULL, 1024, 2, 1, 'Regular', 'test', 'By Email', 'Ongoing', '1', NULL, '2023-07-04 05:44:57', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-07-04 05:44:57', '2023-07-04 05:44:57'),
(36, '#23-07-06-036', 6, NULL, '2023-07-06 00:00:00', 7, '7', 1672, NULL, NULL, NULL, NULL, 1672, 2, 7, 'Regular', 'Outlook mail setup for smart phone.', 'Physical', 'Completed', '7', '2023-07-06 00:00:00', '2023-07-06 10:01:47', 1, NULL, 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:01:47', '2023-07-06 10:01:47'),
(37, '#23-07-06-037', 6, NULL, '2023-07-06 00:00:00', 7, '7', 1672, NULL, NULL, NULL, NULL, 1672, 2, 7, 'Regular', 'Outlook mail setup for smart phone.', 'Physical', 'Completed', '7', '2023-07-06 00:00:00', '2023-07-06 10:01:48', 1, NULL, 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:01:48', '2023-07-06 10:01:48'),
(38, '#23-07-06-038', 6, NULL, '2023-07-06 00:00:00', 7, '7', 1709, NULL, NULL, NULL, NULL, 1709, 2, 7, 'Regular', 'Printing problem from HR printer.', 'Physical', 'Completed', '7', '2023-07-06 00:00:00', '2023-07-06 10:05:41', 1, 'Solved', 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:05:41', '2023-07-06 10:05:41'),
(39, '#23-07-06-039', 6, NULL, '2023-07-06 00:00:00', 7, '7', 1838, NULL, NULL, NULL, NULL, 1838, 2, 7, 'Emergency', 'DESKTOP PC checked, repaired & delivered to BRMC project.', 'Physical', 'Completed', '7', '2023-07-06 00:00:00', '2023-07-06 10:12:40', 1, 'This PC using for weight scale & handover to Mr. Mannan.', 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:12:40', '2023-07-06 10:12:40'),
(40, '#23-07-13-040', 4, NULL, '2023-07-13 00:00:00', 2, '2', 1712, NULL, NULL, NULL, NULL, 1712, 1, 1, 'Regular', 'sdsd', 'By Email', 'Pending', '1', NULL, '2023-07-13 09:27:36', 1, 'sdsd', 1, NULL, NULL, 1, NULL, NULL, '2023-07-13 09:27:36', '2023-07-13 09:27:36'),
(41, '#23-07-18-041', 4, NULL, '2023-07-18 00:00:00', 2, '2', 1712, NULL, NULL, NULL, NULL, 1712, 1, 1, 'Emergency', NULL, 'Physical', 'Ongoing', '1', NULL, '2023-07-18 09:46:06', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-07-18 09:46:06', '2023-07-18 09:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `issue_types`
--

CREATE TABLE `issue_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `issue_type` varchar(255) DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `issue_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` int(10) UNSIGNED NOT NULL,
  `location_name` varchar(300) NOT NULL,
  `address` text DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `location_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `location_name`, `address`, `unit_id`, `company_id`, `location_oder`, `remarks`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 'The Westin Dhaka', 'Address: Main Gulshan Avenue, Plot-01 Rd 45, Dhaka 1212\r\nPhone: 02222-291988', 4, 2, 1, NULL, 1, 1, NULL, NULL, '2023-01-17 02:46:38', '2023-01-17 02:46:38'),
(4, 'Ashulia (UVTC)', 'Ashulia (UVTC)', 7, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:25:12', '2023-03-15 03:25:12'),
(5, 'Baridhara Diplomats Tower', 'Baridhara Diplomats Tower', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:26:06', '2023-03-15 03:26:06'),
(6, 'Borak Bizz Centre', 'Borak Bizz Centre', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:26:47', '2023-03-15 03:26:47'),
(7, 'Borak Mehnur (Project)', 'Borak Mehnur (Project)', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:27:19', '2023-03-15 03:27:19'),
(8, 'Borak Minarva', 'Borak Minarva', 5, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:28:22', '2023-03-15 03:28:22'),
(9, 'Borak Polytechnic Institute', 'Borak Polytechnic Institute', 11, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:28:41', '2023-03-15 03:28:41'),
(10, 'Borak Travels', 'Borak Travels', 16, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:29:11', '2023-03-15 03:29:11'),
(11, 'Borak Zahir Tower', 'Borak Zahir Tower', 5, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:30:13', '2023-03-15 03:30:13'),
(12, 'Concord Tarulata', 'Concord Tarulata', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:30:57', '2023-03-15 03:30:57'),
(13, 'Crescent Commercial Centre', 'Crescent Commercial Centre', 5, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:31:33', '2023-03-15 03:31:33'),
(14, 'CSBF Health Center', 'CSBF Health Center', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:31:58', '2023-03-15 03:31:58'),
(15, 'Daily Amader Shomoy', 'Daily Amader Shomoy', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:32:22', '2023-03-15 03:32:22'),
(16, 'DCC Sheraton Project', 'DCC Sheraton Project', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:35:14', '2023-03-15 03:35:14'),
(17, 'Gulshan Clinic', 'Gulshan Clinic', 3, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:35:34', '2023-03-15 03:35:34'),
(18, 'HANSA by UHRL', 'HANSA by UHRL', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:35:53', '2023-03-15 03:35:53'),
(19, 'Head Office', 'Head Office', 1, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:36:17', '2023-03-15 03:36:17'),
(20, 'Joar Shahara (Land)', 'Joar Shahara (Land)', 4, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:36:38', '2023-03-15 03:36:38'),
(21, 'Kamarkhola', 'Kamarkhola', 1, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:36:49', '2023-03-15 03:36:49'),
(22, 'Kinori', 'Kinori', 3, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:37:00', '2023-03-15 03:37:00'),
(23, 'Konabari', 'Konabari', 10, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:37:18', '2023-03-15 03:37:18'),
(24, 'Kuakata', 'Kuakata', 1, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:37:41', '2023-03-15 03:37:41'),
(25, 'Lab Quest Diagnostic Ltd.', 'Lab Quest Diagnostic Ltd.', 14, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:37:54', '2023-03-15 03:37:54'),
(26, 'Park Valley', 'Park Valley', 10, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:38:15', '2023-03-15 03:38:15'),
(27, 'Patira', 'Patira', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:38:54', '2023-03-15 03:38:54'),
(28, 'Popular Meducal College & Hospital', 'Popular Meducal College & Hospital', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:39:20', '2023-03-15 03:39:20'),
(29, 'Power Plant (Shahajadpur)', 'Power Plant (Shahajadpur)', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:39:41', '2023-03-15 03:39:41'),
(30, 'Purnima House', 'Purnima House', 14, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:40:17', '2023-03-15 03:40:17'),
(31, 'SEZL (Site Office)', 'SEZL (Site Office)', 9, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:40:37', '2023-03-15 03:40:37'),
(32, 'South Park', 'South Park', 4, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:41:07', '2023-03-15 03:41:07'),
(33, 'The Westin Dhaka', 'The Westin Dhaka', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:41:21', '2023-03-15 03:41:21'),
(34, 'UHRL Sky Lounge', 'UHRL Sky Lounge', 4, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:41:49', '2023-03-15 03:41:49'),
(35, 'Unique Acropolis', 'Unique Acropolis', 14, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:42:29', '2023-03-15 03:42:29'),
(36, 'Unique Ceramics', 'Unique Ceramics', 14, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:43:10', '2023-03-15 03:43:10'),
(37, 'Unique Eastern (Shahajadpur)', 'Unique Eastern (Shahajadpur)', 6, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:43:41', '2023-03-15 03:43:41'),
(38, 'Unique Eastern (Uttara)', 'Unique Eastern (Uttara)', 6, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:44:15', '2023-03-15 03:44:15'),
(39, 'Unique Heights', 'Unique Heights', 17, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:44:51', '2023-03-15 03:44:51'),
(40, 'Unique Meghnaghat Power Ltd.', 'Unique Meghnaghat Power Ltd.', 1, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:45:08', '2023-03-15 03:45:08'),
(41, 'Unique Trade Center', 'Unique Trade Center', 12, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:45:58', '2023-03-15 03:45:58'),
(42, 'UPDATE College', 'UPDATE College', 10, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:46:21', '2023-03-15 03:46:21'),
(43, 'Uttara Project', 'Uttara Project', 8, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:46:53', '2023-03-15 03:46:53'),
(44, 'UVTC', 'UVTC', 7, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:47:08', '2023-03-15 03:47:08'),
(45, 'Valuka (Land)', 'Valuka (Land)', 5, NULL, 1, NULL, 1, 2, NULL, NULL, '2023-03-15 03:47:39', '2023-03-15 03:47:39');

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `menu_parent` int(11) NOT NULL DEFAULT 0,
  `menu_name` varchar(150) NOT NULL,
  `menu_slug` varchar(100) NOT NULL,
  `menu_type` varchar(100) DEFAULT NULL,
  `menu_location` varchar(100) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `menu_icon` varchar(250) DEFAULT NULL,
  `menu_url` varchar(250) DEFAULT NULL,
  `menu_oder` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `menu_parent`, `menu_name`, `menu_slug`, `menu_type`, `menu_location`, `remarks`, `menu_icon`, `menu_url`, `menu_oder`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(3, 0, 'Menu Builder', 'menu-builder', 'backend', 'Header', NULL, 'fa-plus', NULL, 19, 1, 1, NULL, NULL, '2023-01-14 21:53:30', '2023-01-14 21:53:30'),
(4, 3, 'Add Menu', 'add-menu', 'backend', 'Header', NULL, 'fa-arrow-right', 'menus.create', 15, 1, 1, NULL, NULL, '2023-01-14 22:16:36', '2023-01-14 22:16:36'),
(5, 3, 'Menu List', 'menu-list', 'backend', 'Header', NULL, 'fa-arrow-right', 'menus.index', 20, 1, 1, NULL, NULL, '2023-01-14 22:16:54', '2023-01-14 22:16:54'),
(6, 0, 'Permission Manage', 'permission-manage', 'backend', 'Header', NULL, 'fa-cog', NULL, 4, 1, 1, NULL, NULL, '2023-01-14 22:31:12', '2023-01-14 22:31:12'),
(7, 6, 'Add Permission', 'add-permission', 'backend', 'Header', NULL, 'fa-arrow-right', 'permissions.create', 6, 1, 1, NULL, NULL, '2023-01-14 22:32:00', '2023-01-14 22:32:00'),
(8, 6, 'Permission List', 'permission-list', 'backend', 'Header', NULL, 'fa-arrow-right', 'permissions.index', 5, 1, 1, NULL, NULL, '2023-01-14 22:32:37', '2023-01-14 22:32:37'),
(9, 0, 'Role Manage', 'role-manage', 'backend', 'Header', NULL, 'fa-lock', NULL, 2, 1, 1, NULL, NULL, '2023-01-14 22:34:50', '2023-01-14 22:34:50'),
(10, 9, 'Add Role', 'add-role', 'backend', 'Header', NULL, 'fa-arrow-right', 'roles.create', 23, 1, 1, NULL, NULL, '2023-01-14 22:45:07', '2023-01-14 22:45:07'),
(11, 9, 'Role List', 'role-list', 'backend', 'Header', NULL, 'fa-arrow-right', 'roles.index', 3, 1, 1, NULL, NULL, '2023-01-14 22:45:36', '2023-01-14 22:47:18'),
(12, 0, 'Settings', 'settings', 'backend', 'Header', NULL, 'fa-lock', 'settings', 1, 1, 1, NULL, NULL, '2023-01-14 22:48:23', '2023-01-14 22:48:23'),
(14, 0, 'Unit Manage', 'unit-manage', 'backend', 'Header', NULL, 'fa-list', 'units.index', 16, 1, 1, NULL, NULL, '2023-01-14 23:22:25', '2023-01-14 23:22:25'),
(15, 0, 'Company Manage', 'company-manage', 'backend', 'Header', NULL, 'fa-list', 'company.index', 24, 1, 1, NULL, NULL, '2023-01-15 01:13:46', '2023-01-15 01:13:46'),
(16, 0, 'Department Manage', 'department-manage', 'backend', 'Header', NULL, 'fa-list', 'departments.index', 21, 1, 1, NULL, NULL, '2023-01-15 04:07:08', '2023-01-15 04:07:25'),
(17, 0, 'Location Manage', 'location-manage', 'backend', 'Header', NULL, 'fa-cog', 'locations.index', 25, 1, 1, NULL, NULL, '2023-01-15 22:45:48', '2023-01-15 22:45:48'),
(18, 0, 'Project Manage', 'project-manage', 'backend', 'Header', NULL, 'fa-list', NULL, 17, 1, 1, NULL, NULL, '2023-01-16 21:53:05', '2023-03-06 03:19:24'),
(19, 0, 'Support Register', 'support-register', 'backend', 'Header', NULL, 'fa-plus', 'supports.index', 22, 1, 1, NULL, NULL, '2023-01-17 21:21:20', '2023-03-11 04:51:10'),
(20, 0, 'Employee Manage', 'employee-manage', 'backend', 'Header', NULL, 'fa-info', 'employees.index', 26, 1, 1, NULL, NULL, '2023-01-17 21:45:26', '2023-01-17 21:45:26'),
(21, 0, 'Dashboard', 'dashboard', 'backend', 'Header', NULL, 'fa-home', 'home', 0, 1, 1, NULL, NULL, '2023-01-17 21:54:23', '2023-01-17 21:54:23'),
(22, 0, 'Manage Support Type', 'manage-support-type', 'backend', 'Header', NULL, 'fa-copy', NULL, 27, 1, 1, NULL, NULL, '2023-02-28 23:47:16', '2023-02-28 23:47:16'),
(23, 22, 'Add Support Type', 'add-support-type', 'backend', 'Header', NULL, 'fa-arrow-right', 'support_type.create', 29, 1, 1, NULL, NULL, '2023-02-28 23:50:33', '2023-02-28 23:50:33'),
(24, 22, 'Support Type List', 'support-type-list', 'backend', 'Header', NULL, 'fa-arrow-right', 'support_type.index', 18, 1, 1, NULL, NULL, '2023-03-01 01:58:01', '2023-03-01 01:58:01'),
(25, 0, 'Category Manage', 'category-manage', 'backend', 'Header', NULL, 'fa-list', NULL, 28, 1, 1, NULL, NULL, '2023-03-01 02:26:36', '2023-03-01 02:26:36'),
(26, 25, 'Add Category', 'add-category', 'backend', 'Header', NULL, 'fa-arrow-right', 'categories.create', 30, 1, 1, NULL, NULL, '2023-03-01 02:27:13', '2023-03-01 02:27:13'),
(27, 25, 'Category List', 'category-list', 'backend', 'Header', NULL, 'fa-list', 'categories.index', 14, 1, 1, NULL, NULL, '2023-03-01 02:27:40', '2023-03-01 02:27:40'),
(28, 0, 'Users Manage', 'users-manage', 'backend', 'Header', NULL, 'fa-users', NULL, 13, 1, 1, NULL, NULL, '2023-03-06 00:47:16', '2023-03-06 00:47:16'),
(29, 28, 'Add User', 'add-user', 'backend', 'Header', NULL, 'fa-arrow-right', 'users.create', 12, 1, 1, NULL, NULL, '2023-03-06 00:48:44', '2023-03-06 00:48:44'),
(30, 28, 'User List', 'user-list', 'backend', 'Header', NULL, 'fa-arrow-right', 'users.index', 11, 1, 1, NULL, NULL, '2023-03-06 00:49:02', '2023-03-06 00:49:02'),
(31, 18, 'Add Project', 'add-project', 'backend', 'Header', NULL, 'fa-plus', 'projects.create', 7, 1, 1, NULL, NULL, '2023-03-06 03:24:54', '2023-03-06 03:24:54'),
(32, 18, 'Project List', 'project-list', 'backend', 'Header', NULL, 'fa-list', 'projects.index', 8, 1, 1, NULL, NULL, '2023-03-06 03:25:29', '2023-03-06 03:25:29'),
(33, 18, 'IT Project', 'it-project', 'backend', 'Header', NULL, 'fa-plus', 'projects-it-create', 9, 1, 1, NULL, NULL, '2023-03-06 03:26:55', '2023-03-06 03:26:55'),
(34, 18, 'Assign Project', 'assign-project', 'backend', 'Header', NULL, 'fa-cog', 'assign-project', 10, 1, 1, NULL, NULL, '2023-03-06 03:50:29', '2023-03-06 04:15:27');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_02_05_044607_create_permission_tables', 1),
(6, '2022_02_06_062951_create_menus_table', 1),
(7, '2022_02_26_053944_create_galleries_table', 1),
(8, '2022_02_26_054246_create_services_table', 1),
(9, '2022_02_26_054323_create_pages_table', 1),
(10, '2022_02_26_054357_create_posts_table', 1),
(11, '2022_02_26_054411_create_settings_table', 1),
(12, '2022_03_01_044037_create_categories_column_table', 1),
(13, '2022_03_01_070934_create_sliders_table', 1),
(14, '2022_03_09_042846_create_rooms_table', 1),
(15, '2022_03_12_044323_create_room_images_table', 1),
(16, '2022_03_12_070143_create_room_services_table', 1),
(17, '2022_10_17_051821_create_frontends_table', 1),
(18, '2022_10_19_050519_create_offers_table', 1),
(19, '2022_11_12_065523_create_events_table', 1),
(20, '2022_11_17_052635_create_contacts_table', 1),
(21, '2023_01_14_044427_create_units_table', 1),
(23, '2023_01_14_044638_create_companies_table', 1),
(27, '2023_01_14_044801_create_support_types_table', 1),
(28, '2023_01_14_044815_create_issue_types_table', 1),
(29, '2023_01_14_044833_create_solved_processes_table', 1),
(31, '2023_01_14_044908_create_issue_logs_table', 1),
(32, '2023_01_14_044930_create_requisition_statuses_table', 1),
(33, '2023_01_14_044944_create_purchases_table', 1),
(34, '2023_01_14_044624_create_departments_table', 2),
(35, '2023_01_14_044653_create_locations_table', 3),
(39, '2023_01_18_031644_create_supports_table', 5),
(43, '2023_03_04_075336_create_issueregister_logs_table', 7),
(45, '2023_01_14_044719_create_projects_table', 9),
(47, '2023_03_09_032410_create_assigntasks_table', 10),
(56, '2023_01_14_044734_create_employees_table', 11),
(57, '2023_01_14_044853_create_issue_registers_table', 11),
(58, '2023_03_06_051535_create_supportdetails_table', 11);

-- --------------------------------------------------------

--
-- Table structure for table `model_has_permissions`
--

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `model_has_roles`
--

CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(1, 'App\\Models\\User', 2),
(2, 'App\\Models\\User', 4),
(2, 'App\\Models\\User', 6),
(2, 'App\\Models\\User', 7),
(2, 'App\\Models\\User', 8),
(2, 'App\\Models\\User', 9),
(2, 'App\\Models\\User', 10);

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(10) UNSIGNED NOT NULL,
  `offer_title` varchar(300) NOT NULL,
  `offer_caption` varchar(250) NOT NULL,
  `offer_content` text DEFAULT NULL,
  `offer_image` text DEFAULT NULL,
  `offer_time` text DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `offer_oder` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_name` varchar(250) DEFAULT NULL,
  `page_slug` varchar(100) DEFAULT NULL,
  `page_description` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `page_link` text DEFAULT NULL,
  `page_image` text DEFAULT NULL,
  `page_oder` int(11) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `key` varchar(255) DEFAULT NULL,
  `table_name` varchar(255) DEFAULT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `key`, `table_name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'role-list', NULL, NULL, 'web', '2023-01-14 05:06:25', '2023-01-14 05:06:25'),
(2, 'role-create', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(3, 'role-edit', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(4, 'role-delete', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(5, 'product-list', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(6, 'product-create', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(7, 'product-edit', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(8, 'product-delete', NULL, NULL, 'web', '2023-01-14 05:06:26', '2023-01-14 05:06:26'),
(9, 'Settings', NULL, NULL, 'web', '2023-01-14 05:08:59', '2023-01-14 05:08:59'),
(10, 'menu-builder', NULL, 'menus', 'web', '2023-01-14 05:10:13', '2023-01-14 05:10:13'),
(12, 'permission-menu', NULL, 'permissions', 'web', '2023-01-14 05:12:29', '2023-01-14 05:12:29'),
(13, 'contact-list-view', NULL, NULL, 'web', '2023-01-14 05:15:43', '2023-01-14 05:15:43'),
(14, 'permission-create', NULL, 'permissions', 'web', '2023-01-14 21:59:14', '2023-01-14 21:59:14'),
(15, 'permission-edit', NULL, 'permissions', 'web', '2023-01-14 21:59:57', '2023-01-14 21:59:57'),
(16, 'permission-delete', NULL, 'permissions', 'web', '2023-01-14 22:00:11', '2023-01-14 22:00:11'),
(17, 'menu-create', NULL, 'menus', 'web', '2023-01-14 22:01:00', '2023-01-14 22:01:00'),
(18, 'menu-edit', NULL, 'menus', 'web', '2023-01-14 22:01:10', '2023-01-14 22:01:10'),
(19, 'menu-delete', NULL, 'menus', 'web', '2023-01-14 22:17:46', '2023-01-14 22:17:46'),
(20, 'role-menu', NULL, 'roles', 'web', '2023-01-14 22:36:48', '2023-01-14 22:36:48'),
(21, 'unit-manage', NULL, NULL, 'web', '2023-01-14 23:15:57', '2023-01-14 23:15:57'),
(22, 'unit.index', NULL, NULL, 'web', '2023-01-14 23:21:08', '2023-01-14 23:21:08'),
(23, 'unit-create', NULL, 'units', 'web', '2023-01-14 23:51:48', '2023-01-14 23:51:48'),
(24, 'unit-edit', NULL, 'units', 'web', '2023-01-14 23:52:00', '2023-01-14 23:52:00'),
(25, 'unit-delete', NULL, 'units', 'web', '2023-01-15 00:14:33', '2023-01-15 00:14:33'),
(26, 'company-manage', NULL, 'companies', 'web', '2023-01-15 01:16:58', '2023-01-15 01:16:58'),
(27, 'department-manage', NULL, 'departments', 'web', '2023-01-15 04:08:45', '2023-01-15 04:08:45'),
(28, 'location-index', NULL, 'locations', 'web', '2023-01-15 22:46:10', '2023-01-15 22:46:10'),
(29, 'location-create', NULL, 'locations', 'web', '2023-01-15 22:46:21', '2023-01-15 22:46:21'),
(30, 'location-edit', NULL, 'locations', 'web', '2023-01-15 22:46:37', '2023-01-15 22:46:37'),
(31, 'location-manage', NULL, 'locations', 'web', '2023-01-15 22:47:18', '2023-01-15 22:47:18'),
(32, 'project-manage', NULL, 'projects', 'web', '2023-01-16 21:55:24', '2023-01-16 21:55:24'),
(33, 'project-create', NULL, 'projects', 'web', '2023-01-16 21:59:04', '2023-01-16 21:59:04'),
(34, 'project-edit', NULL, 'projects', 'web', '2023-01-16 21:59:20', '2023-01-16 21:59:20'),
(35, 'project-delete', NULL, 'projects', 'web', '2023-01-16 21:59:32', '2023-01-16 21:59:32'),
(36, 'support-register', NULL, NULL, 'web', '2023-01-17 21:22:51', '2023-01-17 21:22:51'),
(37, 'employee-manage', NULL, 'employess', 'web', '2023-01-17 21:46:44', '2023-01-17 21:46:44'),
(38, 'dashboard', NULL, NULL, 'web', '2023-01-17 22:01:37', '2023-01-17 22:01:37'),
(40, 'support-type', NULL, 'supports', 'web', '2023-02-28 23:54:42', '2023-02-28 23:54:42'),
(41, 'category-manage', NULL, 'categories', 'web', '2023-03-01 02:44:22', '2023-03-01 02:44:22'),
(42, 'category-create', NULL, 'categories', 'web', '2023-03-01 02:48:19', '2023-03-01 02:48:19'),
(43, 'users-manage', NULL, 'users', 'web', '2023-03-06 00:47:49', '2023-03-06 00:47:49'),
(44, 'support-menu-list', NULL, 'support-menu-list\'', 'web', '2023-03-16 00:54:48', '2023-03-16 00:54:48'),
(45, 'support-menu-list-user', NULL, 'support-menu-list-user', 'web', '2023-03-16 01:43:53', '2023-03-16 01:43:53'),
(46, 'support-create', NULL, 'supports', 'web', '2023-03-16 04:16:30', '2023-03-16 04:16:30');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(10) UNSIGNED NOT NULL,
  `project_name` varchar(300) NOT NULL,
  `starting_date` varchar(300) NOT NULL,
  `ending_date` varchar(300) NOT NULL,
  `project_type` varchar(500) NOT NULL,
  `project_deadline` varchar(300) NOT NULL,
  `project_location` varchar(255) NOT NULL,
  `project_status` varchar(255) NOT NULL,
  `project_description` text DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `project_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `id` int(10) UNSIGNED NOT NULL,
  `requisition_title` varchar(255) DEFAULT NULL,
  `requisition_date` text DEFAULT NULL,
  `requisition_receive_date` text DEFAULT NULL,
  `requisition_raised_by` varchar(255) DEFAULT NULL,
  `unit_id` int(11) NOT NULL,
  `company_id` int(11) DEFAULT NULL,
  `pproject_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `requisition_status_id` int(11) DEFAULT NULL,
  `requisition_oder` int(11) NOT NULL DEFAULT 1,
  `status_date` varchar(250) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `requisition_statuses`
--

CREATE TABLE `requisition_statuses` (
  `id` int(10) UNSIGNED NOT NULL,
  `requisition_name` varchar(255) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'web', '2023-01-14 05:07:27', '2023-01-14 05:07:27'),
(2, 'it admin', 'web', '2023-03-15 22:50:05', '2023-03-15 22:50:05');

-- --------------------------------------------------------

--
-- Table structure for table `role_has_permissions`
--

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
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
(34, 1),
(35, 1),
(36, 1),
(36, 2),
(37, 1),
(38, 1),
(38, 2),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 2),
(45, 1),
(46, 1),
(46, 2);

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_name` varchar(300) NOT NULL,
  `room_type` varchar(250) NOT NULL,
  `room_discription` text DEFAULT NULL,
  `room_available` varchar(255) DEFAULT NULL,
  `room_guests` int(11) DEFAULT NULL,
  `amount` double(13,2) NOT NULL,
  `min_booking` int(11) DEFAULT NULL,
  `room_bed_size` varchar(255) DEFAULT NULL,
  `room_size_sft` varchar(255) DEFAULT NULL,
  `room_reviews` varchar(255) DEFAULT NULL,
  `room_offer` text DEFAULT NULL,
  `arrival_date` varchar(255) DEFAULT NULL,
  `departure_date` varchar(255) DEFAULT NULL,
  `adult` int(11) DEFAULT NULL,
  `children` int(11) DEFAULT NULL,
  `guest` int(11) DEFAULT NULL,
  `room_booking` text DEFAULT NULL,
  `room_main_image` text DEFAULT NULL,
  `room_oder` int(11) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_images`
--

CREATE TABLE `room_images` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_id` varchar(300) NOT NULL,
  `room_image` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `room_services`
--

CREATE TABLE `room_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `room_id` int(10) UNSIGNED NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `service_type` varchar(150) DEFAULT NULL,
  `service_discription` text DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `site_title` varchar(250) DEFAULT NULL,
  `site_description` text DEFAULT NULL,
  `admin_title` varchar(250) DEFAULT NULL,
  `admin_description` text DEFAULT NULL,
  `site_logo` varchar(255) DEFAULT NULL,
  `site_copyright_text` varchar(255) DEFAULT NULL,
  `admin_logo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `site_title`, `site_description`, `admin_title`, `admin_description`, `site_logo`, `site_copyright_text`, `admin_logo`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Ticketing System', 'Ticketing System', 'Ticketing System', 'Ticketing System', '1674015895.gif', 'Daily Working Status', '1674015895.gif', 1, 1, NULL, NULL, '2023-01-17 22:24:55', '2023-04-03 03:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(10) UNSIGNED NOT NULL,
  `slider_name` varchar(300) NOT NULL,
  `slider_caption` varchar(250) NOT NULL,
  `slider_content` text DEFAULT NULL,
  `slider_image` text DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `slider_oder` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `solved_processes`
--

CREATE TABLE `solved_processes` (
  `id` int(10) UNSIGNED NOT NULL,
  `issue_type` varchar(255) DEFAULT NULL,
  `issue_description` text DEFAULT NULL,
  `issue_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supportdetails`
--

CREATE TABLE `supportdetails` (
  `id` int(10) UNSIGNED NOT NULL,
  `support_id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `assigned_id` int(11) DEFAULT NULL,
  `issue_type_id` text DEFAULT NULL,
  `support_type_id` int(11) DEFAULT NULL,
  `solved_process_id` int(11) DEFAULT NULL,
  `support_status` varchar(255) DEFAULT NULL,
  `status_changed_by` varchar(255) DEFAULT NULL,
  `changed_date` datetime DEFAULT NULL,
  `issueregister_logs_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `mac_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supportdetails`
--

INSERT INTO `supportdetails` (`id`, `support_id`, `category_id`, `employee_id`, `assigned_id`, `issue_type_id`, `support_type_id`, `solved_process_id`, `support_status`, `status_changed_by`, `changed_date`, `issueregister_logs_oder`, `remarks`, `status`, `ip_address`, `mac_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1280, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 03:50:47', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 21:50:47', '2023-03-15 21:50:47'),
(2, 2, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 03:52:24', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 21:52:24', '2023-03-15 21:52:24'),
(3, 3, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:02:00', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:02:00', '2023-03-15 22:02:00'),
(4, 4, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:02:43', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:02:43', '2023-03-15 22:02:43'),
(5, 5, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:02:55', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:02:55', '2023-03-15 22:02:55'),
(6, 6, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:03:49', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:03:49', '2023-03-15 22:03:49'),
(7, 7, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:05:30', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:05:30', '2023-03-15 22:05:30'),
(8, 8, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:06:49', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:06:49', '2023-03-15 22:06:49'),
(9, 9, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:08:11', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:08:11', '2023-03-15 22:08:11'),
(10, 10, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:09:57', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:09:57', '2023-03-15 22:09:57'),
(11, 11, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:10:43', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:10:43', '2023-03-15 22:10:43'),
(12, 12, 1, 1712, 1, 'Regular', 1, NULL, 'Ongoing', '2', '2023-03-16 04:13:05', 1, NULL, 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:13:05', '2023-03-15 22:13:05'),
(13, 12, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', NULL, '2023-03-16 04:20:46', 1, 'Task Is Completed', 1, NULL, NULL, 2, NULL, NULL, '2023-03-15 22:20:46', '2023-03-15 22:20:46'),
(14, 13, 1, 1712, 1, 'Regular', 2, NULL, 'Ongoing', '7', '2023-03-16 10:22:30', 1, 'dfdfdfdf', 1, NULL, NULL, 7, NULL, NULL, '2023-03-16 04:22:30', '2023-03-16 04:22:30'),
(15, 14, 4, 1714, 1, 'Regular', 2, NULL, 'Ongoing', '7', '2023-03-16 10:25:59', 1, 'gfgfgfgfgfgfg', 1, NULL, NULL, 7, NULL, NULL, '2023-03-16 04:25:59', '2023-03-16 04:25:59'),
(16, 15, 3, 2395, 7, 'Regular', 3, NULL, 'Ongoing', '7', '2023-03-16 10:29:38', 1, 'dsdsdsdsd', 1, NULL, NULL, 7, NULL, NULL, '2023-03-16 04:29:38', '2023-03-16 04:29:38'),
(17, 16, 2, 1715, 7, 'Regular', 2, NULL, 'Ongoing', '7', '2023-03-16 10:35:17', 1, 'dfdfd', 1, NULL, NULL, 7, NULL, NULL, '2023-03-16 04:35:17', '2023-03-16 04:35:17'),
(18, 17, 1, 1712, 2, 'Emergency', 1, NULL, 'Ongoing', '1', '2023-04-03 05:34:53', 1, 'g', 1, NULL, NULL, 1, NULL, NULL, '2023-04-02 23:34:53', '2023-04-02 23:34:53'),
(19, 18, 3, 1712, 2, 'Regular', 1, NULL, 'Ongoing', '8', '2023-04-03 09:08:56', 1, 'fgfg', 1, NULL, NULL, 8, NULL, NULL, '2023-04-03 03:08:56', '2023-04-03 03:08:56'),
(20, 19, 1, 1712, 7, 'Regular', 1, NULL, 'Ongoing', '1', '2023-04-04 05:50:48', 1, 'dfdf', 1, NULL, NULL, 1, NULL, NULL, '2023-04-03 23:50:48', '2023-04-03 23:50:48'),
(21, 20, 3, 1712, 2, 'Regular', 1, NULL, 'Pending', '1', '2023-04-05 07:04:10', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-05 01:04:10', '2023-04-05 01:04:10'),
(22, 21, 1, 1712, 2, 'Regular', 2, NULL, 'Pending', '1', '2023-04-08 08:50:30', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-08 02:50:30', '2023-04-08 02:50:30'),
(23, 22, 1, 1712, 2, 'Regular', 1, NULL, 'Pending', '1', '2023-04-08 09:18:30', 1, 'Test email', 1, NULL, NULL, 1, NULL, NULL, '2023-04-08 03:18:30', '2023-04-08 03:18:30'),
(24, 23, 3, 1712, 2, 'Regular', 1, NULL, 'Ongoing', '1', '2023-04-08 09:29:36', 1, 'cvc', 1, NULL, NULL, 1, NULL, NULL, '2023-04-08 03:29:36', '2023-04-08 03:29:36'),
(25, 24, 3, 1712, 2, 'Regular', 1, NULL, 'Ongoing', '1', '2023-04-08 09:31:37', 1, 'cvc', 1, NULL, NULL, 1, NULL, NULL, '2023-04-08 03:31:37', '2023-04-08 03:31:37'),
(26, 25, 3, 1712, 2, 'Regular', 1, NULL, 'Ongoing', '1', '2023-04-08 09:34:02', 1, 'cvc', 1, NULL, NULL, 1, NULL, NULL, '2023-04-08 03:34:02', '2023-04-08 03:34:02'),
(27, 26, 3, 1712, 2, 'Regular', 1, NULL, 'Ongoing', '1', '2023-04-08 09:34:48', 1, 'cvc', 1, NULL, NULL, 1, NULL, NULL, '2023-04-08 03:34:48', '2023-04-08 03:34:48'),
(28, 27, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', '1', '2023-04-09 07:39:51', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 01:39:51', '2023-04-09 01:39:51'),
(29, 28, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', '1', '2023-04-09 07:42:23', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 01:42:23', '2023-04-09 01:42:23'),
(30, 29, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', '1', '2023-04-09 07:46:10', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 01:46:10', '2023-04-09 01:46:10'),
(31, 30, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', '1', '2023-04-09 07:47:09', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 01:47:09', '2023-04-09 01:47:09'),
(32, 31, 1, 1712, 2, 'Regular', 1, NULL, 'Pending', '1', '2023-04-09 08:17:44', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 02:17:44', '2023-04-09 02:17:44'),
(33, 32, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', '1', '2023-04-09 08:18:05', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 02:18:05', '2023-04-09 02:18:05'),
(34, 33, 1, 1712, 2, 'Regular', 1, NULL, 'Completed', '1', '2023-04-09 09:01:35', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-04-09 03:01:35', '2023-04-09 03:01:35'),
(35, 34, 1, 1712, 2, 'Emergency', 1, NULL, 'Pending', '1', '2023-07-04 05:08:12', 1, 'Test Task', 1, NULL, NULL, 1, NULL, NULL, '2023-07-04 05:08:12', '2023-07-04 05:08:12'),
(36, 35, 1, 1024, 2, 'Regular', 2, NULL, 'Ongoing', '1', '2023-07-04 05:44:57', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-07-04 05:44:57', '2023-07-04 05:44:57'),
(37, 36, 6, 1672, 7, 'Regular', 2, NULL, 'Completed', '7', '2023-07-06 10:01:47', 1, NULL, 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:01:47', '2023-07-06 10:01:47'),
(38, 37, 6, 1672, 7, 'Regular', 2, NULL, 'Completed', '7', '2023-07-06 10:01:48', 1, NULL, 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:01:48', '2023-07-06 10:01:48'),
(39, 38, 6, 1709, 7, 'Regular', 2, NULL, 'Completed', '7', '2023-07-06 10:05:41', 1, 'Solved', 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:05:41', '2023-07-06 10:05:41'),
(40, 39, 6, 1838, 7, 'Emergency', 2, NULL, 'Completed', '7', '2023-07-06 10:12:40', 1, 'This PC using for weight scale & handover to Mr. Mannan.', 1, NULL, NULL, 7, NULL, NULL, '2023-07-06 10:12:40', '2023-07-06 10:12:40'),
(41, 40, 4, 1712, 2, 'Regular', 1, NULL, 'Pending', '1', '2023-07-13 09:27:36', 1, 'sdsd', 1, NULL, NULL, 1, NULL, NULL, '2023-07-13 09:27:36', '2023-07-13 09:27:36'),
(42, 41, 4, 1712, 2, 'Emergency', 1, NULL, 'Ongoing', '1', '2023-07-18 09:46:06', 1, NULL, 1, NULL, NULL, 1, NULL, NULL, '2023-07-18 09:46:06', '2023-07-18 09:46:06');

-- --------------------------------------------------------

--
-- Table structure for table `supports`
--

CREATE TABLE `supports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `support_types`
--

CREATE TABLE `support_types` (
  `id` int(10) UNSIGNED NOT NULL,
  `support_type` varchar(255) DEFAULT NULL,
  `support_description` text DEFAULT NULL,
  `support_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `ip_address` int(11) DEFAULT NULL,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `support_types`
--

INSERT INTO `support_types` (`id`, `support_type`, `support_description`, `support_oder`, `remarks`, `status`, `ip_address`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'By Phone', 'By Phone', 1, 'By Phone', 1, NULL, 1, NULL, NULL, '2023-03-01 01:07:09', '2023-03-01 01:07:09'),
(2, 'Physical', 'Physical', 1, 'Physical', 1, NULL, 1, NULL, NULL, '2023-03-01 01:51:19', '2023-03-01 01:51:19'),
(3, 'By Email', 'By Email', 1, NULL, 1, NULL, 1, NULL, NULL, '2023-03-01 02:05:28', '2023-03-01 02:05:28'),
(4, 'Remotely', 'Remotely', 1, 'Remotely', 1, NULL, 1, NULL, NULL, '2023-04-09 22:18:01', '2023-04-09 22:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `units`
--

CREATE TABLE `units` (
  `id` int(10) UNSIGNED NOT NULL,
  `unit_name` varchar(300) NOT NULL,
  `unit_code` varchar(255) DEFAULT NULL,
  `unit_oder` int(11) NOT NULL DEFAULT 1,
  `remarks` varchar(250) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `created_by` int(10) UNSIGNED NOT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `units`
--

INSERT INTO `units` (`id`, `unit_name`, `unit_code`, `unit_oder`, `remarks`, `status`, `created_by`, `updated_by`, `deleted_at`, `created_at`, `updated_at`) VALUES
(1, 'Unique Grouo', 'UG', 1, NULL, 1, 1, NULL, '2023-01-15 05:59:41', '2023-01-14 23:59:41', '2023-01-17 02:34:51'),
(3, 'Gulshan Clinic', 'GCL', 1, 'Hospitaly Managemant', 1, 1, NULL, '2023-01-15 06:03:40', '2023-01-15 00:03:40', '2023-01-15 00:58:59'),
(4, 'Unique Hotel & Resorts  Limited', 'UHRL', 1, 'Unique Hotel & Resorts  Limited', 1, 1, NULL, '2023-01-15 06:06:24', '2023-01-15 00:06:24', '2023-01-15 00:06:24'),
(5, 'Borak Real Estate Limited', 'BREL', 1, 'Borak Real Estate Limited', 1, 1, NULL, '2023-01-15 06:16:21', '2023-01-15 00:16:21', '2023-01-15 00:16:21'),
(6, 'Unique Eastern (Pvt.) Ltd', 'UEPL', 1, 'Unique Eastern (Pvt.) Ltd', 1, 1, NULL, '2023-01-15 06:17:22', '2023-01-15 00:17:22', '2023-01-15 00:17:22'),
(7, 'Unique Vocational Training Centre Ltd', 'UVTC', 1, 'Unique Vocational Training Centre Ltd', 1, 1, NULL, '2023-01-15 06:18:22', '2023-01-15 00:18:22', '2023-01-15 00:18:22'),
(8, 'Tribeni International Ltd. (TIL)', 'TIL', 1, 'Tribeni International Ltd. (TIL)', 1, 1, NULL, '2023-01-15 06:19:05', '2023-01-15 00:19:05', '2023-01-15 00:19:05'),
(9, 'Sonargaon Economic Zone Limited', 'SEZL', 1, 'Sonargaon Economic Zone Limited', 1, 1, NULL, '2023-01-15 06:19:55', '2023-01-15 00:19:55', '2023-01-15 00:19:55'),
(10, 'UPDATE College', 'updc', 1, 'UPDATE College', 1, 1, NULL, '2023-01-15 06:20:44', '2023-01-15 00:20:44', '2023-01-15 00:20:44'),
(11, 'Borak Polytechnic Institute', 'BPI', 1, 'Borak Polytechnic Institute (BPI)', 1, 1, NULL, '2023-01-15 06:21:30', '2023-01-15 00:21:30', '2023-01-15 00:21:30'),
(12, 'HANSA MANAGEMENT LTD', 'hml', 1, 'HANSA MANAGEMENT LTD', 1, 1, NULL, '2023-01-15 06:22:23', '2023-01-15 00:22:23', '2023-01-15 00:22:23'),
(13, 'Unique Share Management Ltd.', 'USML', 1, 'Unique Share Management Ltd. (USML)', 1, 1, NULL, '2023-01-15 06:23:06', '2023-01-15 00:23:06', '2023-01-15 00:23:06'),
(14, 'Unique Ceramic Industries Ltd', 'UCIL', 1, 'Unique Ceramic Industries Ltd', 1, 1, NULL, '2023-01-15 06:24:34', '2023-01-15 00:24:34', '2023-01-15 00:24:34'),
(15, 'Borak Ready Mix Concrete', 'BRMC', 1, 'Borak Ready Mix Concrete', 1, 1, NULL, '2023-01-15 06:26:01', '2023-01-15 00:26:01', '2023-01-15 00:26:01'),
(16, 'Borak Travels (Pvt.) Limited', 'BTL', 1, 'Borak Travels (Pvt.) Limited', 1, 1, NULL, '2023-01-15 06:27:01', '2023-01-15 00:27:01', '2023-01-15 00:27:01'),
(17, 'UNIQUE TOURS AND TRAVELS LTD.', 'UTTL', 1, 'UNIQUE TOURS AND TRAVELS LTD.', 1, 1, NULL, '2023-01-15 06:27:44', '2023-01-15 00:27:44', '2023-01-15 00:27:44'),
(18, 'Amader Somoi', 'Amader Somoi', 1, 'Amader Somoi', 1, 1, NULL, '2023-01-15 06:32:05', '2023-01-15 00:32:05', '2023-01-15 00:32:05'),
(22, 'Arial Dairy and Agro Industries Ltd.', 'Arial Dairy and Agro Industries Ltd.', 1, 'Arial Dairy and Agro Industries Ltd.', 1, 2, NULL, '2023-03-15 08:20:51', '2023-03-15 02:20:51', '2023-03-15 02:20:51');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `is_superuser` tinyint(1) NOT NULL DEFAULT 0,
  `role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) DEFAULT NULL,
  `user_type` enum('normal_user','super_user','admin') NOT NULL DEFAULT 'normal_user',
  `email` varchar(191) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `cell_phone` varchar(15) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `unit_id` int(11) DEFAULT NULL,
  `company_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `avatar` varchar(191) DEFAULT 'users/default.png',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=>Active, 0=>Inactive, 99=>Deleted',
  `email_verified_at` datetime DEFAULT NULL,
  `password` varchar(191) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `settings` text DEFAULT NULL,
  `user_image` varchar(255) DEFAULT NULL,
  `created_by` int(10) UNSIGNED DEFAULT NULL,
  `updated_by` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `is_superuser`, `role_id`, `name`, `user_type`, `email`, `user_name`, `cell_phone`, `employee_id`, `unit_id`, `company_id`, `department_id`, `location_id`, `avatar`, `status`, `email_verified_at`, `password`, `remember_token`, `settings`, `user_image`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 0, NULL, 'Admin User', 'admin', 'admin@gmail.com', 'admin', NULL, NULL, NULL, NULL, NULL, NULL, 'users/default.png', 1, NULL, '$2y$10$xusbuBDIfoA2Bkazbe03EOINU7m6wZndRlSvD9ekJVQLGQJjFmNpa', NULL, NULL, '1674016188.png', NULL, NULL, '2023-01-14 05:07:27', '2023-03-15 23:44:39', NULL),
(2, 0, NULL, 'Imran Rahaman', 'normal_user', 'imran@gmail.com', 'addmin@gmail.com', NULL, NULL, 18, 4, 1, 2, 'users/default.png', 1, NULL, '$2y$10$e2II6a/iN60S1.muJZ7ysOCDddtMbXC4wuHvQSLMFNDeHGhPYbytm', NULL, NULL, '1678685981.jpg', NULL, NULL, '2023-03-06 03:08:23', '2023-03-12 23:39:41', NULL),
(4, 0, NULL, 'Kowsiq Ahmed', 'admin', 'kowsiq@uniquegroupbd.com', 'Kowsiq150', NULL, NULL, 1, 0, 1, 7, 'users/default.png', 1, NULL, '$2y$10$bAqHI04DWURVqaiaPH4jwO2jbq6MiE8/HMwtP3RWbJyM3ehsd9Zte', NULL, NULL, '1678963811.jpg', NULL, NULL, '2023-03-15 23:21:52', '2023-03-16 04:50:11', NULL),
(6, 0, NULL, 'Nizam Uddin', 'admin', 'nizam@uniquegroupbd.com', 'Nizam1200', NULL, NULL, 1, 0, 1, 7, 'users/default.png', 1, NULL, '$2y$10$hzAqwc13LYLXAGnLXxMsE.bfVTVDBOf8VYQsspGMMVBsgjzeCUMr2', NULL, NULL, NULL, NULL, NULL, '2023-03-15 23:48:51', '2023-03-15 23:53:16', NULL),
(7, 0, NULL, 'Abu Bakar Siddik', 'normal_user', 'siddik@uniquegroupbd.com', 'Siddik789', NULL, NULL, 1, 0, 26, 7, 'users/default.png', 1, NULL, '$2y$10$MYQa4JDRBlXNIQtYTmfPS.T3FbE8nGFOq8w6j/xDC5ygDVqy7q0jK', NULL, NULL, '1678953959.jpg', NULL, NULL, '2023-03-16 01:59:01', '2023-07-04 07:05:27', NULL),
(8, 0, NULL, 'imran', '', 'md.imran1200@gmail.com', 'Imran789', NULL, NULL, 1, 0, 26, 7, 'users/default.png', 1, NULL, '$2y$10$hdrjEoYBLIITLEzwJlJSjezktxyFE2ppsq4I0FyITQsJG5LUVDFha', NULL, NULL, NULL, NULL, NULL, '2023-04-03 02:18:46', '2023-04-03 02:18:46', NULL),
(9, 0, NULL, 'Nazmul Hossain Khan', 'normal_user', 'nazmul@uniquegroupbd.com', 'Nazmul', NULL, NULL, 5, 0, 26, 7, 'users/default.png', 1, NULL, '$2y$10$/geezl2bRaVAHcc.vsjUjOdyy7lA3mnpYMpAJB9iCIkJAac3v/Qp.', NULL, NULL, NULL, NULL, NULL, '2023-07-04 07:00:30', '2023-07-04 07:00:30', NULL),
(10, 0, NULL, 'Mehnaj', 'normal_user', 'mehnaz@uniquegroupbd.com', 'Mehnaj789', NULL, NULL, 4, 0, 26, 7, 'users/default.png', 1, NULL, '$2y$10$xzwG2xsUzjG3QhZY5X2WUONuwEm2dOXZk4CUqo4uxpoRrFaCbjuhW', NULL, NULL, NULL, NULL, NULL, '2023-07-06 10:59:58', '2023-07-06 11:02:17', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assigntasks`
--
ALTER TABLE `assigntasks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assigntasks_id_index` (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_id_index` (`id`),
  ADD KEY `categories_category_name_index` (`category_name`),
  ADD KEY `categories_category_slug_index` (`category_slug`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD KEY `companies_id_index` (`id`),
  ADD KEY `companies_company_name_index` (`company_name`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contacts_id_index` (`id`),
  ADD KEY `contacts_contact_name_index` (`contact_name`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_id_index` (`id`),
  ADD KEY `departments_department_name_index` (`department_name`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employees_id_index` (`id`),
  ADD KEY `employees_employee_id_index` (`employee_id`(768));

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `events_id_index` (`id`),
  ADD KEY `events_event_name_index` (`event_name`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `frontends`
--
ALTER TABLE `frontends`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `galleries`
--
ALTER TABLE `galleries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `galleries_id_index` (`id`);

--
-- Indexes for table `issueregister_logs`
--
ALTER TABLE `issueregister_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issueregister_logs_id_index` (`id`),
  ADD KEY `issueregister_logs_issue_id_index` (`issue_id`);

--
-- Indexes for table `issue_logs`
--
ALTER TABLE `issue_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_logs_id_index` (`id`),
  ADD KEY `issue_logs_issue_id_index` (`issue_id`),
  ADD KEY `issue_logs_unit_id_index` (`unit_id`),
  ADD KEY `issue_logs_support_id_index` (`support_id`),
  ADD KEY `issue_logs_issue_type_id_index` (`issue_type_id`),
  ADD KEY `issue_logs_solved_process_id_index` (`solved_process_id`);

--
-- Indexes for table `issue_registers`
--
ALTER TABLE `issue_registers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_registers_id_index` (`id`);

--
-- Indexes for table `issue_types`
--
ALTER TABLE `issue_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `issue_types_id_index` (`id`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locations_id_index` (`id`),
  ADD KEY `locations_location_name_index` (`location_name`);

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `menus_id_index` (`id`),
  ADD KEY `menus_menu_name_index` (`menu_name`),
  ADD KEY `menus_menu_slug_index` (`menu_slug`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `offers_id_index` (`id`),
  ADD KEY `offers_offer_title_index` (`offer_title`),
  ADD KEY `offers_offer_caption_index` (`offer_caption`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pages_id_index` (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `projects_id_index` (`id`),
  ADD KEY `projects_project_name_index` (`project_name`),
  ADD KEY `projects_starting_date_index` (`starting_date`),
  ADD KEY `projects_ending_date_index` (`ending_date`),
  ADD KEY `projects_project_type_index` (`project_type`),
  ADD KEY `projects_project_deadline_index` (`project_deadline`),
  ADD KEY `projects_project_location_index` (`project_location`),
  ADD KEY `projects_project_status_index` (`project_status`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `purchases_id_index` (`id`),
  ADD KEY `purchases_unit_id_index` (`unit_id`);

--
-- Indexes for table `requisition_statuses`
--
ALTER TABLE `requisition_statuses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requisition_statuses_id_index` (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`);

--
-- Indexes for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rooms_id_index` (`id`),
  ADD KEY `rooms_room_name_index` (`room_name`),
  ADD KEY `rooms_room_type_index` (`room_type`);

--
-- Indexes for table `room_images`
--
ALTER TABLE `room_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_images_id_index` (`id`),
  ADD KEY `room_images_room_id_index` (`room_id`);

--
-- Indexes for table `room_services`
--
ALTER TABLE `room_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `room_services_id_index` (`id`),
  ADD KEY `room_services_room_id_index` (`room_id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `settings_id_index` (`id`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sliders_id_index` (`id`),
  ADD KEY `sliders_slider_name_index` (`slider_name`),
  ADD KEY `sliders_slider_caption_index` (`slider_caption`);

--
-- Indexes for table `solved_processes`
--
ALTER TABLE `solved_processes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solved_processes_id_index` (`id`);

--
-- Indexes for table `supportdetails`
--
ALTER TABLE `supportdetails`
  ADD PRIMARY KEY (`id`),
  ADD KEY `supportdetails_id_index` (`id`),
  ADD KEY `supportdetails_support_id_index` (`support_id`);

--
-- Indexes for table `supports`
--
ALTER TABLE `supports`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `support_types`
--
ALTER TABLE `support_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `support_types_id_index` (`id`);

--
-- Indexes for table `units`
--
ALTER TABLE `units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `units_id_index` (`id`),
  ADD KEY `units_unit_name_index` (`unit_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_user_name_unique` (`user_name`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assigntasks`
--
ALTER TABLE `assigntasks`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2454;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `frontends`
--
ALTER TABLE `frontends`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `galleries`
--
ALTER TABLE `galleries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issueregister_logs`
--
ALTER TABLE `issueregister_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `issue_logs`
--
ALTER TABLE `issue_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issue_registers`
--
ALTER TABLE `issue_registers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `issue_types`
--
ALTER TABLE `issue_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `requisition_statuses`
--
ALTER TABLE `requisition_statuses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_images`
--
ALTER TABLE `room_images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `room_services`
--
ALTER TABLE `room_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `solved_processes`
--
ALTER TABLE `solved_processes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supportdetails`
--
ALTER TABLE `supportdetails`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `supports`
--
ALTER TABLE `supports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `support_types`
--
ALTER TABLE `support_types`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `units`
--
ALTER TABLE `units`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `model_has_permissions`
--
ALTER TABLE `model_has_permissions`
  ADD CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `model_has_roles`
--
ALTER TABLE `model_has_roles`
  ADD CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `role_has_permissions`
--
ALTER TABLE `role_has_permissions`
  ADD CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
