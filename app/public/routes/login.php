<?php

require(__DIR__ . "/../controllers/LoginController.php");

Route::add('/login', function () {
    // homepage is simply loading a static page
    // view the user routes for example following the MVC pattern
    require(__DIR__ . "/../views/pages/login.php");
});

Route::add('/login', function() {

    $controller = new LoginController();

    $controller->Login();
}, 'post');