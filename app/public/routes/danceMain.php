<?php

require_once __DIR__ . '/../controllers/DanceController.php';

Route::add('/dance', function () {

    $danceController = new DanceController();
    $artists = $danceController->getArtists();

    require(__DIR__ . "/../views/pages/danceMain.php");
}, 'get');


