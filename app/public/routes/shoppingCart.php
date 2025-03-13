<?php
require_once(__DIR__ . "/../controllers/ReservationController.php");

Route::add('/cart', function()  {

    require_once(__DIR__ . '/../views/pages/shoppingCart.php');
}, 'get');


Route::add('/completeOrder', function()  {

   $cartController = new CartController();


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
