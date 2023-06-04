-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2023 at 08:12 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `workout_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_latihan`
--

CREATE TABLE `jadwal_latihan` (
  `id_jadwal_latihan` int(11) NOT NULL,
  `tanggal_latihan` datetime NOT NULL,
  `status` enum('BELUM','SUDAH') NOT NULL,
  `id_latihan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jadwal_latihan`
--

INSERT INTO `jadwal_latihan` (`id_jadwal_latihan`, `tanggal_latihan`, `status`, `id_latihan`, `id_user`) VALUES
(5, '2023-06-04 12:16:00', 'SUDAH', 3, 1),
(6, '2023-06-04 12:21:00', 'BELUM', 4, 1),
(8, '2023-06-04 12:41:00', 'SUDAH', 4, 1),
(9, '2023-06-04 16:51:00', 'SUDAH', 5, 2),
(10, '2023-06-04 12:52:00', 'BELUM', 5, 2),
(12, '2023-06-04 13:03:00', 'SUDAH', 7, 2);

-- --------------------------------------------------------

--
-- Table structure for table `latihan`
--

CREATE TABLE `latihan` (
  `id_latihan` int(11) NOT NULL,
  `nama_latihan` varchar(100) NOT NULL,
  `durasi` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `latihan`
--

INSERT INTO `latihan` (`id_latihan`, `nama_latihan`, `durasi`, `id_user`) VALUES
(1, 'Squad Jump', 12000, 1),
(3, 'Joging', 6000, 1),
(4, 'Plank', 6500, 1),
(5, 'Squad Jump', 6000, 2),
(6, 'push up', 60, 2),
(7, 'Joging', 12000, 2);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `email`) VALUES
(1, 'yaasmiin123', '$2y$10$ya43QB2rPJi.CUo9Vp03A.rJ7dw8WLsHbYQFrK8KYeuxyj/i4OT/y', 'yaasmiin123@gmail.com'),
(2, 'nuhaa', '$2y$10$FrrdBHlncpVtzzbJMqnu1OBJO5yCqhpdFB8YhKEuCz0MzMMwSKLzO', 'nuhaa@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jadwal_latihan`
--
ALTER TABLE `jadwal_latihan`
  ADD PRIMARY KEY (`id_jadwal_latihan`),
  ADD KEY `id_latihan` (`id_latihan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `latihan`
--
ALTER TABLE `latihan`
  ADD PRIMARY KEY (`id_latihan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `jadwal_latihan`
--
ALTER TABLE `jadwal_latihan`
  MODIFY `id_jadwal_latihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `latihan`
--
ALTER TABLE `latihan`
  MODIFY `id_latihan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwal_latihan`
--
ALTER TABLE `jadwal_latihan`
  ADD CONSTRAINT `jadwal_latihan_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jadwal_latihan_ibfk_3` FOREIGN KEY (`id_latihan`) REFERENCES `latihan` (`id_latihan`) ON DELETE CASCADE;

--
-- Constraints for table `latihan`
--
ALTER TABLE `latihan`
  ADD CONSTRAINT `latihan_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
