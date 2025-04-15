<?php
require_once __DIR__ . '/../models/YummyModel.php';

class RestaurantDetailsController
{
    public function show($id)
    {
        $restaurantModel = new YummyModel();

        $restaurant = $restaurantModel->getRestaurantById($id);
        $menuItems = $restaurantModel->getMenuItemsByRestaurant($id);

        if (!$restaurant) {
            return null;
        }
        
        return [
            'restaurant' => $restaurant,
            'menuItems' => $menuItems
        ];
    }
}
?>
