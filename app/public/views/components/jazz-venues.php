<!-- Venues Section -->
<section class="jazz-venues" id="venues">
    <div class="container">
        <h2>Festival Venues</h2>
        <div class="venues-container">
            <?php foreach ($venues as $venue): ?>
                <div class="venue-card">
                    <h3><?= htmlspecialchars($venue['name']) ?></h3>
                    <div class="venue-address">
                        <p><?= htmlspecialchars($venue['address']) ?></p>
                    </div>
                    
                    <?php if (!empty($venue['description'])): ?>
                        <div class="venue-description">
                            <p><?= htmlspecialchars($venue['description']) ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <div class="venue-info">
                        <p><strong>Capacity:</strong> <?= htmlspecialchars($venue['capacity']) ?> people</p>
                        
                        <?php if (!empty($venue['contact'])): ?>
                            <div class="venue-contact">
                                <h4>Contact Information</h4>
                                <p><i class="fas fa-envelope"></i> Email: <?= htmlspecialchars($venue['contact']['email']) ?></p>
                                <p><i class="fas fa-phone"></i> Phone: <?= htmlspecialchars($venue['contact']['office_phone']) ?> (office) - during office hours <?= htmlspecialchars($venue['contact']['office_hours']) ?></p>
                                <p><i class="fas fa-info-circle"></i> Information: <?= htmlspecialchars($venue['contact']['info_phone']) ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <a href="https://maps.google.com/?q=<?= urlencode($venue['address']) ?>" target="_blank" class="btn-map">
                        <i class="fas fa-map-marker-alt"></i> View on Map
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>