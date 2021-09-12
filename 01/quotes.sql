-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 13, 2021 at 01:20 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quotes`
--

-- --------------------------------------------------------

--
-- Table structure for table `used_quotes_by_session`
--

CREATE TABLE `used_quotes_by_session` (
  `ID` int(11) NOT NULL,
  `sessionID` varchar(255) NOT NULL,
  `used_quote_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `used_quotes_by_session`
--

INSERT INTO `used_quotes_by_session` (`ID`, `sessionID`, `used_quote_id`) VALUES
(101, 'p7fvm6tinn1omkt33884p4raev', 66),
(102, 'p7fvm6tinn1omkt33884p4raev', 8),
(103, 'p7fvm6tinn1omkt33884p4raev', 3),
(104, 'p7fvm6tinn1omkt33884p4raev', 1),
(105, 'p7fvm6tinn1omkt33884p4raev', 42),
(106, 'p7fvm6tinn1omkt33884p4raev', 7),
(107, 'p7fvm6tinn1omkt33884p4raev', 5),
(108, 'p7fvm6tinn1omkt33884p4raev', 6),
(109, 'p7fvm6tinn1omkt33884p4raev', 4),
(110, 'p7fvm6tinn1omkt33884p4raev', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `used_quotes_by_session`
--
ALTER TABLE `used_quotes_by_session`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `used_quotes_by_session`
--
ALTER TABLE `used_quotes_by_session`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
