-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Mar 25, 2025 at 06:16 PM
-- Server version: 11.6.2-MariaDB-ubu2404
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `developmentdb`
--

-- --------------------------------------------------------

USE developmentdb;

--
-- Table structure for table `Appearances`
--

CREATE TABLE `Appearances` (
  `EventId` int(11) DEFAULT NULL,
  `ArtistId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Content`
--

CREATE TABLE `Content` (
  `ContentId` int(11) NOT NULL,
  `EventType` enum('home','dance','history','yummy','magic','jazz') DEFAULT NULL,
  `Section` varchar(50) DEFAULT NULL,
  `Content` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Content`
--

INSERT INTO `Content` (`ContentId`, `EventType`, `Section`, `Content`) VALUES
(1, 'history', 'overview', 'Haarlem, one of the Netherlands\'s most picturesque cities, is steeped in history and culture. From its cobblestone streets to grand churches, Haarlem offers a glimpse into the past. This walking tour takes you through the city\'s iconic landmarks, blending stories of its vibrant history with breathtaking architecture.'),
(2, 'history', 'event_detail', 'Embark on an unforgettable journey through Haarlem\'s historic streets with our guided walking tour. This 2.5-hour experience includes visits to the city\'s most renowned landmarks and a 15-minute refreshment break. Perfect for history enthusiasts and curious travelers alike, this tour provides an intimate glimpse into Haarlem\'s cultural and architectural treasures.'),
(3, 'dance', 'aboutUs', 'At Haarlem Dance, we showcase top-tier dance, house, techno, and trance acts in iconic venues in and around the city of Haarlem. Six world-class DJs will thrill audiences with epic Back2Back sessions on big stages and intimate experimental club sets. So don’t miss out — hop in, join the vibe, and dance the night away.');

-- --------------------------------------------------------

--
-- Table structure for table `DanceArtist`
--

CREATE TABLE `DanceArtist` (
  `ArtistId` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Genre` varchar(100) DEFAULT NULL,
  `ProfileImageName` varchar(100) DEFAULT NULL,
  `DetailImageName` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `DanceArtist`
--

INSERT INTO `DanceArtist` (`ArtistId`, `Name`, `Genre`, `ProfileImageName`, `DetailImageName`, `Description`) VALUES
(7, 'Hardwell', 'Dance & House', 'HardwellProfile.png', 'HardwellDetail.png', NULL),
(8, 'Armin van Buuren', 'Trance & Techno', 'BuurenProfile.png', 'BuurenDetail.png', NULL),
(9, 'Martin Garrix', 'Dance & Electronic', 'GarrixProfile.png', 'GarrixDetail.png', NULL),
(10, 'Tiësto', 'Trance, Techno, Minimal, House & Electronic', 'TiestoProfile.png', 'TiestoDetail.png', 'Tiësto, born Tijs Michiel Verwest on January 17, 1969, in Breda, Netherlands, is a Grammy-winning DJ and one of the most influential figures in the global electronic dance music scene. Rising to prominence with his trance anthems in the early 2000s, Tiësto later evolved his style to include house, electro, and pop influences, cementing his versatility. He was the first DJ to perform at the Olympic Games and continues to headline major festivals worldwide, inspiring generations of producers and fans alike.'),
(11, 'Nicky Romero', 'Electrohouse & Progressive House', 'RomeroProfile.png', 'RomeroDetail.png', NULL),
(12, 'Afrojack', 'House', 'AfrojackProfile.png', 'AfrojackDetail.png', 'Afrojack, born Nick van de Wall on September 9, 1987, in Spijkenisse, Netherlands, is a world-renowned DJ, producer, and music entrepreneur. He rose to fame in the early 2010s with his unique electro-house sound and has become one of the most influential figures in electronic dance music.'),
(13, 'Hardwell', 'Dance & House', 'HardwellProfile.png', 'HardwellDetail.png', NULL),
(14, 'Armin van Buuren', 'Trance & Techno', 'BuurenProfile.png', 'BuurenDetail.png', NULL),
(15, 'Martin Garrix', 'Dance & Electronic', 'GarrixProfile.png', 'GarrixDetail.png', NULL),
(16, 'Tiësto', 'Trance, Techno, Minimal, House & Electronic', 'TiestoProfile.png', 'TiestoDetail.png', 'Tiësto, born Tijs Michiel Verwest on January 17, 1969, in Breda, Netherlands, is a Grammy-winning DJ and one of the most influential figures in the global electronic dance music scene. Rising to prominence with his trance anthems in the early 2000s, Tiësto later evolved his style to include house, electro, and pop influences, cementing his versatility. He was the first DJ to perform at the Olympic Games and continues to headline major festivals worldwide, inspiring generations of producers and fans alike.'),
(17, 'Nicky Romero', 'Electrohouse & Progressive House', 'RomeroProfile.png', 'RomeroDetail.png', NULL),
(18, 'Afrojack', 'House', 'AfrojackProfile.png', 'AfrojackDetail.png', 'Afrojack, born Nick van de Wall on September 9, 1987, in Spijkenisse, Netherlands, is a world-renowned DJ, producer, and music entrepreneur. He rose to fame in the early 2010s with his unique electro-house sound and has become one of the most influential figures in electronic dance music.');
-- --------------------------------------------------------

--
-- Table structure for table `DanceEvent`
--

CREATE TABLE `DanceEvent` (
  `DanceEventId` int(11) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `TimeSlot` varchar(100) DEFAULT NULL,
  `DurationByMinute` int(11) DEFAULT NULL,
  `TicketsAvailable` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DancePerformance`
--

CREATE TABLE `DancePerformance` (
  `DanceEventId` int(11) NOT NULL,
  `DanceArtistId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `DanceSong`
--

CREATE TABLE `DanceSong` (
  `SongId` int(11) NOT NULL,
  `ArtistId` int(11) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `ReleaseYear` int(11) DEFAULT NULL,
  `Credits` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `SongFileName` varchar(100) DEFAULT NULL,
  `ImageName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `DanceSong`
--

INSERT INTO `DanceSong` (`SongId`, `ArtistId`, `Title`, `ReleaseYear`, `Credits`, `Description`, `SongFileName`, `ImageName`) VALUES
(4, NULL, 'Take Over Control', 2010, 'Eva Simons', 'Afrojack’s breakout hit, a global anthem that introduced his electro-house style to the world and catapulted him to international fame.', 'Afrojack_takeovercontrol.mp3', 'Afrojack_1.png'),
(5, NULL, 'Give Me Everything', 2011, 'Pitbull, Ne-Yo, & Nayer', 'Co-produced by Afrojack, this collaboration with Pitbull topped the Billboard Hot 100 in the U.S. and charted in over 30 countries.', 'Afrojack_givemeeverything.mp3', 'Afrojack_2.png'),
(6, NULL, 'The Spark', 2013, 'Spree Wilson', 'A feel-good anthem that showcases Afrojack’s ability to blend EDM with pop elements, \"The Spark\" is a motivational track that resonates with audiences beyond the dance floor.', 'Afrojack_thespark.mp3', 'Afrojack_3.png');

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `EventId` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `TimeSlot` varchar(50) DEFAULT NULL,
  `DurationByMinute` int(11) DEFAULT NULL,
  `TicketsAvailable` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Event`
--

INSERT INTO `Event` (`EventId`, `Description`, `Location`, `StartDateTime`, `TimeSlot`, `DurationByMinute`, `TicketsAvailable`, `Price`) VALUES
(101, 'Gumbo Kings performance at Patronaat', '1', '2023-07-27 18:00:00', 'Evening', 60, 300, 15),
(102, 'Evolve performance at Patronaat', '1', '2023-07-27 19:30:00', 'Evening', 60, 300, 15),
(103, 'Ntjam Rosie performance at Patronaat', '1', '2023-07-27 21:00:00', 'Evening', 60, 300, 15),
(104, 'Wicked Jazz Sounds performance at Patronaat', '2', '2023-07-27 18:00:00', 'Evening', 60, 200, 10),
(105, 'Wouter Hamel performance at Patronaat', '2', '2023-07-27 19:30:00', 'Evening', 60, 200, 10),
(106, 'Jonna Frazer performance at Patronaat', '2', '2023-07-27 21:00:00', 'Evening', 60, 200, 10),
(107, 'Karsu performance at Patronaat', '1', '2023-07-28 18:00:00', 'Evening', 60, 300, 15),
(108, 'Uncle Sue performance at Patronaat', '1', '2023-07-28 19:30:00', 'Evening', 60, 300, 15),
(109, 'Chris Allen performance at Patronaat', '1', '2023-07-28 21:00:00', 'Evening', 60, 300, 15),
(110, 'Myles Sanko performance at Patronaat', '2', '2023-07-28 18:00:00', 'Evening', 60, 200, 10),
(111, 'Ilse Huizinga performance at Patronaat', '2', '2023-07-28 19:30:00', 'Evening', 60, 200, 10),
(112, 'Eric Vloeimans and Hotspot! performance at Patronaat', '2', '2023-07-28 21:00:00', 'Evening', 60, 200, 10),
(113, 'Gare du Nord performance at Patronaat', '1', '2023-07-29 18:00:00', 'Evening', 60, 300, 15),
(114, 'Rilan & The Bombadiers performance at Patronaat', '1', '2023-07-29 19:30:00', 'Evening', 60, 300, 15),
(115, 'Soul Six performance at Patronaat', '1', '2023-07-29 21:00:00', 'Evening', 60, 300, 15),
(116, 'Han Bennink performance at Patronaat', '3', '2023-07-29 18:00:00', 'Evening', 60, 150, 10),
(117, 'The Nordanians performance at Patronaat', '3', '2023-07-29 19:30:00', 'Evening', 60, 150, 10),
(118, 'Lilith Merlot performance at Patronaat', '3', '2023-07-29 21:00:00', 'Evening', 60, 150, 10),
(119, 'Ruis Soundsystem performance at Grote Markt', '4', '2023-07-30 15:00:00', 'Afternoon', 60, 1000, 0),
(120, 'Wicked Jazz Sounds performance at Grote Markt', '4', '2023-07-30 16:00:00', 'Afternoon', 60, 1000, 0),
(121, 'Evolve performance at Grote Markt', '4', '2023-07-30 17:00:00', 'Afternoon', 60, 1000, 0),
(122, 'The Nordanians performance at Grote Markt', '4', '2023-07-30 18:00:00', 'Evening', 60, 1000, 0),
(123, 'Gumbo Kings performance at Grote Markt', '4', '2023-07-30 19:00:00', 'Evening', 60, 1000, 0),
(124, 'Gare du Nord performance at Grote Markt', '4', '2023-07-30 20:00:00', 'Evening', 60, 1000, 0),
(1001, 'Gumbo Kings at Haarlem Jazz', '1', '2023-07-27 19:00:00', 'Evening', 90, 300, 25),
(1002, 'Evolve at Haarlem Jazz', '2', '2023-07-27 21:00:00', 'Evening', 90, 200, 20),
(1003, 'Ntjam Rosie at Haarlem Jazz', '1', '2023-07-28 19:00:00', 'Evening', 90, 300, 25),
(1004, 'Wicked Jazz Sounds at Haarlem Jazz', '2', '2023-07-28 21:00:00', 'Evening', 90, 200, 20),
(1005, 'Wouter Hamel at Haarlem Jazz', '1', '2023-07-29 19:00:00', 'Evening', 90, 300, 25),
(1006, 'Uncle Sue at Haarlem Jazz', '2', '2023-07-29 21:00:00', 'Evening', 90, 200, 20),
(1007, 'Karsu at Haarlem Jazz', '4', '2023-07-30 15:00:00', 'Afternoon', 60, 1000, 0),
(1008, 'Jonna Fraser at Haarlem Jazz', '4', '2023-07-30 17:00:00', 'Evening', 60, 1000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTour`
--

CREATE TABLE `HistoryTour` (
  `EventId` int(11) NOT NULL,
  `LocationId` int(11) DEFAULT NULL,
  `LocationName` varchar(100) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `WhyVisit` text DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `ImageGenera` varchar(255) DEFAULT NULL,
  `ImageGallery` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `HistoryTour`
--

INSERT INTO `HistoryTour` (`EventId`, `LocationId`, `LocationName`, `Description`, `WhyVisit`, `Address`, `ImageGenera`, `ImageGallery`) VALUES
(1, 1, 'Church of St. Bavo', 'The Church of St. Bavo, an iconic Gothic masterpiece in Haarlem, dates back to the 14th century. Known for its towering spire and stunning architecture, it houses the world-famous Müller organ, once played by Mozart himself. A true symbol of Haarlem\'s rich history and grandeur.', 'Experience the magnificent Müller Organ, played by Mozart himself in 1766 and considered one of the world\'s most renowned instruments.||Marvel at the stunning Gothic architecture with its soaring arches, majestic spire, and vibrant stained-glass windows that have inspired visitors for centuries.||Immerse yourself in the rich history of this symbol of Dutch religious and cultural heritage that has hosted countless important events and remains the spiritual heart of Haarlem.', 'Grote Markt, Haarlem', 'st-bavo.png', 'st-bavo5.png,st-bavo1.png,st-bavo2.png,st-bavo3.png,st-bavo4.png'),
(2, 2, 'Grote Markt', 'The Grote Markt, Haarlem\'s historic main square, is the heart of the city. Surrounded by landmarks like the Town Hall and the Church of St. Bavo, it serves as a vibrant gathering place for markets, events, and cultural celebrations.', 'Experience the vibrant heartbeat of Haarlem at this historic square that has been the city\'s central gathering place since medieval times.||Enjoy the bustling atmosphere with charming cafés, restaurants, and seasonal markets in a picturesque setting surrounded by stunning historic buildings.||Capture breathtaking photos of the iconic St. Bavo Church and Renaissance-style Town Hall that define Haarlem\'s skyline and showcase its Golden Age prosperity.', 'Grote Markt, Haarlem', 'grote-markt.png', 'grote-markt1.png,grote-markt2.png,grote-markt.png,grote-markt3.png,grote-markt4.png'),
(3, 3, 'De Hallen', 'De Hallen Haarlem, a striking cultural landmark, is home to the Frans Hals Museum\'s contemporary art collection. Located in a historic building on the Grote Markt, it offers a blend of modern creativity and Haarlem\'s rich artistic heritage.', 'Discover contemporary art exhibitions housed in a beautifully preserved historic building with a fascinating architectural contrast between old and new.||Experience the evolution of Dutch and international art through carefully curated collections and rotating exhibitions that showcase emerging and established artists.||Take a break from traditional sightseeing to immerse yourself in modern creativity while still appreciating Haarlem\'s rich cultural heritage in this thoughtfully renovated space.', 'Grote Markt 16, Haarlem', 'de-hallen.png', 'de-hallen1.png,de-hallen2.png,de-hallen.png,de-hallen3.png,de-hallen4.png'),
(4, 4, 'Proveniershof', 'Proveniershof, a serene 17th-century courtyard in Haarlem, is nestled among picturesque historic houses. Once home to retired tradesmen, it now offers a peaceful escape, showcasing the city\'s rich architectural and cultural heritage.', 'Step back in time as you enter this peaceful 17th-century courtyard hidden away from the bustling city streets, offering a serene escape from urban life.||Experience the unique Dutch \"hofje\" tradition of communal living spaces built for elderly residents through charitable foundations, a social system that predates modern welfare.||Admire the perfectly preserved historic houses, lush garden, and authentic architectural details that offer a glimpse into Haarlem\'s social history and community values.', 'Grote Houtstraat 140, Haarlem', 'proveniershof.png', 'proveniershof1.png,proveniershof2.png,proveniershof.png,proveniershof3.png,proveniershof4.png'),
(5, 5, 'Jopenkerk', 'Jopenkerk Haarlem, a former church turned brewery, blends history with modern craft beer culture. This unique venue offers visitors a chance to enjoy locally brewed Jopen beers while surrounded by stunning stained-glass windows and Gothic architecture, making it a must-visit landmark.', 'Sample award-winning craft beers made according to historic Haarlem recipes in the unique setting of a repurposed historic church that blends sacred and secular worlds.||Marvel at the stunning transformation of this religious space into a brewery while still preserving its architectural grandeur, soaring ceiling, and beautiful stained-glass windows.||Enjoy the perfect blend of historical appreciation and modern hospitality with excellent food pairings in this truly unique landmark that epitomizes creative adaptive reuse.', 'Gedempte Voldersgracht 2, Haarlem', 'jopenkerk.png', 'jopenkerk1.png,jopenkerk2.png,jopenkerk.png,jopenkerk3.png,jopenkerk4.png'),
(6, 6, 'Waalse Kerk Haarlem', 'The Waalse Kerk, a charming 14th-century chapel in Haarlem, is renowned for its intimate atmosphere and beautiful acoustics. Once a refuge for French Huguenots, it now serves as a cultural venue for concerts and events.', 'Experience the intimate atmosphere of this historic chapel that once provided refuge for French Huguenots fleeing religious persecution, a testament to Haarlem\'s tradition of tolerance.||Listen to the incredible acoustics that make this venue a favorite for chamber music concerts and cultural performances throughout the year.||Admire the elegant simplicity of this smaller church that offers a more peaceful alternative to the grandeur of St. Bavo, with its own unique charm and historical significance.', 'Begijnhof 30, Haarlem', 'waalse-kerk.png', 'waalse-kerk1.png,waalse-kerk2.png,waalse-kerk.png,waalse-kerk3.png,waalse-kerk4.png'),
(7, 7, 'Molen de Adriaan', 'Molen de Adriaan, a historic windmill on the banks of the Spaarne River, offers panoramic views of Haarlem. Originally built in 1779, this iconic landmark showcases the Netherlands\' rich milling heritage and provides a fascinating glimpse into traditional Dutch craftsmanship.', 'Climb to the top of this historic windmill for panoramic views of Haarlem and the Spaarne River that you can\'t get anywhere else in the city.||Learn about traditional Dutch milling craftsmanship through interactive exhibits and demonstrations of this iconic symbol of Dutch heritage and industrial history.||Photograph this perfectly reconstructed 18th-century landmark that has become one of Haarlem\'s most recognizable symbols and a testament to Dutch determination and engineering.', 'Papentorenvest 1A, Haarlem', 'molen-adriaan1.png', 'molen-adriaan3.png,molen-adriaan2.png,molen-adriaan4.png,molen-adriaan5.png,molen-adriaan6.png'),
(8, 8, 'Amsterdamse Poort', 'The Amsterdamse Poort, Haarlem\'s last remaining city gate, is a stunning medieval structure dating back to the 14th century. Once a key entry point to the city, it now stands as a testament to Haarlem\'s rich history and architectural grandeur.', 'Walk through Haarlem\'s last remaining medieval city gate that has stood guard since the 14th century as a testament to the city\'s defensive past and historical importance.||Imagine the countless travelers, merchants, and visitors who passed beneath these arches over more than 600 years of history, connecting Haarlem to Amsterdam and beyond.||Capture stunning photos of this well-preserved Gothic structure that creates a dramatic contrast with the modern city that has grown around it while maintaining its historic integrity.', 'Amsterdamse Poort, Haarlem', 'amsterdamse-poort2.png', 'amsterdamse-poort1.png,amsterdamse-poort2.png,amsterdamse-poort3.png'),
(9, 9, 'Hof van Bakenes', 'Hof van Bakenes, Haarlem\'s oldest hofje, is a tranquil courtyard dating back to the 14th century. Surrounded by charming historic houses, it offers a peaceful retreat and a glimpse into the city\'s tradition of community living.', 'Discover Haarlem\'s oldest hofje (courtyard) dating back to 1395, offering a glimpse into early Dutch charitable housing traditions that shaped urban development.||Experience the serene atmosphere of this hidden garden courtyard that feels worlds away from the busy streets just steps away, providing a peaceful retreat.||Admire the charming historic houses surrounding the courtyard that have sheltered residents for over six centuries, exemplifying the Dutch commitment to community and social welfare.', 'Bakenessergracht 67, Haarlem', 'hof-van-bakenes.png', 'molen-adriaan3.png,molen-adriaan2.png,molen-adriaan4.png,molen-adriaan5.png,molen-adriaan6.png');

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTourBooking`
--

CREATE TABLE `HistoryTourBooking` (
  `BookingId` int(11) NOT NULL,
  `ScheduleId` int(11) DEFAULT NULL,
  `Language` enum('English','Dutch','Chinese') DEFAULT NULL,
  `TicketType` enum('Regular Participant','Family Package Deal') DEFAULT NULL,
  `Seats` int(11) DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `BookingTime` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTourSchedule`
--

CREATE TABLE `HistoryTourSchedule` (
  `EventId` int(11) NOT NULL,
  `ScheduleId` int(11) DEFAULT NULL,
  `TourDate` date DEFAULT NULL,
  `TourTime` time DEFAULT NULL,
  `Language` enum('English','Dutch','Chinese') DEFAULT NULL,
  `GuideId` int(11) DEFAULT NULL,
  `TicketsAvailable` int(11) DEFAULT NULL,
  `TicketPrice` decimal(10,2) DEFAULT NULL,
  `FamilyTicketPrice` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `HistoryTourSchedule`
--

INSERT INTO `HistoryTourSchedule` (`EventId`, `ScheduleId`, `TourDate`, `TourTime`, `Language`, `GuideId`, `TicketsAvailable`, `TicketPrice`, `FamilyTicketPrice`) VALUES
(101, 1, '2025-07-24', '10:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(102, 2, '2025-07-24', '10:00:00', 'English', 3, 12, 17.50, 60.00),
(103, 3, '2025-07-24', '13:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(104, 4, '2025-07-24', '13:00:00', 'English', 3, 12, 17.50, 60.00),
(105, 5, '2025-07-24', '16:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(106, 6, '2025-07-24', '16:00:00', 'English', 3, 12, 17.50, 60.00),
(107, 7, '2025-07-25', '10:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(108, 8, '2025-07-25', '10:00:00', 'English', 7, 12, 17.50, 60.00),
(109, 9, '2025-07-25', '13:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(110, 10, '2025-07-25', '13:00:00', 'English', 7, 12, 17.50, 60.00),
(111, 11, '2025-07-25', '13:00:00', 'Chinese', 9, 12, 17.50, 60.00),
(112, 12, '2025-07-25', '16:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(113, 13, '2025-07-25', '16:00:00', 'English', 7, 12, 17.50, 60.00),
(114, 14, '2025-07-26', '10:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(115, 15, '2025-07-26', '10:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(116, 16, '2025-07-26', '10:00:00', 'English', 3, 12, 17.50, 60.00),
(117, 17, '2025-07-26', '10:00:00', 'English', 7, 12, 17.50, 60.00),
(118, 18, '2025-07-26', '13:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(119, 19, '2025-07-26', '13:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(120, 20, '2025-07-26', '13:00:00', 'English', 3, 12, 17.50, 60.00),
(121, 21, '2025-07-26', '13:00:00', 'English', 7, 12, 17.50, 60.00),
(122, 22, '2025-07-26', '13:00:00', 'Chinese', 9, 12, 17.50, 60.00),
(123, 23, '2025-07-26', '16:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(124, 24, '2025-07-26', '16:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(125, 25, '2025-07-27', '10:00:00', 'Dutch', 2, 12, 17.50, 60.00),
(126, 26, '2025-07-27', '10:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(127, 27, '2025-07-27', '10:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(128, 28, '2025-07-27', '10:00:00', 'English', 8, 12, 17.50, 60.00),
(129, 29, '2025-07-27', '10:00:00', 'English', 3, 12, 17.50, 60.00),
(130, 30, '2025-07-27', '10:00:00', 'Chinese', 9, 12, 17.50, 60.00),
(131, 31, '2025-07-27', '13:00:00', 'Dutch', 2, 12, 17.50, 60.00),
(132, 32, '2025-07-27', '13:00:00', 'Dutch', 5, 12, 17.50, 60.00),
(133, 33, '2025-07-27', '13:00:00', 'Dutch', 1, 12, 17.50, 60.00),
(134, 34, '2025-07-27', '13:00:00', 'English', 8, 12, 17.50, 60.00),
(135, 35, '2025-07-27', '13:00:00', 'English', 3, 12, 17.50, 60.00),
(136, 36, '2025-07-27', '13:00:00', 'English', 7, 12, 17.50, 60.00),
(137, 37, '2025-07-27', '13:00:00', 'Chinese', 9, 12, 17.50, 60.00),
(138, 38, '2025-07-27', '13:00:00', 'Chinese', 6, 12, 17.50, 60.00),
(139, 39, '2025-07-27', '16:00:00', 'Dutch', 2, 12, 17.50, 60.00),
(140, 40, '2025-07-27', '16:00:00', 'English', 8, 12, 17.50, 60.00);

-- --------------------------------------------------------

--
-- Table structure for table `JazzArtist`
--

CREATE TABLE `JazzArtist` (
  `ArtistId` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Hashtag` varchar(100) DEFAULT NULL,
  `ProfileImageName` varchar(100) DEFAULT NULL,
  `artistGallery` text DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `musical_style` text DEFAULT NULL,
  `career_highlights` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzArtist`
--

INSERT INTO `JazzArtist` (`ArtistId`, `Name`, `Hashtag`, `ProfileImageName`, `artistGallery`, `Description`, `short_description`, `musical_style`, `career_highlights`) VALUES
(1, 'Gumbo Kings', '#gumbokings', 'gumbo-kings.jpg', 'gumbo-kings-banner.jpg', 'Gumbo Kings is a high-energy jazz band known for their infectious New Orleans groove mixed with modern soul and funk influences. Their performances are a thrilling experience, featuring tight horn arrangements, lively improvisations, and an undeniable sense of rhythm that gets audiences dancing. Drawing inspiration from classic brass bands while infusing contemporary elements, they have carved out a unique space in the jazz world. The band has toured extensively across Europe, bringing their energetic sound to festival stages and jazz clubs alike. With a commitment to keeping the spirit of New Orleans jazz alive while pushing its boundaries, Gumbo Kings continue to gain recognition for their electrifying live shows and innovative approach to the genre.', 'A high-energy jazz band blending New Orleans groove with modern soul and funk influences.', 'New Orleans-inspired jazz\nEnergetic and dynamic live performances\nTraditional jazz with a modern twist', ' Performed at numerous jazz festivals across Europe (2010-Present)\nKnown for their electrifying New Orleans-inspired sound (2012-Present)\nAcclaimed for innovative live performances (2013-Present)\nPlayed in venues ranging from intimate jazz clubs to major international festivals (2014-Present)'),
(2, 'Evolve', '#evolve', 'evolve.jpg', 'evolve-banner.jpg', 'Evolve is a forward-thinking jazz collective that seamlessly integrates modern electronic elements with the improvisational spirit of jazz. Their sound is characterized by lush synthesizers, intricate rhythms, and dynamic interplay between acoustic and digital instrumentation. Constantly pushing the boundaries of jazz fusion, they experiment with textures and soundscapes that create an immersive listening experience. Their music appeals to both jazz purists and fans of progressive electronic music, making them a staple in contemporary jazz festivals. With each performance, Evolve crafts a sonic journey that challenges and excites, cementing their reputation as one of the most innovative acts in modern jazz.', 'A dynamic jazz collective pushing the boundaries of contemporary jazz with fusion and electronic elements.', '\nFusion of electronic and acoustic elements\nExperimentation with jazz and electronic music\nCutting-edge approach to jazz with a contemporary twist', '\nFeatured at renowned jazz festivals (2014-Present)\nKnown for experimental fusion of electronic and acoustic elements (2016-Present)\nCollaborated with cutting-edge artists from various genres (2015-Present)\nGained recognition as one of the most innovative jazz collectives of their generation (2017-Present)'),
(3, 'Ntjam Rosie', '#ntjamrosie', 'ntjam-rosie.jpg', 'ntjam-rosie-banner.jpg', 'Ntjam Rosie is a Dutch-Cameroonian singer and songwriter known for her rich blend of jazz, soul, and African influences. Her expressive voice and deeply personal songwriting make her music both captivating and emotionally resonant. Ntjam Rosie’s sound fuses traditional jazz harmonies with rhythmic Afrobeat elements, creating a unique and vibrant musical identity. Over the years, she has released several critically acclaimed albums and graced the stages of major jazz festivals across Europe. Her artistry transcends genres, making her one of the most exciting and versatile voices in the contemporary jazz and soul scene.', 'A soulful jazz vocalist mixing jazz, R&B, and African influences into a rich, warm sound.', '\nBlend of jazz, soul, and African rhythms\nEmotionally resonant music with depth and authenticity\nFocus on storytelling and connection with listeners', '\nReceived critical acclaim for emotionally resonant music (2015-Present)\nPerformed at major jazz festivals across Europe (2016-Present)\nKnown for blending jazz, soul, and African rhythms (2017-Present)\nMusic continues to inspire listeners with depth and authenticity (2018-Present)'),
(4, 'Wicked Jazz Sounds', '#wickedjazzsounds', 'wicked-jazz-sounds.jpg', 'wicked-jazz-sounds-banner.jpg', 'Wicked Jazz Sounds is a genre-defying collective that fuses jazz with funk, soul, hip-hop, and electronic beats. Their dynamic live performances blend live instrumentation with DJ sets, creating a seamless mix of classic jazz grooves and dancefloor energy. They have gained a strong following through their residency at Amsterdam’s leading jazz venues and frequent festival appearances. By bridging the gap between jazz and modern dance music, Wicked Jazz Sounds offers an exciting and fresh take on live performance, appealing to both jazz aficionados and club-goers alike.', 'A genre-blending band and DJ collective fusing jazz, funk, and electronic beats for vibrant live performances.', '\nFusion of jazz, funk, soul, and electronic music\nBlending live jazz instrumentation with DJ sets\nBoundary-pushing and genre-defying sound', '\nA prominent fixture in the European jazz scene (2015-Present)\nPioneering fusion of jazz, funk, soul, and electronic music (2016-Present)\nUnique performances blending live jazz instrumentation with DJ sets (2017-Present)\nBuilt a loyal following through boundary-pushing music and dynamic performances (2018-Present)'),
(5, 'Wouter Hamel', '#wouterhamel', 'wouter-hamel.jpg', 'wouter-hamel-banner.jpg', 'Wouter Hamel is a Dutch singer-songwriter who masterfully blends jazz with pop sensibilities. His smooth vocal style, catchy melodies, and sophisticated arrangements make his music accessible while still retaining the depth of jazz traditions. Hamel first gained international recognition with his debut album, which introduced audiences to his unique jazz-pop sound. Since then, he has performed across Europe and Asia, captivating fans with his charming stage presence and heartfelt songwriting. His ability to fuse vintage jazz influences with contemporary pop elements has made him one of the leading figures in modern jazz-pop.', 'A Dutch jazz-pop singer-songwriter known for his smooth vocals and sophisticated, catchy melodies.', '\nSophisticated jazz-pop sound\nCatchy melodies and smooth arrangements\nHeartfelt songwriting and engaging live performances', '\nPerformed internationally across Europe and Asia (2014-Present)\nGained a reputation for sophisticated jazz-pop sound (2015-Present)\nCelebrated for catchy melodies and smooth arrangements (2016-Present)\nCaptivates audiences with engaging live shows and heartfelt songwriting (2017-Present)'),
(6, 'Jonna Fraser', '#jonnafraser', 'jonna-fraser.jpg', 'jonna-fraser-banner.jpg', 'Jonna Fraser is a versatile artist who seamlessly incorporates jazz influences into his hip-hop and R&B sound. His music is characterized by smooth melodies, intricate vocal arrangements, and a deep sense of groove. As an artist who constantly experiments with genre-blending, Fraser brings a fresh perspective to modern music by infusing his tracks with jazz harmonies and rhythms. His ability to switch between soulful ballads and upbeat tracks has earned him a devoted fanbase, and he continues to be a key player in the evolution of contemporary urban music with a jazz twist.', 'A versatile artist incorporating jazz influences into R&B, hip-hop, and soul-infused music.', '\nGenre-blending with jazz influences in hip-hop and R&B\nSmooth melodies and intricate vocal arrangements\nContemporary urban music with jazz elements', '\nKnown for genre-blending approach with jazz influences in hip-hop and R&B (2014-Present)\nPerformance characterized by smooth melodies and intricate vocal arrangements (2015-Present)\nContinues to be a leading figure in modern urban music with a jazz twist (2016-Present)'),
(7, 'Karsu', '#karsu', 'karsu.jpg', 'karsu-banner.jpg', 'Karsu is a multi-talented singer, pianist, and composer who blends jazz with Turkish musical traditions and classical influences. Her unique style is a fusion of East and West, incorporating rich harmonies, intricate melodies, and deeply emotional storytelling. Known for her dynamic stage presence and virtuosic piano skills, she has performed at prestigious venues such as Carnegie Hall and major jazz festivals. Karsu’s music is both deeply personal and universally resonant, making her a standout artist in the global jazz scene.', 'A singer-pianist blending jazz, Turkish influences, and soul into a unique, heartfelt sound.', '\nFusion of jazz, Turkish music, and classical influences\nVirtuosic piano skills\nEmotive songwriting blending different cultural traditions', '\nGained international recognition for performances at prestigious venues like Carnegie Hall (2017-Present)\nFuses jazz, Turkish music, and classical influences (2015-Present)\nVirtuosic piano skills and emotive songwriting continue to captivate audiences (2016-Present)'),
(8, 'Uncle Sue', '#unclesue', 'uncle-sue.jpg', 'uncle-sue-banner.jpg', 'Uncle Sue is a jazz-funk band known for their energetic and groove-driven sound. Their music is a blend of progressive jazz, rock elements, and explosive brass arrangements that create a thrilling live experience. The band’s innovative approach to jazz-funk has earned them accolades and a loyal following among jazz and fusion enthusiasts. Their ability to seamlessly transition between complex jazz improvisations and infectious funk rhythms makes them a standout act on the European jazz circuit.', 'A jazz-funk band with an energetic and groovy style, bringing fresh rhythms and bold improvisation.', '\nJazz-funk fusion\nBlending progressive jazz with rock and funk elements\nInnovative improvisations and high-energy live performances', '\nGained attention for electrifying jazz-funk performances across Europe (2015-Present)\nBlends progressive jazz with rock and funk elements (2016-Present)\nKnown for innovative improvisations and dynamic live performances (2017-Present)'),
(9, 'Chris Allen', '#chrisallen', 'chris-allen.jpg', 'chris-allen-banner.jpg', 'Chris Allen is a soulful saxophonist whose music embodies the smooth and contemporary side of jazz. With a warm, expressive tone and impeccable phrasing, Allen creates melodies that are both soothing and captivating. He has performed with some of the biggest names in jazz and has been featured as a soloist on numerous projects. His music blends traditional jazz influences with modern production, making his sound accessible to a broad audience while maintaining a deep respect for the jazz tradition.', 'A soulful jazz musician delivering smooth melodies and heartfelt performances.', '\nSoulful, expressive saxophone playing\nContributions to both traditional and contemporary jazz\nVersatility in playing various jazz styles', '\nPerformed with major names in jazz (2015-Present)\nSoulful and expressive saxophone playing featured on numerous albums (2016-Present)\nEarned critical acclaim for contributions to both traditional and contemporary jazz (2017-Present)'),
(10, 'Myles Sanko', '#mylessanko', 'myles-sanko.jpg', 'myles-sanko-banner.jpg', 'Myles Sanko is a British soul-jazz artist known for his rich vocal tone and powerful storytelling. His music blends jazz, soul, and funk elements to create emotionally charged compositions that resonate with listeners. Sanko’s ability to deliver heartfelt performances has made him a favorite at international jazz festivals, and he has shared the stage with jazz greats such as Gregory Porter. His commitment to authentic storytelling through music has solidified his place as one of the most compelling voices in contemporary jazz and soul.', 'A British soul-jazz artist known for his rich vocals and retro-modern sound.', '\nSoul-jazz fusion\nRich vocal tone and emotionally charged performances\nAuthentic storytelling through music', '\nCaptivated audiences worldwide with rich vocal tone and emotionally charged performances (2015-Present)\nPerformed at major jazz festivals (2016-Present)\nShared the stage with jazz legends like Gregory Porter (2017-Present)\nKnown for storytelling through music (2018-Present)'),
(11, 'Ilse Huizinga', '#ilsehuizinga', 'ilse-huizinga.jpg', 'ilse-huizinga-banner.jpg', 'Ilse Huizinga is a Dutch jazz vocalist celebrated for her elegant interpretation of classic jazz standards and her ability to blend contemporary arrangements with timeless vocals. Her voice is known for its warmth and clarity, which she uses to evoke a deep emotional connection with her audience. Huizinga has released multiple albums through Challenge Records, showcasing her versatile vocal style and her unique approach to jazz. A regular performer at top jazz venues, she has earned a reputation for her engaging live performances and impeccable technique. Her music explores the full spectrum of jazz, from ballads to up-tempo tracks, establishing her as one of the most respected voices in Dutch jazz.', 'A Dutch jazz vocalist celebrated for her elegant interpretations of jazz standards and originals.', '\nClassic vocal jazz with contemporary arrangements\nElegant interpretations of jazz standards\nFocus on phrasing and musical expression', '\nRecognized as one of the leading jazz vocalists in the Netherlands (2015-Present)\nKnown for elegant interpretations of jazz standards (2016-Present)\nReleased multiple albums on Challenge Records (2017-Present)\nPerformed at major European jazz festivals (2018-Present)'),
(12, 'Eric Vloeimans', '#ericvloeimans', 'eric-vloeimans.jpg', 'eric-vloeimans-banner.jpg', 'Eric Vloeimans is a world-class trumpet player whose music fuses jazz with classical and world music influences. Known for his technical prowess and lyrical improvisation, Vloeimans has created a distinct sound that bridges the gap between traditional jazz and experimental music. An Edison Award winner, he has composed for film and television, showcasing his versatility and artistic depth. Vloeimans leads his own band, where his trumpet takes center stage, guiding the group through complex harmonies and intricate rhythms. His performances are marked by an emotional intensity, which has earned him international recognition in the jazz world. With his boundary-pushing approach, Eric Vloeimans continues to innovate and inspire musicians across genres.', 'A world-class trumpet player and his band, fusing jazz with cinematic and world music elements.', '\nJazz trumpet with classical and world music influences\nInnovative trumpet playing\nCompositions for both jazz ensembles and film scores', '\nAwarded the Edison Award for contributions to jazz (2016)\nKnown for innovative trumpet playing (2017-Present)\nComposed for film and television (2015-Present)\nCollaborated with top jazz musicians and earned a reputation as one of Europe’s leading trumpet players (2018-Present)'),
(13, 'Gare du Nord', '#garedunord', 'gare-du-nord.jpg', 'gare-du-nord-banner.jpg', 'Gare du Nord is a stylish jazz-lounge band known for mixing smooth jazz, blues, and pop elements into their music. Their signature sound is a blend of jazz and lounge music with a modern twist, appealing to listeners who enjoy sophisticated, laid-back grooves. The band has achieved success with multiple platinum albums and has produced several hits across European radio charts. Their music transports listeners to a world of elegance and relaxation, with catchy melodies and soothing rhythms that make them a favorite among jazz enthusiasts and casual listeners alike.', 'A stylish jazz-lounge band mixing smooth jazz, blues, and electronic influences.', '\nJazz-pop fusion\nSmooth and relaxed sound\nLounge music with jazz influences', '\nAchieved multiple platinum albums (2015-Present)\nHits across European charts (2016-Present)\nKnown for smooth fusion of jazz and lounge music (2017-Present)\nBuilt a loyal fan base through extensive European tours (2018-Present)'),
(14, 'Rilan & The Bombadiers', '#rilanbombadiers', 'rilan-bombadiers.jpg', 'rilan-bombadiers-banner.jpg', 'Rilan & The Bombadiers is a dynamic fusion band blending jazz, soul, and funk into an infectious neo-swing sound. With contemporary production techniques, their music blends elements of traditional jazz with modern sensibilities, creating a fresh and exciting take on the genre. The band has performed on television and at major music festivals, gaining popularity for their energetic live shows and genre-blending sound. Their ability to merge vintage swing with a modern twist has made them a favorite among fans of both jazz and contemporary music.', 'A dynamic fusion band blending jazz, soul, and funk with an energetic stage presence.', '\nNeo-swing with contemporary production\nFusion of jazz, soul, and funk\nHigh-energy performances with modern twists on classic swing', '\nGained recognition for high-energy jazz, soul, and funk performances (2016-Present)\nFeatured on television and major festivals (2017-Present)\nKnown for neo-swing and contemporary production (2018-Present)'),
(15, 'Soul Six', '#soulsix', 'soul-six.jpg', 'soul-six-banner.jpg', 'Soul Six is a soulful vocal harmony group with a jazz-infused sound that features horn-driven arrangements and funk elements. Their music combines the power of vocal harmonies with the groove of jazz and soul, creating a sound that is both energetic and smooth. The band has served as a supporting act for some of the biggest names in the international soul scene, showcasing their talent and versatility. Soul Six’s live performances are known for their tight vocals and infectious rhythms, with the band’s horn section adding to the richness of their sound.', 'A soulful vocal harmony group with a jazz-infused sound and deep grooves.', '\nHorn-driven soul-jazz with funk elements\nEnergetic and infectious grooves\nStrong vocal harmonies and jazz influences', '\nSupported international soul artists (2016-Present)\nGained recognition for horn-driven soul-jazz sound (2017-Present)\nPerformed at major festivals and venues across Europe (2018-Present)\nKnown for infectious grooves and vocal harmonies (2019-Present)'),
(16, 'Han Bennink', '#hanbennink', 'han-bennink.jpg', 'han-bennink-banner.jpg', 'Han Bennink is a legendary Dutch drummer known for his groundbreaking work in free jazz and avant-garde improvisation. A pioneer in the world of experimental jazz, Bennink’s drumming style is characterized by its spontaneous energy, unpredictable rhythms, and unique use of percussion instruments. He is a co-founder of the Instant Composers Pool, a collective that has been at the forefront of experimental jazz in Europe. Over his long career, Han Bennink has collaborated with some of the most innovative musicians in the genre, including Peter Brötzmann and Willem Breuker, pushing the boundaries of jazz with each performance. His contributions to the development of free jazz have earned him widespread acclaim, and he remains an influential figure in the contemporary jazz scene. Known for his tireless creativity, Bennink’s live performances are often an intense, unpredictable experience, where his drumming becomes a vital conversation with the other musicians on stage.', 'A legendary Dutch drummer known for his free jazz improvisations and avant-garde percussion.', '\nFree jazz and avant-garde improvisation\nExperimental drumming techniques\nExploration of non-traditional jazz structures and forms', '\nA legendary drummer known for pioneering contributions to free jazz (2015-Present)\nCo-founder of Instant Composers Pool (2016-Present)\nWorked with jazz icons like Peter Brötzmann and Evan Parker (2017-Present)\nKnown for experimental drumming and avant-garde approach to jazz (2018-Present)'),
(17, 'The Nordanians', '#nordanians', 'nordanians.jpg', 'nordanians-banner.jpg', 'The Nordanians is a trio that blends jazz with Indian and Balkan influences, creating a distinctive Indo-jazz fusion with contemporary elements. Known for their innovative approach to traditional music, The Nordanians combine complex rhythms and melodic lines from Indian classical music with the harmonic structures of jazz and the folk traditions of the Balkans. Their performances are a celebration of world music, drawing from diverse cultural influences while maintaining a strong jazz foundation. They have gained recognition at world music festivals and have collaborated with artists from various cultural backgrounds, expanding their global reach.', 'A trio blending jazz with Indian and Balkan influences, creating a unique, rhythmic sound.', '\nIndo-jazz fusion\nBlending jazz with Indian and Balkan musical traditions\nComplex rhythms and melodic structures', '\nEarned acclaim for fusion of jazz with Indian and Balkan influences (2015-Present)\nPerformed at world music festivals (2016-Present)\nBlended complex rhythms and melodies from diverse traditions (2017-Present)'),
(18, 'Lilith Merlot', '#lilithmerlot', 'lilith-merlot.jpg', 'lilith-merlot-banner.jpg', 'Lilith Merlot is a jazz-soul singer-songwriter known for her warm, expressive voice and emotional delivery. Her music blends neo-soul jazz with R&B elements, creating a sound that is both intimate and powerful. Merlot’s deep connection to her music is reflected in her soulful melodies and poetic lyrics, which have garnered her attention in the jazz and soul music scenes. A winner of several vocal jazz competitions, Lilith Merlot has been featured in jazz festivals and has captivated audiences with her heartfelt performances. Her work continues to resonate with listeners, earning her a growing fan base in the jazz community.', 'A jazz-soul singer-songwriter with a warm, expressive voice and intimate storytelling.', '\nNeo-soul jazz with R&B influences\nSmooth and emotive vocal performances\nBlend of jazz, soul, and contemporary R&B', '\nWon vocal jazz competitions and earned recognition in the neo-soul and jazz scene (2016-Present)\nPerformed at prestigious European festivals (2017-Present)\nContinues to captivate audiences with fusion of jazz, soul, and R&B (2018-Present)'),
(19, 'Ruis Soundsystem', '#ruissoundsystem', 'ruis-soundsystem.jpg', 'ruis-soundsystem-banner.jpg', 'Ruis Soundsystem is an innovative collective known for their experimental fusion of electronic beats and live jazz instrumentation. By combining cutting-edge technology with live performances, Ruis Soundsystem pushes the boundaries of both genres, creating a unique sonic experience. Their music explores the intersection of jazz improvisation with electronic soundscapes, resulting in a bold and immersive listening experience. Ruis Soundsystem has performed at major electronic and jazz festivals, where their genre-defying approach to music has earned them a dedicated following. The collective’s performances are marked by a dynamic blend of live instruments and electronic production, creating a high-energy atmosphere that captivates audiences.', 'An experimental jazz collective combining improvisation with electronic and avant-garde influences.', '\nFusion of jazz and electronic music\nLive improvisation with electronic manipulation\nExperimentation with sound and live performance', '\nPioneered fusion of jazz and electronic music (2016-Present)\nKnown for immersive live performances at major festivals (2017-Present)\nBlended electronic manipulation with live improvisation, gaining recognition in both jazz and electronic scenes (2018-Present)');

-- --------------------------------------------------------

--
-- Table structure for table `JazzEvent`
--

CREATE TABLE `JazzEvent` (
  `EventId` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `TimeSlot` varchar(50) DEFAULT NULL,
  `DurationByMinute` int(11) DEFAULT NULL,
  `TicketsAvailable` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzEvent`
--


INSERT INTO `JazzEvent` (`EventId`, `Description`, `Location`, `StartDateTime`, `TimeSlot`, `DurationByMinute`, `TicketsAvailable`, `Price`) VALUES
(101, 'Gumbo Kings performance at Patronaat', '1', '2023-07-27 18:00:00', 'Evening', 60, 300, 15),
(102, 'Evolve performance at Patronaat', '1', '2023-07-27 19:30:00', 'Evening', 60, 300, 15),
(103, 'Ntjam Rosie performance at Patronaat', '1', '2023-07-27 21:00:00', 'Evening', 60, 300, 15),
(104, 'Wicked Jazz Sounds performance at Patronaat', '2', '2023-07-27 18:00:00', 'Evening', 60, 200, 10),
(105, 'Wouter Hamel performance at Patronaat', '2', '2023-07-27 19:30:00', 'Evening', 60, 200, 10),
(106, 'Jonna Frazer performance at Patronaat', '2', '2023-07-27 21:00:00', 'Evening', 60, 200, 10),
(107, 'Karsu performance at Patronaat', '1', '2023-07-28 18:00:00', 'Evening', 60, 300, 15),
(108, 'Uncle Sue performance at Patronaat', '1', '2023-07-28 19:30:00', 'Evening', 60, 300, 15),
(109, 'Chris Allen performance at Patronaat', '1', '2023-07-28 21:00:00', 'Evening', 60, 300, 15),
(110, 'Myles Sanko performance at Patronaat', '2', '2023-07-28 18:00:00', 'Evening', 60, 200, 10),
(111, 'Ilse Huizinga performance at Patronaat', '2', '2023-07-28 19:30:00', 'Evening', 60, 200, 10),
(112, 'Eric Vloeimans and Hotspot! performance at Patronaat', '2', '2023-07-28 21:00:00', 'Evening', 60, 200, 10),
(113, 'Gare du Nord performance at Patronaat', '1', '2023-07-29 18:00:00', 'Evening', 60, 300, 15),
(114, 'Rilan & The Bombadiers performance at Patronaat', '1', '2023-07-29 19:30:00', 'Evening', 60, 300, 15),
(115, 'Soul Six performance at Patronaat', '1', '2023-07-29 21:00:00', 'Evening', 60, 300, 15),
(116, 'Han Bennink performance at Patronaat', '3', '2023-07-29 18:00:00', 'Evening', 60, 150, 10),
(117, 'The Nordanians performance at Patronaat', '3', '2023-07-29 19:30:00', 'Evening', 60, 150, 10),
(118, 'Lilith Merlot performance at Patronaat', '3', '2023-07-29 21:00:00', 'Evening', 60, 150, 10),
(119, 'Ruis Soundsystem performance at Grote Markt', '4', '2023-07-30 15:00:00', 'Afternoon', 60, 1000, 0),
(120, 'Wicked Jazz Sounds performance at Grote Markt', '4', '2023-07-30 16:00:00', 'Afternoon', 60, 1000, 0),
(121, 'Evolve performance at Grote Markt', '4', '2023-07-30 17:00:00', 'Afternoon', 60, 1000, 0),
(122, 'The Nordanians performance at Grote Markt', '4', '2023-07-30 18:00:00', 'Evening', 60, 1000, 0),
(123, 'Gumbo Kings performance at Grote Markt', '4', '2023-07-30 19:00:00', 'Evening', 60, 1000, 0),
(124, 'Gare du Nord performance at Grote Markt', '4', '2023-07-30 20:00:00', 'Evening', 60, 1000, 0),
(1001, 'Gumbo Kings at Haarlem Jazz', '1', '2023-07-27 19:00:00', 'Evening', 90, 300, 25),
(1002, 'Evolve at Haarlem Jazz', '2', '2023-07-27 21:00:00', 'Evening', 90, 200, 20),
(1003, 'Ntjam Rosie at Haarlem Jazz', '1', '2023-07-28 19:00:00', 'Evening', 90, 300, 25),
(1004, 'Wicked Jazz Sounds at Haarlem Jazz', '2', '2023-07-28 21:00:00', 'Evening', 90, 200, 20),
(1005, 'Wouter Hamel at Haarlem Jazz', '1', '2023-07-29 19:00:00', 'Evening', 90, 300, 25),
(1006, 'Uncle Sue at Haarlem Jazz', '2', '2023-07-29 21:00:00', 'Evening', 90, 200, 20),
(1007, 'Karsu at Haarlem Jazz', '4', '2023-07-30 15:00:00', 'Afternoon', 60, 1000, 0),
(1008, 'Jonna Fraser at Haarlem Jazz', '4', '2023-07-30 17:00:00', 'Evening', 60, 1000, 0);

--
-- Table structure for table `JazzPass`
--

CREATE TABLE `JazzPass` (
  `PassId` int(11) NOT NULL,
  `PassType` varchar(20) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `ShortDescription` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `BasePrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Featured` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedAt` timestamp NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzPass`
--

INSERT INTO `JazzPass` (`PassId`, `PassType`, `DisplayName`, `ShortDescription`, `Description`, `BasePrice`, `Featured`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Free', 'Sunday Performances', 'All performances at Grote Markt on Sunday', 'Free for all visitors. No reservation needed.', 0.00, 0, '2025-03-25 03:25:58', '2025-03-25 03:25:58'),
(2, 'SingleUse', 'Single Performance', 'Access to a single performance', 'Prices vary by venue: Main Hall €15, Second & Third Hall €10, Grote Markt free.', 15.00, 0, '2025-03-25 03:25:58', '2025-03-25 03:25:58'),
(3, 'DayPass', 'Day Pass', 'Access to all venues for one day', 'All-Access pass for this day €35,00. Choose Thursday, Friday, or Saturday.', 35.00, 0, '2025-03-25 03:25:58', '2025-03-25 03:25:58'),
(4, 'WeekendPass', 'Weekend Pass (Thu-Sat)', 'Access to all performances Thursday through Saturday', 'All-Access pass for Thu, Fri, Sat: €80,00.', 80.00, 1, '2025-03-25 03:25:58', '2025-03-25 03:25:58');

-- --------------------------------------------------------

--
-- Table structure for table `JazzPerformance`
--

CREATE TABLE `JazzPerformance` (
  `JazzEventId` int(11) DEFAULT NULL,
  `ArtistId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzPerformance`
--

INSERT INTO `JazzPerformance` (`JazzEventId`, `ArtistId`) VALUES
(101, 1),
(102, 2),
(103, 3),
(104, 4),
(105, 5),
(106, 6),
(107, 7),
(108, 8),
(109, 9),
(110, 10),
(111, 11),
(112, 12),
(113, 13),
(114, 14),
(115, 15),
(116, 16),
(117, 17),
(118, 18),
(119, 19),
(120, 4),
(121, 2),
(122, 17),
(123, 1),
(124, 13);

-- --------------------------------------------------------

--
-- Table structure for table `JazzTrack`
--

CREATE TABLE `JazzTrack` (
  `TrackId` int(11) NOT NULL,
  `ArtistId` int(11) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Credits` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `ReleaseYear` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzTrack`
--

INSERT INTO `JazzTrack` (`TrackId`, `ArtistId`, `Title`, `Credits`, `Description`, `ReleaseYear`) VALUES
(1, 1, 'Bourbon Street Parade', 'Traditional, arranged by Gumbo Kings', 'A jubilant celebration of New Orleans parade traditions with exuberant brass and infectious rhythms', '2020-05-15'),
(2, 1, 'Crescent City Blues', 'Composed by Gumbo Kings', 'A soulful homage to the musical heritage of New Orleans with rich harmonies and expressive solos', '2020-05-15'),
(3, 1, 'Mardi Gras Morning', 'Composed by Gumbo Kings', 'An energetic piece capturing the excitement and color of Carnival season, featuring call-and-response sections', '2020-05-15'),
(4, 2, 'Quantum Leap', 'Composed by Marcus Reynolds', 'An adventurous composition blending acoustic jazz with electronic elements and shifting time signatures', '2021-09-10'),
(5, 2, 'Digital Monk', 'Composed by Marcus Reynolds', 'A tribute to Thelonious Monk reimagined through contemporary production techniques', '2021-09-10'),
(6, 2, 'Neural Networks', 'Composed by Evolve', 'An explorative piece with complex interweaving melodic lines inspired by artificial intelligence concepts', '2021-09-10'),
(7, 3, 'Cameroon Memories', 'Composed by Ntjam Rosie', 'A heartfelt composition blending jazz harmonies with traditional Central African rhythms', '2022-02-18'),
(8, 3, 'Atlantic Bridge', 'Composed by Ntjam Rosie', 'A powerful song exploring cultural connections across continents with soaring vocals', '2022-02-18'),
(9, 3, 'Mother\'s Voice', 'Composed by Ntjam Rosie', 'A tender ballad with lyrics in both English and Bakaka celebrating maternal wisdom', '2022-02-18'),
(10, 4, 'Club Jazz Revolution', 'Composed by Wicked Jazz Sounds Collective', 'A high-energy fusion of jazz improvisation with house music rhythms', '2021-11-05'),
(11, 4, 'Midnight in Amsterdam', 'Composed by Wicked Jazz Sounds Collective', 'A groove-oriented track capturing the city\'s late-night creative energy', '2021-11-05'),
(12, 4, 'Sample This', 'Composed by Wicked Jazz Sounds Collective', 'An innovative piece built around fragments of classic jazz recordings', '2021-11-05'),
(13, 5, 'November Rain', 'Composed by Wouter Hamel', 'A melancholic yet hopeful ballad featuring Hamel\'s signature warm vocals and delicate piano', '2023-03-21'),
(14, 5, 'Paris in Spring', 'Composed by Wouter Hamel', 'A charming song inspired by French chanson with playful lyrics and sophisticated chord changes', '2023-03-21'),
(15, 5, 'Autumn Leaves Revisited', 'Traditional, arranged by Wouter Hamel', 'A fresh interpretation of the jazz standard with unexpected harmonic twists', '2023-03-21');

-- --------------------------------------------------------

--
-- Table structure for table `Lorentz`
--

CREATE TABLE `Lorentz` (
  `LorentzId` int(11) NOT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `EndDateTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `Menu`
--

CREATE TABLE `Menu` (
  `MenuId` int(11) NOT NULL,
  `RestaurantId` int(11) DEFAULT NULL,
  `MenuName` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `MenuItem`
--

CREATE TABLE `MenuItem` (
  `MenuItemId` int(11) NOT NULL,
  `MenuId` int(11) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
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
  `Status` varchar(50) DEFAULT NULL,
  `OrderDate` datetime DEFAULT NULL,
  `PhoneNumber` varchar(20) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Order`
--

INSERT INTO `Order` (`OrderId`, `UserId`, `Amount`, `Status`, `OrderDate`, `PhoneNumber`, `Address`) VALUES
(1, 1, NULL, NULL, '2025-03-25 12:31:18', '0647629759', 'Strada Marului, nr 5'),
(2, 1, NULL, NULL, '2025-03-25 12:32:01', '0647629759', 'Strada Marului, nr 5'),
(3, 1, NULL, NULL, '2025-03-25 12:32:05', '0647629759', 'Strada Marului, nr 5'),
(4, 1, 0, 'Pending', '2025-03-25 12:39:35', '0647629759', 'Strada Marului, nr 5'),
(5, 1, 0, 'Pending', '2025-03-25 12:41:47', '0647629759', 'Strada Marului, nr 5');

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE `Restaurant` (
  `RestaurantId` int(11) NOT NULL,
  `EventId` int(11) DEFAULT NULL,
  `CuisineType` varchar(50) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `About` text DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `ImageGallery` varchar(255) DEFAULT NULL,
  `Image_url` varchar(255) DEFAULT NULL,
  `WorkingHours` varchar(255) DEFAULT NULL,
  `SessionsAvailable` varchar(100) DEFAULT NULL,
  `FirstStart` datetime DEFAULT NULL,
  `Duration` int(11) DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `Seats` int(11) DEFAULT NULL,
  `ReducedPrice` int(11) DEFAULT NULL,
  `Comment` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Restaurant`
--

INSERT INTO `Restaurant` (`RestaurantId`, `EventId`, `CuisineType`, `Description`, `About`, `Address`, `Name`, `ImageGallery`, `Image_url`, `WorkingHours`, `SessionsAvailable`, `FirstStart`, `Duration`, `Rating`, `Seats`, `ReducedPrice`, `Comment`) VALUES
(1, 1, 'Dutch, Fish, European', 'A cozy café serving Dutch, fish, and European dishes.', 'Welcome to Café De Roemer, where tradition meets innovation! Located in the heart of Haarlem, we specialize in authentic Italian dishes crafted with locally sourced ingredients. Whether you\'re here for a romantic dinner, a family gathering, or a casual meal with friends, our warm ambiance and exquisite menu will ensure an unforgettable dining experience.', 'Botermarkt 17, 2011 XL Haarlem', 'Café de Roemer', 'cafe-de-roemer1.jpg,cafe-de-roemer2.jpg,cafe-de-roemer3.jpg', 'cafe-roemer.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '3', '2024-03-09 18:00:00', 2, 4, 35, 18, NULL),
(2, 2, 'French, Fish, European', 'Fine French dining by the river, specializing in seafood.', 'Welcome to Fris, where tradition meets innovation! Located in the heart of Haarlem, we specialize in authentic Italian dishes crafted with locally sourced ingredients. Whether you\'re here for a romantic dinner, a family gathering, or a casual meal with friends, our warm ambiance and exquisite menu will ensure an unforgettable dining experience.', 'Spaarne 96, 2011 CL Haarlem, Nederland', 'Ratatouille', 'ratatouille1.jpg,ratatouille2.jpg,ratatouille3.jpg', 'ratatouille.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '3', '2024-03-09 17:00:00', 2, 4, 52, 23, NULL),
(3, 3, 'Dutch, Fish, European', 'An elegant dining experience offering Dutch and seafood cuisine.', 'Welcome to Restaurant ML, that blends historical elegance with contemporary flair, offering a Michelin-starred menu that impresses with its creativity and taste. Led by Chef Mark Gratama, the restaurant is celebrated for its innovative dishes that expertly combine traditional techniques with modern culinary artistry.', 'Kleine Houtstraat 70, 2011 DR Haarlem, Nederland', 'Restaurant ML', 'restaurant-ml1.jpg,restaurant-ml2.jpg,restaurant-ml3.jpg', 'restaurant-ml.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '2', '2024-03-09 17:00:00', 2, 4, 60, 23, NULL),
(4, 4, 'Dutch, French, European', 'A blend of Dutch and French flavors in a cozy atmosphere.', 'Welcome to Fris! Nestled in the heart of Haarlem, Fris marries contemporary culinary art with the rich flavors of Dutch cuisine. Perfect for a sophisticated night out, a memorable family dinner, or a delightful gathering with friends, our restaurant offers a warm atmosphere and a menu that caters to discerning palates. Join us at Fris for an exceptional dining adventure where every meal is a celebration of modern gastronomy.', 'Twijnderslaan 7, 2012 BG Haarlem, Nederland', 'Restaurant Fris', 'restaurant-fris1.jpg,restaurant-fris2.jpg,restaurant-fris3.jpg', 'restaurant-fris.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '3', '2024-03-09 17:30:00', 2, 4, 45, 23, NULL),
(5, 5, 'Vegan', 'A fully vegan restaurant with innovative plant-based dishes.', 'Welcome to New Vegas, a culinary gem in the bustling heart of Haarlem at Koningstraat 5. Here, we merge vibrant flavors with an artistic flair to bring you a truly unique dining experience. Our kitchen focuses on innovative international cuisine, with each dish crafted to surprise and delight. ', 'Koningstraat 5, 2011 TB Haarlem', 'New Vegas', 'new-vegas1.jpg,new-vegas2.jpg,new-vegas3.jpg', 'new-vegas.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '3', '2024-03-09 17:00:00', 2, 3, 36, 18, NULL),
(6, 6, 'Dutch, European, Modern', 'A modern take on Dutch and European cuisine in a grand setting.', 'Welcome to Grand Café Brinkmann, a cherished landmark nestled in the heart of Haarlem at Grote Markt 13. Established over a century ago, this iconic café blends rich history with contemporary hospitality. Offering a diverse menu that ranges from classic Dutch favorites to modern culinary delights, Grand Café Brinkmann is perfect for any dining occasion. ', 'Grote Markt 13, 2011 RC Haarlem, Nederland', 'Grand Cafe Brinkman', 'grand-cafe-brinkman1.jpg,grand-cafe-brinkman2.jpg,grand-cafe-brinkman3.jpg', 'grand-cafe-brinkman.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '3', '2024-03-09 16:30:00', 2, 3, 100, 18, NULL),
(7, 7, 'Dutch, Fish, European', 'A French-inspired bistro with fresh seafood and Dutch classics.', 'Welcome to Frenchy Bistro Toujours, your slice of Paris nestled in the charming streets of Haarlem at Oude Groenmarkt 10. This cozy bistro offers a romantic and inviting ambiance, perfect for indulging in the finest French cuisine. At Toujours, we pride ourselves on delivering authentic flavors using high-quality ingredients, paired beautifully with our selection of French wines. ', 'Oude Groenmarkt 10-12, 2011 HL Haarlem, Nederland', 'Urban Frenchy Bistro Toujours', 'urban-frenchy1.jpg,urban-frenchy2.jpg,urban-frenchy3.jpg', 'urban-frenchy.jpg', 'Monday - Tuesday: Closed\nWednesday - Saturday: 12:00 - 14:30, 18:30 - 21:30\nSunday: 12:00 - 14:30, 18:30 - 21:00', '3', '2024-03-09 17:30:00', 2, 3, 48, 18, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Ticket`
--

CREATE TABLE `Ticket` (
  `TicketId` int(11) NOT NULL,
  `OrderId` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL,
  `PassType` enum('SingleUse','DayPass','WeekendPass') DEFAULT NULL,
  `IsValid` tinyint(1) DEFAULT NULL,
  `EventId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `TourGuide`
--

CREATE TABLE `TourGuide` (
  `GuideId` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `ProfileImage` varchar(255) DEFAULT NULL,
  `LanguagesSpoken` enum('English','Dutch','Chinese') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `TourGuide`
--

INSERT INTO `TourGuide` (`GuideId`, `FullName`, `ProfileImage`, `LanguagesSpoken`) VALUES
(1, 'Jan-Willem', 'jan-willem.png', 'Dutch'),
(2, 'Lisa', 'lisa.png', 'Dutch'),
(3, 'Frederic', 'frederic.png', 'English'),
(4, 'Lisa', 'lisa-chinese.png', 'Chinese'),
(5, 'Annet', 'annet.png', 'Dutch'),
(6, 'Susan', 'susan.png', 'Chinese'),
(7, 'William', 'william.png', 'English'),
(8, 'Deirdre', 'deirdre.png', 'English'),
(9, 'Kim', 'kim.png', 'Chinese');

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserId` int(11) NOT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `VerifyToken` varchar(100) DEFAULT NULL,
  `VerifyStatus` tinyint(4) DEFAULT 0,
  `ResetTokenExpires` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `FullName`, `Email`, `Password`, `Role`, `VerifyToken`, `VerifyStatus`, `ResetTokenExpires`) VALUES
(1, 'minudenisa29@gmail.com', 'minudenisa29@gmail.com', '$2y$12$jCeTK/mwIeCoFbYa.oLjkuPrwuio8xiOmgrfyKGwZk/KyaFjf4MEm', 'customer', '5dab23b6dc70d349c9d6d898d5eeeada', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Venue`
--

CREATE TABLE `Venue` (
  `VenueId` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `Address` varchar(100) DEFAULT NULL,
  `Capacity` int(11) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueId`, `Name`, `Location`, `Address`, `Capacity`, `Description`) VALUES
(1, 'Patronaat Main Hall', 'Patronaat', 'Zijlsingel 2, 2013 DN Haarlem', 300, 'The main performance hall of Patronaat'),
(2, 'Patronaat Second Hall', 'Patronaat', 'Zijlsingel 2, 2013 DN Haarlem', 200, 'The second performance hall of Patronaat'),
(3, 'Patronaat Third Hall', 'Patronaat', 'Zijlsingel 2, 2013 DN Haarlem', 150, 'The intimate third performance hall of Patronaat'),
(4, 'Grote Markt', 'Grote Markt', 'Grote Markt, Haarlem', 1000, 'The central market square of Haarlem');

--


/*
this works after filling the danceEvent table
INSERT INTO DancePerformance (DanceEventId, DanceArtistId) VALUES
(1, 5),
(1, 6),
(2, 4),
(3, 2),
(4, 3),
(5, 1),
(6, 6),
(6, 4),
(6, 5),
(7, 3),
(8, 2),
(9, 1),
(10, 1),
(10, 3),
(10, 2),
(11, 4),
(12, 6),
(13, 5); */


-- Indexes for dumped tables
--

--
-- Indexes for table `Appearances`
--
ALTER TABLE `Appearances`
  ADD KEY `EventId` (`EventId`),
  ADD KEY `ArtistId` (`ArtistId`);

--
-- Indexes for table `Content`
--
ALTER TABLE `Content`
  ADD PRIMARY KEY (`ContentId`);

--
-- Indexes for table `DanceArtist`
--
ALTER TABLE `DanceArtist`
  ADD PRIMARY KEY (`ArtistId`);

--
-- Indexes for table `DanceEvent`
--
ALTER TABLE `DanceEvent`
  ADD PRIMARY KEY (`DanceEventId`);

--
-- Indexes for table `DancePerformance`
--
ALTER TABLE `DancePerformance`
  ADD PRIMARY KEY (`DanceEventId`,`DanceArtistId`),
  ADD KEY `DanceArtistId` (`DanceArtistId`);

--
-- Indexes for table `DanceSong`
--
ALTER TABLE `DanceSong`
  ADD PRIMARY KEY (`SongId`),
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
-- Indexes for table `HistoryTourBooking`
--
ALTER TABLE `HistoryTourBooking`
  ADD PRIMARY KEY (`BookingId`),
  ADD KEY `ScheduleId` (`ScheduleId`);

--
-- Indexes for table `HistoryTourSchedule`
--
ALTER TABLE `HistoryTourSchedule`
  ADD PRIMARY KEY (`EventId`),
  ADD KEY `GuideId` (`GuideId`);

--
-- Indexes for table `JazzEvent`
--
ALTER TABLE `JazzEvent`
  ADD PRIMARY KEY (`EventId`);

--
-- Indexes for table `JazzPass`
--
ALTER TABLE `JazzPass`
  ADD PRIMARY KEY (`PassId`);

--
-- Indexes for table `JazzPerformance`
--
ALTER TABLE `JazzPerformance`
  ADD KEY `JazzEventId` (`JazzEventId`),
  ADD KEY `ArtistId` (`ArtistId`);

--
-- Indexes for table `JazzTrack`
--
ALTER TABLE `JazzTrack`
  ADD PRIMARY KEY (`TrackId`),
  ADD KEY `ArtistId` (`ArtistId`);

--
-- Indexes for table `Lorentz`
--
ALTER TABLE `Lorentz`
  ADD PRIMARY KEY (`LorentzId`);

--
-- Indexes for table `Menu`
--
ALTER TABLE `Menu`
  ADD PRIMARY KEY (`MenuId`),
  ADD KEY `RestaurantId` (`RestaurantId`);

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
  ADD PRIMARY KEY (`RestaurantId`);

--
-- Indexes for table `Ticket`
--
ALTER TABLE `Ticket`
  ADD PRIMARY KEY (`TicketId`),
  ADD KEY `OrderId` (`OrderId`),
  ADD KEY `EventId` (`EventId`);

--
-- Indexes for table `TourGuide`
--
ALTER TABLE `TourGuide`
  ADD PRIMARY KEY (`GuideId`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserId`);

--
-- Indexes for table `Venue`
--
ALTER TABLE `Venue`
  ADD PRIMARY KEY (`VenueId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `DanceArtist`
--
ALTER TABLE `DanceArtist`
  MODIFY `ArtistId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `DanceEvent`
--
ALTER TABLE `DanceEvent`
  MODIFY `DanceEventId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `DanceSong`
--
ALTER TABLE `DanceSong`
  MODIFY `SongId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `HistoryTourBooking`
--
ALTER TABLE `HistoryTourBooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JazzPass`
--
ALTER TABLE `JazzPass`
  MODIFY `PassId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Order`
--
ALTER TABLE `Order`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Ticket`
--
ALTER TABLE `Ticket`
  MODIFY `TicketId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Appearances`
--
ALTER TABLE `Appearances`
  ADD CONSTRAINT `Appearances_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`),
  ADD CONSTRAINT `Appearances_ibfk_2` FOREIGN KEY (`ArtistId`) REFERENCES `DanceArtist` (`ArtistId`);

--
-- Constraints for table `DancePerformance`
--
ALTER TABLE `DancePerformance`
  ADD CONSTRAINT `DancePerformance_ibfk_1` FOREIGN KEY (`DanceEventId`) REFERENCES `DanceEvent` (`DanceEventId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `DancePerformance_ibfk_2` FOREIGN KEY (`DanceArtistId`) REFERENCES `DanceArtist` (`ArtistId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `DanceSong`
--
ALTER TABLE `DanceSong`
  ADD CONSTRAINT `DanceSong_ibfk_1` FOREIGN KEY (`ArtistId`) REFERENCES `DanceArtist` (`ArtistId`);

--
-- Constraints for table `HistoryTourBooking`
--
ALTER TABLE `HistoryTourBooking`
  ADD CONSTRAINT `HistoryTourBooking_ibfk_1` FOREIGN KEY (`ScheduleId`) REFERENCES `HistoryTourSchedule` (`EventId`);

--
-- Constraints for table `HistoryTourSchedule`
--
ALTER TABLE `HistoryTourSchedule`
  ADD CONSTRAINT `HistoryTourSchedule_ibfk_1` FOREIGN KEY (`GuideId`) REFERENCES `TourGuide` (`GuideId`);

--
-- Constraints for table `JazzEvent`
--
ALTER TABLE `JazzEvent`
  ADD CONSTRAINT `JazzEvent_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

--
-- Constraints for table `Menu`
--
ALTER TABLE `Menu`
  ADD CONSTRAINT `Menu_ibfk_1` FOREIGN KEY (`RestaurantId`) REFERENCES `Restaurant` (`RestaurantId`);

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
-- Constraints for table `Ticket`
--
ALTER TABLE `Ticket`
  ADD CONSTRAINT `Ticket_ibfk_1` FOREIGN KEY (`OrderId`) REFERENCES `Order` (`OrderId`),
  ADD CONSTRAINT `Ticket_ibfk_2` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
=======
  OrderId INT PRIMARY KEY,
  UserId INT,
  Amount INT,
  Status VARCHAR(50),
  OrderDate DATETIME,
  PhoneNumber VARCHAR(20),
  Address VARCHAR(255),
  FOREIGN KEY (UserId) REFERENCES Users(UserId)
);

-- Creating the Event table
CREATE TABLE Event (
  EventId INT PRIMARY KEY,
  Description VARCHAR(255),
  Location VARCHAR(100),
  StartDateTime DATETIME,
  TimeSlot VARCHAR(50),
  DurationByMinute INT,
  TicketsAvailable INT,
  Price INT
);

CREATE TABLE Ticket (
  TicketId INT PRIMARY KEY,
  OrderId INT,
  Price INT,
  PassType ENUM('SingleUse', 'DayPass', 'WeekendPass'),
  IsValid TINYINT(1),
  EventId INT,
  FOREIGN KEY (OrderId) REFERENCES `Order`(OrderId),
  FOREIGN KEY (EventId) REFERENCES Event(EventId)
);

-- Creating the DanceEvent table
CREATE TABLE DanceEvent (
  EventId INT PRIMARY KEY,
  DanceEventId INT,
  Description VARCHAR(100),
  Location VARCHAR(100),
  StartDateTime DATETIME,
  TimeSlot VARCHAR(100),
  DurationByMinute INT,
  TicketsAvailable INT,
  Price INT,
  FOREIGN KEY (EventId) REFERENCES Event(EventId)
);

-- Creating the JazzEvent table
CREATE TABLE JazzEvent (
  EventId INT PRIMARY KEY,
  JazzEventId INT,
  Duration DATETIME,
  StartDateTime DATETIME,
  TicketsAvailable INT,
  Price INT,
  StartTime TIME,
  EndTime TIME,
  SeatsTotal INT,
  FOREIGN KEY (EventId) REFERENCES Event(EventId)
);

-- Creating the DanceArtist table
CREATE TABLE DanceArtist (
  ArtistId INT PRIMARY KEY,
  Name VARCHAR(100),
  Title VARCHAR(100),
  Genre VARCHAR(100),
  ImageName VARCHAR(100),
  Description VARCHAR(255)
);

-- Creating the JazzArtist table
CREATE TABLE JazzArtist (
  ArtistId INT PRIMARY KEY,
  Name VARCHAR(100),
  Hashtag VARCHAR(100),
  ProfileImageName VARCHAR(100),
  BannerImageName VARCHAR(100),
  Description VARCHAR(255)
);

-- Creating the JazzPerformance table
CREATE TABLE JazzPerformance (
  JazzEventId INT,
  ArtistId INT,
  FOREIGN KEY (JazzEventId) REFERENCES JazzEvent(EventId),
  FOREIGN KEY (ArtistId) REFERENCES JazzArtist(ArtistId)
);

-- Creating the DanceSong table
CREATE TABLE DanceSong (
  SongId INT PRIMARY KEY,
  ArtistId INT,
  Title VARCHAR(100),
  Credits VARCHAR(255),
  Description VARCHAR(255),
  ImageName VARCHAR(100),
  FOREIGN KEY (ArtistId) REFERENCES DanceArtist(ArtistId)
);

-- Creating the JazzTrack table
CREATE TABLE JazzTrack (
  TrackId INT PRIMARY KEY,
  ArtistId INT,
  Title VARCHAR(100),
  Credits VARCHAR(100),
  Description VARCHAR(255),
  ReleaseYear DATE,
  FOREIGN KEY (ArtistId) REFERENCES JazzArtist(ArtistId)
);

-- Creating the Appearances table
CREATE TABLE Appearances (
  EventId INT,
  ArtistId INT,
  FOREIGN KEY (EventId) REFERENCES Event(EventId),
  FOREIGN KEY (ArtistId) REFERENCES DanceArtist(ArtistId)
);

-- Creating the Venue table
CREATE TABLE Venue (
  VenueId INT PRIMARY KEY,
  Name VARCHAR(100),
  Location VARCHAR(100),
  Address VARCHAR(100),
  Capacity INT,
  Description VARCHAR(255)
);

-- Creating the TourGuide table
CREATE TABLE TourGuide (
  GuideId INT PRIMARY KEY,
  FullName VARCHAR(100),
  ProfileImage VARCHAR(255),
  LanguagesSpoken ENUM('English', 'Dutch', 'Chinese')
);

-- Creating the HistoryTourSchedule table
CREATE TABLE HistoryTourSchedule (
  EventId INT PRIMARY KEY,
  ScheduleId INT,
  TourDate DATE,
  TourTime TIME,
  Language ENUM('English', 'Dutch', 'Chinese'),
  GuideId INT,
  TicketsAvailable INT,
  TicketPrice DECIMAL,
  FamilyTicketPrice DECIMAL,
  FOREIGN KEY (GuideId) REFERENCES TourGuide(GuideId)
);

-- Creating the HistoryTourBooking table
CREATE TABLE HistoryTourBooking (
  BookingId INT AUTO_INCREMENT PRIMARY KEY,
  ScheduleId INT,
  Language ENUM('English', 'Dutch', 'Chinese'),
  TicketType ENUM('Regular', 'Participant', 'Family Package Deal'),
  Seats INT,
  Price DECIMAL,
  BookingTime DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (ScheduleId) REFERENCES HistoryTourSchedule(EventId)
);
