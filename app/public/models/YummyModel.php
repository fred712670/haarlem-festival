<?php
require_once __DIR__ . '/BaseModel.php';

class YummyModel extends BaseModel
{
    public function getAllRestaurants()
    {
        try {
            $query = "SELECT RestaurantId AS id, Name, Description, Image_url, Address FROM Restaurant";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // 🛠️ Debugging Output - Log fetched data
            error_log("Fetched restaurants: " . print_r($restaurants, true));
            return $restaurants ?: [];
        } catch (Exception $e) {
            error_log("Error fetching restaurants: " . $e->getMessage());
            return [];
        }
    }
    
    public function getRestaurantById($id)
    {
        try {
            $query = "SELECT * FROM Restaurant WHERE RestaurantId = :id";
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $restaurant = $stmt->fetch(PDO::FETCH_ASSOC);
    
            // Convert ImageGallery (comma-separated) to an array
            if (!empty($restaurant['ImageGallery'])) {
                $restaurant['ImageGallery'] = explode(',', $restaurant['ImageGallery']);
            } else {
                $restaurant['ImageGallery'] = [$restaurant['Image_url']]; // Fallback to main image
            }
    
            return $restaurant ?: null;
        } catch (Exception $e) {
            error_log("Error fetching restaurant details: " . $e->getMessage());
            return null;
        }
    }
}
?>
