<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/YummyController.php';
require_once __DIR__ . '/../controllers/RestaurantDetailsController.php';

// Home Page Route
Route::add('/', function () {
    require(__DIR__ . "/../views/pages/index.php");
});

// Restaurants Page Route
Route::add('/yummy', function() {
    require_once __DIR__ . '/../views/pages/yummy.php';
}, 'get');

// Dynamic Restaurant Details Route
Route::add('/restaurant/([0-9]+)', function ($id) {
    $controller = new RestaurantDetailsController();
    $controller->show($id);
}, 'get');
?>