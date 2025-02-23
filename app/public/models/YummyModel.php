<?php
require_once __DIR__ . '/BaseModel.php';

class YummyModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct(); // Ensure PDO initializes
    }

    public function getAllRestaurants()
    {
        $stmt = self::$pdo->query("SELECT * FROM restaurants ORDER BY rating DESC");
        return $stmt->fetchAll();
    }

    public function getRestaurantById($id)
    {
        $stmt = self::$pdo->prepare("SELECT * FROM restaurants WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
}
?>
