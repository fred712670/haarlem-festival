<?php
// controllers/OrderPaymentCoordinator.php

require_once __DIR__ . '/OrderController.php';
require_once __DIR__ . '/PaymentController.php';

use Stripe\Stripe;
use Stripe\Checkout\Session;

class OrderPaymentCoordinator
{
    private OrderController $orders;
    private PaymentController $payment;

    public function __construct(
        OrderController $orders,
        PaymentController $payment
    ) {
        $this->orders  = $orders;
        $this->payment = $payment;
    }

    // Starts Stripe checkout session; no order/tickets are created yet
    public function beginCheckoutProcess(): void
    {
        $this->payment->createCheckoutSession();
    }

    // Called after Stripe confirms a successful payment
    public function handleSuccess(): void
    {
        // 1) Get Stripe session and customer details
        $sessionId = $_GET['session_id'] ?? null;
        if (!$sessionId) {
            die("Missing session ID from Stripe.");
        }

        try {
            Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
            $session = Session::retrieve($sessionId, ['expand' => ['customer_details']]);
        } catch (\Exception $e) {
            die("Failed to retrieve Stripe session: " . $e->getMessage());
        }

        if ($session->payment_status !== 'paid') {
            die("Payment not completed.");
        }

        // 2) Extract phone and address
        $cust = $session->customer_details;
        $phone = $cust->phone ?? null;
        $address = $cust->address
            ? "{$cust->address->line1}, {$cust->address->postal_code}, {$cust->address->city}, {$cust->address->country}"
            : null;

        // 3) Create order in DB (PDF + cart-clear included inside)
        $_POST['phone'] = $phone;
        $_POST['address'] = $address;
        $orderResult = $this->orders->createOrder();

        // 4) Save Stripe session ID to DB
        $orderId = $orderResult['order']['OrderId'] ?? null;
        $this->payment->storeStripeSessionId($orderId, $sessionId);

        // 5) Show success page
        $this->payment->showSuccessPage($this->orders);
    }

    // Called when user cancels from Stripe (or closes browser)
    public function handleCancel(): void
    {
        // Create the order anyway so it's held (optional: may depend on business rules)
        $this->orders->createOrder();

        // Render the cancellation view
        $this->payment->showCancelPage($this->orders);
    }
}
