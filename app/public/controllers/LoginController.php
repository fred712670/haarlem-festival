<?php

class LoginController
{
    public function login()
    {
        $userModel = new UserModel();

        $username = trim($_POST['username']);  // Get the entered username and remove extra spaces
        $password = trim($_POST['password']);  // Get the entered password and remove extra spaces

        $user = $userModel->login($username);

        // Debug: Log the user data to see what we're getting
        error_log("Login attempt for: " . $username);
        if ($user) {
            error_log("User found: " . json_encode($user));
        } else {
            error_log("No user found with this username");
        }

        if ($user && password_verify($password, $user['Password'])) {  // Check if user exists and password is correct
            // Store essential user information in session
            $_SESSION['user'] = $user['FullName'];  // Store the username in session
            $_SESSION['userId'] = $user['UserId'];
            header('Location: '. '/'); // Direct user to index page
            exit;
        } else {
            $error = "Your login credentials are incorrect.";
            require(__DIR__ . "/../views/pages/login.php");
            //exit;
        }   
    }
}
?>