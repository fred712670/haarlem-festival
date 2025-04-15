<?php

class CartController {
    public function __construct() {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    public function addTicket($ticket) {
        $_SESSION['cart'][] = $ticket;
    }

    public function getTickets() {
        return $_SESSION['cart'];
    }

    public function updateTicketQuantity($index, $quantity) {
        if (isset($_SESSION['cart'][$index])) {
            $_SESSION['cart'][$index]['quantity'] = $quantity;
        }
    }

    public function completeOrder($tickets) {
        if (isset($_SESSION['cart'])) {
            
        }
    }

    public function clearCart() {
    unset($_SESSION['cart']);
    }

}
