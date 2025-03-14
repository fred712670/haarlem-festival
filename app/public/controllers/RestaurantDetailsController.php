<?php
require_once __DIR__ . '/../models/YummyModel.php';

class RestaurantDetailsController
{
    public function show($id)
    {
        $restaurantModel = new YummyModel();
        return $restaurantModel->getRestaurantById($id);
    }
}
?>
