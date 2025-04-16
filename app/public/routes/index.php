<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/YummyController.php';
require_once __DIR__ . '/../controllers/RestaurantDetailsController.php';

// Home Page Route
Route::add('/', function () {
    require(__DIR__ . "/../views/pages/index.php");
});