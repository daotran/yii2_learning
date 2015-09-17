-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 17, 2015 at 11:19 AM
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
-- Table structure for table `auth_assignment`
--

CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1442462830),
('author', '2', 1442462830);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE IF NOT EXISTS `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Admin Role', 'userGroup', NULL, 1442462830, 1442462830),
('author', 1, 'Author Role', 'userGroup', NULL, 1442462830, 1442462830),
('createPost', 2, 'Create a post', NULL, NULL, 1442462830, 1442462830),
('updateOwnPost', 2, 'Update own post', 'isAuthor', NULL, 1442462830, 1442462830),
('updatePost', 2, 'Update post', NULL, NULL, 1442462830, 1442462830);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'author'),
('author', 'createPost'),
('author', 'updateOwnPost'),
('admin', 'updatePost'),
('updateOwnPost', 'updatePost');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_rule`
--

INSERT INTO `auth_rule` (`name`, `data`, `created_at`, `updated_at`) VALUES
('isAuthor', 'O:29:"app\\commands\\rules\\AuthorRule":3:{s:4:"name";s:8:"isAuthor";s:9:"createdAt";i:1442462830;s:9:"updatedAt";i:1442462830;}', 1442462830, 1442462830),
('userGroup', 'O:32:"app\\commands\\rules\\UserGroupRule":3:{s:4:"name";s:9:"userGroup";s:9:"createdAt";i:1442462830;s:9:"updatedAt";i:1442462830;}', 1442462830, 1442462830);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
(1, 'Category 1', NULL, NULL, 1, 'Category 1'),
(2, 'Category 2', NULL, NULL, 2, 'Category 2');

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
('m140506_102106_rbac_init', 1442388338),
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
('m150914_075349_extend_status_table_for_created_by', 1442217635),
('m150916_035629_create_roles_table', 1442375926),
('m150916_035653_create_usersroles_table', 1442375926),
('m150916_041357_create_roles_table', 1442376951),
('m150916_041402_create_usersroles_table', 1442376952),
('m150916_041723_create_users_roles_table', 1442377064),
('m150916_075048_create_menu_table', 1442389925);

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
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=34 ;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `message`, `permissions`, `created_at`, `updated_at`, `created_by`) VALUES
(31, 'Dennis created status 1', 20, 1442373390, 1442373390, 38),
(32, 'Admin created status 1', 10, 1442373881, 1442373881, 37),
(33, 'Admin created status 2', 10, 1442375060, 1442375060, 37);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `gender` varchar(11) CHARACTER SET utf8 DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `auth_key` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `password_reset_token` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=39 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `gender`, `status`, `email`, `password`, `auth_key`, `password_reset_token`) VALUES
(37, 'Admin', 'Admin', 'Male', 1, 'admin@gmail.com', '$2y$13$0mNGn5Gf.guUMPbELzeWieSnpMKIXxXechwoA4al/U8bVw7rLjCIi', 'HMl-n-mHG52DZ2nvYWuTCEiZpGCLjlj9', 'jjpZ84r5lFJ4e3KKEn5mclGGT1ffS94P_1442372574'),
(38, 'Dennis', 'TRAN', 'Male', 1, 'dennis@enclave.vn', '$2y$13$Dh5SXe0Swj3IYOGjQlBnZOUnAFxBakMBlH8/.kQft2QNixga6UmXm', 'ATTXB_jSk-8HYjfh3x5FwUzBTgTN9aVu', 'sFByP2W-vznbksnyn24bxeJnJMfCBfWL_1442372594');

-- --------------------------------------------------------

--
-- Table structure for table `users_roles`
--

CREATE TABLE IF NOT EXISTS `users_roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_roles_user_id` (`user_id`),
  KEY `fk_users_roles_role_id` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_status_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `users_roles`
--
ALTER TABLE `users_roles`
  ADD CONSTRAINT `fk_users_roles_role_id` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_users_roles_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
