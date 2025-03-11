<?php
require_once __DIR__ . './../components/restaurant-header.php';
require_once __DIR__ . './../components/restaurant-location.php';
require_once __DIR__ . './../components/restaurant-info.php';
require_once __DIR__ . './../components/restaurant-reservation.php';

// Render Components
renderRestaurantHeader($restaurant);
renderRestaurantLocation($restaurant);
renderRestaurantInfo($restaurant);
renderRestaurantReservation($restaurant);
?>
