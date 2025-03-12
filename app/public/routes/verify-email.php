<?php
Route::add('/verify-email', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");
    
    $userController = new UserController();
    
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $userController->verifyEmail($token);
    } else {
        $_SESSION['verification_status'] = 'No verification token provided.';
        require(__DIR__ . "/../views/pages/verify-email.php");
    }
}, 'get');

