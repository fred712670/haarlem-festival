<?php
require_once 'models/OrderModel.php';

class OrderController {

    public function createOrder(){
        $orderModel = new OrderModel();
        $order = $_SESSION['cart'];

        $orderModel->createOrder($order);

    }

}