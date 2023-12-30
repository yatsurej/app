-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2023 at 11:54 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webar`
--

-- --------------------------------------------------------

--
-- Table structure for table `establishment`
--

CREATE TABLE `establishment` (
  `ID` int(11) NOT NULL,
  `establishmentCode` varchar(20) NOT NULL,
  `establishmentName` text NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 - active; 0 - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `establishment`
--

INSERT INTO `establishment` (`ID`, `establishmentCode`, `establishmentName`, `isActive`) VALUES
(1, 'ESTB1', 'National Museum Western Visayas', 1),
(2, 'ESTB2', 'Stockroom', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exhibit`
--

CREATE TABLE `exhibit` (
  `exhibitID` int(11) NOT NULL,
  `exhibitCode` varchar(20) NOT NULL,
  `exhibitName` text NOT NULL,
  `exhibitInformation` longtext NOT NULL,
  `exhibitModel` longtext NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 - active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exhibit`
--

INSERT INTO `exhibit` (`exhibitID`, `exhibitCode`, `exhibitName`, `exhibitInformation`, `exhibitModel`, `isActive`) VALUES
(1, 'E1', 'Ship in A Bottle', 'something something information etc. etc.', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/ship_in_a_bottle/scene.gltf', 1),
(6, 'E2', 'Elephant Fossil', 'exhibit_test2_information', 'exhibit_test2_modelurl', 1),
(7, 'E3', 'Dress', 'exhibit_test3_information', 'exhibit_test3_modelurl', 1),
(8, 'E4', 'Golden Mask', 'exhibit_test4_information', 'exhibit_test4_modelurl', 1),
(9, 'E5', 'Church Sculpture', 'exhibit_test5_information', 'exhibit_test5_modelurl', 1),
(10, 'E6', 'Garchomp', 'gible last evolution', 'rrahh', 1),
(11, 'E7', 'Arceus', 'god of pokemon? bwahaha', 'rraaahhhh', 1),
(12, 'E8', 'Dialga', 'god of time ', 'rraaaaa', 1),
(13, 'E9', 'Palkia', 'god of space', 'palkia', 1),
(14, 'E10', 'giratina', 'anti-matter goes brr brr', 'dfsd', 1),
(15, 'E11', 'Darkrai', 'nightmare wooo~ scary', 'ror', 1),
(16, 'E12', 'Gible', 'chomp', 'chomp chomp', 1),
(17, 'E13', 'Pikachu', 'overrated fr fr', 'pika pika', 1),
(18, 'E14', 'Shaymin', 'flowerrrrrrr', 'haha', 1),
(19, 'E15', 'Piplup', 'pengu', 'pengu', 1),
(20, 'E16', 'Chimchar', 'monkeh', 'monkey', 1),
(22, 'E17', 'Bulbasaur', 'green', 'green', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exhibit_accession`
--

CREATE TABLE `exhibit_accession` (
  `ID` int(11) NOT NULL,
  `accessionCode` varchar(20) NOT NULL,
  `rackingCode` varchar(20) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `accessionDate` date NOT NULL,
  `userID` int(11) NOT NULL,
  `isPosted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Not Posted; 1 - Posted',
  `datePosted` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exhibit_accession`
--

INSERT INTO `exhibit_accession` (`ID`, `accessionCode`, `rackingCode`, `exhibitID`, `accessionDate`, `userID`, `isPosted`, `datePosted`, `timestamp`) VALUES
(47, 'A1', 'R1', 1, '2023-12-25', 1, 1, '2023-12-25', '2023-12-25 11:22:17'),
(48, 'A2', 'R9', 10, '2023-12-25', 1, 1, '2023-12-25', '2023-12-25 11:46:03'),
(49, 'A3', 'R5', 8, '2023-12-26', 1, 1, '2023-12-26', '2023-12-25 16:52:39'),
(50, 'A4', 'R6', 11, '2023-12-26', 1, 0, '0000-00-00', '2023-12-25 18:05:31');

--
-- Triggers `exhibit_accession`
--
DELIMITER $$
CREATE TRIGGER `accession_posted` AFTER UPDATE ON `exhibit_accession` FOR EACH ROW BEGIN 
    IF new.isPosted = 1 AND new.isPosted <> old.isPosted THEN 

        INSERT INTO movement 
            (isPosted, datePosted, movementCode, movementType, exhibitID, locationTo, actualCount, userID) 
        VALUES 
            (1, new.datePosted, new.accessionCode, 'ACCESSION', new.exhibitID, new.rackingCode, 1, new.userID); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `exhibit_transfer`
--

CREATE TABLE `exhibit_transfer` (
  `ID` int(11) NOT NULL,
  `transferCode` varchar(20) NOT NULL,
  `sourceRackingCode` varchar(20) NOT NULL,
  `currentRackingCode` varchar(20) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `transferDate` date NOT NULL,
  `userID` int(11) NOT NULL,
  `isPosted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Not Posted; 1 - Posted',
  `datePosted` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exhibit_transfer`
--

INSERT INTO `exhibit_transfer` (`ID`, `transferCode`, `sourceRackingCode`, `currentRackingCode`, `exhibitID`, `transferDate`, `userID`, `isPosted`, `datePosted`, `timestamp`) VALUES
(31, 'T1', 'R9', 'R6', 10, '2023-12-27', 5, 1, '2023-12-27', '2023-12-26 16:24:03'),
(32, 'T2', 'R1', 'R3', 1, '2023-12-27', 5, 1, '2023-12-27', '2023-12-26 16:29:58');

--
-- Triggers `exhibit_transfer`
--
DELIMITER $$
CREATE TRIGGER `transfer_posted` AFTER UPDATE ON `exhibit_transfer` FOR EACH ROW BEGIN 
    IF new.isPosted = 1 AND new.isPosted <> old.isPosted THEN 
        INSERT INTO movement 
            (isPosted, datePosted, movementCode, movementType, exhibitID, locationFrom, locationTo, actualCount, userID) 
        VALUES 
            (1, new.datePosted, new.transferCode, 'TRANSFER', new.exhibitID, old.sourceRackingCode, new.sourceRackingCode, -1, new.userID); 
            
         INSERT INTO movement 
            (isPosted, datePosted, movementCode, movementType, exhibitID, locationFrom, locationTo, actualCount, userID) 
        VALUES 
            (1, new.datePosted, new.transferCode, 'TRANSFER', new.exhibitID, new.sourceRackingCode, new.currentRackingCode, 1, new.userID); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedbackID` int(11) NOT NULL,
  `guestID` int(11) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `ratingScore` tinyint(1) NOT NULL,
  `feedbackContent` text NOT NULL,
  `feedbackDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackID`, `guestID`, `exhibitID`, `ratingScore`, `feedbackContent`, `feedbackDate`) VALUES
(25, 5, 7, 4, '4', '2023-11-30');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `ID` int(11) NOT NULL,
  `galleryCode` varchar(20) NOT NULL,
  `galleryName` text NOT NULL,
  `establishmentCode` varchar(20) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 - active; 0 - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`ID`, `galleryCode`, `galleryName`, `establishmentCode`, `isActive`) VALUES
(1, 'G1', 'Gallery 1', 'ESTB1', 1),
(2, 'G2', 'Gallery 2', 'ESTB1', 1),
(3, 'G3', 'Gallery 3', 'ESTB1', 1),
(4, 'G4', 'Gallery 4', 'ESTB1', 1),
(5, 'G5', 'Gallery 5', 'ESTB1', 1),
(6, 'G6', 'Stockroom 1', 'ESTB2', 1);

-- --------------------------------------------------------

--
-- Table structure for table `guest`
--

CREATE TABLE `guest` (
  `guestID` int(11) NOT NULL,
  `guestGoogleID` varchar(20) NOT NULL,
  `guestGoogleEmail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `guest`
--

INSERT INTO `guest` (`guestID`, `guestGoogleID`, `guestGoogleEmail`) VALUES
(5, 'Froizel Apolonio', 'froizelrej@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `movement`
--

CREATE TABLE `movement` (
  `entryID` int(11) NOT NULL,
  `isPosted` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Posted',
  `datePosted` date NOT NULL,
  `movementCode` varchar(20) NOT NULL,
  `movementType` text NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `locationFrom` varchar(20) DEFAULT NULL,
  `locationTo` varchar(20) NOT NULL,
  `actualCount` float NOT NULL,
  `userID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movement`
--

INSERT INTO `movement` (`entryID`, `isPosted`, `datePosted`, `movementCode`, `movementType`, `exhibitID`, `locationFrom`, `locationTo`, `actualCount`, `userID`, `timestamp`) VALUES
(90, 1, '2023-12-25', 'A1', 'ACCESSION', 1, NULL, 'R1', 1, 1, '2023-12-25 11:22:17'),
(91, 1, '2023-12-25', 'A2', 'ACCESSION', 10, NULL, 'R9', 1, 1, '2023-12-25 11:46:03'),
(92, 1, '2023-12-26', 'A3', 'ACCESSION', 8, NULL, 'R5', 1, 1, '2023-12-25 16:52:39'),
(97, 1, '2023-12-27', 'T1', 'TRANSFER', 10, 'R9', 'R9', -1, 5, '2023-12-26 16:24:03'),
(98, 1, '2023-12-27', 'T1', 'TRANSFER', 10, 'R9', 'R6', 1, 5, '2023-12-26 16:24:03'),
(99, 1, '2023-12-27', 'T2', 'TRANSFER', 1, 'R1', 'R1', -1, 5, '2023-12-26 16:29:58'),
(100, 1, '2023-12-27', 'T2', 'TRANSFER', 1, 'R1', 'R3', 1, 5, '2023-12-26 16:29:58');

-- --------------------------------------------------------

--
-- Table structure for table `racking`
--

CREATE TABLE `racking` (
  `ID` int(11) NOT NULL,
  `rackingCode` varchar(20) NOT NULL,
  `rackingName` text NOT NULL,
  `galleryCode` varchar(20) NOT NULL,
  `isActive` tinyint(1) DEFAULT 1 COMMENT '1 - active; 0 - inactive1 - active; 0 - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `racking`
--

INSERT INTO `racking` (`ID`, `rackingCode`, `rackingName`, `galleryCode`, `isActive`) VALUES
(1, 'R1', 'Display Unit', 'G1', 1),
(10, 'R10', 'Shelf', 'G5', 1),
(11, 'R11', 'RRRAAAHH', 'G5', 1),
(2, 'R2', 'Glass Wall', 'G1', 1),
(3, 'R3', 'Table 1', 'G2', 1),
(4, 'R4 ', 'Display Unit', 'G2', 1),
(5, 'R5', 'Cabinet 1', 'G3', 1),
(6, 'R6', 'Table 1', 'G4', 1),
(7, 'R7', 'Glass Wall', 'G4', 1),
(8, 'R8', 'Display Unit', 'G5', 1),
(9, 'R9', 'Shelf 1', 'G6', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` text NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 - active; 0 - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `firstName`, `lastName`, `contactNumber`, `username`, `password`, `role`, `isActive`) VALUES
(1, 'Admin', 'Admin', '09123456789', 'admin', 'admin', 'Admin', 1),
(2, 'Gon', 'Freecs', '09123456789', 'gon', 'gon', 'Staff', 1),
(3, 'Killua', 'Zoldyck', '09123456789', 'killua', 'killua', 'Staff', 1),
(4, 'Albedo', 'Labidabs', '123456789', 'albedo', 'albedo', 'Staff', 1),
(5, 'Kazuha', 'Kaedehara', '7684324', 'kazuha', 'kazuha', 'Admin', 1),
(6, 'Pearl', 'Universe', '322121', 'pearl', 'pearl', 'Staff', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `establishment`
--
ALTER TABLE `establishment`
  ADD PRIMARY KEY (`establishmentCode`),
  ADD UNIQUE KEY `establishmentCode_2` (`establishmentCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `establishmentCode` (`establishmentCode`);

--
-- Indexes for table `exhibit`
--
ALTER TABLE `exhibit`
  ADD PRIMARY KEY (`exhibitID`);

--
-- Indexes for table `exhibit_accession`
--
ALTER TABLE `exhibit_accession`
  ADD PRIMARY KEY (`accessionCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `accession_fk1` (`rackingCode`),
  ADD KEY `accession_fk2` (`exhibitID`),
  ADD KEY `accession_fk3` (`userID`);

--
-- Indexes for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  ADD PRIMARY KEY (`transferCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `transfer_fk1` (`exhibitID`),
  ADD KEY `transfer_fk2` (`userID`),
  ADD KEY `transfer_fk3` (`currentRackingCode`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedbackID`),
  ADD KEY `feedback_fk1` (`guestID`),
  ADD KEY `feedback_fk2` (`exhibitID`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`galleryCode`),
  ADD UNIQUE KEY `galleryCode_2` (`galleryCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `galleryCode` (`galleryCode`),
  ADD KEY `gallery_fk1` (`establishmentCode`);

--
-- Indexes for table `guest`
--
ALTER TABLE `guest`
  ADD PRIMARY KEY (`guestID`);

--
-- Indexes for table `movement`
--
ALTER TABLE `movement`
  ADD PRIMARY KEY (`entryID`),
  ADD KEY `ID` (`entryID`),
  ADD KEY `movement_fk1` (`exhibitID`);

--
-- Indexes for table `racking`
--
ALTER TABLE `racking`
  ADD PRIMARY KEY (`rackingCode`),
  ADD UNIQUE KEY `rackingCode` (`rackingCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `racking_fk1` (`galleryCode`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exhibit`
--
ALTER TABLE `exhibit`
  MODIFY `exhibitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `exhibit_accession`
--
ALTER TABLE `exhibit_accession`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `racking`
--
ALTER TABLE `racking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exhibit_accession`
--
ALTER TABLE `exhibit_accession`
  ADD CONSTRAINT `accession_fk1` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk2` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk3` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE;

--
-- Constraints for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  ADD CONSTRAINT `transfer_fk1` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk2` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk3` FOREIGN KEY (`currentRackingCode`) REFERENCES `racking` (`rackingCode`) ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_fk1` FOREIGN KEY (`guestID`) REFERENCES `guest` (`guestID`) ON UPDATE NO ACTION,
  ADD CONSTRAINT `feedback_fk2` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON UPDATE CASCADE;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON UPDATE CASCADE;

--
-- Constraints for table `movement`
--
ALTER TABLE `movement`
  ADD CONSTRAINT `movement_fk1` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `racking`
--
ALTER TABLE `racking`
  ADD CONSTRAINT `racking_fk1` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
