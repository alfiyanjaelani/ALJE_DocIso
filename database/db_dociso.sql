-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2024 at 10:05 AM
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
-- Database: `db_dociso_new`
--

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
(3, 'Produksi'),
(4, 'Warehouse'),
(10, 'PPIC');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_document`
--

CREATE TABLE `tbl_document` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `berkas` longblob NOT NULL,
  `type` varchar(100) NOT NULL,
  `Id_department` int(11) NOT NULL,
  `upload_by` varchar(255) NOT NULL,
  `uploaded_date` datetime DEFAULT NULL,
  `size` int(11) NOT NULL,
  `update_by` varchar(11) NOT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(1, 'egi', 4, '123', 1),
(5, 'ari', 3, '123', 1),
(7, 'umei', 4, '123', 1),
(8, 'danu', 10, '123', 1),
(11, 'b', 10, '123', 1),
(12, 'c', 3, '123', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_dokumen_with_department`
-- (See below for the actual view)
--
CREATE TABLE `vw_dokumen_with_department` (
`id_doc` int(11)
,`name_doc` text
,`berkas` longblob
,`type` varchar(100)
,`Id_department` int(11)
,`Nama_department` varchar(255)
,`uploaded_date` datetime
,`upload_by` varchar(255)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `vw_user`
-- (See below for the actual view)
--
CREATE TABLE `vw_user` (
`Id_User` int(11)
,`Name` varchar(255)
,`Id_Departement` int(11)
,`Password` varchar(255)
,`Status` int(11)
,`Nama_department` varchar(255)
,`Status_user` varchar(8)
);

-- --------------------------------------------------------

--
-- Structure for view `vw_dokumen_with_department`
--
DROP TABLE IF EXISTS `vw_dokumen_with_department`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_dokumen_with_department`  AS SELECT `dc`.`id` AS `id_doc`, `dc`.`name` AS `name_doc`, `dc`.`berkas` AS `berkas`, `dc`.`type` AS `type`, `dc`.`Id_department` AS `Id_department`, `dp`.`Nama_department` AS `Nama_department`, `dc`.`uploaded_date` AS `uploaded_date`, `dc`.`upload_by` AS `upload_by` FROM (`tbl_document` `dc` left join `tbl_department` `dp` on(`dp`.`Id_department` = `dc`.`Id_department`)) ;

-- --------------------------------------------------------

--
-- Structure for view `vw_user`
--
DROP TABLE IF EXISTS `vw_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `vw_user`  AS SELECT `u`.`Id_User` AS `Id_User`, `u`.`Name` AS `Name`, `u`.`Id_Departement` AS `Id_Departement`, `u`.`Password` AS `Password`, `u`.`Status` AS `Status`, `d`.`Nama_department` AS `Nama_department`, CASE WHEN `u`.`Status` = 1 THEN 'Active' WHEN `u`.`Status` = 0 THEN 'Inactive' ELSE 'Unknown' END AS `Status_user` FROM (`tbl_user` `u` left join `tbl_department` `d` on(`u`.`Id_Departement` = `d`.`Id_department`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`Id_department`);

--
-- Indexes for table `tbl_document`
--
ALTER TABLE `tbl_document`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_user`
--
ALTER TABLE `tbl_user`
  ADD PRIMARY KEY (`Id_User`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `Id_department` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_document`
--
ALTER TABLE `tbl_document`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;

--
-- AUTO_INCREMENT for table `tbl_user`
--
ALTER TABLE `tbl_user`
  MODIFY `Id_User` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
