-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 21, 2018 at 02:38 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `engrafa`
--
CREATE DATABASE IF NOT EXISTS `engrafa` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `engrafa`;

-- --------------------------------------------------------

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `root` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `menus`
--

INSERT INTO `menus` (`id`, `root`, `name`, `url`, `icon`, `id_url`, `created_at`, `updated_at`) VALUES
(1, 0, 'Dashboard', '/', 'fa-dashboard', NULL, '2018-11-07 02:11:32', '2018-11-07 02:11:32'),
(2, 0, 'Index', '/index', 'fa-folder-open', NULL, '2018-11-07 02:11:32', '2018-11-07 02:11:32'),
(3, 0, 'Survey', '/survey', 'fa-files-o', 'mn_survey', '2018-11-07 02:11:32', '2018-11-07 02:11:32'),
(4, 0, 'Create New Survey', '#', 'fa-plus', 'mn_create_new_team', '2018-11-07 02:11:32', '2018-11-07 02:11:32'),
(5, 0, 'Calendar', '/calendar', 'fa-calendar', NULL, '2018-11-07 02:11:32', '2018-11-07 02:11:32'),
(6, 0, 'Setting', '/setting', 'fa-gear', NULL, '2018-11-07 02:11:32', '2018-11-07 02:11:32');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_11_07_071818_create_menus_table', 1),
(4, '2018_11_07_071854_create_roles_table', 1),
(5, '2018_11_07_071918_create_role_menus_table', 1),
(7, '2018_11_17_104509_add_iduser_to_menus', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('sunjayaaris@gmail.com', '$2y$10$PSCFSYRUvvmLkmSdyf.uN.9oRPMRzWG0tg9g7bJ1OyUguluRU0MiG', '2018-11-07 06:35:58');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `super_admin` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `super_admin`, `created_at`, `updated_at`) VALUES
('1-Super Admin', 'Super Admin', 1, '2018-11-07 02:11:23', '2018-11-07 02:11:23'),
('2-Admin', 'Admin', 0, '2018-11-07 02:11:23', '2018-11-07 02:11:23'),
('3-Creator', 'Creator', 0, '2018-11-07 02:11:23', '2018-11-07 02:11:23'),
('4-Editor', 'Editor', 0, '2018-11-07 02:11:23', '2018-11-07 02:11:23'),
('5-Contributor', 'Contributor', 0, '2018-11-07 02:11:23', '2018-11-07 02:11:23'),
('6-Viewer', 'Viewer', 0, '2018-11-07 02:11:23', '2018-11-07 02:11:23');

-- --------------------------------------------------------

--
-- Table structure for table `role_menus`
--

DROP TABLE IF EXISTS `role_menus`;
CREATE TABLE `role_menus` (
  `id` int(10) UNSIGNED NOT NULL,
  `role` int(11) NOT NULL,
  `menu` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_menus`
--

INSERT INTO `role_menus` (`id`, `role`, `menu`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL),
(2, 1, 2, NULL, NULL),
(3, 1, 3, NULL, NULL),
(4, 1, 4, NULL, NULL),
(5, 1, 5, NULL, NULL),
(6, 1, 6, NULL, NULL),
(7, 1, 10, NULL, NULL),
(8, 2, 6, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

DROP TABLE IF EXISTS `schedules`;
CREATE TABLE `schedules` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `location` text NOT NULL,
  `detail` text NOT NULL,
  `color` int(3) NOT NULL,
  `created_by` int(10) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
CREATE TABLE `surveys` (
  `id` int(10) NOT NULL,
  `name` varchar(255) NOT NULL,
  `expired` datetime NOT NULL,
  `created_by` int(10) NOT NULL COMMENT 'user yang membuat team',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `name`, `expired`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'SURVEY_1', '2018-11-17 22:39:00', 2, '2018-11-17 16:39:25', '2018-11-17 08:39:12'),
(2, 'SURVEY_2', '2018-11-28 00:51:00', 2, '2018-11-18 10:51:17', '2018-11-18 10:51:17');

-- --------------------------------------------------------

--
-- Table structure for table `survey_members`
--

DROP TABLE IF EXISTS `survey_members`;
CREATE TABLE `survey_members` (
  `id` int(10) NOT NULL,
  `user` int(10) NOT NULL COMMENT 'foreign key untuk id user pada table users',
  `survey` int(10) NOT NULL COMMENT 'foreign key untuk id team pada table teams',
  `role` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_members`
--

INSERT INTO `survey_members` (`id`, `user`, `survey`, `role`) VALUES
(1, 1, 1, '2-Responden'),
(2, 2, 1, '2-Responden'),
(3, 1, 1, '1-Surveyor'),
(4, 1, 2, '2-Responden'),
(5, 2, 2, '1-Surveyor');

-- --------------------------------------------------------

--
-- Table structure for table `survey_roles`
--

DROP TABLE IF EXISTS `survey_roles`;
CREATE TABLE `survey_roles` (
  `id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_by` int(10) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `survey_roles`
--

INSERT INTO `survey_roles` (`id`, `name`, `created_by`, `created_at`, `updated_at`) VALUES
('1-Surveyor', 'Surveyor', NULL, '2018-11-16 16:06:01', '0000-00-00 00:00:00'),
('2-Responden', 'Responden', NULL, '2018-11-16 16:06:18', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(10) NOT NULL,
  `survey` int(10) NOT NULL COMMENT 'id team yang menandakan kepemilikan task',
  `name` varchar(255) NOT NULL,
  `assign` int(10) NOT NULL COMMENT 'id user yang menandakan siapa yang harus mengerjakan task',
  `due_date` datetime DEFAULT NULL COMMENT 'jatuh tempo task',
  `detail` text NOT NULL,
  `color` varchar(10) NOT NULL COMMENT 'warna',
  `progress` int(3) NOT NULL COMMENT 'persentase progress yang sudah dikerjakan',
  `priority` varchar(50) NOT NULL COMMENT 'tingkat prioritas task (1-High, 2-Medium, 3-Low)',
  `document_support` text COMMENT 'url document yang diupload',
  `created_by` int(10) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `survey`, `name`, `assign`, `due_date`, `detail`, `color`, `progress`, `priority`, `document_support`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'TASK_1', 1, '2018-11-30 19:05:00', 'DETAIL1', 'CD5C5C', 20, '3-Low', NULL, 2, '2018-11-20 12:06:41', '2018-11-20 05:05:23'),
(2, 1, 'TASK_2', 2, '2018-11-29 19:09:00', 'DETAIL2', 'C71585', 50, '1-High', NULL, 2, '2018-11-20 12:29:23', '2018-11-20 05:09:15'),
(3, 1, 'TASK_3', 1, '2018-12-31 19:51:00', 'DETAIL 3', 'FF8C00', 100, '2-Medium', NULL, 2, '2018-11-20 13:46:52', '2018-11-20 05:51:33');

-- --------------------------------------------------------

--
-- Table structure for table `task_participant`
--

DROP TABLE IF EXISTS `task_participant`;
CREATE TABLE `task_participant` (
  `id` int(10) NOT NULL,
  `task` int(10) NOT NULL COMMENT 'id task',
  `team_member` int(10) NOT NULL COMMENT 'id team member yang berpartisipasi dalam task',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `task_participant`
--

INSERT INTO `task_participant` (`id`, `task`, `team_member`, `updated_at`, `created_at`) VALUES
(1, 1, 1, '2018-11-20 05:05:23', '2018-11-20 05:05:23'),
(2, 1, 2, '2018-11-20 05:05:23', '2018-11-20 05:05:23'),
(3, 2, 1, '2018-11-20 05:09:15', '2018-11-20 05:09:15'),
(4, 2, 2, '2018-11-20 05:09:15', '2018-11-20 05:09:15'),
(5, 3, 2, '2018-11-20 05:51:33', '2018-11-20 05:51:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `name`, `username`, `phone`, `role`, `email`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'aris', 'sunjaya', 'aris sunjaya', 'arissunjaya', '+6289639336906', '1-Super Admin', 'sunjayaaris@gmail.com', '$2y$10$.UgRbkxhYkf/9053Sczit.oxl/gVfoD7J.iYSeJjkSEqrmUmPQezC', 'tf8DrB5uhfuLlxiGU3cgJUYT4oXCX1amD5nvGHimJamZ4r8sU8BJxof0ln62', '2018-11-07 02:38:13', '2018-11-07 02:38:13'),
(2, 'Muhammad Fahmy', 'A.H', 'Muhammad Fahmy A.H', 'fahmyabdul', '+6282116665865', '1-Super Admin', 'firstfahmyabdul@gmail.com', '$2y$10$WOYaC9/zYottsvCSyg6VnO8QttmQjY23r3H4aiXOIdwhwkVzxdbSq', 'u6WBazi4hyA8ilWysiwjXc76QuBVmQzDw68ih30MiNQikGHZhKOOwoMMcRqa', '2018-11-17 08:14:42', '2018-11-17 08:14:42'),
(3, 'Amrullah', 'Baharun', 'Amrullah Baharun', 'ambahar', '123123', NULL, 'ambahar@gmail.com', '$2y$10$bz8YW9A6rHV79C8FE6u0pO4Z6pIxGvcmJ4iIrdmZMSn5siAhjJh26', NULL, '2018-11-20 09:29:50', '2018-11-20 09:29:50'),
(4, 'Sinari', 'Mawardi', 'Sinari Mawardi', 'simawar', '123123123', '4-Editor', 'simawar@gmail.com', '$2y$10$Ng60HTgRWx.Wi9suWgPYZu1lF8xyt2lc5rNN5XEtJDw2e3ATu7dIG', 'CLw3htZGH7JduO3FeUalfTcCQGPia9JZfaaJcd9Q1Yxmyq6wJhbX8OKECB0K', '2018-11-20 09:41:39', '2018-11-20 09:41:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `role_menus`
--
ALTER TABLE `role_menus`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_members`
--
ALTER TABLE `survey_members`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `survey_roles`
--
ALTER TABLE `survey_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task_participant`
--
ALTER TABLE `task_participant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menus`
--
ALTER TABLE `menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `role_menus`
--
ALTER TABLE `role_menus`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `survey_members`
--
ALTER TABLE `survey_members`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `task_participant`
--
ALTER TABLE `task_participant`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
