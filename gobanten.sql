-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2020 at 07:22 PM
-- Server version: 10.1.35-MariaDB
-- PHP Version: 7.2.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gobanten`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `deleteBantenDitolakFromPembelian` (IN `idPembelian` INT)  BEGIN
	DELETE FROM pembelian WHERE id_pembelian= idPembelian;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getAllToko` ()  BEGIN
	SELECT *, COUNT(t.id_toko) AS 'banyakTokoValid' FROM banten b INNER JOIN toko t ON b.id_toko = t.id_toko INNER JOIN detailbanten db ON db.id_banten = b.id_banten GROUP BY b.id_toko; 
    
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getCustomerBantenStatus` (IN `idPengguna` INT, IN `statusPesanan` VARCHAR(50))  BEGIN 
	SELECT p.idtoko_pembelian,t.nama_toko FROM pembelian p INNER JOIN toko t ON t.id_toko = p.idtoko_pembelian WHERE p.idpengguna_pembelian = idPengguna AND p.status_pembelian= statusPesanan GROUP BY p.idtoko_pembelian;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `getPembelianDitolak` (IN `idPengguna` INT, IN `statusPembelianTolak` VARCHAR(255), IN `statusPembelianBatal` VARCHAR(255))  BEGIN
	SELECT pemb.*,t.*,pen.namadepan_penjual,pen.namabelakang_penjual,pen.hp_penjual FROM pembelian pemb INNER JOIN toko t ON pemb.idtoko_pembelian=t.id_toko INNER JOIN penjual pen ON t.id_toko=pen.id_toko WHERE pemb.idpengguna_pembelian = idPengguna AND (pemb.status_pembelian = statusPembelianTolak OR pemb.status_pembelian=statusPembelianBatal);
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `namadepan_admin` varchar(100) NOT NULL,
  `namabelakang_admin` varchar(100) NOT NULL,
  `username_admin` varchar(100) NOT NULL,
  `password_admin` varchar(100) NOT NULL,
  `email_admin` varchar(100) NOT NULL,
  `hp_admin` varchar(14) NOT NULL,
  `foto_admin` varchar(100) NOT NULL,
  `id_wilayah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `namadepan_admin`, `namabelakang_admin`, `username_admin`, `password_admin`, `email_admin`, `hp_admin`, `foto_admin`, `id_wilayah`) VALUES
(3, 'Budi', 'Gunawan', 'budi', '123', 'budi@gmail.com', '84028024', 'image1.jpg', 3),
(4, 'Satya', 'Bambang', 'admin', '123', 'satyabambang@gmail.com', '0814767584', 'avatar.png', 4);

-- --------------------------------------------------------

--
-- Table structure for table `bank`
--

CREATE TABLE `bank` (
  `id_bank` int(11) NOT NULL,
  `nama_bank` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bank`
--

INSERT INTO `bank` (`id_bank`, `nama_bank`) VALUES
(1, 'BNI-46'),
(2, 'BRI'),
(3, 'Mandiri'),
(4, 'Bukopin'),
(5, 'BCA'),
(6, 'Simpedes');

-- --------------------------------------------------------

--
-- Table structure for table `banten`
--

CREATE TABLE `banten` (
  `id_banten` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `nama_banten` varchar(100) NOT NULL,
  `deskripsi_banten` varchar(200) NOT NULL,
  `kelengkapan_banten` varchar(200) NOT NULL,
  `foto_banten` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `banten`
--

INSERT INTO `banten` (`id_banten`, `id_kategori`, `id_toko`, `nama_banten`, `deskripsi_banten`, `kelengkapan_banten`, `foto_banten`) VALUES
(20, 26, 19, 'Banten Kuningan', 'Banten untuk upacara kuningan', 'Banten Lengkap', 'banten payascita.png'),
(21, 24, 20, 'Dupa Gayatri', 'Dupa yang memiliki aroma wangi kayu cendana, sangat cocok untuk dijadikan bahan meditasi saat sembahyang', '1 Dus isi 6 bungkus dupa, harga dihitung untuk 1 dus', 'Banten1.png'),
(22, 24, 20, 'Banten Penyajan Galungan', 'Banten untuk penyajan galungan ', 'Paket banten sesuai dengan tingkatan banten di daerah Badung', 'banten tumpeng.png'),
(23, 26, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Banten untuk upacara tawur agung kesanga', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'banten pengulap.png'),
(24, 27, 20, 'Banten Pitra Yadnya', 'Banten untuk sarana upakara pitra yadnya', 'Banten lengkap, sesuaikan orderan berdasarkan tingkatan', 'banten untuk pitra yadnya-30.png'),
(25, 25, 20, 'Banten Otonan', 'Banten untuk otonan nem bulan', 'Kelengkapan akan menyesuaikan tingkatan banten yang akan dipesan', 'banten pejati-panca yadnya-33.png'),
(28, 24, 20, 'Banten Galungan', 'Banten untuk upacara penyucian saat galungan.', 'Paket banten lengkap sesuai tingkatan banten dan standar kabupaten Badung, terdiri dari sampian ulam dan lainnya', 'banten payascita.png'),
(29, 28, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'banten bhuta yadnya-31.png'),
(30, 29, 26, 'Banten Penglukatan', 'Banten untuk melukat otonan', 'Banten lengkap sesuai tingkatan banten berikan deskripsi saat pemesanan', 'banten otonan&bungkat-panca yadnya-27.png'),
(32, 27, 20, 'Banten Pengulap', 'Banten ngulapin yang biasanya digunakan saat proses pembakaran mayat saat ngaben', 'Aledan sayut, 2 buah tumpeng, 1 buah tulung urip, 5 buah tumpeng sari, 5 buah tipat kedis, 5 buah anak tulung, 5 buah kuangen , 200, keping pis bolong, Canang burat wangi', 'banten pengulap.png'),
(33, 31, 19, 'Banten Prayascita', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'banten payascita.png'),
(36, 23, 19, 'Banten Penyajan', 'Banten untuk upacara penyajan galungan dewa yadnya', 'Banten paket komplit lengkap, pesanan sesuai tingkatan banten', 'BEBANTENAN-01.png'),
(39, 34, 27, 'Banten Kuningan', 'a', 'a', 'banten otonan&bungkat-panca yadnya-27.png');

--
-- Triggers `banten`
--
DELIMITER $$
CREATE TRIGGER `after_banten_deleted` AFTER DELETE ON `banten` FOR EACH ROW BEGIN
    	DELETE FROM detailbanten WHERE id_banten = old.id_banten;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `detailbanten`
--

CREATE TABLE `detailbanten` (
  `id_detail` int(11) NOT NULL,
  `id_banten` int(11) NOT NULL,
  `id_tingkatan` int(11) NOT NULL,
  `stok_detail` int(11) NOT NULL,
  `hargaawal_detail` int(11) NOT NULL,
  `diskon_detail` int(11) NOT NULL,
  `hargaakhir_detail` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detailbanten`
--

INSERT INTO `detailbanten` (`id_detail`, `id_banten`, `id_tingkatan`, `stok_detail`, `hargaawal_detail`, `diskon_detail`, `hargaakhir_detail`) VALUES
(19, 20, 1, 12, 120000, 12, 105600),
(20, 21, 1, 12, 12000, 12, 10560),
(21, 22, 2, 13, 198000, 12, 174240),
(22, 23, 1, 15, 150000, 12, 132000),
(23, 22, 1, 12, 12000, 12, 10560),
(25, 22, 3, 23, 112000, 0, 112000),
(27, 24, 3, 23, 23, 23, 18),
(28, 28, 4, 23, 23, 23, 18),
(29, 29, 1, 12, 200000, 0, 200000),
(30, 29, 2, 90, 180000, 20, 144000),
(31, 30, 1, 12, 190000, 12, 167200),
(32, 25, 1, 12, 50000, 0, 50000),
(33, 30, 3, 10, 190000, 0, 190000),
(35, 32, 1, 12, 190000, 0, 190000),
(36, 32, 2, 12, 145000, 12, 127600),
(37, 32, 3, 1, 50000, 0, 50000),
(38, 33, 1, 10, 150000, 12, 132000),
(41, 20, 2, 12, 190000, 12, 167200);

-- --------------------------------------------------------

--
-- Table structure for table `kategoribanten`
--

CREATE TABLE `kategoribanten` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `id_toko` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kategoribanten`
--

INSERT INTO `kategoribanten` (`id_kategori`, `nama_kategori`, `id_toko`) VALUES
(23, 'Dewa Yadnya', 19),
(24, 'Dewa Yadnya', 20),
(25, 'Bhuta Yadnya', 20),
(26, 'Bhuta Yadnya', 19),
(27, 'Pitra Yadnya', 20),
(28, 'Bhuta Yadnya', 26),
(29, 'Dewa Yadnya', 26),
(30, 'Sarana Upakara', 26),
(31, 'Umum', 19),
(34, 'Dewa Yadanya', 27),
(35, 'Bhuta Yadnya', 27);

-- --------------------------------------------------------

--
-- Table structure for table `nota`
--

CREATE TABLE `nota` (
  `id_nota` int(11) NOT NULL,
  `idpengguna_nota` int(11) NOT NULL,
  `idtoko_nota` int(11) NOT NULL,
  `namabanten_nota` varchar(100) NOT NULL,
  `tingkatanbanten_nota` varchar(50) NOT NULL,
  `kelengkapanbanten_nota` varchar(200) NOT NULL,
  `deskripsibanten_nota` varchar(300) NOT NULL,
  `quantity_nota` int(11) NOT NULL,
  `hargaawal_nota` int(11) NOT NULL,
  `diskon_nota` int(11) NOT NULL,
  `hargaongkir_nota` int(11) NOT NULL,
  `hargaakhir_nota` int(11) NOT NULL,
  `provinsiongkir_nota` varchar(100) NOT NULL,
  `kotaongkir_nota` varchar(100) NOT NULL,
  `catatanpemesanan_nota` varchar(200) NOT NULL,
  `tanggalkirim_nota` date NOT NULL,
  `tanggalbeli_nota` date NOT NULL,
  `alamatpengiriman_nota` varchar(200) NOT NULL,
  `fotobanten_nota` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `nota`
--

INSERT INTO `nota` (`id_nota`, `idpengguna_nota`, `idtoko_nota`, `namabanten_nota`, `tingkatanbanten_nota`, `kelengkapanbanten_nota`, `deskripsibanten_nota`, `quantity_nota`, `hargaawal_nota`, `diskon_nota`, `hargaongkir_nota`, `hargaakhir_nota`, `provinsiongkir_nota`, `kotaongkir_nota`, `catatanpemesanan_nota`, `tanggalkirim_nota`, `tanggalbeli_nota`, `alamatpengiriman_nota`, `fotobanten_nota`) VALUES
(12, 5, 20, 'Banten Gadungan', 'Madya', 'Paket banten lengkap', 'Banten gatau apa ini', 4, 198000, 12, 1212, 175452, 'Bali', 'Bangli', 'Tolong bantennya dibungkus dengan kain sukla', '2020-04-29', '2020-04-24', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png'),
(13, 5, 20, 'Dupa Gayatri', 'Utama', '1 dus 12 paket', 'Dupa wangi untuk meditasi sembahyang, harum cendana', 3, 12000, 12, 4242, 14802, 'Bali', 'Denpasar', 'Tolong dibungkus rapi dengan plastik ya', '2020-04-26', '2020-04-25', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten1.png'),
(14, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 2, 150000, 12, 4141, 136141, 'Bali', 'Klungkung', '', '2020-04-28', '2020-04-26', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(15, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 4, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-04-28', '2020-04-26', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(16, 5, 20, 'Banten Gadungan', 'Nista', 'Paket banten lengkap', 'Banten gatau apa ini', 5, 112000, 0, 1212, 113212, 'Bali', 'Bangli', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png'),
(17, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 41414, 173414, 'Bali', 'Singaraja', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(18, 5, 20, 'Banten Pitra Yadnya', 'Nista', 'Banten lengkap, sesuaikan orderan berdasarkan tingkatan', 'Banten untuk saran upakara pitra yadnya', 3, 23, 23, 114141, 114159, 'Bali', 'Klungkung', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png'),
(19, 5, 20, 'Banten Galungan', 'Umum', 'Paket banten lengkap sesuai tingkatan banten dan standar kabupaten Badung, terdiri dari sampian ulam dan lainnya', 'Banten untuk upacara penyucian saat galungan.', 1, 23, 23, 1212, 1230, 'Bali', 'Bangli', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(20, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Madya', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 1, 200000, 20, 10000, 170000, 'Bali', 'Tabanan', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png'),
(21, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 1414, 133414, 'Bali', 'Bangli', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(22, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 12, 132012, 'Bali', 'Tabanan', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(23, 5, 20, 'Banten Gadungan', 'Madya', 'Paket banten lengkap', 'Banten gatau apa ini', 1, 198000, 12, 1212, 175452, 'Bali', 'Bangli', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png'),
(24, 5, 20, 'Dupa Gayatri', 'Utama', '1 dus 12 paket', 'Dupa bagus', 1, 12000, 12, 1222, 11782, 'Bali', 'Singaraja', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten1.png'),
(25, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 1414, 133414, 'Bali', 'Bangli', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(26, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Madya', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 1, 200000, 20, 27000, 187000, 'Bali', 'Klungkung', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png'),
(27, 6, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 12, 132012, 'Bali', 'Gianyar', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar Bali', 'banten pengulap.png'),
(28, 7, 20, 'Banten Galungan', 'Umum', 'Paket banten lengkap sesuai tingkatan banten dan standar kabupaten Badung, terdiri dari sampian ulam dan lainnya', 'Banten untuk upacara penyucian saat galungan.', 1, 23, 23, 114141, 114159, 'Bali', 'Klungkung', '', '2020-05-01', '2020-04-30', 'Jalan Raya Padangsambian', 'banten payascita.png'),
(29, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 5, 200000, 0, 10000, 210000, 'Bali', 'Badung', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png'),
(30, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 1, 200000, 0, 12000, 212000, 'Bali', 'Denpasar', '', '2020-05-15', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png'),
(31, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Madya', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 1, 180000, 20, 10000, 154000, 'Bali', 'Tabanan', '', '2020-05-08', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png'),
(32, 5, 20, 'Banten Penyajan Galungan', 'Utama', 'Paket banten sesuai dengan tingkatan banten di daerah Badung', 'Banten untuk penyajan galungan ', 1, 12000, 12, 114141, 124701, 'Bali', 'Klungkung', '', '2020-05-07', '2020-05-02', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten tumpeng.png'),
(33, 5, 19, 'Banten Prayascita', 'Utama', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 3, 150000, 12, 14, 132014, 'Bali', 'Karangasem', '', '2020-05-13', '2020-05-04', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(34, 5, 19, 'Banten Prayascita', 'Utama', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 1, 150000, 12, 12, 132012, 'Bali', 'Gianyar', '', '2020-05-05', '2020-05-04', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(35, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 1, 200000, 0, 15000, 215000, 'Bali', 'Gianyar', '', '2020-05-28', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png'),
(36, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 4141, 136141, 'Bali', 'Klungkung', '', '2020-05-22', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(37, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 1, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-05-18', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(38, 5, 19, 'Banten Prayascita', 'Utama', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 1, 150000, 12, 4141, 136141, 'Bali', 'Klungkung', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(39, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 41414, 173414, 'Bali', 'Singaraja', '', '2020-05-27', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(40, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(41, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-18', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(42, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 2, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(43, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 2, 150000, 12, 4141, 268141, 'Bali', 'Klungkung', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(44, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 2, 150000, 12, 10000, 274000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(45, 5, 19, 'Banten Prayascita', 'Utama', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-17', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(46, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-17', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png'),
(47, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 1, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-06-13', '2020-06-11', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(48, 8, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 1, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-07-01', '2020-06-11', 'Jalan Raya Sumedang', 'banten payascita.png'),
(49, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 1, 120000, 12, 10000, 115600, 'Bali', 'Denpasar', 'Banten tolong di package yang rapi, dan tolong diantar dengan baik', '2020-06-13', '2020-06-11', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png'),
(50, 8, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-06-13', '2020-06-11', 'Jalan Raya Anyer Penarukan', 'banten pengulap.png'),
(51, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 1, 120000, 12, 10000, 115600, 'Bali', 'Denpasar', '', '2020-06-12', '2020-06-11', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png');

-- --------------------------------------------------------

--
-- Table structure for table `notifadmin`
--

CREATE TABLE `notifadmin` (
  `id_notifikasi` int(11) NOT NULL,
  `idpenjual_notif` int(11) NOT NULL,
  `pesan_notif` varchar(500) NOT NULL,
  `status_notif` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id_ongkir` int(11) NOT NULL,
  `id_wilayah` int(11) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `harga_ongkir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ongkir`
--

INSERT INTO `ongkir` (`id_ongkir`, `id_wilayah`, `id_toko`, `harga_ongkir`) VALUES
(14, 5, 19, 14),
(15, 6, 19, 4141),
(16, 10, 19, 1414),
(17, 9, 19, 41414),
(18, 4, 19, 12),
(19, 3, 19, 12),
(20, 7, 19, 14),
(21, 2, 19, 10000),
(25, 7, 20, 12),
(26, 10, 20, 1212),
(27, 6, 20, 114141),
(29, 3, 20, 4141),
(31, 5, 20, 12),
(33, 9, 20, 1222),
(34, 4, 20, 12),
(35, 2, 20, 4242),
(36, 8, 20, 12334),
(37, 4, 22, 213),
(38, 2, 22, 12313),
(39, 3, 22, 3123),
(40, 5, 22, 3131),
(41, 9, 22, 13131),
(42, 7, 22, 31312),
(43, 6, 22, 21313),
(44, 8, 22, 3131321),
(45, 10, 22, 313123),
(47, 2, 26, 12000),
(48, 3, 26, 10000),
(49, 4, 26, 15000),
(50, 5, 26, 20000),
(51, 6, 26, 27000),
(52, 7, 26, 20000),
(53, 8, 26, 10000),
(54, 9, 26, 10000),
(55, 10, 26, 9000),
(65, 2, 28, 12000),
(66, 3, 28, 9000),
(67, 4, 28, 19000),
(68, 5, 28, 12000),
(69, 6, 28, 15000),
(70, 7, 28, 15000),
(71, 8, 28, 15000),
(72, 8, 19, 12333),
(73, 2, 27, 12),
(74, 3, 27, 12),
(75, 4, 27, 12),
(76, 5, 27, 12),
(77, 6, 27, 12),
(78, 7, 27, 12),
(79, 8, 27, 12),
(80, 9, 27, 12),
(81, 10, 27, 12);

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `idpengguna_pembelian` int(11) NOT NULL,
  `idtoko_pembelian` int(11) NOT NULL,
  `namabanten_pembelian` varchar(100) NOT NULL,
  `tingkatanbanten_pembelian` varchar(50) NOT NULL,
  `kelengkapanbanten_pembelian` varchar(200) NOT NULL,
  `deskripsibanten_pembelian` varchar(300) NOT NULL,
  `kategoribanten_pembelian` varchar(100) NOT NULL,
  `quantity_pembelian` int(11) NOT NULL,
  `hargaawal_pembelian` int(11) NOT NULL,
  `diskon_pembelian` int(11) NOT NULL,
  `hargaongkir_pembelian` int(11) NOT NULL,
  `hargaakhir_pembelian` int(11) NOT NULL,
  `provinsiongkir_pembelian` varchar(100) NOT NULL,
  `kotaongkir_pembelian` varchar(100) NOT NULL,
  `catatanpemesanan_pembelian` varchar(200) NOT NULL,
  `tanggalkirim_pembelian` date NOT NULL,
  `tanggalbeli_pembelian` date NOT NULL,
  `alamatpengiriman_pembelian` varchar(200) NOT NULL,
  `fotobanten_pembelian` varchar(100) NOT NULL,
  `status_pembelian` varchar(50) NOT NULL,
  `catatanpenolakan_pembelian` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `idpengguna_pembelian`, `idtoko_pembelian`, `namabanten_pembelian`, `tingkatanbanten_pembelian`, `kelengkapanbanten_pembelian`, `deskripsibanten_pembelian`, `kategoribanten_pembelian`, `quantity_pembelian`, `hargaawal_pembelian`, `diskon_pembelian`, `hargaongkir_pembelian`, `hargaakhir_pembelian`, `provinsiongkir_pembelian`, `kotaongkir_pembelian`, `catatanpemesanan_pembelian`, `tanggalkirim_pembelian`, `tanggalbeli_pembelian`, `alamatpengiriman_pembelian`, `fotobanten_pembelian`, `status_pembelian`, `catatanpenolakan_pembelian`) VALUES
(39, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Dewa Yadnya', 1, 120000, 12, 14, 105614, 'Bali', 'Karangasem', '', '2020-04-29', '2020-04-24', 'Jalan Sungai Kapuas', 'banten payascita.png', 'Selesai', ''),
(40, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 3, 150000, 12, 14, 132014, 'Bali', 'Karangasem', '', '2020-04-30', '2020-04-24', 'Jalan Sungai Kapuas', 'banten pengulap.png', 'Selesai', ''),
(41, 5, 20, 'Banten Kuningan', 'Madya', 'A', 'A', 'Bhuta Yadnya', 2, 190000, 12, 15000, 182200, 'Bali', 'Karangasem', '', '2020-04-24', '2020-04-24', 'Jalan Sungai Kapuas', 'Banten3.png', 'Selesai', ''),
(42, 5, 20, 'Banten Kuningan', 'Utama', 'Banten lengkap sesuai tingkatan banten, silahkan isi di deskripsi saat pemesanan', 'Banten untuk keperluan upacara kuningan', 'Dewa Yadnya', 1, 12000, 12, 15000, 25560, 'Bali', 'Karangasem', '', '2020-04-28', '2020-04-24', 'Jalan Sungai Kapuas', 'Banten1.png', 'Selesai', ''),
(43, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Dewa Yadnya', 1, 120000, 12, 14, 105614, 'Bali', 'Karangasem', '', '2020-04-29', '2020-04-24', 'Jalan Sungai Kapuas', 'banten payascita.png', 'Selesai', ''),
(46, 5, 20, 'Banten Gadungan', 'Madya', 'Paket banten lengkap', 'Banten gatau apa ini', 'Bhuta Yadnya', 4, 198000, 12, 4141, 178381, 'Bali', 'Tabanan', '', '2020-04-30', '2020-04-24', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png', 'Selesai', ''),
(47, 5, 20, 'Banten Gadungan', 'Madya', 'Paket banten lengkap', 'Banten gatau apa ini', 'Bhuta Yadnya', 4, 198000, 12, 1212, 175452, 'Bali', 'Bangli', 'Tolong bantennya dibungkus dengan kain sukla', '2020-04-29', '2020-04-24', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png', 'Selesai', ''),
(50, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Dewa Yadnya', 4, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-04-28', '2020-04-26', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Tolak', 'Banten sudah disediakan oleh penjual untuk saat ini'),
(51, 5, 20, 'Banten Gadungan', 'Nista', 'Paket banten lengkap', 'Banten gatau apa ini', 'Bhuta Yadnya', 5, 112000, 0, 1212, 113212, 'Bali', 'Bangli', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png', 'Tolak', 'Banten yang dijumlah sangat banyak dalam rentang waktu yang mepet'),
(52, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 41414, 173414, 'Bali', 'Singaraja', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Tolak', 'Tanggal pengiriman mepet untuk bisa dikirim,  maaf ya untuk orderan selanjutnya bisa dipesan di jauh-jauh hari'),
(53, 5, 20, 'Banten Pitra Yadnya', 'Nista', 'Banten lengkap, sesuaikan orderan berdasarkan tingkatan', 'Banten untuk saran upakara pitra yadnya', 'Pitra Yadnya', 3, 23, 23, 114141, 114159, 'Bali', 'Klungkung', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png', 'Tolak', 'Tidak bisa mengerjakan banten pitra yadnya dalam waktu dekat dikarenakan full orderan'),
(54, 5, 20, 'Banten Galungan', 'Umum', 'Paket banten lengkap sesuai tingkatan banten dan standar kabupaten Badung, terdiri dari sampian ulam dan lainnya', 'Banten untuk upacara penyucian saat galungan.', 'Dewa Yadnya', 1, 23, 23, 1212, 1230, 'Bali', 'Bangli', '', '2020-04-29', '2020-04-28', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Selesai', ''),
(55, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Madya', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Bhuta Yadnya', 1, 200000, 20, 10000, 170000, 'Bali', 'Tabanan', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak merespon. Saldomu telah kami kembalikan ke rekeningmu'),
(56, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 1414, 133414, 'Bali', 'Bangli', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Selesai', ''),
(57, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 12, 132012, 'Bali', 'Tabanan', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Selesai', ''),
(58, 5, 20, 'Banten Gadungan', 'Madya', 'Paket banten lengkap', 'Banten gatau apa ini', 'Dewa Yadnya', 1, 198000, 12, 1212, 175452, 'Bali', 'Bangli', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten3.png', '', ''),
(59, 5, 20, 'Dupa Gayatri', 'Utama', '1 dus 12 paket', 'Dupa bagus', 'Dewa Yadnya', 1, 12000, 12, 1222, 11782, 'Bali', 'Singaraja', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'Banten1.png', '', ''),
(60, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 1414, 133414, 'Bali', 'Bangli', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Selesai', ''),
(61, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Madya', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Bhuta Yadnya', 1, 200000, 20, 27000, 187000, 'Bali', 'Klungkung', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak mengerjakan bantenmu. Saldomu telah kami kembalikan ke rekeningmu'),
(62, 6, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 12, 132012, 'Bali', 'Gianyar', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar Bali', 'banten pengulap.png', 'Selesai', ''),
(63, 7, 20, 'Banten Galungan', 'Umum', 'Paket banten lengkap sesuai tingkatan banten dan standar kabupaten Badung, terdiri dari sampian ulam dan lainnya', 'Banten untuk upacara penyucian saat galungan.', 'Dewa Yadnya', 1, 23, 23, 114141, 114159, 'Bali', 'Klungkung', '', '2020-05-01', '2020-04-30', 'Jalan Raya Padangsambian', 'banten payascita.png', '', ''),
(64, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Bhuta Yadnya', 5, 200000, 0, 10000, 210000, 'Bali', 'Badung', '', '2020-05-01', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak merespon. Saldomu telah kami kembalikan ke rekeningmu'),
(65, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Bhuta Yadnya', 1, 200000, 0, 12000, 212000, 'Bali', 'Denpasar', '', '2020-05-15', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak merespon. Saldomu telah kami kembalikan ke rekeningmu'),
(66, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Madya', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Bhuta Yadnya', 1, 180000, 20, 10000, 154000, 'Bali', 'Tabanan', '', '2020-05-08', '2020-04-30', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak merespon. Saldomu telah kami kembalikan ke rekeningmu'),
(67, 5, 20, 'Banten Penyajan Galungan', 'Utama', 'Paket banten sesuai dengan tingkatan banten di daerah Badung', 'Banten untuk penyajan galungan ', 'Dewa Yadnya', 1, 12000, 12, 114141, 124701, 'Bali', 'Klungkung', '', '2020-05-07', '2020-05-02', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten tumpeng.png', '', ''),
(68, 5, 19, 'Banten Prayascita', 'Utama', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 'Umum', 3, 150000, 12, 14, 132014, 'Bali', 'Karangasem', '', '2020-05-13', '2020-05-04', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Selesai', ''),
(70, 5, 26, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'Paket banten lengkap dan sesuai dengan tingkatan setiap bantenya, harga juga menyesuaikan tingkatan bantennya', 'Banten untuk upacara pecaruan agung tawur kesangan ', 'Bhuta Yadnya', 1, 200000, 0, 15000, 215000, 'Bali', 'Gianyar', '', '2020-05-28', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten bhuta yadnya-31.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak merespon. Saldomu telah kami kembalikan ke rekeningmu'),
(71, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 4141, 136141, 'Bali', 'Klungkung', '', '2020-05-22', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Selesai', ''),
(72, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Bhuta Yadnya', 1, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-05-16', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Selesai', ''),
(75, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Tolak', 'Tidak bisa saya buat'),
(78, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 2, 150000, 12, 4141, 268141, 'Bali', 'Klungkung', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Tolak', 'Banten tidak bisa dibuat untuk hari ini\r\n'),
(79, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 2, 150000, 12, 10000, 274000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-16', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Batal', ''),
(80, 5, 19, 'Banten Prayascita', 'Utama', 'Aled, Sampian Nagasari, Sampian Padma, Jajan Uli, Bagina, Apem, Roti kukus, Cerorot, Tape Gede, Pinang, Tebu, Tempat nasi dari kelongkong, Daun tabia bun, daun dapdap dan padang lepas, Payuk pere beri', 'Banten Prayascita biasanya dipergunakan untuk membersihkan atau mensucikan pikiran sebelum dilaksanakan upacara â€“ upacara suci seperti melaspas bangunan, ', 'Umum', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-17', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak mengerjakan bantenmu. Saldomu telah kami kembalikan ke rekeningmu'),
(81, 5, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-05-19', '2020-05-17', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten pengulap.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak mengerjakan bantenmu. Saldomu telah kami kembalikan ke rekeningmu'),
(82, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Bhuta Yadnya', 1, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-06-13', '2020-06-11', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak mengerjakan bantenmu. Saldomu telah kami kembalikan ke rekeningmu'),
(83, 8, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Bhuta Yadnya', 1, 120000, 12, 1414, 107014, 'Bali', 'Bangli', '', '2020-07-01', '2020-06-11', 'Jalan Raya Sumedang', 'banten payascita.png', 'Kirim', ''),
(84, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Bhuta Yadnya', 1, 120000, 12, 10000, 115600, 'Bali', 'Denpasar', 'Banten tolong di package yang rapi, dan tolong diantar dengan baik', '2020-06-13', '2020-06-11', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Batal', 'Pesanan telah dibatalkan oleh sistem karena penjual tidak mengerjakan bantenmu. Saldomu telah kami kembalikan ke rekeningmu'),
(85, 8, 19, 'Banten Pecaruan Agung Tawur Kesanga', 'Utama', 'banten lengkap sesuai deskripsi pesanan dan tingkatan pesanan', 'Banten untuk upacara tawur agung kesanga', 'Bhuta Yadnya', 1, 150000, 12, 10000, 142000, 'Bali', 'Denpasar', '', '2020-06-13', '2020-06-11', 'Jalan Raya Anyer Penarukan', 'banten pengulap.png', 'Kirim', ''),
(86, 5, 19, 'Banten Kuningan', 'Utama', 'Banten Lengkap', 'Banten untuk upacara kuningan', 'Bhuta Yadnya', 1, 120000, 12, 10000, 115600, 'Bali', 'Denpasar', '', '2020-06-12', '2020-06-11', 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'banten payascita.png', 'Terima', '');

--
-- Triggers `pembelian`
--
DELIMITER $$
CREATE TRIGGER `after_pembelian_insert` AFTER INSERT ON `pembelian` FOR EACH ROW BEGIN 
    	INSERT INTO nota VALUES('',NEW.idpengguna_pembelian,NEW.idtoko_pembelian,NEW.namabanten_pembelian,NEW.tingkatanbanten_pembelian,NEW.kelengkapanbanten_pembelian,NEW.deskripsibanten_pembelian,NEW.quantity_pembelian,NEW.hargaawal_pembelian,NEW.diskon_pembelian,NEW.hargaongkir_pembelian,NEW.hargaakhir_pembelian,NEW.provinsiongkir_pembelian,NEW.kotaongkir_pembelian,NEW.catatanpemesanan_pembelian,NEW.tanggalkirim_pembelian,NEW.tanggalbeli_pembelian,NEW.alamatpengiriman_pembelian,NEW.fotobanten_pembelian);
        UPDATE penjual SET dompet_penjual = dompet_penjual + NEW.hargaakhir_pembelian WHERE id_penjual = NEW.idtoko_pembelian;
        
    END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `namadepan_pengguna` varchar(100) NOT NULL,
  `namabelakang_pengguna` varchar(100) NOT NULL,
  `hp_pengguna` int(11) NOT NULL,
  `email_pengguna` varchar(100) NOT NULL,
  `provinsi_pengguna` varchar(100) NOT NULL,
  `kota_pengguna` varchar(50) NOT NULL,
  `kodepos_pengguna` mediumint(6) NOT NULL,
  `alamat_pengguna` varchar(125) NOT NULL,
  `foto_pengguna` varchar(100) NOT NULL,
  `username_pengguna` varchar(100) NOT NULL,
  `password_pengguna` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `namadepan_pengguna`, `namabelakang_pengguna`, `hp_pengguna`, `email_pengguna`, `provinsi_pengguna`, `kota_pengguna`, `kodepos_pengguna`, `alamat_pengguna`, `foto_pengguna`, `username_pengguna`, `password_pengguna`) VALUES
(5, 'Satria', 'Bimantara', 2147483647, 'satria_Md@yahoo.com', 'Bali', 'Denpasar', 980328, 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'image1.jpg', 'bimbim', '123'),
(6, 'Budi', 'Badawan', 2147483647, 'budi@gmail.com', 'Bali', 'Denpasar', 80114, 'Jalan Pulau Tarakan Nomor 20 Denpasar', 'avatar3.png', 'budi', '123'),
(7, 'Susilo', 'Bambang', 2147483647, 'susilo@gmail.com', '', '', 0, '', 'avatar3.png', 'susilo', '123'),
(8, 'Budi', 'Susanto', 2147483647, 'budisusanto@gmail.com', '', '', 0, '', 'avatar3.png', 'user1', '123');

-- --------------------------------------------------------

--
-- Table structure for table `penjual`
--

CREATE TABLE `penjual` (
  `id_penjual` int(11) NOT NULL,
  `namadepan_penjual` varchar(50) NOT NULL,
  `namabelakang_penjual` varchar(50) NOT NULL,
  `email_penjual` varchar(100) NOT NULL,
  `hp_penjual` varchar(14) NOT NULL,
  `dompet_penjual` int(11) NOT NULL,
  `foto_penjual` varchar(100) NOT NULL,
  `username_penjual` varchar(100) NOT NULL,
  `password_penjual` varchar(100) NOT NULL,
  `id_toko` int(11) NOT NULL,
  `id_bank` int(11) NOT NULL,
  `rekening_penjual` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `penjual`
--

INSERT INTO `penjual` (`id_penjual`, `namadepan_penjual`, `namabelakang_penjual`, `email_penjual`, `hp_penjual`, `dompet_penjual`, `foto_penjual`, `username_penjual`, `password_penjual`, `id_toko`, `id_bank`, `rekening_penjual`) VALUES
(19, 'I Made', 'Satria', 'satria_Md@yahoo.com', '081337700152', 364614, 'avatar3.png', 'bimbim', '123', 19, 2, '0804312'),
(20, 'Budi', 'Laksamana', 'cahya@gmail.com', '08148934', 0, 'image1.jpg', 'budi', '123', 20, 1, '324342'),
(26, 'Laksmi', 'Pande', 'laksmi@gmail.com', '081223377849', -1148000, 'avatar.png', 'laksmi', '123', 26, 1, '12332432'),
(27, 'Putri', 'Wahyuni', 'putri@gmail.com', '081667788192', 0, 'avatar.png', 'putri', '123', 27, 3, '018902884'),
(28, 'Aditya', 'Pratama', 'adit@gmail.com', '0184397543', 0, 'avatar.png', 'adit', '123', 28, 1, '1807594-193'),
(29, 'Budiyasa', 'Sudiasa', 'budiasa@gmail.com', '08123345609', 0, 'avatar.png', 'budiyasa', '123', 29, 2, '12345'),
(30, 'Susanto', 'Megaranto', 'susanto@gmail.com', '081337782934', 0, 'avatar.png', 'susanto', '123', 30, 3, '0804312'),
(31, 'Wahyuni', 'Putri', 'putriwahyuni@gmail.com', '081446677384', 0, 'avatar.png', 'wahyuni', '123', 31, 6, '8309264928');

-- --------------------------------------------------------

--
-- Table structure for table `tingkatanbanten`
--

CREATE TABLE `tingkatanbanten` (
  `id_tingkatan` int(11) NOT NULL,
  `nama_tingkatan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tingkatanbanten`
--

INSERT INTO `tingkatanbanten` (`id_tingkatan`, `nama_tingkatan`) VALUES
(1, 'Utama'),
(2, 'Madya'),
(3, 'Nista'),
(4, 'Umum');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id_toko` int(11) NOT NULL,
  `nama_toko` varchar(100) NOT NULL,
  `alamat_toko` varchar(300) NOT NULL,
  `kota_toko` varchar(100) NOT NULL,
  `provinsi_toko` varchar(100) NOT NULL,
  `kodepos_toko` varchar(100) NOT NULL,
  `deskripsi_toko` varchar(400) NOT NULL,
  `catatan_toko` varchar(400) NOT NULL,
  `status_toko` varchar(50) NOT NULL,
  `foto_toko` varchar(100) NOT NULL,
  `id_wilayah` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id_toko`, `nama_toko`, `alamat_toko`, `kota_toko`, `provinsi_toko`, `kodepos_toko`, `deskripsi_toko`, `catatan_toko`, `status_toko`, `foto_toko`, `id_wilayah`) VALUES
(19, 'Toko Bu Ayu', 'Jalan WR Supratman Nomor 35 Denpasar', 'Denpasar', 'Bali', '80119', 'Toko yang menyediakan segala perlengkapan banten upacara di Bali dan melayani ke seluruh kota di Bali', 'Silahkan lengkapi orderan dengan memasukkan detail pada catatan pemesanan', 'Buka', 'BEBANTENAN-35.png', 2),
(20, 'Toko Nyoman', 'Jalan Raya Mas Sukawati', 'Gianyar', 'Bali', '1234', 'Toko yang menyediakan sarana dan prasarana berbagai upakara di Bali dan melayani seluruh daerah di seputaran Bali', 'Toko berada sesuai alamat, pemesanan detail bisa dicantumkan pada bagian deskripsi pemesanan.', 'Buka', 'BEBANTENAN-26.png', 4),
(26, 'Toko Mertha', 'Jalan Raya Lukluk Nomor 34 Mengwi, Badung', 'Badung', 'Bali', '12345', 'Toko yang menyediakan sarana prasarana perlegkapan banten di wilayah Bali dan sekitarnya', 'Toko buka setiap hari. Untuk para pemesan agar harap mencantumkan pemesanan pada box deskripsi pemesanan agar lebih detail', 'Buka', 'BEBANTENAN-34.png', 8),
(27, 'Griya Agung Ratu ', 'Jalan Raya Mas Ubud', 'Singaraja', 'Bali', '13231', 'ds', 'dsd', 'Buka', 'BEBANTENAN-35.png', 9),
(28, 'Toko Banten Adit', 'Jalan Teuku Umar Nomor 35 Denpasar', 'Denpasar', 'Bali', '80114', 'Toko yang menyediakan sarana perlengkapan banten di bali', 'Toko buka', 'Buka', 'BEBANTENAN-35.png', 2),
(29, 'Toko Banten Budiyasa', 'Jalan Raya Sangeh Nomor 35, Gianyar, Bali', 'Denpasar', 'Bali', '80991', 'Toko yang menyediakan sarana dan prasarana upakara di Bali khususnya di daerah gianyar', 'Toko buka setiap hari lokasi sama seperti alamat yang tertera. Tutup untuk hari libur bali', 'Buka', 'BEBANTENAN-35.png', 2),
(30, 'Toko Banten Susanto', 'Jalan Nusa Kambangan Nomor 45 Denpasar', 'Denpasar', 'Bali', '80119', 'Toko A', 'Toko B', 'Buka', 'BEBANTENAN-34.png', 2),
(31, 'Toko Putri Wahyuni', 'Jalan Teuku Umar Nomor 45 Denpasar', 'Denpasar', 'Bali', '80117', 'Toko A', 'Toko B', 'Buka', 'BEBANTENAN-26.png', 2);

--
-- Triggers `toko`
--
DELIMITER $$
CREATE TRIGGER `after_toko_deleted` AFTER DELETE ON `toko` FOR EACH ROW BEGIN
    	UPDATE penjual SET id_toko = 0 WHERE id_toko = old.id_toko;
        DELETE FROM banten WHERE id_toko = old.id_toko;
        DELETE FROM kategoribanten WHERE id_toko = old.id_toko;
        DELETE FROM ongkir WHERE id_toko = old.id_toko;
        DELETE FROM pembelian WHERE idtoko_pembelian = old.id_toko;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `id_wilayah` int(11) NOT NULL,
  `provinsi_wilayah` varchar(50) NOT NULL,
  `kota_wilayah` varchar(65) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `wilayah`
--

INSERT INTO `wilayah` (`id_wilayah`, `provinsi_wilayah`, `kota_wilayah`) VALUES
(2, 'Bali', 'Denpasar'),
(3, 'Bali', 'Tabanan'),
(4, 'Bali', 'Gianyar'),
(5, 'Bali', 'Karangasem'),
(6, 'Bali', 'Klungkung'),
(7, 'Bali', 'Jembrana'),
(8, 'Bali', 'Badung'),
(9, 'Bali', 'Singaraja'),
(10, 'Bali', 'Bangli');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `bank`
--
ALTER TABLE `bank`
  ADD PRIMARY KEY (`id_bank`);

--
-- Indexes for table `banten`
--
ALTER TABLE `banten`
  ADD PRIMARY KEY (`id_banten`);

--
-- Indexes for table `detailbanten`
--
ALTER TABLE `detailbanten`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `kategoribanten`
--
ALTER TABLE `kategoribanten`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `nota`
--
ALTER TABLE `nota`
  ADD PRIMARY KEY (`id_nota`);

--
-- Indexes for table `notifadmin`
--
ALTER TABLE `notifadmin`
  ADD PRIMARY KEY (`id_notifikasi`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id_ongkir`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `penjual`
--
ALTER TABLE `penjual`
  ADD PRIMARY KEY (`id_penjual`);

--
-- Indexes for table `tingkatanbanten`
--
ALTER TABLE `tingkatanbanten`
  ADD PRIMARY KEY (`id_tingkatan`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id_toko`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`id_wilayah`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bank`
--
ALTER TABLE `bank`
  MODIFY `id_bank` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `banten`
--
ALTER TABLE `banten`
  MODIFY `id_banten` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `detailbanten`
--
ALTER TABLE `detailbanten`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `kategoribanten`
--
ALTER TABLE `kategoribanten`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `nota`
--
ALTER TABLE `nota`
  MODIFY `id_nota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `notifadmin`
--
ALTER TABLE `notifadmin`
  MODIFY `id_notifikasi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id_ongkir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `penjual`
--
ALTER TABLE `penjual`
  MODIFY `id_penjual` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `tingkatanbanten`
--
ALTER TABLE `tingkatanbanten`
  MODIFY `id_tingkatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id_toko` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wilayah`
--
ALTER TABLE `wilayah`
  MODIFY `id_wilayah` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
