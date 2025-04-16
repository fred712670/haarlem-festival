<?php
function renderFoodCard($image, $title, $description) {
?>
    <div class="food-card">
        <div class="food-card-content">
            <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($title) ?>">
            <h3><?= htmlspecialchars($title) ?></h3>
            <p class="food-description"><?= htmlspecialchars($description) ?></p>
            <button class="expand-btn">+</button>
        </div>
    </div>
<?php 
} 
?>