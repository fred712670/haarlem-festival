<?php
Route::add('/registration', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the reCAPTCHA response directly from POST data
        $captchaResponse = $_POST['g-recaptcha-response'] ?? null;  // Ensuring the captcha response exists

        // Handle registration form submission
        $userController = new UserController();
        try {
            $userController->processRegistration($_POST['username'], $_POST['email'], $_POST['password'], $captchaResponse);
            header('Location: /login');
            exit();
        } catch (Exception $e) {
            $_SESSION['register_error'] = $e->getMessage();
            header('Location: /registration');
            exit();
        }
    } else {
        // Display the registration form view
        require(__DIR__ . "/../views/pages/registration.php");
    }
}, ["get", "post"]);

