<?php
class ReservationController {
    public function __construct() {
        // Initialize cart in session if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    public function createReservation($data) {
        // Validate required fields
        if (empty($data['name']) || empty($data['price'])) {
            $_SESSION['error'] = "Missing required information for reservation";
            return false;
        }

        // For day passes, extract date from selectedDay
        $date = isset($data['date']) ? $data['date'] : '';
        
        // If this is a day pass submission with a selectedDay
        if (isset($data['ticketType']) && $data['ticketType'] === 'DayPass' && isset($data['selectedDay'])) {
            $date = $data['selectedDay']; // Use the selected day's date
        }

        // Create reservation item
        $item = [
            'eventId' => $data['eventId'] ?? null,
            'description' => $data['name'] ?? '',
            'location' => $data['address'] ?? '',
            'dateTime' => $date . ' ' . ($data['time'] ?? ''),
            'price' => (float)($data['price'] ?? 0),
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