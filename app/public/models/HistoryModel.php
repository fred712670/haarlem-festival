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
                  AND (TotalSeats - SeatsBooked) > 0";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time]);
        return $stmt->fetchAll();
    }
    
    // Get available seats for a date, time, and language
    public function getAvailableSeats($date, $time, $language) {
        $query = "SELECT SUM(TotalSeats - SeatsBooked) as AvailableSeats 
                  FROM HistoryTourSchedule 
                  WHERE TourDate = ? AND TourTime = ? AND Language = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time, $language]);
        $result = $stmt->fetch();
        return $result ? $result['AvailableSeats'] : 0;
    }
    
    // Get price information for a date and time
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
        // Begin transaction
        self::$pdo->beginTransaction();
        
        try {
            // Create booking
            $query = "INSERT INTO HistoryTourBooking 
                      (ScheduleId, Language, TicketType, Seats, TotalPrice) 
                      VALUES (?, ?, ?, ?, ?)";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute([$scheduleId, $language, $ticketType, $seats, $totalPrice]);
            $bookingId = self::$pdo->lastInsertId();
            
            // Update seats booked
            $query = "UPDATE HistoryTourSchedule 
                      SET SeatsBooked = SeatsBooked + ? 
                      WHERE ScheduleId = ?";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute([$seats, $scheduleId]);
            
            // Commit transaction
            self::$pdo->commit();
            
            return $bookingId;
        } catch (Exception $e) {
            // Rollback transaction on error
            self::$pdo->rollback();
            throw $e;
        }
    }
    
    // Get guide information for a specific schedule
    public function getGuideInfo($scheduleId) {
        $query = "SELECT tg.FullName, tg.ProfileImage 
                  FROM HistoryTourSchedule hts
                  JOIN TourGuide tg ON hts.TourGuideId = tg.TourGuideId
                  WHERE hts.ScheduleId = ?";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$scheduleId]);
        return $stmt->fetch();
    }
    
    // Get available schedules
    public function getScheduleId($date, $time, $language) {
        $query = "SELECT ScheduleId FROM HistoryTourSchedule 
                  WHERE TourDate = ? AND TourTime = ? AND Language = ? 
                  AND (TotalSeats - SeatsBooked) > 0 
                  ORDER BY (TotalSeats - SeatsBooked) DESC 
                  LIMIT 1";
        $stmt = self::$pdo->prepare($query);
        $stmt->execute([$date, $time, $language]);
        $result = $stmt->fetch();
        return $result ? $result['ScheduleId'] : null;
    }

   public function getBookingDetails($bookingId) {
    $query = "SELECT 
        htb.Language, htb.TicketType, htb.Seats, htb.TotalPrice,
        hts.TourDate, hts.TourTime,
        tg.FullName as GuideName, tg.ProfileImage as GuideImage
    FROM HistoryTourBooking htb
    JOIN HistoryTourSchedule hts ON htb.ScheduleId = hts.ScheduleId
    JOIN TourGuide tg ON hts.TourGuideId = tg.TourGuideId
    WHERE htb.BookingId = ?";
    
    $stmt = self::$pdo->prepare($query);
    $stmt->execute([$bookingId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}
?>
