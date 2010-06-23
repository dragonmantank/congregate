-- phpMyAdmin SQL Dump
-- version 3.1.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 06, 2009 at 03:06 PM
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


-- --------------------------------------------------------

--
-- Table structure for table `fc_FilesComments`
--

CREATE TABLE IF NOT EXISTS `fc_FilesComments` (
  `id` int(11) NOT NULL auto_increment,
  `fileId` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `fc_FilesComments`
--


-- --------------------------------------------------------

--
-- Table structure for table `fd_FilesDetail`
--

CREATE TABLE IF NOT EXISTS `fd_FilesDetail` (
  `id` int(11) NOT NULL auto_increment,
  `fileId` int(11) NOT NULL,
  `fsFilename` varchar(255) NOT NULL,
  `mimetype` varchar(50) NOT NULL,
  `size` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `fd_FilesDetail`
--


-- --------------------------------------------------------

--
-- Table structure for table `f_Files`
--

CREATE TABLE IF NOT EXISTS `f_Files` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `directory` varchar(255) NOT NULL,
  `originalAuthor` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `detailId` int(11) NOT NULL,
  `revision` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `projectId` (`projectId`,`section`,`filename`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `f_Files`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `g_Groups`
--

INSERT INTO `g_Groups` (`id`, `name`, `level`, `dateCreated`) VALUES
(1, 'root', 0, '2009-03-27 19:07:27'),
(2, 'Project Manager', 1, '2009-03-27 19:07:49'),
(3, 'User', 99, '2009-03-27 19:08:29');

-- --------------------------------------------------------

--
-- Table structure for table `nt_NotesText`
--

CREATE TABLE IF NOT EXISTS `nt_NotesText` (
  `id` int(11) NOT NULL auto_increment,
  `noteId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `dateAdded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `nt_NotesText`
--


-- --------------------------------------------------------

--
-- Table structure for table `n_Notes`
--

CREATE TABLE IF NOT EXISTS `n_Notes` (
  `id` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `dateAdded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `private` tinyint(1) NOT NULL default '1',
  `readOnly` tinyint(1) NOT NULL default '0',
  `currentRev` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `n_Notes`
--


-- --------------------------------------------------------

--
-- Table structure for table `psig_ProjectSignatures`
--

CREATE TABLE IF NOT EXISTS `psig_ProjectSignatures` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `signatureId` int(11) NOT NULL,
  `captured` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `psig_ProjectSignatures`
--


-- --------------------------------------------------------

--
-- Table structure for table `ps_ProjectSections`
--

CREATE TABLE IF NOT EXISTS `ps_ProjectSections` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `ps_ProjectSections`
--

INSERT INTO `ps_ProjectSections` (`id`, `name`) VALUES
(1, 'Approval'),
(2, 'Software Design'),
(3, 'Design'),
(4, 'Implementation'),
(5, 'Debugging'),
(6, 'Installation'),
(7, 'Maintenance');

-- --------------------------------------------------------

--
-- Table structure for table `p_Projects`
--

CREATE TABLE IF NOT EXISTS `p_Projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) NOT NULL default '1',
  `author` int(11) NOT NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dateApproved` timestamp NOT NULL default '0000-00-00 00:00:00',
  `dateDeclined` timestamp NOT NULL default '0000-00-00 00:00:00',
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
  `section` varchar(20) NOT NULL,
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
  `priority` double NOT NULL,
  `task` text NOT NULL,
  `estimateOrig` tinyint(4) NOT NULL,
  `estimateCurrent` tinyint(4) NOT NULL,
  `elapsed` tinyint(4) NOT NULL,
  `remaining` tinyint(4) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  `completedBy` varchar(100) default NULL,
  `dateCreated` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `dateCompleted` timestamp NOT NULL default '0000-00-00 00:00:00',
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
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `name_2` (`name`),
  UNIQUE KEY `name_3` (`name`),
  UNIQUE KEY `name_4` (`name`),
  UNIQUE KEY `name_5` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `u_Users`
--

INSERT INTO `u_Users` (`id`, `username`, `password`, `name`, `email`, `primaryGroup`, `dateCreated`, `dateActivated`, `status`, `challenge`) VALUES
(1, 'root', 'bef3452591febf751a9333de927f2d9c', 'Root User', 'root@domain.com', 1, '2009-03-18 18:09:47', '2009-03-18 00:00:00', 1, '');
