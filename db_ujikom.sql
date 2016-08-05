-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 28, 2016 at 02:49 PM
-- Server version: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ujikom`
--

-- --------------------------------------------------------

--
-- Stand-in structure for view `qw_type`
--
CREATE TABLE IF NOT EXISTS `qw_type` (
`IDType` varchar(7)
,`NmType` varchar(20)
,`KodeMerk` varchar(7)
,`NmMerk` varchar(20)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `qw_user`
--
CREATE TABLE IF NOT EXISTS `qw_user` (
`NIK` varchar(20)
,`NmKaryawan` varchar(50)
,`AlmtKaryawan` text
,`TelpKaryawan` varchar(20)
,`Foto` varchar(200)
,`UserName` varchar(15)
,`PassWord` varchar(50)
,`TypeUser` varchar(15)
);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenis_service`
--

CREATE TABLE IF NOT EXISTS `tb_jenis_service` (
  `IDJenisService` varchar(7) NOT NULL,
  `NmJenisService` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenis_service`
--

INSERT INTO `tb_jenis_service` (`IDJenisService`, `NmJenisService`) VALUES
('JS001', 'Tambal Ban'),
('JS002', 'Ganti Suku Cadang'),
('JS003', 'Kerusakan ACU'),
('JS004', 'Ganti Oli');

-- --------------------------------------------------------

--
-- Table structure for table `tb_karyawan`
--

CREATE TABLE IF NOT EXISTS `tb_karyawan` (
  `NIK` varchar(20) NOT NULL,
  `NmKaryawan` varchar(50) NOT NULL,
  `AlmtKaryawan` text NOT NULL,
  `TelpKaryawan` varchar(20) NOT NULL,
  `Foto` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_karyawan`
--

INSERT INTO `tb_karyawan` (`NIK`, `NmKaryawan`, `AlmtKaryawan`, `TelpKaryawan`, `Foto`) VALUES
('1130404', 'admin', 'admin', 'admin', 'logistics-delivery-45764.png'),
('11304048', 'Nurul Ramdan', 'Cibedug', '0852121831672', 'photo.jpg'),
('11304049', 'dadan', 'Cibedug', '08972917497191', 'konsumen.png');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kendaraan`
--

CREATE TABLE IF NOT EXISTS `tb_kendaraan` (
  `NoPlat` varchar(20) NOT NULL,
  `Tahun` varchar(5) NOT NULL,
  `TarifPerJam` int(9) NOT NULL,
  `StatusRental` int(1) NOT NULL,
  `KodePemilik` varchar(7) NOT NULL,
  `IDType` varchar(7) NOT NULL,
  `TglRiwayat` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_kendaraan`
--

INSERT INTO `tb_kendaraan` (`NoPlat`, `Tahun`, `TarifPerJam`, `StatusRental`, `KodePemilik`, `IDType`, `TglRiwayat`) VALUES
('B1514AB', '2005', 20000, 0, '11003', 'T001', '2016-02-28'),
('D1828TE', '1995', 9000, 0, '11005', 'T006', '2016-02-28'),
('D9021GZ', '2003', 21000, 1, '11003', 'T003', '2016-02-28'),
('D9891AG', '1965', 17000, 2, '11006', 'T004', '2016-02-28'),
('F9812ZR', '2002', 17000, 0, '11005', 'T002', '2016-02-28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_login`
--

CREATE TABLE IF NOT EXISTS `tb_login` (
  `UserName` varchar(15) NOT NULL,
  `PassWord` varchar(50) NOT NULL,
  `TypeUser` varchar(15) NOT NULL,
  `NIK` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_login`
--

INSERT INTO `tb_login` (`UserName`, `PassWord`, `TypeUser`, `NIK`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'administrator', '1130404'),
('karyawan', 'ac43724f16e9241d990427ab7c8f4228', 'karyawan', '11304049'),
('nadila', '928741fe16ae38595d8eb190dc2485dc', 'karyawan', '1130819871'),
('Ramdannur', '21232f297a57a5a743894a0e4a801fc3', 'administrator', '11304048');

-- --------------------------------------------------------

--
-- Table structure for table `tb_merk`
--

CREATE TABLE IF NOT EXISTS `tb_merk` (
  `KodeMerk` varchar(7) NOT NULL,
  `NmMerk` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_merk`
--

INSERT INTO `tb_merk` (`KodeMerk`, `NmMerk`) VALUES
('M001', 'Honda'),
('M002', 'Toyota'),
('M003', 'Innova'),
('M004', 'Lamborgini'),
('M005', 'Xenia'),
('M006', 'BMW'),
('M007', 'Ferari'),
('M008', 'APV'),
('M009', 'Esemka');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan`
--

CREATE TABLE IF NOT EXISTS `tb_pelanggan` (
  `NoKTP` varchar(20) NOT NULL,
  `NmPelanggan` varchar(50) NOT NULL,
  `AlmtPelanggan` text NOT NULL,
  `TelpPelanggan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelanggan`
--

INSERT INTO `tb_pelanggan` (`NoKTP`, `NmPelanggan`, `AlmtPelanggan`, `TelpPelanggan`) VALUES
('99801283182731827', 'Febri Heriawan', 'Cisarua', '089717248172'),
('998078774540001', 'Vincent Saepudin', 'Jalan Raya Padjajaran, Bogor', '089228314731'),
('998830179102747', 'Uus Darsono', 'Jalan Raya Tajur', '0898271472716'),
('998912831991872', 'Gery Prakoso', 'Cisarua', '098129381983'),
('99901821', 'Ghazy Fauzan', 'Cisarua', '899823741'),
('999099123', 'Lukman Hakim', 'Cisarua', '898239422'),
('99982918921831', 'Christian Febianus Renggi', 'Caringin', '089717247472'),
('99989879871', 'Iqbal Agung ', 'Cicurug', '0898981273123'),
('9999266647626276726', 'Ricky Prayogi', 'Cikopo', '0897777743453');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pelanggan_backup`
--

CREATE TABLE IF NOT EXISTS `tb_pelanggan_backup` (
  `NoKTP` varchar(20) NOT NULL,
  `NmPelanggan` varchar(50) NOT NULL,
  `AlmtPelanggan` text NOT NULL,
  `TelpPelanggan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pelanggan_backup`
--

INSERT INTO `tb_pelanggan_backup` (`NoKTP`, `NmPelanggan`, `AlmtPelanggan`, `TelpPelanggan`) VALUES
('99801283182731827', 'Febri Heriawan', 'Cisarua', '089717248172'),
('998078774540001', 'Vincent Saepudin', 'Jalan Raya Padjajaran, Bogor', '089228314731'),
('998830179102747', 'Uus Darsono', 'Jalan Raya Tajur', '0898271472716'),
('998912831991872', 'Gery Prakoso', 'Cisarua', '098129381983'),
('99982918921831', 'Christian Febianus Renggi', 'Caringin', '089717247472'),
('9999266647626276726', 'Ricky Prayogi', 'Cikopo', '0897777743453');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pemilik`
--

CREATE TABLE IF NOT EXISTS `tb_pemilik` (
  `KodePemilik` varchar(7) NOT NULL,
  `NmPemilik` varchar(25) NOT NULL,
  `AlmtPemilik` text NOT NULL,
  `TelpPemilik` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_pemilik`
--

INSERT INTO `tb_pemilik` (`KodePemilik`, `NmPemilik`, `AlmtPemilik`, `TelpPemilik`) VALUES
('11003', 'Usman Purwantono', 'Jalan Raya Puncak, Bogor', '082518291482'),
('11005', 'Nanang Hariono', 'Cikereteg, Bogor', '0858281289812'),
('11006', 'Peri Hermawan', 'Cisarua', '089892734711');

-- --------------------------------------------------------

--
-- Table structure for table `tb_service`
--

CREATE TABLE IF NOT EXISTS `tb_service` (
  `KodeService` varchar(7) NOT NULL,
  `NoPlat` varchar(20) NOT NULL,
  `IDJenisService` varchar(7) NOT NULL,
  `TglService` date NOT NULL,
  `BiayaService` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_service`
--

INSERT INTO `tb_service` (`KodeService`, `NoPlat`, `IDJenisService`, `TglService`, `BiayaService`) VALUES
('S00001', 'F9812ZR', 'JS003', '2016-02-10', 17000),
('S00002', 'D9021GZ', 'JS004', '2016-02-22', 30000),
('S00003', 'D9021GZ', 'JS002', '2016-02-22', 20000),
('S00004', 'B1514AB', 'JS001', '2016-02-26', 30000),
('S00005', 'D9891AG', 'JS002', '2016-02-28', 400000),
('S00006', 'B1514AB', 'JS003', '2016-02-25', 42000),
('S00007', 'D1828TE', 'JS002', '2016-02-29', 70000),
('S00008', 'D9891AG', 'JS003', '2016-02-11', 123),
('S00009', 'D9891AG', 'JS002', '2016-02-28', 10000),
('S00010', 'D9891AG', 'JS002', '2016-02-29', 20000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_setoran`
--

CREATE TABLE IF NOT EXISTS `tb_setoran` (
  `NoSetoran` varchar(7) NOT NULL,
  `TglSetoran` date NOT NULL,
  `KodePemilik` varchar(7) NOT NULL,
  `Jumlah` int(9) NOT NULL,
  `NIK` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_setoran`
--

INSERT INTO `tb_setoran` (`NoSetoran`, `TglSetoran`, `KodePemilik`, `Jumlah`, `NIK`) VALUES
('R021900', '2016-02-28', '11003', 2318500, '11304048'),
('R021905', '2016-02-28', '11003', 3270000, '11304048'),
('R021906', '2016-02-28', '11006', 1620000, '1130404'),
('R021907', '2016-02-28', '11005', 2020000, '11304048'),
('R021908', '2016-02-28', '11006', 3183000, '11304048'),
('R021909', '2016-02-28', '11003', 1700000, '1130404'),
('R021910', '2016-02-28', '11005', 117500, '11304049');

-- --------------------------------------------------------

--
-- Table structure for table `tb_sopir`
--

CREATE TABLE IF NOT EXISTS `tb_sopir` (
  `IDSopir` varchar(7) NOT NULL,
  `NmSopir` varchar(25) NOT NULL,
  `AlmtSopir` text NOT NULL,
  `TelpSopir` varchar(20) NOT NULL,
  `NoSim` varchar(30) NOT NULL,
  `TarifPerJam` int(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_sopir`
--

INSERT INTO `tb_sopir` (`IDSopir`, `NmSopir`, `AlmtSopir`, `TelpSopir`, `NoSim`, `TarifPerJam`) VALUES
('0', 'Tanpa Sopir', '0', '0', '0', 0),
('10203', 'Endang Suprato', 'Jalan Sudirman', '0989172371', '98721837391279317', 10000),
('14201', 'Ujang', 'Cisarua', '089218741872', '211123131273918723', 6000),
('14202', 'Bejo Subroto', 'Jalan Raya Puncak, Bogor', '085281939182', '2111231329818371872', 7000);

-- --------------------------------------------------------

--
-- Table structure for table `tb_transaksi_sewa`
--

CREATE TABLE IF NOT EXISTS `tb_transaksi_sewa` (
  `NoTransaksi` varchar(7) NOT NULL,
  `NoKTP` varchar(20) NOT NULL,
  `NoPlat` varchar(20) NOT NULL,
  `TglPesan` date NOT NULL,
  `TglPinjam` date NOT NULL,
  `JamPinjam` time NOT NULL,
  `TglRencKembali` date NOT NULL,
  `JamRencKembali` time NOT NULL,
  `TglRealKembali` date NOT NULL,
  `JamRealKembali` time NOT NULL,
  `Denda` int(9) NOT NULL,
  `KilometerPinjam` int(12) NOT NULL,
  `KilometerKembali` int(12) NOT NULL,
  `BBMPinjam` int(6) NOT NULL,
  `BBMKembali` int(5) NOT NULL,
  `KondisiMobilPinjam` varchar(25) NOT NULL,
  `KondisiMobilKembali` varchar(25) NOT NULL,
  `Kerusakan` text NOT NULL,
  `BiayaKerusakan` int(10) NOT NULL,
  `BiayaBBM` int(9) NOT NULL,
  `IDSopir` varchar(7) NOT NULL,
  `StatusBayar` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_transaksi_sewa`
--

INSERT INTO `tb_transaksi_sewa` (`NoTransaksi`, `NoKTP`, `NoPlat`, `TglPesan`, `TglPinjam`, `JamPinjam`, `TglRencKembali`, `JamRencKembali`, `TglRealKembali`, `JamRealKembali`, `Denda`, `KilometerPinjam`, `KilometerKembali`, `BBMPinjam`, `BBMKembali`, `KondisiMobilPinjam`, `KondisiMobilKembali`, `Kerusakan`, `BiayaKerusakan`, `BiayaBBM`, `IDSopir`, `StatusBayar`) VALUES
('R021900', '99801283182731827', 'D9021GZ', '2016-02-27', '2016-02-25', '14:01:00', '2016-02-26', '22:58:00', '2016-02-28', '23:58:00', 777000, 200, 300, 123, 120, 'baik', 'baik', 'Tidak Ada', 0, 22500, '14202', 1),
('R021905', '9999266647626276726', 'B1514AB', '2016-02-25', '2016-02-24', '00:13:00', '2016-02-28', '14:03:00', '2016-02-28', '11:57:00', 0, 113, 130, 9, 5, 'baik', 'baik', 'Tidak Ada', 0, 30000, '10203', 1),
('R021906', '998078774540001', 'D9891AG', '2016-02-28', '2016-02-25', '23:58:00', '2016-02-27', '12:58:00', '2016-02-28', '11:58:00', 272000, 400, 928, 12, 123, 'baik', 'rusak', 'Tidak Ada', 0, 0, '10203', 1),
('R021907', '99801283182731827', 'D1828TE', '2015-11-20', '2015-11-29', '22:57:00', '2015-11-30', '23:58:00', '2015-12-03', '11:58:00', 19305000, 20, 300, 41, 35, 'baik', 'rusak', 'Kaca Pecah', 700000, 45000, '14201', 1),
('R021908', '998912831991872', 'D9891AG', '2016-01-01', '2016-01-04', '23:58:00', '2016-01-08', '02:59:00', '2016-01-10', '11:58:00', 20910000, 300, 351, 30, 28, 'baik', 'baik', 'Tidak Ada', 0, 15000, '14202', 1),
('R021909', '998830179102747', 'B1514AB', '2016-02-28', '2016-01-29', '11:58:00', '2016-01-30', '11:58:00', '2016-02-02', '00:57:00', 13880000, 38, 40, 9, 10, 'baik', 'rusak', 'Tidak Ada', 0, 0, '0', 1),
('R021910', '998830179102747', 'F9812ZR', '2016-02-28', '2016-02-29', '12:59:00', '2016-03-03', '12:59:00', '2016-02-28', '12:59:00', 0, 400, 459, 20, 15, 'baik', 'rusak', 'Kaca Pecah', 80000, 37500, '14201', 1),
('R021911', '99989879871', 'D9021GZ', '2016-02-28', '2016-02-29', '12:31:00', '2016-02-25', '23:58:00', '0000-00-00', '00:00:00', 0, 90, 0, 45, 0, 'baik', '', '', 0, 0, '14201', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_type`
--

CREATE TABLE IF NOT EXISTS `tb_type` (
  `IDType` varchar(7) NOT NULL,
  `NmType` varchar(20) NOT NULL,
  `KodeMerk` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_type`
--

INSERT INTO `tb_type` (`IDType`, `NmType`, `KodeMerk`) VALUES
('T001', 'SUV', 'M002'),
('T002', 'Chooper', 'M006'),
('T003', 'Coupe', 'M001'),
('T004', 'Mini van', 'M002'),
('T006', 'Sedan', 'M001'),
('T007', 'Jip', 'M002');

-- --------------------------------------------------------

--
-- Structure for view `qw_type`
--
DROP TABLE IF EXISTS `qw_type`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qw_type` AS select `tb_type`.`IDType` AS `IDType`,`tb_type`.`NmType` AS `NmType`,`tb_type`.`KodeMerk` AS `KodeMerk`,`tb_merk`.`NmMerk` AS `NmMerk` from (`tb_type` join `tb_merk` on((`tb_merk`.`KodeMerk` = `tb_type`.`KodeMerk`)));

-- --------------------------------------------------------

--
-- Structure for view `qw_user`
--
DROP TABLE IF EXISTS `qw_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `qw_user` AS select `tb_karyawan`.`NIK` AS `NIK`,`tb_karyawan`.`NmKaryawan` AS `NmKaryawan`,`tb_karyawan`.`AlmtKaryawan` AS `AlmtKaryawan`,`tb_karyawan`.`TelpKaryawan` AS `TelpKaryawan`,`tb_karyawan`.`Foto` AS `Foto`,`tb_login`.`UserName` AS `UserName`,`tb_login`.`PassWord` AS `PassWord`,`tb_login`.`TypeUser` AS `TypeUser` from (`tb_karyawan` join `tb_login` on((`tb_karyawan`.`NIK` = `tb_login`.`NIK`)));

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_jenis_service`
--
ALTER TABLE `tb_jenis_service`
  ADD PRIMARY KEY (`IDJenisService`);

--
-- Indexes for table `tb_karyawan`
--
ALTER TABLE `tb_karyawan`
  ADD PRIMARY KEY (`NIK`);

--
-- Indexes for table `tb_kendaraan`
--
ALTER TABLE `tb_kendaraan`
  ADD PRIMARY KEY (`NoPlat`);

--
-- Indexes for table `tb_login`
--
ALTER TABLE `tb_login`
  ADD PRIMARY KEY (`UserName`);

--
-- Indexes for table `tb_merk`
--
ALTER TABLE `tb_merk`
  ADD PRIMARY KEY (`KodeMerk`);

--
-- Indexes for table `tb_pelanggan`
--
ALTER TABLE `tb_pelanggan`
  ADD PRIMARY KEY (`NoKTP`);

--
-- Indexes for table `tb_pelanggan_backup`
--
ALTER TABLE `tb_pelanggan_backup`
  ADD PRIMARY KEY (`NoKTP`);

--
-- Indexes for table `tb_pemilik`
--
ALTER TABLE `tb_pemilik`
  ADD PRIMARY KEY (`KodePemilik`);

--
-- Indexes for table `tb_service`
--
ALTER TABLE `tb_service`
  ADD PRIMARY KEY (`KodeService`);

--
-- Indexes for table `tb_setoran`
--
ALTER TABLE `tb_setoran`
  ADD PRIMARY KEY (`NoSetoran`);

--
-- Indexes for table `tb_sopir`
--
ALTER TABLE `tb_sopir`
  ADD PRIMARY KEY (`IDSopir`);

--
-- Indexes for table `tb_transaksi_sewa`
--
ALTER TABLE `tb_transaksi_sewa`
  ADD PRIMARY KEY (`NoTransaksi`);

--
-- Indexes for table `tb_type`
--
ALTER TABLE `tb_type`
  ADD PRIMARY KEY (`IDType`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
