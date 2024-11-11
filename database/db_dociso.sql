-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2024 at 05:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_dociso`
--

-- --------------------------------------------------------

--
-- Table structure for table `dokumen_iso`
--

CREATE TABLE `dokumen_iso` (
  `id_doc` int(11) NOT NULL,
  `name_doc` varchar(255) NOT NULL,
  `id_department` int(11) NOT NULL,
  `upload_by` varchar(255) NOT NULL,
  `upload_date` date NOT NULL,
  `Size` int(11) NOT NULL,
  `Ekstensi` varchar(50) NOT NULL,
  `Berkas` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dokumen_iso`
--

INSERT INTO `dokumen_iso` (`id_doc`, `name_doc`, `id_department`, `upload_by`, `upload_date`, `Size`, `Ekstensi`, `Berkas`) VALUES
(3, 'ISO 9001', 1, 'Egi', '2024-11-09', 0, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `Id_department` int(11) NOT NULL,
  `Nama_department` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`Id_department`, `Nama_department`) VALUES
(1, 'PPIC'),
(2, 'HRGA'),
(3, 'Produksi'),
(4, 'Warehouse');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_user`
--

CREATE TABLE `tbl_user` (
  `Id_User` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Id_Departement` int(11) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_user`
--

INSERT INTO `tbl_user` (`Id_User`, `Name`, `Id_Departement`, `Password`, `Status`) VALUES
(1, 'egi', 2, '123', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dokumen_iso`
--
ALTER TABLE `dokumen_iso`
  ADD PRIMARY KEY (`id_doc`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`Id_department`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`Id_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dokumen_iso`
--
ALTER TABLE `dokumen_iso`
  MODIFY `id_doc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `Id_department` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
