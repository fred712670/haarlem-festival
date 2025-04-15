<?php

require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/PaymentController.php';

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

// Expired Redirect
Route::add('/payment/expired', function () {
    $controller = new PaymentController();
    $controller->showExpiredPage(); // informs user the hold has lapsed
}, 'get');

// Stripe Redirect Bridges
Route::get('/stripe-redirect/success', function () {
    $sessionId = $_GET['session_id'] ?? null;
    if (!$sessionId) {
        http_response_code(400);
        exit("Missing session ID.");
    }
    header("Location: /payment/success?session_id=" . urlencode($sessionId));
    exit;
});

Route::get('/stripe-redirect/cancel', function () {
    $orderId = $_GET['order_id'] ?? null;
    if (!$orderId) {
        http_response_code(400);
        exit("Missing order ID.");
    }
    header("Location: /payment/cancel?order_id=" . urlencode($orderId));
    exit;
});

