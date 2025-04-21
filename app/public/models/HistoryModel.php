<?php
require_once(__DIR__ . "/BaseModel.php");

class HistoryModel extends BaseModel {

    public function __construct() {
        parent::__construct(); 
    }

    // Get all available dates for tours
    public function getAvailableDates() {
        $query = "SELECT DISTINCT TourDate FROM HistoryTourSchedule 
                  WHERE TourDate >= CURDATE() 
                  ORDER BY TourDate ASC";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // Get available times for a specific date
    public function getAvailableTimes($date) {
        $query = "SELECT DISTINCT TourTime FROM HistoryTourSchedule 
                  WHERE TourDate = ? 
                  ORDER BY TourTime ASC";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date]);
        return $stmt->fetchAll();
    }

    // Get available languages for a specific date and time
    public function getAvailableLanguages($date, $time) {
        $query = "SELECT DISTINCT Language FROM HistoryTourSchedule 
                  WHERE TourDate = ? AND TourTime = ? 
                  AND TicketsAvailable > 0";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time]);
        return $stmt->fetchAll();
    }

    // Get available seats
    public function getAvailableSeats($date, $time, $language) {
        $query = "SELECT SUM(TicketsAvailable) as AvailableSeats 
                  FROM HistoryTourSchedule 
                  WHERE TourDate = ? AND TourTime = ? AND Language = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time, $language]);
        $result = $stmt->fetch();
        return $result ? $result['AvailableSeats'] : 0;
    }

    // Get price info
    public function getPriceInfo($date, $time) {
        $query = "SELECT TicketPrice, FamilyTicketPrice FROM HistoryTourSchedule 
                  WHERE TourDate = ? AND TourTime = ? 
                  LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time]);
        return $stmt->fetch();
    }

    // Create a booking
    public function createBooking($scheduleId, $language, $ticketType, $seats, $totalPrice) {
        self::$pdo->beginTransaction();
        try {
            // Insert into booking table
            $stmt = self::$pdo->prepare("INSERT INTO HistoryTourBooking 
                (ScheduleId, Language, TicketType, Seats, Price) 
                VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$scheduleId, $language, $ticketType, $seats, $totalPrice]);
            $bookingId = self::$pdo->lastInsertId();
            // Decrease tickets available
            $stmt = self::$pdo->prepare("UPDATE HistoryTourSchedule 
                SET TicketsAvailable = TicketsAvailable - ? 
                WHERE EventId = ?");
            $stmt->execute([$seats, $scheduleId]);

            self::$pdo->commit();
            return $bookingId;
        } catch (Exception $e) {
            self::$pdo->rollback();
            throw $e;
        }
    }

    // Get guide full name and profile image for a schedule
    public function getGuideInfo($scheduleId) {
        $query = "SELECT tg.FullName, tg.ProfileImage 
                  FROM HistoryTourSchedule hts
                  JOIN TourGuide tg ON hts.GuideId = tg.GuideId
                  WHERE hts.EventId = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$scheduleId]);
        return $stmt->fetch();
    }

    // Get one schedule ID matching date/time/language, with tickets left
    public function getScheduleId($date, $time, $language) {
        $query = "SELECT EventId 
                  FROM HistoryTourSchedule 
                  WHERE TourDate = ? AND TourTime = ? AND Language = ? 
                  AND TicketsAvailable > 0 
                  ORDER BY TicketsAvailable DESC 
                  LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time, $language]);
        $result = $stmt->fetch();
        return $result ? $result['EventId'] : null;
    }

    // Get content HTML for history page sections
    public function getHistoryContent($section) {
        $query = "SELECT Content FROM Content 
                  WHERE EventType = 'history' AND Section = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$section]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['Content'] : '';
    }

    // Get all history tour locations 
    public function getHistoryLocations() {
        $query = "SELECT LocationId, LocationName, Description, Address, ImageGenera, ImageGallery 
                  FROM HistoryTour 
                  ORDER BY LocationId";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

     // Get list of all tour guides
    public function getTourGuides() {
        $query = "SELECT GuideId, FullName, ProfileImage, LanguagesSpoken 
                  FROM TourGuide 
                  ORDER BY FullName";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get formatted schedule summary for overview page
    public function getTourSchedule() {
        $query = "SELECT 
                    DATE_FORMAT(TourDate, '%d %M') as FormattedDate,
                    DATE_FORMAT(TourDate, '%W') as DayOfWeek,
                    GROUP_CONCAT(DISTINCT TIME_FORMAT(TourTime, '%H:%i') ORDER BY TourTime SEPARATOR ', ') as Times,
                    'Church of St. Bavo' as StartLocation,
                    MAX(CASE WHEN Language = 'English' THEN 'Yes' ELSE 'No' END) as EnglishTour,
                    MAX(CASE WHEN Language = 'Dutch' THEN 'Yes' ELSE 'No' END) as DutchTour,
                    MAX(CASE WHEN Language = 'Chinese' THEN 'Yes' ELSE 'No' END) as ChineseTour,
                    12 as Seats
                  FROM HistoryTourSchedule
                  GROUP BY TourDate
                  ORDER BY TourDate";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get pricing overview
    public function getPricing() {
        $query = "SELECT TicketPrice, FamilyTicketPrice 
                  FROM HistoryTourSchedule 
                  LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Get one location’s data by ID and build image array
    public function getTourLocationById($locationId) {
        $query = "SELECT * FROM HistoryTour WHERE LocationId = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$locationId]);
        $location = $stmt->fetch(PDO::FETCH_ASSOC);
        // Build gallery array from comma list
        if ($location) {
            $location['ImageGalleryArray'] = !empty($location['ImageGallery'])
                ? explode(',', $location['ImageGallery'])
                : [$location['ImageGenera']];
        }

        return $location;
    }
    // Alternate method for EventId lookup 
    public function getHistoryTourEventId($date, $time, $language) {
        $query = "SELECT EventId FROM HistoryTourSchedule 
                WHERE TourDate = :date 
                    AND TourTime = :time 
                    AND Language = :language
                LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':language', $language);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? (int)$result['EventId'] : null;
    }

}
?>
