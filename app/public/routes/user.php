<?php

// require the user controller so we can use it in this file
require_once(__DIR__ . "/../controllers/UserController.php");
require_once(__DIR__ . "/../controllers/OrderController.php");

// any request for the /users route will be handled by this function
Route::add('/users', function () {
    $userController = new UserController(); // create a new user controller
    //$users = $userController->getAll(); // get data data for the view
    require_once(__DIR__ . "/../views/pages/users.php"); // load the view
});

// any request for a specific user will be handled by this route, i.e. /user/2
// the dynamic part of the url path gets passed in as the $userId variable
Route::add('/user/([a-z-0-9-]*)', function ($userId) {
    $userController = new UserController(); // create a new user controller
    $user = $userController->get($userId); // get data for the view
    require_once(__DIR__ . "/../views/pages/user.php"); // load the view
});



// PROFILE EDITING

Route::add('/profile', function()  {
    if (isset($_SESSION['userId'])){
        $userController = new UserController();
        $user = $userController->get($_SESSION['userId']);

        $orderController = new OrderController();
        $orders = $orderController->getUserOrders($_SESSION['userId']);
        
        require_once(__DIR__ . '/../views/pages/profile.php');
    } else {
        header("Location: /login");
    }
}, 'get');


Route::add('/profile/update/name', function() {
    $username = filter_var($_SESSION["username"]);
    $newFullName = $_POST['fullName'] ?? '';
    $userController = new UserController();

    if ($userController->updateName($username, $newFullName)) {
        $nameValidation = "Name updated successfully!";
    } else {
        $nameValidation = "Failed to update name, make sure the name contains at least 5 characters.";
    }
    
    $user = $userController->get(1);
    require_once(__DIR__ . '/../views/pages/profileEdit.php');
}, 'post');


Route::add('/profile/update/email', function() {

    //$userId = $_SESSION['userId']; // Ensure the user is authenticated and has an ID in the session

    $currentEmail = $_POST['currentEmail'] ?? '';
    $newEmail = $_POST['newEmail'] ?? '';
    $confirmEmail = $_POST['confirmEmail'] ?? '';

    $userController = new UserController();

    // Check if new email matches the confirmed email
    if ($newEmail !== $confirmEmail) {
        $emailValidation = "New email and confirm email do not match.";
    } else {
        if ($userController->updateEmail(1, $newEmail)) {
            $emailValidation = "Email updated successfully!";
        } else {
            $emailValidation = "Failed to update email. Make sure the new email is valid and not already in use.";
        }
    }
    // Fetch the updated user data
    $user = $userController->get(id: $_SESSION['userId']);

    //$_SESSION['message'] = $message;

    // Redirect back to the profile edit page or include it directly
    require_once(__DIR__ . '/../views/pages/profile.php');
}, method: 'post');


Route::add('/profile/update/password', function() {
    //$username = filter_var($_SESSION["username"]); 
    $username = 1; 
    $currentPswd = $_POST['inpCurrentPsw'] ?? '';
    $newPswd = $_POST['inpNewPsw'] ?? '';
    $repeatNewPsw = $_POST['inpRepeatNewPsw'] ?? '';

    $userController = new UserController();

    if($userController->changePassword($username, $currentPswd, $newPswd, $repeatNewPsw)){
        $passwordValidation = "Password changed successfully!";
    }
    else{
        $passwordValidation = "Error! Current password is incorrect or new password does not meet the standards!";
    }

    $user = $userController->get(1);
    require_once(__DIR__ . '/../views/pages/profileEdit.php');
    
    /*if ($userController->changePassword($username, $currentPswd, $newPswd, $repeatNewPsw)) {
        header("Location: /logout");
    } else {
        $error = "Error! Current password is incorrect or new password does not meet the standards!";
        $user = $userController->get($_SESSION['userId']);
        require_once(__DIR__ . '/../views/pages/profileEdit.php');
    }*/
}, 'post');

/*Route::add('/profile/updateImage', function() {
    $userController = new UserController();
    $userController->updateProfileImage();
    header('Location: /profile/edit');
}, 'post');*/




// -- Forgot Password Routes --

// Forgot Password Page (Displays form)
Route::add('/forgot-password', function () {
    require_once __DIR__ . '/../views/pages/forgot-password.php';
}, 'get');

// Send Reset Password Link (Handles form submission)
Route::add('/send-password-reset', function () {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = $_POST["email"] ?? "";
        $response = UserController::sendResetLink($email);
        echo $response; // Return success/error message
    } else {
        die("❌ Invalid request method.");
    }
}, 'post');

// Reset Password Page (Displays form)
Route::add('/reset-password', function () {
    require_once __DIR__ . '/../models/UserModel.php';
    $userModel = new UserModel();
    
    $token = $_GET["token"] ?? null;
    if (!$token) {
        die("❌ No token provided in the URL.");
    }

    $tokenHash = hash("sha256", $token);
    $user = $userModel->getUserByResetToken($tokenHash);

    if (!$user) {
        die("❌ Token not found or expired.");
    }

    // Make $token available in the view
    $_SESSION['reset_token'] = $token;
    require_once __DIR__ . '/../views/pages/reset-password.php';
}, 'get');

// Process Reset Password (Handles form submission)
Route::add('/process-reset-password', function () {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $token = $_POST["token"] ?? null;
        $newPassword = $_POST["password"] ?? null;

        if (!$token || !$newPassword) {
            die("❌ Invalid request.");
        }
        
        $response = UserController::processResetPassword($token, $newPassword);
        echo $response; // Return success/error message
    } else {
        die("❌ Invalid request method.");
    }
}, 'post');


Route::add('/logout', function () {
	$_SESSION = [];
	session_destroy();
	header("Location: /");
	exit;
}, 'post');
?>