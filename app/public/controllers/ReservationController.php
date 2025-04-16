<?php
class ReservationController {
    public function __construct() {
        // Initialize cart in session if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    public function createReservation($data) {
        
        // Initialize variables
        $eventId = null;
        $date = null;
        $price = null;

        // If this is a History Tour, use the HistoryModel to get the eventId.
        if ($data['name'] === 'History Tour') {
            $historyModel = new HistoryModel();
            $eventId = $historyModel->getHistoryTourEventId($data['date'], $data['time'], $data['language']);
            $date = $data['date'] . ' ' . $data['time'];
            $price = $data['price'];
        } else {
            // Otherwise, handle based on ticketType.
            if ($data['ticketType'] === 'DayPass') {
                $eventId = null;
                $date = $data['date'];
                $price = $data['price'];
            } else if ($data['ticketType'] === 'WeekendPass') {
                $eventId = null;
                $date = null;
                $price = $data['price'];
            } else {
                // For non-history SingleUse, take eventId from POST data.
                $eventId = $data['eventId'];
                $date = $data['date'] . ' ' . $data['time'];
                $price = $data['price']; 
            }
        }

        // Create reservation item
        $item = [
            'eventId' => $eventId,
            'description' => $data['name'] ?? '',
            'location' => $data['address'] ?? '',
            'dateTime' => $date,
            'price' => $price,
            'ticketType' => $data['ticketType'] ?? '',
            'quantity' => (int)($data['guests'] ?? 1)
        ];

        // Add to cart session
        $_SESSION['cart'][] = $item;
        
        return true;
    }

    public function updateQuantity($index, $action) {
        if (isset($_SESSION['cart'][$index])) {
            if ($action === 'add') {
                // Increase quantity (max 20)
                if ($_SESSION['cart'][$index]['quantity'] < 20) {
                    $_SESSION['cart'][$index]['quantity']++;
                }
            } elseif ($action === 'subtract') {
                // Decrease quantity (min 1)
                if ($_SESSION['cart'][$index]['quantity'] > 1) {
                    $_SESSION['cart'][$index]['quantity']--;
                }
            }
        }
    }

    public function deleteItem($index) {
        if (isset($_SESSION['cart'][$index])) {
            // Remove the item from the cart
            array_splice($_SESSION['cart'], $index, 1);
        }
    }
}