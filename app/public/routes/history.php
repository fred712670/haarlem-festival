<?php
require(__DIR__ . "/../controllers/HistoryController.php");

// History page route
Route::add('/history', function () {
    $controller = new HistoryController();
    $controller->showHistoryPage();
}, 'get');

// Reservation route
Route::add('/reservation', function () {
    $controller = new HistoryController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookingResult = $controller->processBooking($_POST);

        if ($bookingResult['success']) {
            header("Location: /booking-confirmation");
        } else {
            $errorString = urlencode(implode('; ', $bookingResult['errors']));
            header("Location: /reservation?error=" . $errorString);
        }
        exit();
    }

    // Show the booking form
    $controller->showReservationForm();
}, ['get', 'post']);

// Booking confirmation 
Route::add('/booking-confirmation', function () {
    require(__DIR__ . "/../views/pages/tour_confirmation.php");
}, 'get');

// Location detail route
Route::add('/history/tour-location/([0-9]+)', function($locationId) {
    $controller = new HistoryController();
    $location = $controller->getTourLocationById($locationId);
    $locations = $controller->getHistoryLocations(); 

    if (!$location) {
        header("Location: /history");
        exit();
    }

    // Prepare images for each section
    $images = [
        'banner' => $location['ImageGalleryArray'][0] ?? '',
        'about' => $location['ImageGalleryArray'][1] ?? '',
        'gallery' => [
            $location['ImageGalleryArray'][2] ?? '',
            $location['ImageGalleryArray'][3] ?? '',
            $location['ImageGalleryArray'][4] ?? ''
        ]
    ];

    require(__DIR__ . "/../views/pages/tour_location.php");
}, 'get');
