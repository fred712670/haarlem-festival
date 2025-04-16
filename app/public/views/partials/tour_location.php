<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($location['LocationName']) ?> - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/history_location.css">
    <script src="../../assets/js/history.js"></script>
</head>
<body>
   
<div class="tour-location-page">


    <!-- Banner Section -->
    <section class="tour-location-banner">

        <!-- Back Button -->
        <a href="/history" class="back-button">
            <img src="../../assets/img/history/back-arrow.png" alt="Back">
            <span>Back to History Tour</span>
        </a>

        <img src="../../assets/img/history/<?= htmlspecialchars($images['banner']) ?>" alt="<?= htmlspecialchars($location['LocationName']) ?>" class="banner-image">
        <div class="banner-content">
            <h1 class="banner-title"><?= htmlspecialchars($location['LocationName']) ?></h1>
            <h2 class="banner-subtitle">Discover the iconic landmark that has stood as the heart of Haarlem</h2>
        </div>
    </section>
    
    <!-- Information Section -->
    <section class="tour-location-information">
        <h2 class="location-section-title">About <?= htmlspecialchars($location['LocationName']) ?></h2>
        <div class="location-flex-wrapper">
            <div class="location-info-text">
                <p><?= htmlspecialchars($location['Description']) ?></p>
            </div>
            <div class="location-info-image">
                <img src="../../assets/img/history/<?= htmlspecialchars($images['about']) ?>" alt="<?= htmlspecialchars($location['LocationName']) ?>" class="location-detail-img">
            </div>
        </div>
    </section>
    
    <!-- Highlights Section -->
    <section class="tour-location-highlights">
        <h2 class="location-section-title">Why Visit <?= htmlspecialchars($location['LocationName']) ?>?</h2>
        <div class="highlights-container">
            <?php 
            if (!empty($location['WhyVisit'])):
                $paragraphs = explode("||", $location['WhyVisit']);
                foreach ($paragraphs as $paragraph):
                    if (trim($paragraph) !== ''):
            ?>
            <div class="highlight-box">
                <p><?= htmlspecialchars($paragraph) ?></p>
            </div>
            <?php
                    endif;
                endforeach;
            endif;
            ?>
        </div>
    </section>
    
    <!-- Photo Gallery Section -->
    <section class="tour-location-gallery">
        <h2 class="location-section-title">A Visual Journey</h2>
        <div class="gallery-container">
            <div class="gallery-item">
                <img src="../../assets/img/history/<?= htmlspecialchars($images['gallery'][0]) ?>" alt="<?= htmlspecialchars($location['LocationName']) ?> - Image 1" class="gallery-image">
                <span class="gallery-caption"><?= htmlspecialchars($location['LocationName']) ?></span>
            </div>
            
            <div class="gallery-item">
                <img src="../../assets/img/history/<?= htmlspecialchars($images['gallery'][1]) ?>" alt="<?= htmlspecialchars($location['LocationName']) ?> - Image 2" class="gallery-image">
                <span class="gallery-caption"><?= htmlspecialchars($location['LocationName']) ?></span>
            </div>
            
            <div class="gallery-item">
                <img src="../../assets/img/history/<?= htmlspecialchars($images['gallery'][2]) ?>" alt="<?= htmlspecialchars($location['LocationName']) ?> - Image 3" class="gallery-image">
                <span class="gallery-caption"><?= htmlspecialchars($location['LocationName']) ?></span>
            </div>
        </div>
    </section>
    
    <!-- Tour Route Section -->
    <section class="tour-location-route">
        <h2 class="location-section-title">Tour Route</h2>
        <div class="route-container">
            <!-- Location List -->
            <div class="location-list">
                <?php foreach ($locations as $locationItem): ?>
                    <div class="location-item <?= $locationItem['LocationId'] == $location['LocationId'] ? 'active' : '' ?>">
                        <div class="location-dot"></div>
                        <div class="location-name">
                            <?php if ($locationItem['LocationName'] === 'Church of St. Bavo'): ?>
                                Starting point:<br>
                            <?php endif; ?>
                            <?= htmlspecialchars($locationItem['LocationName']) ?>
                            <?php if ($locationItem['LocationName'] === 'Jopenkerk'): ?>
                                <br>(Break location)
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Map Section -->
            <div class="location-map-wrapper">
                <iframe src="https://maps.google.com/maps?q=<?= urlencode($location['Address']) ?>&output=embed" 
                        frameborder="0" 
                        class="location-map-iframe" 
                        allowfullscreen></iframe>
            </div>
            
            <!-- Booking -->
            <div class="cta-panel">
                <h3>Have you decided yet?</h3>
                <img src="../../assets/img/history/booking.png" alt="Ticket Icon" class="ticket-icon">
                <p>Don't miss the chance to explore Haarlem's rich history! Click below to sign up and start your journey through the past.</p>
                <a href="/Reservation" class="book-now-btn">Book Now</a>
            </div>
        </div>
    </section>
</div>

</body>
</html>
