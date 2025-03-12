<?php
class ReservationController {
    public function createReservation($postData) {
        $errors = [];

        if (empty($postData['guests'])) {
            $errors[] = "Number of guests is required.";
        } else if ((int)$postData['guests'] < 1 || (int)$postData['guests'] > 12) {
            $errors[] = "Number of guests must be between 1 and 12.";
        }

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
        //handle special requests at a later stage
        //$specialRequests = $postData['requests'] ?? '';

        if (empty($postData['time'])) {
            $errors[] = "Time selection is required.";
        }

        if (!empty($errors)) {
            $_SESSION['reservationErrors'] = $errors;
            return false; 
        } else {
            $ticket = [
            //'eventId' => rand(100, 999),
            'description' => $postData["restaurantName"],
            'location' => $postData["restaurantAddress"],
            'dateTime' => "Reservation for " . htmlspecialchars($postData['date']) . " at " . htmlspecialchars($postData['time']),
            'price' => 0,
            'quantity' => (int)$postData['guests']
            ];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            //for now, clear the session
            $_SESSION['cart'] = array();
            $_SESSION['cart'][] = $ticket;
            
            return true;
        }


    }
}
