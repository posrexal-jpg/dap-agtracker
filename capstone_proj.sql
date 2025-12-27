-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 30, 2024 at 05:13 AM
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
-- Database: `capstone_proj`
--

-- --------------------------------------------------------

--
-- Table structure for table `agency`
--

CREATE TABLE `agency` (
  `id` bigint UNSIGNED NOT NULL,
  `agency-name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `date_of_sighting` date DEFAULT NULL,
  `time_of_sighting` time DEFAULT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(10,7) NOT NULL,
  `municipality` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number_of_cots` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `observer_category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `early_juvenile` int DEFAULT NULL,
  `juvenile` int DEFAULT NULL,
  `sub_adult` int DEFAULT NULL,
  `adult` int DEFAULT NULL,
  `late_adult` int DEFAULT NULL,
  `barangay` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`id`, `name`, `description`, `date_of_sighting`, `time_of_sighting`, `latitude`, `longitude`, `municipality`, `created_at`, `updated_at`, `photo`, `number_of_cots`, `activity_type`, `observer_category`, `early_juvenile`, `juvenile`, `sub_adult`, `adult`, `late_adult`, `barangay`) VALUES
(1, NULL, NULL, '2024-11-21', '16:41:00', '10.2324916', '125.0217548', 'liloan', '2024-11-28 00:37:30', '2024-11-28 00:37:30', NULL, '31', 'fishing', 'fisherfolks', 11, 7, NULL, 7, 6, ''),
(2, NULL, NULL, '2024-11-27', '16:43:00', '10.3155948', '125.0025247', 'padre burgos', '2024-11-28 00:39:46', '2024-11-28 00:39:46', NULL, '36', 'fishing', 'fisherfolks', 9, 12, NULL, 11, 4, ''),
(3, NULL, NULL, '2024-11-21', '16:47:00', '10.2047857', '125.0547208', 'sogod', '2024-11-28 00:43:22', '2024-11-28 00:43:22', NULL, '6', 'fishing', 'fisherfolks', 6, NULL, NULL, NULL, NULL, ''),
(4, NULL, NULL, '2024-11-22', '16:46:00', '10.2804644', '125.0361774', 'bontoc', '2024-11-28 00:43:42', '2024-11-28 00:43:42', NULL, '45', 'fishing', 'independent researcher', 11, 17, 12, 5, NULL, ''),
(5, NULL, NULL, '2024-11-23', '16:46:00', '10.2460058', '124.9956568', 'malitbog', '2024-11-28 00:44:01', '2024-11-28 00:44:01', NULL, '13', 'fishing', 'independent researcher', NULL, NULL, NULL, 13, NULL, ''),
(6, NULL, NULL, '2024-11-28', '17:37:00', '10.2077141', '125.0395203', 'san francisco', '2024-11-29 02:38:21', '2024-11-29 02:38:21', 'photos/6749999c74163.jpg', '24', 'research', 'barangay residents', 5, 6, 9, NULL, 4, ''),
(7, NULL, NULL, '2024-11-23', '15:38:00', '10.1689672', '125.0202942', 'limasawa', '2024-11-29 02:38:55', '2024-11-29 02:38:55', NULL, '69', 'fishing', 'barangay residents', NULL, NULL, NULL, 69, NULL, ''),
(8, NULL, NULL, '2024-11-22', '06:55:00', '10.2021965', '125.0491342', 'bontoc', '2024-11-29 02:54:53', '2024-11-29 02:54:53', NULL, '20', 'fishing', 'fisherfolks', 13, NULL, NULL, 7, NULL, 'poblacion'),
(9, NULL, NULL, '2024-11-29', '08:34:00', '10.2054615', '125.0065613', 'Panaon', '2024-11-29 08:35:17', '2024-11-29 08:35:17', 'photos/6749ed44987cc.jpg', '31', 'Research', 'Researcher', 8, 6, 4, 4, 9, 'Secret'),
(10, NULL, NULL, '2024-11-12', '06:42:00', '10.1703189', '125.0724792', 'Bontoc', '2024-11-29 08:42:32', '2024-11-29 08:42:32', NULL, '1', 'Fishing', 'Fisherfolks', NULL, NULL, 1, NULL, NULL, 'Jdhd'),
(11, NULL, NULL, '2024-11-21', '03:38:00', '10.1338206', '125.0422668', 'Bontoc', '2024-11-29 08:43:10', '2024-11-29 08:43:10', NULL, NULL, 'Fishing', 'Fisherfolks', NULL, NULL, NULL, NULL, NULL, 'Jdhd'),
(12, NULL, NULL, '2024-11-25', '00:43:00', '10.1149357', '125.0610638', 'Bontoc', '2024-11-29 08:43:55', '2024-11-29 08:43:55', NULL, '2', 'Fishing', 'Fisherfolks', NULL, 2, NULL, NULL, NULL, 'Djsjs'),
(13, NULL, NULL, '2024-11-12', '06:44:00', '10.1216536', '125.0628662', 'Bontoc', '2024-11-29 08:44:36', '2024-11-29 08:44:36', NULL, '2', 'Fishing', 'Fisherfolks', NULL, 2, NULL, NULL, NULL, 'Udjdie'),
(14, NULL, NULL, '2024-11-29', '09:51:00', '10.1405799', '125.0354004', 'Bontoc', '2024-11-29 08:51:34', '2024-11-29 08:51:34', NULL, '10', 'Fishing', 'Fisherfolks', NULL, 10, NULL, NULL, NULL, 'Jzjzhzh'),
(15, NULL, NULL, '2024-11-29', '00:52:00', '10.1175978', '125.0505066', 'Panaon', '2024-11-29 08:53:05', '2024-11-29 08:53:05', NULL, '9', 'Fishing', 'Fisherfolks', NULL, 9, NULL, NULL, NULL, 'Jsjsjs'),
(16, NULL, NULL, '2024-11-22', '03:55:00', '10.1730223', '125.0079346', 'Panaon', '2024-11-29 08:55:24', '2024-11-29 08:55:24', NULL, '1', 'Fishing', 'Fisherfolks', NULL, NULL, 1, NULL, NULL, 'Nbg');

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
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2019_08_19_000000_create_failed_jobs_table', 1),
(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(6, '2024_07_26_161637_create_locations_table', 1),
(7, '2024_07_26_164228_add_photo_to_locations_table', 1),
(8, '2024_08_27_040741_create_roles_table', 1),
(9, '2024_08_27_042142_create_agency_table', 1),
(10, '2024_08_28_165706_add_role_to_users_table', 1),
(11, '2024_10_28_174536_add_additional_fields_to_locations_table', 1),
(12, '2024_11_12_150859_alter_locations_table_allow_null_name', 1),
(13, '2024_11_14_153250_add_municipality_to_locations_table', 1),
(14, '2024_11_16_152532_add_date_and_time_of_sighting_to_locations', 1),
(15, '2024_11_20_171032_create_municipality_table', 1),
(16, '2024_11_26_100038_rename_size_of_cots', 1),
(17, '2024_11_28_052715_add_size_locations', 1),
(18, '2024_11_29_104852_add_baranggay_to_location', 2);

-- --------------------------------------------------------

--
-- Table structure for table `municipality`
--

CREATE TABLE `municipality` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint UNSIGNED NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `role_name`, `created_at`, `updated_at`) VALUES
(1, 'admin', '2024-11-28 00:32:10', '2024-11-28 00:32:10'),
(2, 'user', '2024-11-28 00:32:10', '2024-11-28 00:32:10');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `role_id` bigint UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `role_id`) VALUES
(1, 'Jay sabalo', 'yajzkie@gmail.com', '2024-11-28 00:33:08', '$2y$12$6dU4LlSA4Qj4m7HVEV/XD.Fcbzl7VvRfeUeqKjVBzsAdHqQqt2Wti', 'WgXhSA875d', NULL, NULL, 1),
(2, 'meryjie meking', 'meryjie@gmail.com', '2024-11-28 00:33:08', '$2y$12$Hz1QxjlsD4M/8v856Z8qIOhPRHH0n6vmUUzT6zml7qHLdSUo1UFI6', 'YU5PwEAs5i', NULL, NULL, 2),
(3, 'admin', 'administrator@gmail.com', '2024-11-28 00:33:58', '$2y$12$7GbKBlKPCwICAKI6I2CduekMRcV8uYvx9nPNqy3y1DNMMdOSKRfwC', 'S6qe3l6mIv', NULL, NULL, 1),
(4, 'user', 'user@gmail.com', '2024-11-28 00:33:59', '$2y$12$ACcFl6gAkZskPs93IEpPmuL7hWawWYdlgIkXivrHhlSzku9LuXHlG', 'bQyjrXnzlP', NULL, NULL, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agency`
--
ALTER TABLE `agency`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `municipality`
--
ALTER TABLE `municipality`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

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
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_name_unique` (`role_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agency`
--
ALTER TABLE `agency`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `municipality`
--
ALTER TABLE `municipality`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
