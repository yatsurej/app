-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2023 at 07:48 PM
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
  `ID` int(11) NOT NULL,
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

INSERT INTO `exhibits` (`ID`, `exhibitCode`, `exhibitName`, `exhibitInformation`, `exhibitModel`, `exhibitMarker`, `isActive`) VALUES
(1, 'E1', 'exhibit_test1_name', 'exhibit_test1_information', 'exhibit_test1_modelurl', '', 1),
(6, 'E2', 'exhibit_test2_name', 'exhibit_test2_information', 'exhibit_test2_modelurl', '', 1),
(7, 'E3', 'exhibit_test3_name', 'exhibit_test3_information', 'exhibit_test3_modelurl', '', 1),
(8, 'E4', 'exhibit_test4_name', 'exhibit_test4_information', 'exhibit_test4_modelurl', '', 1),
(9, 'E5', 'exhibit_test5_name', 'exhibit_test5_information', 'exhibit_test5_modelurl', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `feedbackContent` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Table structure for table `inventory`
--

CREATE TABLE `inventory` (
  `ID` int(11) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `establishmentCode` varchar(255) NOT NULL,
  `galleryCode` varchar(255) NOT NULL,
  `rackingCode` varchar(255) NOT NULL,
  `staffID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `inventory`
--

INSERT INTO `inventory` (`ID`, `exhibitID`, `establishmentCode`, `galleryCode`, `rackingCode`, `staffID`, `timestamp`) VALUES
(9, 1, 'ESTB1', 'G1', 'R2', 1, '2023-11-09 06:36:10'),
(10, 6, 'ESTB1', 'G1', 'R2', 3, '2023-11-09 18:20:59'),
(11, 7, 'ESTB1', 'G2', 'R4 ', 2, '2023-11-09 18:24:22'),
(12, 9, 'ESTB2', 'G6', 'R9', 1, '2023-11-11 18:23:16');

-- --------------------------------------------------------

--
-- Table structure for table `movement`
--

CREATE TABLE `movement` (
  `ID` int(11) NOT NULL,
  `movementCode` varchar(255) NOT NULL,
  `establishmentCode` varchar(255) NOT NULL,
  `galleryCode` varchar(255) NOT NULL,
  `rackingCode` varchar(255) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `movementDate` date NOT NULL,
  `staffID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movement`
--

INSERT INTO `movement` (`ID`, `movementCode`, `establishmentCode`, `galleryCode`, `rackingCode`, `exhibitID`, `movementDate`, `staffID`, `timestamp`) VALUES
(3, 'M1', 'ESTB1', 'G1', 'R2', 1, '2023-11-08', 1, '2023-11-09 06:36:10'),
(4, 'M2', 'ESTB1', 'G1', 'R2', 6, '2023-11-12', 3, '2023-11-09 18:20:59'),
(5, 'M3', 'ESTB1', 'G2', 'R4 ', 7, '2023-11-10', 2, '2023-11-09 18:24:22'),
(6, 'M4', 'ESTB2', 'G6', 'R9', 9, '2023-11-08', 1, '2023-11-11 18:23:16');

--
-- Triggers `movement`
--
DELIMITER $$
CREATE TRIGGER `movement_accession` AFTER INSERT ON `movement` FOR EACH ROW BEGIN
    INSERT INTO inventory (exhibitID, establishmentCode, galleryCode, rackingCode, staffID, timestamp)
    VALUES (NEW.exhibitID, NEW.establishmentCode, NEW.galleryCode, NEW.rackingCode, NEW.staffID, NEW.timestamp);
    
    INSERT INTO movement_record (movementCode,movementType, movementDate, movementFrom, movementTo, staffID,timestamp)
    VALUES (NEW.movementCode, 'ACCESSION', NEW.movementDate, CONCAT(NEW.establishmentCode, ' - ',NEW.galleryCode, ' - ', NEW.rackingCode), CONCAT(NEW.establishmentCode, ' - ', NEW.galleryCode, ' - ', NEW.rackingCode), NEW.staffID, NEW.timestamp);
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `movement_transfer` AFTER UPDATE ON `movement` FOR EACH ROW BEGIN 
	IF NEW.establishmentCode <> OLD.establishmentCode 
	OR NEW.galleryCode <> OLD.galleryCode 
	OR NEW.rackingCode <> OLD.rackingCode
	OR NEW.movementDate <> OLD.movementDate 
    THEN 
    
    UPDATE inventory 
    SET establishmentCode = NEW.establishmentCode, 
    	galleryCode = NEW.galleryCode, 
        rackingCode = NEW.rackingCode, 
        staffID = NEW.staffID, 
        timestamp = NEW.timestamp 
	WHERE inventory.exhibitID = NEW.exhibitID; 
    
    INSERT INTO movement_record (movementCode, movementType, movementDate, movementFrom, movementTo, staffID, timestamp) 
    VALUES (NEW.movementCode, 'TRANSFER', NEW.movementDate, CONCAT(OLD.establishmentCode,' - ', OLD.galleryCode, ' - ', OLD.rackingCode), CONCAT(NEW.establishmentCode,' - ', NEW.galleryCode, ' - ', NEW.rackingCode), NEW.staffID, NEW.timestamp); 
	END IF; 
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `movement_record`
--

CREATE TABLE `movement_record` (
  `ID` int(11) NOT NULL,
  `movementCode` varchar(255) NOT NULL,
  `movementType` text NOT NULL,
  `movementDate` date NOT NULL,
  `movementFrom` text NOT NULL,
  `movementTo` text NOT NULL,
  `staffID` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movement_record`
--

INSERT INTO `movement_record` (`ID`, `movementCode`, `movementType`, `movementDate`, `movementFrom`, `movementTo`, `staffID`, `timestamp`) VALUES
(2, 'M1', 'ACCESSION', '2023-11-08', 'ESTB1 - G1 - R1', 'ESTB1 - G1 - R1', 1, '2023-11-09 06:31:21'),
(3, 'M1', 'TRANSFER', '0000-00-00', 'ESTB1 - G1 - R1', 'ESTB1 - G1 - R2', 1, '2023-11-09 06:36:10'),
(4, 'M2', 'ACCESSION', '2023-11-09', 'ESTB1 - G1 - R2', 'ESTB1 - G1 - R2', 3, '2023-11-09 08:57:31'),
(5, 'M2', 'TRANSFER', '0000-00-00', 'ESTB1 - G1 - R2', 'ESTB1 - G1 - R1', 3, '2023-11-09 08:57:55'),
(6, 'M2', 'TRANSFER', '0000-00-00', 'ESTB1 - G1 - R1', 'ESTB1 - G1 - R2', 3, '2023-11-09 08:58:19'),
(7, 'M2', 'TRANSFER', '0000-00-00', 'ESTB1 - G1 - R2', 'ESTB1 - G1 - R2', 3, '2023-11-09 09:00:10'),
(8, 'M2', 'TRANSFER', '2023-11-12', 'ESTB1 - G1 - R2', 'ESTB1 - G1 - R2', 3, '2023-11-09 18:20:59'),
(9, 'M3', 'ACCESSION', '2023-11-10', 'ESTB1 - G2 - R3', 'ESTB1 - G2 - R3', 2, '2023-11-09 18:23:53'),
(10, 'M3', 'TRANSFER', '2023-11-10', 'ESTB1 - G2 - R3', 'ESTB1 - G2 - R4 ', 2, '2023-11-09 18:24:22'),
(11, 'M4', 'ACCESSION', '2023-11-08', 'ESTB2 - G6 - R9', 'ESTB2 - G6 - R9', 1, '2023-11-11 18:23:16');

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
  `ID` int(11) NOT NULL,
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

INSERT INTO `staff` (`ID`, `firstName`, `lastName`, `contactNumber`, `username`, `password`, `role`, `isActive`) VALUES
(1, 'Admin', 'Admin', '09123456789', 'admin', 'admin', 'Admin', 1),
(2, 'Staff 1 First Name', 'Staff 1 Last Name', '09123456789', 'u_staff1', 'p_staff1', 'Staff', 1),
(3, 'Staff 2 First Name', 'Staff 2 Last Name', '09123456789', 'u_staff2', 'p_staff2', 'Staff', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `userEmail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
-- Indexes for table `exhibits`
--
ALTER TABLE `exhibits`
  ADD PRIMARY KEY (`ID`);

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
-- Indexes for table `inventory`
--
ALTER TABLE `inventory`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `inventory_fk1` (`exhibitID`),
  ADD KEY `inventory_fk2` (`galleryCode`),
  ADD KEY `inventory_fk3` (`rackingCode`),
  ADD KEY `inventory_fk4` (`staffID`),
  ADD KEY `inventory_fk5` (`establishmentCode`);

--
-- Indexes for table `movement`
--
ALTER TABLE `movement`
  ADD PRIMARY KEY (`movementCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `movement_fk1` (`establishmentCode`),
  ADD KEY `movement_fk2` (`galleryCode`),
  ADD KEY `movement_fk3` (`rackingCode`),
  ADD KEY `movement_fk4` (`exhibitID`),
  ADD KEY `movement_fk5` (`staffID`);

--
-- Indexes for table `movement_record`
--
ALTER TABLE `movement_record`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `mrecord_fk1` (`movementCode`);

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
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `establishment`
--
ALTER TABLE `establishment`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `exhibits`
--
ALTER TABLE `exhibits`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `inventory`
--
ALTER TABLE `inventory`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movement_record`
--
ALTER TABLE `movement_record`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `racking`
--
ALTER TABLE `racking`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD CONSTRAINT `feedback_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`ID`) ON UPDATE NO ACTION;

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `gallery_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON UPDATE CASCADE;

--
-- Constraints for table `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_fk1` FOREIGN KEY (`exhibitID`) REFERENCES `exhibits` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk2` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk3` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk4` FOREIGN KEY (`staffID`) REFERENCES `staff` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_fk5` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON UPDATE CASCADE;

--
-- Constraints for table `movement`
--
ALTER TABLE `movement`
  ADD CONSTRAINT `movement_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movement_fk2` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movement_fk3` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movement_fk4` FOREIGN KEY (`exhibitID`) REFERENCES `exhibits` (`ID`) ON UPDATE CASCADE,
  ADD CONSTRAINT `movement_fk5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`ID`) ON UPDATE CASCADE;

--
-- Constraints for table `movement_record`
--
ALTER TABLE `movement_record`
  ADD CONSTRAINT `mrecord_fk1` FOREIGN KEY (`movementCode`) REFERENCES `movement` (`movementCode`) ON UPDATE NO ACTION;

--
-- Constraints for table `racking`
--
ALTER TABLE `racking`
  ADD CONSTRAINT `racking_fk1` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
