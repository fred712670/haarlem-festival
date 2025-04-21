<?php

// Include the DanceController class
require_once __DIR__ . '/../controllers/DanceController.php';

// Loads the main dance festival page with artists, events, and about content
Route::add('/dance', function () {
    $controller = new DanceController();

    // Retrieve all dance artists and scheduled dance events
    $artists = $controller->getArtists();
    $danceEvents = $controller->getDanceEvents();

    // Retrieve and format the "about us" section content
    $aboutContent = $controller->getContent('dance', 'aboutUs');
    $aboutContentWrapped = $controller->wrapParagraphs($aboutContent);

    // Group events by day: friday, saturday, sunday
    $groups = $controller->groupDanceEventsByDay($danceEvents);
    $friday   = $groups['friday'];
    $saturday = $groups['saturday'];
    $sunday   = $groups['sunday'];

    // Load the dance main view, which uses the variables above
    require(__DIR__ . "/../views/pages/danceMain.php");
}, 'get');

// Loads the artist detail page based on query param ?id=
Route::get('/dance/artist', function () {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        die("Artist ID is required.");
    }

    // Use the controller to access artist data (preserves MVC structure)
    $controller = new DanceController();
    $artist = $controller->getArtistById($id);
    $songs = $controller->getSongsByArtistId($id);
    $performances = $controller->getArtistPerformances($id);

    if (!$artist) {
        die("Artist not found.");
    }

    // Load the artist detail view with artist, songs, and performances available
    require_once __DIR__ . '/../views/pages/danceDetail.php';
}, 'get');

