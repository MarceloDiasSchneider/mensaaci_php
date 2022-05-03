ALTER TABLE `rel_piatti_ingredienti`
MODIFY COLUMN `id_piatto` int(11) NOT NULL,
MODIFY COLUMN `id_ingrediente` int(11) NOT NULL,
ADD CONSTRAINT `FK_piatto_id`
FOREIGN KEY (`id_piatto`) REFERENCES `piatto`(`id`),
ADD CONSTRAINT FK_ingrediente_id
FOREIGN KEY (`id_ingrediente`) REFERENCES `ingredienti`(`id`);