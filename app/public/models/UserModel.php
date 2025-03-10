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

    public function login($username): array
    {
        $stmt = self::$pdo->prepare("SELECT * FROM User WHERE FullName = :username");  // Prepare SQL to fetch user by username
        $stmt->execute(['username' => $username]);  // Execute the SQL query with the entered username
        return $stmt->fetch();  // Fetch the user record from the database
    }

    public function updatePassword(string $username, string $newPasword) 
    {
        $stmt = self::$pdo->prepare("UPDATE User SET password = :new_password WHERE FullName = :username");
        $stmt->execute(['username' => $username, 'new_password' => $newPasword]);
    }
}
