<?php
require_once 'models/HistoryModel.php';

class HistoryController {
    private $model;

    public function __construct() {
        $this->model = new HistoryModel();
    }

    public function getTourGuides() {
        return $this->model->getTourGuides();
    }

    public function getTourSchedule() {
        return $this->model->getTourSchedule();
    }

    public function getHistoryContent($section) {
        return $this->model->getHistoryContent($section);
    }

    public function getHistoryLocations() {
        return $this->model->getHistoryLocations();
    }

    public function getPricing() {
        return $this->model->getPricing();
    }

    public function getTourLocationById($locationId) {
        return $this->model->getTourLocationById($locationId);
    }

    public function showHistoryPage() {
        $guides = $this->getTourGuides();
        $schedule = $this->getTourSchedule();
        $locations = $this->getHistoryLocations();
        $overviewContent = $this->getHistoryContent('overview');
        $eventDetailContent = $this->getHistoryContent('event_detail');
        $pricing = $this->getPricing();

        require(__DIR__ . "/../views/pages/history.php");
    }
    public function showReservationForm() {
        // Get all available dates
        $availableDates = $this->model->getAvailableDates();
    
        // dynamic dropdowns
        $defaultDate = $availableDates[0]['TourDate'] ?? null;
        $availableTimes = $defaultDate ? $this->model->getAvailableTimes($defaultDate) : [];
        $defaultTime = $availableTimes[0]['TourTime'] ?? null;
        $availableLanguages = ($defaultDate && $defaultTime) 
            ? $this->model->getAvailableLanguages($defaultDate, $defaultTime) 
            : [];
    
        // Pass the data to the view
        require(__DIR__ . "/../views/pages/tour_reservation.php");
    }

    // Booking handling
    public function processBooking($postData) {
        $errors = $this->validateBookingInput($postData);

        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            $scheduleId = $this->model->getScheduleId($postData['date'], $postData['time'], $postData['language']);
            if (!$scheduleId) {
                return ['success' => false, 'errors' => ["No available tour schedule found."]];
            }

            $priceInfo = $this->model->getPriceInfo($postData['date'], $postData['time']);
            $ticketType = $postData['ticket_type'];
            $seats = ($ticketType === 'Family Package Deal') ? 4 : (int)$postData['seats'];
            $totalPrice = ($ticketType === 'Family Package Deal') ? $priceInfo['FamilyTicketPrice'] : $priceInfo['TicketPrice'] * $seats;

            $bookingId = $this->model->createBooking(
                $scheduleId,
                $postData['language'],
                $ticketType,
                $seats,
                $totalPrice
            );

            $guideInfo = $this->model->getGuideInfo($scheduleId);

            return [
                'success' => true,
                'bookingId' => $bookingId,
                'guideInfo' => $guideInfo,
                'tourDetails' => [
                    'date' => $postData['date'],
                    'time' => $postData['time'],
                    'language' => $postData['language'],
                    'ticketType' => $ticketType,
                    'seats' => $seats,
                    'totalPrice' => $totalPrice
                ]
            ];
        } catch (Exception $e) {
            return ['success' => false, 'errors' => ["Booking failed: " . $e->getMessage()]];
        }
    }

    // Input validation 
    private function validateBookingInput($data) {
        return $this->validateDate($data);
    }

    private function validateDate($data) {
        $errors = [];

        if (empty($data['date'])) {
            $errors[] = "Date is required.";
            return $errors;
        }

        $availableDates = array_column($this->model->getAvailableDates(), 'TourDate');

        if (!in_array($data['date'], $availableDates)) {
            $errors[] = "The selected date is not available for booking.";
        }

        return $errors;
    }
}
?>
