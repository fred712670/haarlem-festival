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
            $_SESSION['userId'] = $user['UserId']; // Store user ID
            $_SESSION['role'] = $user['Role']; // Store the user role
            $_SESSION['email'] = $user['Email']; // Store email
            
            // Debug: Log session data
            error_log("Session data set: " . json_encode($_SESSION));
            
            // Redirect based on role
            if (strtolower($user['Role']) === strtolower('Administrator')) {
                error_log("Redirecting to admin panel");
                header('Location: '. '/admin');
            } else {
                error_log("Redirecting to homepage");
                header('Location: '. '/'); // Direct user to index page 
            }
            exit;
        } else {
            header('Location: '. '/login?error=1'); 
            exit;
        }   
    }
}
?>