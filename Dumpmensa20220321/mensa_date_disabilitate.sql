DROP TABLE IF EXISTS `disabled_dates`;
CREATE TABLE `disabled_dates` (
  `id` int NOT NULL AUTO_INCREMENT,
  `disabled_date` date NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nodouble` (`disabled_date`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci ;
