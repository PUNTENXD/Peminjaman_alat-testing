-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2026 at 09:26 AM
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
-- Database: `ukk_peminjaman_alat`
--

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` bigint(20) NOT NULL,
  `id_user` bigint(20) NOT NULL,
  `id_alat` bigint(20) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tgl_pinjam` datetime NOT NULL,
  `tgl_rencana_kembali` date NOT NULL,
  `tgl_kembali` datetime DEFAULT NULL,
  `status` enum('pending','pinjam','kembali') NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_user`, `id_alat`, `jumlah`, `tgl_pinjam`, `tgl_rencana_kembali`, `tgl_kembali`, `status`, `create_at`, `update_at`) VALUES
(1, 3, 2, 2, '2026-02-12 00:00:00', '2026-02-13', '2026-02-12 00:00:00', 'kembali', '2026-02-12 02:38:01', '2026-02-11 19:50:01'),
(3, 6, 2, 1, '2026-02-13 02:29:45', '2026-02-14', '2026-02-13 02:39:43', 'kembali', '2026-02-13 01:45:00', '2026-02-12 19:39:43'),
(4, 6, 3, 1, '2026-02-13 02:17:04', '2026-02-14', '2026-02-13 02:39:19', 'kembali', '2026-02-13 01:45:27', '2026-02-12 19:39:19'),
(5, 6, 3, 1, '2026-02-13 02:16:36', '2026-02-18', '2026-02-13 08:15:03', 'kembali', '2026-02-13 01:45:50', '2026-02-13 01:15:03'),
(6, 6, 3, 4, '2026-02-13 00:00:00', '2026-02-14', '2026-02-13 08:14:57', 'kembali', '2026-02-13 02:56:21', '2026-02-13 01:14:57'),
(8, 3, 2, 1, '2026-02-13 06:42:37', '2026-02-13', '2026-02-13 07:43:33', 'kembali', '2026-02-12 23:42:37', '2026-02-13 00:43:33'),
(9, 3, 2, 5, '2026-02-13 07:39:55', '2026-02-13', NULL, 'pinjam', '2026-02-13 00:39:55', '2026-02-13 00:40:25'),
(10, 3, 6, 1, '2026-02-13 08:01:46', '2026-02-13', NULL, 'pending', '2026-02-13 01:01:46', '2026-02-13 01:01:46'),
(11, 3, 6, 1, '2026-02-13 08:01:58', '2026-02-14', '2026-02-13 08:17:56', 'kembali', '2026-02-13 01:01:58', '2026-02-13 01:17:56');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_alat` (`id_alat`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON UPDATE CASCADE,
  ADD CONSTRAINT `peminjaman_ibfk_2` FOREIGN KEY (`id_alat`) REFERENCES `alat` (`id_alat`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
