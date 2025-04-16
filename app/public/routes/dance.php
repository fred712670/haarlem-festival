<?php

require_once __DIR__ . '/../controllers/DanceController.php';

Route::add('/dance', function () {
    $controller = new DanceController();
    $artists = $controller->getArtists();
    
$danceEvents = $controller->getDanceEvents();
    $aboutContent = $controller->getContent('dance', 'aboutUs');

    require(__DIR__ . "/../views/pages/danceMain.php");
}, 'get');


Route::get('/dance/artist', function () {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Artist ID is required.");
    }

    $model = new DanceModel();
    $artist = $model->getArtist($id);
    $songs = $model->getArtistSongs($id);
    $performances = $model->getArtistPerformances($id);

    if (!$artist) {
        die("Artist not found.");
    }

    require_once __DIR__ . '/../views/partials/danceDetail.php';
});


?>
