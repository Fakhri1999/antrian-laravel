-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 09 Mar 2020 pada 12.24
-- Versi server: 10.1.36-MariaDB
-- Versi PHP: 7.2.11

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
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `nama`) VALUES
(1, 'admin', 'admin', 'Firhan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `nomor_antrian` varchar(20) NOT NULL,
  `tanggal_pembuatan` varchar(22) NOT NULL,
  `jam_pembuatan` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `kepuasan` varchar(50) NOT NULL DEFAULT 'TIDAK MENGISI',
  `id_petugas` int(11) NOT NULL,
  `id_layanan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `antrian`
--

INSERT INTO `antrian` (`id`, `nomor_antrian`, `tanggal_pembuatan`, `jam_pembuatan`, `status`, `kepuasan`, `id_petugas`, `id_layanan`) VALUES
(0, '0', '0', '0', 0, '0', 0, 0),
(15, 'B000', '02-02-2020 23:20:40', '0', 1, '0', 0, 0),
(16, 'A000', '02-02-2020 23:28:05', '0', 1, '0', 0, 0),
(17, 'B001', '02-02-2020 23:51:18', '0', 1, '0', 0, 0),
(18, 'C001', '03-02-2020 21:28:02', '0', 1, '0', 0, 0),
(19, 'A001', '03-02-2020 21:29:52', '0', 1, '0', 0, 0),
(20, 'A002', '03-02-2020 21:31:39', '0', 1, '0', 0, 0),
(21, 'A003', '03-02-2020 21:32:06', '0', 1, '0', 0, 0),
(22, 'C002', '03-02-2020 21:34:24', '0', 1, '0', 0, 0),
(23, 'A004', '03-02-2020 21:47:38', '0', 1, '0', 0, 0),
(24, 'B001', '03-02-2020 21:59:12', '0', 1, '0', 0, 3),
(26, 'C001', '06-02-2020', '22:04:09', 1, '0', 0, 3),
(27, 'C001', '07-02-2020', '20:55:49', 1, '0', 0, 3),
(28, 'B001', '07-02-2020', '20:58:56', 1, '0', 0, 2),
(29, 'B002', '07-02-2020', '20:58:58', 1, '0', 0, 2),
(30, 'A001', '07-02-2020', '20:59:01', 1, '0', 0, 1),
(31, 'C002', '07-02-2020', '21:00:12', 1, '0', 0, 3),
(32, 'A002', '07-02-2020', '21:00:14', 1, '0', 0, 1),
(33, 'E001', '07-02-2020', '21:00:16', 1, '0', 0, 5),
(34, 'A001', '08-02-2020', '00:51:44', 10, '0', 2, 1),
(35, 'A002', '08-02-2020', '00:54:13', 10, '0', 2, 1),
(36, 'A001', '09-02-2020', '14:08:40', 10, 'TIDAK MENGISI', 1, 1),
(37, 'B001', '09-02-2020', '14:08:42', 1, 'TIDAK MENGISI', 0, 2),
(38, 'C001', '09-02-2020', '14:08:45', 1, 'TIDAK MENGISI', 0, 3),
(39, 'B002', '09-02-2020', '14:08:46', 1, 'TIDAK MENGISI', 0, 2),
(40, 'C002', '09-02-2020', '14:08:48', 1, 'TIDAK MENGISI', 0, 3),
(41, 'A002', '09-02-2020', '14:08:49', 1, 'TIDAK MENGISI', 0, 1),
(42, 'A003', '09-02-2020', '14:08:51', 1, 'TIDAK MENGISI', 0, 1),
(43, 'A004', '09-02-2020', '22:30:58', 1, 'TIDAK MENGISI', 0, 1),
(44, 'D001', '09-02-2020', '22:31:25', 1, 'TIDAK MENGISI', 0, 4),
(45, 'A005', '09-02-2020', '22:32:31', 1, 'TIDAK MENGISI', 0, 1),
(46, 'A006', '09-02-2020', '22:32:34', 1, 'TIDAK MENGISI', 0, 1),
(47, 'G001', '09-02-2020', '22:45:10', 1, 'TIDAK MENGISI', 0, 11),
(48, 'G002', '09-02-2020', '22:46:01', 1, 'TIDAK MENGISI', 0, 11),
(49, 'B003', '09-02-2020', '22:46:14', 1, 'TIDAK MENGISI', 0, 1),
(50, 'A007', '09-02-2020', '22:46:36', 1, 'TIDAK MENGISI', 0, 1),
(51, 'G003', '09-02-2020', '22:46:48', 1, 'TIDAK MENGISI', 0, 11),
(52, 'A001', '10-02-2020', '01:46:57', 10, 'PUAS', 2, 1),
(53, 'A002', '10-02-2020', '01:47:31', 10, 'TIDAK MENGISI', 2, 1),
(54, 'A003', '10-02-2020', '01:47:58', 10, '', 2, 1),
(55, 'A004', '10-02-2020', '09:37:22', 10, 'TIDAK MENGISI', 2, 1),
(56, 'B001', '10-02-2020', '09:37:25', 10, 'TIDAK MENGISI', 2, 2),
(57, 'A005', '10-02-2020', '09:37:27', 10, 'TIDAK MENGISI', 2, 1),
(58, 'B002', '10-02-2020', '10:02:58', 1, 'TIDAK MENGISI', 0, 2),
(59, 'A006', '10-02-2020', '10:07:25', 10, 'TIDAK MENGISI', 2, 1),
(60, 'A007', '10-02-2020', '10:08:09', 10, 'TIDAK MENGISI', 2, 1),
(61, 'B003', '10-02-2020', '10:08:14', 1, 'TIDAK MENGISI', 0, 2),
(62, 'C001', '11-02-2020', '22:17:42', 10, 'TIDAK MENGISI', 2, 3),
(63, 'C002', '11-02-2020', '22:17:44', 9, 'PUAS', 2, 3),
(64, 'B001', '11-02-2020', '22:17:45', 10, 'PUAS', 2, 2),
(65, 'A001', '11-02-2020', '22:17:48', 10, 'TIDAK MENGISI', 2, 1),
(66, 'A002', '11-02-2020', '22:32:07', 9, 'TIDAK MENGISI', 2, 1),
(67, 'B002', '11-02-2020', '22:32:10', 10, 'TIDAK MENGISI', 2, 2),
(68, 'C003', '11-02-2020', '22:32:12', 9, 'TIDAK MENGISI', 2, 3),
(69, 'B003', '11-02-2020', '22:32:14', 9, 'TIDAK PUAS', 2, 2),
(70, 'A003', '11-02-2020', '22:42:13', 9, 'TIDAK MENGISI', 2, 1),
(71, 'B004', '11-02-2020', '22:42:16', 10, 'TIDAK MENGISI', 2, 2),
(72, 'C004', '11-02-2020', '22:42:18', 10, 'TIDAK MENGISI', 2, 3),
(73, 'A004', '11-02-2020', '22:45:16', 10, 'PUAS', 2, 1),
(74, 'A005', '11-02-2020', '22:45:18', 10, 'TIDAK MENGISI', 2, 1),
(75, 'A006', '11-02-2020', '22:45:20', 10, 'TIDAK MENGISI', 2, 1),
(76, 'A007', '11-02-2020', '23:44:46', 10, 'TIDAK MENGISI', 2, 1),
(77, 'B005', '11-02-2020', '23:44:48', 10, 'TIDAK MENGISI', 2, 2),
(78, 'C005', '11-02-2020', '23:44:50', 1, 'TIDAK MENGISI', 0, 3),
(79, 'A008', '11-02-2020', '23:44:52', 10, 'TIDAK MENGISI', 2, 1),
(80, 'A009', '11-02-2020', '23:45:31', 10, 'TIDAK MENGISI', 2, 1),
(81, 'A010', '11-02-2020', '23:58:36', 10, 'TIDAK MENGISI', 2, 1),
(82, 'A011', '11-02-2020', '23:58:38', 10, 'TIDAK MENGISI', 2, 1),
(83, 'A012', '11-02-2020', '23:58:40', 10, 'TIDAK MENGISI', 2, 1),
(84, 'A013', '11-02-2020', '23:59:03', 10, 'TIDAK MENGISI', 2, 1),
(85, 'A014', '11-02-2020', '23:59:04', 10, 'TIDAK MENGISI', 2, 1),
(86, 'A015', '11-02-2020', '23:59:06', 1, 'TIDAK MENGISI', 0, 1),
(87, 'A016', '11-02-2020', '23:59:07', 1, 'TIDAK MENGISI', 0, 1),
(88, 'A001', '12-02-2020', '00:16:38', 9, 'TIDAK MENGISI', 2, 1),
(89, 'A002', '12-02-2020', '00:16:40', 10, 'PUAS', 2, 1),
(90, 'A003', '12-02-2020', '00:17:31', 9, 'TIDAK MENGISI', 2, 1),
(91, 'A004', '12-02-2020', '00:17:32', 10, 'TIDAK MENGISI', 2, 1),
(92, 'A005', '12-02-2020', '00:17:33', 10, 'TIDAK MENGISI', 1, 1),
(93, 'A006', '12-02-2020', '00:17:34', 1, 'TIDAK MENGISI', 0, 1),
(173, 'C001', '13-02-2020', '14:54:09', 1, 'TIDAK MENGISI', 0, 3),
(174, 'A001', '13-02-2020', '15:03:20', 10, 'TIDAK MENGISI', 2, 1),
(175, 'A002', '13-02-2020', '15:05:44', 10, 'TIDAK MENGISI', 2, 1),
(176, 'A003', '13-02-2020', '15:05:47', 10, 'TIDAK MENGISI', 2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `display`
--

CREATE TABLE `display` (
  `id` int(11) NOT NULL,
  `nama_perusahaan` varchar(255) DEFAULT NULL,
  `logo_perusahaan` varchar(60) DEFAULT NULL,
  `alamat_perusahaan` text,
  `running_text` text,
  `video_display` varchar(60) DEFAULT NULL,
  `slogan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `display`
--

INSERT INTO `display` (`id`, `nama_perusahaan`, `logo_perusahaan`, `alamat_perusahaan`, `running_text`, `video_display`, `slogan`) VALUES
(1, 'wada', 'logo.png', 'adw', 'awd', 'video.mp4', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `layanan`
--

CREATE TABLE `layanan` (
  `id` int(11) NOT NULL,
  `nama_layanan` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `layanan`
--

INSERT INTO `layanan` (`id`, `nama_layanan`, `status`, `urutan`) VALUES
(0, '-', 0, 0),
(1, 'NPWP / PKP', 1, 1),
(2, 'PELAPORAN & PERMOHONAN', 1, 2),
(3, 'KONSULTASI PERMOHONAN', 1, 3),
(4, 'KONSULTASI APLIKASI & eSPT', 0, 4),
(5, 'KONSULTASI WP BARU', 0, 5),
(6, 'eFAKTUR DAN SERTIFIKAT', 0, 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `loket`
--

CREATE TABLE `loket` (
  `id` int(11) NOT NULL,
  `nomor_loket` varchar(20) NOT NULL,
  `status` int(11) NOT NULL,
  `id_petugas` int(11) NOT NULL DEFAULT '0',
  `id_antrian` int(11) NOT NULL,
  `urutan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `loket`
--

INSERT INTO `loket` (`id`, `nomor_loket`, `status`, `id_petugas`, `id_antrian`, `urutan`) VALUES
(1, 'Loket 1', 1, 2, 176, 1),
(2, 'Loket 2', 1, 1, 92, 2),
(3, 'Loket 3', 0, 0, 0, 3),
(4, 'Loket 4', 0, 0, 0, 4),
(5, 'Loket 5', 0, 0, 0, 5),
(6, 'Loket 6', 0, 0, 0, 6),
(7, 'Loket 7', 0, 0, 0, 7),
(8, 'Loket 8', 0, 0, 0, 8),
(9, 'Loket 9', 0, 0, 0, 9);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int(11) NOT NULL,
  `npwp` varchar(16) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(60) DEFAULT NULL,
  `no_telp` varchar(100) DEFAULT NULL,
  `kode_pendaftaran` varchar(60) DEFAULT NULL,
  `status` enum('0','1') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `petugas`
--

CREATE TABLE `petugas` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `pin` varchar(50) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `petugas`
--

INSERT INTO `petugas` (`id`, `username`, `nama`, `pin`, `status`) VALUES
(0, '', '', 'null', 0),
(1, 'firhan', 'M. Firhan Azmi Nor', '400', 1),
(2, 'fakhri', 'Fakhri', '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `display`
--
ALTER TABLE `display`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `layanan`
--
ALTER TABLE `layanan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `loket`
--
ALTER TABLE `loket`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=177;

--
-- AUTO_INCREMENT untuk tabel `display`
--
ALTER TABLE `display`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `layanan`
--
ALTER TABLE `layanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `loket`
--
ALTER TABLE `loket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `petugas`
--
ALTER TABLE `petugas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
