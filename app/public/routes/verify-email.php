<?php
Route::add('/verify-email', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");
    $userController = new UserController();

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $userController->verifyEmail($token);
    } else {
        echo "No token provided.";
    }
}, 'get');


