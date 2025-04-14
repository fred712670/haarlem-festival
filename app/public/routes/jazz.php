<?php
/**
 * Jazz Festival Routes
 * 
 * This file defines all routes related to the Jazz Festival section of the website,
 * including both web page routes and API endpoints for AJAX functionality.
 */
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/JazzController.php';
require_once __DIR__ . '/../controllers/ReservationController.php';

// Main Jazz Festival page route
Route::add('/jazz', function () {
    $controller = new JazzController();
    $data = $controller->index(); // Fetch all jazz data

    // Extract data for the view
    $artists = $data['artists'];
    $schedule = $data['schedule'];
    $venues = $data['venues'];
    $ticketInfo = $data['ticketInfo'];
    $content = $data['content'];
    // Set a flag to indicate this is the main page (not artist detail)
    $isArtistPage = false;
    
    require_once __DIR__ . '/../views/pages/jazz.php';
}, 'get');

// Individual artist details page route
Route::add('/jazz/artist/([0-9]+)', function ($id) {
    $controller = new JazzController();
    $artist = $controller->showArtist($id);
    
    if (!$artist) {
        header("Location: /jazz");
        exit();
    }
    
    // Get venue details for the venues component
    $venues = $controller->getVenues();
    
    // Get the schedule data organized by days
    $schedule = $controller->getSchedule($id);
    
    // Add this line to get ticket info
    $ticketInfo = $controller->getTicketInfo();
    
    // Set artist name for the schedule heading
    $artistName = $artist['name'];
    
    // Set a flag to indicate this is an artist page
    $isArtistPage = true;
    
    // Include the artist detail view
    require_once __DIR__ . '/../views/partials/jazz-artist.php';
}, 'get');

// API endpoint to get all jazz artists as JSON
Route::add('/api/jazz/artists', function() {
    $controller = new JazzController();
    $artists = $controller->getAllArtists();
    
    header('Content-Type: application/json');
    echo json_encode($artists);
}, 'get');

// API endpoint to get a specific artist's data as JSON
Route::add('/api/jazz/artist/([0-9]+)', function($id) {
    $controller = new JazzController();
    $artist = $controller->showArtist($id);
    
    header('Content-Type: application/json');
    if (!$artist) {
        http_response_code(404);
        echo json_encode(['error' => 'Artist not found']);
    } else {
        echo json_encode($artist);
    }
}, 'get');

// API endpoint to get festival schedule as JSON
Route::add('/api/jazz/schedule', function() {
    $controller = new JazzController();
    $artistId = isset($_GET['artist']) ? intval($_GET['artist']) : null;
    $schedule = $controller->getSchedule($artistId);
    
    header('Content-Type: application/json');
    echo json_encode($schedule);
}, 'get');

// API endpoint to get ticket information as JSON
Route::add('/api/jazz/tickets', function() {
    $controller = new JazzController();
    $tickets = $controller->getTicketInfo();
    
    header('Content-Type: application/json');
    echo json_encode($tickets);
}, 'get');