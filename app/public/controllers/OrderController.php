<?php
require_once 'models/OrderModel.php';

class OrderController {
    public function createOrder() {
        if (empty($_SESSION['cart']) || empty($_SESSION['userId'])) {
            die("❌ Order or User not available.");
        }

        $orderModel = new OrderModel();
        $cart = $_SESSION['cart'];
        $userId = $_SESSION['userId'];

        // Get phone/address from POST
        $phone = $_POST['phone'] ?? null;
        $address = $_POST['address'] ?? null;

        // Create order
        $orderId = $orderModel->createOrder($cart, $userId, $phone, $address);

        // Clear cart
        unset($_SESSION['cart']);

        // Redirect
        header("Location: /thank-you?orderId=$orderId");
        exit;
    }


    public function getUserOrders(){
        $userId = $_SESSION['userId'];
        $orderModel = new OrderModel();
        return $orderModel->getUserOrders($userId);
    }
}