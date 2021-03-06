-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.6.17 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.1.0.4913
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for lylichkhoahoc
CREATE DATABASE IF NOT EXISTS `lylichkhoahoc` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `lylichkhoahoc`;


-- Dumping structure for table lylichkhoahoc.jos_admin_resource
CREATE TABLE IF NOT EXISTS `jos_admin_resource` (
  `resource_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Resource ID',
  `parent_id` int(10) NOT NULL COMMENT 'Resource Parent',
  `resource` varchar(255) NOT NULL COMMENT 'Resource',
  `resource_name` varchar(255) NOT NULL DEFAULT 'Resource New' COMMENT 'Resource Name',
  `resource_type` varchar(20) NOT NULL COMMENT 'Type resource',
  `resource_object` varchar(50) NOT NULL DEFAULT 'ACL' COMMENT 'White list or ACL',
  `is_white_list` int(11) DEFAULT '0',
  `is_hidden` int(11) DEFAULT '0',
  PRIMARY KEY (`resource_id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8 COMMENT='Admin Resource Table';

-- Dumping data for table lylichkhoahoc.jos_admin_resource: ~73 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_resource` DISABLE KEYS */;
INSERT INTO `jos_admin_resource` (`resource_id`, `parent_id`, `resource`, `resource_name`, `resource_type`, `resource_object`, `is_white_list`, `is_hidden`) VALUES
	(1, 0, 'Route', 'Route Module', 'Module', 'ACL', 0, 1),
	(2, 1, 'Route\\Controller\\Route', 'Route\\Controller\\Route Controller', 'Controller', 'ACL', 0, 1),
	(3, 2, 'index', 'index Action', 'Action', 'ACL', 0, 1),
	(4, 0, 'Permission', 'Permission Module', 'Module', 'ACL', 0, 0),
	(5, 4, 'Permission\\Controller\\User', 'Permission\\Controller\\User Controller', 'Controller', 'ACL', 0, 0),
	(6, 5, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(7, 5, 'login', 'login Action', 'Action', 'ACL', 1, 0),
	(8, 5, 'logout', 'logout Action', 'Action', 'ACL', 1, 0),
	(9, 4, 'Permission\\Controller\\Permission', 'Permission\\Controller\\Permission Controller', 'Controller', 'ACL', 0, 0),
	(10, 9, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(11, 9, 'permissionOfUser', 'permissionOfUser Action', 'Action', 'ACL', 0, 0),
	(12, 9, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(13, 9, 'changeWhiteList', 'changeWhiteList Action', 'Action', 'ACL', 0, 0),
	(14, 9, 'update', 'update Action', 'Action', 'ACL', 0, 0),
	(15, 0, 'Application', 'Application Module', 'Module', 'ACL', 0, 0),
	(16, 15, 'Application\\Controller\\Index', 'Application\\Controller\\Index Controller', 'Controller', 'ACL', 0, 0),
	(17, 16, 'index', 'index Action', 'Action', 'ACL', 1, 0),
	(19, 16, 'editInfor', 'editInfor Action', 'Action', 'ACL', 0, 0),
	(20, 16, 'editAllProfile', 'editAllProfile Action', 'Action', 'ACL', 0, 0),
	(21, 0, 'CongTacNghienCuu', 'CongTacNghienCuu Module', 'Module', 'ACL', 0, 0),
	(22, 21, 'CongTacNghienCuu\\Controller\\CongTacNghienCuu', 'CongTacNghienCuu\\Controller\\CongTacNghienCuu Controller', 'Controller', 'ACL', 0, 0),
	(23, 22, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(24, 22, 'add', 'add Action', 'Action', 'ACL', 0, 0),
	(25, 22, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(26, 22, 'delete', 'delete Action', 'Action', 'ACL', 0, 0),
	(27, 0, 'ChungChiKhac', 'ChungChiKhac Module', 'Module', 'ACL', 0, 0),
	(28, 27, 'ChungChiKhac\\Controller\\ChungChiKhac', 'ChungChiKhac\\Controller\\ChungChiKhac Controller', 'Controller', 'ACL', 0, 0),
	(29, 28, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(30, 28, 'add', 'add Action', 'Action', 'ACL', 0, 0),
	(31, 28, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(32, 28, 'delete', 'delete Action', 'Action', 'ACL', 0, 0),
	(33, 0, 'MonHoc', 'MonHoc Module', 'Module', 'ACL', 0, 0),
	(34, 33, 'MonHoc\\Controller\\MonHoc', 'MonHoc\\Controller\\MonHoc Controller', 'Controller', 'ACL', 0, 0),
	(35, 34, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(36, 34, 'add', 'add Action', 'Action', 'ACL', 0, 0),
	(37, 34, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(38, 34, 'delete', 'delete Action', 'Action', 'ACL', 0, 0),
	(39, 0, 'NamHoc', 'NamHoc Module', 'Module', 'ACL', 0, 0),
	(40, 39, 'NamHoc\\Controller\\NamHoc', 'NamHoc\\Controller\\NamHoc Controller', 'Controller', 'ACL', 0, 0),
	(41, 40, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(42, 40, 'kichHoat', 'kichHoat Action', 'Action', 'ACL', 0, 0),
	(43, 40, 'add', 'add Action', 'Action', 'ACL', 0, 0),
	(44, 40, 'delete', 'delete Action', 'Action', 'ACL', 0, 0),
	(45, 0, 'Attribute', 'Attribute Module', 'Module', 'ACL', 0, 0),
	(46, 45, 'Attribute\\Controller\\Attribute', 'Attribute\\Controller\\Attribute Controller', 'Controller', 'ACL', 0, 0),
	(47, 46, 'index', 'index Action', 'Action', 'ACL', 0, 0),
	(48, 46, 'add', 'add Action', 'Action', 'ACL', 0, 0),
	(49, 46, 'edit', 'edit Action', 'Action', 'ACL', 0, 0),
	(50, 46, 'delete', 'delete Action', 'Action', 'ACL', 0, 0),
	(51, 46, 'editOption', 'editOption Action', 'Action', 'ACL', 0, 0),
	(52, 16, 'editCertificate', 'editCertificate Action', 'Action', 'ACL', 0, 0),
	(53, 16, 'addTeaching', 'addTeaching Action', 'Action', 'ACL', 0, 0),
	(54, 16, 'editTeaching', 'editTeaching Action', 'Action', 'ACL', 0, 0),
	(55, 16, 'deleteTeaching', 'deleteTeaching Action', 'Action', 'ACL', 0, 0),
	(56, 16, 'editHoatDongNghienCuuKhoaHoc', 'editHoatDongNghienCuuKhoaHoc Action', 'Action', 'ACL', 0, 0),
	(57, 16, 'addOrtherWork', 'addOrtherWork Action', 'Action', 'ACL', 0, 0),
	(58, 16, 'editOrtherWork', 'editOrtherWork Action', 'Action', 'ACL', 0, 0),
	(59, 16, 'deleteOrtherWork', 'deleteOrtherWork Action', 'Action', 'ACL', 0, 0),
	(60, 16, 'addFutureTeaching', 'addFutureTeaching Action', 'Action', 'ACL', 0, 0),
	(61, 16, 'editFutureTeaching', 'editFutureTeaching Action', 'Action', 'ACL', 0, 0),
	(62, 16, 'deleteFutureTeaching', 'deleteFutureTeaching Action', 'Action', 'ACL', 0, 0),
	(63, 16, 'addFutureHoatDongNghienCuuKhoaHoc', 'addFutureHoatDongNghienCuuKhoaHoc Action', 'Action', 'ACL', 0, 0),
	(64, 16, 'editFutureHoatDongNghienCuuKhoaHoc', 'editFutureHoatDongNghienCuuKhoaHoc Action', 'Action', 'ACL', 0, 0),
	(65, 16, 'deleteFutureHoatDongNghienCuuKhoaHoc', 'deleteFutureHoatDongNghienCuuKhoaHoc Action', 'Action', 'ACL', 0, 0),
	(66, 16, 'addFutureStudy', 'addFutureStudy Action', 'Action', 'ACL', 0, 0),
	(67, 16, 'editFutureStudy', 'editFutureStudy Action', 'Action', 'ACL', 0, 0),
	(68, 16, 'deleteFutureStudy', 'deleteFutureStudy Action', 'Action', 'ACL', 0, 0),
	(69, 16, 'addFutureOrtherWork', 'addFutureOrtherWork Action', 'Action', 'ACL', 0, 0),
	(70, 16, 'editFutureOrtherWork', 'editFutureOrtherWork Action', 'Action', 'ACL', 0, 0),
	(71, 16, 'deleteFutureOrtherWork', 'deleteFutureOrtherWork Action', 'Action', 'ACL', 0, 0),
	(72, 16, 'addScientificReport', 'addScientificReport Action', 'Action', 'ACL', 0, 0),
	(73, 16, 'editScientificReport', 'editScientificReport Action', 'Action', 'ACL', 0, 0),
	(74, 16, 'deleteScientificReport', 'deleteScientificReport Action', 'Action', 'ACL', 0, 0);
/*!40000 ALTER TABLE `jos_admin_resource` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_admin_role
CREATE TABLE IF NOT EXISTS `jos_admin_role` (
  `role_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Role ID',
  `role_name` varchar(50) DEFAULT NULL COMMENT 'Role Name Is UserType In Jos_Users',
  PRIMARY KEY (`role_id`),
  UNIQUE KEY `role_name` (`role_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Role table';

-- Dumping data for table lylichkhoahoc.jos_admin_role: ~4 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_role` DISABLE KEYS */;
INSERT INTO `jos_admin_role` (`role_id`, `role_name`) VALUES
	(4, 'Author'),
	(2, 'Editor'),
	(3, 'Registered'),
	(1, 'Super Administrator');
/*!40000 ALTER TABLE `jos_admin_role` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_admin_rule
CREATE TABLE IF NOT EXISTS `jos_admin_rule` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Rule ID',
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'Role ID',
  `resource_id` varchar(255) DEFAULT NULL COMMENT 'Resource ID',
  PRIMARY KEY (`rule_id`),
  KEY `IDX_JOS_RULE_RESOURCE_ID_ROLE_ID` (`resource_id`,`role_id`),
  KEY `IDX_JOS_RULE_ROLE_ID_RESOURCE_ID` (`role_id`,`resource_id`),
  CONSTRAINT `FK_JOS_RULE_ROLE_ID_JOS_ROLE_ROLE_ID` FOREIGN KEY (`role_id`) REFERENCES `jos_admin_role` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=344 DEFAULT CHARSET=utf8 COMMENT='Admin Rule Table';

-- Dumping data for table lylichkhoahoc.jos_admin_rule: ~163 rows (approximately)
/*!40000 ALTER TABLE `jos_admin_rule` DISABLE KEYS */;
INSERT INTO `jos_admin_rule` (`rule_id`, `role_id`, `resource_id`) VALUES
	(106, 1, '10'),
	(107, 1, '11'),
	(108, 1, '12'),
	(109, 1, '13'),
	(110, 1, '14'),
	(111, 1, '15'),
	(286, 2, '15'),
	(317, 3, '15'),
	(255, 4, '15'),
	(112, 1, '16'),
	(287, 2, '16'),
	(318, 3, '16'),
	(256, 4, '16'),
	(113, 1, '17'),
	(288, 2, '17'),
	(319, 3, '17'),
	(257, 4, '17'),
	(114, 1, '19'),
	(289, 2, '19'),
	(320, 3, '19'),
	(258, 4, '19'),
	(115, 1, '20'),
	(139, 1, '21'),
	(140, 1, '22'),
	(141, 1, '23'),
	(142, 1, '24'),
	(143, 1, '25'),
	(144, 1, '26'),
	(145, 1, '27'),
	(146, 1, '28'),
	(147, 1, '29'),
	(148, 1, '30'),
	(149, 1, '31'),
	(150, 1, '32'),
	(151, 1, '33'),
	(152, 1, '34'),
	(153, 1, '35'),
	(154, 1, '36'),
	(155, 1, '37'),
	(156, 1, '38'),
	(157, 1, '39'),
	(100, 1, '4'),
	(282, 2, '4'),
	(313, 3, '4'),
	(251, 4, '4'),
	(158, 1, '40'),
	(159, 1, '41'),
	(160, 1, '42'),
	(161, 1, '43'),
	(162, 1, '44'),
	(163, 1, '45'),
	(164, 1, '46'),
	(165, 1, '47'),
	(166, 1, '48'),
	(167, 1, '49'),
	(101, 1, '5'),
	(283, 2, '5'),
	(314, 3, '5'),
	(252, 4, '5'),
	(168, 1, '50'),
	(169, 1, '51'),
	(116, 1, '52'),
	(290, 2, '52'),
	(321, 3, '52'),
	(259, 4, '52'),
	(117, 1, '53'),
	(291, 2, '53'),
	(322, 3, '53'),
	(260, 4, '53'),
	(118, 1, '54'),
	(292, 2, '54'),
	(323, 3, '54'),
	(261, 4, '54'),
	(119, 1, '55'),
	(293, 2, '55'),
	(324, 3, '55'),
	(262, 4, '55'),
	(120, 1, '56'),
	(294, 2, '56'),
	(325, 3, '56'),
	(263, 4, '56'),
	(121, 1, '57'),
	(295, 2, '57'),
	(326, 3, '57'),
	(264, 4, '57'),
	(122, 1, '58'),
	(296, 2, '58'),
	(327, 3, '58'),
	(265, 4, '58'),
	(123, 1, '59'),
	(297, 2, '59'),
	(328, 3, '59'),
	(266, 4, '59'),
	(102, 1, '6'),
	(124, 1, '60'),
	(298, 2, '60'),
	(329, 3, '60'),
	(267, 4, '60'),
	(125, 1, '61'),
	(299, 2, '61'),
	(330, 3, '61'),
	(268, 4, '61'),
	(126, 1, '62'),
	(300, 2, '62'),
	(331, 3, '62'),
	(269, 4, '62'),
	(127, 1, '63'),
	(301, 2, '63'),
	(332, 3, '63'),
	(270, 4, '63'),
	(128, 1, '64'),
	(302, 2, '64'),
	(333, 3, '64'),
	(271, 4, '64'),
	(129, 1, '65'),
	(303, 2, '65'),
	(334, 3, '65'),
	(272, 4, '65'),
	(130, 1, '66'),
	(304, 2, '66'),
	(335, 3, '66'),
	(273, 4, '66'),
	(131, 1, '67'),
	(305, 2, '67'),
	(336, 3, '67'),
	(274, 4, '67'),
	(132, 1, '68'),
	(306, 2, '68'),
	(337, 3, '68'),
	(275, 4, '68'),
	(133, 1, '69'),
	(307, 2, '69'),
	(338, 3, '69'),
	(276, 4, '69'),
	(103, 1, '7'),
	(284, 2, '7'),
	(315, 3, '7'),
	(253, 4, '7'),
	(134, 1, '70'),
	(308, 2, '70'),
	(339, 3, '70'),
	(277, 4, '70'),
	(135, 1, '71'),
	(309, 2, '71'),
	(340, 3, '71'),
	(278, 4, '71'),
	(136, 1, '72'),
	(310, 2, '72'),
	(341, 3, '72'),
	(279, 4, '72'),
	(137, 1, '73'),
	(311, 2, '73'),
	(342, 3, '73'),
	(280, 4, '73'),
	(138, 1, '74'),
	(312, 2, '74'),
	(343, 3, '74'),
	(281, 4, '74'),
	(104, 1, '8'),
	(285, 2, '8'),
	(316, 3, '8'),
	(254, 4, '8'),
	(105, 1, '9');
/*!40000 ALTER TABLE `jos_admin_rule` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_attribute
CREATE TABLE IF NOT EXISTS `jos_attribute` (
  `attribute_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_code` varchar(50) DEFAULT NULL,
  `year_id` year(4) DEFAULT '2015',
  `frontend_input` varchar(50) DEFAULT 'Text',
  `frontend_label` varchar(50) DEFAULT NULL,
  `value_table` varchar(50) DEFAULT 'jos_infomation',
  PRIMARY KEY (`attribute_id`),
  UNIQUE KEY `attribute_code` (`attribute_code`,`year_id`),
  KEY `FK_jos_attribute_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_attribute_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='Sử dụng trong jos_information';

-- Dumping data for table lylichkhoahoc.jos_attribute: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_attribute` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_attribute` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_attribute_option
CREATE TABLE IF NOT EXISTS `jos_attribute_option` (
  `value_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `attribute_id` smallint(6) unsigned NOT NULL DEFAULT '1',
  `key` varchar(250) DEFAULT NULL,
  `label` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `attribute_id_key` (`attribute_id`,`key`),
  CONSTRAINT `FK_jos_attribute_option_jos_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `jos_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table lylichkhoahoc.jos_attribute_option: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_attribute_option` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_attribute_option` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_certificate
CREATE TABLE IF NOT EXISTS `jos_certificate` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `year_id` year(4) DEFAULT '2015',
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `name` (`name`,`year_id`),
  KEY `FK_jos_certificate_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_certificate_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='Các chứng chỉ';

-- Dumping data for table lylichkhoahoc.jos_certificate: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_certificate` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_certificate` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_certificate_user
CREATE TABLE IF NOT EXISTS `jos_certificate_user` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `certificate_id` smallint(6) NOT NULL DEFAULT '1',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `level` varchar(250) DEFAULT NULL,
  `note` varchar(250) DEFAULT '0',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id` (`user_id`,`certificate_id`),
  KEY `FK_jos_certificate_user_jos_certificate` (`certificate_id`),
  CONSTRAINT `FK_jos_certificate_user_jos_certificate` FOREIGN KEY (`certificate_id`) REFERENCES `jos_certificate` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='1 user có những chứng chỉ nào';

-- Dumping data for table lylichkhoahoc.jos_certificate_user: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_certificate_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_certificate_user` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_future_orther_work
CREATE TABLE IF NOT EXISTS `jos_future_orther_work` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `year_id` year(4) DEFAULT '2015',
  `user_id` int(11) DEFAULT '1',
  `content` varchar(250) DEFAULT NULL,
  `time_from` date DEFAULT NULL,
  `time_to` date DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_content` (`user_id`,`content`,`year_id`),
  KEY `FK_jos_future_orther_work_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_future_orther_work_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Định hướng phát triển\r\nCông tác khác';

-- Dumping data for table lylichkhoahoc.jos_future_orther_work: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_future_orther_work` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_future_orther_work` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_future_science_research_of_user
CREATE TABLE IF NOT EXISTS `jos_future_science_research_of_user` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `science_activity_name` varchar(250) DEFAULT NULL,
  `year_id` year(4) DEFAULT '2015',
  `time_from` date DEFAULT NULL,
  `time_to` date DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_content` (`user_id`,`science_activity_name`,`year_id`),
  KEY `FK_jos_futurre_science_research_of_user_jos_science_activity` (`science_activity_name`),
  KEY `FK_jos_future_science_research_of_user_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_future_science_research_of_user_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Định hướng phát triển\r\nCông tác nghiên cứu khoa học';

-- Dumping data for table lylichkhoahoc.jos_future_science_research_of_user: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_future_science_research_of_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_future_science_research_of_user` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_future_study
CREATE TABLE IF NOT EXISTS `jos_future_study` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '1',
  `subject_name` varchar(250) DEFAULT NULL,
  `year_id` year(4) DEFAULT '2015',
  `address` varchar(250) DEFAULT NULL,
  `time_from` date DEFAULT NULL,
  `time_to` date DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id` (`user_id`,`subject_name`,`year_id`),
  KEY `FK_jos_future_study_jos_subject` (`subject_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Định hướng phát triển\r\nHọc tập nâng cao trình độ';

-- Dumping data for table lylichkhoahoc.jos_future_study: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_future_study` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_future_study` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_future_teaching
CREATE TABLE IF NOT EXISTS `jos_future_teaching` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `subject_id` smallint(6) NOT NULL DEFAULT '1',
  `lesson_number` int(11) DEFAULT '0',
  `qualifications` varchar(250) DEFAULT NULL,
  `edu_system` varchar(250) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_subject` (`user_id`,`subject_id`),
  KEY `FK_jos_future_teaching_jos_subject` (`subject_id`),
  CONSTRAINT `FK_jos_future_teaching_jos_subject` FOREIGN KEY (`subject_id`) REFERENCES `jos_subject` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Định hướng phát triển\r\nCông tác giảng dạy';

-- Dumping data for table lylichkhoahoc.jos_future_teaching: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_future_teaching` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_future_teaching` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_infomation
CREATE TABLE IF NOT EXISTS `jos_infomation` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `attribute_id` smallint(6) unsigned NOT NULL DEFAULT '1',
  `value` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_attribute_id` (`user_id`,`attribute_id`),
  KEY `FK_jos_thong_tin_ca_nhan_jos_attribute` (`attribute_id`),
  CONSTRAINT `FK_jos_thong_tin_ca_nhan_jos_attribute` FOREIGN KEY (`attribute_id`) REFERENCES `jos_attribute` (`attribute_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COMMENT='Thông tin cá nhân, kèm với bảng jos_attribute';

-- Dumping data for table lylichkhoahoc.jos_infomation: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_infomation` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_infomation` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_orther_work
CREATE TABLE IF NOT EXISTS `jos_orther_work` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `year_id` year(4) DEFAULT '2015',
  `user_id` int(11) DEFAULT '1',
  `content` varchar(250) DEFAULT NULL,
  `time_from` date DEFAULT NULL,
  `time_to` date DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_content` (`user_id`,`content`,`year_id`),
  KEY `FK_jos_orther_work_jos_year` (`year_id`,`user_id`,`content`),
  CONSTRAINT `FK_jos_orther_work_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='Công tác khác';

-- Dumping data for table lylichkhoahoc.jos_orther_work: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_orther_work` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_orther_work` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_science_activity
CREATE TABLE IF NOT EXISTS `jos_science_activity` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `year_id` year(4) DEFAULT '2015',
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `name` (`name`,`year_id`),
  KEY `FK_jos_science_activity_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_science_activity_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Các hoạt động nghiên cứu khoa học';

-- Dumping data for table lylichkhoahoc.jos_science_activity: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_science_activity` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_science_activity` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_science_research_of_user
CREATE TABLE IF NOT EXISTS `jos_science_research_of_user` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '1',
  `science_activity_id` smallint(6) DEFAULT '1',
  `time_from` date DEFAULT NULL,
  `time_to` date DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_science_activity_id` (`user_id`,`science_activity_id`),
  KEY `FK_jos_science_research_of_user_jos_science_activity` (`science_activity_id`),
  CONSTRAINT `FK_jos_science_research_of_user_jos_science_activity` FOREIGN KEY (`science_activity_id`) REFERENCES `jos_science_activity` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Liên kết bảng jos_user và bảng jos_science_activity';

-- Dumping data for table lylichkhoahoc.jos_science_research_of_user: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_science_research_of_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_science_research_of_user` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_scientific_report
CREATE TABLE IF NOT EXISTS `jos_scientific_report` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `year_id` year(4) NOT NULL DEFAULT '2015',
  `user_id` int(11) NOT NULL DEFAULT '1',
  `name` varchar(250) DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `publish_place` varchar(250) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_name` (`user_id`,`name`,`year_id`),
  KEY `FK_jos_scientific_report_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_scientific_report_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Báo cáo khoa học đã công bố';

-- Dumping data for table lylichkhoahoc.jos_scientific_report: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_scientific_report` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_scientific_report` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_subject
CREATE TABLE IF NOT EXISTS `jos_subject` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `year_id` year(4) DEFAULT '2015',
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `name` (`name`,`year_id`),
  KEY `FK_jos_subject_jos_year` (`year_id`),
  CONSTRAINT `FK_jos_subject_jos_year` FOREIGN KEY (`year_id`) REFERENCES `jos_year` (`year_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='Môn học';

-- Dumping data for table lylichkhoahoc.jos_subject: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_subject` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_subject` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_teaching
CREATE TABLE IF NOT EXISTS `jos_teaching` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '1',
  `subject_id` smallint(6) DEFAULT '1',
  `lesson_number` int(11) DEFAULT '0',
  `qualifications` varchar(250) DEFAULT NULL,
  `edu_system` varchar(250) DEFAULT NULL,
  `note` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_subject` (`user_id`,`subject_id`),
  KEY `FK_jos_teaching_jos_subject` (`subject_id`),
  CONSTRAINT `FK_jos_teaching_jos_subject` FOREIGN KEY (`subject_id`) REFERENCES `jos_subject` (`value_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Công tác giảng dạy';

-- Dumping data for table lylichkhoahoc.jos_teaching: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_teaching` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_teaching` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_users
CREATE TABLE IF NOT EXISTS `jos_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(150) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `password` varchar(100) NOT NULL DEFAULT '',
  `usertype` varchar(25) NOT NULL DEFAULT '',
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `sendEmail` tinyint(4) DEFAULT '0',
  `gid` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `registerDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL DEFAULT '',
  `params` text NOT NULL,
  `stt` int(11) NOT NULL DEFAULT '2',
  PRIMARY KEY (`id`),
  KEY `usertype` (`usertype`) USING BTREE,
  KEY `idx_name` (`name`) USING BTREE,
  KEY `gid_block` (`gid`,`block`) USING BTREE,
  KEY `username` (`username`) USING BTREE,
  KEY `email` (`email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=117 DEFAULT CHARSET=utf8;

-- Dumping data for table lylichkhoahoc.jos_users: 34 rows
/*!40000 ALTER TABLE `jos_users` DISABLE KEYS */;
INSERT INTO `jos_users` (`id`, `name`, `username`, `email`, `password`, `usertype`, `block`, `sendEmail`, `gid`, `registerDate`, `lastvisitDate`, `activation`, `params`, `stt`) VALUES
	(62, 'Administrator', 'ktcn', 'hoangkhamtv@tvu.edu.vn', 'd6b0ab7f1c8ab8f514db9a6d85de160a', 'Super Administrator', 0, 1, 25, '2011-02-27 08:18:59', '2014-05-20 14:02:50', '', 'admin_language=en-GB\nlanguage=en-GB\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(75, 'Nguyễn Hoàng Duy Thiện', 'thiennhd', 'thiennhd@gmail.com', 'd6b0ab7f1c8ab8f514db9a6d85de160a', 'Editor', 0, 1, 20, '2012-01-30 03:27:46', '2014-05-27 09:27:11', '', 'admin_language=en-GB\nlanguage=en-GB\neditor=\nhelpsite=\ntimezone=7\n\n', 1),
	(76, 'Võ Phước Hưng', 'hungvo', 'hungvo@tvu.edu.vn', 'd6b0ab7f1c8ab8f514db9a6d85de160a', 'Registered', 0, 0, 18, '2012-01-30 03:30:52', '2014-04-25 08:54:07', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', -1),
	(77, 'Nguyễn Bảo Ân', 'annb', 'annb@tvu.edu.vn', '078c1b640991fd43404fce86fea80e51:UVEMN4Es68g3i7Y0eVhggXlimCehDHFW', 'Registered', 0, 0, 18, '2012-01-30 03:32:52', '2014-03-31 09:56:15', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(78, 'Võ Thành C', 'vothanhc', 'vothanhc@tvu.edu.vn', '1ab15591d0b098f9bf794ef9c85ac7a0:VUxy3LLFGOg1CxVgBmyWzYI1X4e6YeFc', 'Registered', 0, 0, 18, '2012-01-30 03:33:57', '2014-04-04 08:23:09', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(79, 'Phạm Minh Đương', 'duongmtvu', 'duongmtvu@yahoo.com', '2540e408aeb83b55afdd8d130f60cdf4:XQbW40tLKHTWle1aXO9N2mErETBMfsqH', 'Registered', 0, 0, 18, '2012-01-30 03:34:55', '2014-05-26 13:37:05', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(80, 'Nguyễn Trần Diễm Hạnh', 'diemhanh_tvu', 'diemhanh_tvu@tvu.edu.vn', '988be21644784d9773c31cb7ae0852d3:ViotM8oc64UDkYHNl2RR1NTTK56PKYIT', 'Registered', 0, 0, 18, '2012-01-30 03:35:49', '2013-09-04 02:42:51', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(81, 'Ngô Thanh Huy', 'thanhhuydhbk', 'thanhhuydhbk@gmail.com', '2ecf1234a26d37bb21caee2843c52778:VtziWwcx9hw7pbEE4qIazoPuWwtiWoSA', 'Registered', 0, 0, 18, '2012-01-30 03:36:40', '2014-02-23 15:13:15', '59d0901dc846a6af66edf0fc0e89800f', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(82, 'Dương Ngọc Vân Khanh', 'dnvkhanh', 'dnvkhanh@gmail.com', '7c6ca33c765534783805ace933fa1e96:JAwMDDiE1xb4Bv81trdBoNzWR2XIW223', 'Registered', 0, 0, 18, '2012-01-30 03:37:41', '2013-09-06 07:57:19', 'a4d88478344773cc17e339d9910b2493', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(83, 'Nguyễn Nhứt Lam', 'lamnntvu', 'lamnntvu@gmail.com', 'fceccf70b893ad34b8766a9e8cbdcb4a:Y1lrFEVk0DyxlJAF8qdB9uINztYRm6Ha', 'Registered', 0, 0, 18, '2012-01-30 03:38:22', '2014-05-07 05:54:12', 'f782a6f5f91bca916928f7447a745770', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(102, 'Hà Thị Thúy Vi', 'hattvi.tvu2008', 'hattvi.tvu2008@gmail.com', '5045c4add8bffe55796545eaa0fa7979:KFTBEOz6INwicDEafyGgltnNRhCahIM4', 'Registered', 0, 0, 18, '2012-01-30 08:02:04', '2013-12-24 07:19:44', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(84, 'Lê Thị Thùy Lan', 'aitthuylan', 'aitthuylan@gmail.com', '239a37a8653d1f327c4b88bc0c0a4267:BffOnyBtF4Ew7ZggxhU41OM7onpBcqqV', 'Registered', 0, 0, 18, '2012-01-30 03:40:23', '2014-05-26 04:27:20', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(85, 'Phạm Thị Trúc Mai', 'pttmai', 'pttmai@tvu.edu.vn', 'a476f2f805b9576507323e020521271b:NEd0YFxpkLUsxRzV9uFrEbjjVvyM1svr', 'Registered', 0, 0, 18, '2012-01-30 03:41:18', '2014-05-26 04:39:56', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(86, 'Đoàn Phước Miền', 'mien', 'mien@vietnamqa.com', '259d4967ffa64385c110d65d33f0a973:mu2e2zNm2Re4dWMjiNUOrqXoB3gTcBuk', 'Registered', 0, 0, 18, '2012-01-30 03:42:28', '2014-05-19 11:53:57', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(87, 'Trần Văn Nam', 'tranvannamtvu', 'tranvannamtvu@yahoo.com.vn', 'e1b297208832febb89e67d277f4fac4a:PJSX2v7hWCNE3UYcmzr8WY8moBiDkKFv', 'Registered', 0, 0, 18, '2012-01-30 03:43:36', '2014-01-03 03:06:02', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(88, 'Trầm Hoàng Nam', 'tramhoangnam', 'tramhoangnam@yahoo.com', '3764497c236d69521fdc0bf83fe5ccf4:V2jMa53ikpFd3EmL4FR4PWKAIsIDfhiD', 'Registered', 0, 0, 18, '2012-01-30 03:44:26', '2014-05-27 07:03:04', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(89, 'Phan Thị Phương Nam', 'phuongnam0719', 'phuongnam0719@yahoo.com', 'fe6eeed613bec601641873621e8d3e03:hN5HWmnpSymFLfkP7wM971c5xTVAmW1J', 'Registered', 0, 0, 18, '2012-01-30 03:46:33', '2014-04-15 10:22:26', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(90, 'Khấu Văn Nhựt', 'nhutkhau', 'nhutkhau@gmail.com', '3f2bac8cbdbdd95fca7044b5e3b011fb:TWBRAyFDsrO5evhFfkO5BHbUIkSqBJeG', 'Registered', 0, 0, 18, '2012-01-30 03:47:26', '2014-05-10 07:49:51', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(91, 'Nguyễn Khắc Quốc', 'quoctv10', 'quoctv10@gmail.com', '3b68548473f86421c579e1353e16e827:oC2DVpEOGsMZ3lsdflRpGB1tIeh6ZH7s', 'Registered', 0, 0, 18, '2012-01-30 03:48:08', '2014-04-23 06:37:05', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(92, 'Nguyễn Thái Sơn', 'jun_misuri', 'jun_misuri@yahoo.com', '793cebfce697963ede7f512f9c377ca2:OJdlmflLKVyusBgIgJuLd8LVs3mLJds3', 'Registered', 0, 0, 18, '2012-01-30 03:48:52', '2014-02-24 11:36:39', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(93, 'Nguyễn Thừa Phát Tài', 'phattai', 'phattai@tvu.edu.vn', '78fc588266bdc580e2e48a4ec3ef880a:iVhi9JWFy8C2HDEZcQbWqfLL9myuKxy8', 'Registered', 0, 0, 18, '2012-01-30 03:49:36', '2014-05-12 09:58:07', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(94, 'Trần Thanh Tâm', 'tinhanhcantho31', 'tinhanhcantho31@yahoo.com.vn', '98873d9a44fe322fc3e5f8eeb4178c0c:WLSfq6CnOl5FmdRdW5tR0CYghfIfeej1', 'Registered', 1, 0, 18, '2012-01-30 03:50:29', '2014-03-23 14:40:40', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(95, 'Huỳnh Văn Thanh', 'hvthanh', 'hvthanh@tvu.edu.vn', 'ee6e94efe7813d038b8f396dfb054b41:fzxrAd5BIzhKgW8pa6M5ROQmtu2f9r0d', 'Registered', 0, 0, 18, '2012-01-30 03:51:12', '2014-05-27 09:19:14', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(96, 'Nguyễn Ngọc Đan Thanh', 'ngocdanthanhdt', 'ngocdanthanhdt@gmail.com', '0cf4c3112f79eefe23796913cbc6a46b:zczHaa6Q43SmfxbOPzkJkvxBgOmOVS6y', 'Registered', 0, 0, 18, '2012-01-30 03:51:55', '2014-05-26 15:09:16', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(97, 'Lê Minh Tự', 'leminhtu.tvu', 'leminhtu.tvu@gmail.com', 'f28cb448cc959ae0b1603a4b79da5b76:cdMW25yfSgc6G1nwVM1PoY6dh1Xog72x', 'Registered', 0, 0, 18, '2012-01-30 03:52:35', '2014-03-12 03:31:13', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(98, 'Trịnh Quốc Việt', 'tqvietttt', 'tqvietttt@gmail.com', '3cc79d8782545686ca8ecd8a6f080d9e:kXX2BLYw7ACFr4AQIwlB4GIRJdEulGVq', 'Registered', 0, 0, 18, '2012-01-30 03:55:21', '2014-05-27 01:57:23', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(99, 'Nguyễn Thị Ngọc Mai', 'maithaophuc', 'maithaophuc@gmail.com', '676de6e77bb43c117d6a3650b5e83b12:BfLnePHemXcCB1cyixde9s5bgJ1Si8Bf', 'Registered', 1, 0, 18, '2012-01-30 03:55:58', '2014-01-07 23:23:29', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(100, 'Thạch Kọng Saoane', 'kongsaoanethach', 'kongsaoanethach@gmail.com', 'ed401c2de59133ed0af4cd30c1809203:qxaWuXIMASKKNudGiP7XkNQBMuyaTMg7', 'Registered', 1, 0, 18, '2012-01-30 03:56:51', '2014-02-20 01:59:12', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(113, 'Trịnh Thị Anh Duyên', 'trinhanhduyen89', 'trinhanhduyen89@yahoo.com.vn', 'd6b0ab7f1c8ab8f514db9a6d85de160a', 'Editor', 0, 0, 20, '2012-07-11 03:42:27', '2014-04-25 03:38:55', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(105, 'Dương Thị Chiểu', 'dtchieu', 'dtchieu@tvu.edu.vn', 'd6b0ab7f1c8ab8f514db9a6d85de160a', 'Author', 1, 0, 19, '2012-04-06 02:09:33', '2012-05-28 03:21:27', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(112, 'Phan Quốc Nghĩa', 'nghiatvnt', 'nghiatvnt@tvu.edu.vn', '55d224a87d341c8fabb52e7a5869ce42:rehiETzNypOJxIUsNj51BV5RwPDunYlE', 'Author', 1, 1, 19, '2012-07-07 08:26:37', '0000-00-00 00:00:00', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(114, 'Nguyễn Mộng Hiền', 'hientvu', 'nguyenmonghienjcu@gmail.com', '8da2932ae33e86fc2b5e463f1c5d76c5:NBqVeeIXxOeNkEm0lePTJhAROaaCNNlL', 'Registered', 0, 0, 18, '2012-08-15 03:00:17', '2014-05-27 01:54:54', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(115, 'Nhan Minh Phúc', 'nhanminhphuc', 'nhanminhphuc@gmail.com', '3c047d0f9407e7d600c06e8c26548586:jkFOIAp5INSMEqGQHVVWtlQLJTlGF1JA', 'Registered', 0, 0, 18, '2012-08-15 03:00:53', '2014-05-27 03:39:44', '', 'admin_language=\nlanguage=\neditor=\nhelpsite=\ntimezone=7\n\n', 2),
	(116, 'Nguyễn Bá Nhiệm', 'nhiemnb', 'nhiemnb@gmail.com', '82e558086a6d2d255d27b46e6342ac9a:GX4bKwJXT3aLEdCNxOjXFKz3IzoAOcBU', 'Registered', 0, 0, 18, '2013-05-04 01:48:25', '2014-04-21 03:45:16', '0b4a0c1bc6e3090b760a9480482d96c9', 'language=\ntimezone=7\n\n', 0);
/*!40000 ALTER TABLE `jos_users` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_user_lasttime_login
CREATE TABLE IF NOT EXISTS `jos_user_lasttime_login` (
  `value_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '75',
  `lasttime_login` datetime DEFAULT NULL,
  PRIMARY KEY (`value_id`),
  UNIQUE KEY `user_id_year_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='Ghi nhận lần cuối đăng nhập của từng user trong từng năm';

-- Dumping data for table lylichkhoahoc.jos_user_lasttime_login: ~2 rows (approximately)
/*!40000 ALTER TABLE `jos_user_lasttime_login` DISABLE KEYS */;
/*!40000 ALTER TABLE `jos_user_lasttime_login` ENABLE KEYS */;


-- Dumping structure for table lylichkhoahoc.jos_year
CREATE TABLE IF NOT EXISTS `jos_year` (
  `year_id` year(4) NOT NULL,
  `is_active` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`year_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Dumping data for table lylichkhoahoc.jos_year: ~0 rows (approximately)
/*!40000 ALTER TABLE `jos_year` DISABLE KEYS */;
INSERT INTO `jos_year` (`year_id`, `is_active`) VALUES
	('2015', 1);
/*!40000 ALTER TABLE `jos_year` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
