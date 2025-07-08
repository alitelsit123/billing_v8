

CREATE TABLE `riwayat_backupdb` (
  `id_backup` int(11) NOT NULL AUTO_INCREMENT,
  `nama_db` text NOT NULL,
  `tanggal` date NOT NULL,
  PRIMARY KEY (`id_backup`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tb_kas` (
  `id_kas` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) DEFAULT NULL,
  `tgl_kas` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `penerimaan` int(11) DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT NULL,
  `jenis_kas` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_tagihan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kas`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_kas VALUES("1","","2024-06-15","Pembayaran Internet AN.&nbspWisky Sumenda,&nbspPaket&nbsp5 Mbps","250000","","","","1");



CREATE TABLE `tb_kas2` (
  `id_kas` int(11) NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(11) DEFAULT NULL,
  `tgl_kas` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `penerimaan` int(11) DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT NULL,
  `jenis_kas` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_tagihan` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_kas`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;




CREATE TABLE `tb_paket` (
  `id_paket` int(11) NOT NULL AUTO_INCREMENT,
  `nama_paket` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `ppn` decimal(10,2) DEFAULT NULL,
  `id_pmikrotik` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_paket`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_paket VALUES("26","5 Mbps","250000","0.10","");
INSERT INTO tb_paket VALUES("27","10 Mbps","300000","","");
INSERT INTO tb_paket VALUES("28","15Mbps","350000","","");



CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT,
  `kode_pelanggan` varchar(30) NOT NULL,
  `nik` varchar(18) DEFAULT NULL,
  `nama_pelanggan` varchar(255) NOT NULL,
  `alamat` varchar(255) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `paket` int(11) NOT NULL,
  `ip_address` varchar(255) DEFAULT NULL,
  `tgl_pemasangan` datetime NOT NULL,
  `jatuh_tempo` datetime NOT NULL DEFAULT current_timestamp(),
  `location` varchar(255) DEFAULT NULL,
  `id_perangkat` varchar(11) DEFAULT NULL,
  `odp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_pelanggan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_pelanggan VALUES("1","WNG031001","","Wisky Sumenda","","089612345678","26","","2024-06-15 08:36:00","2024-08-15 08:38:33","1.218248, 124.603627","","1");



CREATE TABLE `tb_perangkat` (
  `id_perangkat` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perangkat` text NOT NULL,
  PRIMARY KEY (`id_perangkat`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tb_perangkat VALUES("1","121");



CREATE TABLE `tb_profile` (
  `id_profile` int(11) NOT NULL AUTO_INCREMENT,
  `nama_sekolah` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telpon` varchar(20) NOT NULL,
  `website` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `bendahara` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `ktu` varchar(255) NOT NULL,
  `nip_ktu` varchar(30) NOT NULL,
  PRIMARY KEY (`id_profile`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_profile VALUES("1","TAGIHAN INTERNET","Jl. Kebayoran","021.090939","www.sekolah.com","Jakarta","Bejo Santoso","1968890993933434","LOGO L-ONE NETWORK.png","ABDUL MUIS","343434343434");



CREATE TABLE `tb_tagihan` (
  `id_tagihan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) NOT NULL,
  `bulan_tahun` varchar(30) NOT NULL,
  `jml_bayar` int(11) NOT NULL,
  `terbayar` int(11) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL,
  `status_bayar` int(11) DEFAULT NULL,
  `no_invoice` varchar(100) DEFAULT NULL,
  `blokir_status` int(11) DEFAULT NULL,
  `terkirim` enum('belum','terkirim') NOT NULL,
  `waktu_bayar` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_tagihan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_tagihan VALUES("1","1","062024","250000","250000","2024-06-15","1","00001.BLR.MST.","","belum","2024-06-15 08:38:33","124");



CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(30) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO tb_user VALUES("2","admin","admin","admin","admin","title.png","","123456778");
INSERT INTO tb_user VALUES("124","kasir1","Jen","kasir1","kasir","default.png","","0000");
INSERT INTO tb_user VALUES("125","OP23122001","Wisky Sumenda","OP23122001","user","admin.png","1","");
INSERT INTO tb_user VALUES("126","teknisi","teknisi","teknisi","teknisi","default.png","","000");



CREATE TABLE `tbl_badmin` (
  `id_badmin` int(11) NOT NULL AUTO_INCREMENT,
  `harga` varchar(255) DEFAULT NULL,
  `status` enum('saya','pelanggan') NOT NULL,
  PRIMARY KEY (`id_badmin`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO tbl_badmin VALUES("1","2000","pelanggan");



CREATE TABLE `tbl_blokir` (
  `id_blokir` int(11) NOT NULL AUTO_INCREMENT,
  `status_blokir` enum('aktif','tidakaktif') NOT NULL,
  `set_waktu` int(11) DEFAULT NULL,
  `set_waktu2` varchar(30) DEFAULT NULL,
  `pesan_blokir` text DEFAULT NULL,
  PRIMARY KEY (`id_blokir`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_blokir VALUES("1","aktif","1","minutes","$nama : Untuk Mengambil Nama Pelanggan
$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo
$tagihan : Untuk Mengambil Harga 
$no_telp : Untuk Mengambil Nomor Telepon Pelanggan
$sekarang_format : Untuk Mendapatkan Waktu Sekarang");



CREATE TABLE `tbl_bukablokir` (
  `id_bukablokir` int(11) NOT NULL AUTO_INCREMENT,
  `pesan_bukablokir` text DEFAULT NULL,
  PRIMARY KEY (`id_bukablokir`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_bukablokir VALUES("1","$nama : Untuk Mengambil Nama Pelanggan
$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo
$tagihan : Untuk Mengambil Harga 
$no_telp : Untuk Mengambil Nomor Telepon Pelanggan
$harinin : Untuk Mengambil Waktu dan Tanggal Hari Ini
");



CREATE TABLE `tbl_buktibayar` (
  `id_buktibayar` int(11) NOT NULL AUTO_INCREMENT,
  `id_rekening` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  `gambar` text NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_terima` datetime NOT NULL,
  PRIMARY KEY (`id_buktibayar`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_informasi` (
  `id_informasi` int(11) NOT NULL AUTO_INCREMENT,
  `judul_informasi` varchar(255) NOT NULL,
  `isi_informasi` text NOT NULL,
  PRIMARY KEY (`id_informasi`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_keluhan` (
  `id_keluhan` int(11) NOT NULL AUTO_INCREMENT,
  `id_pelanggan` int(11) NOT NULL,
  `judul_keluhan` varchar(50) NOT NULL,
  `nomor_tiket` varchar(255) NOT NULL,
  `isi_keluhan` text NOT NULL,
  `gambar` text NOT NULL,
  `masalah` text DEFAULT NULL,
  `no_wa` varchar(15) NOT NULL,
  `status_keluhan` enum('menunggu','proses','selesai','tidak merespon') NOT NULL,
  `tanggal` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_keluhan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_mikrotik` (
  `id_mikrotik` int(11) NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port_mikrotik` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_mikrotik`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_nomorphone` (
  `id_mynumber` int(11) NOT NULL AUTO_INCREMENT,
  `my_number` varchar(15) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL,
  PRIMARY KEY (`id_mynumber`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_notif` (
  `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT,
  `status_notifikasi` enum('aktif','tidakaktif') NOT NULL,
  `pesan_notifikasi` text NOT NULL,
  PRIMARY KEY (`id_notifikasi`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_notif VALUES("1","aktif","$nama : Untuk Mengambil Nama Pelanggan
$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo
$tagihan : Untuk Mengambil Harga 
$no_telp : Untuk Mengambil Nomor Telepon Pelanggan");



CREATE TABLE `tbl_notifbayar` (
  `id_notifbayar` int(11) NOT NULL AUTO_INCREMENT,
  `pesan_bayar` text NOT NULL,
  PRIMARY KEY (`id_notifbayar`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_notifbayar VALUES("1","$nama : Untuk Mengambil Nama Pelanggan
$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo
$tagihan : Untuk Mengambil Harga 
$no_telp : Untuk Mengambil Nomor Telepon Pelanggan
$harinin : Untuk Mengambil Waktu dan Tanggal Hari Ini
");



CREATE TABLE `tbl_npemasangan` (
  `id_npemasangan` int(11) NOT NULL AUTO_INCREMENT,
  `status_notif` enum('aktif','tidak') NOT NULL,
  `pesan_notif` text NOT NULL,
  PRIMARY KEY (`id_npemasangan`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_npemasangan VALUES("1","aktif","$nama : Untuk Mengambil Nama Pelanggan
$alamat : Untuk Mengambil Alamat Pelanggan
$no_telp : Untuk Mengambil Nomor Telepon Pelanggan
$paket : Untuk Mengambil Paket Pilihan Pelanggan
$tgl_pemasangan : Untuk Mengambil Tanggal Pemasangan Pelanggan
                           ");



CREATE TABLE `tbl_odc` (
  `id_odc` int(11) NOT NULL AUTO_INCREMENT,
  `nama_odc` varchar(255) NOT NULL,
  `perangkat_odc` varchar(50) NOT NULL,
  `port_odc` varchar(30) NOT NULL,
  `location` text NOT NULL,
  PRIMARY KEY (`id_odc`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_odc VALUES("1","ODC Timur","ODC1","10","1.222469, 124.603221");
INSERT INTO tbl_odc VALUES("2","ODC Barat","ODC2","10","1.220302, 124.600958");
INSERT INTO tbl_odc VALUES("3","Odc 1","Odc","8","-7.737083, 110.681605");



CREATE TABLE `tbl_odp` (
  `id_odp` int(11) NOT NULL AUTO_INCREMENT,
  `nama_odp` varchar(255) NOT NULL,
  `port_odp` varchar(30) NOT NULL,
  `location` varchar(255) NOT NULL,
  `odc` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_odp`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_odp VALUES("1","ODP1","8","","1");
INSERT INTO tbl_odp VALUES("2","ODP2","8","","2");
INSERT INTO tbl_odp VALUES("3","Kretek","8","-7.737761, 110.684293","3");



CREATE TABLE `tbl_paketmikrotik` (
  `id_paketmikrotik` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ya','tidak') NOT NULL,
  `ppn` enum('aktif','tidak') DEFAULT NULL,
  PRIMARY KEY (`id_paketmikrotik`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_paketmikrotik VALUES("1","tidak","aktif");



CREATE TABLE `tbl_penggunamikrotik` (
  `id_penggunamikrotik` int(11) NOT NULL AUTO_INCREMENT,
  `status` enum('ya','tidak') NOT NULL,
  `addppsecret` enum('ya','tidak') NOT NULL,
  `ippelanggan` enum('statik','dynamic') NOT NULL,
  `mapping` enum('aktif','tidak') DEFAULT NULL,
  `ip_pool` enum('ya','tidak') DEFAULT NULL,
  PRIMARY KEY (`id_penggunamikrotik`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO tbl_penggunamikrotik VALUES("1","tidak","tidak","dynamic","aktif","tidak");



CREATE TABLE `tbl_pengumuman` (
  `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT,
  `isi_pengumuman` text NOT NULL,
  PRIMARY KEY (`id_pengumuman`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_pesan_siaran` (
  `id_pesan_siaran` int(11) NOT NULL AUTO_INCREMENT,
  `judul_pesan_siaran` varchar(255) NOT NULL,
  `isi_pesan` text NOT NULL,
  PRIMARY KEY (`id_pesan_siaran`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_pgate` (
  `id_pgat` int(11) NOT NULL AUTO_INCREMENT,
  `tclientkey` varchar(255) DEFAULT NULL,
  `tserverkey` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pgat`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;




CREATE TABLE `tbl_rekening` (
  `id_rekening` int(11) NOT NULL AUTO_INCREMENT,
  `nama_bank` varchar(50) NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL,
  PRIMARY KEY (`id_rekening`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;




CREATE TABLE `tbl_token` (
  `id_token` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  PRIMARY KEY (`id_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


