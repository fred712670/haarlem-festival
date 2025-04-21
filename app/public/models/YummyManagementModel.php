<?php
require_once(__DIR__ . "/BaseModel.php");

/**
 * Model for handling yummy management database operations
 */
class YummyManagementModel extends BaseModel
{
    /**
     * Get count of restaurants
     */
    public function getRestaurantCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM Restaurant";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting restaurant count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of menus
     */
    public function getMenuCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM Menu";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting menu count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of menu items
     */
    public function getMenuItemCount()
    {
        try {
            $query = "SELECT COUNT(*) as count FROM MenuItem";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting menu item count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get count of reservations
     */
    public function getReservationCount()
    {
        try {
            // For now, we'll just count tickets with type 'Reservation'
            $query = "SELECT COUNT(*) as count FROM Ticket WHERE PassType = 'Reservation'";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'];
        } catch (Exception $e) {
            error_log("Error getting reservation count: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Get all restaurants
     */
    public function getAllRestaurants()
    {
        try {
            $query = "SELECT 
                        r.RestaurantId, 
                        r.EventId, 
                        r.Name, 
                        r.Address, 
                        r.CuisineType, 
                        r.Description,
                        r.Image_url
                      FROM Restaurant r
                      ORDER BY r.Name";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all restaurants: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a restaurant by ID
     */
    public function getRestaurantById($restaurantId)
    {
        try {
            $query = "SELECT 
                        r.RestaurantId, 
                        r.EventId, 
                        r.CuisineType, 
                        r.Description, 
                        r.About, 
                        r.Address, 
                        r.Name, 
                        r.ImageGallery, 
                        r.Image_url, 
                        r.WorkingHours, 
                        r.SessionsAvailable, 
                        r.FirstStart, 
                        r.Duration, 
                        r.Rating, 
                        r.Seats, 
                        r.ReducedPrice, 
                        r.Comment
                      FROM Restaurant r
                      WHERE r.RestaurantId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching restaurant by ID {$restaurantId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a restaurant event in the Event table
     */
    public function createRestaurantEvent()
    {
        try {
            $query = "INSERT INTO Event (EventType) VALUES ('Restaurant')";
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return self::$pdo->lastInsertId();
        } catch (Exception $e) {
            error_log("Error creating restaurant event: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new restaurant
     */
    public function createRestaurant(
        $eventId, 
        $name, 
        $cuisineType, 
        $description, 
        $about, 
        $address, 
        $imageUrl, 
        $imageGallery, 
        $workingHours, 
        $sessionsAvailable, 
        $firstStart, 
        $duration, 
        $rating, 
        $seats, 
        $reducedPrice, 
        $comment
    ) {
        try {
            $query = "INSERT INTO Restaurant 
                        (EventId, Name, CuisineType, Description, About, Address, 
                        Image_url, ImageGallery, WorkingHours, SessionsAvailable, 
                        FirstStart, Duration, Rating, Seats, ReducedPrice, Comment) 
                      VALUES 
                        (:eventId, :name, :cuisineType, :description, :about, :address, 
                        :imageUrl, :imageGallery, :workingHours, :sessionsAvailable, 
                        :firstStart, :duration, :rating, :seats, :reducedPrice, :comment)";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':cuisineType', $cuisineType, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':about', $about, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
            $stmt->bindParam(':imageGallery', $imageGallery, PDO::PARAM_STR);
            $stmt->bindParam(':workingHours', $workingHours, PDO::PARAM_STR);
            $stmt->bindParam(':sessionsAvailable', $sessionsAvailable, PDO::PARAM_INT);
            $stmt->bindParam(':firstStart', $firstStart, PDO::PARAM_STR);
            $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':seats', $seats, PDO::PARAM_INT);
            $stmt->bindParam(':reducedPrice', $reducedPrice, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return [
                'success' => true, 
                'message' => 'Restaurant created successfully.',
                'restaurantId' => self::$pdo->lastInsertId()
            ];
        } catch (Exception $e) {
            error_log("Error creating restaurant: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create restaurant: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing restaurant
     */
    public function updateRestaurant(
        $restaurantId, 
        $name, 
        $cuisineType, 
        $description, 
        $about, 
        $address, 
        $imageUrl, 
        $imageGallery, 
        $workingHours, 
        $sessionsAvailable, 
        $firstStart, 
        $duration, 
        $rating, 
        $seats, 
        $reducedPrice, 
        $comment
    ) {
        try {
            $query = "UPDATE Restaurant 
                      SET Name = :name,
                          CuisineType = :cuisineType,
                          Description = :description,
                          About = :about,
                          Address = :address,
                          Image_url = :imageUrl,
                          ImageGallery = :imageGallery,
                          WorkingHours = :workingHours,
                          SessionsAvailable = :sessionsAvailable,
                          FirstStart = :firstStart,
                          Duration = :duration,
                          Rating = :rating,
                          Seats = :seats,
                          ReducedPrice = :reducedPrice,
                          Comment = :comment
                      WHERE RestaurantId = :restaurantId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
            $stmt->bindParam(':cuisineType', $cuisineType, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':about', $about, PDO::PARAM_STR);
            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
            $stmt->bindParam(':imageUrl', $imageUrl, PDO::PARAM_STR);
            $stmt->bindParam(':imageGallery', $imageGallery, PDO::PARAM_STR);
            $stmt->bindParam(':workingHours', $workingHours, PDO::PARAM_STR);
            $stmt->bindParam(':sessionsAvailable', $sessionsAvailable, PDO::PARAM_INT);
            $stmt->bindParam(':firstStart', $firstStart, PDO::PARAM_STR);
            $stmt->bindParam(':duration', $duration, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->bindParam(':seats', $seats, PDO::PARAM_INT);
            $stmt->bindParam(':reducedPrice', $reducedPrice, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Restaurant updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating restaurant: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update restaurant: ' . $e->getMessage()];
        }
    }

   

    /**
     * Delete a restaurant
     */
    public function deleteRestaurant($restaurantId)
    {
        try {
            self::$pdo->beginTransaction();
            
            // First, get the EventId from Restaurant
            $getQuery = "SELECT EventId FROM Restaurant WHERE RestaurantId = :restaurantId";
            $getStmt = self::$pdo->prepare($getQuery);
            $getStmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $getStmt->execute();
            $result = $getStmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$result) {
                self::$pdo->rollBack();
                return ['success' => false, 'message' => 'Restaurant not found.'];
            }
            
            $eventId = $result['EventId'];
            
            // Delete all menus and menu items for this restaurant
            $menuItemDeleteQuery = "DELETE mi FROM MenuItem mi JOIN Menu m ON mi.MenuId = m.MenuId WHERE m.RestaurantId = :restaurantId";
            $menuItemDeleteStmt = self::$pdo->prepare($menuItemDeleteQuery);
            $menuItemDeleteStmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $menuItemDeleteStmt->execute();
            
            $menuDeleteQuery = "DELETE FROM Menu WHERE RestaurantId = :restaurantId";
            $menuDeleteStmt = self::$pdo->prepare($menuDeleteQuery);
            $menuDeleteStmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $menuDeleteStmt->execute();
            
            // Delete Restaurant
            $restaurantQuery = "DELETE FROM Restaurant WHERE RestaurantId = :restaurantId";
            $restaurantStmt = self::$pdo->prepare($restaurantQuery);
            $restaurantStmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $restaurantStmt->execute();
            
            // Delete from main Event table
            $eventQuery = "DELETE FROM Event WHERE EventId = :eventId";
            $eventStmt = self::$pdo->prepare($eventQuery);
            $eventStmt->bindParam(':eventId', $eventId, PDO::PARAM_INT);
            $eventStmt->execute();
            
            self::$pdo->commit();
            
            return ['success' => true, 'message' => 'Restaurant deleted successfully.'];
        } catch (Exception $e) {
            self::$pdo->rollBack();
            error_log("Error deleting restaurant: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete restaurant: ' . $e->getMessage()];
        }
    }

    /**
     * Get all menus with restaurant info
     */
    public function getAllMenus()
    {
        try {
            $query = "SELECT 
                        m.MenuId, 
                        m.RestaurantId, 
                        m.MenuName, 
                        r.Name as RestaurantName
                      FROM Menu m
                      JOIN Restaurant r ON m.RestaurantId = r.RestaurantId
                      ORDER BY r.Name, m.MenuName";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all menus: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a menu by ID
     */
    public function getMenuById($menuId)
    {
        try {
            $query = "SELECT 
                        m.MenuId, 
                        m.RestaurantId, 
                        m.MenuName, 
                        r.Name as RestaurantName
                      FROM Menu m
                      JOIN Restaurant r ON m.RestaurantId = r.RestaurantId
                      WHERE m.MenuId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $menuId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching menu by ID {$menuId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new menu
     */
   /**
 * Create a new menu
 */
public function createMenu($restaurantId, $menuName)
{
    try {
        // Get the maximum MenuId and add 1
        $maxIdQuery = "SELECT COALESCE(MAX(MenuId), 0) as maxId FROM Menu";
        $maxIdStmt = self::$pdo->prepare($maxIdQuery);
        $maxIdStmt->execute();
        $result = $maxIdStmt->fetch(PDO::FETCH_ASSOC);
        $newId = $result['maxId'] + 1;
        
        // Insert with explicit MenuId
        $query = "INSERT INTO Menu (MenuId, RestaurantId, MenuName) VALUES (:menuId, :restaurantId, :menuName)";
        $stmt = self::$pdo->prepare($query);
        $stmt->bindParam(':menuId', $newId, PDO::PARAM_INT);
        $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
        $stmt->bindParam(':menuName', $menuName, PDO::PARAM_STR);
        
        $stmt->execute();
        
        return [
            'success' => true, 
            'message' => 'Menu created successfully.',
            'menuId' => $newId
        ];
    } catch (Exception $e) {
        error_log("Error creating menu: " . $e->getMessage());
        return ['success' => false, 'message' => 'Failed to create menu: ' . $e->getMessage()];
    }
}

    /**
     * Update an existing menu
     */
    public function updateMenu($menuId, $restaurantId, $menuName)
    {
        try {
            $query = "UPDATE Menu 
                      SET RestaurantId = :restaurantId,
                          MenuName = :menuName
                      WHERE MenuId = :menuId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
            $stmt->bindParam(':restaurantId', $restaurantId, PDO::PARAM_INT);
            $stmt->bindParam(':menuName', $menuName, PDO::PARAM_STR);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Menu updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating menu: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update menu: ' . $e->getMessage()];
        }
    }

    /**
     * Check if menu has any items
     */
    public function menuHasItems($menuId)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM MenuItem WHERE MenuId = :menuId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['count'] > 0;
        } catch (Exception $e) {
            error_log("Error checking if menu has items: " . $e->getMessage());
            return true; // Assume has items if query fails, to prevent accidental deletion
        }
    }

    /**
     * Delete a menu
     */
    public function deleteMenu($menuId)
    {
        try {
            $query = "DELETE FROM Menu WHERE MenuId = :menuId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Menu deleted successfully.'];
        } catch (Exception $e) {
            error_log("Error deleting menu: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete menu: ' . $e->getMessage()];
        }
    }

    /**
     * Get all menu items with menu and restaurant info
     */
    public function getAllMenuItems()
    {
        try {
            $query = "SELECT 
                        mi.MenuItemId, 
                        mi.MenuId, 
                        mi.Title, 
                        mi.Description, 
                        mi.Price,
                        m.MenuName,
                        r.Name as RestaurantName
                      FROM MenuItem mi
                      JOIN Menu m ON mi.MenuId = m.MenuId
                      JOIN Restaurant r ON m.RestaurantId = r.RestaurantId
                      ORDER BY r.Name, m.MenuName, mi.Title";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching all menu items: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a menu item by ID
     */
    public function getMenuItemById($menuItemId)
    {
        try {
            $query = "SELECT 
                        mi.MenuItemId, 
                        mi.MenuId, 
                        mi.Title, 
                        mi.Description, 
                        mi.Price,
                        m.MenuName,
                        r.Name as RestaurantName
                      FROM MenuItem mi
                      JOIN Menu m ON mi.MenuId = m.MenuId
                      JOIN Restaurant r ON m.RestaurantId = r.RestaurantId
                      WHERE mi.MenuItemId = :id";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':id', $menuItemId, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log("Error fetching menu item by ID {$menuItemId}: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Create a new menu item
     */
    public function createMenuItem($menuId, $title, $description, $price)
    {
        try {
            $query = "INSERT INTO MenuItem (MenuId, Title, Description, Price) 
                      VALUES (:menuId, :title, :description, :price)";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return [
                'success' => true, 
                'message' => 'Menu item created successfully.',
                'menuItemId' => self::$pdo->lastInsertId()
            ];
        } catch (Exception $e) {
            error_log("Error creating menu item: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to create menu item: ' . $e->getMessage()];
        }
    }

    /**
     * Update an existing menu item
     */
    public function updateMenuItem($menuItemId, $menuId, $title, $description, $price)
    {
        try {
            $query = "UPDATE MenuItem 
                      SET MenuId = :menuId,
                          Title = :title,
                          Description = :description,
                          Price = :price
                      WHERE MenuItemId = :menuItemId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':menuItemId', $menuItemId, PDO::PARAM_INT);
            $stmt->bindParam(':menuId', $menuId, PDO::PARAM_INT);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt->bindParam(':price', $price, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Menu item updated successfully.'];
        } catch (Exception $e) {
            error_log("Error updating menu item: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to update menu item: ' . $e->getMessage()];
        }
    }

    /**
     * Delete a menu item
     */
    public function deleteMenuItem($menuItemId)
    {
        try {
            $query = "DELETE FROM MenuItem WHERE MenuItemId = :menuItemId";
            
            $stmt = self::$pdo->prepare($query);
            $stmt->bindParam(':menuItemId', $menuItemId, PDO::PARAM_INT);
            
            $stmt->execute();
            
            return ['success' => true, 'message' => 'Menu item deleted successfully.'];
        } catch (Exception $e) {
            error_log("Error deleting menu item: " . $e->getMessage());
            return ['success' => false, 'message' => 'Failed to delete menu item: ' . $e->getMessage()];
        }
    }
}