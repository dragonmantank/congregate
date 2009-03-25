CREATE TABLE IF NOT EXISTS `nt_NotesText` (
  `id` int(11) NOT NULL auto_increment,
  `noteId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `dateAdded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `author` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `n_Notes`
--

CREATE TABLE IF NOT EXISTS `n_Notes` (
  `id` int(11) NOT NULL auto_increment,
  `userId` int(11) NOT NULL,
  `projectId` int(11) NOT NULL,
  `section` varchar(50) NOT NULL,
  `dateAdded` timestamp NOT NULL default CURRENT_TIMESTAMP,
  `private` tinyint(1) NOT NULL default '1',
  `readOnly` tinyint(1) NOT NULL default '0',
  `currentRev` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;