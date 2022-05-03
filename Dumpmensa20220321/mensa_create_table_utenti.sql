CREATE TABLE `utenti` (
  `id` int(11) NOT NULL AUTO_INCREMENT ,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(100) NOT NULL,
  `google_sub_id` int(11),
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodouble_mail` (`email`),
  UNIQUE KEY `nodouble_google_sub_id` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
