<?php
// controllers/PaymentController.php

require_once __DIR__ . '/../models/OrderModel.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class PaymentController
{
    private OrderModel $orderModel;

    public function __construct()
    {
        // Initialize Stripe and the OrderModel
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        $this->orderModel = new OrderModel();
    }

    // Create a Stripe Checkout session based on the current cart.
    // Will redirect the user to Stripe's hosted payment page.
    public function createCheckoutSession(): void
    {
        $cart   = $_SESSION['cart']   ?? [];
        $userId = $_SESSION['userId'] ?? null;

        if (!$userId || empty($cart)) {
            http_response_code(400);
            exit("Missing user or cart.");
        }

        // Convert cart items to Stripe-compatible line items
        $lineItems = array_map(function (array $item) {
            return [
                'price_data' => [
                    'currency'     => 'eur',
                    'product_data' => [
                        'name' => $item['description'] . ' – ' . $item['ticketType'],
                    ],
                    'unit_amount'  => (int)($item['price'] * 100),  // Stripe expects amount in cents
                    'tax_behavior' => 'exclusive',
                ],
                'quantity' => $item['quantity'],
            ];
        }, $cart);

        // Fail early if line items are malformed or empty
        if (empty($lineItems)) {
            http_response_code(400);
            exit("Your cart is empty or invalid.");
        }

        // Create the actual Stripe checkout session
        $session = Session::create([
            'payment_method_types'       => ['card'],
            'line_items'                 => $lineItems,
            'mode'                       => 'payment',
            'automatic_tax'              => ['enabled' => true],
            'success_url'                => "http://localhost/payment/success?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url'                 => "http://localhost/payment/cancel?session_id={CHECKOUT_SESSION_ID}",
            'metadata'                   => ['user_id' => $userId],
            'phone_number_collection'    => ['enabled' => true],
            'billing_address_collection' => 'required',
        ]);

        // Redirect user to Stripe-hosted checkout page
        header("Location: {$session->url}");
        exit;
    }

    // Handle Stripe's success redirect.
    // Marks the order as paid, stores contact info, and shows success message.
    public function showSuccessPage(OrderController $orders): void
    {
        $sessionId = $_GET['session_id'] ?? null;
        if (!$sessionId) {
            $message = "Missing session ID.";
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        try {
            // Retrieve Stripe session and expand customer details
            $session = Session::retrieve($sessionId, ['expand' => ['customer_details']]);
        } catch (\Exception $e) {
            $message = "Stripe error: " . $e->getMessage();
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        // Check payment status
        if ($session->payment_status !== 'paid') {
            $message = "Payment not completed (status: {$session->payment_status}).";
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        // Mark the order as paid in the database
        $orderId = $this->orderModel->getOrderIdBySessionId($sessionId);
        $this->orderModel->markOrderAsPaid($orderId);

        // Show success message (PDF handling done via coordinator)
        $view    = 'payment_success';
        $status  = 'success';
        $message = 'Thank you! Your order has been confirmed.';
        require __DIR__ . '/../views/pages/payment.php';
    }

    // Handle Stripe's cancel redirect.
    public function showCancelPage(OrderController $orders): void
    {
        $orderId = $_GET['order_id'];
        $order   = $orderId ? $this->orderModel->getOrderById($orderId) : null;

        $status = 'error';
        $message = 'Your payment was cancelled. It will be reserved for 24 hours.';

        $view = 'payment_cancel';
        require __DIR__ . '/../views/pages/payment.php';
    }

    // Save the Stripe session ID to the order in the database.
    public function storeStripeSessionId(int $orderId, string $sessionId): void
    {
        $this->orderModel->setStripeSessionId($orderId, $sessionId);
    }    
}
