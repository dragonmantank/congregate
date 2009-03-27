ALTER TABLE `p_Projects` ADD `slug` VARCHAR( 255 ) NOT NULL AFTER `name`;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
