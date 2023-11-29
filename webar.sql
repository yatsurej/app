-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2023 at 08:41 PM
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
-- Table structure for table `exhibit`
--

CREATE TABLE `exhibit` (
  `exhibitID` int(11) NOT NULL,
  `exhibitCode` varchar(255) NOT NULL,
  `exhibitName` varchar(255) NOT NULL,
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
(14, 'E11', 'giratina', 'anti-matter goes brr brr', 'dfsd', 1),
(15, 'E12', 'Darkrai', 'nightmare wooo~ scary', 'ror', 1),
(16, 'E13', 'Gible', 'chomp', 'chomp chomp', 1),
(17, 'E14', 'Pikachu', 'overrated fr fr', 'pika pika', 1),
(18, 'E15', 'Shaymin', 'flowerrrrrrr', 'haha', 1),
(19, 'E16', 'Piplup', 'pengu', 'pengu', 1),
(20, 'E17', 'Chimchar', 'monkeh', 'monkey', 1),
(22, 'E18', 'Bulbasaur', 'green', 'green', 1);

-- --------------------------------------------------------

--
-- Table structure for table `exhibit_accession`
--

CREATE TABLE `exhibit_accession` (
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
-- Dumping data for table `exhibit_accession`
--

INSERT INTO `exhibit_accession` (`ID`, `accessionCode`, `establishmentCode`, `galleryCode`, `rackingCode`, `exhibitID`, `accessionDate`, `staffID`, `posted`, `datePosted`, `timestamp`) VALUES
(25, 'A1', 'ESTB1', 'G2', 'R3', 6, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 14:54:06'),
(34, 'A10', 'ESTB1', 'G3', 'R5', 14, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:59:37'),
(36, 'A11', 'ESTB1', 'G2', 'R3', 16, '2023-11-26', 1, 1, '2023-11-27', '2023-11-26 16:13:56'),
(37, 'A12', 'ESTB1', 'G2', 'R3', 15, '2023-11-27', 1, 1, '2023-11-27', '2023-11-26 16:27:17'),
(39, 'A13', 'ESTB1', 'G4', 'R7', 17, '2023-11-27', 1, 1, '2023-11-27', '2023-11-26 16:27:33'),
(40, 'A14', 'ESTB1', 'G4', 'R7', 22, '2023-11-27', 1, 1, '2023-11-27', '2023-11-26 16:27:46'),
(41, 'A15', 'ESTB1', 'G5', 'R8', 18, '2023-11-27', 1, 1, '2023-11-27', '2023-11-26 16:28:08'),
(42, 'A16', 'ESTB1', 'G5', 'R8', 19, '2023-11-26', 1, 1, '2023-11-27', '2023-11-26 16:28:19'),
(43, 'A17', 'ESTB1', 'G5', 'R8', 20, '2023-11-27', 1, 1, '2023-11-27', '2023-11-26 16:28:35'),
(26, 'A2', 'ESTB1', 'G2', 'R4 ', 8, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:26:23'),
(27, 'A3', 'ESTB1', 'G1', 'R1', 1, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 05:28:24'),
(28, 'A4', 'ESTB1', 'G2', 'R3', 7, '2023-11-19', 1, 1, '2023-11-26', '2023-11-26 05:28:38'),
(29, 'A5', 'ESTB1', 'G4', 'R7', 9, '2023-11-20', 1, 1, '2023-11-26', '2023-11-26 05:28:56'),
(30, 'A6', 'ESTB1', 'G2', 'R3', 10, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:58:33'),
(31, 'A7', 'ESTB1', 'G3', 'R5', 11, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:58:52'),
(32, 'A8', 'ESTB1', 'G3', 'R5', 13, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:59:06'),
(33, 'A9', 'ESTB1', 'G3', 'R5', 12, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:59:23');

--
-- Triggers `exhibit_accession`
--
DELIMITER $$
CREATE TRIGGER `accession_posted` AFTER UPDATE ON `exhibit_accession` FOR EACH ROW BEGIN 
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
-- Table structure for table `exhibit_transfer`
--

CREATE TABLE `exhibit_transfer` (
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
-- Dumping data for table `exhibit_transfer`
--

INSERT INTO `exhibit_transfer` (`ID`, `transferCode`, `sourceLocation`, `establishmentCode`, `galleryCode`, `rackingCode`, `exhibitID`, `transferDate`, `staffID`, `posted`, `datePosted`, `timestamp`) VALUES
(15, 'T1', 'National Museum Western Visayas - Gallery 2 - Table 1', 'ESTB1', 'G1', 'R1', 6, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:14:47'),
(24, 'T10', 'National Museum Western Visayas - Gallery 1 - Display Unit', 'ESTB1', 'G1', 'R2', 6, '2023-11-28', 1, 0, '0000-00-00', '2023-11-28 16:47:36'),
(16, 'T2', 'National Museum Western Visayas - Gallery 2 - Display Unit', 'ESTB2', 'G6', 'R9', 8, '2023-11-24', 4, 1, '2023-11-25', '2023-11-25 15:26:46'),
(17, 'T3', 'Stockroom - Stockroom 1 - Shelf 1', 'ESTB1', 'G4', 'R7', 8, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:27:21'),
(18, 'T4', 'National Museum Western Visayas - Gallery 1 - Display Unit', 'ESTB2', 'G6', 'R9', 6, '2023-11-26', 4, 1, '2023-11-25', '2023-11-25 15:28:38'),
(19, 'T5', 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'ESTB1', 'G3', 'R5', 8, '2023-11-23', 5, 1, '2023-11-25', '2023-11-25 15:59:45'),
(20, 'T6', 'Stockroom - Stockroom 1 - Shelf 1', 'ESTB1', 'G1', 'R1', 6, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:22:52'),
(21, 'T7', 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 'ESTB1', 'G1', 'R1', 8, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:23:07'),
(22, 'T8', 'National Museum Western Visayas - Gallery 2 - Table 1', 'ESTB1', 'G1', 'R1', 7, '2023-11-26', 1, 1, '2023-11-26', '2023-11-26 15:23:24'),
(23, 'T9', 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'ESTB1', 'G1', 'R1', 9, '2023-11-19', 1, 1, '2023-11-26', '2023-11-26 15:23:40');

--
-- Triggers `exhibit_transfer`
--
DELIMITER $$
CREATE TRIGGER `transfer_posted` AFTER UPDATE ON `exhibit_transfer` FOR EACH ROW BEGIN 
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
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `ID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `exhibitID` int(11) NOT NULL,
  `ratingScore` tinyint(1) NOT NULL,
  `feedbackContent` text NOT NULL,
  `feedbackDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`ID`, `userID`, `exhibitID`, `ratingScore`, `feedbackContent`, `feedbackDate`) VALUES
(25, 5, 7, 4, '4', '2023-11-30');

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
(66, 1, '2023-11-25', 'T5', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 1, 5, '2023-11-25 15:59:45'),
(67, 1, '2023-11-26', 'A3', 'ACCESSION', 1, NULL, 'National Museum Western Visayas - Gallery 1 - Display Unit', 1, 1, '2023-11-26 05:28:24'),
(68, 1, '2023-11-26', 'A4', 'ACCESSION', 7, NULL, 'National Museum Western Visayas - Gallery 2 - Table 1', 1, 1, '2023-11-26 05:28:38'),
(69, 1, '2023-11-26', 'A5', 'ACCESSION', 9, NULL, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 1, 1, '2023-11-26 05:28:56'),
(70, 1, '2023-11-26', 'T6', 'TRANSFER', 6, 'Stockroom - Stockroom 1 - Shelf 1', 'Stockroom - Stockroom 1 - Shelf 1', -1, 1, '2023-11-26 15:22:52'),
(71, 1, '2023-11-26', 'T6', 'TRANSFER', 6, 'Stockroom - Stockroom 1 - Shelf 1', 'National Museum Western Visayas - Gallery 1 - Display Unit', 1, 1, '2023-11-26 15:22:52'),
(72, 1, '2023-11-26', 'T7', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 'National Museum Western Visayas - Gallery 3 - Cabinet 1', -1, 1, '2023-11-26 15:23:07'),
(73, 1, '2023-11-26', 'T7', 'TRANSFER', 8, 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 'National Museum Western Visayas - Gallery 1 - Display Unit', 1, 1, '2023-11-26 15:23:07'),
(74, 1, '2023-11-26', 'T8', 'TRANSFER', 7, 'National Museum Western Visayas - Gallery 2 - Table 1', 'National Museum Western Visayas - Gallery 2 - Table 1', -1, 1, '2023-11-26 15:23:24'),
(75, 1, '2023-11-26', 'T8', 'TRANSFER', 7, 'National Museum Western Visayas - Gallery 2 - Table 1', 'National Museum Western Visayas - Gallery 1 - Display Unit', 1, 1, '2023-11-26 15:23:24'),
(76, 1, '2023-11-26', 'T9', 'TRANSFER', 9, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'National Museum Western Visayas - Gallery 4 - Glass Wall', -1, 1, '2023-11-26 15:23:40'),
(77, 1, '2023-11-26', 'T9', 'TRANSFER', 9, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 'National Museum Western Visayas - Gallery 1 - Display Unit', 1, 1, '2023-11-26 15:23:40'),
(78, 1, '2023-11-26', 'A6', 'ACCESSION', 10, NULL, 'National Museum Western Visayas - Gallery 2 - Table 1', 1, 1, '2023-11-26 15:58:33'),
(79, 1, '2023-11-26', 'A7', 'ACCESSION', 11, NULL, 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 1, 1, '2023-11-26 15:58:52'),
(80, 1, '2023-11-26', 'A8', 'ACCESSION', 13, NULL, 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 1, 1, '2023-11-26 15:59:06'),
(81, 1, '2023-11-26', 'A9', 'ACCESSION', 12, NULL, 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 1, 1, '2023-11-26 15:59:23'),
(82, 1, '2023-11-26', 'A10', 'ACCESSION', 14, NULL, 'National Museum Western Visayas - Gallery 3 - Cabinet 1', 1, 1, '2023-11-26 15:59:37'),
(83, 1, '2023-11-27', 'A11', 'ACCESSION', 16, NULL, 'National Museum Western Visayas - Gallery 2 - Table 1', 1, 1, '2023-11-26 16:13:56'),
(84, 1, '2023-11-27', 'A12', 'ACCESSION', 15, NULL, 'National Museum Western Visayas - Gallery 2 - Table 1', 1, 1, '2023-11-26 16:27:17'),
(85, 1, '2023-11-27', 'A13', 'ACCESSION', 17, NULL, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 1, 1, '2023-11-26 16:27:33'),
(86, 1, '2023-11-27', 'A14', 'ACCESSION', 22, NULL, 'National Museum Western Visayas - Gallery 4 - Glass Wall', 1, 1, '2023-11-26 16:27:46'),
(87, 1, '2023-11-27', 'A15', 'ACCESSION', 18, NULL, 'National Museum Western Visayas - Gallery 5 - Display Unit', 1, 1, '2023-11-26 16:28:08'),
(88, 1, '2023-11-27', 'A16', 'ACCESSION', 19, NULL, 'National Museum Western Visayas - Gallery 5 - Display Unit', 1, 1, '2023-11-26 16:28:19'),
(89, 1, '2023-11-27', 'A17', 'ACCESSION', 20, NULL, 'National Museum Western Visayas - Gallery 5 - Display Unit', 1, 1, '2023-11-26 16:28:35');

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
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userID` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `userEmail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userID`, `user_name`, `userEmail`) VALUES
(5, 'Froizel Apolonio', 'froizelrej@gmail.com');

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
  ADD KEY `accession_fk1` (`establishmentCode`),
  ADD KEY `accession_fk2` (`galleryCode`),
  ADD KEY `accession_fk3` (`rackingCode`),
  ADD KEY `accession_fk4` (`exhibitID`),
  ADD KEY `accession_fk5` (`staffID`);

--
-- Indexes for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  ADD PRIMARY KEY (`transferCode`),
  ADD KEY `ID` (`ID`),
  ADD KEY `transfer_fk1` (`establishmentCode`),
  ADD KEY `transfer_fk2` (`galleryCode`),
  ADD KEY `transfer_fk3` (`rackingCode`),
  ADD KEY `transfer_fk4` (`exhibitID`),
  ADD KEY `transfer_fk5` (`staffID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `feedback_fk1` (`userID`),
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
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userID`);

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
  MODIFY `exhibitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `exhibit_accession`
--
ALTER TABLE `exhibit_accession`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=90;

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
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `exhibit_accession`
--
ALTER TABLE `exhibit_accession`
  ADD CONSTRAINT `accession_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk2` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk3` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk4` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `accession_fk5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  ADD CONSTRAINT `transfer_fk1` FOREIGN KEY (`establishmentCode`) REFERENCES `establishment` (`establishmentCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk2` FOREIGN KEY (`galleryCode`) REFERENCES `gallery` (`galleryCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk3` FOREIGN KEY (`rackingCode`) REFERENCES `racking` (`rackingCode`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk4` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transfer_fk5` FOREIGN KEY (`staffID`) REFERENCES `staff` (`staffID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_fk1` FOREIGN KEY (`userID`) REFERENCES `user` (`userID`) ON UPDATE NO ACTION,
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
