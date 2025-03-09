-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Feb 24, 2025 at 11:27 AM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbHaarlemFestival`
--

-- --------------------------------------------------------

--
-- Table structure for table `Artist`
--

CREATE TABLE `Artist` (
  `ArtistId` int(11) NOT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DanceEvent`
--

CREATE TABLE `DanceEvent` (
  `EventId` int(11) NOT NULL,
  `ArtistId` int(11) DEFAULT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `TicketsAvailable` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `EventId` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `DateAndTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTour`
--

CREATE TABLE `HistoryTour` (
  `EventId` int(11) NOT NULL,
  `SelectedTime` datetime DEFAULT NULL,
  `LanguageOption` enum('English','Dutch','Chinese') DEFAULT NULL,
  `TicketType` enum('Regular Participant','Family Package Deal') DEFAULT NULL,
  `SelectedDate` date DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Menu`
--

CREATE TABLE `Menu` (
  `MenuId` int(11) NOT NULL,
  `EventId` int(11) DEFAULT NULL,
  `MenuName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MenuItem`
--

CREATE TABLE `MenuItem` (
  `MenuItemId` int(11) NOT NULL,
  `MenuId` int(11) DEFAULT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Order`
--

CREATE TABLE `Order` (
  `OrderId` int(11) NOT NULL,
  `UserId` int(11) DEFAULT NULL,
  `Amount` int(11) DEFAULT NULL,
  `Status` varchar(255) DEFAULT NULL,
  `OrderDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE `Restaurant` (
  `RestaurantId` int(11) NOT NULL,
  `EventId` int(11) DEFAULT NULL,
  `CuisineType` varchar(255) DEFAULT NULL,
  `SessionAvailable` varchar(255) DEFAULT NULL,
  `FirstStart` datetime DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Seats` int(11) DEFAULT NULL,
  `ReducedPrice` int(11) DEFAULT NULL,
  `Comment` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------
--
-- Table structure for table `Ticket`
--

CREATE TABLE `Ticket` (
  `TicketId` int(11) NOT NULL,
  `NoOfPeople` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `EventId` int(11) DEFAULT NULL,
  `OrderId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TourGuide`
--

CREATE TABLE `TourGuide` (
  `TourGuideId` int(11) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `AvailableTime` time DEFAULT NULL,
  `AvailableDate` date DEFAULT NULL,
  `LanguageSpoke` enum('English','Dutch','Chinese') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserId` int(11) NOT NULL,
  `FullName` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` varchar(255) DEFAULT NULL,
  `ResetToken` varchar(255) DEFAULT NULL,
  `ResetTokenExpires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Artist`
--
ALTER TABLE `Artist`
  ADD PRIMARY KEY (`ArtistId`);

--
-- Indexes for table `DanceEvent`
--
ALTER TABLE `DanceEvent`
  ADD PRIMARY KEY (`EventId`),
  ADD KEY `ArtistId` (`ArtistId`);

--
-- Indexes for table `Event`
--
ALTER TABLE `Event`
  ADD PRIMARY KEY (`EventId`);

--
-- Indexes for table `HistoryTour`
--
ALTER TABLE `HistoryTour`
  ADD PRIMARY KEY (`EventId`);

--
-- Indexes for table `Menu`
--
ALTER TABLE `Menu`
  ADD PRIMARY KEY (`MenuId`),
  ADD KEY `EventId` (`EventId`);

--
-- Indexes for table `MenuItem`
--
ALTER TABLE `MenuItem`
  ADD PRIMARY KEY (`MenuItemId`),
  ADD KEY `MenuId` (`MenuId`);

--
-- Indexes for table `Order`
--
ALTER TABLE `Order`
  ADD PRIMARY KEY (`OrderId`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexes for table `Restaurant`
--
ALTER TABLE `Restaurant`
  ADD PRIMARY KEY (`RestaurantId`),
  ADD KEY `EventId` (`EventId`);

--
-- Indexes for table `Ticket`
--
ALTER TABLE `Ticket`
  ADD PRIMARY KEY (`TicketId`),
  ADD KEY `EventId` (`EventId`),
  ADD KEY `OrderId` (`OrderId`);

--
-- Indexes for table `TourGuide`
--
ALTER TABLE `TourGuide`
  ADD PRIMARY KEY (`TourGuideId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Artist`
--
ALTER TABLE `Artist`
  MODIFY `ArtistId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Event`
--
ALTER TABLE `Event`
  MODIFY `EventId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Menu`
--
ALTER TABLE `Menu`
  MODIFY `MenuId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `MenuItem`
--
ALTER TABLE `MenuItem`
  MODIFY `MenuItemId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Order`
--
ALTER TABLE `Order`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Restaurant`
--
ALTER TABLE `Restaurant`
  MODIFY `RestaurantId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Ticket`
--
ALTER TABLE `Ticket`
  MODIFY `TicketId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `TourGuide`
--
ALTER TABLE `TourGuide`
  MODIFY `TourGuideId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `DanceEvent`
--
ALTER TABLE `DanceEvent`
  ADD CONSTRAINT `DanceEvent_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`),
  ADD CONSTRAINT `DanceEvent_ibfk_2` FOREIGN KEY (`ArtistId`) REFERENCES `Artist` (`ArtistId`);

--
-- Constraints for table `HistoryTour`
--
ALTER TABLE `HistoryTour`
  ADD CONSTRAINT `HistoryTour_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

--
-- Constraints for table `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `Menu_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

--
-- Constraints for table `MenuItem`
--
ALTER TABLE `MenuItem`
  ADD CONSTRAINT `MenuItem_ibfk_1` FOREIGN KEY (`MenuId`) REFERENCES `Menu` (`MenuId`);

--
-- Constraints for table `Order`
--
ALTER TABLE `Order`
  ADD CONSTRAINT `Order_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `User` (`UserId`);

--
-- Constraints for table `Restaurant`
--
ALTER TABLE `Restaurant`
  ADD CONSTRAINT `Restaurant_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

--
-- Constraints for table `Ticket`
--
ALTER TABLE `Ticket`
  ADD CONSTRAINT `Ticket_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`),
  ADD CONSTRAINT `Ticket_ibfk_2` FOREIGN KEY (`OrderId`) REFERENCES `Order` (`OrderId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--  Yummy additions --
ALTER TABLE `Restaurant`
ADD COLUMN `Name` VARCHAR(255) NOT NULL AFTER `RestaurantId`,
ADD COLUMN `Description` TEXT DEFAULT NULL AFTER `Name`,
ADD COLUMN `Image_url` VARCHAR(255) DEFAULT NULL AFTER `Description`,
ADD COLUMN `Address` TEXT DEFAULT NULL AFTER `Image_url`,
ADD COLUMN `WorkingHours` TEXT DEFAULT NULL AFTER `Address`;

INSERT INTO `Restaurant` 
(`RestaurantId`, `Name`, `Description`, `Image_url`, `Address`, `CuisineType`, `Seats`, `Rating`, `SessionAvailable`, `Duration`, `FirstStart`, `ReducedPrice`,`WorkingHours`)
VALUES
(1, 'Café de Roemer', 'A cozy café serving Dutch, fish, and European dishes.', 'cafe-roemer.jpg', 'Botermarkt 17, 2011 XL Haarlem', 'Dutch, Fish, European', 35, 4, 3, 1.5, '2024-03-09 18:00:00', 17.50, 'Monday - Tuesday: Closed Wednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30 Sunday: 12:00 - 14:30, 18:30 - 21:00'),
(2, 'Ratatouille', 'Fine French dining by the river, specializing in seafood.', 'ratatouille.jpg', 'Spaarne 96, 2011 CL Haarlem, Nederland', 'French, Fish, European', 52, 4, 3, 2, '2024-03-09 17:00:00', 22.50),
(3, 'Restaurant ML', 'An elegant dining experience offering Dutch and seafood cuisine.', 'restaurant-ml.jpg', 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', 'Dutch, Fish, European', 60, 4, 2, 2, '2024-03-09 17:00:00', 22.50, 'Monday - Tuesday: Closed Wednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30 Sunday: 12:00 - 14:30, 18:30 - 21:00'),
(4, 'Restaurant Fris', 'A blend of Dutch and French flavors in a cozy atmosphere.', 'restaurant-fris.jpg', 'Twijnderslaan 7, 2012 BG Haarlem, Nederland', 'Dutch, French, European', 45, 4, 3, 1.5, '2024-03-09 17:30:00', 22.50, 'Monday - Tuesday: Closed Wednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30 Sunday: 12:00 - 14:30, 18:30 - 21:00'),
(5, 'New Vegas', 'A fully vegan restaurant with innovative plant-based dishes.', 'new-vegas.jpg', 'Koningstraat 5, 2011 TB Haarlem', 'Vegan', 36, 3, 3, 1.5, '2024-03-09 17:00:00', 17.50, 'Monday - Tuesday: Closed Wednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30 Sunday: 12:00 - 14:30, 18:30 - 21:00'),
(6, 'Grand Cafe Brinkman', 'A modern take on Dutch and European cuisine in a grand setting.', 'grand-cafe-brinkman.jpg', 'Grote Markt 13, 2011 RC Haarlem, Nederland', 'Dutch, European, Modern', 100, 3, 3, 1.5, '2024-03-09 16:30:00', 17.50, 'Monday - Tuesday: Closed Wednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30 Sunday: 12:00 - 14:30, 18:30 - 21:00'),
(7, 'Urban Frenchy Bistro Toujours', 'A French-inspired bistro with fresh seafood and Dutch classics.', 'urban-frenchy.jpg', 'Oude Groenmarkt 10-12, 2011 HL Haarlem, Nederland', 'Dutch, Fish, European', 48, 3, 3, 1.5, '2024-03-09 17:30:00', 17.50, 'Monday - Tuesday: Closed Wednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30 Sunday: 12:00 - 14:30, 18:30 - 21:00');
