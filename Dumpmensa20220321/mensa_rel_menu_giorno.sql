CREATE TABLE `rel_menu_giorno` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `id_menu` int(11) NOT NULL,
  `giorno` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodouble` (`id_menu`,`giorno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
