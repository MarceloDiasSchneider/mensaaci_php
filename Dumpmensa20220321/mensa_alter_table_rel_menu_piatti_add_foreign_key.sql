ALTER TABLE `rel_menu_piatti`
MODIFY COLUMN `id_menu` int(11) NOT NULL,
MODIFY COLUMN `id_piatto` int(11) NOT NULL,
ADD CONSTRAINT `FK_menu_id`
FOREIGN KEY (`id_menu`) REFERENCES `menu`(`id`),
ADD CONSTRAINT `FK_piatto_id_t`
FOREIGN KEY (`id_piatto`) REFERENCES `piatto`(`id`);