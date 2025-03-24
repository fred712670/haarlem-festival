<?php
require_once 'models/OrderModel.php';

class OrderController {
    public function createOrder(){
        $orderModel = new OrderModel();
        $order = $_SESSION['cart'];
        unset($_SESSION['cart']);
        $orderModel->createOrder($order);
    }


    public function getUserOrders(){
        $userId = $_SESSION['userId'];
        $orderModel = new OrderModel();
        return $orderModel->getUserOrders($userId);
    }
}