<?php

require_once(__DIR__ . "/../models/UserModel.php");

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function get($id){
       $this->userModel->get($id);
    }

    // Method to verify captcha
    private function verifyCaptcha($captchaInput)
    {
        if (!isset($_SESSION['captcha_answer'], $captchaInput) || $captchaInput != $_SESSION['captcha_answer']) {
            throw new Exception("Incorrect captcha input. Please try again.");
        }
        unset($_SESSION['captcha_answer']); 
        unset($_SESSION['captcha_question']);
    }
    
    // Handle user registration
    public function processRegistration($username, $email, $password, $role, $captcha)
    {
       // Validate the input
    if (empty($username) || empty($email) || empty($password) || empty($role)) {
        $_SESSION['register_error'] = "All fields are required.";
        header('Location: /registration');
        exit();
    }

    // Captcha validation
    try {
        $this->verifyCaptcha($captcha);
    } catch (Exception $e) {
        $_SESSION['register_error'] = $e->getMessage();
        header('Location: /registration');
        exit();
    }

    // Attempt to register the new user
    $result = $this->userModel->register($username, $email, $password, $role);
    if ($result['success']) {
        header('Location: /login');
        exit();
    } else {
        $_SESSION['register_error'] = $result['message'];
        header('Location: /registration');
        exit();
    }
}

    public function updateName($username, $newName) {
        return $this->userModel->updateName($username, $newName);
    }
    public function updateEmail($userId, $newEmail) {
        return $this->userModel->updateEmail($userId, $newEmail);
    }

    public function changePassword($username, $currentPswd, $newPswd, $repeatNewPsw ) {
        return $this->userModel->updatePassword($username, $currentPswd, $newPswd, $repeatNewPsw);
    }

}

