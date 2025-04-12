<?php
function renderRestaurantReservation($restaurant) {
?>
    <div class="reservation">
        <div class="contact-info">
            <h3>Contact Information</h3>
            <p>📞 +31 20 123 4567</p>
            <p>✉ info@<?= strtolower(str_replace(' ', '', $restaurant['Name'])) ?>.com</p>
            <p>📍 <?= htmlspecialchars($restaurant['Address']) ?></p>
        </div>
        <div class="reservation-form">
            <h3>Make a Reservation</h3>
            <!-- Added names so that the form is workable-->
            <form method="post" action="/reserve">
                <!-- Hidden inputs to pass restaurant name and address with the form-->
                <input type="hidden" name="eventId" value="<?= htmlspecialchars($restaurant['EventId']) ?>">
                <input type="hidden" name="name" value="<?= htmlspecialchars($restaurant['Name']) ?>">
                <input type="hidden" name="address" value="<?= htmlspecialchars($restaurant['Address']) ?>">
                <input type="hidden" name="ticketType" value="Reservation">

                <label for="guests">Number of guests:</label>
                <input type="number" id="guests" name="guests" min="1" max="12"<?= $restaurant['Seats'] ?> value="2">

                <label for="date">Select a date:</label>
                <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" required>

                <label for="time">Select time:</label>
                <select id="time" name="time">
                    <option value="12:00-14:30">12:00 - 14:30</option>
                    <option value="18:30-21:00">18:30 - 21:00</option>
                </select>

                <label for="requests">Special Requests:</label>
                <textarea id="requests" name="requests" placeholder="Allergies, dietary preferences, etc."></textarea>

                <button type="submit">Reserve</button>
            </form>
            <p class="reservation-note">💡 A reservation fee of €10 per person will be charged and deducted from your bill.</p>
        </div>
    </div>
<?php
}
?>
