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
        
            if (!$restaurant) {
              return null;
            }

            // Convert ImageGallery (comma-separated) to an array
            if (!empty($restaurant['ImageGallery'])) {
              $restaurant['ImageGallery'] = explode(',', $restaurant['ImageGallery']);
            } else {
              $restaurant['ImageGallery'] = !empty($restaurant['Image_url']) ? [$restaurant['Image_url']] : [];
            }

            return $restaurant;
        } catch (Exception $e) {
            error_log("Error fetching restaurant details: " . $e->getMessage());
            return null;
        }
    }

    public function getMenuItemsByRestaurant($restaurantId)
    {
        $query = "
        SELECT mi.Title, mi.Description, mi.Price
        FROM MenuItem mi
        JOIN Menu m ON mi.MenuId = m.MenuId
        WHERE m.RestaurantId = :restaurantId";

        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
