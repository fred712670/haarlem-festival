<?php

require_once __DIR__ . '/../lib/Route.php';

require_once __DIR__.'/../controllers/OrderPaymentCoordinator.php';

Route::add('/payment/create-checkout-session', function(){
    $co = new OrderPaymentCoordinator(
        new OrderController(),
        new PaymentController()
    );
    $co->beginCheckoutProcess();
}, 'post');

Route::add('/payment/success', function(){
    $co = new OrderPaymentCoordinator(
        new OrderController(),
        new PaymentController()
    );
    $co->handleSuccess();
}, 'get');

Route::add('/payment/cancel', function(){
    $co = new OrderPaymentCoordinator(
        new OrderController(),
        new PaymentController()
    );
    $co->handleCancel();
}, 'get');


