-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 29, 2021 at 04:57 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ticketing`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `adminId` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`adminId`, `username`, `password`) VALUES
(1, 'admin', 'root');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_customer`
--

CREATE TABLE `tbl_customer` (
  `customer_ID` int(11) NOT NULL,
  `customer_Lname` varchar(255) NOT NULL,
  `customer_Fname` varchar(255) NOT NULL,
  `phonenumber` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_events`
--

CREATE TABLE `tbl_events` (
  `event_ID` int(11) NOT NULL,
  `eventName` varchar(255) NOT NULL,
  `eventDate` date NOT NULL,
  `eventVenue` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seat`
--

CREATE TABLE `tbl_seat` (
  `seat_ID` int(11) NOT NULL,
  `seat_Pref` varchar(50) NOT NULL,
  `seat_Type` varchar(50) NOT NULL,
  `seat_Size` int(11) NOT NULL,
  `seat_Price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_seatsinventory`
--

CREATE TABLE `tbl_seatsinventory` (
  `seat_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `seatSold` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sell`
--

CREATE TABLE `tbl_sell` (
  `sell_ID` int(11) NOT NULL,
  `event_ID` int(11) NOT NULL,
  `seat_ID` int(11) NOT NULL,
  `Price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ticketorders`
--

CREATE TABLE `tbl_ticketorders` (
  `order_ID` int(11) NOT NULL,
  `customer_ID` int(11) NOT NULL,
  `sell_ID` int(11) NOT NULL,
  `dateBought` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Indexes for table `tbl_customer`
--
ALTER TABLE `tbl_customer`
  ADD PRIMARY KEY (`customer_ID`);

--
-- Indexes for table `tbl_events`
--
ALTER TABLE `tbl_events`
  ADD PRIMARY KEY (`event_ID`);

--
-- Indexes for table `tbl_seat`
--
ALTER TABLE `tbl_seat`
  ADD PRIMARY KEY (`seat_ID`);

--
-- Indexes for table `tbl_seatsinventory`
--
ALTER TABLE `tbl_seatsinventory`
  ADD UNIQUE KEY `seat_ID` (`seat_ID`);

--
-- Indexes for table `tbl_sell`
--
ALTER TABLE `tbl_sell`
  ADD PRIMARY KEY (`sell_ID`),
  ADD UNIQUE KEY `event_ID` (`event_ID`),
  ADD UNIQUE KEY `seat_ID` (`seat_ID`);

--
-- Indexes for table `tbl_ticketorders`
--
ALTER TABLE `tbl_ticketorders`
  ADD PRIMARY KEY (`order_ID`),
  ADD UNIQUE KEY `customer_ID` (`customer_ID`),
  ADD UNIQUE KEY `sell_ID` (`sell_ID`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_seatsinventory`
--
ALTER TABLE `tbl_seatsinventory`
  ADD CONSTRAINT `tbl_seatsinventory_ibfk_1` FOREIGN KEY (`seat_ID`) REFERENCES `tbl_seat` (`seat_ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tbl_sell`
--
ALTER TABLE `tbl_sell`
  ADD CONSTRAINT `tbl_Event_ibfk_1` FOREIGN KEY (`event_ID`) REFERENCES `tbl_events` (`event_ID`),
  ADD CONSTRAINT `tbl_Seat_ibfk_2` FOREIGN KEY (`seat_ID`) REFERENCES `tbl_seat` (`seat_ID`);

--
-- Constraints for table `tbl_ticketorders`
--
ALTER TABLE `tbl_ticketorders`
  ADD CONSTRAINT `tbl_Customer_ibfk_1` FOREIGN KEY (`customer_ID`) REFERENCES `tbl_customer` (`customer_ID`),
  ADD CONSTRAINT `tbl_Sell_ibfk_1` FOREIGN KEY (`sell_ID`) REFERENCES `tbl_sell` (`sell_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
