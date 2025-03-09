<?php
require_once __DIR__ . '/../models/YummyModel.php';

class YummyController
{
    public function index()
    {
        $restaurantModel = new YummyModel();
        $restaurants = $restaurantModel->getAllRestaurants();

        // ✅ Pass restaurants to the view (avoid direct include)
        return $restaurants;
    }
}
?>