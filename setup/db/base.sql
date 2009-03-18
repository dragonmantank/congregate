-- phpMyAdmin SQL Dump
-- version 3.1.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 18, 2009 at 10:30 PM
-- Server version: 5.0.45
-- PHP Version: 5.2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `biffpm-dev`
--

-- --------------------------------------------------------

--
-- Table structure for table `g_Groups`
--

CREATE TABLE IF NOT EXISTS `g_Groups` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `level` tinyint(4) NOT NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `g_Groups`
--


-- --------------------------------------------------------

--
-- Table structure for table `p_Projects`
--

CREATE TABLE IF NOT EXISTS `p_Projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `p_Projects`
--


-- --------------------------------------------------------

--
-- Table structure for table `sdd_SoftwareDesignDescription`
--

CREATE TABLE IF NOT EXISTS `sdd_SoftwareDesignDescription` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `designOverview` text NOT NULL,
  `chosenArchitecture` text NOT NULL,
  `alternateDesigns` text NOT NULL,
  `systemInterfaceDescription` text NOT NULL,
  `componentDescription` text,
  `userInterfaceDescription` text NOT NULL,
  `additionalMaterial` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sdd_SoftwareDesignDescription`
--


-- --------------------------------------------------------

--
-- Table structure for table `sig_Signatures`
--

CREATE TABLE IF NOT EXISTS `sig_Signatures` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `signature` varchar(100) NOT NULL,
  `date` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `sig_Signatures`
--


-- --------------------------------------------------------

--
-- Table structure for table `t_Tasks`
--

CREATE TABLE IF NOT EXISTS `t_Tasks` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `feature` varchar(100) NOT NULL,
  `priority` tinyint(4) NOT NULL,
  `task` text NOT NULL,
  `estimateOrig` tinyint(4) NOT NULL,
  `estimateCurrent` tinyint(4) NOT NULL,
  `elapsed` tinyint(4) NOT NULL,
  `remaining` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  `completedBy` varchar(100) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `t_Tasks`
--


-- --------------------------------------------------------

--
-- Table structure for table `ug_UserGroups`
--

CREATE TABLE IF NOT EXISTS `ug_UserGroups` (
  `id` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `groupId` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `ug_UserGroups`
--


-- --------------------------------------------------------

--
-- Table structure for table `up_UserProjects`
--

CREATE TABLE IF NOT EXISTS `up_UserProjects` (
  `id` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `up_UserProjects`
--


-- --------------------------------------------------------

--
-- Table structure for table `u_Users`
--

CREATE TABLE IF NOT EXISTS `u_Users` (
  `id` int(11) NOT NULL auto_increment,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `primaryGroup` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dateActivated` timestamp NOT NULL default '0000-00-00 00:00:00',
  `status` tinyint(4) NOT NULL default '-1',
  `challenge` varchar(50) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `username` (`username`,`name`,`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `u_Users`
--

INSERT INTO `u_Users` (`id`, `username`, `password`, `name`, `email`, `primaryGroup`, `dateCreated`, `dateActivated`, `status`, `challenge`) VALUES
(1, 'root@domain.com', 'bef3452591febf751a9333de927f2d9c', 'Root', 'root@domain.com', 1, '2009-03-18 18:09:47', '2009-03-18 00:00:00', 1, '');
