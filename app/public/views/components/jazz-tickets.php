<!-- Tickets Section -->
<section class="jazz-tickets" id="tickets">
    <div class="container">
        <h2>Tickets</h2>
        
        <div class="ticket-options">
            <?php foreach ($ticketInfo as $ticket): ?>
                <?php if ($ticket['type'] === 'Free') continue; // Skip free passes ?>
                
                <div class="ticket-card <?= $ticket['featured'] ? 'featured' : '' ?>">
                    <h3><?= htmlspecialchars($ticket['title']) ?></h3>
                    <p class="price">€<?= number_format($ticket['price'], 2) ?></p>
                    
                    <ul>
                        <?php foreach (explode('||', $ticket['description']) as $item): ?>
                            <?php if (trim($item)): ?>
                                <li><?= htmlspecialchars(trim($item)) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    
                    <?php if ($ticket['type'] === 'SingleUse'): ?>
                        <a href="#schedule" class="btn-buy">Select Performance</a>
                    <?php elseif ($ticket['type'] === 'DayPass'): ?>
                        <a href="#" class="btn-buy" id="day-pass-btn">Buy Now</a>
                    <?php elseif ($ticket['type'] === 'WeekendPass'): ?>
                        <form action="/reserve" method="POST" style="display: inline;">
                            <input type="hidden" name="ticketType" value="<?= $ticket['type'] ?>">
                            <input type="hidden" name="name" value="<?= htmlspecialchars($ticket['title']) ?>">
                            <input type="hidden" name="price" value="<?= $ticket['price'] ?>">
                            <input type="hidden" name="date" value="<?= htmlspecialchars($ticket['dates']) ?>">
                            <button type="submit" class="btn-buy">Best Value - Buy Now</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Free Sunday info -->
        <?php 
        $sundayPass = array_filter($ticketInfo, function($t) { return $t['type'] === 'Free'; });
        $sundayPass = reset($sundayPass);
        if ($sundayPass):
            $description = explode('||', $sundayPass['description']);
        ?>
        <div class="sunday-free-info">
            <div class="free-info-card">
                <h3><?= htmlspecialchars($description[0] ?? 'Sunday Performances - Free Entry') ?></h3>
                <p><?= htmlspecialchars($description[1] ?? '') ?></p>
                <p><?= htmlspecialchars($description[2] ?? '') ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Include the Day Pass Modal -->
<?php include_once __DIR__ . '/../components/day-pass-modal.php'; ?>

<!-- Include CSS and JS -->
<link rel="stylesheet" href="/assets/css/jazz.css"> 
<script src="/assets/js/jazz.js"></script>