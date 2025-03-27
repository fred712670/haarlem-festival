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
// Update this route
Route::add('/jazz/artist/([0-9]+)/([a-zA-Z0-9-]+)', function ($id, $name) {
    $controller = new JazzController();
    $artist = $controller->showArtist($id); // Still find by ID
    
    if (!$artist) {
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

// Keep the old route for backward compatibility
Route::add('/jazz/artist/([0-9]+)', function ($id) {
    $controller = new JazzController();
    $artist = $controller->showArtist($id);
    
    if (!$artist) {
        header("Location: /jazz");
        exit();
    }
    
    // Create a URL-friendly version of the artist name (slug)
    $nameSlug = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $artist['name'])));
    
    // Redirect to the URL with both ID and name
    header("Location: /jazz/artist/$id/$nameSlug");
    exit();
}, 'get');
?>