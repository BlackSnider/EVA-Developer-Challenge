-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 05, 2023 at 10:57 PM
-- Server version: 5.7.42-cll-lve
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eva-challenge`
--

-- --------------------------------------------------------

--
-- Table structure for table `eva_tbl_access`
--

CREATE TABLE `eva_tbl_access` (
  `accessTokenID` int(11) NOT NULL,
  `accessToken` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eva_tbl_access`
--

INSERT INTO `eva_tbl_access` (`accessTokenID`, `accessToken`) VALUES
(1, 'shpua_b4d2ded3bf4e751a6f6d99ae96039f35');

-- --------------------------------------------------------

--
-- Table structure for table `eva_tbl_products_comments`
--

CREATE TABLE `eva_tbl_products_comments` (
  `productCommentID` int(11) NOT NULL,
  `productID` int(11) NOT NULL,
  `key` text NOT NULL,
  `value` text NOT NULL,
  `namespace` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eva_tbl_products_comments`
--

INSERT INTO `eva_tbl_products_comments` (`productCommentID`, `productID`, `key`, `value`, `namespace`) VALUES
(3, 2147483647, 'customer_name', 'GreenLantern', 'custom'),
(4, 2147483647, 'comments', 'The girl in town has plenty of flowers to buy with.', 'custom');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eva_tbl_access`
--
ALTER TABLE `eva_tbl_access`
  ADD PRIMARY KEY (`accessTokenID`);

--
-- Indexes for table `eva_tbl_products_comments`
--
ALTER TABLE `eva_tbl_products_comments`
  ADD PRIMARY KEY (`productCommentID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eva_tbl_access`
--
ALTER TABLE `eva_tbl_access`
  MODIFY `accessTokenID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `eva_tbl_products_comments`
--
ALTER TABLE `eva_tbl_products_comments`
  MODIFY `productCommentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
