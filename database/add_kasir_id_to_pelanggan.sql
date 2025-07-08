-- SQL untuk menambahkan kolom kasir_id ke tabel tb_pelanggan
-- Jalankan query ini di database Anda setelah membuat tabel tb_area dan menambahkan area_id ke tb_user
-- Menambahkan kolom kasir_id ke tabel tb_pelanggan
ALTER TABLE `tb_pelanggan`
ADD COLUMN `kasir_id` int (11) NULL,
ADD INDEX `fk_kasir_id` (`kasir_id`),
ADD CONSTRAINT `fk_pelanggan_kasir` FOREIGN KEY (`kasir_id`) REFERENCES `tb_user` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

-- Update data yang sudah ada (opsional - set kasir_id ke NULL untuk data existing)
-- UPDATE `tb_pelanggan` SET `kasir_id` = NULL WHERE `kasir_id` IS NULL;