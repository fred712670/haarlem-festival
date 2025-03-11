<?php
Route::add('/registration', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");
       
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the reCAPTCHA response directly from POST data
        $captchaResponse = $_POST['g-recaptcha-response'] ?? null; 
        
        // Handle registration form submission
        $userController = new UserController();
        $userController->processRegistration($_POST['username'], $_POST['email'], $_POST['password'], $captchaResponse);
    } else {
        // Display the registration form view
        require(__DIR__ . "/../views/pages/registration.php");
    }
}, ["get", "post"]);
?>
