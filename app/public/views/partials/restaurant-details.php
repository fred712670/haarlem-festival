<pre>
<?php print_r($restaurant); ?>
</pre>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzles and Science at Teylers Museum</title>
    <link href="../../assets/css/yummy.css" rel="stylesheet">
</head>
<body>
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

</body>
