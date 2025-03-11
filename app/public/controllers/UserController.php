<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

require_once(__DIR__ . "/../models/UserModel.php");

class UserController
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }
    // Method to verify captcha
    private function verifyCaptcha($captchaResponse)
    {
        if (empty($captchaResponse)) {
            return false;
        }
        
        $secretKey = '6LevYe4qAAAAACGnKkA5RoWl5nSRIVS7ZQpsWUoO'; 
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secretKey,
            'response' => $captchaResponse
        ];
        
        $options = [
            'http' => [
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data)
            ]
        ];
        
        $context = stream_context_create($options);
        $verify_response = file_get_contents($url, false, $context);
        $response_data = json_decode($verify_response);
        
        return $response_data->success;
    }
    private function validateEmail($email) 
    {
    // Check if email has valid format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    
    // Extract domain from email
    $domain = substr(strrchr($email, "@"), 1);
    
    // Check if domain is valid 
    return checkdnsrr($domain, 'MX');
    }

    // Handle user registration
    public function processRegistration($username, $email, $password, $captchaResponse) {
        $role = 'customer';  
    
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['register_error'] = "All fields are required.";
            header('Location: /registration');
            exit();
        }
    
        try {
            // Validate email format and domain
            if (!$this->validateEmail($email)) {
                throw new Exception("Please enter a valid email address.");
            }
    
            // Verify captcha
            if (!$this->verifyCaptcha($captchaResponse)) {
                throw new Exception("Captcha verification failed.");
            }
    
            // Generate verification token
            $verify_token = bin2hex(random_bytes(16));
            
            // Call user model with the token
            $result = $this->userModel->register($username, $email, $password, $role, $verify_token);
            
            // Handle different registration outcomes
            if ($result['success'] === false) {
               
                if (isset($result['message'])) {
                    throw new Exception($result['message']);
                } else {
                    throw new Exception("Registration failed. Please try again.");
                }
            }
            
            // If we reach here, registration was successful
            // Send verification email
            $this->sendEmailRegister($username, $email, $verify_token);

            $_SESSION['verification_status'] = 'Your account has been created successfully! Please check your email to verify your account.';
            require(__DIR__ . "/../views/pages/verify-email.php");
            exit();
        } catch (Exception $e) {
            $_SESSION['register_error'] = $e->getMessage();
            header('Location: /registration');
            exit();
        }
    }

    function sendEmailRegister($username, $email, $verify_token)
    {
        $mail = new PHPMailer(true);  
        try {
            //Server settings
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'zifengliangtest@gmail.com';              
            $mail->Password   = 'ngfi bndf fajr zlkz';
            $mail->Port       = 465;                        
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
                                               
    
            //Recipients
            $mail->setFrom('zifengliangtest@gmail.com', 'Haarlem Festival');
            // Add a recipient
            $mail->addAddress($email, $username); 
    
            // Content
            // Set email format to HTML
            $mail->isHTML(true);                                       
            $mail->Subject = 'Email Verification from Haarlem Festival';
            $mail->Body    = "Hello $username, <br>Please click on the link below to verify your email address:<br><a href='http://localhost/verify-email?token=$verify_token'> Verify Email</a>";
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            $_SESSION['email_error'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;

        }
    }

    public function verifyEmail($token) {
        $result = $this->userModel->verifyUser($token);
        
        if ($result) {
            // Verification success
            $_SESSION['verification_status'] = 'Email successfully verified. You can now log in.';
        } else {
            // Verification failed
            $_SESSION['verification_status'] = 'The verification link is invalid or has already been used.';
        }
        require(__DIR__ . "/../views/pages/verify-email.php");
        exit();
    }
}
?>
