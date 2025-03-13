<?php
function renderRestaurantHeader($restaurant) {
        $imageGallery = is_string($restaurant['ImageGallery']) 
        ? json_decode($restaurant['ImageGallery'], true) 
        : $restaurant['ImageGallery'];

    if (!is_array($imageGallery)) {
        $imageGallery = [];
    }
?>
    <div class="restaurant-container">
        <a href="/yummy" class="back-arrow">←</a>

        <!-- Image and About Section -->
        <div class="restaurant-header">
            <div class="restaurant-image">
                <div class="slideshow">
                    <?php foreach ($imageGallery as $image): ?>
                        <img class="slide" src="/assets/img/yummy/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($restaurant['Name']) ?>">
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="restaurant-about">
                <h2>About <?= htmlspecialchars($restaurant['Name']) ?></h2>
                <p><?= htmlspecialchars($restaurant['About']) ?></p>

                <h3>Working Hours</h3>
                <p><?= nl2br(htmlspecialchars($restaurant['WorkingHours'])) ?></p>
            </div>
        </div>
    </div>
<?php
}
?>
