-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2023 at 05:58 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel_photogram`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logins`
--

CREATE TABLE `admin_logins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_logins`
--

INSERT INTO `admin_logins` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$ko.EUcULBMnNnOUkT78cwuviVyGurLEISpWa0GStUmUQVKsXIlazy', '2023-07-24 09:48:32', '2023-07-24 09:48:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(18, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(19, '2023_06_25_144801_create_signups_table', 1),
(20, '2023_07_09_113554_create_admin_logins_table', 1),
(21, '2023_07_18_172455_create_photos_table', 1),
(22, '2023_07_31_155127_create_profiles_table', 2),
(23, '2023_08_02_165039_2023_06_25_144801_create_signups_table', 3),
(24, '2023_08_02_170802_add_column_to_signups_table', 4),
(25, '2023_08_06_172408_create_user_feedbacks_table', 5);

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `photos`
--

CREATE TABLE `photos` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) UNSIGNED NOT NULL,
  `photo` blob NOT NULL,
  `caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `photos`
--

INSERT INTO `photos` (`id`, `userid`, `photo`, `caption`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 0x2f73746f726167652f696d616765732f6d617872657364656661756c742e6a7067, 'laravel founder', 0, '2023-07-24 12:16:28', '2023-07-24 12:16:28'),
(2, 10, 0x2f73746f726167652f696d616765732f6c61726176656c206d76632e706e67, 'test', 0, '2023-08-06 01:40:45', '2023-08-06 01:40:45'),
(3, 1, 0x2f73746f726167652f696d616765732f64656d6f2e6a7067, 'test', 0, '2023-08-08 11:46:16', '2023-08-08 11:46:16'),
(4, 1, 0x2f73746f726167652f696d616765732f746573742e6a7067, 'hi my name is Rehan', 0, '2023-08-09 10:07:25', '2023-08-09 10:07:25'),
(5, 1, 0x2f73746f726167652f696d616765732f726979617a2070686f746f2068616c662e6a7067, 'hI MY NAME IS rEHAN  2.0', 0, '2023-08-09 10:08:46', '2023-08-09 10:08:46'),
(6, 2, 0x2f73746f726167652f696d616765732f64656d6f6f6e652e6a7067, 'first', 0, '2023-08-09 10:38:53', '2023-08-09 10:38:53');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) UNSIGNED NOT NULL,
  `about` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_photo` blob NOT NULL,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `userid`, `about`, `gender`, `profile_photo`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'i am riyaz mohamed from madurai, i am full stack php developer and cyber security engineer, thank you.', '1', 0x2f73746f726167652f70726f66696c65696d616765732f746573742e6a7067, 0, '2023-08-02 12:01:24', '2023-08-06 04:54:36'),
(2, 10, 'this is google login account', '1', 0x2f73746f726167652f70726f66696c65696d616765732f726979617a2070686f746f2068616c662e6a7067, 0, '2023-08-06 01:43:05', '2023-08-06 04:51:21'),
(3, 2, 'test', '1', 0x2f73746f726167652f70726f66696c65696d616765732f746573746f6e652e706e67, 0, '2023-08-09 10:39:28', '2023-08-09 10:39:28');

-- --------------------------------------------------------

--
-- Table structure for table `signups`
--

CREATE TABLE `signups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mobile` bigint(20) DEFAULT NULL,
  `google_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_update_status` tinyint(4) NOT NULL DEFAULT 0,
  `active_status` tinyint(4) NOT NULL DEFAULT 0,
  `deleted` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `signups`
--

INSERT INTO `signups` (`id`, `username`, `email`, `password`, `mobile`, `google_id`, `profile_update_status`, `active_status`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 'riyaz', 'riyaz@gmail.com', '$2y$10$I1Kg8qJ4hFRnTK2SrfJyS.FE456Ip2scpfplQygrKhuDfPduBE.GS', 8012175552, '', 1, 0, 0, '2023-07-22 10:38:13', '2023-08-02 12:01:25'),
(2, 'mohamed', 'mohamed@gmail.com', '$2y$10$1SxmR7Zs9j7qIKM.JDfQPOj0kNFkiD1N0b/6G/waM1iYtwPUERvn2', 9976660033, '', 1, 0, 0, '2023-07-23 04:17:17', '2023-08-09 10:39:28'),
(10, 'riyaz mohamed', 'rm15324950@gmail.com', NULL, NULL, '110076416865879665060', 1, 0, 0, '2023-08-06 01:06:43', '2023-08-06 09:01:56'),
(11, 'test', 'test@gmail.com', '$2y$10$Fiz4ZVp2Lbxjjr3RFV8NYO.fR18RYDju7hY0sjnX7cIupYC0zVRke', 1234567899, NULL, 0, 0, 0, '2023-08-09 12:12:06', '2023-08-09 12:12:06');

-- --------------------------------------------------------

--
-- Table structure for table `user_feedbacks`
--

CREATE TABLE `user_feedbacks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userid` bigint(20) UNSIGNED NOT NULL,
  `feedback` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_feedbacks`
--

INSERT INTO `user_feedbacks` (`id`, `userid`, `feedback`, `deleted`, `created_at`, `updated_at`) VALUES
(1, 1, 'normal account for testing', 0, '2023-08-07 13:18:49', '2023-08-07 13:18:49'),
(2, 1, 'test', 0, '2023-08-07 13:20:54', '2023-08-07 13:20:54'),
(3, 10, 'google account for testing', 0, '2023-08-07 13:21:25', '2023-08-07 13:21:25'),
(4, 1, 'feedback count', 0, '2023-08-08 12:30:16', '2023-08-08 12:30:16'),
(5, 1, 'alert test', 0, '2023-08-08 12:31:46', '2023-08-08 12:31:46'),
(6, 1, 'test', 0, '2023-08-08 12:32:13', '2023-08-08 12:32:13'),
(7, 1, 'test test', 0, '2023-08-08 12:32:47', '2023-08-08 12:32:47'),
(8, 1, 'riyaz', 0, '2023-08-08 12:33:17', '2023-08-08 12:33:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logins`
--
ALTER TABLE `admin_logins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_logins_username_unique` (`username`),
  ADD UNIQUE KEY `admin_logins_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `photos_userid_foreign` (`userid`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `signups`
--
ALTER TABLE `signups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `signups_username_unique` (`username`),
  ADD UNIQUE KEY `signups_email_unique` (`email`),
  ADD UNIQUE KEY `signups_mobile_unique` (`mobile`);

--
-- Indexes for table `user_feedbacks`
--
ALTER TABLE `user_feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logins`
--
ALTER TABLE `admin_logins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `signups`
--
ALTER TABLE `signups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_feedbacks`
--
ALTER TABLE `user_feedbacks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_userid_foreign` FOREIGN KEY (`userid`) REFERENCES `signups` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
