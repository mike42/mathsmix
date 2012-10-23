-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 24, 2012 at 08:17 AM
-- Server version: 5.5.24
-- PHP Version: 5.3.10-1ubuntu3.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mathsmix`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity`
--

CREATE TABLE IF NOT EXISTS `activity` (
  `activity_id` int(11) NOT NULL AUTO_INCREMENT,
  `at_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `activity_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `activity_isgen` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`activity_id`),
  KEY `at_id` (`at_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_question`
--

CREATE TABLE IF NOT EXISTS `activity_question` (
  `aq_id` int(11) NOT NULL AUTO_INCREMENT,
  `atqm_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `aq_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `aq_content` text NOT NULL,
  PRIMARY KEY (`aq_id`),
  KEY `atqm_id` (`atqm_id`),
  KEY `activity_id` (`activity_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_question_response`
--

CREATE TABLE IF NOT EXISTS `activity_question_response` (
  `aq_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `aqr_marks` decimal(4,3) NOT NULL,
  `aqr_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `aqr_response` text NOT NULL,
  PRIMARY KEY (`aq_id`,`task_id`),
  KEY `aq_id` (`aq_id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `activity_template`
--

CREATE TABLE IF NOT EXISTS `activity_template` (
  `at_id` int(11) NOT NULL AUTO_INCREMENT,
  `at_type` varchar(32) NOT NULL,
  `at_name` text NOT NULL,
  `at_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`at_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `activity_template_qm`
--

CREATE TABLE IF NOT EXISTS `activity_template_qm` (
  `atqm_id` int(11) NOT NULL AUTO_INCREMENT,
  `at_id` int(11) NOT NULL,
  `atqm_no` int(11) NOT NULL,
  `qu_id` int(11) NOT NULL,
  `atqm_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `atqm_marks` decimal(4,3) NOT NULL,
  PRIMARY KEY (`atqm_id`),
  UNIQUE KEY `activity_template` (`at_id`,`atqm_no`),
  KEY `qu_id` (`qu_id`),
  KEY `at_id` (`at_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `attends`
--

CREATE TABLE IF NOT EXISTS `attends` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`class_id`),
  KEY `user_id` (`user_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Students in classes';

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `class_id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(256) NOT NULL,
  `yl_id` int(11) NOT NULL,
  `class_open` int(1) NOT NULL DEFAULT '0',
  `class_year` year(4) NOT NULL,
  `class_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `school_id` int(11) NOT NULL,
  PRIMARY KEY (`class_id`),
  KEY `yl_id` (`yl_id`),
  KEY `school_id` (`school_id`),
  KEY `yl_and_school` (`yl_id`,`school_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Classes' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `class_selection`
--

CREATE TABLE IF NOT EXISTS `class_selection` (
  `class_id` int(11) NOT NULL,
  `tt_id` int(11) NOT NULL,
  `yw_id` int(11) NOT NULL,
  `cs_due` datetime NOT NULL,
  `cs_visible_from` datetime NOT NULL,
  `cs_enabled` int(1) NOT NULL DEFAULT '0',
  `cs_compulsory` int(11) NOT NULL DEFAULT '1',
  `cs_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`class_id`,`tt_id`),
  KEY `yw_id` (`yw_id`),
  KEY `class_id` (`class_id`),
  KEY `tt_id` (`tt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Selection of coursework for the class to complete';

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `country_iso` varchar(2) NOT NULL COMMENT 'ISO 3166 Alpha-2 code',
  `country_name` text NOT NULL COMMENT 'Country name',
  PRIMARY KEY (`country_iso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Countries';

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
  `district_id` int(11) NOT NULL AUTO_INCREMENT,
  `district_name` text NOT NULL,
  `country_iso` varchar(2) NOT NULL,
  `district_term_count` int(2) NOT NULL,
  `district_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`district_id`),
  KEY `country_iso` (`country_iso`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Area of a country with a common curriculum' AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `domain`
--

CREATE TABLE IF NOT EXISTS `domain` (
  `domain_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_id` int(11) DEFAULT NULL,
  `domain_defaultrole` varchar(256) NOT NULL,
  `domain_host` varchar(256) NOT NULL,
  `domain_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`domain_id`),
  UNIQUE KEY `domain_host` (`domain_host`),
  KEY `school_id` (`school_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Domain names which are in use' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `format_option`
--

CREATE TABLE IF NOT EXISTS `format_option` (
  `qv_id` int(11) NOT NULL,
  `qm_id` int(11) NOT NULL,
  PRIMARY KEY (`qv_id`,`qm_id`),
  KEY `qv_id` (`qv_id`),
  KEY `qm_id` (`qm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `question_maker`
--

CREATE TABLE IF NOT EXISTS `question_maker` (
  `qm_id` int(11) NOT NULL AUTO_INCREMENT,
  `qm_name` text NOT NULL,
  `qm_class` varchar(256) NOT NULL,
  `qm_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`qm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_usage`
--

CREATE TABLE IF NOT EXISTS `question_usage` (
  `qu_id` int(11) NOT NULL AUTO_INCREMENT,
  `qu_comment` text NOT NULL,
  `qv_id` int(11) NOT NULL,
  `qu_content` text NOT NULL,
  `qm_id` int(11) NOT NULL,
  `qu_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`qu_id`),
  KEY `qm_id` (`qm_id`),
  KEY `qv_id` (`qv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores ways of using QuestionMakers' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `question_viewer`
--

CREATE TABLE IF NOT EXISTS `question_viewer` (
  `qv_id` int(11) NOT NULL,
  `qv_name` text NOT NULL,
  `qv_class` varchar(256) NOT NULL,
  `qv_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`qv_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

CREATE TABLE IF NOT EXISTS `school` (
  `school_id` int(11) NOT NULL AUTO_INCREMENT,
  `school_name` text NOT NULL,
  `school_location` text NOT NULL,
  `school_tz` varchar(256) NOT NULL COMMENT 'Timezone identifier for PHP',
  `school_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `district_id` int(11) NOT NULL,
  PRIMARY KEY (`school_id`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Schools' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE IF NOT EXISTS `tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `tag_name` text NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tag_qm`
--

CREATE TABLE IF NOT EXISTS `tag_qm` (
  `qm_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`qm_id`,`tag_id`),
  KEY `qm_id` (`qm_id`),
  KEY `tag_id` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `task_due` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `task_complete` int(1) NOT NULL,
  `task_grade` decimal(4,3) NOT NULL,
  `yw_id` int(11) NOT NULL,
  `activity_id` int(11) NOT NULL,
  `tt_id` int(11) NOT NULL,
  PRIMARY KEY (`task_id`),
  KEY `activity_id` (`activity_id`),
  KEY `tt_id` (`tt_id`),
  KEY `user_id` (`user_id`),
  KEY `yw_id` (`yw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `task_template`
--

CREATE TABLE IF NOT EXISTS `task_template` (
  `tt_id` int(11) NOT NULL AUTO_INCREMENT,
  `at_id` int(11) NOT NULL,
  `yl_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `tt_name` text NOT NULL,
  `tt_week` int(2) NOT NULL,
  `tt_sequence` int(11) NOT NULL,
  `tt_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tt_public` int(1) NOT NULL DEFAULT '0',
  `tt_shared` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tt_id`),
  KEY `at_id` (`at_id`),
  KEY `yl_id` (`yl_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Task templates for a given year level' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `teaches`
--

CREATE TABLE IF NOT EXISTS `teaches` (
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`class_id`),
  KEY `user_id` (`user_id`),
  KEY `class_id` (`class_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Teachers in charge of classes';

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_firstname` text NOT NULL,
  `user_surname` text NOT NULL,
  `user_email` varchar(256) NOT NULL,
  `domain_id` int(11) NOT NULL,
  `user_password` varchar(256) NOT NULL,
  `user_salt` varchar(256) NOT NULL,
  `user_role` varchar(256) NOT NULL,
  `user_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`),
  KEY `domain_id` (`domain_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='User information' AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `year_level`
--

CREATE TABLE IF NOT EXISTS `year_level` (
  `yl_id` int(11) NOT NULL AUTO_INCREMENT,
  `yl_name` varchar(256) NOT NULL,
  `yl_level` int(2) NOT NULL,
  `district_id` int(11) NOT NULL,
  `yl_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`yl_id`),
  UNIQUE KEY `yl_level` (`yl_level`,`district_id`),
  UNIQUE KEY `yl_name` (`yl_name`,`district_id`),
  KEY `district_id` (`district_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Year levels within a district' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `year_week`
--

CREATE TABLE IF NOT EXISTS `year_week` (
  `yw_id` int(11) NOT NULL AUTO_INCREMENT,
  `yw_year` year(4) NOT NULL,
  `yw_week` int(2) NOT NULL,
  `yw_start` datetime NOT NULL,
  `yw_end` datetime NOT NULL,
  PRIMARY KEY (`yw_id`),
  UNIQUE KEY `yw_yearwk` (`yw_year`,`yw_week`),
  KEY `yw_year` (`yw_year`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Listing of dates for weeks of the year' AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity`
--
ALTER TABLE `activity`
  ADD CONSTRAINT `activity_ibfk_1` FOREIGN KEY (`at_id`) REFERENCES `activity_template` (`at_id`),
  ADD CONSTRAINT `activity_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `activity_question`
--
ALTER TABLE `activity_question`
  ADD CONSTRAINT `activity_question_ibfk_1` FOREIGN KEY (`atqm_id`) REFERENCES `activity_template_qm` (`atqm_id`),
  ADD CONSTRAINT `activity_question_ibfk_2` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`);

--
-- Constraints for table `activity_question_response`
--
ALTER TABLE `activity_question_response`
  ADD CONSTRAINT `activity_question_response_ibfk_1` FOREIGN KEY (`aq_id`) REFERENCES `activity_question` (`aq_id`),
  ADD CONSTRAINT `activity_question_response_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `task` (`task_id`);

--
-- Constraints for table `activity_template`
--
ALTER TABLE `activity_template`
  ADD CONSTRAINT `activity_template_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `activity_template_qm`
--
ALTER TABLE `activity_template_qm`
  ADD CONSTRAINT `activity_template_qm_ibfk_1` FOREIGN KEY (`at_id`) REFERENCES `activity_template` (`at_id`),
  ADD CONSTRAINT `activity_template_qm_ibfk_2` FOREIGN KEY (`qu_id`) REFERENCES `question_usage` (`qu_id`);

--
-- Constraints for table `attends`
--
ALTER TABLE `attends`
  ADD CONSTRAINT `attends_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `attends_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`yl_id`) REFERENCES `year_level` (`yl_id`),
  ADD CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`);

--
-- Constraints for table `class_selection`
--
ALTER TABLE `class_selection`
  ADD CONSTRAINT `class_selection_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`),
  ADD CONSTRAINT `class_selection_ibfk_2` FOREIGN KEY (`tt_id`) REFERENCES `task_template` (`tt_id`),
  ADD CONSTRAINT `class_selection_ibfk_3` FOREIGN KEY (`yw_id`) REFERENCES `year_week` (`yw_id`);

--
-- Constraints for table `district`
--
ALTER TABLE `district`
  ADD CONSTRAINT `district_ibfk_1` FOREIGN KEY (`country_iso`) REFERENCES `country` (`country_iso`) ON UPDATE CASCADE;

--
-- Constraints for table `domain`
--
ALTER TABLE `domain`
  ADD CONSTRAINT `domain_ibfk_2` FOREIGN KEY (`school_id`) REFERENCES `school` (`school_id`) ON DELETE SET NULL;

--
-- Constraints for table `format_option`
--
ALTER TABLE `format_option`
  ADD CONSTRAINT `format_option_ibfk_1` FOREIGN KEY (`qv_id`) REFERENCES `question_viewer` (`qv_id`),
  ADD CONSTRAINT `format_option_ibfk_2` FOREIGN KEY (`qm_id`) REFERENCES `question_maker` (`qm_id`);

--
-- Constraints for table `question_usage`
--
ALTER TABLE `question_usage`
  ADD CONSTRAINT `question_usage_ibfk_1` FOREIGN KEY (`qv_id`) REFERENCES `question_viewer` (`qv_id`),
  ADD CONSTRAINT `question_usage_ibfk_2` FOREIGN KEY (`qm_id`) REFERENCES `question_maker` (`qm_id`);

--
-- Constraints for table `school`
--
ALTER TABLE `school`
  ADD CONSTRAINT `school_ibfk_4` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`);

--
-- Constraints for table `tag_qm`
--
ALTER TABLE `tag_qm`
  ADD CONSTRAINT `tag_qm_ibfk_1` FOREIGN KEY (`qm_id`) REFERENCES `question_maker` (`qm_id`),
  ADD CONSTRAINT `tag_qm_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`tag_id`);

--
-- Constraints for table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `task_ibfk_4` FOREIGN KEY (`activity_id`) REFERENCES `activity` (`activity_id`),
  ADD CONSTRAINT `task_ibfk_5` FOREIGN KEY (`tt_id`) REFERENCES `task_template` (`tt_id`),
  ADD CONSTRAINT `task_ibfk_6` FOREIGN KEY (`yw_id`) REFERENCES `year_week` (`yw_id`);

--
-- Constraints for table `task_template`
--
ALTER TABLE `task_template`
  ADD CONSTRAINT `task_template_ibfk_1` FOREIGN KEY (`at_id`) REFERENCES `activity_template` (`at_id`),
  ADD CONSTRAINT `task_template_ibfk_2` FOREIGN KEY (`yl_id`) REFERENCES `year_level` (`yl_id`),
  ADD CONSTRAINT `task_template_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Constraints for table `teaches`
--
ALTER TABLE `teaches`
  ADD CONSTRAINT `teaches_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teaches_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`class_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`domain_id`) REFERENCES `domain` (`domain_id`);

--
-- Constraints for table `year_level`
--
ALTER TABLE `year_level`
  ADD CONSTRAINT `year_level_ibfk_1` FOREIGN KEY (`district_id`) REFERENCES `district` (`district_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
