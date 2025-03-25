<link rel="stylesheet" href="/assets/css/jazz.css">
<link rel="stylesheet" href="/assets/css/style.css">

<!-- Main Jazz Content -->
<section class="jazz-hero" role="banner" aria-labelledby="jazz-hero-title">
    <div class="jazz-hero-content">
        <h1 id="jazz-hero-title">HAARLEM-JAZZ FESTIVAL 2025</h1>
        <p>From THURSDAY 24 JULY Till SUNDAY 27 JULY</p>
        <a href="#tickets" class="btn-ticket" aria-label="Get Your Tickets Now">Get Your Tickets Now</a>
    </div>
</section>

<!-- About Section --> 
<section class="jazz-about" id="about" aria-labelledby="about-title">
    <div class="container">
        <h2 id="about-title">About The Event</h2>
        <p>Haarlem Jazz brings world-class jazz performances to the heart of Haarlem from July 24-27, 2025. Featuring both established artists and emerging talents, the festival transforms Het Patronaat and Grote Markt into vibrant venues where jazz comes alive.</p>
    </div>
</section>

<!-- Artists Grid - Pulling all artists from database -->
<section class="jazz-artists" id="artists" aria-labelledby="artists-title">
    <div class="container">
        <h2 id="artists-title">Meet The Artists</h2>
        <div class="artists-grid" role="list">
            <?php foreach ($artists as $artist): ?>
                <div class="artist-card" role="listitem">
                    <div class="artist-image">
                        <img src="/assets/img/jazz/<?= htmlspecialchars($artist['image']) ?>" alt="Photo of <?= htmlspecialchars($artist['name']) ?>">
                        <div class="artist-preview">
                            <p><?= htmlspecialchars($artist['short_description']) ?></p>
                            <a href="/jazz/artist/<?= htmlspecialchars($artist['id']) ?>" class="read-more" aria-label="Read more about <?= htmlspecialchars($artist['name']) ?>">Read More</a>
                        </div>
                    </div>
                    <h3><?= htmlspecialchars($artist['name']) ?></h3>
                    
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Include Festival Schedule Component -->
<?php require_once __DIR__ . '/../components/jazz-schedule.php'; ?>

<!-- Include the Tickets Section -->
<?php require_once __DIR__ . '/../components/jazz-tickets.php'; ?>

<!-- Include the Venues Section -->
<?php require_once __DIR__ . '/../components/jazz-venues.php'; ?>

<script src="/assets/js/jazz.js"></script>