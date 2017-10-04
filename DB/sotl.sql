-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 06, 2017 at 07:06 PM
-- Server version: 5.5.52-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `sotl`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE IF NOT EXISTS `comments` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `films`
--

CREATE TABLE IF NOT EXISTS `films` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `genre` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `challenges` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `team_credit` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `biography` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `video_link` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `vimeo_video_id` int(11) NOT NULL,
  `likes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `most_likes` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_and_contributer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `films`
--

INSERT INTO `films` (`id`, `user_id`, `title`, `genre`, `challenges`, `team_credit`, `biography`, `video_link`, `vimeo_video_id`, `likes`, `most_likes`, `credit_and_contributer`, `created_at`, `updated_at`) VALUES
(1, 3, 'Ram bio', 'g1', 'c1', '', 'In vel erat mattis, iaculis elit at, scelerisque nulla. Curabitur sit amet ex finibus, dapibus ex et, sodales nulla. Nullam faucibus ex id leo sollicitudin faucibus. Nulla euismod ullamcorper lacus eu maximus. Proin pellentesque orci velit, at condimentum est dignissim at. Pellentesque sit amet erat et est laoreet efficitur. Mauris egestas dolor id dignissim luctus. Integer commodo velit et augue varius volutpat. Suspendisse pretium nibh diam, nec molestie felis egestas eget.', 'https://vimeo.com/220003118', 220003118, 'a:2:{i:0;i:3;i:1;i:2;}', 'a:2:{i:0;i:3;i:1;i:2;}', '', '2017-06-03 02:09:39', '2017-06-05 08:25:19');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `challenges` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=82 ;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(75, '2014_10_12_000000_create_users_table', 1),
(76, '2014_10_12_100000_create_password_resets_table', 1),
(77, '2017_05_12_110239_create_posts_table', 1),
(78, '2017_05_12_110255_create_comments_table', 1),
(79, '2017_05_26_113922_create_films_table', 1),
(80, '2017_05_26_123847_create_genres_table', 1),
(81, '2017_05_26_132248_create_reviews_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `film_id` int(11) NOT NULL,
  `helpfullreview` int(11) DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `rate_elements` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=13 ;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `film_id`, `helpfullreview`, `title`, `description`, `rate_elements`, `created_at`, `updated_at`) VALUES
(10, 2, 1, NULL, 'My new Updated Review Title', 'In vel erat mattis, iaculis elit at, scelerisque nulla. Curabitur sit amet ex finibus, dapibus ex et, sodales nulla. Nullam faucibus ex id leo sollicitudin faucibus. Nulla euismod ullamcorper lacus eu maximus. Proin pellentesque orci velit, at condimentum est dignissim at. Pellentesque sit amet erat et est laoreet efficitur. Mauris egestas dolor id dignissim luctus. Integer commodo velit et augue varius volutpat. Suspendisse pretium nibh diam, nec molestie felis egestas eget.', 'a:7:{s:6:"writer";s:1:"3";s:8:"director";s:1:"2";s:6:"editor";s:1:"5";s:14:"cinematography";s:1:"1";s:6:"acting";s:1:"4";s:8:"producer";s:1:"2";s:10:"filmrating";s:3:"3.5";}', '2017-06-06 05:27:25', '2017-06-06 06:48:22'),
(11, 1, 1, NULL, 'Admin Review Title', 'Sed id erat pellentesque, tincidunt tellus quis, volutpat quam. Nunc quis vestibulum nulla, at malesuada augue. Fusce maximus non elit sit amet auctor. Sed ultricies, est et sollicitudin porttitor, neque justo aliquam neque, tincidunt pellentesque risus arcu laoreet tellus. Aenean nec dui ex. Phasellus non sem a lorem mollis laoreet. Maecenas non arcu sapien. Aenean vitae vulputate ex. Phasellus mattis turpis vel diam sagittis consequat.', 'a:7:{s:6:"writer";s:1:"3";s:8:"director";s:1:"2";s:6:"editor";s:1:"4";s:14:"cinematography";s:1:"2";s:6:"acting";s:1:"4";s:8:"producer";s:1:"2";s:10:"filmrating";s:3:"3.6";}', '2017-06-06 07:01:16', '2017-06-06 07:01:16'),
(12, 4, 1, NULL, 'Shanik Review', 'Sed id erat pellentesque, tincidunt tellus quis, volutpat quam. Nunc quis vestibulum nulla, at malesuada augue. Fusce maximus non elit sit amet auctor. Sed ultricies, est et sollicitudin porttitor, neque justo aliquam neque, tincidunt pellentesque risus arcu laoreet tellus. Aenean nec dui ex. Phasellus non sem a lorem mollis laoreet. Maecenas non arcu sapien. Aenean vitae vulputate ex. Phasellus mattis turpis vel diam sagittis consequat.', 'a:7:{s:6:"writer";s:1:"5";s:8:"director";s:1:"4";s:6:"editor";s:1:"3";s:14:"cinematography";s:1:"2";s:6:"acting";s:1:"4";s:8:"producer";s:1:"3";s:10:"filmrating";s:3:"2.8";}', '2017-06-06 07:22:53', '2017-06-06 07:22:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `login_with` int(11) NOT NULL,
  `user_pic` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=5 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `login_with`, `user_pic`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Ramesh Jaiswal', 'ramesh007jai@gmail.com', '$2y$10$TJBZekK1IfgN7uHhVmoQ5OL0ORd52Y6N.2j26apyg/S468FNNl2CO', 'admin', 0, '', 'Y7fhuvQZLkELAgUvEox5lewkME6TAcdegq5WkAxQeg0eKW6bdz7zEBU91d0i', '2017-06-05 07:17:30', '2017-06-05 07:17:30'),
(2, 'Student', 'student@gmail.com', '$2y$10$AkjviKffO2rfXhkcWSAmbe4oBwRJ8xQzdrRjY3k68BEYcOsodkEhe', 'student', 0, '', 'pHAAQzU2dcpv1UCEgyRp7HzLmFeWc23qGGjW2HDgljXw4eAz7XSFNku1CeWr', '2017-06-05 07:17:58', '2017-06-05 07:17:58'),
(3, 'Test clixlogix', 'ramesh.clixlogix@gmail.com', '$2y$10$xtCIHfisoGOi0laGPEeNqO.MfG8M9vtgRz3SkbRlGo1w0K0ymVwWm', 'non-student', 0, '', 'fQhlIkJK9tTmTxPvtOEKBzeuBiX9UDNvXQivx59cDY1gmXYX0RPIRtbdRKiv', '2017-06-05 07:18:05', '2017-06-05 07:18:05'),
(4, 'Shanik Kumar', 'shanik@gmail.com', '$2y$10$YLKmziryqm2003LY34Jl2ew61l59j3YBLZeJs3h9KC/f7kRRNDR.G', 'student', 0, '', 'yM6wbwF0awcQVZ01Wncpwtfo829Pd577yo4iLwmU7COfI4QKcXdhuX7VBzOQ', '2017-06-06 07:21:55', '2017-06-06 07:21:55');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
