<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/YummyController.php';
require_once __DIR__ . '/../controllers/RestaurantDetailsController.php';
require_once __DIR__ . '/../controllers/HomeController.php';
// Home Page Route
Route::add('/', function () {
    $controller = new HomeController();
    $controller->loadSections(); 
});