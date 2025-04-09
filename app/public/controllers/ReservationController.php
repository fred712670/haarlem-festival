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

            $price = 0;

            if(isset($postData["price"])){
                $price = $postData["price"];
            }

            $ticket = [
            'eventId' => $postData["eventId"],
            'description' => $postData["name"],
            'location' => $postData["address"],
            'dateTime' => "Reservation for " . htmlspecialchars($postData['date']) . " at " . htmlspecialchars($postData['time']),
            'ticketType' => $postData["ticketType"],
            'price' => $price,
            'quantity' => (int)$postData['guests']
            ];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            //for now, clear the session
            $_SESSION['cart'][] = $ticket;
            
            return true;
        }
    }

    public function deleteItem($index) {
        if (isset($_SESSION['cart'][$index])) {
            array_splice($_SESSION['cart'], $index, 1);
        }
    }

    public function updateQuantity($index, $action) {

        if (isset($_SESSION['cart'][$index])) {
            if ($action === 'add') {
                $_SESSION['cart'][$index]['quantity']++;
            } elseif ($action === 'subtract' && $_SESSION['cart'][$index]['quantity'] > 1) {
                $_SESSION['cart'][$index]['quantity']--;
            }
            $_SESSION['feedback'] = "Quantity updated.";
        } 
    }
}   
