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
        // Initialize Stripe & your OrderModel once
        Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
        $this->orderModel = new OrderModel();
    }

    /**
     * Kick off (or reuse) a Stripe Checkout session.
     *
     * @param array           $orderResult  ['order'=>…, 'tickets'=>…]
     * @param OrderController $orders       to expire orders if you still need it
     */
    public function createCheckoutSession(): void
{
    $cart   = $_SESSION['cart']   ?? [];
    $userId = $_SESSION['userId'] ?? null;

    if (!$userId || empty($cart)) {
        http_response_code(400);
        exit("Missing user or cart.");
    }

    // Convert your cart into Stripe line_items
    $lineItems = array_map(function(array $item) {
        return [
            'price_data' => [
                'currency'     => 'eur',
                'product_data' => [
                    // adjust these keys to match your cart structure
                    'name' => $item['description'] . ' – ' . $item['ticketType'],
                ],
                'unit_amount'  => (int)($item['price'] * 100),  // must be > 0
            ],
            'quantity' => $item['quantity'],                  // use actual quantity
        ];
    }, $cart);

    // If you somehow ended up with no valid items, bail out early
    if (empty($lineItems)) {
        http_response_code(400);
        exit("Your cart is empty or invalid.");
    }

    // Create the Stripe session with your real items
    $session = Session::create([
        'payment_method_types'       => ['card'],
        'line_items'                 => $lineItems,
        'mode'                       => 'payment',
        'success_url'                => "http://localhost/payment/success?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url'                 => "http://localhost/payment/cancel",
        'metadata'                   => ['user_id' => $userId],
        'phone_number_collection'    => ['enabled' => true],
        'billing_address_collection' => 'required',
    ]);

    header("Location: {$session->url}");
    exit;
}


    /**
     * Handle Stripe’s success redirect.
     *
     * @param OrderController $orders  for any order‐level logic you still need
     */
    public function showSuccessPage(OrderController $orders): void
    {
        $sessionId = $_GET['session_id'] ?? null;
        if (!$sessionId) {
            $message = "Missing session ID.";
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        try {
            $session = Session::retrieve($sessionId, ['expand' => ['customer_details']]);
        } catch (\Exception $e) {
            $message = "Stripe error: " . $e->getMessage();
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        if ($session->payment_status !== 'paid') {
            $message = "Payment not completed (status: {$session->payment_status}).";
            require __DIR__ . '/../views/pages/payment.php';
            return;
        }

        // 1) Mark as paid
        $orderId = $this->orderModel->getOrderIdBySessionId($sessionId);
        $this->orderModel->markOrderAsPaid($orderId);

        // 2) Store customer details
        $cust = $session->customer_details;
        $address = $cust->address
            ? "{$cust->address->line1}, {$cust->address->postal_code}, {$cust->address->city}, {$cust->address->country}"
            : null;
        $this->orderModel->grabContactDetails($orderId, $cust->phone, $address);

        // 3) Render the success view (PDFs & cart‐clearing are still handled by your coordinator)
        $view    = 'payment_success';
        $status  = 'success';
        $message = 'Thank you! Your order has been confirmed.';
        require __DIR__ . '/../views/pages/payment.php';
    }

    /**
     * Handle Stripe’s cancel redirect.
     *
     * @param OrderController $orders  to inspect current order status if needed
     */
    public function showCancelPage(OrderController $orders): void
    {
        $orderId = $_GET['order_id'] ?? null;
        $order   = $orderId ? $this->orderModel->getOrderById($orderId) : null;

        $status  = ($order && $order['Status'] === 'pending') ? 'notice' : 'error';
        $message = $status === 'notice'
            ? 'Payment cancelled—your reservation is still held.'
            : 'Your payment was cancelled.';

        $view = 'payment_cancel';
        require __DIR__ . '/../views/pages/payment.php';
    }

    public function storeStripeSessionId(int $orderId, string $sessionId): void
    {   
        $this->orderModel->setStripeSessionId($orderId, $sessionId);
    }
}
