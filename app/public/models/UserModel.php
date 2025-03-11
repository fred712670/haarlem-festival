<?php

require_once(__DIR__ . "/BaseModel.php");

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

   // Fetch user by username
   public function getUserByUsername($fullName)
   {
       $sql = "SELECT * FROM User WHERE FullName = :fullName";
       $stmt = self::$pdo->prepare($sql); 
       $stmt->bindParam(':fullName', $fullName);
       $stmt->execute();
       return $stmt->fetch(PDO::FETCH_ASSOC);
   }

   // Verify password
   public function verifyPassword($inputPassword, $storedPassword)
   {
       return password_verify($inputPassword, $storedPassword);
   }

    // Method to check if the name already exists
    private function checkUserName($fullName) {
        $sql = "SELECT UserId FROM User WHERE FullName = :fullName";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

    // Method to check if the email already exists
    private function checkEmail($email) 
    {
        $sql = "SELECT UserId FROM User WHERE Email = :email";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }
   
    public function register($fullName, $email, $password, $role, $verify_token) 
    {
        // Check if username exists
        if ($this->checkUserName($fullName)) {
            return ['success' => false, 'message' => 'Username already exists'];
        }
        
        // Check if email exists
        if ($this->checkEmail($email)) {
            return ['success' => false, 'message' => 'Email already exists'];
        }
        
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        
        $sql = "INSERT INTO User (FullName, Email, Password, Role, verify_token, verify_status)
                VALUES (:fullName, :email, :password, :role, :verify_token, 0)";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':verify_token', $verify_token);
        
        $result = $stmt->execute();
        
        return [
            'success' => $result,
            'verify_token' => $verify_token
        ];
    }
        // Verify user and update verify_status
    public function verifyUser($token) {
        $sql = "SELECT UserId FROM User WHERE verify_token = :verify_token AND verify_status = 0";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':verify_token', $token);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user) {
            $sql = "UPDATE User SET verify_status = 1 WHERE UserId = :userId";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindParam(':userId', $user['UserId']);
            return $stmt->execute();
        }
        return false;
    }
}


