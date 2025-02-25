<?php

// require the user controller so we can use it in this file
require_once(__DIR__ . "/../controllers/UserController.php");

// any request for the /users route will be handled by this function
Route::add('/users', function () {
    $userController = new UserController(); // create a new user controller
    $users = $userController->getAll(); // get data data for the view
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

Route::add('/profile/edit', function()  {
    //$userController = new UserController();
    //$user = $userController->get($_SESSION['userId']);
    require_once(__DIR__ . '/../views/pages/profileEdit.php');
}, 'get');

Route::add('/profile/update/name', function() {
    //$username = filter_var($_SESSION["username"]);
    $username = "John Doe";
    $newFullName = $_POST['fullName'] ?? '';
    //$message = "";

    $userController = new UserController();
    if ($userController->updateName($username, $newFullName)) {
        $message = "Name updated successfully!";
    } else {
        $message = "Failed to update name, make sure the name contains at least 5 characters.";
    }
    $user = $userController->get($_SESSION['userId']);
    require_once(__DIR__ . '/../views/pages/profileEdit.php');
}, 'post');


Route::add('/profile/update/email', function() {

    //$userId = $_SESSION['userId']; // Ensure the user is authenticated and has an ID in the session

    $currentEmail = $_POST['currentEmail'] ?? '';
    $newEmail = $_POST['newEmail'] ?? '';
    $confirmEmail = $_POST['confirmEmail'] ?? '';

    $userController = new UserController();

    // Message initialization
    $message = "";
    // Check if new email matches the confirmed email
    if ($newEmail !== $confirmEmail) {
        $message = "New email and confirm email do not match.";
    } else {
        // Proceed with updating the email if they match
        if ($userController->updateEmail($userId, $currentEmail, $newEmail)) {
            $message = "Email updated successfully!";
        } else {
            $message = "Failed to update email. Make sure the new email is valid and not already in use.";
        }
    }
    // Fetch the updated user data
    $user = $userController->get(id: $userId);

    // Store message in session or pass along in some way
    $_SESSION['message'] = $message;

    // Redirect back to the profile edit page or include it directly
    require_once(__DIR__ . '/../views/pages/profileEdit.php');
}, method: 'post');

