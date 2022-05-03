DROP TABLE `rel_utente_giorno_piatti`;

CREATE TABLE `rel_prenotazione_piatti` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_prenotazione` int(11) NOT NULL,
  `id_piatto` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`id_prenotazione`) REFERENCES prenotazione(`id`),
  FOREIGN KEY (`id_piatto`) REFERENCES piatto(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
