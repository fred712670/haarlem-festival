<?php
require_once __DIR__ . '/../controllers/DanceController.php';

Route::add('/dance', function () {
    $controller = new DanceController();
    
    // Retrieve artists and events.
    $artists = $controller->getArtists();
    $danceEvents = $controller->getDanceEvents();
    
    // Get the "about us" content.
    $aboutContent = $controller->getContent('dance', 'aboutUs');
    // Wrap the about content paragraphs.
    $aboutContentWrapped = $controller->wrapParagraphs($aboutContent);
    
    // Group the dance events by day.
    $groups = $controller->groupDanceEventsByDay($danceEvents);
    $friday = $groups['friday'];
    $saturday = $groups['saturday'];
    $sunday = $groups['sunday'];
    
    // Now require the view, which can assume these variables exist:
    require(__DIR__ . "/../views/pages/danceMain.php");
}, 'get');

Route::get('/dance/artist', function () {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Artist ID is required.");
    }
    
    // Use DanceModel directly for artist detail (or consider moving logic into controller)
    require_once __DIR__ . '/../models/DanceModel.php';
    $model = new DanceModel();
    $artist = $model->getArtist($id);
    $songs = $model->getArtistSongs($id);
    $performances = $model->getArtistPerformances($id);
    
    if (!$artist) {
        die("Artist not found.");
    }
    
    require_once __DIR__ . '/../views/pages/danceDetail.php';
});
?>
