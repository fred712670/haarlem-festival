<?php
require_once __DIR__ . '/../models/YummyModel.php';

class RestaurantDetailsController
{
    public function show($id)
    {
        $restaurantModel = new YummyModel();
        $restaurant = $restaurantModel->getRestaurantById($id);

        if (!$restaurant) {
            die("Restaurant not found.");
        }

        require_once __DIR__ . '/../views/pages/restaurant-details.php';
    }
}
?>
