-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 25, 2023 at 05:58 PM
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
-- Table structure for table `accession`
--

CREATE TABLE `accession` (
  `ID` int(11) NOT NULL,
  `accessionCode` varchar(255) NOT NULL,
  `establishmentCode` varchar(255) NOT NULL,
  `galleryCode` varchar(255) NOT NULL,
  `rackingCode` varchar(255) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `accessionDate` date NOT NULL,
  `staffID` int(11) NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Not Posted; 1 - Posted',
  `datePosted` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `accession`
--

INSERT INTO `accession` (`ID`, `accessionCode`, `establishmentCode`, `galleryCode`, `rackingCode`, `exhibitID`, `accessionDate`, `staffID`, `posted`, `datePosted`, `timestamp`) VALUES
(25, 'A1', 'ESTB1', 'G2', 'R3', 6, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 14:54:06'),
(26, 'A2', 'ESTB1', 'G2', 'R4 ', 8, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:26:23');

--
-- Triggers `accession`
--
DELIMITER $$
CREATE TRIGGER `accession_posted` AFTER UPDATE ON `accession` FOR EACH ROW BEGIN 
    IF new.posted = 1 AND new.posted <> old.posted THEN 
        SET @establishmentName = (SELECT establishmentName FROM establishment WHERE establishmentCode = new.establishmentCode);
        SET @galleryName = (SELECT galleryName FROM gallery WHERE galleryCode = new.galleryCode);
        SET @rackingName = (SELECT rackingName FROM racking WHERE rackingCode = new.rackingCode);

        INSERT INTO movement 
            (posted, datePosted, movementCode, movementType, exhibitID, locationTo, actualCount, staffID) 
        VALUES 
            (1, new.datePosted, new.accessionCode, 'ACCESSION', new.exhibitID, CONCAT(@establishmentName, ' - ', @galleryName, ' - ', @rackingName), 1, new.staffID); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `establishment`
--

CREATE TABLE `establishment` (
  `ID` int(11) NOT NULL,
  `establishmentCode` varchar(255) NOT NULL,
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
-- Table structure for table `exhibits`
--

CREATE TABLE `exhibits` (
  `exhibitID` int(11) NOT NULL,
  `exhibitCode` varchar(255) NOT NULL,
  `exhibitName` varchar(255) NOT NULL,
  `exhibitInformation` longtext NOT NULL,
  `exhibitModel` longtext NOT NULL,
  `exhibitMarker` longblob NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 - active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `exhibits`
--

INSERT INTO `exhibits` (`exhibitID`, `exhibitCode`, `exhibitName`, `exhibitInformation`, `exhibitModel`, `exhibitMarker`, `isActive`) VALUES
(1, 'E1', 'Ship in A Bottle', 'exhibit_test1_information', 'exhibit_test1_modelurl', '', 1),
(6, 'E2', 'Elephant Fossil', 'exhibit_test2_information', 'exhibit_test2_modelurl', '', 1),
(7, 'E3', 'Dress', 'exhibit_test3_information', 'exhibit_test3_modelurl', '', 1),
(8, 'E4', 'Golden Mask', 'exhibit_test4_information', 'exhibit_test4_modelurl', '', 1),
(9, 'E5', 'Church Sculpture', 'exhibit_test5_information', 'exhibit_test5_modelurl', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `ratingScore` tinyint(1) NOT NULL,
  `feedbackContent` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedbacks`
--

INSERT INTO `feedbacks` (`ID`, `userID`, `ratingScore`, `feedbackContent`) VALUES
(3, 1, 5, 'Wow! Excellent quality of exhibits, I\'m in love.'),
(4, 2, 2, 'My art is better...'),
(5, 3, 3, 'cool'),
(6, 2, 4, 'amazing'),
(7, 1, 1, 'bad');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `ID` int(11) NOT NULL,
  `galleryCode` varchar(255) NOT NULL,
  `galleryName` text NOT NULL,
  `establishmentCode` varchar(255) NOT NULL,
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
-- Table structure for table `movement`
--

CREATE TABLE `movement` (
  `entryID` int(11) NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Posted/Approved',
  `datePosted` date NOT NULL,
  `movementCode` varchar(255) NOT NULL,
  `movementType` text NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `locationFrom` text DEFAULT NULL,
  `locationTo` text NOT NULL,
  `actualCount` float NOT NULL,
  `staffID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movement`
--

INSERT INTO `movement` (`entryID`, `posted`, `datePosted`, `movementCode`, `movementType`, `exhibitID`, `locationFrom`, `locationTo`, `actualCount`, `staffID`, `timestamp`) VALUES
(51, 1, '2023-11-25', 'A1', 'ACCESSION', 6, NULL, 'National Museum Western Visayas - Gallery 2 - Table 1', 1, 4, '2023-11-25 14:54:06'),
(56, 1, '2023-11-25', 'T1', 'TRANSFER', 6, 'National Museum Western Visayas - Gallery 2 - Table 1', 'National Museum Western Visayas - Gallery 2 - Table 1', -1, 4, '2023-11-25 15:14:47'),
(57, 1, '2023-11-25', 'T1', 'TRANSFER', 6, 'National Museum Western Visayas - Gallery 2 - Table 1', 'National Museum Western Visayas - Gallery 1 - Display Unit', 1, 4, '2023-11-25 15:14:47'),
(58, 1, '2023-11-25', 'A2', 'ACCESSION', 8, NULL, 'National Museum Western Visayas - Gallery 2 - Display Unit', 1, 4, '2023-11-25 15:26:23'),
(59, 1, '2023-11-25', 'T2', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 2 - Display Unit', 'National Museum Western Visayas - Gallery 2 - Display Unit', -1, 4, '2023-11-25 15:26:46'),
(60, 1, '2023-11-25', 'T2', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 2 - Display Unit', 'Stockroom - Stockroom 1 - Shelf 1', 1, 4, '2023-11-25 15:26:46'),
(61, 1, '2023-11-25', 'T3', 'TRANSFER', 8, 'Stockroom - Stockroom 1 - Shelf 1', 'Stockroom - Stockroom 1 - Shelf 1', -1, 4, '2023-11-25 15:27:21'),
(62, 1, '2023-11-25', 'T3', 'TRANSFER', 8, 'Stockroom - Stockroom 1 - Shelf 1', 'National Museum Western Visayas - Gallery 4 - Glass Wall', 1, 4, '2023-11-25 15:27:21'),
(63, 1, '2023-11-25', 'T4', 'TRANSFER', 6, 'National Museum Western Visayas - Gallery 1 - Display Unit', 'National Museum Western Visayas - Gallery 1 - Display Unit', -1, 4, '2023-11-25 15:28:38'),
(64, 1, '2023-11-25', 'T4', 'TRANSFER', 6, 'National Museum Western Visayas - Gallery 1 - Display Unit', 'Stockroom - Stockroom 1 - Shelf 1', 1, 4, '2023-11-25 15:28:38'),
(65, 1, '2023-11-25', 'T5', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'National Museum Western Visayas - Gallery 4 - Glass Wall', -1, 5, '2023-11-25 15:59:45'),
(66, 1, '2023-11-25', 'T5', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 1, 5, '2023-11-25 15:59:45');

-- --------------------------------------------------------

--
-- Table structure for table `racking`
--

CREATE TABLE `racking` (
  `ID` int(11) NOT NULL,
  `rackingCode` varchar(255) NOT NULL,
  `rackingName` text NOT NULL,
  `galleryCode` varchar(255) NOT NULL,
  `isActive` tinyint(1) DEFAULT 1 COMMENT '1 - active; 0 - inactive1 - active; 0 - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `racking`
--

INSERT INTO `racking` (`ID`, `rackingCode`, `rackingName`, `galleryCode`, `isActive`) VALUES
(1, 'R1', 'Display Unit', 'G1', 1),
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
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `staffID` int(11) NOT NULL,
  `firstName` text NOT NULL,
  `lastName` text NOT NULL,
  `contactNumber` varchar(20) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` text NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 - active; 0 - inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`staffID`, `firstName`, `lastName`, `contactNumber`, `username`, `password`, `role`, `isActive`) VALUES
(1, 'Admin', 'Admin', '09123456789', 'admin', 'admin', 'Admin', 1),
(2, 'Gon', 'Freecs', '09123456789', 'gon', 'gon', 'Staff', 1),
(3, 'Killua', 'Zoldyck', '09123456789', 'killua', 'killua', 'Staff', 1),
(4, 'Albedo', 'Labidabs', '123456789', 'albedo', 'albedo', 'Staff', 1),
(5, 'Kazuha', 'Kaedehara', '7684324', 'kazuha', 'kazuha', 'Admin', 1),
(6, 'Pearl', 'Universe', '322121', 'pearl', 'pearl', 'Staff', 1);

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `ID` int(11) NOT NULL,
  `transferCode` varchar(255) NOT NULL,
  `sourceLocation` varchar(255) NOT NULL,
  `establishmentCode` varchar(255) NOT NULL,
  `galleryCode` varchar(255) NOT NULL,
  `rackingCode` varchar(255) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `transferDate` date NOT NULL,
  `staffID` int(11) NOT NULL,
  `posted` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - Not Posted; 1 - Posted',
  `datePosted` date NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transfer`
--

INSERT INTO `transfer` (`ID`, `transferCode`, `sourceLocation`, `establishmentCode`, `galleryCode`, `rackingCode`, `exhibitID`, `transferDate`, `staffID`, `posted`, `datePosted`, `timestamp`) VALUES
(15, 'T1', 'National Museum Western Visayas - Gallery 2 - Table 1', 'ESTB1', 'G1', 'R1', 6, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:14:47'),
(16, 'T2', 'National Museum Western Visayas - Gallery 2 - Display Unit', 'ESTB2', 'G6', 'R9', 8, '2023-11-24', 4, 1, '2023-11-25', '2023-11-25 15:26:46'),
(17, 'T3', 'Stockroom - Stockroom 1 - Shelf 1', 'ESTB1', 'G4', 'R7', 8, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:27:21'),
(18, 'T4', 'National Museum Western Visayas - Gallery 1 - Display Unit', 'ESTB2', 'G6', 'R9', 6, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:28:38'),
(19, 'T5', 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'ESTB1', 'G3', 'R5', 8, '2023-11-23', 5, 1, '2023-11-25', '2023-11-25 15:59:45');

--
-- Triggers `transfer`
--
DELIMITER $$
CREATE TRIGGER `transfer_posted` AFTER UPDATE ON `transfer` FOR EACH ROW BEGIN 
    IF new.posted = 1 AND new.posted <> old.posted THEN 
        SET @establishmentName = (SELECT establishmentName FROM establishment WHERE establishmentCode = new.establishmentCode);
        SET @galleryName = (SELECT galleryName FROM gallery WHERE galleryCode = new.galleryCode);
        SET @rackingName = (SELECT rackingName FROM racking WHERE rackingCode = new.rackingCode);

        INSERT INTO movement 
            (posted, datePosted, movementCode, movementType, exhibitID, locationFrom, locationTo, actualCount, staffID) 
        VALUES 
            (1, new.datePosted, new.transferCode, 'TRANSFER', new.exhibitID, old.sourceLocation, new.sourceLocation, -1, new.staffID); 
            
         INSERT INTO movement 
            (posted, datePosted, movementCode, movementType, exhibitID, locationFrom, locationTo, actualCount, staffID) 
        VALUES 
            (1, new.datePosted, new.transferCode, 'TRANSFER', new.exhibitID, new.sourceLocation, CONCAT(@establishmentName, ' - ', @galleryName, ' - ', @rackingName), 1, new.staffID); 
    END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `userFirstName` text DEFAULT NULL COMMENT 'optional',
  `userLastName` text DEFAULT NULL COMMENT 'optional',
  `userEmail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `userFirstName`, `userLastName`, `userEmail`) VALUES
(1, 'Froizel', 'Apolonio', 'froizelrej@gmail.com'),
(2, 'Albedo', 'Pogi', 'albedo@gmail.com'),
(3, NULL, NULL, 'test@gmail.com');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accession`
--
ALTER TABLE `accession`
  ADD PRIMARY KEY (`accessionCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `accession_fk1` (`establishmentCode`),
  ADD KEY `accession_fk2` (`galleryCode`),
  ADD KEY `accession_fk3` (`rackingCode`),
  ADD KEY `accession_fk4` (`exhibitID`),
  ADD KEY `accession_fk5` (`staffID`);

--
-- Indexes for table `establishment`
--
ALTER TABLE `establishment`
  ADD PRIMARY KEY (`establishmentCode`),
  ADD UNIQUE KEY `establishmentCode_2` (`establishmentCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `establishmentCode` (`establishmentCode`);

--
-- Indexes for table `exhibits`
--
ALTER TABLE `exhibits`
  ADD PRIMARY KEY (`exhibitID`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `feedback_fk1` (`userID`);

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
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`staffID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`transferCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `transfer_fk1` (`establishmentCode`),
  ADD KEY `transfer_fk2` (`galleryCode`),
  ADD KEY `transfer_fk3` (`rackingCode`),
  ADD KEY `transfer_fk4` (`exhibitID`),
  ADD KEY `transfer_fk5` (`staffID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accession`
--
ALTER TABLE `accession`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exhibits`
--
ALTER TABLE `exhibits`
  MODIFY `exhibitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=67;

--
-- AUTO_INCREMENT for table `racking`
--
ALTER TABLE `racking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `staffID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `accession`
--
ALTER TABLE `accession`
  ADD CONSTRAINT `accession_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk2` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk3` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk4` FOREIGN KEY (`exhibitID`) REFERENCES `exhibits` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedback_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE NO ACTION;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON UPDATE CASCADE;

--
-- Constraints for table `movement`
--
ALTER TABLE `movement`
  ADD CONSTRAINT `movement_fk1` FOREIGN KEY (`exhibitID`) REFERENCES `exhibits` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `racking`
--
ALTER TABLE `racking`
  ADD CONSTRAINT `racking_fk1` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON UPDATE CASCADE;

--
-- Constraints for table `transfer`
--
ALTER TABLE `transfer`
  ADD CONSTRAINT `transfer_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk2` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk3` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk4` FOREIGN KEY (`exhibitID`) REFERENCES `exhibits` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
