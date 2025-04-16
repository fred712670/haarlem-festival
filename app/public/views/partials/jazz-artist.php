<?php 
require_once __DIR__ . "/../partials/header.php"; 
?>
<link rel="stylesheet" href="/assets/css/jazz.css">

<div class="artist-container">
    <a href="/jazz" class="back-arrow" aria-label="Back to Jazz Festival homepage">←</a>
    
    <!-- Artist Header -->
    <section class="artist-header" aria-labelledby="artist-name">
        <div class="container">
            <div class="artist-profile">
                <div class="artist-image">
                    <img src="/assets/img/jazz/<?= htmlspecialchars($artist['image']) ?>" alt="<?= htmlspecialchars($artist['name']) ?> profile photo">
                </div>
                <div class="artist-info">
                    <h1 id="artist-name"><?= htmlspecialchars($artist['name']) ?></h1>
                   
                    <div class="artist-description">
                        <?= htmlspecialchars($artist['short_description']) ?>
                    </div>
                    <a href="#tickets" class="btn-ticket" aria-label="Purchase tickets for <?= htmlspecialchars($artist['name']) ?>">Get Your Tickets Now</a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- About The Band -->
    <section class="about-band" id="about" aria-labelledby="about-title">
        <div class="container">
            <h2 id="about-title">About the Band</h2>
            <div class="about-content">
                <?= nl2br(htmlspecialchars($artist['description'])) ?>
            </div>
        </div>
    </section>
    
    <!-- Musical Style -->
    <section class="musical-style" id="musical-style" aria-labelledby="style-title">
        <div class="container">
            <h2 id="style-title">Musical Style</h2>
            <div class="style-content">
                <?= nl2br(htmlspecialchars($artist['musical_style'])) ?>
            </div>
        </div>
    </section>
    
    <!-- Career Highlights -->
    <section class="career-highlights" id="career-highlights" aria-labelledby="highlights-title">
        <div class="container">
            <h2 id="highlights-title">Career Highlights</h2>
            <div class="highlights-content">
                <?= nl2br(htmlspecialchars($artist['career_highlights'])) ?>
            </div>
        </div>
    </section>
    
    <!-- Image Gallery -->
    <?php if (!empty($artist['gallery']) && count($artist['gallery']) > 0): ?>
    <section class="artist-gallery" id="gallery" aria-labelledby="gallery-title">
        <div class="container">
            <h2 id="gallery-title">Gallery</h2>
            <div class="gallery-grid" role="list" aria-label="Photo gallery of <?= htmlspecialchars($artist['name']) ?>">
                <?php foreach ($artist['gallery'] as $index => $image): ?>
                    <div class="gallery-item" role="listitem">
                        <img src="/assets/img/jazz/<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($artist['name']) ?> performance photo <?= $index + 1 ?>">
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
    
    <!-- Tracks Section -->
    <?php if (!empty($artist['tracks'])): ?>
<section class="artist-tracks py-5 bg-light" id="tracks" aria-labelledby="tracks-title">
    <div class="container">
        <h2 class="mb-4" id="tracks-title">Popular Tracks</h2>
        
        <div class="tracks-list" role="list" aria-label="List of tracks by <?= htmlspecialchars($artist['name']) ?>">
            <?php foreach ($artist['tracks'] as $index => $track): ?>
                <div class="track-item card mb-3 p-3 shadow-sm" role="listitem" data-track-id="<?= htmlspecialchars($track['id']) ?>">
                    <div class="d-flex align-items-center">
                        <div class="track-number me-3 fw-bold text-secondary"><?= $index + 1 ?></div>
                        
                        <div class="track-info flex-grow-1">
                            <h3 class="track-title h5 mb-1"><?= htmlspecialchars($track['title']) ?></h3>
                            <?php if (!empty($track['release_year'])): ?>
                                <span class="track-year text-muted small ms-2"><?= date('Y', strtotime($track['release_year'])) ?></span>
                            <?php endif; ?>
                            <?php if (!empty($track['description'])): ?>
                                <p class="track-description text-muted small mb-0"><?= htmlspecialchars($track['description']) ?></p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="track-controls d-flex align-items-center">
                            <!-- Audio controls will be inserted here by JavaScript -->
                            <button class="play-button btn btn-primary rounded-circle d-flex align-items-center justify-content-center" 
                                    style="width: 40px; height: 40px;" 
                                    aria-label="Play <?= htmlspecialchars($track['title']) ?>">
                                <span class="play-icon" aria-hidden="true">▶</span>
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<!-- Include Festival Schedule Component with artist's performances -->
<?php 
    // Setup variables for the schedule component
    $artistName = $artist['name'];
    $artistSchedule = isset($artistPerformances) ? $artistPerformances : [];
    require_once __DIR__ . '/../components/jazz-schedule.php'; 
?>

<!-- Include the Tickets Section -->
<?php require_once __DIR__ . '/../components/jazz-tickets.php'; ?>

<!-- Include the Venues Section -->
<?php require_once __DIR__ . '/../components/jazz-venues.php'; ?>

<script src="/assets/js/jazz.js"></script>

<?php require_once __DIR__ . "/../partials/footer.php"; ?>