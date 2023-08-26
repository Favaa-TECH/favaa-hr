-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 12, 2023 at 03:06 AM
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
-- Database: `favaa_hr`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `check_in_latitude` decimal(10,8) DEFAULT NULL,
  `check_in_longitude` decimal(11,8) DEFAULT NULL,
  `check_in_time` time DEFAULT NULL,
  `check_in_date` date DEFAULT NULL,
  `check_out_latitude` decimal(10,8) DEFAULT NULL,
  `check_out_longitude` decimal(11,8) DEFAULT NULL,
  `check_out_time` time DEFAULT NULL,
  `check_out_date` date DEFAULT NULL,
  `work_hours` bigint DEFAULT NULL,
  `overtime` bigint DEFAULT NULL,
  `status` enum('Present','Late','Holiday','Leave','Absent') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_in` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo_out` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `employee_id`, `check_in_latitude`, `check_in_longitude`, `check_in_time`, `check_in_date`, `check_out_latitude`, `check_out_longitude`, `check_out_time`, `check_out_date`, `work_hours`, `overtime`, `status`, `photo_in`, `photo_out`, `created_at`, `updated_at`) VALUES
(9, 1, '-6.98252330', '109.13620000', '09:47:57', '2023-07-12', '-6.98250367', '109.13620328', '09:49:35', '2023-07-12', NULL, NULL, 'Present', '2_In_image_1689130077.jpg', '2_Out_image_1689130175.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` bigint UNSIGNED NOT NULL,
  `working_hours_id` bigint UNSIGNED DEFAULT NULL,
  `position_id` bigint UNSIGNED DEFAULT NULL,
  `outlet_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('Laki-laki','Perempuan') COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `working_hours_id`, `position_id`, `outlet_id`, `name`, `email`, `address`, `phone`, `gender`, `date_of_birth`, `photo`, `created_at`, `updated_at`) VALUES
(1, NULL, 1, 2, 'Dany Nur', 'dany@gmail.com', 'Jalan Kenangan', '089699968405', 'Laki-laki', '2002-12-24', '1_dany_nur.jpeg', '2023-06-28 10:13:07', '2023-06-28 10:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `holidays`
--

CREATE TABLE `holidays` (
  `id` bigint UNSIGNED NOT NULL,
  `holiday_date` date NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_04_19_040035_create_employees_table', 1),
(6, '2023_04_19_040319_create_outlets_table', 1),
(7, '2023_04_19_041131_create_attendance_table', 1),
(8, '2023_04_19_044815_create_position_table', 1),
(9, '2023_04_19_052255_add_outlet_id_column_to_employees_table', 1),
(10, '2023_04_19_053724_add_position_id_column_to_employees_table', 1),
(11, '2023_04_19_054210_add_employee_id_column_to_attendance_table', 1),
(12, '2023_04_19_095644_add_employee_id_column_to_users_table', 1),
(13, '2023_05_26_095255_create_working_hours_table', 1),
(14, '2023_05_26_095748_add_working_hours_id_column_to_employees_table', 1),
(15, '2023_06_06_051228_create_holidays_table', 1),
(16, '2023_06_26_203625_create_shifts_table', 1),
(17, '2023_06_26_212557_create_schedules_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `outlets`
--

CREATE TABLE `outlets` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_ot` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat_ot` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kontak_ot` bigint NOT NULL,
  `keterangan` int NOT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `outlets`
--

INSERT INTO `outlets` (`id`, `nama_ot`, `alamat_ot`, `kontak_ot`, `keterangan`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(1, 'Favaa Gudang', 'Jl. prof moh yamin no.31 dukuh mingkrik - slawi', 85549000024, 2, '-6.98251365', '109.13619976', '2023-06-28 10:05:11', '2023-06-28 10:05:11'),
(2, 'FAvaa Pusat', 'Jl. prof moh yamin no.31 dukuh mingkrik - slawi', 85549000024, 3, '-6.98251032', '109.13619976', '2023-06-28 10:05:11', '2023-06-28 10:05:11');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(3, 'App\\Models\\User', 2, 'token-name', 'c9ff3f453e3642ca88396074552ef5edc7245df1defafd883489dda5fc926b31', '[\"*\"]', NULL, NULL, '2023-07-04 02:43:42', '2023-07-04 02:43:42'),
(4, 'App\\Models\\User', 2, 'token-name', 'ff957555675fd824bedc46a710438eb0884024894612f404b6e4e56e81fc43c5', '[\"*\"]', NULL, NULL, '2023-07-04 02:43:43', '2023-07-04 02:43:43'),
(5, 'App\\Models\\User', 2, 'token-name', 'ce1cb1d487a4cf9e99167227462975aa2517a3970c1386542f67990a8cb97411', '[\"*\"]', '2023-07-06 07:34:00', NULL, '2023-07-05 19:54:36', '2023-07-06 07:34:00'),
(6, 'App\\Models\\User', 2, 'token-name', '66b4458b808358a9709c2ef161c01257d62969c9456dd9c47201176bb2e38c5e', '[\"*\"]', NULL, NULL, '2023-07-06 19:34:09', '2023-07-06 19:34:09'),
(7, 'App\\Models\\User', 2, 'token-name', 'fce92bed1f43c9de3efe47fe24a5f7793c51d504fa850dd4b431ae807321e7b7', '[\"*\"]', NULL, NULL, '2023-07-06 20:51:34', '2023-07-06 20:51:34'),
(8, 'App\\Models\\User', 2, 'token-name', '33917a3edf5093b55fbbb11374f1b66cda95bbd2227c6a1fa98845bb43078a8c', '[\"*\"]', NULL, NULL, '2023-07-06 21:49:59', '2023-07-06 21:49:59'),
(10, 'App\\Models\\User', 2, 'token-name', 'a70cb287935350e859fcf9ff66b6295e9b14cc55976c0597ca8fbeed27867a9a', '[\"*\"]', NULL, NULL, '2023-07-06 23:03:49', '2023-07-06 23:03:49'),
(11, 'App\\Models\\User', 2, 'token-name', '13403199824de243acf71893c88a25703c57d828a797419892452a42fc94fc9d', '[\"*\"]', NULL, NULL, '2023-07-06 23:07:56', '2023-07-06 23:07:56'),
(12, 'App\\Models\\User', 2, 'token-name', '1efb5546d3be21c589cac7da274f8ded17d4c7cbd75e2bb919e095938dedae7e', '[\"*\"]', NULL, NULL, '2023-07-06 23:08:27', '2023-07-06 23:08:27'),
(13, 'App\\Models\\User', 2, 'token-name', 'ee90f260fe1dd4775cf156d2854f2b9570ea4f2877aabf1b4ff766dc2da535b0', '[\"*\"]', NULL, NULL, '2023-07-06 23:08:37', '2023-07-06 23:08:37'),
(14, 'App\\Models\\User', 2, 'token-name', '624e131472e9a4363e116ca2e3a7a7e284e84dbada85e861ad77613245a4c206', '[\"*\"]', NULL, NULL, '2023-07-07 07:20:08', '2023-07-07 07:20:08'),
(15, 'App\\Models\\User', 2, 'token-name', 'f41bcf6334597e891c6ba21eae7dd0ea88f661868bd9aba6a00f91f0b347a04c', '[\"*\"]', NULL, NULL, '2023-07-07 07:21:00', '2023-07-07 07:21:00'),
(16, 'App\\Models\\User', 2, 'token-name', '8f6dad52af086d2960286f61f052393fc3eb860302fa4eb517f857b77422fe34', '[\"*\"]', NULL, NULL, '2023-07-07 07:21:22', '2023-07-07 07:21:22'),
(17, 'App\\Models\\User', 2, 'token-name', '4d319082fdee8dc0635975a49c35a624fc6c27005db872b3a4c10f000d002b40', '[\"*\"]', NULL, NULL, '2023-07-07 07:23:15', '2023-07-07 07:23:15'),
(18, 'App\\Models\\User', 2, 'token-name', 'd72761cae09ffcc8568522d071ce66f4298714751bf5ec406b8c957d89b18170', '[\"*\"]', NULL, NULL, '2023-07-07 07:24:44', '2023-07-07 07:24:44'),
(19, 'App\\Models\\User', 2, 'token-name', '2f6b3bc945fbdab957acfe3ab36e039c25623ea51f2bd0461dc369c489146426', '[\"*\"]', NULL, NULL, '2023-07-07 07:25:07', '2023-07-07 07:25:07'),
(20, 'App\\Models\\User', 2, 'token-name', 'bcb5f26abcc4ebd6e72f1d5759193ccb160b0f0db6d84ce88f27f3238513d2d6', '[\"*\"]', NULL, NULL, '2023-07-07 16:52:15', '2023-07-07 16:52:15'),
(21, 'App\\Models\\User', 2, 'token-name', '80510ec198eb8992f5259d1cb8c9610804dd3ce58f9a2cb5b7550127a015db11', '[\"*\"]', NULL, NULL, '2023-07-07 23:08:15', '2023-07-07 23:08:15'),
(22, 'App\\Models\\User', 2, 'token-name', '19acb490c266a8f092232f5f5133dcf6e2b5e8554575609f1ef6f9b9f2024055', '[\"*\"]', NULL, NULL, '2023-07-07 23:15:08', '2023-07-07 23:15:08'),
(23, 'App\\Models\\User', 2, 'token-name', '4757a38059bfd097d08437bd8d4bdd40874341a54325b59dcd0d30d786fdd0d4', '[\"*\"]', NULL, NULL, '2023-07-07 23:30:01', '2023-07-07 23:30:01'),
(24, 'App\\Models\\User', 2, 'token-name', '08ca0a6a4a1973d2e4d57ac09d6150996f67073573ce4c6eb5494256db11c4b7', '[\"*\"]', NULL, NULL, '2023-07-07 23:39:37', '2023-07-07 23:39:37'),
(25, 'App\\Models\\User', 2, 'token-name', '24cdcb3bd76fd025c8d52f6b4287ec28293aa091d3856c9de0364958eef0646b', '[\"*\"]', NULL, NULL, '2023-07-07 23:40:03', '2023-07-07 23:40:03'),
(26, 'App\\Models\\User', 2, 'token-name', 'b5ec3c3666db21f5243550ca753c5e5d0530657c7509b915897afc335f83a33d', '[\"*\"]', NULL, NULL, '2023-07-08 06:04:45', '2023-07-08 06:04:45'),
(28, 'App\\Models\\User', 2, 'token-name', 'a0778c2049d6345406a9a9d343bb69a0af4400c14f8d606328db8bb0a86eafc8', '[\"*\"]', NULL, NULL, '2023-07-09 01:43:55', '2023-07-09 01:43:55'),
(29, 'App\\Models\\User', 2, 'token-name', '3af2208bd716ef283e8a29bf4c3a789f278d874f675a56524e140910ab81abe8', '[\"*\"]', NULL, NULL, '2023-07-09 01:44:58', '2023-07-09 01:44:58'),
(30, 'App\\Models\\User', 2, 'token-name', '71dab93fb0807c855426c562c991c5d25c5ffd137784615d8807444bc67591ec', '[\"*\"]', NULL, NULL, '2023-07-09 01:48:25', '2023-07-09 01:48:25'),
(31, 'App\\Models\\User', 2, 'token-name', '86b1c4b1372ce099c70e0e3f7914f81b70bf554a03f3eaa273d31db68c499121', '[\"*\"]', NULL, NULL, '2023-07-09 02:11:31', '2023-07-09 02:11:31'),
(32, 'App\\Models\\User', 2, 'token-name', 'e0cd0f4f2d530d13f96ea030ad72986cd3240b01dcb8d9a437213873a47b8af0', '[\"*\"]', NULL, NULL, '2023-07-09 04:29:48', '2023-07-09 04:29:48'),
(33, 'App\\Models\\User', 2, 'token-name', '363dcf3e14837c99174eddece3be4744bb9a97d1368f4d5d583874b4cb216c3e', '[\"*\"]', NULL, NULL, '2023-07-09 04:32:58', '2023-07-09 04:32:58'),
(34, 'App\\Models\\User', 2, 'token-name', 'a28d58544fae44fc578cb8e75e9e9b1ca2245d7810d022fe9d92ffc7bbb7f2d6', '[\"*\"]', NULL, NULL, '2023-07-10 18:41:48', '2023-07-10 18:41:48'),
(35, 'App\\Models\\User', 2, 'token-name', '1e7b19bd0c4e9c4f7ac04675c65aa7d5e28b3b5baddde7cec0f1ab9fc597ddb5', '[\"*\"]', NULL, NULL, '2023-07-10 18:42:16', '2023-07-10 18:42:16'),
(36, 'App\\Models\\User', 2, 'token-name', '9e46d2e7732e518a7fd78ef17da9841821c75ce3004af284f8cd4740c41944b6', '[\"*\"]', NULL, NULL, '2023-07-10 19:30:40', '2023-07-10 19:30:40'),
(37, 'App\\Models\\User', 2, 'token-name', 'e9c561a4d5ea225104536f1b33ceabc894f8967b312496455d2e857fb9788aa7', '[\"*\"]', NULL, NULL, '2023-07-10 19:31:11', '2023-07-10 19:31:11'),
(38, 'App\\Models\\User', 2, 'token-name', 'b238eb96a7664fed1b1e6309a690f0efb8e8f0382f5749e30b90339521186d88', '[\"*\"]', NULL, NULL, '2023-07-10 19:33:15', '2023-07-10 19:33:15'),
(39, 'App\\Models\\User', 2, 'token-name', '4331145353bc95d6a950b35889e99759d1f0f5120bad9e05d4d441a913bbd6e5', '[\"*\"]', NULL, NULL, '2023-07-10 19:37:42', '2023-07-10 19:37:42'),
(40, 'App\\Models\\User', 2, 'token-name', '3254a5f89a88199076d5781af65a2fa9e2d6d06c8150bf4a40c5838af64dd70a', '[\"*\"]', NULL, NULL, '2023-07-10 19:38:05', '2023-07-10 19:38:05'),
(41, 'App\\Models\\User', 2, 'token-name', '61e77576ec33567a94f99567712726a8e38ca35354d438907b63ccc9980040f8', '[\"*\"]', NULL, NULL, '2023-07-10 19:57:04', '2023-07-10 19:57:04'),
(42, 'App\\Models\\User', 2, 'token-name', '4a045356aef7d68063ab68a1318d530b661f951c2588b7d33bfed615170718ec', '[\"*\"]', '2023-07-12 02:49:35', NULL, '2023-07-10 20:30:06', '2023-07-12 02:49:35'),
(43, 'App\\Models\\User', 2, 'token-name', 'e7d4090a8dd27be9c7fd1e0e7d26d88877bb62b72b2ae405337a2c16ff36194a', '[\"*\"]', '2023-07-11 23:29:40', NULL, '2023-07-10 23:52:49', '2023-07-11 23:29:40'),
(44, 'App\\Models\\User', 2, 'token-name', '84dbaec9a57b3edb1f754f9a98169413ed82cfb9cd8ba00fa78d06892edc0509', '[\"*\"]', '2023-07-11 12:59:06', NULL, '2023-07-11 01:56:36', '2023-07-11 12:59:06'),
(45, 'App\\Models\\User', 2, 'token-name', 'f03ce28163e0543d7a0299881f1fe371c53dfe0b4c174d92dd1a10aca0bcf745', '[\"*\"]', '2023-07-12 00:04:33', NULL, '2023-07-11 16:24:30', '2023-07-12 00:04:33'),
(46, 'App\\Models\\User', 2, 'token-name', 'fb05c163dd904eca87b8d16a2664b9c83704a6224373c84e5ee7f0f820f2542a', '[\"*\"]', '2023-07-12 02:47:57', NULL, '2023-07-11 16:36:14', '2023-07-12 02:47:57');

-- --------------------------------------------------------

--
-- Table structure for table `position`
--

CREATE TABLE `position` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `position`
--

INSERT INTO `position` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Programmer', 'Membuat Aplikasi', '2023-06-28 10:12:08', '2023-06-28 10:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `shift_type` enum('Fulltime','Parttime') COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `employee_id` bigint UNSIGNED DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('Administrator','HR Manager','Payroll Manager','Supervisor','Employee') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Employee',
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `employee_id`, `name`, `email`, `email_verified_at`, `password`, `role`, `photo`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Medikre', 'admin@admin.com', NULL, '$2y$10$3v0d4Jjpm/IFlmNYxDdKoOHoWCbeDRULC7sdwxxqY8ePERCShWBOa', 'Administrator', NULL, NULL, '2023-06-28 02:24:45', '2023-06-28 02:24:45'),
(2, 1, 'Dany Nur', 'dany@gmail.com', NULL, '$2y$10$qFum3kG7VcTGjyCdSsieEuK9hcn.xogrPLDJAxcl5uzRUtWLljmCe', 'Employee', 'C:\\Users\\mualf\\AppData\\Local\\Temp\\php5E91.tmp', NULL, '2023-06-28 10:13:08', '2023-06-28 10:13:08');

-- --------------------------------------------------------

--
-- Table structure for table `working_hours`
--

CREATE TABLE `working_hours` (
  `id` bigint UNSIGNED NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `employees_email_unique` (`email`),
  ADD KEY `employees_outlet_id_foreign` (`outlet_id`),
  ADD KEY `employees_position_id_foreign` (`position_id`),
  ADD KEY `employees_working_hours_id_foreign` (`working_hours_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `holidays`
--
ALTER TABLE `holidays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `outlets`
--
ALTER TABLE `outlets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `working_hours`
--
ALTER TABLE `working_hours`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `holidays`
--
ALTER TABLE `holidays`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `outlets`
--
ALTER TABLE `outlets`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `position`
--
ALTER TABLE `position`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `working_hours`
--
ALTER TABLE `working_hours`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_outlet_id_foreign` FOREIGN KEY (`outlet_id`) REFERENCES `outlets` (`id`),
  ADD CONSTRAINT `employees_position_id_foreign` FOREIGN KEY (`position_id`) REFERENCES `position` (`id`),
  ADD CONSTRAINT `employees_working_hours_id_foreign` FOREIGN KEY (`working_hours_id`) REFERENCES `working_hours` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_employee_id_foreign` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
