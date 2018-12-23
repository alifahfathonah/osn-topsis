-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 14, 2018 at 06:16 PM
-- Server version: 10.0.34-MariaDB-0ubuntu0.16.04.1
-- PHP Version: 7.2.6-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `osn_topsis`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `kelas` varchar(20) NOT NULL,
  `no_induk` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `alternatif`
--

INSERT INTO `alternatif` (`id`, `nama`, `kelas`, `no_induk`) VALUES
(8, 'A1', '2', 1111),
(9, 'A2', '2', 1112),
(10, 'A3', '1', 1113),
(11, 'A4', '3', 1114),
(12, 'A5', '1', 1115),
(13, 'Andre', '12 Science 6', 2147483647),
(14, 'dani', 'asda', 123123123);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id` int(11) NOT NULL,
  `kode` varchar(20) NOT NULL,
  `name` varchar(60) NOT NULL,
  `bobot` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria`
--

INSERT INTO `kriteria` (`id`, `kode`, `name`, `bobot`) VALUES
(1, 'NIPA', 'Nilai test IPA', 4),
(2, 'NMTK', 'Nilai tes Matematika', 4),
(3, 'NP', 'Nilai Praktek', 4),
(4, 'NRR', 'Nilai Rata-rata Raport', 2),
(5, 'PBP', 'Poin di BP', 3),
(6, 'CA', 'Catatan ke-Alpa-an', 1),
(7, 'CS', 'Catatan Sakit', 2);

-- --------------------------------------------------------

--
-- Table structure for table `kriteria_rating`
--

CREATE TABLE `kriteria_rating` (
  `id` int(11) NOT NULL,
  `kriteria_id` int(11) NOT NULL,
  `rating_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kriteria_rating`
--

INSERT INTO `kriteria_rating` (`id`, `kriteria_id`, `rating_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 2, 1),
(7, 2, 2),
(8, 2, 3),
(9, 2, 4),
(10, 2, 5),
(11, 3, 1),
(12, 3, 2),
(13, 3, 3),
(14, 3, 4),
(15, 3, 5),
(16, 4, 1),
(17, 4, 2),
(18, 4, 3),
(19, 4, 4),
(20, 4, 5),
(21, 5, 6),
(22, 5, 7),
(23, 5, 8),
(24, 5, 9),
(25, 6, 10),
(26, 6, 11),
(27, 6, 12),
(28, 6, 13),
(29, 7, 14),
(30, 7, 15),
(31, 7, 16);

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `rating` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rating`
--

INSERT INTO `rating` (`id`, `name`, `rating`, `keterangan`) VALUES
(1, '&lt;= 60', 1, 'Sangat Kurang'),
(2, '61 - 70', 2, 'Kurang'),
(3, '71 - 80', 3, 'Cukup'),
(4, '81 - 90', 4, 'Baik'),
(5, '91 - 100', 5, 'Sangat Baik'),
(6, '>= 31', 1, 'Tidak Disiplin'),
(7, '21 - 30', 2, 'Kurang Disiplin'),
(8, '11 - 20', 3, 'Cukup Disiplin'),
(9, '0 - 10', 4, 'Sangat Disiplin'),
(10, '>= 3', 1, 'Sangat Buruk'),
(11, '2', 2, 'Buruk'),
(12, '1', 3, 'Baik'),
(13, '0', 4, 'Sangat Baik'),
(14, '>=4', 1, 'Buruk'),
(15, '2 - 3', 2, 'Cukup'),
(16, '0 - 1', 3, 'Baik');

-- --------------------------------------------------------

--
-- Table structure for table `topsis`
--

CREATE TABLE `topsis` (
  `id` int(11) NOT NULL,
  `alternatif_id` int(11) NOT NULL,
  `kriteria_id` int(11) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `topsis`
--

INSERT INTO `topsis` (`id`, `alternatif_id`, `kriteria_id`, `nilai`) VALUES
(22, 8, 1, 4),
(23, 8, 2, 4),
(24, 8, 3, 3),
(25, 8, 4, 3),
(26, 8, 5, 3),
(27, 8, 6, 4),
(28, 8, 7, 3),
(29, 9, 1, 3),
(30, 9, 2, 5),
(31, 9, 3, 4),
(32, 9, 4, 5),
(33, 9, 5, 4),
(34, 9, 6, 4),
(35, 9, 7, 3),
(36, 10, 1, 3),
(37, 10, 2, 4),
(38, 10, 3, 4),
(39, 10, 4, 3),
(40, 10, 5, 2),
(41, 10, 6, 3),
(42, 10, 7, 2),
(57, 11, 1, 4),
(58, 11, 2, 4),
(59, 11, 3, 3),
(60, 11, 4, 3),
(61, 11, 5, 3),
(62, 11, 6, 4),
(63, 11, 7, 3),
(64, 12, 1, 5),
(65, 12, 2, 5),
(66, 12, 3, 5),
(67, 12, 4, 4),
(68, 12, 5, 4),
(69, 12, 6, 3),
(70, 12, 7, 3),
(71, 13, 1, 5),
(72, 13, 2, 5),
(73, 13, 3, 5),
(74, 13, 4, 5),
(75, 13, 5, 4),
(76, 13, 6, 4),
(77, 13, 7, 3);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_kriteria_rating`
--
CREATE TABLE `v_kriteria_rating` (
`kode` varchar(20)
,`k_name` varchar(60)
,`bobot` double
,`r_name` varchar(50)
,`rating` double
,`keterangan` text
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `v_topsis`
--
CREATE TABLE `v_topsis` (
`id` int(11)
,`alt_id` int(11)
,`krt_id` int(11)
,`nilai` double
,`nama` varchar(50)
,`kelas` varchar(20)
,`no_induk` int(11)
,`kode` varchar(20)
,`name` varchar(60)
,`bobot` double
);

-- --------------------------------------------------------

--
-- Structure for view `v_kriteria_rating`
--
DROP TABLE IF EXISTS `v_kriteria_rating`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_kriteria_rating`  AS  select `kriteria`.`kode` AS `kode`,`kriteria`.`name` AS `k_name`,`kriteria`.`bobot` AS `bobot`,`rating`.`name` AS `r_name`,`rating`.`rating` AS `rating`,`rating`.`keterangan` AS `keterangan` from ((`kriteria_rating` join `kriteria` on((`kriteria_rating`.`kriteria_id` = `kriteria`.`id`))) join `rating` on((`kriteria_rating`.`rating_id` = `rating`.`id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `v_topsis`
--
DROP TABLE IF EXISTS `v_topsis`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `v_topsis`  AS  select `topsis`.`id` AS `id`,`topsis`.`alternatif_id` AS `alt_id`,`topsis`.`kriteria_id` AS `krt_id`,`topsis`.`nilai` AS `nilai`,`alternatif`.`nama` AS `nama`,`alternatif`.`kelas` AS `kelas`,`alternatif`.`no_induk` AS `no_induk`,`kriteria`.`kode` AS `kode`,`kriteria`.`name` AS `name`,`kriteria`.`bobot` AS `bobot` from ((`topsis` join `alternatif` on((`alternatif`.`id` = `topsis`.`alternatif_id`))) join `kriteria` on((`kriteria`.`id` = `topsis`.`kriteria_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kriteria_rating`
--
ALTER TABLE `kriteria_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kriteria_id` (`kriteria_id`,`rating_id`),
  ADD KEY `kriteria_rating_ibfk_2` (`rating_id`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `topsis`
--
ALTER TABLE `topsis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `alternatif_id` (`alternatif_id`),
  ADD KEY `kriteria_id` (`kriteria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alternatif`
--
ALTER TABLE `alternatif`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `kriteria`
--
ALTER TABLE `kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `kriteria_rating`
--
ALTER TABLE `kriteria_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `topsis`
--
ALTER TABLE `topsis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `kriteria_rating`
--
ALTER TABLE `kriteria_rating`
  ADD CONSTRAINT `kriteria_rating_ibfk_1` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kriteria_rating_ibfk_2` FOREIGN KEY (`rating_id`) REFERENCES `rating` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `topsis`
--
ALTER TABLE `topsis`
  ADD CONSTRAINT `topsis_ibfk_1` FOREIGN KEY (`alternatif_id`) REFERENCES `alternatif` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `topsis_ibfk_2` FOREIGN KEY (`kriteria_id`) REFERENCES `kriteria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
