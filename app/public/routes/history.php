<?php
require(__DIR__ . "/../controllers/HistoryController.php");

//History route
Route::add('/history', function () {
    $controller = new HistoryController();
    $guides = $controller->getTourGuides();
    $schedule = $controller->getTourSchedule();
    $locations = $controller->getHistoryLocations();
    $overviewContent = $controller->getHistoryContent('overview');
    $eventDetailContent = $controller->getHistoryContent('event_detail');
    $pricing = $controller->getPricing();


    require(__DIR__ . "/../views/pages/history.php");

}, 'get');

//Reservation route
Route::add('/Reservation', function () {
   $controller = new HistoryController();
   
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       $bookingResult = $controller->processBooking($_POST);
       
       $bookingResult['success'] 
           ? header("Location: /booking-confirmation?bookingId=" . $bookingResult['bookingId'])
           : header("Location: /Reservation?error=" . urlencode(implode('; ', $bookingResult['errors'])));
       exit();
   } else {
       require(__DIR__ . "/../views/pages/tour_reservation.php");
   }
}, ['get', 'post']);

//confirmation route 
Route::add('/booking-confirmation', function () {
    $controller = new HistoryController();
    $bookingId = $_GET['bookingId'] ?? null;
    
    if (!$bookingId) {
        header("Location: /Reservation?error=Invalid booking ID");
        exit();
    }
    
    $bookingDetails = $controller->getBookingConfirmationDetails($bookingId);
    
    if (!$bookingDetails['success']) {
        header("Location: /Reservation?error=Booking not found");
        exit();
    }
    
    // pass details to the view
    $details = $bookingDetails['details'] ?? [];
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
