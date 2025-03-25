<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/JazzController.php';

// Main Jazz Festival page route
Route::add('/jazz', function () {
    $controller = new JazzController();
    $data = $controller->index(); // Fetch all jazz data
    
    // Extract data for the view
    $artists = $data['artists'];
    $schedule = $data['schedule'];
    $venues = $data['venues'];
    $ticketInfo = $data['ticketInfo'];
    
    // Set a flag to indicate this is the main page (not artist detail)
    $isArtistPage = false;
    
    require_once __DIR__ . '/../views/pages/jazz.php';
}, 'get');

// Individual artist details page route
Route::add('/jazz/artist/([0-9]+)', function ($id) {
    $controller = new JazzController();
    $artist = $controller->showArtist($id); // Fetch specific artist data
    
    if (!$artist) {
        // Handle artist not found
        header("Location: /jazz");
        exit();
    }
    
    // Get venue details for the venues component
    $venues = $controller->getVenues();
    
    // Get the schedule data organized by days
    $schedule = $controller->getSchedule($id);
    
    // Set artist name for the schedule heading
    $artistName = $artist['name'];
    
    // Set a flag to indicate this is an artist page
    $isArtistPage = true;
    
    // Include the artist detail view
    require_once __DIR__ . '/../views/partials/jazz-artist.php';
}, 'get');
?>