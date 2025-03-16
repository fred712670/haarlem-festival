<?php
require(__DIR__ . "/../controllers/HistoryController.php");

//History route
Route::add('/history', function () {
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

