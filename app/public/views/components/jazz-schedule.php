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
                                         <th>Add to Cart</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dayInfo['events'] as $event): ?>
                                        <tr>
                                            <td><?= date('H:i', strtotime($event['start_time'])) ?> - <?= date('H:i', strtotime($event['end_time'])) ?></td>
                                            
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
                                            <td>
                                                <?php if ($event['price'] > 0): ?>
                                                    <form action="/reserve" method="post">
                                                        <input type="hidden" name="eventId" value="<?= htmlspecialchars($event['EventId']) ?>">
                                                        <input type="hidden" name="name" value="Jazz Event: <?= htmlspecialchars($event['artist_name']) ?>">
                                                        <input type="hidden" name="address" value="<?= htmlspecialchars($event['venue_name']) ?>">
                                                        <input type="hidden" name="date" value="<?= htmlspecialchars($dateKey) ?>">
                                                        <input type="hidden" name="time" value="<?= htmlspecialchars($event['start_time']) ?>">
                                                        <input type="hidden" name="price" value="<?= htmlspecialchars($event['price']) ?>">
                                                        <input type="hidden" name="ticketType" value="SingleUse">
                                                        <input type="hidden" name="guests" value="1">
                                                        <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                                    </form>
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
                                        <?= date('H:i', strtotime($event['start_time'])) ?> - <?= date('H:i', strtotime($event['end_time'])) ?>
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
                                    
                                    <?php if ($event['price'] > 0): ?>
                                        <div class="performance-action">
                                            <form action="/reserve" method="post">
                                                <input type="hidden" name="eventId" value="<?= isset($event['jazz_event_id']) ? htmlspecialchars($event['jazz_event_id']) : '' ?>">
                                                <input type="hidden" name="name" value="Jazz Event: <?= htmlspecialchars($event['artist_name']) ?>">
                                                <input type="hidden" name="address" value="<?= htmlspecialchars($event['venue_name']) ?>">
                                                <input type="hidden" name="date" value="<?= htmlspecialchars($dateKey) ?>">
                                                <input type="hidden" name="time" value="<?= htmlspecialchars($event['start_time']) ?>">
                                                <input type="hidden" name="price" value="<?= htmlspecialchars($event['price']) ?>">
                                                <input type="hidden" name="ticketType" value="SingleUse">
                                                <input type="hidden" name="guests" value="1">
                                                <button type="submit" class="btn-add-to-cart">Add to Cart</button>
                                            </form>
                                        </div>
                                    <?php endif; ?>
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

<!-- Include the external JavaScript and CSS -->
<link rel="stylesheet" href="/assets/css/jazz.css">
<script src="/assets/js/jazz.js"></script>