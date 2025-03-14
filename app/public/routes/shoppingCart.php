<?php
require_once(__DIR__ . "/../controllers/ReservationController.php");

Route::add('/cart', function()  {

    require_once(__DIR__ . '/../views/pages/shoppingCart.php');
}, 'get');


Route::add('/completeOrder', function()  {

   //$cartController = new CartController();
   //header('Location: /cart');

}, 'post');

Route::add('/reserve/restaurant', function() {

    $reservationController = new ReservationController();
    $validation = $reservationController->createReservation($_POST);
    
    if($validation != true){
        //redirect to restaurant and read SESSION ERROR
    }
    else{
        header('Location: /cart');
    }

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