<?php
Route::add('/registration', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");

    // Only start session if it hasn't been started yet
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Handle registration form submission
        $userController = new UserController();
        try {
            $userController->processRegistration($_POST['username'], $_POST['email'], $_POST['password'], $_POST['role'], $_POST['captcha']);
            header('Location: /login');
            exit();
        } catch (Exception $e) {
            $_SESSION['register_error'] = $e->getMessage();
            header('Location: /registration');
            exit();
        }
    } else {
        // Generate a random number for the captcha
        $randomCaptcha = rand(1000, 9999);  
        $_SESSION['captcha_answer'] = $randomCaptcha;
        $_SESSION['captcha_question'] = $randomCaptcha; 
        require(__DIR__ . "/../views/pages/registration.php");
    }
}, ["get", "post"]);
?>
