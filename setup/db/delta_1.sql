CREATE TABLE IF NOT EXISTS `sddc_SDDComponents` (
  `id` int(11) NOT NULL,
  `sddId` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;