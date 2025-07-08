-- SQL untuk membuat tabel tb_area
-- Jalankan query ini di database Anda
CREATE TABLE
  IF NOT EXISTS `tb_area` (
    `id` int (11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
  ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_general_ci;

-- Insert data contoh (opsional)
INSERT INTO
  `tb_area` (`name`)
VALUES
  ('Jakarta Pusat'),
  ('Jakarta Selatan'),
  ('Jakarta Utara'),
  ('Jakarta Barat'),
  ('Jakarta Timur');