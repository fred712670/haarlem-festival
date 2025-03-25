<?php
Route::add('/registration', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");
       
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the reCAPTCHA response directly from POST data
        $captchaResponse = $_POST['g-recaptcha-response'] ?? null; 
        
        // Handle registration form submission
        $userController = new UserController();
        $result = $userController->processRegistration(
            $_POST['username'], 
            $_POST['email'], 
            $_POST['password'], 
            $captchaResponse
        );
        
        if ($result['success']) {
            // Registration successful
            $_SESSION['verification_status'] = $result['message'];
            require(__DIR__ . "/../views/pages/verify-email.php");
            exit();
        } else {
            // Registration failed - instead of redirecting, store error and show the form again
            $_SESSION['register_error'] = $result['message'];
            require(__DIR__ . "/../views/pages/registration.php");
            exit();
        }
    } else {
        // Display the registration form view
        require(__DIR__ . "/../views/pages/registration.php");
    }
}, ['get', 'post']);
