<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/JazzController.php';
require_once __DIR__ . '/../controllers/ReservationController.php';

// Route for the main jazz page
Route::add('/jazz', function () {
    $controller = new JazzController();
    // Call the index method to retrieve all necessary jazz festival data
    $data = $controller->index(); // Fetch all jazz data like artists, schedule, venues, etc.

    // Extract each part of the data array into individual variables
    $artists = $data['artists'];       // List of jazz artists
    $schedule = $data['schedule'];     // Festival schedule
    $venues = $data['venues'];         // Locations where performances happen
    $ticketInfo = $data['ticketInfo']; // Ticket pricing and availability
    $content = $data['content'];       // Additional page content (e.g., intro, banners)

    // Set this flag to false because this is the main overview page, not an individual artist page
    $isArtistPage = false;

    // Load the main jazz page view
    require_once __DIR__ . '/../views/pages/jazz.php';
}, 'get');

// Route for the artist detail page with ID and name in the URL
Route::add('/jazz/artist/([0-9]+)/([a-zA-Z0-9-]+)', function ($id, $name) {
    $controller = new JazzController();

    // Get artist data by ID
    $artist = $controller->showArtist($id);

    // If artist is not found, redirect to the main jazz page
    if (!$artist) {
        header("Location: /jazz");
        exit();
    }

    // Fetch all venues (even if not artist-specific, for sidebar or footer)
    $venues = $controller->getVenues();

    // Fetch the schedule specifically for this artist
    $schedule = $controller->getSchedule($id);

    // Fetch ticket information (may be the same across all artists)
    $ticketInfo = $controller->getTicketInfo();

    // Store the artist's name to use in the schedule heading
    $artistName = $artist['name'];

    // Set this flag to true because this is an individual artist detail page
    $isArtistPage = true;

    // Load the view that shows the artist's details
    require_once __DIR__ . '/../views/partials/jazz-artist.php';
}, 'get');

// Legacy route kept for backward compatibility (only artist ID in URL)
Route::add('/jazz/artist/([0-9]+)', function ($id) {
    $controller = new JazzController();

    // Get the artist details by ID
    $artist = $controller->showArtist($id);

    // If the artist does not exist, redirect to the main page
    if (!$artist) {
        header("Location: /jazz");
        exit();
    }

    // Generate a slug from the artist name (remove special characters and replace spaces with dashes)
    $nameSlug = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $artist['name'])));

    // Redirect the old route to the new route with ID and slug
    header("Location: /jazz/artist/$id/$nameSlug");
    exit();
}, 'get');

// API endpoint to get track details in JSON format
Route::add('/api/jazz/track/([0-9]+)', function($trackId) {
    // Set the response header to JSON
    header('Content-Type: application/json');

    $controller = new JazzController();

    // Output the track details as JSON
    echo json_encode($controller->getTrackDetails($trackId));
}, 'get');
