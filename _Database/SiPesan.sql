-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2021 at 12:39 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sipesan`
--

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `npm` char(20) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nama_mhs` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `jurusan` varchar(50) DEFAULT NULL,
  `semester` int(11) DEFAULT NULL,
  `foto_profil` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`npm`, `pass`, `nama_mhs`, `email`, `jurusan`, `semester`, `foto_profil`) VALUES
('18081010014', '$2y$10$jskgDEuY4A66A97BDasHC.AhzyjK2acZDX.z.8qsY19VVd6U4LQT6', 'Rizqi Yahya Mahendra', 'kiky.mahendra21@gmail.com', 'Teknik Informatika', 7, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `surat`
--

CREATE TABLE `surat` (
  `id` int(11) NOT NULL,
  `npm` char(20) NOT NULL,
  `no_surat` char(30) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `judul_surat` varchar(255) NOT NULL,
  `perusahaan` varchar(255) NOT NULL,
  `perihal_lengkap` varchar(1024) NOT NULL,
  `status_surat` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `surat`
--

INSERT INTO `surat` (`id`, `npm`, `no_surat`, `kategori`, `judul_surat`, `perusahaan`, `perihal_lengkap`, `status_surat`) VALUES
(1, '18081010014', 'MG.1/3/EKS/X/2020', 'Magang', 'Surat pengantar magang PT Bank Mandri Area Surabaya Gentengkail', 'PT Bank Mandiri Area Surabaya Gentengkail', 'menyatakan bahwa mahasiswa dengan data yang terlampir memohon untuk melakukan Praktik Kerja Lapangan pada PT Bank Mandiri Area Surabaya Gentengkail mulai dari tanggal 14 Maret 2021 sampai dengan tanggal 15 September 2021.', 'Tervalidasi');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `PASSWORD` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `PASSWORD`) VALUES
(1, 'admin', '$2y$10$v50XomNh4QCwLohjpofejeMgpOOVNS4Ma.USdIgn7jEXglMPhBl7u');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`npm`);

--
-- Indexes for table `surat`
--
ALTER TABLE `surat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `npm` (`npm`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `surat`
--
ALTER TABLE `surat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `surat`
--
ALTER TABLE `surat`
  ADD CONSTRAINT `surat_ibfk_1` FOREIGN KEY (`npm`) REFERENCES `mahasiswa` (`npm`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
