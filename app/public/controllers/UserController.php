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

    public static function sendResetLink($email) {
        $userModel = new UserModel();

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "❌ Invalid email format!";
        }

        $user = $userModel->getUserByEmail($email);
        if (!$user) {
            return "❌ No user found with this email.";
        }

        // ✅ Generate a secure token
        $token = bin2hex(random_bytes(16));
        $token_hash = hash("sha256", $token);
        $expiry = date("Y-m-d H:i:s", time() + 3600); 

        // ✅ Store reset token in DB
        if (!$userModel->storeResetToken($email, $token_hash, $expiry)) {
            return "❌ Failed to store reset token.";
        }

        // ✅ Send reset email
        $baseUrl = $_ENV["APP_URL"] ?? "http://localhost"; 
        $resetLink = "$baseUrl/reset-password?token=" . urlencode($token);
        $mail = require __DIR__ . "/../views/pages/mailer.php";
        $mail->addAddress($email);
        $mail->Subject = "Password Reset Request";
        $mail->Body = "Click <a href=\"$resetLink\">here</a> to reset your password.<br><br>This link expires in 1 hour.";

        try {
            $mail->send();
            return "✅ Reset link sent! Check your inbox.";
        } catch (Exception $e) {
            return "❌ Email error: " . $mail->ErrorInfo;
        }
    }

    public static function processResetPassword($token, $newPassword) {
        $userModel = new UserModel();

        $token_hash = hash("sha256", $token);
        $user = $userModel->getUserByResetToken($token_hash);

        if (!$user) return "❌ Token not found or expired.";
        if (strtotime($user["ResetTokenExpires"]) <= time()) return "❌ Token expired.";

        return $userModel->updateResetPassword($user["UserId"], $newPassword) 
            ? "✅ Password updated successfully! <a href='/login'>Login</a>."
            : "❌ Something went wrong.";
    }
}

