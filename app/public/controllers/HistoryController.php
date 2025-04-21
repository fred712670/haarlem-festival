<?php
require_once 'models/HistoryModel.php';

class HistoryController {
    private $model;

    public function __construct() {
        $this->model = new HistoryModel();
    }
    // Fetch all tour guides
    public function getTourGuides() {
        return $this->model->getTourGuides();
    }
    // Fetch tour schedule summary
    public function getTourSchedule() {
        return $this->model->getTourSchedule();
    }
    // Fetch content for a given history section
    public function getHistoryContent($section) {
        return $this->model->getHistoryContent($section);
    }
    // Fetch all history tour locations
    public function getHistoryLocations() {
        return $this->model->getHistoryLocations();
    }
    // Fetch pricing information
    public function getPricing() {
        return $this->model->getPricing();
    }
    // Fetch detailed information for one location
    public function getTourLocationById($locationId) {
        return $this->model->getTourLocationById($locationId);
    }
    // Render the main history overview page
    public function showHistoryPage() {
        $guides = $this->getTourGuides();
        $schedule = $this->getTourSchedule();
        $locations = $this->getHistoryLocations();
        $overviewContent = $this->getHistoryContent('overview');
        $eventDetailContent = $this->getHistoryContent('event_detail');
        $pricing = $this->getPricing();

        require(__DIR__ . "/../views/pages/history.php");
    }
    // Render the reservation form with date/time/language options
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
        // Step 1: Validate the input fields
        $errors = $this->validateBookingInput($postData);
        // If there are validation errors, return them immediately
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }

        try {
            // Step 2: Find a matching schedule slot
            $scheduleId = $this->model->getScheduleId($postData['date'], $postData['time'], $postData['language']);
            // If no slot is available, return an error
            if (!$scheduleId) {
                return ['success' => false, 'errors' => ["No available tour schedule found."]];
            }
            // Step 3: Retrieve pricing info for the chosen date/time
            $priceInfo = $this->model->getPriceInfo($postData['date'], $postData['time']);
            // Step 4: Determine which ticket type was selected
            $ticketType = $postData['ticket_type'];
            // Step 5: Calculate seat count (4 for family deal, else user input)
            $seats = ($ticketType === 'Family Package Deal') ? 4 : (int)$postData['seats'];
            // Step 6: Compute the total price
            $totalPrice = ($ticketType === 'Family Package Deal') ? $priceInfo['FamilyTicketPrice'] : $priceInfo['TicketPrice'] * $seats;
            // Step 7: Create the booking record and decrement availability
            $bookingId = $this->model->createBooking(
                $scheduleId,
                $postData['language'],
                $ticketType,
                $seats,
                $totalPrice
            );
            // Step 8: Fetch guide details for the confirmation
            $guideInfo = $this->model->getGuideInfo($scheduleId);
            // Step 9: Return a success response with all relevant data
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
    // Validate that the 'date' field is present and valid
    private function validateDate($data) {
        $errors = [];
        // Ensure a date was provided
        if (empty($data['date'])) {
            $errors[] = "Date is required.";
            return $errors;
        }
        // Fetch all allowed dates from the model
        $availableDates = array_column($this->model->getAvailableDates(), 'TourDate');
         // Check that the provided date is one of the available ones
        if (!in_array($data['date'], $availableDates)) {
            $errors[] = "The selected date is not available for booking.";
        }
        // 4) Return the list of errors (empty means no issues)
        return $errors;
    }
}
?>
