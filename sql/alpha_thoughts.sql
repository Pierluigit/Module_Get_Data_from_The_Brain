-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: mysql16j15.db.hostpoint.internal
-- Generation Time: Apr 12, 2020 at 06:49 PM
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
-- Table structure for table `alpha_thoughts`
--

CREATE TABLE `alpha_thoughts` (
  `idThought` int(11) NOT NULL,
  `active` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `categorie` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tags` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `-- the brain info --` varchar(0) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ActivationDateTime` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ACType` int(11) NOT NULL,
  `Kind` int(11) NOT NULL,
  `TagIds` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Label` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ThoughtIconInfo` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Indexes for table `alpha_thoughts`
--
ALTER TABLE `alpha_thoughts`
  ADD PRIMARY KEY (`idThought`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alpha_thoughts`
--
ALTER TABLE `alpha_thoughts`
  MODIFY `idThought` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
