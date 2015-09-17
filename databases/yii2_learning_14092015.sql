-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 14, 2015 at 05:23 PM
-- Server version: 5.5.44
-- PHP Version: 5.6.11-1+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yii2_learning`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1441795122),
('m140209_132017_init', 1441958432),
('m140403_174025_create_account_table', 1441958433),
('m140504_113157_update_tables', 1441958435),
('m140504_130429_create_token_table', 1441958436),
('m140602_111327_create_menu_table', 1442211734),
('m140830_171933_fix_ip_field', 1441958436),
('m140830_172703_change_account_table_name', 1441958436),
('m141222_110026_update_ip_field', 1441958436),
('m141222_135246_alter_username_length', 1442203166),
('m150614_103145_update_social_account_table', 1442203167),
('m150623_212711_fix_username_notnull', 1442203168),
('m150909_103349_create_posts_table', 1441795124),
('m150910_020453_users', 1441942136),
('m150911_044255_create_status_table', 1441946915),
('m150911_045629_create_posts_table', 1441947400),
('m150911_045733_create_posts_table', 1441947508),
('m150914_075138_create_users_table', 1442217154),
('m150914_075349_extend_status_table_for_created_by', 1442217635);

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci NOT NULL,
  `create_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `data`, `create_time`, `update_time`) VALUES
(1, 'Dennis Posts 1', '1', 1441947646, 1441951211);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `message` text COLLATE utf8_unicode_ci NOT NULL,
  `permissions` smallint(6) NOT NULL DEFAULT '0',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_status_created_by` (`created_by`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=30 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `message`, `permissions`, `created_at`, `updated_at`, `created_by`) VALUES
(29, 'Status was created by user logged in.', 10, 1442223950, 1442223950, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `username` varchar(30) CHARACTER SET utf8 DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `authKey` longtext CHARACTER SET utf8 NOT NULL,
  `accessToken` longtext CHARACTER SET utf8,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `username`, `password`, `authKey`, `accessToken`) VALUES
(1, 'Dennis', 'TRAN', 'dennis@enclave.vn', 'dennis', '7daacea5f373b4c1c054158b126d317f', '7daacea5f373b4c1c054158b126d317f', '7daacea5f373b4c1c054158b126d317f'),
(2, 'Noland', 'TRAN', 'noland@enclave.vn', 'noland', '0c145d8738efd1d1e1953bad9ce7f92a', '0c145d8738efd1d1e1953bad9ce7f92a', '0c145d8738efd1d1e1953bad9ce7f92a'),
(3, 'admin', 'admin', 'admin123@enclave.vn', 'admin', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3', '21232f297a57a5a743894a0e4a801fc3');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_status_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
