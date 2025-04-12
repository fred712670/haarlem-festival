<?php
?>
<!-- Day Pass Selection Modal -->
<div id="dayPassModal" class="day-pass-modal">
    <div class="day-pass-modal-content">
        <span class="day-pass-close">&times;</span>
        <h2>Select a Day</h2>
        <p>Choose which day you would like to attend with your Day Pass:</p>
        
        <form action="/reserve" method="post" class="day-pass-form">
            <div class="day-options">
                <?php foreach ($schedule as $dateKey => $dayInfo): ?>
                <div class="day-option">
                    <input type="radio" id="day-<?= htmlspecialchars($dateKey) ?>" name="selectedDay" value="<?= htmlspecialchars($dateKey) ?>">
                    <label for="day-<?= htmlspecialchars($dateKey) ?>">
                        <span class="day-name"><?= htmlspecialchars($dayInfo['day_name']) ?></span>
                        <span class="day-date"><?= htmlspecialchars($dayInfo['day_number']) ?> <?= htmlspecialchars($dayInfo['month_name']) ?></span>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Hidden fields for the cart -->
            <input type="hidden" name="eventId" value="day-pass">
            <input type="hidden" name="name" value="Jazz Festival Day Pass">
            <input type="hidden" name="address" value="All Venues">
            <input type="hidden" name="price" value="35.00">
            <input type="hidden" name="ticketType" value="DayPass">
            <input type="hidden" name="guests" value="1">
            <input type="hidden" name="date" id="selected-date-input" value="">
            <input type="hidden" name="time" value="All Day">
            
            <div class="day-pass-actions">
                <button type="button" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-confirm" disabled>Add to Cart</button>
            </div>
        </form>
    </div>
</div>