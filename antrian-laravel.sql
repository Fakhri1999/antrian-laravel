-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2020 at 07:02 AM
-- Server version: 8.0.13-4
-- PHP Version: 7.2.24-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antrian-laravel`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL
);

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama`) VALUES
(1, 'admin', 'admin', 'Firhan');

-- --------------------------------------------------------

--
-- Table structure for table `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `nomor_antrian` varchar(20) NOT NULL,
  `waktu_pembuatan` varchar(22) NOT NULL,
  `pilihan_layanan` int(11) NOT NULL,
  `status` int(11) NOT NULL
);

--
-- Dumping data for table `antrian`
--

INSERT INTO `antrian` (`id`, `nomor_antrian`, `waktu_pembuatan`, `pilihan_layanan`, `status`) VALUES
(15, 'B000', '02-02-2020 23:20:40', 0, 1),
(16, 'A000', '02-02-2020 23:28:05', 0, 1),
(17, 'B001', '02-02-2020 23:51:18', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loket`
--

CREATE TABLE `loket` (
  `id` int(11) NOT NULL,
  `nomor_loket` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL DEFAULT '0',
  `nomor_antrian` varchar(50) NOT NULL
);

--
-- Dumping data for table `loket`
--

INSERT INTO `loket` (`id`, `nomor_loket`, `status`, `id_petugas`, `nomor_antrian`) VALUES
(1, 'Loket 1', 0, 1, ''),
(2, 'Loket 2', 0, 0, ''),
(3, 'Loket 3', 0, 0, ''),
(4, 'Loket 4', 0, 0, ''),
(5, 'Loket 5', 0, 0, ''),
(6, 'Loket 6', 0, 0, ''),
(7, 'Loket 7', 0, 0, ''),
(8, 'Loket 8', 0, 0, ''),
(9, 'Loket 9', 0, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `pin` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`id`, `username`, `nama`, `pin`, `status`) VALUES
(1, 'hannyen', 'M. Firhan Azmi Nor', '400', 1),
(2, 'fakhri', 'Fakrhi Imaduddin', '385', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loket`
--
ALTER TABLE `loket`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loket`
--
ALTER TABLE `loket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
