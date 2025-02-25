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
    private function checkEmail($email) {
        $sql = "SELECT UserId FROM User WHERE Email = :email";
        $stmt = self::$pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch() !== false;
    }

   // Method to register a new user
   public function register($fullName, $email, $password, $role) {

    if ($this->checkUserName($fullName)) {
        return ['success' => false, 'message' => 'Username already exists'];
    }

    if ($this->checkEmail($email)) {
        return ['success' => false, 'message' => 'Email already exists'];
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO User (FullName, Email, Password, Role) VALUES (:fullName, :email, :password, :role)";
    $stmt = self::$pdo->prepare($sql);
    $stmt->bindParam(':fullName', $fullName);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':role', $role);

    if ($stmt->execute()) {
        return ['success' => true];
    } else {
        return ['success' => false, 'message' => 'Registration failed'];
    }
}
}
?>
