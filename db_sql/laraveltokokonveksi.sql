-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2025 at 10:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laraveltokokonveksi`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(11) NOT NULL,
  `namakategori` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `created_at`, `updated_at`) VALUES
(20, 'Kaos Olahraga', '2024-10-02 02:49:32', '2025-11-14 03:17:32'),
(21, 'Seragam', '2024-10-02 08:17:18', '2025-11-14 03:17:40'),
(22, 'Jaket', '2025-11-14 03:19:17', '2025-11-14 03:19:17');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `idpembayaran` int(11) NOT NULL,
  `idpembelian` int(11) NOT NULL,
  `nama` text NOT NULL,
  `tanggaltransfer` text NOT NULL,
  `tanggal` datetime NOT NULL,
  `bukti` text NOT NULL,
  `jumlah` varchar(255) NOT NULL,
  `tipe` varchar(255) NOT NULL DEFAULT 'Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`idpembayaran`, `idpembelian`, `nama`, `tanggaltransfer`, `tanggal`, `bukti`, `jumlah`, `tipe`) VALUES
(1, 1, 'Fahrul Adib', '2025-11-14', '2025-11-14 00:00:00', '20251114165657width_200 (1).png', '108500', 'DP'),
(2, 1, 'Fahrul Adib', '2025-11-14', '2025-11-14 00:00:00', '202511141658031371289728.webp', '108500', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `idpembelian` int(11) NOT NULL,
  `notransaksi` text NOT NULL,
  `id` int(11) NOT NULL,
  `tanggalbeli` date NOT NULL,
  `ongkir` varchar(250) NOT NULL DEFAULT '0',
  `totalbeli` text NOT NULL,
  `alamat` text NOT NULL,
  `statusbeli` text NOT NULL,
  `waktu` datetime NOT NULL,
  `lokasi` text DEFAULT NULL,
  `nama` varchar(250) NOT NULL,
  `email` varchar(500) NOT NULL,
  `telepon` varchar(250) NOT NULL,
  `metodepembayaran` varchar(250) NOT NULL,
  `catatan` text NOT NULL,
  `qrcode` text NOT NULL,
  `tipepembayaran` varchar(255) NOT NULL DEFAULT 'Lunas'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`idpembelian`, `notransaksi`, `id`, `tanggalbeli`, `ongkir`, `totalbeli`, `alamat`, `statusbeli`, `waktu`, `lokasi`, `nama`, `email`, `telepon`, `metodepembayaran`, `catatan`, `qrcode`, `tipepembayaran`) VALUES
(1, '#TP20251114045638', 1, '2025-11-14', '22000', '195000', 'Jl. Prapanca Raya No. 9', 'Selesai', '2025-11-14 16:56:38', 'KERTAPATI, KERTAPATI, PALEMBANG, SUMATERA SELATAN, 30258', 'Fahrul Adib', 'fahruladib9@gmail.com', '082282076702', 'Transfer', 'asdsad', 'qr_1.svg', 'Lunas'),
(2, '#TP20251115045831', 1, '2025-11-15', '0', '195000', 'Jl. Prapanca Raya No. 9', 'Belum Bayar', '2025-11-15 16:58:31', 'KERTAPATI, KERTAPATI, PALEMBANG, SUMATERA SELATAN, 30258', 'Fahrul Adib', 'fahruladib9@gmail.com', '082282076702', 'COD', '', 'qr_2.svg', 'Lunas');

-- --------------------------------------------------------

--
-- Table structure for table `pembelianproduk`
--

CREATE TABLE `pembelianproduk` (
  `idpembelianproduk` int(11) NOT NULL,
  `idpembelian` int(11) NOT NULL,
  `idproduk` int(11) NOT NULL,
  `nama` text NOT NULL,
  `harga` text NOT NULL,
  `subharga` text NOT NULL,
  `jumlah` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelianproduk`
--

INSERT INTO `pembelianproduk` (`idpembelianproduk`, `idpembelian`, `idproduk`, `nama`, `harga`, `subharga`, `jumlah`) VALUES
(1, 1, 6, 'Jaket Bomber Waterproof Windproof', '195000', '195000', '1'),
(2, 2, 6, 'Jaket Bomber Waterproof Windproof', '195000', '195000', '1');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_foto`
--

CREATE TABLE `pembelian_foto` (
  `id_pembelian_foto` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `status` text NOT NULL,
  `foto` text NOT NULL,
  `fotobuktiditerima` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_foto`
--

INSERT INTO `pembelian_foto` (`id_pembelian_foto`, `id_pembelian`, `status`, `foto`, `fotobuktiditerima`) VALUES
(1, 1, 'Pesanan Sedang Dikirim', '20251114045727-width_200.png', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `telepon` text NOT NULL,
  `alamat` text DEFAULT NULL,
  `fotoprofil` text NOT NULL,
  `level` text NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `tempat_lahir` varchar(100) DEFAULT NULL,
  `jekel` varchar(100) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `kota` varchar(255) DEFAULT NULL,
  `kec` varchar(255) DEFAULT NULL,
  `kode_pos` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nama`, `email`, `password`, `telepon`, `alamat`, `fotoprofil`, `level`, `tgl_lahir`, `tempat_lahir`, `jekel`, `provinsi`, `kota`, `kec`, `kode_pos`) VALUES
(1, 'Fahrul Adib', 'fahruladib9@gmail.com', '123', '082282076702', 'Jl. Prapanca Raya No. 9', 'Untitled.png', 'Pelanggan', '2002-07-08', 'Jakarta', 'Laki-laki', 'DKI Jakarta', 'Jakarta Selatan', 'Ciganjur', '12170'),
(2, 'Administrator', 'admin@gmail.com', 'admin', '081293827383', 'Palembang', '', 'Admin', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'Produksi', 'produksi@gmail.com', '123', '082282076702', 'Banyuasin', '', 'Tim Produksi', '2000-11-11', 'Banyuasin', 'Laki-laki', NULL, NULL, NULL, NULL),
(9, 'Owner', 'owner@gmail.com', '123', '082282076702', 'Jl. Prapanca Raya No. 9', 'Untitled.png', 'Owner', '2002-07-08', 'Jakarta', 'Laki-laki', 'DKI Jakarta', 'Jakarta Selatan', 'Ciganjur', '12170');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `idkategori` int(11) NOT NULL,
  `nama` text NOT NULL,
  `harga` text NOT NULL,
  `deskripsi` text NOT NULL,
  `foto` text NOT NULL,
  `stok` varchar(250) NOT NULL DEFAULT '0',
  `tanggal` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`idproduk`, `idkategori`, `nama`, `harga`, `deskripsi`, `foto`, `stok`, `tanggal`) VALUES
(1, 20, 'Kaos Olahraga Dry Fit Lengan Pendek', '75000', '<p>Kaos olahraga berbahan dry fit premium, ringan, cepat menyerap keringat, dan nyaman dipakai untuk jogging, gym, maupun aktivitas outdoor.</p>', '495e7ba9b59a8606f62d2441a8731566.jpg_720x720q80.jpg', '99999', '2025-11-14'),
(2, 20, 'Kaos Training Sportwear Stretch Active', '89000', '<table>\r\n</table>\r\n\r\n<p>Kaos training dengan material stretch breathable, sangat elastis, cocok untuk workout intensitas tinggi. Anti-bakteri dan tidak mudah bau</p>', 'id-11134207-7r98y-lxptdt30wcgu72.jpeg', '99999', '2025-11-14'),
(3, 21, 'Seragam Kerja Kantor Premium', '175000', '<table>\r\n</table>\r\n\r\n<p>Seragam kerja berbahan American Drill premium, kuat, halus, dan nyaman dipakai seharian. Cocok untuk kebutuhan kantor, perusahaan, dan instansi formal</p>', '5ff00786656ebe491d1e9ab46c7fdae2.jpg_720x720q80.jpg', '99999', '2025-11-14'),
(4, 21, 'Seragam Lapangan Tactical Outdoor', '210000', '<p>Seragam lapangan berbahan Ripstop anti-robek, kuat, adem, cocok untuk kegiatan outdoor, keamanan, relawan, dan unit lapangan lainnya.</p>', 'no_brand_tactical_511_kemeja_komando_lapangan_pdl_outdoor_seragam_kantor_kerja_full03_c1fa9e28.webp', '99999', '2025-11-14'),
(5, 22, 'Jaket Hoodie Fleece Premium', '145000', '<p>Hoodie berbahan fleece premium, lembut, hangat, dan nyaman dipakai. Cocok digunakan untuk harian, komunitas, maupun kebutuhan custom desain.</p>', 'brd-44261_jaket-hoodie-zipper-anak-laki-laki-perempuan-usia-3-13-tahun-fleece-tebal-premium_full05-cace547c.webp', '99998', '2025-11-14'),
(6, 22, 'Jaket Bomber Waterproof Windproof', '195000', '<p>Jaket bomber berbahan waterproof dan windproof, sangat cocok untuk riding, outdoor, atau seragam komunitas. Desain elegan dengan resleting kuat dan jahitan rapi.</p>', 'id-11134207-7r98q-lsak1fdq5t5l1c.jpeg', '99999', '2025-11-14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`idpembayaran`),
  ADD KEY `idpembelian` (`idpembelian`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`idpembelian`),
  ADD KEY `id` (`id`);

--
-- Indexes for table `pembelianproduk`
--
ALTER TABLE `pembelianproduk`
  ADD PRIMARY KEY (`idpembelianproduk`) USING BTREE,
  ADD KEY `idpembelian` (`idpembelian`,`idproduk`) USING BTREE,
  ADD KEY `idproduk` (`idproduk`) USING BTREE;

--
-- Indexes for table `pembelian_foto`
--
ALTER TABLE `pembelian_foto`
  ADD PRIMARY KEY (`id_pembelian_foto`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`) USING BTREE,
  ADD KEY `idkategori` (`idkategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `idpembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `idpembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelianproduk`
--
ALTER TABLE `pembelianproduk`
  MODIFY `idpembelianproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pembelian_foto`
--
ALTER TABLE `pembelian_foto`
  MODIFY `id_pembelian_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
