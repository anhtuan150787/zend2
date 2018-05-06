-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 06, 2018 at 07:48 AM
-- Server version: 5.5.49
-- PHP Version: 5.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `zend2`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE IF NOT EXISTS `account` (
  `account_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `account_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `account_username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `account_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_password_salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_status` tinyint(4) NOT NULL,
  `account_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_phone` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `account_picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `group_account_id` smallint(6) NOT NULL,
  PRIMARY KEY (`account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`account_id`, `account_name`, `account_username`, `account_password`, `account_password_salt`, `account_status`, `account_email`, `account_phone`, `account_picture`, `group_account_id`) VALUES
(1, 'Anh Tuấn', 'anhtuan150787', 'e49ed34b584d6a4ac562647850517b13', '65601daf9197d19f660233df5f7961c9', 1, 'anhtuan150787@gmail.com', '0944518855', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_account`
--

CREATE TABLE IF NOT EXISTS `group_account` (
  `group_account_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `group_account_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `group_account_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`group_account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `group_account`
--

INSERT INTO `group_account` (`group_account_id`, `group_account_name`, `group_account_status`) VALUES
(1, 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `group_menu`
--

CREATE TABLE IF NOT EXISTS `group_menu` (
  `group_menu_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `group_account_id` smallint(6) NOT NULL,
  `menu_id` smallint(6) NOT NULL,
  `group_menu_status` tinyint(4) NOT NULL,
  PRIMARY KEY (`group_menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3978 ;

--
-- Dumping data for table `group_menu`
--

INSERT INTO `group_menu` (`group_menu_id`, `group_account_id`, `menu_id`, `group_menu_status`) VALUES
(3942, 1, 3, 1),
(3943, 1, 4, 1),
(3944, 1, 16, 1),
(3945, 1, 17, 1),
(3946, 1, 18, 1),
(3947, 1, 19, 1),
(3948, 1, 20, 1),
(3949, 1, 21, 1),
(3950, 1, 22, 1),
(3951, 1, 5, 1),
(3952, 1, 6, 1),
(3953, 1, 7, 1),
(3954, 1, 8, 1),
(3955, 1, 9, 1),
(3956, 1, 10, 1),
(3957, 1, 11, 1),
(3958, 1, 12, 1),
(3959, 1, 13, 1),
(3960, 1, 14, 1),
(3961, 1, 15, 1),
(3962, 1, 25, 0),
(3963, 1, 26, 0),
(3964, 1, 27, 1),
(3965, 1, 28, 1),
(3966, 1, 29, 1),
(3967, 1, 30, 0),
(3968, 1, 31, 1),
(3969, 1, 32, 1),
(3971, 1, 34, 1),
(3975, 1, 38, 1),
(3976, 1, 39, 1),
(3977, 1, 40, 1);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE IF NOT EXISTS `menu` (
  `menu_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `menu_parent` smallint(6) DEFAULT '0',
  `menu_status` tinyint(4) NOT NULL,
  `menu_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_icon` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `menu_position` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=41 ;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`menu_id`, `menu_name`, `menu_parent`, `menu_status`, `menu_url`, `menu_icon`, `menu_position`) VALUES
(3, 'Chức năng', 0, 1, '', '', 0),
(4, 'Trang chủ', 3, 1, 'admin', 'fa fa-home', 1),
(5, 'Hệ thống', 0, 1, '', '', 0),
(6, 'Menu', 5, 1, '', 'fa fa-sitemap', 0),
(7, 'Danh sách', 6, 1, 'admin/menu/index', '', 0),
(8, 'Thêm mới', 6, 1, 'admin/menu/add', '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
