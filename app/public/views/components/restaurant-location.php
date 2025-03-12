<?php
function renderRestaurantLocation($restaurant) {
?>
    <div class="restaurant-location">
        <h3>Location</h3>
        <p>📍 <strong><?= htmlspecialchars($restaurant['Address']) ?></strong></p>
        <iframe src="https://maps.google.com/maps?q=<?= urlencode($restaurant['Address']) ?>&output=embed" class="location-map"></iframe>
    </div>
<?php
}
?>
