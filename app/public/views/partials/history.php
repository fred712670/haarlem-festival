<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Tour - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/history.css">
    <script src="../../assets/js/history.js"></script>

</head>
<body>
<div class="history-page">
    <!-- Hero Section -->
    <section class="hero">
        <img src="../../assets/img/history/grote-kerk.png" alt="Grote Kerk Haarlem at night" class="hero-image">
        <div class="hero-content">
            <h1 class="hero-title">Stroll Through<br>History</h1>
            <h2 class="hero-subtitle">Explore Haarlem's Rich Historical Landscape</h2>
            <a href="Reservation" class="cta-button">Book Your Tour Now →</a>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="overview">
        <h2 class="section-title">Explore Haarlem's Rich History Through its Iconic Landmarks</h2>
        <div class="content-wrapper">
            <div class="text-content">
                <p><?= htmlspecialchars($overviewContent) ?></p>
            </div>
            <div class="image-content">
                <img src="../../assets/img/history/molen-adriaan1.png" alt="Molen de Adriaan" class="landmark-image">
                <span class="image-caption">Molen de Adriaan</span>
            </div>
        </div>
    </section>

    <!-- Event Detail Section -->
    <section class="event-detail">
        <h2 class="section-title">Event Detail</h2>
        <div class="detail-wrapper">
            <div class="text-content">
                <p><?= htmlspecialchars($eventDetailContent) ?></p>

                <div class="detail-info">
                    <p><strong>Dates:</strong> Thursday 24 July - Sunday 27 July 2025</p>
                    <p><strong>Start Location:</strong> Church of St. Bavo, Grote Markt</p>
                </div>
            </div>
            <div class="image-content">
                <img src="../../assets/img/history/amsterdamse-poort1.png" alt="Amsterdamse Poort" class="landmark-image">
                <span class="image-caption">Amsterdamse Poort</span>
            </div>
        </div>
    </section>

  <!-- Iconic Locations Section -->
<section class="iconic-locations">
    <h2 class="section-title">Iconic Locations</h2>

    <div class="location-gallery">
        <?php foreach ($locations as $location): ?>
        <a href="/history/tour-location/<?= $location['LocationId'] ?>" class="location-thumbnail" 
           data-location="<?= htmlspecialchars($location['LocationName']) ?>"
           data-description="<?= htmlspecialchars($location['Description']) ?>">
            <img src="../../assets/img/history/<?= htmlspecialchars($location['ImageGenera']) ?>" 
                 alt="<?= htmlspecialchars($location['LocationName']) ?>">
        </a>
        <?php endforeach; ?>
    </div>

    <div class="location-description">
        <h3 id="location-title"></h3>
        <p id="location-text"></p>
    </div>
</section>

    <!-- Tour Highlights and Pricing Section -->
<div class="highlights-pricing-container">
    <!-- Tour Highlights -->
    <section class="tour-highlights">
        <h2 class="section-title">Tour Highlights</h2>
        <div class="highlights-card">
            <!-- Highlight items -->
            <div class="highlight-item">
                    <div class="highlight-icon">🏛️</div>
                    <div class="highlight-text">Explore 9 Historic Venues Including St. Bavo Church and Grote Markt</div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">⏱️</div>
                    <div class="highlight-text">Approximately 2.5-Hour Guided Tour with 15-Minute Refreshment Break</div>
                </div>
                <div class="highlight-item">
                    <div class="highlight-icon">👥</div>
                    <div class="highlight-text">Small Group Size: 12 Participants + 1 Guide</div>
                </div>
        </div>
    </section>
    <!-- Ticking Pricing -->
        <section class="ticking-pricing">
        <h2 class="section-title">Ticket Pricing</h2>
        <div class="pricing-card">
        <!-- Price items -->
            <div class="price-item">
                <p>Regular Participant: €<?= number_format($pricing['TicketPrice'], 2) ?></p>
            </div>
            <div class="price-item">
                <p>Family Ticket (Max 4): €<?= number_format($pricing['FamilyTicketPrice'], 2) ?></p>
            </div>
            <div class="price-item">
                <p>Reservation: Mandatory</p>
            </div>
        </div>
    </section>
</div>  

    <!-- Tour Guides Section -->
    <section class="tour-guides">
        <h2 class="section-title">Let us introduce our tour guides!</h2>
    
    <div class="guides-container">
        <?php foreach ($guides as $guide): ?>
        <div class="guide-card">
            <div class="guide-avatar">
                <img src="../../assets/img/history/<?= htmlspecialchars($guide['ProfileImage']) ?>" alt="<?= htmlspecialchars($guide['FullName']) ?>">
            </div>
            <h3 class="guide-name"><?= htmlspecialchars($guide['FullName']) ?></h3>
            <p class="guide-language">Language: <?= htmlspecialchars($guide['LanguagesSpoken']) ?></p>
        </div>
        <?php endforeach; ?>
    </div>
</section>

    <!-- Tour Schedule Section -->
    <section class="tour-schedule">
        <h2 class="section-title">Tour Schedule</h2>
    
    <div class="schedule-table-container">
        <table class="schedule-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Time</th>
                    <th>Start Location</th>
                    <th>English Tour</th>
                    <th>Dutch Tour</th>
                    <th>Chinese Tour</th>
                    <th>Seats</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedule as $day): ?>
                <tr>
                    <td><?= htmlspecialchars($day['FormattedDate']) ?></td>
                    <td><?= htmlspecialchars($day['DayOfWeek']) ?></td>
                    <td><?= htmlspecialchars($day['Times']) ?></td>
                    <td><?= htmlspecialchars($day['StartLocation']) ?></td>
                    <td><?= htmlspecialchars($day['EnglishTour']) ?></td>
                    <td><?= htmlspecialchars($day['DutchTour']) ?></td>
                    <td><?= htmlspecialchars($day['ChineseTour']) ?></td>
                    <td><?= htmlspecialchars($day['Seats']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<!-- Experience Section -->
<section class="experience">
    <h2 class="section-title">Experience</h2>
    
    <div class="experience-container">
        <!-- Progress Bar with Locations -->
        <div class="location-list">
            <?php $isFirst = true; ?>
            <?php foreach ($locations as $index => $location): ?>
                <div class="location-item <?= $isFirst ? 'active' : '' ?>">
                    <div class="location-dot"></div>
                    <div class="location-name">
                        <?php if ($isFirst): ?>
                            Starting point:<br>
                        <?php endif; ?>
                        <?= htmlspecialchars($location['LocationName']) ?>
                        <?php if ($location['LocationName'] === 'Jopenkerk'): ?>
                            <br>(Break location)
                        <?php endif; ?>
                    </div>
                </div>
                <?php $isFirst = false; ?>
            <?php endforeach; ?>
        </div>
        
        <!-- Map Section -->
    <div class="map-container">
        <img src="../../assets/img/history/overviewMap.png" alt="Tour Map" class="tour-map" id="google-map">
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
