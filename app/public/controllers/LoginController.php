<?php

class LoginController
{

    public function login()
    {
        $userModel = new UserModel();

        $username = trim($_POST['username']);  // Get the entered username and remove extra spaces
        $password = trim($_POST['password']);  // Get the entered password and remove extra spaces

        $user = $userModel->login($username);

        if ($user && password_verify($password, $user['Password'])) {  // Check if user exists and password is correct
            $_SESSION['user'] = $user['FullName'];  // Store the username in session
            $_SESSION['userId'] = $user['UserId'];
            header('Location: '. '/'); // Direct user to index page
            exit;
        } else {
            header('Location: '. '/login?error=1'); 
            exit;
        }   
    }
}
?>