<?php
function renderRestaurantInfo($restaurant) {
?>
    <div class="restaurant-info">
        <div class="menu-highlights">
            <h3>Menu Highlights</h3>
            <ol>
                <li><strong>Kingfish</strong> - Passion fruit, peanut, Thai basil (€20)</li>
                <li><strong>Scallops</strong> - Celeriac, katsuani, mushroom (€19)</li>
                <li><strong>Sea Bass</strong> - Nduja, arrabiata, guanciale (€24)</li>
                <li><strong>Perfect Egg</strong> - Truffle, spätzle, mushroom (€8)</li>
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
