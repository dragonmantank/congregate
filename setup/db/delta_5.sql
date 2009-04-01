CREATE TABLE IF NOT EXISTS `psig_ProjectSignatures` (
  `id` int(11) NOT NULL auto_increment,
  `projectId` int(11) NOT NULL,
  `sectionId` int(11) NOT NULL,
  `signatureId` int(11) NOT NULL,
  `captured` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;