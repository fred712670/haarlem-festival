<?php
require_once __DIR__ . '/../partials/header.php';

// Ensure restaurant data is available
if (!isset($restaurant)) {
    die("Error: Restaurant data not found.");
}

// Load the restaurant content
require_once __DIR__ . '/../partials/restaurant-details.php';

require_once __DIR__ . '/../partials/footer.php';
?>
