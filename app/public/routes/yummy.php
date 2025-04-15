<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/YummyController.php';

// Yummy Page Route
Route::add('/yummy', function () {
    $controller = new YummyController();
    $restaurants = $controller->index(); // Fetch restaurant data

    require_once __DIR__ . '/../views/pages/yummy.php';
}, 'get');

// Dynamic Restaurant Details Route
Route::add('/restaurant/([0-9]+)', function ($id) {
    require_once __DIR__ . '/../controllers/YummyController.php';
    $controller = new RestaurantDetailsController();
    $data = $controller->show($id); // ✅ FIXED
    if (!$data || empty($data['restaurant'])) {
        die("Error: Restaurant not found.");
    }
    
    $restaurant = $data['restaurant'];
    $menuItems = $data['menuItems'];
    

    require_once __DIR__ . '/../views/pages/restaurant-details.php';
}, 'get');
?>
