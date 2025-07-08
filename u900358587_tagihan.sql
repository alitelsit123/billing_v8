-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 23, 2024 at 05:02 AM
-- Server version: 10.11.9-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u900358587_tagihan`
--

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_backupdb`
--

CREATE TABLE `riwayat_backupdb` (
  `id_backup` int(11) NOT NULL,
  `nama_db` text NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_backupdb`
--

INSERT INTO `riwayat_backupdb` (`id_backup`, `nama_db`, `tanggal`) VALUES
(39, 'u900358587_tagihan 2024-06-19.sql', '2024-06-19'),
(40, 'u900358587_tagihan 2024-07-15.sql', '2024-07-15');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_badmin`
--

CREATE TABLE `tbl_badmin` (
  `id_badmin` int(11) NOT NULL,
  `harga` varchar(255) DEFAULT NULL,
  `status` enum('saya','pelanggan') NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Dumping data for table `tbl_badmin`
--

INSERT INTO `tbl_badmin` (`id_badmin`, `harga`, `status`) VALUES
(1, '2000', 'pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_blokir`
--

CREATE TABLE `tbl_blokir` (
  `id_blokir` int(11) NOT NULL,
  `status_blokir` enum('aktif','tidakaktif') NOT NULL,
  `set_waktu` int(11) DEFAULT NULL,
  `set_waktu2` varchar(30) DEFAULT NULL,
  `pesan_blokir` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_blokir`
--

INSERT INTO `tbl_blokir` (`id_blokir`, `status_blokir`, `set_waktu`, `set_waktu2`, `pesan_blokir`) VALUES
(1, 'aktif', 1, 'minutes', '$nama : Untuk Mengambil Nama Pelanggan\r\n$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo\r\n$tagihan : Untuk Mengambil Harga \r\n$no_telp : Untuk Mengambil Nomor Telepon Pelanggan\r\n$sekarang_format : Untuk Mendapatkan Waktu Sekarang');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bukablokir`
--

CREATE TABLE `tbl_bukablokir` (
  `id_bukablokir` int(11) NOT NULL,
  `pesan_bukablokir` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_bukablokir`
--

INSERT INTO `tbl_bukablokir` (`id_bukablokir`, `pesan_bukablokir`) VALUES
(1, '$nama : Untuk Mengambil Nama Pelanggan\r\n$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo\r\n$tagihan : Untuk Mengambil Harga \r\n$no_telp : Untuk Mengambil Nomor Telepon Pelanggan\r\n$harinin : Untuk Mengambil Waktu dan Tanggal Hari Ini\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_buktibayar`
--

CREATE TABLE `tbl_buktibayar` (
  `id_buktibayar` int(11) NOT NULL,
  `id_rekening` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_tagihan` int(11) NOT NULL,
  `gambar` text NOT NULL,
  `keterangan` text NOT NULL,
  `tanggal_terima` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_informasi`
--

CREATE TABLE `tbl_informasi` (
  `id_informasi` int(11) NOT NULL,
  `judul_informasi` varchar(255) NOT NULL,
  `isi_informasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_keluhan`
--

CREATE TABLE `tbl_keluhan` (
  `id_keluhan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `judul_keluhan` varchar(50) NOT NULL,
  `nomor_tiket` varchar(255) NOT NULL,
  `isi_keluhan` text NOT NULL,
  `gambar` text NOT NULL,
  `masalah` text DEFAULT NULL,
  `no_wa` varchar(15) NOT NULL,
  `status_keluhan` enum('menunggu','proses','selesai','tidak merespon') NOT NULL,
  `tanggal` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mikrotik`
--

CREATE TABLE `tbl_mikrotik` (
  `id_mikrotik` int(11) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `port_mikrotik` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nomorphone`
--

CREATE TABLE `tbl_nomorphone` (
  `id_mynumber` int(11) NOT NULL,
  `my_number` varchar(15) NOT NULL,
  `nama_pemilik` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notif`
--

CREATE TABLE `tbl_notif` (
  `id_notifikasi` int(11) NOT NULL,
  `status_notifikasi` enum('aktif','tidakaktif') NOT NULL,
  `pesan_notifikasi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notif`
--

INSERT INTO `tbl_notif` (`id_notifikasi`, `status_notifikasi`, `pesan_notifikasi`) VALUES
(1, 'aktif', '$nama : Untuk Mengambil Nama Pelanggan\r\n$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo\r\n$tagihan : Untuk Mengambil Harga \r\n$no_telp : Untuk Mengambil Nomor Telepon Pelanggan');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notifbayar`
--

CREATE TABLE `tbl_notifbayar` (
  `id_notifbayar` int(11) NOT NULL,
  `pesan_bayar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_notifbayar`
--

INSERT INTO `tbl_notifbayar` (`id_notifbayar`, `pesan_bayar`) VALUES
(1, '$nama : Untuk Mengambil Nama Pelanggan\r\n$jatuh_tempo : Untuk Mengambil Tanggal Jatuh Tempo\r\n$tagihan : Untuk Mengambil Harga \r\n$no_telp : Untuk Mengambil Nomor Telepon Pelanggan\r\n$harinin : Untuk Mengambil Waktu dan Tanggal Hari Ini\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_npemasangan`
--

CREATE TABLE `tbl_npemasangan` (
  `id_npemasangan` int(11) NOT NULL,
  `status_notif` enum('aktif','tidak') NOT NULL,
  `pesan_notif` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_npemasangan`
--

INSERT INTO `tbl_npemasangan` (`id_npemasangan`, `status_notif`, `pesan_notif`) VALUES
(1, 'aktif', '$nama : Untuk Mengambil Nama Pelanggan\n$alamat : Untuk Mengambil Alamat Pelanggan\n$no_telp : Untuk Mengambil Nomor Telepon Pelanggan\n$paket : Untuk Mengambil Paket Pilihan Pelanggan\n$tgl_pemasangan : Untuk Mengambil Tanggal Pemasangan Pelanggan\n                           ');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_odc`
--

CREATE TABLE `tbl_odc` (
  `id_odc` int(11) NOT NULL,
  `nama_odc` varchar(255) NOT NULL,
  `perangkat_odc` varchar(50) NOT NULL,
  `port_odc` varchar(30) NOT NULL,
  `location` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_odc`
--

INSERT INTO `tbl_odc` (`id_odc`, `nama_odc`, `perangkat_odc`, `port_odc`, `location`) VALUES
(1, 'ODC Timur', 'ODC1', '10', '1.222469, 124.603221'),
(2, 'ODC Barat', 'ODC2', '10', '1.220302, 124.600958'),
(3, 'Odc 1', 'Odc', '8', '-7.737083, 110.681605');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_odp`
--

CREATE TABLE `tbl_odp` (
  `id_odp` int(11) NOT NULL,
  `nama_odp` varchar(255) NOT NULL,
  `port_odp` varchar(30) NOT NULL,
  `location` varchar(255) NOT NULL,
  `odc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_odp`
--

INSERT INTO `tbl_odp` (`id_odp`, `nama_odp`, `port_odp`, `location`, `odc`) VALUES
(1, 'ODP1', '8', '', 1),
(2, 'ODP2', '8', '', 2),
(3, 'Kretek', '8', '-7.737761, 110.684293', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_paketmikrotik`
--

CREATE TABLE `tbl_paketmikrotik` (
  `id_paketmikrotik` int(11) NOT NULL,
  `status` enum('ya','tidak') NOT NULL,
  `ppn` enum('aktif','tidak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_paketmikrotik`
--

INSERT INTO `tbl_paketmikrotik` (`id_paketmikrotik`, `status`, `ppn`) VALUES
(1, 'tidak', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_penggunamikrotik`
--

CREATE TABLE `tbl_penggunamikrotik` (
  `id_penggunamikrotik` int(11) NOT NULL,
  `status` enum('ya','tidak') NOT NULL,
  `addppsecret` enum('ya','tidak') NOT NULL,
  `ippelanggan` enum('statik','dynamic') NOT NULL,
  `mapping` enum('aktif','tidak') DEFAULT NULL,
  `ip_pool` enum('ya','tidak') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_penggunamikrotik`
--

INSERT INTO `tbl_penggunamikrotik` (`id_penggunamikrotik`, `status`, `addppsecret`, `ippelanggan`, `mapping`, `ip_pool`) VALUES
(1, 'tidak', 'tidak', 'dynamic', 'aktif', 'tidak');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pengumuman`
--

CREATE TABLE `tbl_pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `isi_pengumuman` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pesan_siaran`
--

CREATE TABLE `tbl_pesan_siaran` (
  `id_pesan_siaran` int(11) NOT NULL,
  `judul_pesan_siaran` varchar(255) NOT NULL,
  `isi_pesan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pgate`
--

CREATE TABLE `tbl_pgate` (
  `id_pgat` int(11) NOT NULL,
  `tclientkey` varchar(255) DEFAULT NULL,
  `tserverkey` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_rekening`
--

CREATE TABLE `tbl_rekening` (
  `id_rekening` int(11) NOT NULL,
  `nama_bank` varchar(50) NOT NULL,
  `nomor_rekening` varchar(255) NOT NULL,
  `nama_rekening` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_token`
--

CREATE TABLE `tbl_token` (
  `id_token` int(11) NOT NULL,
  `token` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kas`
--

CREATE TABLE `tb_kas` (
  `id_kas` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `tgl_kas` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `penerimaan` int(11) DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT NULL,
  `jenis_kas` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_tagihan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_kas`
--

INSERT INTO `tb_kas` (`id_kas`, `id_transaksi`, `tgl_kas`, `keterangan`, `penerimaan`, `pengeluaran`, `jenis_kas`, `status`, `id_tagihan`) VALUES
(1, NULL, '2024-06-15', 'Pembayaran Internet AN.&nbspWisky Sumenda,&nbspPaket&nbsp5 Mbps', 250000, NULL, NULL, NULL, 1),
(3, NULL, '2024-07-20', 'Voucher', 100000, 0, NULL, 1, NULL),
(4, NULL, '2024-07-20', 'Setor', 0, 50000, NULL, 1, NULL),
(5, NULL, '2024-07-20', 'Pembayaran Internet AN.&nbspWisky Sumenda,&nbspPaket&nbsp5 Mbps', 275000, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kas2`
--

CREATE TABLE `tb_kas2` (
  `id_kas` int(11) NOT NULL,
  `id_transaksi` int(11) DEFAULT NULL,
  `tgl_kas` date DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `penerimaan` int(11) DEFAULT NULL,
  `pengeluaran` int(11) DEFAULT NULL,
  `jenis_kas` varchar(15) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `id_tagihan` int(11) DEFAULT NULL,
  `id_pelanggan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tb_paket`
--

CREATE TABLE `tb_paket` (
  `id_paket` int(11) NOT NULL,
  `nama_paket` varchar(255) NOT NULL,
  `harga` int(11) NOT NULL,
  `ppn` decimal(10,2) DEFAULT NULL,
  `id_pmikrotik` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_paket`
--

INSERT INTO `tb_paket` (`id_paket`, `nama_paket`, `harga`, `ppn`, `id_pmikrotik`) VALUES
(26, '5 Mbps', 250000, 0.10, NULL),
(27, '10 Mbps', 300000, NULL, NULL),
(28, '15Mbps', 350000, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE `tb_pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
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
  `odp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`id_pelanggan`, `kode_pelanggan`, `nik`, `nama_pelanggan`, `alamat`, `no_telp`, `paket`, `ip_address`, `tgl_pemasangan`, `jatuh_tempo`, `location`, `id_perangkat`, `odp`) VALUES
(1, 'WNG031001', '', 'Wisky Sumenda', '', '089612345678', 26, '', '2024-06-15 08:36:00', '2024-10-15 02:42:16', '13.154376, -8.525391', 'NULL', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_perangkat`
--

CREATE TABLE `tb_perangkat` (
  `id_perangkat` int(11) NOT NULL,
  `nama_perangkat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_perangkat`
--

INSERT INTO `tb_perangkat` (`id_perangkat`, `nama_perangkat`) VALUES
(1, '121');

-- --------------------------------------------------------

--
-- Table structure for table `tb_profile`
--

CREATE TABLE `tb_profile` (
  `id_profile` int(11) NOT NULL,
  `nama_sekolah` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `telpon` varchar(20) NOT NULL,
  `website` varchar(100) NOT NULL,
  `kota` varchar(100) NOT NULL,
  `bendahara` varchar(100) NOT NULL,
  `nip` varchar(30) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `ktu` varchar(255) NOT NULL,
  `nip_ktu` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_profile`
--

INSERT INTO `tb_profile` (`id_profile`, `nama_sekolah`, `alamat`, `telpon`, `website`, `kota`, `bendahara`, `nip`, `foto`, `ktu`, `nip_ktu`) VALUES
(1, 'TAGIHAN INTERNET', 'Jl. Kebayoran', '021.090939', 'www.sekolah.com', 'Jakarta', 'Bejo Santoso', '1968890993933434', 'LOGO L-ONE NETWORK.png', 'ABDUL MUIS', '343434343434');

-- --------------------------------------------------------

--
-- Table structure for table `tb_tagihan`
--

CREATE TABLE `tb_tagihan` (
  `id_tagihan` int(11) NOT NULL,
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
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_tagihan`
--

INSERT INTO `tb_tagihan` (`id_tagihan`, `id_pelanggan`, `bulan_tahun`, `jml_bayar`, `terbayar`, `tgl_bayar`, `status_bayar`, `no_invoice`, `blokir_status`, `terkirim`, `waktu_bayar`, `user_id`) VALUES
(1, 1, '062024', 250000, 250000, '2024-06-15', 1, '00001.BLR.MST.', NULL, 'belum', '2024-06-15 08:38:33', 124),
(2, 1, '072024', 275000, 275000, '2024-07-20', 1, '00003.BLR.MST.', NULL, 'belum', '2024-07-20 02:42:16', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `level` varchar(30) NOT NULL,
  `foto` varchar(255) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `nama_user`, `password`, `level`, `foto`, `id_pelanggan`, `phone_number`) VALUES
(2, 'admin', 'admin', 'Coplink123', 'admin', 'title.png', NULL, '123456778'),
(124, 'kasir1', 'Jen', 'kasir1', 'kasir', 'default.png', NULL, '0000'),
(125, 'OP23122001', 'Wisky Sumenda', 'OP23122001', 'user', 'admin.png', 1, NULL),
(126, 'teknisi', 'teknisi', 'teknisi', 'teknisi', 'default.png', NULL, '000');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `riwayat_backupdb`
--
ALTER TABLE `riwayat_backupdb`
  ADD PRIMARY KEY (`id_backup`);

--
-- Indexes for table `tbl_badmin`
--
ALTER TABLE `tbl_badmin`
  ADD PRIMARY KEY (`id_badmin`);

--
-- Indexes for table `tbl_blokir`
--
ALTER TABLE `tbl_blokir`
  ADD PRIMARY KEY (`id_blokir`);

--
-- Indexes for table `tbl_bukablokir`
--
ALTER TABLE `tbl_bukablokir`
  ADD PRIMARY KEY (`id_bukablokir`);

--
-- Indexes for table `tbl_buktibayar`
--
ALTER TABLE `tbl_buktibayar`
  ADD PRIMARY KEY (`id_buktibayar`);

--
-- Indexes for table `tbl_informasi`
--
ALTER TABLE `tbl_informasi`
  ADD PRIMARY KEY (`id_informasi`);

--
-- Indexes for table `tbl_keluhan`
--
ALTER TABLE `tbl_keluhan`
  ADD PRIMARY KEY (`id_keluhan`);

--
-- Indexes for table `tbl_mikrotik`
--
ALTER TABLE `tbl_mikrotik`
  ADD PRIMARY KEY (`id_mikrotik`);

--
-- Indexes for table `tbl_nomorphone`
--
ALTER TABLE `tbl_nomorphone`
  ADD PRIMARY KEY (`id_mynumber`);

--
-- Indexes for table `tbl_notif`
--
ALTER TABLE `tbl_notif`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `tbl_notifbayar`
--
ALTER TABLE `tbl_notifbayar`
  ADD PRIMARY KEY (`id_notifbayar`);

--
-- Indexes for table `tbl_npemasangan`
--
ALTER TABLE `tbl_npemasangan`
  ADD PRIMARY KEY (`id_npemasangan`);

--
-- Indexes for table `tbl_odc`
--
ALTER TABLE `tbl_odc`
  ADD PRIMARY KEY (`id_odc`);

--
-- Indexes for table `tbl_odp`
--
ALTER TABLE `tbl_odp`
  ADD PRIMARY KEY (`id_odp`);

--
-- Indexes for table `tbl_paketmikrotik`
--
ALTER TABLE `tbl_paketmikrotik`
  ADD PRIMARY KEY (`id_paketmikrotik`);

--
-- Indexes for table `tbl_penggunamikrotik`
--
ALTER TABLE `tbl_penggunamikrotik`
  ADD PRIMARY KEY (`id_penggunamikrotik`);

--
-- Indexes for table `tbl_pengumuman`
--
ALTER TABLE `tbl_pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`);

--
-- Indexes for table `tbl_pesan_siaran`
--
ALTER TABLE `tbl_pesan_siaran`
  ADD PRIMARY KEY (`id_pesan_siaran`);

--
-- Indexes for table `tbl_pgate`
--
ALTER TABLE `tbl_pgate`
  ADD PRIMARY KEY (`id_pgat`);

--
-- Indexes for table `tbl_rekening`
--
ALTER TABLE `tbl_rekening`
  ADD PRIMARY KEY (`id_rekening`);

--
-- Indexes for table `tbl_token`
--
ALTER TABLE `tbl_token`
  ADD PRIMARY KEY (`id_token`);

--
-- Indexes for table `tb_kas`
--
ALTER TABLE `tb_kas`
  ADD PRIMARY KEY (`id_kas`);

--
-- Indexes for table `tb_kas2`
--
ALTER TABLE `tb_kas2`
  ADD PRIMARY KEY (`id_kas`);

--
-- Indexes for table `tb_paket`
--
ALTER TABLE `tb_paket`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tb_perangkat`
--
ALTER TABLE `tb_perangkat`
  ADD PRIMARY KEY (`id_perangkat`);

--
-- Indexes for table `tb_profile`
--
ALTER TABLE `tb_profile`
  ADD PRIMARY KEY (`id_profile`);

--
-- Indexes for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  ADD PRIMARY KEY (`id_tagihan`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `riwayat_backupdb`
--
ALTER TABLE `riwayat_backupdb`
  MODIFY `id_backup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `tbl_badmin`
--
ALTER TABLE `tbl_badmin`
  MODIFY `id_badmin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_blokir`
--
ALTER TABLE `tbl_blokir`
  MODIFY `id_blokir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_bukablokir`
--
ALTER TABLE `tbl_bukablokir`
  MODIFY `id_bukablokir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_buktibayar`
--
ALTER TABLE `tbl_buktibayar`
  MODIFY `id_buktibayar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_informasi`
--
ALTER TABLE `tbl_informasi`
  MODIFY `id_informasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_keluhan`
--
ALTER TABLE `tbl_keluhan`
  MODIFY `id_keluhan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_mikrotik`
--
ALTER TABLE `tbl_mikrotik`
  MODIFY `id_mikrotik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_nomorphone`
--
ALTER TABLE `tbl_nomorphone`
  MODIFY `id_mynumber` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_notif`
--
ALTER TABLE `tbl_notif`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_notifbayar`
--
ALTER TABLE `tbl_notifbayar`
  MODIFY `id_notifbayar` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_npemasangan`
--
ALTER TABLE `tbl_npemasangan`
  MODIFY `id_npemasangan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_odc`
--
ALTER TABLE `tbl_odc`
  MODIFY `id_odc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_odp`
--
ALTER TABLE `tbl_odp`
  MODIFY `id_odp` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_paketmikrotik`
--
ALTER TABLE `tbl_paketmikrotik`
  MODIFY `id_paketmikrotik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_penggunamikrotik`
--
ALTER TABLE `tbl_penggunamikrotik`
  MODIFY `id_penggunamikrotik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_pengumuman`
--
ALTER TABLE `tbl_pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pesan_siaran`
--
ALTER TABLE `tbl_pesan_siaran`
  MODIFY `id_pesan_siaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_pgate`
--
ALTER TABLE `tbl_pgate`
  MODIFY `id_pgat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_rekening`
--
ALTER TABLE `tbl_rekening`
  MODIFY `id_rekening` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_token`
--
ALTER TABLE `tbl_token`
  MODIFY `id_token` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_kas`
--
ALTER TABLE `tb_kas`
  MODIFY `id_kas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_kas2`
--
ALTER TABLE `tb_kas2`
  MODIFY `id_kas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_paket`
--
ALTER TABLE `tb_paket`
  MODIFY `id_paket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_perangkat`
--
ALTER TABLE `tb_perangkat`
  MODIFY `id_perangkat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_profile`
--
ALTER TABLE `tb_profile`
  MODIFY `id_profile` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_tagihan`
--
ALTER TABLE `tb_tagihan`
  MODIFY `id_tagihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
