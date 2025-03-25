<!-- Festival Schedule Component -->
<section class="jazz-schedule" id="schedule">
    <div class="container">
        <h2>
            <?php if (isset($isArtistPage) && $isArtistPage && isset($artistName)): ?>
                <?= htmlspecialchars($artistName) ?>'S PERFORMANCES
            <?php else: ?>
                FESTIVAL SCHEDULE
            <?php endif; ?>
        </h2>
        
        <!-- Schedule tabs -->
        <div class="schedule-tabs">
            <div class="schedule-nav">
                <?php 
                $firstDay = true;
                foreach ($schedule as $dateKey => $dayInfo): ?>
                    <button class="schedule-tab <?= $firstDay ? 'active' : '' ?>" data-day="<?= htmlspecialchars($dateKey) ?>">
                        <?= htmlspecialchars($dayInfo['day_name']) ?> <?= htmlspecialchars($dayInfo['day_number']) ?>
                    </button>
                    <?php $firstDay = false; ?>
                <?php endforeach; ?>
            </div>
            
            <!-- Schedule content -->
            <div class="schedule-content">
                <?php 
                $firstDay = true;
                foreach ($schedule as $dateKey => $dayInfo): ?>
                    <div class="schedule-day <?= $firstDay ? 'active' : '' ?>" id="day-<?= htmlspecialchars($dateKey) ?>">
                        <?php if (empty($dayInfo['events'])): ?>
                            <!-- No performances for this day -->
                            <div class="no-performances">
                                <?php if (isset($isArtistPage) && $isArtistPage && isset($artistName)): ?>
                                    <p><?= htmlspecialchars($artistName) ?> has no performances scheduled on this day.</p>
                                <?php else: ?>
                                    <p>No performances scheduled for this day.</p>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <!-- Desktop view (table) -->
                            <table>
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <?php if (!$isArtistPage): ?>
                                            <th>Artist</th>
                                        <?php endif; ?>
                                        <th>Venue</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dayInfo['events'] as $event): ?>
                                        <tr>
                                            <td><?= date('g:i', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?></td>
                                            
                                            <?php if (!$isArtistPage): ?>
                                                <td>
                                                    <a href="/jazz/artist/<?= htmlspecialchars($event['artist_id']) ?>">
                                                        <?= htmlspecialchars($event['artist_name']) ?>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                            
                                            <td><?= htmlspecialchars($event['venue_name']) ?></td>
                                            <td>
                                                <?php if ($event['price'] > 0): ?>
                                                    €<?= number_format($event['price'], 2) ?>
                                                <?php else: ?>
                                                    Free
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            
                            <!-- Mobile view (cards) -->
                            <?php foreach ($dayInfo['events'] as $event): ?>
                                <div class="performance-card">
                                    <div class="performance-time">
                                        <?= date('g:i', strtotime($event['start_time'])) ?> - <?= date('g:i A', strtotime($event['end_time'])) ?>
                                    </div>
                                    
                                    <?php if (!$isArtistPage): ?>
                                        <div class="performance-artist">
                                            <a href="/jazz/artist/<?= htmlspecialchars($event['artist_id']) ?>">
                                                <?= htmlspecialchars($event['artist_name']) ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="performance-venue">
                                        <?= htmlspecialchars($event['venue_name']) ?>
                                    </div>
                                    <div class="performance-price">
                                        <?php if ($event['price'] > 0): ?>
                                            €<?= number_format($event['price'], 2) ?>
                                        <?php else: ?>
                                            Free
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            
                            <!-- Pricing information note -->
                            <?php if (!empty($dayInfo['events']) && isset($dayInfo['events'][0]['remarks'])): ?>
                                <div class="daily-pricing-info">
                                    <p><strong>Note:</strong> <?= htmlspecialchars($dayInfo['events'][0]['remarks']) ?></p>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <?php $firstDay = false; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<!-- Add JavaScript for tab functionality if not already included -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all schedule tabs
    const scheduleTabs = document.querySelectorAll('.schedule-tab');
    
    // Add click event to each tab
    scheduleTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Remove active class from all tabs
            scheduleTabs.forEach(t => t.classList.remove('active'));
            
            // Add active class to clicked tab
            this.classList.add('active');
            
            // Hide all schedule days
            const scheduleDays = document.querySelectorAll('.schedule-day');
            scheduleDays.forEach(day => day.classList.remove('active'));
            
            // Show the selected day
            const dayId = 'day-' + this.getAttribute('data-day');
            document.getElementById(dayId).classList.add('active');
        });
    });
});
</script>