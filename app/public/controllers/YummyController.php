<?php
require_once __DIR__ . '/../models/YummyModel.php';

class YummyController
{
    public function index()
    {
        $restaurantModel = new YummyModel();
        $restaurants = $restaurantModel->getAllRestaurants();
        $foodItems = $restaurantModel->getAllFoodItems();

        return [
            'restaurants' => $restaurants,
            'foodItems' => $foodItems
        ];
    }
}
?>