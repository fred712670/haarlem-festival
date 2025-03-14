<?php
Route::add('/verify-email', function () {
    require_once(__DIR__ . "/../controllers/UserController.php");
    
    $userController = new UserController();
    
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        $result = $userController->verifyEmail($token);
        
        // Set verification status based on result
        $_SESSION['verification_status'] = $result['message'];
    } else {
        $_SESSION['verification_status'] = 'No verification token provided.';
    }
    
    // Display verification page
    require(__DIR__ . "/../views/pages/verify-email.php");
}, 'get');
?>

