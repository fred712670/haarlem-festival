<?php

Route::add('/cart', function()  {

    require_once(__DIR__ . '/../views/pages/shoppingCart.php');
}, 'get');


Route::add('/completeOrder', function()  {

    $selectedQuantity = $_POST['totalPrice'];
    $ticket = $_SESSION["cart"];
    

    print_r($ticket);
    echo $selectedQuantity;

}, 'post');