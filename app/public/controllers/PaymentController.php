<?php

require_once __DIR__ . '/../models/OrderModel.php';
require_once __DIR__ . '/../vendor/autoload.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController {
    private $orderModel;

    public function __construct() {
        $this->orderModel = new OrderModel();
    }

    public function createCheckoutSession() {
        $userId = $_SESSION['userId'] ?? null;
        if (!$userId) {
            http_response_code(403);
            exit("User not authenticated.");
        }

        $orderId = $_POST['orderId'] ?? null;
        if (!$orderId || !is_numeric($orderId)) {
            http_response_code(400);
            exit("Invalid or missing order ID.");
        }

        $order = $this->orderModel->getOrderById($orderId);
        if (!$order || $order['UserId'] != $userId || $order['Status'] !== 'pending') {
            http_response_code(403);
            exit("Unauthorized or invalid order.");
        }

        if (
    $order['Status'] === 'pending' &&
    strtotime($order['OrderDate']) < strtotime('-24 hours')
) {
    $this->orderModel->expireOrder($orderId);
    header("Location: /payment/expired?order_id=$orderId");
    exit;
}


        $tickets = $this->orderModel->getTicketsByOrderId($orderId);
        if (empty($tickets)) {
            http_response_code(400);
            exit("No tickets found for this order.");
        }

        Stripe::setApiKey($_ENV["STRIPE_SECRET_KEY"]);

        $lineItems = array_map(function ($ticket) {
            return [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $ticket['PassType'] . ' - ' . $ticket['EventName']
                    ],
                    'unit_amount' => intval($ticket['Price'] * 100),
                ],
                'quantity' => 1,
            ];
        }, $tickets);

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => "https://localhost/payment/success?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => "https://localhost/payment/cancel?order_id=$orderId",
            'metadata' => [
                'order_id' => $orderId
            ]
        ]);

        $this->orderModel->setStripeSessionId($orderId, $session->id);
        header("Location: " . $session->url);
        exit;
    }

    public function showSuccessPage() {
        $view = 'payment_success';
        $status = 'error';
        $message = 'Unknown error occurred.';
        $sessionId = $_GET['session_id'] ?? null;

        if (!$sessionId) {
            $message = 'Missing session ID.';
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);

        try {
            $session = Session::retrieve($sessionId);
        } catch (Exception $e) {
            $message = 'Error retrieving session: ' . $e->getMessage();
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        if ($session->payment_status !== 'paid') {
            $message = 'Payment not completed. Status: ' . $session->payment_status;
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        $orderId = $this->orderModel->getOrderIdBySessionId($sessionId);
        if (!$orderId) {
            $message = 'No matching order found.';
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        $order = $this->orderModel->getOrderById($orderId);
        if ($order['Status'] !== 'paid') {
            $this->orderModel->markOrderAsPaid($orderId);
        }

        $status = 'success';
        $message = 'Thank you! Your order has been confirmed, and your tickets have been added to your personal program.';
        require __DIR__ . '/../views/pages/payment.php';
    }

    public function showCancelPage() {
        $view = 'payment_cancel';
        $orderId = $_GET['order_id'] ?? null;

        $status = 'error';
        $message = 'Your payment was cancelled.';

        if ($orderId && is_numeric($orderId)) {
            $order = $this->orderModel->getOrderById($orderId);
            if ($order && $order['Status'] === 'pending') {
                $message = 'You cancelled your payment. Your reservation is still being held for a limited time.';
                $status = 'notice';
            }
        }

        require __DIR__ . '/../views/pages/payment.php';
    }

    public function showExpiredPage() {
        $view = 'payment_expired';
        $status = 'error';
        $message = 'Your order has expired because it was not paid in time.';

        require __DIR__ . '/../views/pages/payment.php';
    }
}
