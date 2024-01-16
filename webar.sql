-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 16, 2024 at 06:03 AM
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
(1, 'E1', 'Ship in A Bottle', 'The delicate ship, intricately detailed with scaled masts and rigging, rests within the confines of a glass bottle, a testament to the patience and precision of its creator.', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/ship_in_a_bottle/scene.gltf', 0),
(25, 'E2', 'Oton Gold Death Mask', 'A funerary mask that was placed on eyes and nose of the dead, and was attached to the teeth from the two sides of the lower part of the nose cover to keep it in place.\r\n\r\nThe Oton Gold Death Mask was discovered in-situ on June 5, 1967 at Grave #6 in Madiavilla Property in San Antonio, Oton, Iloilo by the National Museum team headed by anthropologists Alfredo Evangelista and F. Landa Jocano. The artefact was found covering a skull. It consisted of eyes and nose coverings, both embellished with repoussé dots. The funerary mask is dated to late 14th to early 15th century A.D. (Age of Trade).\r\n\r\nThe early Bisayans believed that the human body became vulnerable to evil spirits looking for their next hosts once a spirit departed. After the grieving, the deceased, especially the rich and powerful, was placed inside a coffin made of uncorruptible wood. Rich jewel adorned their body, and sheets of gold sealed their eyes and mouth. The gold ornaments served as defenses for the dead as they defended away evil spirits through their radiance.', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Oton%20Golden%20Death%20Mask.glb', 1),
(26, 'E3', 'Elephant Lower Molar', 'el’-e-fas\r\n750,000 million years old\r\nCabatuan Formation\r\nSitio Bitoguan, Brgy. Jelicuon Montinola, Cabatuan Iloilo\r\n\r\nElephants and stegodon were the largest mammals That ever roamed the area known today as Panay Island, About 750,000 years ago. The most important difference between the two can be observed in the molars. An elephant has crowned, multi-plated, molars, allowing it to graze on grasses and leaves. Whereas, stegendon has low-crowned, roofed-teeth that is well adapted to browsing on twigs and leaves on trees. It also grew longer, straighter tusks that were so close together that they may have draped their trunks over one of the tusks.\r\n\r\nLike its closest living relative, the Asian Elephant, Elephas has two tusks and four molars at any given time. Lower molars, like this fossil, curve inwards (concave) compared to upper molars that curve outwards (convex).', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Elephant%20Lower%20Molar.glb', 1),
(27, 'E4', 'Elephant Upper Molar', 'el’-e-fas\r\n750,000 million years old\r\nCabatuan Formation\r\nSitio Bitoguan, Brgy. Jelicuon Montinola, Cabatuan Iloilo\r\n\r\nElephas sp. has molars with compressed diamonds-shaped structures called lamellae that are adapted to grinding grasses. This fossil has 13 lamellae forming a complete molar.', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Elephant%20Upper%20Molar.glb', 1),
(28, 'E5', 'Juvenile Stegodon Tooth', 'steg’-o-don\r\n750,000 million years old\r\nCabatuan Formation\r\nJelicuon, Cabatuan Iloilo\r\n\r\nStegodon sp. Is an extinct, distant cousin of modern elephants. They were forest-dwellers. Their low, roof-like molars were used to browse and crunch twigs, wood, and leaves on trees. This fossil tooth is small and underdeveloped and would have come from a baby stegodon.', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Juvenile%20stegodon%20tooth.glb', 1),
(29, 'E6', 'Piña Gown', 'Aklan | 2020\r\nPineapple and cotton\r\n\r\nHand-embroidered filipiniana', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Pina%20Gown.glb', 1),
(30, 'E7', 'Siltstone', 'Invertibrate Trace Fossil\r\n5.33 - 11.63 million years old\r\nTarao Formation, Sapitan-Badiang, Guimbal, Iloilo\r\n\r\nFossilized Burrows in Siltstone or Tunnels left by the digging of an ancient worm-like organism. The burrows were filled with yellowish sand as soon as the animal left the burrow or died.', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Siltstone.glb', 1),
(31, 'E8', 'Philippinite Tektite', '790,000 million years old\r\nSitio Bitoguan, Brgy. Jelicuon Montinola, Cabatuan, Iloilo\r\n\r\nTektites found in the Philippines are called philippinites. The largest discovered philippinite weighs 1,281.89 grams. This tektite was discovered by the National Museum of the Philippines in 1984 and weighs 18.19 grams. It is one of millions created through the impact of the meteorite about 790,000 years ago. Interestingly, this ball of glass is found in the same rock formation containing the fossils of the large mammals like elephants and stegodons. ', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Tektite.glb', 1),
(32, 'E9', 'Galingan/Spinning Wheel', 'Indag-an, Miagao, Iloilo\r\n2018\r\nWood, metal, and nylon cord\r\nDonated by Connie F. Atijon', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Spinning%20Wheel.glb', 1),
(33, 'E10', 'Bestida', 'Female dress with pinilian designs\r\n2020\r\nCotton', 'https://raw.githubusercontent.com/yatsurej/3d-models/main/Bestida.glb', 1);

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
(51, 'A1', 'R1', 1, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 14:33:35'),
(60, 'A10', 'R3', 31, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:57:54'),
(52, 'A2', 'R4 ', 25, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:50:51'),
(53, 'A3', 'R1', 26, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:54:16'),
(54, 'A4', 'R1', 27, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:56:18'),
(55, 'A5', 'R5', 28, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:56:32'),
(56, 'A6', 'R7', 29, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:56:52'),
(57, 'A7', 'R1', 30, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:57:04'),
(58, 'A8', 'R6', 32, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:57:22'),
(59, 'A9', 'R8', 33, '2024-01-08', 1, 1, '2024-01-08', '2024-01-08 15:57:42');

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
  `feedbackTitle` text NOT NULL,
  `feedbackContent` text NOT NULL,
  `feedbackDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedbackID`, `guestID`, `exhibitID`, `ratingScore`, `feedbackTitle`, `feedbackContent`, `feedbackDate`) VALUES
(26, 6, 26, 3, '', 'test_3stars', '2024-01-09'),
(27, 6, 27, 5, '', 'test (again)', '2024-01-09'),
(28, 6, 25, 3, '', 'omg wow cool xd', '2024-01-16'),
(29, 6, 25, 5, '', '5 stars xd xd', '2024-01-16'),
(30, 6, 25, 1, 'final test with title', 'xd ', '2024-01-16');

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
(6, '10944241351413152601', 'froizelrej@gmail.com');

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
(101, 1, '2024-01-08', 'A1', 'ACCESSION', 1, NULL, 'R1', 1, 1, '2024-01-08 14:33:35'),
(102, 1, '2024-01-08', 'A2', 'ACCESSION', 25, NULL, 'R4 ', 1, 1, '2024-01-08 15:50:51'),
(103, 1, '2024-01-08', 'A3', 'ACCESSION', 26, NULL, 'R1', 1, 1, '2024-01-08 15:54:16'),
(104, 1, '2024-01-08', 'A4', 'ACCESSION', 27, NULL, 'R1', 1, 1, '2024-01-08 15:56:18'),
(105, 1, '2024-01-08', 'A5', 'ACCESSION', 28, NULL, 'R5', 1, 1, '2024-01-08 15:56:32'),
(106, 1, '2024-01-08', 'A6', 'ACCESSION', 29, NULL, 'R7', 1, 1, '2024-01-08 15:56:52'),
(107, 1, '2024-01-08', 'A7', 'ACCESSION', 30, NULL, 'R1', 1, 1, '2024-01-08 15:57:04'),
(108, 1, '2024-01-08', 'A8', 'ACCESSION', 32, NULL, 'R6', 1, 1, '2024-01-08 15:57:22'),
(109, 1, '2024-01-08', 'A9', 'ACCESSION', 33, NULL, 'R8', 1, 1, '2024-01-08 15:57:42'),
(110, 1, '2024-01-08', 'A10', 'ACCESSION', 31, NULL, 'R3', 1, 1, '2024-01-08 15:57:54');

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
  MODIFY `exhibitID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `exhibit_accession`
--
ALTER TABLE `exhibit_accession`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `exhibit_transfer`
--
ALTER TABLE `exhibit_transfer`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `guest`
--
ALTER TABLE `guest`
  MODIFY `guestID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `movement`
--
ALTER TABLE `movement`
  MODIFY `entryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

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
  ADD CONSTRAINT `feedback_fk1` FOREIGN KEY (`guestID`) REFERENCES `guest` (`guestID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feedback_fk2` FOREIGN KEY (`exhibitID`) REFERENCES `exhibit` (`exhibitID`) ON DELETE CASCADE ON UPDATE CASCADE;

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
