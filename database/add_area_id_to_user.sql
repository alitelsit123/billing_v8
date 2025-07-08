-- SQL untuk menambahkan kolom area_id ke tabel tb_user
-- Jalankan query ini di database Anda setelah membuat tabel tb_area
-- Menambahkan kolom area_id ke tabel tb_user
ALTER TABLE `tb_user`
ADD COLUMN `area_id` int (11) NULL AFTER `level`,
ADD INDEX `fk_area_id` (`area_id`),
ADD CONSTRAINT `fk_user_area` FOREIGN KEY (`area_id`) REFERENCES `tb_area` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Update data yang sudah ada (opsional - set area_id ke NULL untuk data existing)
-- UPDATE `tb_user` SET `area_id` = NULL WHERE `area_id` IS NULL;