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
    public function login($username): array
    {
        $stmt = self::$pdo->prepare("SELECT * FROM User WHERE FullName = :username");  // Prepare SQL to fetch user by username
        $stmt->execute(['username' => $username]);  // Execute the SQL query with the entered username
        return $stmt->fetch();  // Fetch the user record from the database
    }


    public function get($id)
    {
        $pdo = self::$pdo; 

        if (empty($id) || !is_numeric($id)) {
            return false;
        }
    
        // Prepare the SQL statement using PDO
        $stmt = $pdo->prepare("SELECT UserId, FullName, Email, Role FROM User WHERE UserId = :userId");
    
        // Bind parameters to the prepared statement using PDO's bindParam
        $stmt->bindParam(':userId', $id, PDO::PARAM_INT);
    
        // Execute the statement
        if ($stmt->execute()) {
            // Fetch result
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            // Return user data if found, else return false
            return $user ? $user : false;
        } else {
            return false; 
        }
    }

    public function updateName($username, $newFullName): bool {
        $pdo = self::$pdo; 

        if (empty($newFullName) || strlen($newFullName) < 5 || strlen($newFullName) > 20) {
            return false;
        }

        // Prepare the SQL statement using PDO
        $stmt = $pdo->prepare("UPDATE User SET FullName = ? WHERE FullName = ?");

        // Bind parameters to the prepared statement using PDO's bindParam
        $stmt->bindParam(1, $newFullName); 
        $stmt->bindParam(2, $username); 

        // Execute the statement and return true on success
        return $stmt->execute();
    }


    public function updateEmail($userId, $newEmail): bool {
        $pdo = self::$pdo;
    
        // Validate the newEmail input
        if (empty($newEmail) || !filter_var($newEmail, FILTER_VALIDATE_EMAIL) || strlen($newEmail) > 255) {
            return false; // Return false if the new email is not valid
        }
    
        // Prepare the SQL statement using PDO
        $stmt = $pdo->prepare("UPDATE User SET Email = :newEmail WHERE UserId = :userId");
    
        // Bind parameters to the prepared statement using PDO's bindParam
        $stmt->bindParam(':newEmail', $newEmail, PDO::PARAM_STR);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    
        // Execute the statement and return true on success
        return $stmt->execute();
    }
    
    /*public function updatePassword(string $username, string $newPasword) 
    {
        $stmt = self::$pdo->prepare("UPDATE User SET password = :new_password WHERE FullName = :username");
        $stmt->execute(['username' => $username, 'new_password' => $newPasword]);
    }*/

    public function updatePassword($userId, $currentPswd, $newPswd, $repeatNewPswd): bool {
        $pdo = self::$pdo;
    
        if (empty($currentPswd) || empty($newPswd) || empty($repeatNewPswd)) {
            return false;
        }
        if (strlen($currentPswd) < 5 || strlen($newPswd) < 5 || strlen($repeatNewPswd) < 5) {
            return false;
        }
        if ($newPswd !== $repeatNewPswd) {
            return false;
        }
        // Fetch the current password hash from the database using PDO
        $stmt = $pdo->prepare("SELECT Password FROM User WHERE UserId = ?");
        $stmt->bindParam(1, $userId);
        $stmt->execute();
    
        if ($stmt->rowCount() == 0) {
            return false; // No user found
        }
    
        $hashedCurrentPswd = $stmt->fetchColumn();
    
        // Verify the current password with the hashed password from the database
        if (!password_verify($currentPswd, $hashedCurrentPswd)) {
            return false;
        }
    
        $hashedNewPswd = password_hash($newPswd, PASSWORD_DEFAULT);
    
        // Update the password in the database using PDO
        $stmt = $pdo->prepare("UPDATE User SET Password = ? WHERE UserId = ?");
        $stmt->bindParam(1, $hashedNewPswd);
        $stmt->bindParam(2, $userId);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail($email) {
        $sql = "SELECT * FROM User WHERE Email = ?";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function storeResetToken($email, $token_hash, $expiry) {
        $sql = "UPDATE User SET ResetToken = ?, ResetTokenExpires = ? WHERE Email = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$token_hash, $expiry, $email]);
    }
    
    public function getUserByResetToken($token_hash)
    {
        $sql = "SELECT * FROM User WHERE ResetToken = ? AND ResetTokenExpires > NOW()";
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute([$token_hash]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateResetPassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $sql = "UPDATE User SET password = ?, ResetToken = NULL, ResetTokenExpires = NULL WHERE UserId = ?";
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute([$hashedPassword, $userId]);
    }
}

?>

