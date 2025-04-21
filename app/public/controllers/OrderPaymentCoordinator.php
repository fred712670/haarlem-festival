<?php
// controllers/OrderPaymentCoordinator.php

require_once __DIR__ . '/OrderController.php';
require_once __DIR__ . '/PaymentController.php';

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
        // 1) Create order and tickets in DB (PDF + cart-clearing included inside createOrder)
        $orderResult = $this->orders->createOrder();

        // 2) Fetch order ID and session ID from Stripe redirect query
        $orderId = $orderResult['order']['OrderId'] ?? null;
        $sessionId = $_GET['session_id'] ?? null;

        // 3) Save the Stripe session ID to the order
        $this->payment->storeStripeSessionId($orderId, $sessionId);

        // 4) Mark order as paid, store customer details, and render the success view
        $this->payment->showSuccessPage($this->orders);

        // 5) PDF and cart clearing were already handled in createOrder, nothing else needed
    }

    // Called when user cancels from Stripe (or closes browser)
    public function handleCancel(): void
    {
        // Create the order anyway so it's held (optional: may depend on business rules)
        $this->orders->createOrder();

        // Render the cancellation view, messaging depends on order status
        $this->payment->showCancelPage($this->orders);
    }
}
