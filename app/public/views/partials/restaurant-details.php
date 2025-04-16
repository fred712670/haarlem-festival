<?php 
require_once __DIR__ . '/../components/restaurant-header.php';
require_once __DIR__ . '/../components/restaurant-location.php';
require_once __DIR__ . '/../components/restaurant-info.php';
require_once __DIR__ . '/../components/restaurant-reservation.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy</title>
    <link rel="stylesheet" href="/assets/css/yummy.css">
</head>
<body>
    <div class="restaurant-container">
        <a href="/yummy" class="back-arrow">←</a>

        <?php 
        renderRestaurantHeader($restaurant);
        renderRestaurantLocation($restaurant);
        renderRestaurantInfo($restaurant, $menuItems);
        renderRestaurantReservation($restaurant, $menuItems);
        ?>
    </div>
    <script src="/assets/js/yummy.js"></script>
</body>
</html>
