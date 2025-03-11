<?php
require_once 'CartModel.php';

class CartModel {
    private $model;

    public function __construct() {
        $this->model = new CartModel();
    }

    public function addToCart($ticket) {
        $this->model->addTicket($ticket);
    }

    public function updateQuantity($index, $quantity) {
        $this->model->updateTicketQuantity($index, $quantity);
        header('Location: cart.php'); // Redirect to the cart view after updating
    }

    /*public function viewCart() {
        $tickets = $this->model->getTickets();
        include 'CartView.php'; // Assuming the cart view is handled by CartView.php
    }*/
}
