<?php

require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/OrderPaymentCoordinator.php';

// Route for creating a Stripe Checkout session (initiated from a POST request)
Route::add('/payment/create-checkout-session', function() {
    $co = new OrderPaymentCoordinator(
        new OrderController(),
        new PaymentController()
    );
    $co->beginCheckoutProcess(); // Starts the Stripe session (no DB insert yet)
}, 'post');

// Route that Stripe redirects to after successful payment
Route::add('/payment/success', function() {
    $co = new OrderPaymentCoordinator(
        new OrderController(),
        new PaymentController()
    );
    $co->handleSuccess(); // Creates order, marks paid, generates PDFs, clears cart
}, 'get');

// Route that Stripe redirects to after cancellation or failure
Route::add('/payment/cancel', function() {
    $co = new OrderPaymentCoordinator(
        new OrderController(),
        new PaymentController()
    );
    $co->handleCancel(); // Stores a pending order, shows cancel message, clears cart
}, 'get');
