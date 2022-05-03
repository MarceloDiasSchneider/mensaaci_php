ALTER TABLE `rel_menu_giorno`
ADD CONSTRAINT `FK_menu_id_t`
FOREIGN KEY (`id_menu`) REFERENCES `menu`(`id`);