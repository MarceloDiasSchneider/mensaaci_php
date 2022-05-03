CREATE TABLE `prenotazione` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_utente` int(11) NOT NULL,
  `giorno` datetime NOT NULL,
  `note_takeaway` varchar(255),
  `turno` int(11) NOT NULL,
  `takeaway` int(11) NOT NULL,
  `consumazione` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodouble` (`id_utente`,`giorno`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
