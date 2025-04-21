<?php

class LoginController
{
    public function login()
    {
        // Instantiate the user model to access login logic
        $userModel = new UserModel();

        // Trim inputs to remove leading/trailing spaces
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        // Attempt to retrieve user record by username
        $user = $userModel->login($username);

        // If a user was found and the password matches...
        if ($user && password_verify($password, $user['Password'])) {

            // Store essential user data in session for later use
            $_SESSION['user']   = $user['FullName'];
            $_SESSION['userId'] = $user['UserId'];
            $_SESSION['role']   = $user['Role'];
            $_SESSION['email']  = $user['Email'];

            // Redirect the user based on role
            if (strtolower($_SESSION['role']) === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }

            exit(); // Always terminate after header redirect
        } else {
            // Login failed – reload login view with error message
            $error = "Your login credentials are incorrect.";
            require(__DIR__ . "/../views/pages/login.php");
        }
    }
}
?>
