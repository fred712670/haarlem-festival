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
ADD COLUMN `WorkingHours` TEXT DEFAULT NULL AFTER `Address`,
ADD COLUMN `ImageGallery` TEXT DEFAULT NULL AFTER `Image_url`,
ADD COLUMN `About` TEXT DEFAULT NULL AFTER `Description`;

INSERT INTO `Restaurant` 
(`RestaurantId`, `Name`, `Description`, `About`, `Image_url`, `ImageGallery`, `Address`, `CuisineType`, `Seats`, `Rating`, `SessionAvailable`, `Duration`, `FirstStart`, `ReducedPrice`, `WorkingHours`) 
VALUES
(1, 'Café de Roemer', 'A cozy café serving Dutch, fish, and European dishes.', "Welcome to Café De Roemer, where tradition meets innovation! Located in the heart of Haarlem, we specialize in authentic Italian dishes crafted with locally sourced ingredients. Whether you're here for a romantic dinner, a family gathering, or a casual meal with friends, our warm ambiance and exquisite menu will ensure an unforgettable dining experience.", 
 'cafe-roemer.jpg', 'cafe-de-roemer1.jpg,cafe-de-roemer2.jpg,cafe-de-roemer3.jpg', 
 'Botermarkt 17, 2011 XL Haarlem', 'Dutch, Fish, European', 35, 4, 3, 1.5, '2024-03-09 18:00:00', 17.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00'),

(2, 'Ratatouille', 'Fine French dining by the river, specializing in seafood.', "Welcome to Fris, where tradition meets innovation! Located in the heart of Haarlem, we specialize in authentic Italian dishes crafted with locally sourced ingredients. Whether you're here for a romantic dinner, a family gathering, or a casual meal with friends, our warm ambiance and exquisite menu will ensure an unforgettable dining experience.", 
 'ratatouille.jpg', 'ratatouille1.jpg,ratatouille2.jpg,ratatouille3.jpg', 
 'Spaarne 96, 2011 CL Haarlem, Nederland', 'French, Fish, European', 52, 4, 3, 2, '2024-03-09 17:00:00', 22.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00'),

(3, 'Restaurant ML', 'An elegant dining experience offering Dutch and seafood cuisine.', "Welcome to Restaurant ML, that blends historical elegance with contemporary flair, offering a Michelin-starred menu that impresses with its creativity and taste. Led by Chef Mark Gratama, the restaurant is celebrated for its innovative dishes that expertly combine traditional techniques with modern culinary artistry.",
 'restaurant-ml.jpg', 'restaurant-ml1.jpg,restaurant-ml2.jpg,restaurant-ml3.jpg', 
 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', 'Dutch, Fish, European', 60, 4, 2, 2, '2024-03-09 17:00:00', 22.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00'),

(4, 'Restaurant Fris', 'A blend of Dutch and French flavors in a cozy atmosphere.', "Welcome to Fris! Nestled in the heart of Haarlem, Fris marries contemporary culinary art with the rich flavors of Dutch cuisine. Perfect for a sophisticated night out, a memorable family dinner, or a delightful gathering with friends, our restaurant offers a warm atmosphere and a menu that caters to discerning palates. Join us at Fris for an exceptional dining adventure where every meal is a celebration of modern gastronomy." ,
 'restaurant-fris.jpg', 'restaurant-fris1.jpg,restaurant-fris2.jpg,restaurant-fris3.jpg', 
 'Twijnderslaan 7, 2012 BG Haarlem, Nederland', 'Dutch, French, European', 45, 4, 3, 1.5, '2024-03-09 17:30:00', 22.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00'),

(5, 'New Vegas', 'A fully vegan restaurant with innovative plant-based dishes.', "Welcome to New Vegas, a culinary gem in the bustling heart of Haarlem at Koningstraat 5. Here, we merge vibrant flavors with an artistic flair to bring you a truly unique dining experience. Our kitchen focuses on innovative international cuisine, with each dish crafted to surprise and delight. " ,
 'new-vegas.jpg', 'new-vegas1.jpg,new-vegas2.jpg,new-vegas3.jpg', 
 'Koningstraat 5, 2011 TB Haarlem', 'Vegan', 36, 3, 3, 1.5, '2024-03-09 17:00:00', 17.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00'),

(6, 'Grand Cafe Brinkman', 'A modern take on Dutch and European cuisine in a grand setting.', "Welcome to Grand Café Brinkmann, a cherished landmark nestled in the heart of Haarlem at Grote Markt 13. Established over a century ago, this iconic café blends rich history with contemporary hospitality. Offering a diverse menu that ranges from classic Dutch favorites to modern culinary delights, Grand Café Brinkmann is perfect for any dining occasion. " ,
 'grand-cafe-brinkman.jpg', 'grand-cafe-brinkman1.jpg,grand-cafe-brinkman2.jpg,grand-cafe-brinkman3.jpg', 
 'Grote Markt 13, 2011 RC Haarlem, Nederland', 'Dutch, European, Modern', 100, 3, 3, 1.5, '2024-03-09 16:30:00', 17.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00'),

(7, 'Urban Frenchy Bistro Toujours', 'A French-inspired bistro with fresh seafood and Dutch classics.', "Welcome to Frenchy Bistro Toujours, your slice of Paris nestled in the charming streets of Haarlem at Oude Groenmarkt 10. This cozy bistro offers a romantic and inviting ambiance, perfect for indulging in the finest French cuisine. At Toujours, we pride ourselves on delivering authentic flavors using high-quality ingredients, paired beautifully with our selection of French wines. " ,
 'urban-frenchy.jpg', 'urban-frenchy1.jpg,urban-frenchy2.jpg,urban-frenchy3.jpg', 
 'Oude Groenmarkt 10-12, 2011 HL Haarlem, Nederland', 'Dutch, Fish, European', 48, 3, 3, 1.5, '2024-03-09 17:30:00', 17.50, 
 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00');


 -- Add RegisteredDate column to User table if it doesn't already exist
ALTER TABLE `User` 
ADD COLUMN `RegisteredDate` DATETIME DEFAULT CURRENT_TIMESTAMP AFTER `ResetTokenExpires`;

-- Add Status column to User table for filtering active/inactive users
ALTER TABLE `User` 
ADD COLUMN `Status` ENUM('Active', 'Inactive') NOT NULL DEFAULT 'Active' AFTER `RegisteredDate`;

-- Create indexes for better performance in filtering and searching
CREATE INDEX idx_user_email ON User(Email);
CREATE INDEX idx_user_fullname ON User(FullName);
CREATE INDEX idx_user_role ON User(Role);
CREATE INDEX idx_user_status ON User(Status);
CREATE INDEX idx_user_registered ON User(RegisteredDate);

-- Sample data for testing (optional)
INSERT INTO `User` (`FullName`, `Email`, `Password`, `Role`, `RegisteredDate`, `Status`) VALUES
('John Admin', 'admin@haarlemfestival.com', '$2y$10$GGJ0tLjKEZ1RhYuKqSvs9OOuQJJ5SDhZQDRO0rJA7.TeWI4NFJrJG', 'Administrator', NOW(), 'Active'),
('Jane Employee', 'employee@haarlemfestival.com', '$2y$10$GGJ0tLjKEZ1RhYuKqSvs9OOuQJJ5SDhZQDRO0rJA7.TeWI4NFJrJG', 'Employee', DATE_SUB(NOW(), INTERVAL 1 DAY), 'Active'),
('Bob Customer', 'customer1@example.com', '$2y$10$GGJ0tLjKEZ1RhYuKqSvs9OOuQJJ5SDhZQDRO0rJA7.TeWI4NFJrJG', 'Customer', DATE_SUB(NOW(), INTERVAL 3 DAY), 'Active'),
('Alice Customer', 'customer2@example.com', '$2y$10$GGJ0tLjKEZ1RhYuKqSvs9OOuQJJ5SDhZQDRO0rJA7.TeWI4NFJrJG', 'Customer', DATE_SUB(NOW(), INTERVAL 5 DAY), 'Active'),
('Sam Visitor', 'visitor@example.com', '$2y$10$GGJ0tLjKEZ1RhYuKqSvs9OOuQJJ5SDhZQDRO0rJA7.TeWI4NFJrJG', 'Customer', DATE_SUB(NOW(), INTERVAL 7 DAY), 'Inactive');

-- Note: The password hash above is for 'password123' - for testing purposes only

-- Adding two attributes to the User Table
ALTER TABLE `User` 
ADD COLUMN `verify_token` VARCHAR(255) NULL AFTER `ResetTokenExpires`,
ADD COLUMN `verify_status` TINYINT(1) NOT NULL DEFAULT 0 COMMENT '0=not verified, 1=verified';

-- improving the tour guide tables 
ALTER TABLE `TourGuide` 
DROP COLUMN `AvailableTime`,
DROP COLUMN `AvailableDate`,
MODIFY `FullName` varchar(255) NOT NULL,
MODIFY `LanguageSpoke` enum('English','Dutch','Chinese') NOT NULL,
ADD COLUMN `ProfileImage` varchar(255) DEFAULT NULL;

-- creating history tour schedule 
CREATE TABLE `HistoryTourSchedule` (
  `ScheduleId` int(11) NOT NULL AUTO_INCREMENT,
  `TourDate` date NOT NULL,
  `TourTime` time NOT NULL,
  `TourGuideId` int(11) NOT NULL,
  `Language` enum('English','Dutch','Chinese') NOT NULL,
  `TotalSeats` int(11) NOT NULL DEFAULT 12,
  `SeatsBooked` int(11) NOT NULL DEFAULT 0,
  `TicketPrice` decimal(10,2) NOT NULL,
  `FamilyTicketPrice` decimal(10,2) NOT NULL,
  PRIMARY KEY (`ScheduleId`),
  KEY `idx_tour_date_time` (`TourDate`, `TourTime`),
  KEY `idx_tourguide` (`TourGuideId`),
  CONSTRAINT `fk_schedule_guide` FOREIGN KEY (`TourGuideId`) REFERENCES `TourGuide` (`TourGuideId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--creating history tour booking 
CREATE TABLE `HistoryTourBooking` (
  `BookingId` int(11) NOT NULL AUTO_INCREMENT,
  `ScheduleId` int(11) NOT NULL,
  `Language` enum('English','Dutch','Chinese') NOT NULL,
  `TicketType` enum('Regular Participant','Family Package Deal') NOT NULL,
  `Seats` int(11) NOT NULL DEFAULT 1,
  `TotalPrice` decimal(10,2) NOT NULL,
  `BookingTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`BookingId`),
  KEY `idx_schedule` (`ScheduleId`),
  CONSTRAINT `fk_booking_schedule` FOREIGN KEY (`ScheduleId`) REFERENCES `HistoryTourSchedule` (`ScheduleId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--filling data into tourguide table
INSERT INTO `TourGuide` (`FullName`, `LanguageSpoke`, `ProfileImage`) VALUES
('Jan-Willem', 'Dutch', 'jan-willem.png'),
('Lisa', 'Dutch', 'lisa.png'),
('Frederic', 'English', 'frederic.png'),
('Lisa', 'Chinese', 'lisa-chinese.png'),
('Annet', 'Dutch', 'annet.png'),
('Susan', 'Chinese', 'susan.png'),
('William', 'English', 'william.png'),
('Deirdre', 'English', 'deirdre.png'),
('Kim', 'Chinese', 'kim.png');

-- Thursday, July 24
INSERT INTO `HistoryTourSchedule` (`TourDate`, `TourTime`, `TourGuideId`, `Language`, `TotalSeats`, `SeatsBooked`, `TicketPrice`, `FamilyTicketPrice`) VALUES
('2025-07-24', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-24', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-24', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-24', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-24', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-24', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00);

-- Friday, July 25
INSERT INTO `HistoryTourSchedule` (`TourDate`, `TourTime`, `TourGuideId`, `Language`, `TotalSeats`, `SeatsBooked`, `TicketPrice`, `FamilyTicketPrice`) VALUES
('2025-07-25', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-25', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'William' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-25', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-25', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'William' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-25', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Kim' AND LanguageSpoke = 'Chinese'), 'Chinese', 12, 0, 17.50, 60.00),
('2025-07-25', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-25', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'William' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00);

-- Saturday, July 26
INSERT INTO `HistoryTourSchedule` (`TourDate`, `TourTime`, `TourGuideId`, `Language`, `TotalSeats`, `SeatsBooked`, `TicketPrice`, `FamilyTicketPrice`) VALUES
('2025-07-26', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-26', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-26', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-26', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'William' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-26', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-26', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-26', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-26', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'William' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-26', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Kim' AND LanguageSpoke = 'Chinese'), 'Chinese', 12, 0, 17.50, 60.00),
('2025-07-26', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-26', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00);

-- Sunday, July 27
INSERT INTO `HistoryTourSchedule` (`TourDate`, `TourTime`, `TourGuideId`, `Language`, `TotalSeats`, `SeatsBooked`, `TicketPrice`, `FamilyTicketPrice`) VALUES
('2025-07-27', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Lisa' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Deirdre' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-27', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-27', '10:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Kim' AND LanguageSpoke = 'Chinese'), 'Chinese', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Lisa' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Annet' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Jan-Willem' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Deirdre' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Frederic' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'William' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Kim' AND LanguageSpoke = 'Chinese'), 'Chinese', 12, 0, 17.50, 60.00),
('2025-07-27', '13:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Susan' AND LanguageSpoke = 'Chinese'), 'Chinese', 12, 0, 17.50, 60.00),
('2025-07-27', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Lisa' AND LanguageSpoke = 'Dutch'), 'Dutch', 12, 0, 17.50, 60.00),
('2025-07-27', '16:00:00', (SELECT TourGuideId FROM TourGuide WHERE FullName = 'Deirdre' AND LanguageSpoke = 'English'), 'English', 12, 0, 17.50, 60.00);
