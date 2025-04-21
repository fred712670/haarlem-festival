<?php

class LoginController
{
    public function login()
    {
        $userModel = new UserModel();
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $user = $userModel->login($username);

        if ($user && password_verify($password, $user['Password'])) {
            // Store all necessary session variables
            $_SESSION['user'] = $user['FullName'];
            $_SESSION['userId'] = $user['UserId'];
            $_SESSION['role'] = $user['Role'];
            $_SESSION['email'] = $user['Email'];
            
            // Redirect based on role
            if (strtolower($_SESSION['role']) === 'admin') {
                header('Location: /admin/dashboard');
            } else {
                header('Location: /');
            }
            exit();
        } else {
            $error = "Your login credentials are incorrect.";
            require(__DIR__ . "/../views/pages/login.php");
        }   
    }
}
?>