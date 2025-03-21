<?php
require_once 'models/HistoryModel.php';

class HistoryController {
    private $model;
    
    public function __construct() {
        $this->model = new HistoryModel();
    }
    
   //handling booking
    public function processBooking($postData) {
        $errors = [];

        // Validate date
        if (empty($postData['date'])) {
            $errors[] = "Date is required.";
        } else {
            $selectedDate = new DateTime($postData['date']);
            $today = new DateTime();
            $today->setTime(0, 0, 0);

            if ($selectedDate < $today) {
                $errors[] = "The selected date cannot be in the past.";
            }
        }

        // Validate time
        if (empty($postData['time'])) {
            $errors[] = "Time is required.";
        }

        // Validate language
        if (empty($postData['language'])) {
            $errors[] = "Language is required.";
        }

        // Validate ticket type
        if (empty($postData['ticket_type'])) {
            $errors[] = "Ticket type is required.";
        }

        // Validate seats for Regular Participant
        if ($postData['ticket_type'] === 'Regular Participant') {
            if (empty($postData['seats'])) {
                $errors[] = "Number of seats is required.";
            } else if ((int)$postData['seats'] < 1 || (int)$postData['seats'] > 12) {
                $errors[] = "Number of seats must be between 1 and 12.";
            }
        }
        // If there are errors, return them
        if (!empty($errors)) {
            return [
                'success' => false,
                'errors' => $errors
            ];
        }
        // Try to process the booking
        try {
            // Get schedule ID
            $scheduleId = $this->model->getScheduleId(
                $postData['date'], 
                $postData['time'], 
                $postData['language']
            );

            if (!$scheduleId) {
                return [
                    'success' => false,
                    'errors' => ["No available tour schedule found."]
                ];
            }

            // Get price information
            $priceInfo = $this->model->getPriceInfo($postData['date'], $postData['time']);
            
            // Calculate total price
            $seats = ($postData['ticket_type'] === 'Family Package Deal') ? 1 : (int)$postData['seats'];
            $totalPrice = ($postData['ticket_type'] === 'Regular Participant') 
                ? $priceInfo['TicketPrice'] * $seats 
                : $priceInfo['FamilyTicketPrice'];

            // Create booking
            $bookingId = $this->model->createBooking(
                $scheduleId, 
                $postData['language'], 
                $postData['ticket_type'], 
                $seats, 
                $totalPrice
            );

            // Get guide information
            $guideInfo = $this->model->getGuideInfo($scheduleId);

            return [
                'success' => true,
                'bookingId' => $bookingId,
                'guideInfo' => $guideInfo,
                'tourDetails' => [
                    'date' => $postData['date'],
                    'time' => $postData['time'],
                    'language' => $postData['language'],
                    'ticketType' => $postData['ticket_type'],
                    'seats' => $seats,
                    'totalPrice' => $totalPrice
                ]
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'errors' => ["Booking failed: " . $e->getMessage()]
            ];
        }
    }
    //get details 
    public function getBookingConfirmationDetails($bookingId) {
        $details = $this->model->getBookingDetails($bookingId);
        
        return $details ? 
            ['success' => true, 'details' => $details] : 
            ['success' => false, 'errors' => ['Booking not found']];
    }
}
?>
