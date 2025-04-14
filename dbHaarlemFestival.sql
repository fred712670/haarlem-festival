-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Apr 14, 2025 at 12:08 PM
-- Server version: 11.5.2-MariaDB-ubu2404
-- PHP Version: 8.2.25

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
(3, 'dance', 'aboutUs', 'At Haarlem Dance, we showcase top-tier dance, house, techno, and trance acts in iconic venues in and around the city of Haarlem. Six world-class DJs will thrill audiences with epic Back2Back sessions on big stages and intimate experimental club sets. So don’t miss out — hop in, join the vibe, and dance the night away.'),
(4, 'jazz', 'hero_title', 'HAARLEM-JAZZ FESTIVAL 2025'),
(5, 'jazz', 'hero_dates', 'From THURSDAY 24 JULY Till SUNDAY 27 JULY'),
(6, 'jazz', 'about', 'Haarlem Jazz brings world-class jazz performances to the heart of Haarlem from July 24-27, 2025. Featuring both established artists and emerging talents, the festival transforms Het Patronaat and Grote Markt into vibrant venues where jazz comes alive.'),
(7, 'jazz', 'ticket_button', 'Get Your Tickets Now');

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
(1, 'Hardwell', 'Dance & House', 'HardwellProfile.png', 'HardwellDetail.png', 'Hardwell, born Robbert van de Corput on January 7, 1988, in Breda, Netherlands, is a globally acclaimed DJ and electronic music producer. Known for his high-energy big room house sound, he topped DJ Mag’s Top 100 DJs list twice and has headlined the world’s biggest festivals.'),
(2, 'Armin van Buuren', 'Trance & Techno', 'BuurenProfile.png', 'BuurenDetail.png', 'Armin van Buuren, born on December 25, 1976, in Leiden, Netherlands, is one of the most iconic trance DJs and producers in the world. Host of the influential radio show *A State of Trance*, he has shaped the genre with his uplifting productions and legendary live performances.'),
(3, 'Martin Garrix', 'Dance & Electronic', 'GarrixProfile.png', 'GarrixDetail.png', 'Martin Garrix, born Martijn Garritsen on May 14, 1996, in Amstelveen, Netherlands, is a multi-platinum DJ and producer who rose to fame with his breakout hit “Animals.” Blending progressive house, pop, and future bass, he has become a dominant force in global EDM culture.'),
(4, 'Tiësto', 'Trance, Techno, Minimal, House & Electronic', 'TiestoProfile.png', 'TiestoDetail.png', 'Tiësto, born Tijs Michiel Verwest on January 17, 1969, in Breda, Netherlands, is a Grammy-winning DJ and one of the most influential figures in the global electronic dance music scene. Rising to prominence with his trance anthems in the early 2000s, Tiësto later evolved his style to include house, electro, and pop influences, cementing his versatility. He was the first DJ to perform at the Olympic Games and continues to headline major festivals worldwide, inspiring generations of producers and fans alike.'),
(5, 'Nicky Romero', 'Electrohouse & Progressive House', 'RomeroProfile.png', 'RomeroDetail.png', 'Nicky Romero, born Nick Rotteveel on January 6, 1989, in Amerongen, Netherlands, is a prominent DJ, producer, and founder of Protocol Recordings. Known for tracks like “Toulouse” and collaborations with Avicii and Calvin Harris, he has left a major mark on progressive and electro house.'),
(6, 'Afrojack', 'House', 'AfrojackProfile.png', 'AfrojackDetail.png', 'Afrojack, born Nick van de Wall on September 9, 1987, in Spijkenisse, Netherlands, is a world-renowned DJ, producer, and music entrepreneur. He rose to fame in the early 2010s with his unique electro-house sound and has become one of the most influential figures in electronic dance music.');

-- --------------------------------------------------------

--
-- Table structure for table `DanceEvent`
--

CREATE TABLE `DanceEvent` (
  `DanceEventId` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `Location` varchar(100) DEFAULT NULL,
  `StartDateTime` datetime DEFAULT NULL,
  `TimeSlot` varchar(100) DEFAULT NULL,
  `DurationByMinute` int(11) DEFAULT NULL,
  `TicketsAvailable` int(11) DEFAULT NULL,
  `Price` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `DanceEvent`
--

INSERT INTO `DanceEvent` (`DanceEventId`, `EventId`, `Description`, `Location`, `StartDateTime`, `TimeSlot`, `DurationByMinute`, `TicketsAvailable`, `Price`) VALUES
(1, 8, 'Nicky Romero, Afrojack', 'Lichtfabriek', '2025-07-25 20:00:00', '20:00 - 02:00', 360, 1500, 75),
(2, 9, 'Tiësto', 'Slachthuis', '2025-07-25 22:00:00', '22:00 - 23:30', 90, 200, 60),
(3, 10, 'Armin van Buuren', 'XO the Club', '2025-07-25 22:00:00', '22:00 - 23:30', 90, 300, 60),
(4, 11, 'Martin Garrix', 'Puncher Comedy Club', '2025-07-25 22:00:00', '22:00 - 23:30', 90, 200, 60),
(5, 12, 'Hardwell', 'Jopenkerk', '2025-07-25 22:00:00', '22:00 - 23:30', 90, 200, 60),
(6, 13, 'Afrojack, Tiësto, Nicky Romero', 'Caprera Openluchttheater', '2025-07-26 14:00:00', '14:00 - 23:00', 540, 2000, 110),
(7, 14, 'Martin Garrix', 'Slachthuis', '2025-07-26 18:00:00', '18:00 - 19:30', 90, 300, 60),
(8, 15, 'Armin van Buuren', 'Jopenkerk', '2025-07-26 19:00:00', '19:00 - 23:00', 240, 1500, 60),
(9, 16, 'Hardwell', 'XO the Club', '2025-07-26 21:00:00', '21:00 - 22:30', 90, 200, 90),
(10, 17, 'Hardwell, Martin Garrix, Armin van Buuren', 'Caprera Openluchttheater', '2025-07-27 14:00:00', '14:00 - 23:00', 540, 2000, 110),
(11, 18, 'Tiësto', 'Lichtfabriek', '2025-07-27 21:00:00', '21:00 - 22:30', 90, 300, 75),
(12, 19, 'Afrojack', 'Jopenkerk', '2025-07-27 22:00:00', '22:00 - 23:30', 90, 1500, 60),
(13, 20, 'Nicky Romero', 'Slachthuis', '2025-07-27 23:00:00', '23:00 - 00:30', 90, 200, 60);

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

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `EventId` int(11) NOT NULL,
  `EventType` enum('DanceEvent','JazzEvent','Restaurant','HistoryTour') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Event`
--

INSERT INTO `Event` (`EventId`, `EventType`) VALUES
(1, 'Restaurant'),
(2, 'Restaurant'),
(3, 'Restaurant'),
(4, 'Restaurant'),
(5, 'Restaurant'),
(6, 'Restaurant'),
(7, 'Restaurant'),
(8, 'DanceEvent'),
(9, 'DanceEvent'),
(10, 'DanceEvent'),
(11, 'DanceEvent'),
(12, 'DanceEvent'),
(13, 'DanceEvent'),
(14, 'DanceEvent'),
(15, 'DanceEvent'),
(16, 'DanceEvent'),
(17, 'DanceEvent'),
(18, 'DanceEvent'),
(19, 'DanceEvent'),
(20, 'DanceEvent'),
(21, 'JazzEvent'),
(22, 'JazzEvent'),
(23, 'JazzEvent'),
(24, 'JazzEvent'),
(25, 'JazzEvent'),
(26, 'JazzEvent'),
(27, 'JazzEvent'),
(28, 'JazzEvent'),
(29, 'JazzEvent'),
(30, 'JazzEvent'),
(31, 'JazzEvent'),
(32, 'JazzEvent'),
(33, 'JazzEvent'),
(34, 'JazzEvent'),
(35, 'JazzEvent'),
(36, 'JazzEvent'),
(37, 'JazzEvent'),
(38, 'JazzEvent'),
(39, 'JazzEvent'),
(40, 'JazzEvent'),
(41, 'JazzEvent'),
(42, 'JazzEvent'),
(43, 'JazzEvent'),
(44, 'JazzEvent'),
(45, 'JazzEvent'),
(46, 'JazzEvent'),
(47, 'JazzEvent'),
(48, 'JazzEvent'),
(49, 'JazzEvent'),
(50, 'JazzEvent'),
(51, 'JazzEvent'),
(52, 'JazzEvent'),
(53, 'HistoryTour'),
(54, 'HistoryTour'),
(55, 'HistoryTour'),
(56, 'HistoryTour'),
(57, 'HistoryTour'),
(58, 'HistoryTour'),
(59, 'HistoryTour'),
(60, 'HistoryTour'),
(61, 'HistoryTour');

-- --------------------------------------------------------

--
-- Table structure for table `HistoryTour`
--

CREATE TABLE `HistoryTour` (
  `HistoryTourId` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
  `LocationId` int(11) NOT NULL,
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

INSERT INTO `HistoryTour` (`HistoryTourId`, `EventId`, `LocationId`, `LocationName`, `Description`, `WhyVisit`, `Address`, `ImageGenera`, `ImageGallery`) VALUES
(1, 53, 1, 'Church of St. Bavo', 'The Church of St. Bavo, an iconic Gothic masterpiece in Haarlem, dates back to the 14th century. Known for its towering spire and stunning architecture, it houses the world-famous Müller organ, once played by Mozart himself. A true symbol of Haarlem\'s rich history and grandeur.', 'Experience the magnificent Müller Organ, played by Mozart himself in 1766 and considered one of the world\'s most renowned instruments.||Marvel at the stunning Gothic architecture with its soaring arches, majestic spire, and vibrant stained-glass windows that have inspired visitors for centuries.||Immerse yourself in the rich history of this symbol of Dutch religious and cultural heritage that has hosted countless important events and remains the spiritual heart of Haarlem.', 'Grote Markt, Haarlem', 'st-bavo.png', 'st-bavo5.png,st-bavo1.png,st-bavo2.png,st-bavo3.png,st-bavo4.png'),
(2, 54, 2, 'Grote Markt', 'The Grote Markt, Haarlem\'s historic main square, is the heart of the city. Surrounded by landmarks like the Town Hall and the Church of St. Bavo, it serves as a vibrant gathering place for markets, events, and cultural celebrations.', 'Experience the vibrant heartbeat of Haarlem at this historic square that has been the city\'s central gathering place since medieval times.||Enjoy the bustling atmosphere with charming cafés, restaurants, and seasonal markets in a picturesque setting surrounded by stunning historic buildings.||Capture breathtaking photos of the iconic St. Bavo Church and Renaissance-style Town Hall that define Haarlem\'s skyline and showcase its Golden Age prosperity.', 'Grote Markt, Haarlem', 'grote-markt.png', 'grote-markt1.png,grote-markt2.png,grote-markt.png,grote-markt3.png,grote-markt4.png'),
(3, 55, 3, 'De Hallen', 'De Hallen Haarlem, a striking cultural landmark, is home to the Frans Hals Museum\'s contemporary art collection. Located in a historic building on the Grote Markt, it offers a blend of modern creativity and Haarlem\'s rich artistic heritage.', 'Discover contemporary art exhibitions housed in a beautifully preserved historic building with a fascinating architectural contrast between old and new.||Experience the evolution of Dutch and international art through carefully curated collections and rotating exhibitions that showcase emerging and established artists.||Take a break from traditional sightseeing to immerse yourself in modern creativity while still appreciating Haarlem\'s rich cultural heritage in this thoughtfully renovated space.', 'Grote Markt 16, Haarlem', 'de-hallen.png', 'de-hallen1.png,de-hallen2.png,de-hallen.png,de-hallen3.png,de-hallen4.png'),
(4, 56, 4, 'Proveniershof', 'Proveniershof, a serene 17th-century courtyard in Haarlem, is nestled among picturesque historic houses. Once home to retired tradesmen, it now offers a peaceful escape, showcasing the city\'s rich architectural and cultural heritage.', 'Step back in time as you enter this peaceful 17th-century courtyard hidden away from the bustling city streets, offering a serene escape from urban life.||Experience the unique Dutch \"hofje\" tradition of communal living spaces built for elderly residents through charitable foundations, a social system that predates modern welfare.||Admire the perfectly preserved historic houses, lush garden, and authentic architectural details that offer a glimpse into Haarlem\'s social history and community values.', 'Grote Houtstraat 140, Haarlem', 'proveniershof.png', 'proveniershof1.png,proveniershof2.png,proveniershof.png,proveniershof3.png,proveniershof4.png'),
(5, 57, 5, 'Jopenkerk', 'Jopenkerk Haarlem, a former church turned brewery, blends history with modern craft beer culture. This unique venue offers visitors a chance to enjoy locally brewed Jopen beers while surrounded by stunning stained-glass windows and Gothic architecture, making it a must-visit landmark.', 'Sample award-winning craft beers made according to historic Haarlem recipes in the unique setting of a repurposed historic church that blends sacred and secular worlds.||Marvel at the stunning transformation of this religious space into a brewery while still preserving its architectural grandeur, soaring ceiling, and beautiful stained-glass windows.||Enjoy the perfect blend of historical appreciation and modern hospitality with excellent food pairings in this truly unique landmark that epitomizes creative adaptive reuse.', 'Gedempte Voldersgracht 2, Haarlem', 'jopenkerk.png', 'jopenkerk1.png,jopenkerk2.png,jopenkerk.png,jopenkerk3.png,jopenkerk4.png'),
(6, 58, 6, 'Waalse Kerk Haarlem', 'The Waalse Kerk, a charming 14th-century chapel in Haarlem, is renowned for its intimate atmosphere and beautiful acoustics. Once a refuge for French Huguenots, it now serves as a cultural venue for concerts and events.', 'Experience the intimate atmosphere of this historic chapel that once provided refuge for French Huguenots fleeing religious persecution, a testament to Haarlem\'s tradition of tolerance.||Listen to the incredible acoustics that make this venue a favorite for chamber music concerts and cultural performances throughout the year.||Admire the elegant simplicity of this smaller church that offers a more peaceful alternative to the grandeur of St. Bavo, with its own unique charm and historical significance.', 'Begijnhof 30, Haarlem', 'waalse-kerk.png', 'waalse-kerk1.png,waalse-kerk2.png,waalse-kerk.png,waalse-kerk3.png,waalse-kerk4.png'),
(7, 59, 7, 'Molen de Adriaan', 'Molen de Adriaan, a historic windmill on the banks of the Spaarne River, offers panoramic views of Haarlem. Originally built in 1779, this iconic landmark showcases the Netherlands\' rich milling heritage and provides a fascinating glimpse into traditional Dutch craftsmanship.', 'Climb to the top of this historic windmill for panoramic views of Haarlem and the Spaarne River that you can\'t get anywhere else in the city.||Learn about traditional Dutch milling craftsmanship through interactive exhibits and demonstrations of this iconic symbol of Dutch heritage and industrial history.||Photograph this perfectly reconstructed 18th-century landmark that has become one of Haarlem\'s most recognizable symbols and a testament to Dutch determination and engineering.', 'Papentorenvest 1A, Haarlem', 'molen-adriaan1.png', 'molen-adriaan3.png,molen-adriaan2.png,molen-adriaan4.png,molen-adriaan5.png,molen-adriaan6.png'),
(8, 60, 8, 'Amsterdamse Poort', 'The Amsterdamse Poort, Haarlem\'s last remaining city gate, is a stunning medieval structure dating back to the 14th century. Once a key entry point to the city, it now stands as a testament to Haarlem\'s rich history and architectural grandeur.', 'Walk through Haarlem\'s last remaining medieval city gate that has stood guard since the 14th century as a testament to the city\'s defensive past and historical importance.||Imagine the countless travelers, merchants, and visitors who passed beneath these arches over more than 600 years of history, connecting Haarlem to Amsterdam and beyond.||Capture stunning photos of this well-preserved Gothic structure that creates a dramatic contrast with the modern city that has grown around it while maintaining its historic integrity.', 'Amsterdamse Poort, Haarlem', 'amsterdamse-poort2.png', 'amsterdamse-poort1.png,amsterdamse-poort2.png,amsterdamse-poort3.png'),
(9, 61, 9, 'Hof van Bakenes', 'Hof van Bakenes, Haarlem\'s oldest hofje, is a tranquil courtyard dating back to the 14th century. Surrounded by charming historic houses, it offers a peaceful retreat and a glimpse into the city\'s tradition of community living.', 'Discover Haarlem\'s oldest hofje (courtyard) dating back to 1395, offering a glimpse into early Dutch charitable housing traditions that shaped urban development.||Experience the serene atmosphere of this hidden garden courtyard that feels worlds away from the busy streets just steps away, providing a peaceful retreat.||Admire the charming historic houses surrounding the courtyard that have sheltered residents for over six centuries, exemplifying the Dutch commitment to community and social welfare.', 'Bakenessergracht 67, Haarlem', 'hof-van-bakenes.png', 'molen-adriaan3.png,molen-adriaan2.png,molen-adriaan4.png,molen-adriaan5.png,molen-adriaan6.png');

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

INSERT INTO `JazzArtist` (`ArtistId`, `Name`, `ProfileImageName`, `artistGallery`, `Description`, `short_description`, `musical_style`, `career_highlights`) VALUES
(1, 'Gumbo Kings', 'gumbo-kings.jpg', 'gumbo-kings-banner.jpg', 'Gumbo Kings is a high-energy jazz band known for their infectious New Orleans groove mixed with modern soul and funk influences. Their performances are a thrilling experience, featuring tight horn arrangements, lively improvisations, and an undeniable sense of rhythm that gets audiences dancing. Drawing inspiration from classic brass bands while infusing contemporary elements, they have carved out a unique space in the jazz world. The band has toured extensively across Europe, bringing their energetic sound to festival stages and jazz clubs alike. With a commitment to keeping the spirit of New Orleans jazz alive while pushing its boundaries, Gumbo Kings continue to gain recognition for their electrifying live shows and innovative approach to the genre.', 'A high-energy jazz band blending New Orleans groove with modern soul and funk influences.', 'New Orleans-inspired jazz\nEnergetic and dynamic live performances\nTraditional jazz with a modern twist', ' Performed at numerous jazz festivals across Europe (2010-Present)\nKnown for their electrifying New Orleans-inspired sound (2012-Present)\nAcclaimed for innovative live performances (2013-Present)\nPlayed in venues ranging from intimate jazz clubs to major international festivals (2014-Present)'),
(2, 'Evolve', 'evolve.jpg', 'evolve-banner.jpg', 'Evolve is a forward-thinking jazz collective that seamlessly integrates modern electronic elements with the improvisational spirit of jazz. Their sound is characterized by lush synthesizers, intricate rhythms, and dynamic interplay between acoustic and digital instrumentation. Constantly pushing the boundaries of jazz fusion, they experiment with textures and soundscapes that create an immersive listening experience. Their music appeals to both jazz purists and fans of progressive electronic music, making them a staple in contemporary jazz festivals. With each performance, Evolve crafts a sonic journey that challenges and excites, cementing their reputation as one of the most innovative acts in modern jazz.', 'A dynamic jazz collective pushing the boundaries of contemporary jazz with fusion and electronic elements.', '\nFusion of electronic and acoustic elements\nExperimentation with jazz and electronic music\nCutting-edge approach to jazz with a contemporary twist', '\nFeatured at renowned jazz festivals (2014-Present)\nKnown for experimental fusion of electronic and acoustic elements (2016-Present)\nCollaborated with cutting-edge artists from various genres (2015-Present)\nGained recognition as one of the most innovative jazz collectives of their generation (2017-Present)'),
(3, 'Ntjam Rosie', 'ntjam-rosie.jpg', 'ntjam-rosie-banner.jpg', 'Ntjam Rosie is a Dutch-Cameroonian singer and songwriter known for her rich blend of jazz, soul, and African influences. Her expressive voice and deeply personal songwriting make her music both captivating and emotionally resonant. Ntjam Rosie’s sound fuses traditional jazz harmonies with rhythmic Afrobeat elements, creating a unique and vibrant musical identity. Over the years, she has released several critically acclaimed albums and graced the stages of major jazz festivals across Europe. Her artistry transcends genres, making her one of the most exciting and versatile voices in the contemporary jazz and soul scene.', 'A soulful jazz vocalist mixing jazz, R&B, and African influences into a rich, warm sound.', '\nBlend of jazz, soul, and African rhythms\nEmotionally resonant music with depth and authenticity\nFocus on storytelling and connection with listeners', '\nReceived critical acclaim for emotionally resonant music (2015-Present)\nPerformed at major jazz festivals across Europe (2016-Present)\nKnown for blending jazz, soul, and African rhythms (2017-Present)\nMusic continues to inspire listeners with depth and authenticity (2018-Present)'),
(4, 'Wicked Jazz Sounds', 'wicked-jazz-sounds.jpg', 'wicked-jazz-sounds-banner.jpg', 'Wicked Jazz Sounds is a genre-defying collective that fuses jazz with funk, soul, hip-hop, and electronic beats. Their dynamic live performances blend live instrumentation with DJ sets, creating a seamless mix of classic jazz grooves and dancefloor energy. They have gained a strong following through their residency at Amsterdam’s leading jazz venues and frequent festival appearances. By bridging the gap between jazz and modern dance music, Wicked Jazz Sounds offers an exciting and fresh take on live performance, appealing to both jazz aficionados and club-goers alike.', 'A genre-blending band and DJ collective fusing jazz, funk, and electronic beats for vibrant live performances.', '\nFusion of jazz, funk, soul, and electronic music\nBlending live jazz instrumentation with DJ sets\nBoundary-pushing and genre-defying sound', '\nA prominent fixture in the European jazz scene (2015-Present)\nPioneering fusion of jazz, funk, soul, and electronic music (2016-Present)\nUnique performances blending live jazz instrumentation with DJ sets (2017-Present)\nBuilt a loyal following through boundary-pushing music and dynamic performances (2018-Present)'),
(5, 'Wouter Hamel', 'wouter-hamel.jpg', 'wouter-hamel-banner.jpg', 'Wouter Hamel is a Dutch singer-songwriter who masterfully blends jazz with pop sensibilities. His smooth vocal style, catchy melodies, and sophisticated arrangements make his music accessible while still retaining the depth of jazz traditions. Hamel first gained international recognition with his debut album, which introduced audiences to his unique jazz-pop sound. Since then, he has performed across Europe and Asia, captivating fans with his charming stage presence and heartfelt songwriting. His ability to fuse vintage jazz influences with contemporary pop elements has made him one of the leading figures in modern jazz-pop.', 'A Dutch jazz-pop singer-songwriter known for his smooth vocals and sophisticated, catchy melodies.', '\nSophisticated jazz-pop sound\nCatchy melodies and smooth arrangements\nHeartfelt songwriting and engaging live performances', '\nPerformed internationally across Europe and Asia (2014-Present)\nGained a reputation for sophisticated jazz-pop sound (2015-Present)\nCelebrated for catchy melodies and smooth arrangements (2016-Present)\nCaptivates audiences with engaging live shows and heartfelt songwriting (2017-Present)'),
(6, 'Jonna Fraser', 'jonna-fraser.jpg', 'jonna-fraser-banner.jpg', 'Jonna Fraser is a versatile artist who seamlessly incorporates jazz influences into his hip-hop and R&B sound. His music is characterized by smooth melodies, intricate vocal arrangements, and a deep sense of groove. As an artist who constantly experiments with genre-blending, Fraser brings a fresh perspective to modern music by infusing his tracks with jazz harmonies and rhythms. His ability to switch between soulful ballads and upbeat tracks has earned him a devoted fanbase, and he continues to be a key player in the evolution of contemporary urban music with a jazz twist.', 'A versatile artist incorporating jazz influences into R&B, hip-hop, and soul-infused music.', '\nGenre-blending with jazz influences in hip-hop and R&B\nSmooth melodies and intricate vocal arrangements\nContemporary urban music with jazz elements', '\nKnown for genre-blending approach with jazz influences in hip-hop and R&B (2014-Present)\nPerformance characterized by smooth melodies and intricate vocal arrangements (2015-Present)\nContinues to be a leading figure in modern urban music with a jazz twist (2016-Present)'),
(7, 'Karsu', 'karsu.jpg', 'karsu-banner.jpg', 'Karsu is a multi-talented singer, pianist, and composer who blends jazz with Turkish musical traditions and classical influences. Her unique style is a fusion of East and West, incorporating rich harmonies, intricate melodies, and deeply emotional storytelling. Known for her dynamic stage presence and virtuosic piano skills, she has performed at prestigious venues such as Carnegie Hall and major jazz festivals. Karsu’s music is both deeply personal and universally resonant, making her a standout artist in the global jazz scene.', 'A singer-pianist blending jazz, Turkish influences, and soul into a unique, heartfelt sound.', '\nFusion of jazz, Turkish music, and classical influences\nVirtuosic piano skills\nEmotive songwriting blending different cultural traditions', '\nGained international recognition for performances at prestigious venues like Carnegie Hall (2017-Present)\nFuses jazz, Turkish music, and classical influences (2015-Present)\nVirtuosic piano skills and emotive songwriting continue to captivate audiences (2016-Present)'),
(8, 'Uncle Sue', 'uncle-sue.jpg', 'uncle-sue-banner.jpg', 'Uncle Sue is a jazz-funk band known for their energetic and groove-driven sound. Their music is a blend of progressive jazz, rock elements, and explosive brass arrangements that create a thrilling live experience. The band’s innovative approach to jazz-funk has earned them accolades and a loyal following among jazz and fusion enthusiasts. Their ability to seamlessly transition between complex jazz improvisations and infectious funk rhythms makes them a standout act on the European jazz circuit.', 'A jazz-funk band with an energetic and groovy style, bringing fresh rhythms and bold improvisation.', '\nJazz-funk fusion\nBlending progressive jazz with rock and funk elements\nInnovative improvisations and high-energy live performances', '\nGained attention for electrifying jazz-funk performances across Europe (2015-Present)\nBlends progressive jazz with rock and funk elements (2016-Present)\nKnown for innovative improvisations and dynamic live performances (2017-Present)'),
(9, 'Chris Allen', 'chris-allen.jpg', 'chris-allen-banner.jpg', 'Chris Allen is a soulful saxophonist whose music embodies the smooth and contemporary side of jazz. With a warm, expressive tone and impeccable phrasing, Allen creates melodies that are both soothing and captivating. He has performed with some of the biggest names in jazz and has been featured as a soloist on numerous projects. His music blends traditional jazz influences with modern production, making his sound accessible to a broad audience while maintaining a deep respect for the jazz tradition.', 'A soulful jazz musician delivering smooth melodies and heartfelt performances.', '\nSoulful, expressive saxophone playing\nContributions to both traditional and contemporary jazz\nVersatility in playing various jazz styles', '\nPerformed with major names in jazz (2015-Present)\nSoulful and expressive saxophone playing featured on numerous albums (2016-Present)\nEarned critical acclaim for contributions to both traditional and contemporary jazz (2017-Present)'),
(10, 'Myles Sanko', 'myles-sanko.jpg', 'myles-sanko-banner.jpg', 'Myles Sanko is a British soul-jazz artist known for his rich vocal tone and powerful storytelling. His music blends jazz, soul, and funk elements to create emotionally charged compositions that resonate with listeners. Sanko’s ability to deliver heartfelt performances has made him a favorite at international jazz festivals, and he has shared the stage with jazz greats such as Gregory Porter. His commitment to authentic storytelling through music has solidified his place as one of the most compelling voices in contemporary jazz and soul.', 'A British soul-jazz artist known for his rich vocals and retro-modern sound.', '\nSoul-jazz fusion\nRich vocal tone and emotionally charged performances\nAuthentic storytelling through music', '\nCaptivated audiences worldwide with rich vocal tone and emotionally charged performances (2015-Present)\nPerformed at major jazz festivals (2016-Present)\nShared the stage with jazz legends like Gregory Porter (2017-Present)\nKnown for storytelling through music (2018-Present)'),
(11, 'Ilse Huizinga', 'ilse-huizinga.jpg', 'ilse-huizinga-banner.jpg', 'Ilse Huizinga is a Dutch jazz vocalist celebrated for her elegant interpretation of classic jazz standards and her ability to blend contemporary arrangements with timeless vocals. Her voice is known for its warmth and clarity, which she uses to evoke a deep emotional connection with her audience. Huizinga has released multiple albums through Challenge Records, showcasing her versatile vocal style and her unique approach to jazz. A regular performer at top jazz venues, she has earned a reputation for her engaging live performances and impeccable technique. Her music explores the full spectrum of jazz, from ballads to up-tempo tracks, establishing her as one of the most respected voices in Dutch jazz.', 'A Dutch jazz vocalist celebrated for her elegant interpretations of jazz standards and originals.', '\nClassic vocal jazz with contemporary arrangements\nElegant interpretations of jazz standards\nFocus on phrasing and musical expression', '\nRecognized as one of the leading jazz vocalists in the Netherlands (2015-Present)\nKnown for elegant interpretations of jazz standards (2016-Present)\nReleased multiple albums on Challenge Records (2017-Present)\nPerformed at major European jazz festivals (2018-Present)'),
(12, 'Eric Vloeimans', 'eric-vloeimans.jpg', 'eric-vloeimans-banner.jpg', 'Eric Vloeimans is a world-class trumpet player whose music fuses jazz with classical and world music influences. Known for his technical prowess and lyrical improvisation, Vloeimans has created a distinct sound that bridges the gap between traditional jazz and experimental music. An Edison Award winner, he has composed for film and television, showcasing his versatility and artistic depth. Vloeimans leads his own band, where his trumpet takes center stage, guiding the group through complex harmonies and intricate rhythms. His performances are marked by an emotional intensity, which has earned him international recognition in the jazz world. With his boundary-pushing approach, Eric Vloeimans continues to innovate and inspire musicians across genres.', 'A world-class trumpet player and his band, fusing jazz with cinematic and world music elements.', '\nJazz trumpet with classical and world music influences\nInnovative trumpet playing\nCompositions for both jazz ensembles and film scores', '\nAwarded the Edison Award for contributions to jazz (2016)\nKnown for innovative trumpet playing (2017-Present)\nComposed for film and television (2015-Present)\nCollaborated with top jazz musicians and earned a reputation as one of Europe’s leading trumpet players (2018-Present)'),
(13, 'Gare du Nord', 'gare-du-nord.jpg', 'gare-du-nord-banner.jpg', 'Gare du Nord is a stylish jazz-lounge band known for mixing smooth jazz, blues, and pop elements into their music. Their signature sound is a blend of jazz and lounge music with a modern twist, appealing to listeners who enjoy sophisticated, laid-back grooves. The band has achieved success with multiple platinum albums and has produced several hits across European radio charts. Their music transports listeners to a world of elegance and relaxation, with catchy melodies and soothing rhythms that make them a favorite among jazz enthusiasts and casual listeners alike.', 'A stylish jazz-lounge band mixing smooth jazz, blues, and electronic influences.', '\nJazz-pop fusion\nSmooth and relaxed sound\nLounge music with jazz influences', '\nAchieved multiple platinum albums (2015-Present)\nHits across European charts (2016-Present)\nKnown for smooth fusion of jazz and lounge music (2017-Present)\nBuilt a loyal fan base through extensive European tours (2018-Present)'),
(14, 'Rilan & The Bombadiers', 'rilan-bombadiers.jpg', 'rilan-bombadiers-banner.jpg', 'Rilan & The Bombadiers is a dynamic fusion band blending jazz, soul, and funk into an infectious neo-swing sound. With contemporary production techniques, their music blends elements of traditional jazz with modern sensibilities, creating a fresh and exciting take on the genre. The band has performed on television and at major music festivals, gaining popularity for their energetic live shows and genre-blending sound. Their ability to merge vintage swing with a modern twist has made them a favorite among fans of both jazz and contemporary music.', 'A dynamic fusion band blending jazz, soul, and funk with an energetic stage presence.', '\nNeo-swing with contemporary production\nFusion of jazz, soul, and funk\nHigh-energy performances with modern twists on classic swing', '\nGained recognition for high-energy jazz, soul, and funk performances (2016-Present)\nFeatured on television and major festivals (2017-Present)\nKnown for neo-swing and contemporary production (2018-Present)'),
(15, 'Soul Six', 'soul-six.jpg', 'soul-six-banner.jpg', 'Soul Six is a soulful vocal harmony group with a jazz-infused sound that features horn-driven arrangements and funk elements. Their music combines the power of vocal harmonies with the groove of jazz and soul, creating a sound that is both energetic and smooth. The band has served as a supporting act for some of the biggest names in the international soul scene, showcasing their talent and versatility. Soul Six’s live performances are known for their tight vocals and infectious rhythms, with the band’s horn section adding to the richness of their sound.', 'A soulful vocal harmony group with a jazz-infused sound and deep grooves.', '\nHorn-driven soul-jazz with funk elements\nEnergetic and infectious grooves\nStrong vocal harmonies and jazz influences', '\nSupported international soul artists (2016-Present)\nGained recognition for horn-driven soul-jazz sound (2017-Present)\nPerformed at major festivals and venues across Europe (2018-Present)\nKnown for infectious grooves and vocal harmonies (2019-Present)'),
(16, 'Han Bennink', 'han-bennink.jpg', 'han-bennink-banner.jpg', 'Han Bennink is a legendary Dutch drummer known for his groundbreaking work in free jazz and avant-garde improvisation. A pioneer in the world of experimental jazz, Bennink’s drumming style is characterized by its spontaneous energy, unpredictable rhythms, and unique use of percussion instruments. He is a co-founder of the Instant Composers Pool, a collective that has been at the forefront of experimental jazz in Europe. Over his long career, Han Bennink has collaborated with some of the most innovative musicians in the genre, including Peter Brötzmann and Willem Breuker, pushing the boundaries of jazz with each performance. His contributions to the development of free jazz have earned him widespread acclaim, and he remains an influential figure in the contemporary jazz scene. Known for his tireless creativity, Bennink’s live performances are often an intense, unpredictable experience, where his drumming becomes a vital conversation with the other musicians on stage.', 'A legendary Dutch drummer known for his free jazz improvisations and avant-garde percussion.', '\nFree jazz and avant-garde improvisation\nExperimental drumming techniques\nExploration of non-traditional jazz structures and forms', '\nA legendary drummer known for pioneering contributions to free jazz (2015-Present)\nCo-founder of Instant Composers Pool (2016-Present)\nWorked with jazz icons like Peter Brötzmann and Evan Parker (2017-Present)\nKnown for experimental drumming and avant-garde approach to jazz (2018-Present)'),
(17, 'The Nordanians', 'nordanians.jpg', 'nordanians-banner.jpg', 'The Nordanians is a trio that blends jazz with Indian and Balkan influences, creating a distinctive Indo-jazz fusion with contemporary elements. Known for their innovative approach to traditional music, The Nordanians combine complex rhythms and melodic lines from Indian classical music with the harmonic structures of jazz and the folk traditions of the Balkans. Their performances are a celebration of world music, drawing from diverse cultural influences while maintaining a strong jazz foundation. They have gained recognition at world music festivals and have collaborated with artists from various cultural backgrounds, expanding their global reach.', 'A trio blending jazz with Indian and Balkan influences, creating a unique, rhythmic sound.', '\nIndo-jazz fusion\nBlending jazz with Indian and Balkan musical traditions\nComplex rhythms and melodic structures', '\nEarned acclaim for fusion of jazz with Indian and Balkan influences (2015-Present)\nPerformed at world music festivals (2016-Present)\nBlended complex rhythms and melodies from diverse traditions (2017-Present)'),
(18, 'Lilith Merlot', 'lilith-merlot.jpg', 'lilith-merlot-banner.jpg', 'Lilith Merlot is a jazz-soul singer-songwriter known for her warm, expressive voice and emotional delivery. Her music blends neo-soul jazz with R&B elements, creating a sound that is both intimate and powerful. Merlot’s deep connection to her music is reflected in her soulful melodies and poetic lyrics, which have garnered her attention in the jazz and soul music scenes. A winner of several vocal jazz competitions, Lilith Merlot has been featured in jazz festivals and has captivated audiences with her heartfelt performances. Her work continues to resonate with listeners, earning her a growing fan base in the jazz community.', 'A jazz-soul singer-songwriter with a warm, expressive voice and intimate storytelling.', '\nNeo-soul jazz with R&B influences\nSmooth and emotive vocal performances\nBlend of jazz, soul, and contemporary R&B', '\nWon vocal jazz competitions and earned recognition in the neo-soul and jazz scene (2016-Present)\nPerformed at prestigious European festivals (2017-Present)\nContinues to captivate audiences with fusion of jazz, soul, and R&B (2018-Present)'),
(19, 'Ruis Soundsystem', 'ruis-soundsystem.jpg', 'ruis-soundsystem-banner.jpg', 'Ruis Soundsystem is an innovative collective known for their experimental fusion of electronic beats and live jazz instrumentation. By combining cutting-edge technology with live performances, Ruis Soundsystem pushes the boundaries of both genres, creating a unique sonic experience. Their music explores the intersection of jazz improvisation with electronic soundscapes, resulting in a bold and immersive listening experience. Ruis Soundsystem has performed at major electronic and jazz festivals, where their genre-defying approach to music has earned them a dedicated following. The collective’s performances are marked by a dynamic blend of live instruments and electronic production, creating a high-energy atmosphere that captivates audiences.', 'An experimental jazz collective combining improvisation with electronic and avant-garde influences.', '\nFusion of jazz and electronic music\nLive improvisation with electronic manipulation\nExperimentation with sound and live performance', '\nPioneered fusion of jazz and electronic music (2016-Present)\nKnown for immersive live performances at major festivals (2017-Present)\nBlended electronic manipulation with live improvisation, gaining recognition in both jazz and electronic scenes (2018-Present)');

-- --------------------------------------------------------

--
-- Table structure for table `JazzEvent`
--

CREATE TABLE `JazzEvent` (
  `JazzEventId` int(11) NOT NULL,
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

INSERT INTO `JazzEvent` (`JazzEventId`, `EventId`, `Description`, `Location`, `StartDateTime`, `TimeSlot`, `DurationByMinute`, `TicketsAvailable`, `Price`) VALUES
(1, 21, 'Gumbo Kings performance at Patronaat', '1', '2025-07-24 18:00:00', '18:00 - 19:00', 60, 300, 15),
(2, 22, 'Evolve performance at Patronaat', '1', '2025-07-24 19:30:00', '19:30 - 20:30', 60, 300, 15),
(3, 23, 'Ntjam Rosie performance at Patronaat', '1', '2025-07-24 21:00:00', '21:00 - 22:00', 60, 300, 15),
(4, 24, 'Wicked Jazz Sounds performance at Patronaat', '2', '2025-07-24 18:00:00', '18:00 - 19:00', 60, 200, 10),
(5, 25, 'Wouter Hamel performance at Patronaat', '2', '2025-07-24 19:30:00', '19:30 - 20:30', 60, 200, 10),
(6, 26, 'Jonna Frazer performance at Patronaat', '2', '2025-07-24 21:00:00', '21:00 - 22:00', 60, 200, 10),
(7, 27, 'Karsu performance at Patronaat', '1', '2025-07-25 18:00:00', '18:00 - 19:00', 60, 300, 15),
(8, 28, 'Uncle Sue performance at Patronaat', '1', '2025-07-25 19:30:00', '19:30 - 20:30', 60, 300, 15),
(9, 29, 'Chris Allen performance at Patronaat', '1', '2025-07-25 21:00:00', '21:00 - 22:00', 60, 300, 15),
(10, 30, 'Myles Sanko performance at Patronaat', '2', '2025-07-25 18:00:00', '18:00 - 19:00', 60, 200, 10),
(11, 31, 'Ilse Huizinga performance at Patronaat', '2', '2025-07-25 19:30:00', '19:30 - 20:30', 60, 200, 10),
(12, 32, 'Eric Vloeimans and Hotspot! performance at Patronaat', '2', '2025-07-25 21:00:00', '21:00 - 22:00', 60, 200, 10),
(13, 33, 'Gare du Nord performance at Patronaat', '1', '2025-07-26 18:00:00', '18:00 - 19:00', 60, 300, 15),
(14, 34, 'Rilan & The Bombadiers performance at Patronaat', '1', '2025-07-26 19:30:00', '19:30 - 20:30', 60, 300, 15),
(15, 35, 'Soul Six performance at Patronaat', '1', '2025-07-26 21:00:00', '21:00 - 22:00', 60, 300, 15),
(16, 36, 'Han Bennink performance at Patronaat', '3', '2025-07-26 18:00:00', '18:00 - 19:00', 60, 150, 10),
(17, 37, 'The Nordanians performance at Patronaat', '3', '2025-07-26 19:30:00', '19:30 - 20:30', 60, 150, 10),
(18, 38, 'Lilith Merlot performance at Patronaat', '3', '2025-07-26 21:00:00', '21:00 - 22:00', 60, 150, 10),
(19, 39, 'Ruis Soundsystem performance at Grote Markt', '4', '2025-07-27 15:00:00', '15:00 - 16:00', 60, 1000, 0),
(20, 40, 'Wicked Jazz Sounds performance at Grote Markt', '4', '2025-07-27 16:00:00', '16:00 - 17:00', 60, 1000, 0),
(21, 41, 'Evolve performance at Grote Markt', '4', '2025-07-27 17:00:00', '17:00 - 18:00', 60, 1000, 0),
(22, 42, 'The Nordanians performance at Grote Markt', '4', '2025-07-27 18:00:00', '18:00 - 19:00', 60, 1000, 0),
(23, 43, 'Gumbo Kings performance at Grote Markt', '4', '2025-07-27 19:00:00', '19:00 - 20:00', 60, 1000, 0),
(24, 44, 'Gare du Nord performance at Grote Markt', '4', '2025-07-27 20:00:00', '20:00 - 21:00', 60, 1000, 0),
(25, 45, 'Gumbo Kings at Haarlem Jazz', '1', '2025-07-27 19:00:00', 'Evening', 90, 300, 25),
(26, 46, 'Evolve at Haarlem Jazz', '2', '2025-07-27 21:00:00', 'Evening', 90, 200, 20),
(27, 47, 'Ntjam Rosie at Haarlem Jazz', '1', '2025-07-28 19:00:00', 'Evening', 90, 300, 25),
(28, 48, 'Wicked Jazz Sounds at Haarlem Jazz', '2', '2025-07-28 21:00:00', 'Evening', 90, 200, 20),
(29, 49, 'Wouter Hamel at Haarlem Jazz', '1', '2025-07-29 19:00:00', 'Evening', 90, 300, 25),
(30, 50, 'Uncle Sue at Haarlem Jazz', '2', '2025-07-29 21:00:00', 'Evening', 90, 200, 20),
(31, 51, 'Karsu at Haarlem Jazz', '4', '2025-07-30 15:00:00', 'Afternoon', 60, 1000, 0),
(32, 52, 'Jonna Fraser at Haarlem Jazz', '4', '2025-07-30 17:00:00', 'Evening', 60, 1000, 0);

-- --------------------------------------------------------

--
-- Table structure for table `JazzPass`
--

CREATE TABLE `JazzPass` (
  `PassId` int(11) NOT NULL,
  `PassType` varchar(20) NOT NULL,
  `DisplayName` varchar(100) NOT NULL,
  `ShortDescription` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `Dates` varchar(255) DEFAULT NULL,
  `BasePrice` decimal(10,2) NOT NULL DEFAULT 0.00,
  `Featured` tinyint(1) NOT NULL DEFAULT 0,
  `CreatedAt` timestamp NULL DEFAULT current_timestamp(),
  `UpdatedAt` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzPass`
--

INSERT INTO `JazzPass` (`PassId`, `PassType`, `DisplayName`, `ShortDescription`, `Description`, `Dates`, `BasePrice`, `Featured`, `CreatedAt`, `UpdatedAt`) VALUES
(1, 'Free', 'Sunday Performances', 'All performances at Grote Markt on Sunday', 'Sunday Performances - Free Entry||All performances at Grote Markt on Sunday, July 27th are free for all visitors. No reservation needed.||Join us for a fantastic day of jazz in the heart of Haarlem!', '2025-07-27', 0.00, 0, '2025-03-25 03:25:58', '2025-04-13 23:33:49'),
(2, 'SingleUse', 'Single Performance', 'Access to a single performance', 'Select individual performances||Main Hall performances: €15 per show||Second & Third Hall: €10 per show||Flexible scheduling to fit your plans', NULL, 15.00, 0, '2025-03-25 03:25:58', '2025-04-13 23:09:27'),
(3, 'DayPass', 'Day Pass', 'Access to all venues for one day', 'Full access to all venues for one day||Choose Thursday, Friday, or Saturday||Access to all performances on your chosen day||Convenient all-in-one ticket', '2025-07-24,2025-07-25,2025-07-26', 35.00, 0, '2025-03-25 03:25:58', '2025-04-13 23:33:49'),
(4, 'WeekendPass', 'Weekend Pass (Thu-Sat)', 'Access to all performances Thursday through Saturday', 'Complete access Thursday through Saturday||Admission to all performances across three days||Experience the full range of indoor festival events', '2025-07-24,2025-07-25,2025-07-26', 80.00, 1, '2025-03-25 03:25:58', '2025-04-13 23:33:49');

-- --------------------------------------------------------

--
-- Table structure for table `JazzPerformance`
--

CREATE TABLE `JazzPerformance` (
  `JazzEventId` int(11) NOT NULL,
  `ArtistId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzPerformance`
--

INSERT INTO `JazzPerformance` (`JazzEventId`, `ArtistId`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17),
(18, 18),
(19, 19),
(20, 4),
(21, 2),
(22, 17),
(23, 1),
(24, 13);

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
  `ReleaseYear` date DEFAULT NULL,
  `audio_file` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `JazzTrack`
--

INSERT INTO `JazzTrack` (`TrackId`, `ArtistId`, `Title`, `Credits`, `Description`, `ReleaseYear`, `audio_file`) VALUES
(1, 1, 'Bourbon Street Parade', 'Traditional, arranged by Gumbo Kings', 'A jubilant celebration of New Orleans parade traditions with exuberant brass and infectious rhythms', '2020-05-15', 'gumbokings.bourbonstreetparade.mp3'),
(2, 1, 'Crescent City Blues', 'Composed by Gumbo Kings', 'A soulful homage to the musical heritage of New Orleans with rich harmonies and expressive solos', '2020-05-15', 'gumbokings.crescentcityblues.mp3'),
(3, 1, 'Mardi Gras Morning', 'Composed by Gumbo Kings', 'An energetic piece capturing the excitement and color of Carnival season, featuring call-and-response sections', '2020-05-15', 'gumbokings.mardigrasmorning.mp3'),
(4, 2, 'Quantum Leap', 'Composed by Marcus Reynolds', 'An adventurous composition blending acoustic jazz with electronic elements and shifting time signatures', '2021-09-10', 'evolve.quantumleap.mp3'),
(5, 2, 'Digital Monk', 'Composed by Marcus Reynolds', 'A tribute to Thelonious Monk reimagined through contemporary production techniques', '2021-09-10', 'evolve.digitalmonk.mp3'),
(6, 2, 'Neural Networks', 'Composed by Evolve', 'An explorative piece with complex interweaving melodic lines inspired by artificial intelligence concepts', '2021-09-10', 'evolve.neuralnetworks.mp3'),
(7, 3, 'Cameroon Memories', 'Composed by Ntjam Rosie', 'A heartfelt composition blending jazz harmonies with traditional Central African rhythms', '2022-02-18', 'ntjamrosie.cameroonmemories.mp3'),
(8, 3, 'Atlantic Bridge', 'Composed by Ntjam Rosie', 'A powerful song exploring cultural connections across continents with soaring vocals', '2022-02-18', 'ntjamrosie.atlanticbridge.mp3'),
(9, 3, 'Mother\'s Voice', 'Composed by Ntjam Rosie', 'A tender ballad with lyrics in both English and Bakaka celebrating maternal wisdom', '2022-02-18', 'ntjamrosie.mothersvoice.mp3'),
(10, 4, 'Club Jazz Revolution', 'Composed by Wicked Jazz Sounds Collective', 'A high-energy fusion of jazz improvisation with house music rhythms', '2021-11-05', 'wickedjazzsounds.clubjazzrevolution.mp3'),
(11, 4, 'Midnight in Amsterdam', 'Composed by Wicked Jazz Sounds Collective', 'A groove-oriented track capturing the city\'s late-night creative energy', '2021-11-05', 'wickedjazzsounds.midnightinamsterdam.mp3'),
(12, 4, 'Sample This', 'Composed by Wicked Jazz Sounds Collective', 'An innovative piece built around fragments of classic jazz recordings', '2021-11-05', 'wickedjazzsounds.samplethis.mp3'),
(13, 5, 'November Rain', 'Composed by Wouter Hamel', 'A melancholic yet hopeful ballad featuring Hamel\'s signature warm vocals and delicate piano', '2023-03-21', 'wouterhamel.novemberrain.mp3'),
(14, 5, 'Paris in Spring', 'Composed by Wouter Hamel', 'A charming song inspired by French chanson with playful lyrics and sophisticated chord changes', '2023-03-21', 'wouterhamel.parisinspring.mp3'),
(15, 5, 'Autumn Leaves Revisited', 'Traditional, arranged by Wouter Hamel', 'A fresh interpretation of the jazz standard with unexpected harmonic twists', '2023-03-21', 'wouterhamel.autumnleavesrevisited.mp3'),
(16, 6, 'Urban Soul', 'Composed by Jonna Fraser', 'A smooth blend of jazz and R&B that showcases Fraser\'s unique vocal style and urban sensibility', '2022-04-15', 'jonnafraser.urbansoul.mp3'),
(17, 6, 'Rhythm City', 'Composed by Jonna Fraser', 'An upbeat track with infectious rhythms and jazz-influenced harmonies that capture the energy of city life', '2022-04-15', 'jonnafraser.rhythmcity.mp3'),
(18, 6, 'Jazzy Nights', 'Composed by Jonna Fraser', 'A mellow, atmospheric piece that combines classic jazz elements with contemporary production techniques', '2022-04-15', 'jonnafraser.jazzynights.mp3'),
(19, 7, 'Anatolian Dreams', 'Composed by Karsu', 'A haunting jazz composition that interweaves traditional Turkish melodic patterns with contemporary jazz harmonies', '2021-11-12', 'karsu.anatoliandreams.mp3'),
(20, 7, 'Istanbul Junction', 'Composed by Karsu', 'A vibrant piece that captures the bustling energy of Istanbul with driving rhythms and intricate piano work', '2021-11-12', 'karsu.istanbuljunction.mp3'),
(21, 7, 'Bridge Between Worlds', 'Composed by Karsu', 'A reflective composition that beautifully blends Eastern and Western musical traditions into a unified jazz expression', '2021-11-12', 'karsu.bridgebetweenworlds.mp3'),
(22, 8, 'Funky Disposition', 'Composed by Uncle Sue', 'A groove-heavy funk-jazz fusion track with punchy brass arrangements and a solid, danceable rhythm section', '2023-01-20', 'unclesue.funkydisposition.mp3'),
(23, 8, 'Backbeat Swagger', 'Composed by Uncle Sue', 'An energetic composition featuring tight ensemble playing and adventurous solos over a compelling backbeat', '2023-01-20', 'unclesue.backbeatswagger.mp3'),
(24, 8, 'Late Night Session', 'Composed by Uncle Sue', 'A smooth, laid-back piece that evokes the intimate atmosphere of after-hours jazz clubs with warm chord progressions', '2023-01-20', 'unclesue.latenightsession.mp3'),
(25, 9, 'Saxophone Soliloquy', 'Composed by Chris Allen', 'A heartfelt saxophone-led composition that showcases Allen\'s expressive tone and lyrical phrasing', '2022-06-08', 'chrisallen.saxophonesoliloquy.mp3'),
(26, 9, 'Blue Horizon', 'Composed by Chris Allen', 'A melodic jazz ballad with rich harmonies and a memorable, singable melody that stays with the listener', '2022-06-08', 'chrisallen.bluehorizon.mp3'),
(27, 9, 'Uptown Shuffle', 'Composed by Chris Allen', 'A swinging, upbeat tune with a catchy hook and sophisticated chord changes that invite improvisation', '2022-06-08', 'chrisallen.uptownshuffle.mp3'),
(28, 10, 'Soul Searchin\'', 'Composed by Myles Sanko', 'A soulful jazz composition with heartfelt vocals exploring themes of self-discovery and personal truth', '2021-09-30', 'mylessanko.soulsearchin.mp3'),
(29, 10, 'Just Being Me', 'Composed by Myles Sanko', 'An authentic expression of individuality through smooth jazz-soul fusion with Sanko\'s distinctive vocal timbre', '2021-09-30', 'mylessanko.justbeingme.mp3'),
(30, 10, 'Midnight Train', 'Composed by Myles Sanko', 'A rhythmic journey through nocturnal soundscapes with train-like percussion and evocative horn arrangements', '2021-09-30', 'mylessanko.midnighttrain.mp3'),
(31, 11, 'Amsterdam Memories', 'Composed by Ilse Huizinga', 'A nostalgic ballad with gentle vocals painting a musical portrait of the canals and streets of Amsterdam', '2022-03-17', 'ilsehuizinga.amsterdammemories.mp3'),
(32, 11, 'Windmill Dreams', 'Composed by Ilse Huizinga', 'A graceful composition inspired by the Dutch landscape, featuring delicate vocal improvisation and sensitive accompaniment', '2022-03-17', 'ilsehuizinga.windmilldreams.mp3'),
(33, 11, 'Beyond Words', 'Composed by Ilse Huizinga', 'A wordless vocal exploration that demonstrates Huizinga\'s remarkable control and emotional expressivity', '2022-03-17', 'ilsehuizinga.beyondwords.mp3'),
(34, 12, 'Trumpet Flight', 'Composed by Eric Vloeimans', 'A soaring trumpet-led composition that showcases Vloeimans\' extraordinary range and technical mastery', '2021-12-05', 'ericvloeimans.trumpetflight.mp3'),
(35, 12, 'Conversations', 'Composed by Eric Vloeimans and Hotspot!', 'An interactive piece featuring musical dialogues between trumpet and ensemble with surprising harmonic twists', '2021-12-05', 'ericvloeimans.conversations.mp3'),
(36, 12, 'Reflections in Brass', 'Composed by Eric Vloeimans', 'A meditative composition with warm trumpet tones floating over subtle, supportive textures from the ensemble', '2021-12-05', 'ericvloeimans.reflectionsinbrass.mp3'),
(37, 13, 'Parisian Rendezvous', 'Composed by Gare du Nord', 'A sophisticated lounge-jazz piece with a French touch, combining smooth rhythms with atmospheric textures', '2023-02-14', 'garedunord.parisianrendezvous.mp3'),
(38, 13, 'Café Culture', 'Composed by Gare du Nord', 'An elegant track capturing the ambiance of European café culture with bossa nova influences and subtle electronic elements', '2023-02-14', 'garedunord.cafeculture.mp3'),
(39, 13, 'Jazz Express', 'Composed by Gare du Nord', 'An uptempo journey through changing landscapes of sound, with driving rhythms and melodic hooks', '2023-02-14', 'garedunord.jazzexpress.mp3'),
(40, 14, 'Swing Revolution', 'Composed by Rilan & The Bombadiers', 'A high-energy neo-swing number that combines vintage jazz vibes with contemporary production and danceable rhythms', '2022-07-22', 'rilanbombadiers.swingrevolution.mp3'),
(41, 14, 'Bombadier Boogie', 'Composed by Rilan & The Bombadiers', 'A rollicking, horn-driven boogie that gets audiences moving with its infectious groove and playful solos', '2022-07-22', 'rilanbombadiers.bombadierboogie.mp3'),
(42, 14, 'Midnight Swing', 'Composed by Rilan & The Bombadiers', 'A sultry, after-hours swing tune that balances sophisticated jazz harmonies with accessible melodies and rhythms', '2022-07-22', 'rilanbombadiers.midnightswing.mp3'),
(43, 15, 'Soulful Strut', 'Composed by Soul Six', 'A strutting, confident jazz-soul fusion with tight horn arrangements and a deep, satisfying groove', '2021-10-10', 'soulsix.soulfulstrut.mp3'),
(44, 15, 'Harmony Lane', 'Composed by Soul Six', 'A melodic composition featuring lush vocal harmonies and warm instrumental textures that evoke classic soul-jazz', '2021-10-10', 'soulsix.harmonylane.mp3'),
(45, 15, 'Six Steps', 'Composed by Soul Six', 'A rhythmically inventive piece in 6/8 time that showcases the ensemble\'s tight coordination and improvisational skills', '2021-10-10', 'soulsix.sixsteps.mp3'),
(46, 16, 'Drum Dialogue', 'Composed by Han Bennink', 'An adventurous percussion solo that demonstrates Bennink\'s innovative approach to the drum kit as a complete musical voice', '2022-09-18', 'hanbennink.drumdialogue.mp3'),
(47, 16, 'Free Form Expression', 'Composed by Han Bennink', 'A boldly experimental free jazz piece that pushes boundaries with unconventional sounds and approaches to rhythm', '2022-09-18', 'hanbennink.freeformexpression.mp3'),
(48, 16, 'Rhythm Abstractions', 'Composed by Han Bennink', 'A multi-layered percussion composition that explores complex rhythmic patterns and timbral variations', '2022-09-18', 'hanbennink.rhythmabstractions.mp3'),
(49, 17, 'Dutch East', 'Composed by The Nordanians', 'A cross-cultural jazz exploration that blends Western jazz harmonies with Eastern melodic influences and rhythmic concepts', '2022-11-04', 'nordanians.dutcheast.mp3'),
(50, 17, 'Crossroads', 'Composed by The Nordanians', 'A meeting point of traditions where jazz improvisation meets classical Indian concepts with seamless integration', '2022-11-04', 'nordanians.crossroads.mp3'),
(51, 17, 'New Horizons', 'Composed by The Nordanians', 'An expansive composition that opens new sonic territories by combining diverse musical worlds into a cohesive whole', '2022-11-04', 'nordanians.newhorizons.mp3'),
(52, 18, 'Red Velvet', 'Composed by Lilith Merlot', 'A smooth, luxurious jazz-soul ballad showcasing Merlot\'s rich vocal timbre and emotional depth', '2022-05-20', 'lilithmerlot.redvelvet.mp3'),
(53, 18, 'Midnight Confession', 'Composed by Lilith Merlot', 'An intimate, confessional piece with minimalist accompaniment highlighting the nuances of Merlot\'s vocal expression', '2022-05-20', 'lilithmerlot.midnightconfession.mp3'),
(54, 18, 'Autumn Leaves Fall', 'Composed by Lilith Merlot', 'A fresh take on seasonal change through jazz-infused soul with poetic lyrics and understated instrumental backing', '2022-05-20', 'lilithmerlot.autumnleavesfall.mp3'),
(55, 19, 'Digital Jazz', 'Composed by Ruis Soundsystem', 'An innovative fusion of electronic production techniques with live jazz instrumentation creating new sonic territories', '2023-01-15', 'ruissoundsystem.digitaljazz.mp3'),
(56, 19, 'Circuit Swing', 'Composed by Ruis Soundsystem', 'A rhythmic exploration where electronic beats and jazz swing engage in dialogue, creating danceable avant-garde music', '2023-01-15', 'ruissoundsystem.circuitswing.mp3'),
(57, 19, 'Ambient Horns', 'Composed by Ruis Soundsystem', 'A atmospheric soundscape where processed horn sounds drift through electronic textures creating immersive listening experiences', '2023-01-15', 'ruissoundsystem.ambienthorns.mp3');

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
(5, 1, 0, 'Pending', '2025-03-25 12:41:47', '0647629759', 'Strada Marului, nr 5'),
(10, 2, NULL, NULL, '2025-04-02 14:48:13', 'fred', '123432142'),
(11, 3, NULL, NULL, '2025-04-13 22:29:07', NULL, NULL),
(12, 3, NULL, NULL, '2025-04-13 22:30:20', NULL, NULL),
(13, 3, NULL, NULL, '2025-04-13 22:30:47', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `Restaurant`
--

CREATE TABLE `Restaurant` (
  `RestaurantId` int(11) NOT NULL,
  `EventId` int(11) NOT NULL,
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

--
-- Dumping data for table `Ticket`
--

INSERT INTO `Ticket` (`TicketId`, `OrderId`, `Price`, `PassType`, `IsValid`, `EventId`) VALUES
(3, 11, 18, NULL, 1, 10),
(4, 11, 18, NULL, 1, 10),
(5, 11, 18, NULL, 1, 10),
(6, 11, 18, NULL, 1, 10),
(7, 12, 0, NULL, 1, 1),
(8, 12, 0, NULL, 1, 1),
(9, 12, 0, NULL, 1, 1),
(10, 13, 18, NULL, 1, 10),
(11, 13, 18, NULL, 1, 10);

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
  `ResetTokenExpires` datetime DEFAULT NULL,
  `RegisteredDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`UserId`, `FullName`, `Email`, `Password`, `Role`, `VerifyToken`, `VerifyStatus`, `ResetTokenExpires`, `RegisteredDate`) VALUES
(1, 'minudenisa29@gmail.com', 'minudenisa29@gmail.com', '$2y$12$jCeTK/mwIeCoFbYa.oLjkuPrwuio8xiOmgrfyKGwZk/KyaFjf4MEm', 'customer', '5dab23b6dc70d349c9d6d898d5eeeada', 0, NULL, '2025-04-13 11:58:28'),
(2, 'fred', 'fred@gmail.com', '$2y$12$GT9ax8mzyqThc.wksKuy8OwasAKug4NBbMcjE/FW/XGS2LH0ZrBPm', 'customer', '2721408a3149f413b2f14143e9ab32a4', 0, NULL, '2025-04-13 11:58:28'),
(3, 'Admin', 'aldrobe.nl@gmail.com', '$2y$12$tqDTmdZDeZQZIbP/dXIsIu1ok7DjNZTDX1QrOPXUTdjYHZPtMAvW6', 'admin', NULL, 0, NULL, '2025-04-13 11:58:28');

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
  `Description` varchar(255) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `OfficePhone` varchar(50) DEFAULT NULL,
  `OfficeHours` varchar(50) DEFAULT NULL,
  `InfoPhone` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Dumping data for table `Venue`
--

INSERT INTO `Venue` (`VenueId`, `Name`, `Location`, `Address`, `Capacity`, `Description`, `Email`, `OfficePhone`, `OfficeHours`, `InfoPhone`) VALUES
(1, 'Patronaat Main Hall', 'Patronaat', 'Zijlsingel 2, 2013 DN Haarlem', 300, 'The main performance hall of Patronaat', 'info@patronaat.nl', '023 - 517 58 50', '10:00 - 17:00', '023 - 517 58 58'),
(2, 'Patronaat Second Hall', 'Patronaat', 'Zijlsingel 2, 2013 DN Haarlem', 200, 'The second performance hall of Patronaat', 'info@patronaat.nl', '023 - 517 58 50', '10:00 - 17:00', '023 - 517 58 58'),
(3, 'Patronaat Third Hall', 'Patronaat', 'Zijlsingel 2, 2013 DN Haarlem', 150, 'The intimate third performance hall of Patronaat', 'info@patronaat.nl', '023 - 517 58 50', '10:00 - 17:00', '023 - 517 58 58'),
(4, 'Grote Markt', 'Grote Markt', 'Grote Markt, Haarlem', 1000, 'The central market square of Haarlem', 'info@haarlemjazz.nl', '023 - 551 47 32', '9:00 - 17:00', '023 - 551 47 35');

--
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
  ADD PRIMARY KEY (`DanceEventId`),
  ADD KEY `EventId` (`EventId`);

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
  ADD PRIMARY KEY (`HistoryTourId`),
  ADD KEY `EventId` (`EventId`);

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
  ADD PRIMARY KEY (`JazzEventId`),
  ADD KEY `EventId` (`EventId`);

--
-- Indexes for table `JazzPass`
--
ALTER TABLE `JazzPass`
  ADD PRIMARY KEY (`PassId`);

--
-- Indexes for table `JazzPerformance`
--
ALTER TABLE `JazzPerformance`
  ADD PRIMARY KEY (`JazzEventId`,`ArtistId`),
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
  ADD PRIMARY KEY (`RestaurantId`),
  ADD KEY `EventId` (`EventId`);

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
  MODIFY `ArtistId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `DanceEvent`
--
ALTER TABLE `DanceEvent`
  MODIFY `DanceEventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `DanceSong`
--
ALTER TABLE `DanceSong`
  MODIFY `SongId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Event`
--
ALTER TABLE `Event`
  MODIFY `EventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `HistoryTour`
--
ALTER TABLE `HistoryTour`
  MODIFY `HistoryTourId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `HistoryTourBooking`
--
ALTER TABLE `HistoryTourBooking`
  MODIFY `BookingId` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `JazzEvent`
--
ALTER TABLE `JazzEvent`
  MODIFY `JazzEventId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `JazzPass`
--
ALTER TABLE `JazzPass`
  MODIFY `PassId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Order`
--
ALTER TABLE `Order`
  MODIFY `OrderId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `Restaurant`
--
ALTER TABLE `Restaurant`
  MODIFY `RestaurantId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `Ticket`
--
ALTER TABLE `Ticket`
  MODIFY `TicketId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
  MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
-- Constraints for table `DanceEvent`
--
ALTER TABLE `DanceEvent`
  ADD CONSTRAINT `DanceEvent_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

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
-- Constraints for table `HistoryTour`
--
ALTER TABLE `HistoryTour`
  ADD CONSTRAINT `HistoryTour_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

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
-- Constraints for table `Restaurant`
--
ALTER TABLE `Restaurant`
  ADD CONSTRAINT `Restaurant_ibfk_1` FOREIGN KEY (`EventId`) REFERENCES `Event` (`EventId`);

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
