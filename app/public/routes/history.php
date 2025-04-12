<?php
require(__DIR__ . "/../controllers/HistoryController.php");

//History route
Route::add('/history', function () {
    $controller = new HistoryController();
    $controller->showHistoryPage();


    require(__DIR__ . "/../views/pages/history.php");

}, 'get');

Route::add('/Reservation', function () {
    $controller = new HistoryController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $bookingResult = $controller->processBooking($_POST);

        if ($bookingResult['success']) {
            header("Location: /booking-confirmation?bookingId=" . $bookingResult['bookingId']);
        } else {
            $errorString = urlencode(implode('; ', $bookingResult['errors']));
            header("Location: /Reservation?error=" . $errorString);
        }
        exit();
    }

    // load the booking form with dynamic data
    $controller->showReservationForm();
}, ['get', 'post']);


Route::add('/booking-confirmation', function () {
    $bookingId = $_GET['bookingId'] ?? null;

    if (!$bookingId) {
        header("Location: /Reservation?error=Invalid booking ID");
        exit();
    }

    
    require(__DIR__ . "/../views/pages/tour_confirmation.php");
}, 'get');

//details page
Route::add('/history/tour-location/([0-9]+)', function($locationId) {
    $controller = new HistoryController();
    $location = $controller->getTourLocationById($locationId);
    $locations = $controller->getHistoryLocations(); // For the experience section
    
    if (!$location) {
        header("Location: /history");
        exit();
    }
    
    // Prepare specific images for each section
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
