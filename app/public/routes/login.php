<?php

// Include the LoginController class
require(__DIR__ . "/../controllers/LoginController.php");

// GET /login
// Loads the login page with the login form
Route::add('/login', function () {
    require(__DIR__ . "/../views/pages/login.php");
}, 'get');

// POST /login
// Handles form submission: invokes LoginController to authenticate the user
Route::add('/login', function () {
    $controller = new LoginController();
    $controller->login();
}, 'post');
