-- phpMyAdmin SQL Dump
-- version 3.0.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 19, 2008 at 05:04 PM
-- Server version: 5.0.51
-- PHP Version: 5.2.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `taskmanager`
--

-- --------------------------------------------------------

--
-- Table structure for table `Projects`
--

CREATE TABLE IF NOT EXISTS `Projects` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `Tasks`
--

CREATE TABLE IF NOT EXISTS `Tasks` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `feature` varchar(255) NOT NULL,
  `tmid` varchar(50) NOT NULL,
  `task` text NOT NULL,
  `priority` int(11) NOT NULL,
  `origEst` float NOT NULL,
  `currEst` float NOT NULL,
  `elapsed` float NOT NULL,
  `completed` tinyint(1) NOT NULL,
  `completedBy` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
