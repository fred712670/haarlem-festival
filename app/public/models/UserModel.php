<?php

require_once(__DIR__ . "/BaseModel.php");

class UserModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAll()
    {
        // demo, this would normally come from the database
        return [
            [
                "id" => 1,
                "email" => "foo@foo.com",
                "username" => "foo_user"
            ],
            [
                "id" => 2,
                "email" => "bar@bar.com",
                "username" => "bar_user"
            ],
        ];
    }

    public function get($id)
    {
        // demo, this would normally come from the database
        return             [
            "id" => 2,
            "email" => "bar@bar.com",
            "username" => "bar_user"
        ];
    }

    public function updateName($username, $newFullName): bool {
        $pdo = BaseModel::getPdo(); 

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

    public function updatePassword($username, $currentPswd, $newPswd, $repeatNewPswd): bool {
        $pdo = BaseModel::getPdo();
    
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
        $stmt = $pdo->prepare("SELECT Password FROM Users WHERE Username = ?");
        $stmt->bindParam(1, $username);
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
        $stmt = $pdo->prepare("UPDATE Users SET Password = ? WHERE Username = ?");
        $stmt->bindParam(1, $hashedNewPswd);
        $stmt->bindParam(2, $username);
    
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
}
