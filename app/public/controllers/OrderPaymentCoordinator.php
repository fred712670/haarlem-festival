<?php
// controllers/OrderPaymentCoordinator.php

require_once __DIR__ . '/OrderController.php';
require_once __DIR__ . '/PaymentController.php';

class OrderPaymentCoordinator
{
    private OrderController   $orders;
    private PaymentController $payment;

    public function __construct(
        OrderController   $orders,
        PaymentController $payment
    ) {
        $this->orders  = $orders;
        $this->payment = $payment;
    }

    /* Begins Stripe process, no DB yet */

    public function beginCheckoutProcess(): void
    {
        $this->payment->createCheckoutSession();
    }

    /**
     * Stripe says “paid” → NOW insert into DB, generate docs, clear cart, render view.
     */
    public function handleSuccess(): void
    {
        // 1) Create the real order (and tickets), _then_ PDF + invoice + cart clear:
        $orderResult = $this->orders->createOrder();

        $orderId = $orderResult['order']['OrderId'] ?? null;
        $sessionId = $_GET['session_id'] ?? null;

        // 2) Store the Stripe session ID on that newly minted order:
        $this->payment->storeStripeSessionId($orderId, $sessionId);
        // 3) Mark it paid & store contact details (this will die if not paid, so we know it is)
        $this->payment->showSuccessPage($this->orders);

        // 4) Done — PDFs and cart‑clearing already happened in createOrder()
    }

    public function handleCancel(): void
    {
        $this->orders->createOrder();

        $this->payment->showCancelPage($this->orders);
    }
}
