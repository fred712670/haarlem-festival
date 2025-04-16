<?php

require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/PaymentController.php';
require_once __DIR__ . '/../controllers/OrderController.php';

// Create Stripe Checkout Session
Route::add('/payment/create-checkout-session', function () {
    $controller = new PaymentController();
    $controller->createCheckoutSession();
}, 'post');

// Success Redirect
Route::add('/payment/success', function () {
    $controller = new PaymentController();
    $controller->showSuccessPage(); // handles Stripe session validation + output
}, 'get');

// Cancel Redirect
Route::add('/payment/cancel', function () {
    $controller = new PaymentController();
    $controller->showCancelPage(); // shows limited-time hold message
}, 'get');