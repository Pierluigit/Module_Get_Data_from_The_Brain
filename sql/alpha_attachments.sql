-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql16j15.db.hostpoint.internal
-- Generation Time: Apr 12, 2020 at 06:48 PM
-- Server version: 10.1.44-MariaDB
-- PHP Version: 7.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `escortgi_fsociety`
--

-- --------------------------------------------------------

--
-- Table structure for table `alpha_attachments`
--

CREATE TABLE `alpha_attachments` (
  `idAttachment` int(11) NOT NULL,
  `SourceId` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Position` int(11) NOT NULL,
  `FileModificationDateTime` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Type` int(11) NOT NULL,
  `DataLength` int(6) NOT NULL,
  `Location` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsIcon` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SourceType` int(64) NOT NULL,
  `NoteType` int(64) NOT NULL,
  `IsWallpaper` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsBrainIcon` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IsBrainAttachment` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `CreationDateTime` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ModificationDateTime` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SyncSentId` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `BrainId` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Id` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alpha_attachments`
--
ALTER TABLE `alpha_attachments`
  ADD PRIMARY KEY (`idAttachment`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alpha_attachments`
--
ALTER TABLE `alpha_attachments`
  MODIFY `idAttachment` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
