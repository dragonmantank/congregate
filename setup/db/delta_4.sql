-- phpMyAdmin SQL Dump
-- version 3.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 31, 2009 at 06:45 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `biffpm-dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `bc_BugCategories`
--

CREATE TABLE IF NOT EXISTS `bc_BugCategories` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `bc_BugCategories`
--

INSERT INTO `bc_BugCategories` (`id`, `name`) VALUES
(1, 'Operational Bug'),
(2, 'Program Bug'),
(3, 'Task'),
(4, 'User Interface Bug');

-- --------------------------------------------------------

--
-- Table structure for table `bn_BugsNotes`
--

CREATE TABLE IF NOT EXISTS `bn_BugsNotes` (
  `id` int(11) NOT NULL auto_increment,
  `bugId` int(11) NOT NULL,
  `author` int(11) NOT NULL,
  `note` text NOT NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `bn_BugsNotes`
--


-- --------------------------------------------------------

--
-- Table structure for table `bp_BugPriority`
--

CREATE TABLE IF NOT EXISTS `bp_BugPriority` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `bp_BugPriority`
--

INSERT INTO `bp_BugPriority` (`id`, `name`, `weight`) VALUES
(1, 'None', 0),
(2, 'Low', 10),
(3, 'Normal', 20),
(4, 'High', 30),
(5, 'Urgent', 40),
(6, 'Immediate', 100);

-- --------------------------------------------------------

--
-- Table structure for table `bs_BugSeverity`
--

CREATE TABLE IF NOT EXISTS `bs_BugSeverity` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `weight` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `bs_BugSeverity`
--

INSERT INTO `bs_BugSeverity` (`id`, `name`, `weight`) VALUES
(1, 'Feature', 80),
(2, 'Trivial', 70),
(3, 'Text', 60),
(4, 'Tweak', 50),
(5, 'Minor', 40),
(6, 'Major', 30),
(7, 'Block', 20),
(8, 'Crash', 1);

-- --------------------------------------------------------

--
-- Table structure for table `b_Bugs`
--

CREATE TABLE IF NOT EXISTS `b_Bugs` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `categoryId` int(11) NOT NULL,
  `reproducibility` tinyint(1) NOT NULL,
  `severityId` int(11) NOT NULL,
  `priorityId` int(11) NOT NULL,
  `summary` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `additionalInfo` text NOT NULL,
  `steps` text NOT NULL,
  `reporter` int(11) NOT NULL,
  `assignedTo` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `status` varchar(50) NOT NULL default 'New',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `b_Bugs`
--

