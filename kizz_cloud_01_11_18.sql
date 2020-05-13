-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2018 at 12:23 PM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kizz_cloud`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` int(11) DEFAULT '1' COMMENT '0: Inactive, 1:Active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Artist', NULL, 1, '2018-10-14 18:30:00', '2018-10-14 18:30:00'),
(2, 'Album', NULL, 1, '2018-10-14 18:30:00', '2018-10-14 18:30:00'),
(3, 'Playlist', NULL, 1, '2018-10-14 18:30:00', '2018-10-14 18:30:00'),
(4, 'Track', NULL, 1, '2018-10-14 18:30:00', '2018-10-14 18:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `contents`
--

CREATE TABLE `contents` (
  `id` int(10) UNSIGNED NOT NULL,
  `cat_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1' COMMENT '0: Inactive, 1:Active',
  `is_delete` tinyint(4) DEFAULT NULL COMMENT '0: Soft, 1: Hard',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contents`
--

INSERT INTO `contents` (`id`, `cat_id`, `name`, `subtitle`, `description`, `image`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(2, 2, 'Hairana', 'Madona', 'New Album created', '1539934181.jpg', 1, NULL, '2018-10-15 07:01:36', '2018-10-22 00:12:38'),
(4, 2, 'Saathi', 'Nick Jones', 'Latest Album version 1', '1539607242.jpg', 1, NULL, '2018-10-15 07:10:42', '2018-10-21 23:52:35'),
(5, 2, 'Album2', 'Madona', 'latest album', '1539934452.jpg', 1, NULL, '2018-10-19 02:01:59', '2018-10-22 02:07:02'),
(6, 1, 'Shaina', '', 'Sufi singer', '1539936286.jpg', 1, NULL, '2018-10-19 02:34:46', '2018-10-19 02:34:46'),
(7, 2, 'Shairana shairana', '', 'Latest hit', '1539936717.jpg', 1, NULL, '2018-10-19 02:41:57', '2018-10-19 02:41:57'),
(8, 3, 'Favourite', 'Nick Jones', 'Favourite Playlists', '1539943418.jpg', 1, NULL, '2018-10-19 04:26:29', '2018-10-22 00:09:04'),
(9, 3, 'Top 10', 'Nick Jones', 'Latest tracks', '1539943181.jpg', 1, NULL, '2018-10-19 04:29:41', '2018-10-22 00:12:02'),
(10, 4, 'Sathiyan', 'Madona', 'Popular track', '1539944223.jpg', 1, NULL, '2018-10-19 04:47:03', '2018-10-22 00:12:56'),
(12, 2, 'Latest Hits', 'Nick Jones', 'Latest Hits', '1540185027.jpg', 1, NULL, '2018-10-21 23:40:27', '2018-10-22 04:52:54'),
(13, 2, 'New Era', 'Nick Jones', 'Top album', '1540185312.jpg', 1, NULL, '2018-10-21 23:45:12', '2018-10-21 23:52:47'),
(15, 4, 'Hip-Hop', 'Madona', 'latest Track', '1540187022.jpg', 1, NULL, '2018-10-22 00:13:42', '2018-10-22 00:13:42'),
(17, 2, 'Amelia Kelly', 'Dolore sint minim', 'Magna sit consequatur enim minus et ipsa ipsum nulla', '1540884303.jpg', 1, NULL, '2018-10-30 01:55:03', '2018-10-30 02:17:32'),
(18, 3, 'Hip-pop', 'By Nick Cannon', 'Deserunt incidunt odit itaque animi', '', 1, NULL, '2018-10-30 02:20:55', '2018-10-30 02:20:55'),
(19, 1, 'Nick Cannon', NULL, 'Sint non dolores in explicabo Cumque', '1540885927.jpg', 1, NULL, '2018-10-30 02:22:07', '2018-10-30 02:24:01'),
(20, 2, 'Top Album', 'Top songs in album', 'Culpa laboris reiciendis laborum Et quod et ut molestias eaque sint dolor unde incididunt', '1541065479.jpg', 1, NULL, '2018-11-01 02:47:25', '2018-11-01 04:14:41');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_10_15_094701_create_categories_table', 2),
(4, '2018_10_15_112526_create_contents_table', 3),
(5, '2018_10_22_094810_create_songs_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) NOT NULL,
  `token` varchar(191) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `songs`
--

CREATE TABLE `songs` (
  `id` int(10) UNSIGNED NOT NULL,
  `group_id` int(10) DEFAULT NULL,
  `cat_id` int(10) DEFAULT NULL,
  `content_id` int(10) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `song` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `duration` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_fav` tinyint(11) DEFAULT '0' COMMENT '0: Unfav, 1: Fav',
  `status` tinyint(11) DEFAULT '1' COMMENT '0: Inactive, 1:Active',
  `is_delete` tinyint(11) DEFAULT NULL COMMENT '0: Soft, 1: Hard',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `songs`
--

INSERT INTO `songs` (`id`, `group_id`, `cat_id`, `content_id`, `name`, `subtitle`, `description`, `image`, `song`, `duration`, `is_fav`, `status`, `is_delete`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 6, 'Ashton Morenooop', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540552094.jpg', '1540552095.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:38:15', '2018-10-30 01:49:02'),
(2, 1, 3, 8, 'Ashton Morenooop', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540552094.jpg', '1540552095.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:38:15', '2018-10-30 01:49:02'),
(3, 1, 4, 15, 'Ashton Morenooop', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540552094.jpg', '1540552095.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:38:15', '2018-10-30 01:49:02'),
(4, 4, 2, 13, 'Glenna Conner', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '', '1540552329.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:42:10', '2018-10-27 05:36:57'),
(5, 4, 4, 15, 'Glenna Conner', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '', '1540552329.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:42:10', '2018-10-27 05:37:04'),
(6, 6, 1, 6, 'Yaarian', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540559479.jpg', '1540559480.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:47:35', '2018-10-28 23:52:08'),
(7, 6, 2, 13, 'Yaarian', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540559479.jpg', '1540559480.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:47:36', '2018-10-28 23:52:08'),
(8, 6, 3, 14, 'Yaarian', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540559479.jpg', '1540559480.mp3', '5000', NULL, 1, NULL, '2018-10-26 05:47:36', '2018-10-28 23:52:08'),
(13, 6, 4, 10, 'Yaarian', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540559479.jpg', '1540559480.mp3', '5000', NULL, 1, NULL, '2018-10-26 07:41:20', '2018-10-28 23:52:08'),
(14, 1, 2, 12, 'Ashton Morenooop', 'Earum anim culpa dolorem', 'Est sint nostrum aut at occaecat lorem', '1540552094.jpg', '1540552095.mp3', '5000', NULL, 1, NULL, '2018-10-26 23:19:35', '2018-10-30 01:49:02'),
(15, 15, 1, 19, 'Evelyn Silva', 'Rerum cumque aute debitis', 'Praesentium non commodo modi porro qui cupiditate sequi cumque et reprehenderit', '', '1540886983.mp3', '5000', 0, 1, NULL, '2018-10-30 02:28:55', '2018-10-30 02:39:48'),
(16, 15, 3, 8, 'Evelyn Silva', 'Rerum cumque aute debitis', 'Praesentium non commodo modi porro qui cupiditate sequi cumque et reprehenderit', '', '1540886983.mp3', '5000', 0, 1, NULL, '2018-10-30 02:28:56', '2018-10-30 02:39:48');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL COMMENT '1:Male, 2:Female, 3:Other',
  `dob` varchar(255) DEFAULT NULL COMMENT 'yyyy-mm-dd',
  `profile` varchar(255) DEFAULT NULL,
  `social_id` varchar(255) DEFAULT NULL,
  `social_type` varchar(255) DEFAULT NULL,
  `device_type` varchar(255) DEFAULT NULL,
  `device_token` varchar(255) DEFAULT NULL,
  `is_notification` tinyint(1) DEFAULT '1' COMMENT '0: Off; 1: On',
  `pass_token` varchar(255) DEFAULT NULL,
  `remember_token` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `gender`, `dob`, `profile`, `social_id`, `social_type`, `device_type`, `device_token`, `is_notification`, `pass_token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'admin@kizz.com', '$2y$10$srG8Amkxd59ghcaF66qOHuxoV9oh726mf/rSZ1giq1epjXJS9FJ2S', 1, '1988-09-09', NULL, NULL, NULL, NULL, NULL, 1, NULL, 'A2pFq6gTVPZRcpH5CPerfpNv1IRfwxxJZS0Ss2YRCRTOv8VFQxhzLPd71bfR', '2018-10-11 03:02:26', '2018-10-30 06:40:52'),
(17, 'kartik', 'sharma', 'ks@gmail.com', '$2y$10$rn344lR2r/Bicgl5bnWdlOli1mOEH5ovsqQI.L5wtZYCwYyvWXCUK', 0, '2000-10-19', '1540969878.jpg', NULL, NULL, 'Android', '12345678998765321', 1, NULL, NULL, '2018-10-30 02:57:25', '2018-10-31 01:41:22'),
(18, 'kartik', 'sharma', 'ankit.chhabra@imarkinfotech.com', NULL, 0, '1960-05-05', '1540893778.jpg', '345011549402154', 'facebook', '', '', 1, NULL, NULL, '2018-10-30 03:06:28', '2018-10-30 06:46:25');

-- --------------------------------------------------------

--
-- Table structure for table `user_playlists`
--

CREATE TABLE `user_playlists` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user_playlists`
--

INSERT INTO `user_playlists` (`id`, `user_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'sad songs', '', '2018-10-29 04:15:51', '2018-10-29 04:15:51'),
(2, 1, 'sufi songs', 'list of all sufi songs', '2018-10-29 04:16:59', '2018-10-29 04:16:59'),
(3, 18, 'sufi songs', 'list of all sufi songs', '2018-10-30 05:16:36', '2018-10-30 05:16:36'),
(4, 18, 'new one', 'my favourite music playlist contains all senti songs', '2018-10-30 06:31:13', '2018-10-30 06:31:13'),
(5, 17, 'my playlist', 'new playlist of collection', '2018-10-31 01:50:19', '2018-10-31 01:50:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contents`
--
ALTER TABLE `contents`
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
-- Indexes for table `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_playlists`
--
ALTER TABLE `user_playlists`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `contents`
--
ALTER TABLE `contents`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `songs`
--
ALTER TABLE `songs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `user_playlists`
--
ALTER TABLE `user_playlists`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
