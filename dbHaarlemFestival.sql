-- Updated SQL - 21-03-2025

-- Lonely Tables
CREATE TABLE Content (
    ContentId INT PRIMARY KEY,
    EventType ENUM('home', 'dance', 'history', 'yummy', 'magic', 'jazz'),
    Section VARCHAR(50),
    Content TEXT
);

CREATE TABLE Lorentz (
    LorentzId INT PRIMARY KEY,
    Description VARCHAR(255),
    StartDate DATE,
    StartDateTime DATETIME,
    EndDateTime DATETIME
);

CREATE TABLE HistoryTour (
    EventId INT PRIMARY KEY,
    LocationId INT,
    LocationName VARCHAR(100),
    Description TEXT,
    Address VARCHAR(100),
    ImageGenera VARCHAR(255),
    ImageGallery TEXT
);

-- Relation Tables

-- Creating the Users table (renamed from User to avoid reserved keyword)
CREATE TABLE Users (
  UserId INT PRIMARY KEY AUTO_INCREMENT,
  FullName VARCHAR(100),
  Email VARCHAR(100) UNIQUE,
  Password VARCHAR(255),
  Role VARCHAR(50),
  ResetToken VARCHAR(255),
  ResetTokenExpires DATETIME,
  RegisteredDate DATETIME DEFAULT CURRENT_TIMESTAMP,
  VerifyToken VARCHAR(100),
  VerifyStatus TINYINT DEFAULT 0,
  Status ENUM('Active', 'Inactive')
);

-- Creating the Restaurant table
CREATE TABLE Restaurant (
  RestaurantId INT PRIMARY KEY,
  EventId INT,
  CuisineType VARCHAR(50),
  About VARCHAR(255),
  Address VARCHAR(255),
  Name VARCHAR(100),
  ImageGallery VARCHAR(255),
  WorkingHours VARCHAR(50),
  SessionsAvailable VARCHAR(100),
  FirstStart DATETIME,
  Duration INT,
  Rating INT,
  Seats INT,
  ReadPrice INT,
  Comment VARCHAR(255)
);

-- Creating the Menu table
CREATE TABLE Menu (
  MenuId INT PRIMARY KEY,
  RestaurantId INT,
  MenuName VARCHAR(100),
  FOREIGN KEY (RestaurantId) REFERENCES Restaurant(RestaurantId)
);

-- Creating the MenuItem table
CREATE TABLE MenuItem (
  MenuItemId INT PRIMARY KEY,
  MenuId INT,
  Title VARCHAR(100),
  Description VARCHAR(255),
  Price INT,
  FOREIGN KEY (MenuId) REFERENCES Menu(MenuId)
);

-- Creating the Order table
CREATE TABLE `Order` (
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