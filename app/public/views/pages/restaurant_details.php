<?php 
require_once __DIR__ . "/../partials/header.php"; 
require_once __DIR__ . "/../partials/header_nav.php"; 
?>

<link rel="stylesheet" href="/assets/css/yummy.css">

<div class="restaurant-container">
    <a href="/yummy" class="back-arrow">←</a>

    <!-- Image and About Section -->
    <div class="restaurant-header">
        <div class="restaurant-image">
            <img src="/assets/img/<?= htmlspecialchars($restaurant['Image_url']) ?>" alt="<?= htmlspecialchars($restaurant['Name']) ?>">
        </div>
        <div class="restaurant-about">
            <h2>About <?= htmlspecialchars($restaurant['Name']) ?></h2>
            <p><?= htmlspecialchars($restaurant['Description']) ?></p>
    
           <h3>Working Hours</h3>
           <p><?= nl2br(htmlspecialchars($restaurant['WorkingHours'])) ?></p>
        </div>
    </div>

    <!-- Location Section -->
    <div class="restaurant-location">
        <h3>Location</h3>
        <p>📍 <strong><?= htmlspecialchars($restaurant['Address']) ?></strong></p>
        <iframe src="https://maps.google.com/maps?q=<?= urlencode($restaurant['Address']) ?>&output=embed" class="location-map"></iframe>
    </div>

    <!-- Menu Highlights & Overview -->
    <div class="restaurant-info">
        <div class="menu-highlights">
            <h3>Menu Highlights</h3>
            <ul>
                <li><strong>Kingfish</strong> - A refreshing blend of passion fruit, peanut, and Thai basil (€20)</li>
                <li><strong>Scallops</strong> - Delicately paired with celeriac, katsuani, and mushroom (€19)</li>
                <li><strong>Sea Bass</strong> - Served with nduja, arrabiata, and guanciale for a rich taste (€24)</li>
                <li><strong>Perfect Egg</strong> - A luxurious combination of truffle, spätzle, and mushroom (€8)</li>
            </ul>
        </div>
        <div class="overview">
            <h3>Overview</h3>
            <p><strong>Sessions Available:</strong> <?= htmlspecialchars($restaurant['SessionAvailable']) ?></p>
            <p><strong>Duration:</strong> <?= htmlspecialchars($restaurant['Duration']) ?> hours</p>
            <p><strong>First Session Start:</strong> <?= htmlspecialchars($restaurant['FirstStart']) ?></p>
            <p><strong>Rating:</strong> ⭐ <?= htmlspecialchars($restaurant['Rating']) ?>/5</p>
            <p><strong>Seats:</strong> <?= htmlspecialchars($restaurant['Seats']) ?></p>
            <p><strong>Price:</strong> €<?= htmlspecialchars($restaurant['ReducedPrice']) ?> (Reduced -12)</p>
            <p><strong>Cuisine:</strong> <?= htmlspecialchars($restaurant['CuisineType']) ?></p>
        </div>
    </div>

    <!-- Reservation Section -->
    <div class="reservation">
        <div class="contact-info">
            <h3>Contact Information</h3>
            <p>📞 +31 20 123 4567</p>
            <p>✉ info@<?= strtolower(str_replace(' ', '', $restaurant['Name'])) ?>.com</p>
            <p>📍 <?= htmlspecialchars($restaurant['Address']) ?></p>
        </div>
        <div class="reservation-form">
            <h3>Make a Reservation</h3>
            <form>
                <label>Number of guests:</label>
                <input type="number" min="1" max="<?= $restaurant['Seats'] ?>" value="2">

                <label>Select a date:</label>
                <input type="date">

                <label>Select time:</label>
                <select>
                    <option>12:00 - 14:30</option>
                    <option>18:30 - 21:00</option>
                </select>

                <label>Special Requests:</label>
                <textarea placeholder="Allergies, dietary preferences, etc."></textarea>

                <button type="submit">Reserve</button>
            </form>
            <p class="reservation-note">💡 A reservation fee of €10 per person will be charged and deducted from your bill.</p>
        </div>
    </div>
</div>

<?php require_once __DIR__ . "/../partials/footer.php"; ?>
