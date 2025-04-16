<?php
function renderRestaurantInfo($restaurant, $menuItems) {
?>
    <div class="restaurant-info">
        <div class="menu-highlights">
            <h3>Menu Highlights</h3>
            <ol>
                <?php if (!empty($menuItems)): ?>
                    <?php foreach ($menuItems as $item): ?>
                        <li>
                            <strong><?= htmlspecialchars($item['Title']) ?></strong> -
                            <?= htmlspecialchars($item['Description']) ?> (€<?= number_format($item['Price'], 2) ?>)
                        </li>
                        <?php endforeach; ?>
                <?php else: ?>
                    <li>No menu items available.</li>
                <?php endif; ?>
            </ol>
        </div>

        <div class="overview">
            <h3>Overview</h3>
            <ol>
                <li><strong>Sessions Available:</strong> <?= htmlspecialchars($restaurant['SessionsAvailable']) ?></li>
                <li><strong>Duration:</strong> <?= htmlspecialchars($restaurant['Duration']) ?> hours</li>
                <li><strong>First Session Start:</strong> <?= htmlspecialchars($restaurant['FirstStart']) ?></li>
                <li><strong>Rating:</strong> ⭐ <?= htmlspecialchars($restaurant['Rating']) ?>/5</li>
                <li><strong>Seats:</strong> <?= htmlspecialchars($restaurant['Seats']) ?></li>
                <li><strong>Price:</strong> €<?= htmlspecialchars($restaurant['ReducedPrice']) ?> (Reduced -12)</li>
                <li><strong>Cuisine:</strong> <?= htmlspecialchars($restaurant['CuisineType']) ?></li>
            </ol>
        </div>
    </div>
<?php
}
?>
