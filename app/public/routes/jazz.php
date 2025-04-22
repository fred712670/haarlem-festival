<?php
require_once __DIR__ . '/../lib/Route.php';
require_once __DIR__ . '/../controllers/JazzController.php';
require_once __DIR__ . '/../controllers/ReservationController.php';

/**
 * Jazz Festival Routes
 * This file defines all routes related to the Jazz Festival section of the website
 */

// Main jazz festival page
Route::add('/jazz', function () {
    $controller = new JazzController();
    $data = $controller->index();
    
    // Extract data for the view
    extract($data);
    
    // Flag to determine rendering variations
    $isArtistPage = false;
    
    // Load view
    require_once __DIR__ . '/../views/pages/jazz.php';
}, 'get');

// Artist detail page with SEO-friendly URL (ID and name slug)
Route::add('/jazz/artist/([0-9]+)/([a-zA-Z0-9-]+)', function ($id, $nameSlug) {
    $controller = new JazzController();
    
    // Validate ID is numeric
    if (!is_numeric($id)) {
        header("Location: /jazz");
        exit();
    }
    
    // Get artist details
    $artist = $controller->showArtist($id);
    
    // Handle artist not found
    if (!$artist) {
        header("Location: /jazz");
        exit();
    }
    
    // Get additional data needed for the view
    $venues = $controller->getVenues();
    $schedule = $controller->getSchedule($id);
    $ticketInfo = $controller->getTicketInfo();
    
    // Additional variables for view
    $artistName = $artist['name'];
    $isArtistPage = true;
    
    // Load artist detail view
    require_once __DIR__ . '/../views/partials/jazz-artist.php';
}, 'get');

// Legacy route for backward compatibility - redirects to SEO-friendly URL
Route::add('/jazz/artist/([0-9]+)', function ($id) {
    $controller = new JazzController();
    
    // Validate ID format
    if (!is_numeric($id)) {
        header("Location: /jazz");
        exit();
    }
    
    // Get artist to generate name slug
    $artist = $controller->showArtist($id);
    
    if (!$artist) {
        header("Location: /jazz");
        exit();
    }
    
    // Generate SEO-friendly slug from artist name
    $nameSlug = strtolower(str_replace(' ', '-', preg_replace('/[^a-zA-Z0-9\s]/', '', $artist['name'])));
    
    // Redirect to canonical URL format
    header("Location: /jazz/artist/$id/$nameSlug");
    exit();
}, 'get');

// API endpoint for track data (returns JSON)
Route::add('/api/jazz/track/([0-9]+)', function($trackId) {
    header('Content-Type: application/json');
    
    // Validate track ID
    if (!is_numeric($trackId)) {
        echo json_encode(['error' => 'Invalid track ID']);
        return;
    }
    
    $controller = new JazzController();
    $trackDetails = $controller->getTrackDetails($trackId);
    
    if (!$trackDetails) {
        echo json_encode(['error' => 'Track not found']);
        return;
    }
    
    echo json_encode($trackDetails);
}, 'get');
