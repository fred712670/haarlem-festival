<?php
require_once(__DIR__ . "/../controllers/ReservationController.php");
require_once(__DIR__ . "/../controllers/OrderController.php");

Route::add('/cart', function()  {

    require_once(__DIR__ . '/../views/pages/shoppingCart.php');
}, 'get');


Route::add('/create/order', function()  {
    $orderController = new OrderController();
    //print_r($_SESSION['cart']);

    $orderController->createOrder();
    
    header('Location: /profile');
});

Route::add('/reserve', function() {

    //print_r($_POST);

    $reservationController = new ReservationController();
    $validation = $reservationController->createReservation($_POST);
    
    if($validation != true){
        //redirect to restaurant and read SESSION ERROR
    }
    else{
        header('Location: /cart');
    };

}, 'post');


Route::add('/updateQuantity', function() {
    $reservationController = new ReservationController();
    $reservationController->updateQuantity($_POST['index'], $_POST['action']);
    header('Location: /cart');
}, 'post');

Route::add('/deleteItem', function() {
    $reservationController = new ReservationController();
    $reservationController->deleteItem($_POST['itemIndex']);
    header('Location: /cart');
}, 'post');

Route::add('/payment', function () {
    require_once __DIR__ . '/../views/pages/payment.php';
}, 'get');

Route::add('/process-payment', function () {
    require_once __DIR__ . '/../controllers/OrderController.php';
    $controller = new OrderController();
    $controller->createOrder();
}, 'post');
