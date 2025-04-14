<?php
?>
<link rel="stylesheet" href="/assets/css/jazz.css">
<link rel="stylesheet" href="/assets/css/style.css">

<!-- Main Jazz Content -->
<section class="jazz-hero" role="banner" aria-labelledby="jazz-hero-title">
    <div class="jazz-hero-content">
        <?php if (isset($content) && isset($content['hero_title'])): ?>
            <h1 id="jazz-hero-title"><?= htmlspecialchars($content['hero_title']) ?></h1>
        <?php endif; ?>
        
        <?php if (isset($content) && isset($content['hero_dates'])): ?>
            <p><?= htmlspecialchars($content['hero_dates']) ?></p>
        <?php endif; ?>
        
        <?php if (isset($content) && isset($content['ticket_button'])): ?>
            <a href="#tickets" class="btn-ticket" aria-label="Get Tickets"><?= htmlspecialchars($content['ticket_button']) ?></a>
        <?php endif; ?>
    </div>
</section>

<!-- About Section --> 
<section class="jazz-about" id="about" aria-labelledby="about-title">
    <div class="container">
        <h2 id="about-title">About The Event</h2>
        <?php if (isset($content) && isset($content['about'])): ?>
            <p><?= htmlspecialchars($content['about']) ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- Artists Grid - Pulling all artists from database -->
<section class="jazz-artists" id="artists" aria-labelledby="artists-title">
    <div class="container">
        <h2 id="artists-title">Meet The Artists</h2>
        <div class="artists-grid" role="list">
            <?php if (isset($artists) && is_array($artists) && !empty($artists)): ?>
                <?php foreach ($artists as $artist): ?>
                    <div class="artist-card" role="listitem">
                        <div class="artist-image">
                            <?php if (isset($artist['image'])): ?>
                                <img src="/assets/img/jazz/<?= htmlspecialchars($artist['image']) ?>" 
                                     alt="Photo of <?= htmlspecialchars($artist['name'] ?? '') ?>">
                            <?php endif; ?>
                            
                            <div class="artist-preview">
                                <?php if (isset($artist['short_description'])): ?>
                                    <p><?= htmlspecialchars($artist['short_description']) ?></p>
                                <?php endif; ?>
                                
                                <?php if (isset($artist['id'])): ?>
                                    <a href="/jazz/artist/<?= htmlspecialchars($artist['id']) ?>" 
                                       class="read-more" 
                                       aria-label="Read more about <?= htmlspecialchars($artist['name'] ?? '') ?>">Read More</a>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <?php if (isset($artist['name'])): ?>
                            <h3><?= htmlspecialchars($artist['name']) ?></h3>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
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