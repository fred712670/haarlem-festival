<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/YummyController.php';

Route::add('/', function () {
    // homepage is simply loading a static page
    // view the user routes for example following the MVC pattern
    require(__DIR__ . "/../views/pages/index.php");
});

Route::add('/yummy', function() {
    require_once __DIR__ . '/../views/pages/yummy.php';
}, 'get');
?>