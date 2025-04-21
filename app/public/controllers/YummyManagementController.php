<?php
require_once(__DIR__ . "/../models/YummyManagementModel.php");

/**
 * Controller for handling yummy management operations
 */
class YummyManagementController
{
    private $yummyModel;

    public function __construct()
    {
        $this->yummyModel = new YummyManagementModel();
    }

    /**
     * Display the yummy management dashboard
     */
    public function dashboard()
    {
        $restaurantCount = $this->yummyModel->getRestaurantCount();
        $menuCount = $this->yummyModel->getMenuCount();
        $menuItemCount = $this->yummyModel->getMenuItemCount();
        $reservationCount = $this->yummyModel->getReservationCount();
        
        return [
            'restaurantCount' => $restaurantCount,
            'menuCount' => $menuCount,
            'menuItemCount' => $menuItemCount,
            'reservationCount' => $reservationCount
        ];
    }

    /**
     * List all restaurants
     */
    public function listRestaurants()
    {
        $restaurants = $this->yummyModel->getAllRestaurants();
        return ['restaurants' => $restaurants];
    }

    /**
     * Get a specific restaurant by ID
     */
    public function getRestaurant($restaurantId)
    {
        return $this->yummyModel->getRestaurantById($restaurantId);
    }

    /**
     * Create a new restaurant
     */
   /**
 * Create a new restaurant
 */
public function createRestaurant($data, $files)
{
    // Validate inputs
    if (empty($data['name']) || empty($data['address']) || empty($data['cuisineType'])) {
        return ['success' => false, 'message' => 'Restaurant name, address, and cuisine type are required.'];
    }

    // Handle main image upload
    $mainImageName = null;
    if (!empty($files['mainImage']['name'])) {
        $mainImageName = $this->processImageUpload($files['mainImage'], 'yummy');
        if (!$mainImageName) {
            return ['success' => false, 'message' => 'Failed to upload main image.'];
        }
    }

    // Handle gallery images if present
    $galleryImages = [];
    if (!empty($files['galleryImages']['name'][0])) {
        foreach ($files['galleryImages']['name'] as $index => $filename) {
            if (empty($filename)) continue;

            $galleryFile = [
                'name' => $files['galleryImages']['name'][$index],
                'type' => $files['galleryImages']['type'][$index],
                'tmp_name' => $files['galleryImages']['tmp_name'][$index],
                'error' => $files['galleryImages']['error'][$index],
                'size' => $files['galleryImages']['size'][$index]
            ];

            $galleryImageName = $this->processImageUpload($galleryFile, 'yummy');
            if ($galleryImageName) {
                $galleryImages[] = $galleryImageName;
            }
        }
    }

    // Create restaurant in Event table first to get EventId
    $eventId = $this->yummyModel->createRestaurantEvent();
    if (!$eventId) {
        return ['success' => false, 'message' => 'Failed to create event record.'];
    }

    // Format the FirstStart time properly
    $firstStart = !empty($data['firstStart']) ? date('Y-m-d H:i:s', strtotime(date('Y-m-d') . ' ' . $data['firstStart'])) : date('Y-m-d 18:00:00');

    // Create restaurant
    return $this->yummyModel->createRestaurant(
        $eventId,
        $data['name'],
        $data['cuisineType'],
        $data['description'] ?? '',
        $data['about'] ?? '',
        $data['address'],
        $mainImageName,
        !empty($galleryImages) ? implode(',', $galleryImages) : null,
        $data['workingHours'] ?? '',
        $data['sessionsAvailable'] ?? 3,
        $firstStart, 
        $data['duration'] ?? 2,
        $data['rating'] ?? 4,
        $data['seats'] ?? 40,
        $data['reducedPrice'] ?? 20,
        $data['comment'] ?? ''
    );
}

    /**
     * Update an existing restaurant
     */
  /**
 * Update an existing restaurant
 */
public function updateRestaurant($restaurantId, $data, $files)
{
    // Validate inputs
    if (empty($data['name']) || empty($data['address']) || empty($data['cuisineType'])) {
        return ['success' => false, 'message' => 'Restaurant name, address, and cuisine type are required.'];
    }

    // Get current restaurant data
    $restaurant = $this->yummyModel->getRestaurantById($restaurantId);
    if (!$restaurant) {
        return ['success' => false, 'message' => 'Restaurant not found.'];
    }

    // Handle main image upload
    $mainImageName = $restaurant['Image_url']; // Default to existing image
    if (!empty($files['mainImage']['name'])) {
        $newImageName = $this->processImageUpload($files['mainImage'], 'yummy');
        if ($newImageName) {
            // Remove old image if successful
            if ($mainImageName) {
                $oldImagePath = __DIR__ . '/../../public/assets/img/yummy/' . $mainImageName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            $mainImageName = $newImageName;
        }
    }

    // Handle gallery images if present
    $galleryImages = [];
    if (!empty($restaurant['ImageGallery'])) {
        // Parse existing gallery images
        $galleryImages = explode(',', $restaurant['ImageGallery']);
    }
    
    // Add new gallery images
    if (!empty($files['galleryImages']['name'][0])) {
        foreach ($files['galleryImages']['name'] as $index => $filename) {
            if (empty($filename)) continue;

            $galleryFile = [
                'name' => $files['galleryImages']['name'][$index],
                'type' => $files['galleryImages']['type'][$index],
                'tmp_name' => $files['galleryImages']['tmp_name'][$index],
                'error' => $files['galleryImages']['error'][$index],
                'size' => $files['galleryImages']['size'][$index]
            ];

            $galleryImageName = $this->processImageUpload($galleryFile, 'yummy');
            if ($galleryImageName) {
                $galleryImages[] = $galleryImageName;
            }
        }
    }

    // Handle removed gallery images
    if (!empty($data['removed_gallery_images'])) {
        $removedImages = explode(',', $data['removed_gallery_images']);
        foreach ($removedImages as $removedImage) {
            $key = array_search($removedImage, $galleryImages);
            if ($key !== false) {
                unset($galleryImages[$key]);
                
                // Delete the file
                $imagePath = __DIR__ . '/../../public/assets/img/yummy/' . $removedImage;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
    }

    // Format the FirstStart time properly
    $firstStart = !empty($data['firstStart']) ? date('Y-m-d H:i:s', strtotime(date('Y-m-d') . ' ' . $data['firstStart'])) : date('Y-m-d 18:00:00');

    // Update restaurant
    return $this->yummyModel->updateRestaurant(
        $restaurantId,
        $data['name'],
        $data['cuisineType'],
        $data['description'] ?? '',
        $data['about'] ?? '',
        $data['address'],
        $mainImageName,
        !empty($galleryImages) ? implode(',', array_values($galleryImages)) : null,
        $data['workingHours'] ?? '',
        $data['sessionsAvailable'] ?? 3,
        $firstStart, // Use the properly formatted datetime
        $data['duration'] ?? 2,
        $data['rating'] ?? 4,
        $data['seats'] ?? 40,
        $data['reducedPrice'] ?? 20,
        $data['comment'] ?? ''
    );
}

    /**
     * Delete a restaurant
     */
    public function deleteRestaurant($restaurantId)
    {
        // Check if restaurant exists
        $restaurant = $this->yummyModel->getRestaurantById($restaurantId);
        if (!$restaurant) {
            return ['success' => false, 'message' => 'Restaurant not found.'];
        }

       

        // Delete restaurant images if exist
        if ($restaurant['Image_url']) {
            $imagePath = __DIR__ . '/../../public/assets/img/yummy/' . $restaurant['Image_url'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete gallery images if exist
        if (!empty($restaurant['ImageGallery'])) {
            $galleryImages = explode(',', $restaurant['ImageGallery']);
            foreach ($galleryImages as $image) {
                $imagePath = __DIR__ . '/../../public/assets/img/yummy/' . $image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }

        // Delete restaurant and its associated event
        return $this->yummyModel->deleteRestaurant($restaurantId);
    }

    /**
     * List all menus with their restaurant info
     */
    public function listMenus()
    {
        $menus = $this->yummyModel->getAllMenus();
        return ['menus' => $menus];
    }

    /**
     * Get data for menu form
     */
    public function getMenuFormData()
    {
        $restaurants = $this->yummyModel->getAllRestaurants();
        
        return [
            'restaurants' => $restaurants,
            'menu' => null
        ];
    }

    /**
     * Get a specific menu by ID
     */
    public function getMenu($menuId)
    {
        $menu = $this->yummyModel->getMenuById($menuId);
        $restaurants = $this->yummyModel->getAllRestaurants();
        
        return [
            'menu' => $menu,
            'restaurants' => $restaurants
        ];
    }

    /**
     * Create a new menu
     */
    public function createMenu($data)
    {
        // Validate inputs
        if (empty($data['menuName']) || empty($data['restaurantId'])) {
            return ['success' => false, 'message' => 'Menu name and restaurant are required.'];
        }

        // Create menu
        return $this->yummyModel->createMenu(
            $data['restaurantId'],
            $data['menuName']
        );
    }

    /**
     * Update an existing menu
     */
    public function updateMenu($menuId, $data)
    {
        // Validate inputs
        if (empty($data['menuName']) || empty($data['restaurantId'])) {
            return ['success' => false, 'message' => 'Menu name and restaurant are required.'];
        }

        // Update menu
        return $this->yummyModel->updateMenu(
            $menuId,
            $data['restaurantId'],
            $data['menuName']
        );
    }

    /**
     * Delete a menu
     */
    public function deleteMenu($menuId)
    {
        // Check if menu exists
        $menu = $this->yummyModel->getMenuById($menuId);
        if (!$menu) {
            return ['success' => false, 'message' => 'Menu not found.'];
        }

        // Check if menu has any items
        $hasItems = $this->yummyModel->menuHasItems($menuId);
        if ($hasItems) {
            return ['success' => false, 'message' => 'Cannot delete menu. The menu has associated items. Remove the items first.'];
        }

        // Delete menu
        return $this->yummyModel->deleteMenu($menuId);
    }

    /**
     * List all menu items
     */
    public function listMenuItems()
    {
        $menuItems = $this->yummyModel->getAllMenuItems();
        return ['menuItems' => $menuItems];
    }

    /**
     * Get data for menu item form
     */
    public function getMenuItemFormData()
    {
        $menus = $this->yummyModel->getAllMenus();
        
        return [
            'menus' => $menus,
            'menuItem' => null
        ];
    }

    /**
     * Get a specific menu item by ID
     */
    public function getMenuItem($menuItemId)
    {
        $menuItem = $this->yummyModel->getMenuItemById($menuItemId);
        $menus = $this->yummyModel->getAllMenus();
        
        return [
            'menuItem' => $menuItem,
            'menus' => $menus
        ];
    }

    /**
     * Create a new menu item
     */
    public function createMenuItem($data)
    {
        // Validate inputs
        if (empty($data['title']) || empty($data['description']) || !isset($data['price']) || empty($data['menuId'])) {
            return ['success' => false, 'message' => 'Title, description, price, and menu are required.'];
        }

        // Create menu item
        return $this->yummyModel->createMenuItem(
            $data['menuId'],
            $data['title'],
            $data['description'],
            $data['price']
        );
    }

    /**
     * Update an existing menu item
     */
    public function updateMenuItem($menuItemId, $data)
    {
        // Validate inputs
        if (empty($data['title']) || empty($data['description']) || !isset($data['price']) || empty($data['menuId'])) {
            return ['success' => false, 'message' => 'Title, description, price, and menu are required.'];
        }

        // Update menu item
        return $this->yummyModel->updateMenuItem(
            $menuItemId,
            $data['menuId'],
            $data['title'],
            $data['description'],
            $data['price']
        );
    }

    /**
     * Delete a menu item
     */
    public function deleteMenuItem($menuItemId)
    {
        // Check if menu item exists
        $menuItem = $this->yummyModel->getMenuItemById($menuItemId);
        if (!$menuItem) {
            return ['success' => false, 'message' => 'Menu item not found.'];
        }

        // Delete menu item
        return $this->yummyModel->deleteMenuItem($menuItemId);
    }

    /**
     * Process image upload and return the filename
     */
    private function processImageUpload($file, $subdir)
    {
        // Check if file upload is valid
        if ($file['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        if (!in_array($file['type'], $allowedTypes)) {
            return false;
        }

        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('img_') . '.' . $extension;
        
        // Make sure the destination directory exists
        $uploadDir = __DIR__ . '/../../public/assets/img/' . $subdir . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        // Move the uploaded file
        if (move_uploaded_file($file['tmp_name'], $uploadDir . $filename)) {
            return $filename;
        }
        
        return false;
    }
}