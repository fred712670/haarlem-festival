<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Home</title>
    <link rel="stylesheet" href="/assets/css/home.css"/>
</head>
<!-- Hero Section  -->
<section class="hero">
    <div class="slideshow-container">
        <?php foreach ($slides as $slide): ?>
            <div class="slide fade" data-link="<?= htmlspecialchars($slide['Link']) ?>" style="opacity: 1;">
                <img src="/assets/img/home/<?= htmlspecialchars($slide['ImageName']) ?>" alt="<?= htmlspecialchars($slide['Title']) ?>">
                <div class="text-box">
                    <h2><?= html_entity_decode($slide['Title']) ?></h2>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <a id="read-more-btn" href="/" class="btn-yellow">Read more →</a>
</section>

<!-- Welcome Section -->
<section class="welcome-section">
    <h2><?= htmlspecialchars($welcome['Title'] ?? '') ?></h2>
    <p><?= nl2br(html_entity_decode($welcome['Content'] ?? '')) ?></p>
</section>

<!-- About Section -->
<section class="about-section">
    <h2><?= htmlspecialchars($about['Title'] ?? '') ?></h2>
    <p><?= nl2br(html_entity_decode($about['Content'] ?? '')) ?></p>
</section>

<!-- Event Locations -->
<section class="locations-section">
    <h2><?= htmlspecialchars($locations['Title']) ?></h2>
    <p><?= nl2br(htmlspecialchars($locations['Content'])) ?></p>

    <!-- Dropdown for selecting locations -->
    <select id="locationSelect" class="location-dropdown">
        <option value="Haarlem">Select a location</option>
        <?php foreach ($locationOptions as $option): ?>
            <option value="<?= htmlspecialchars($option['Content']) ?>">
                <?= htmlspecialchars($option['Title']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Google Maps Embed -->
    <section class="map-section">
        <iframe id="locationMap" 
            src="https://maps.google.com/maps?q=Haarlem&output=embed" 
            class="location-map" 
            width="100%" 
            height="400" 
            style="border:0;" 
            allowfullscreen 
            loading="lazy">
        </iframe>
    </section>
</section>

<!-- Festival Events -->
<section class="events-section">
    <h2>The Festival Events</h2>
    <div class="events-grid">
        <?php foreach ($eventCards as $event): ?>
            <div class="event-card">
                <div class="event-card-line">
                    <h3><?= htmlspecialchars($event['Title']) ?></h3>
                    <img src="/assets/img/home/<?= htmlspecialchars($event['ImageName']) ?>" alt="<?= htmlspecialchars($event['Title']) ?>" />
                </div>
                <p><?= html_entity_decode($event['Content']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<script src="/assets/js/home.js"></script>
