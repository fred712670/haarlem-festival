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
            <form>
                <label>Number of guests:</label>
                <input type="number" min="1" max="<?= $restaurant['Seats'] ?>" value="2">

                <label>Select a date:</label>
                <input type="date">

                <label>Select time:</label>
                <select>
                    <option>12:00 - 14:30</option>
                    <option>18:30 - 21:00</option>
                </select>

                <label>Special Requests:</label>
                <textarea placeholder="Allergies, dietary preferences, etc."></textarea>

                <button type="submit">Reserve</button>
            </form>
            <p class="reservation-note">💡 A reservation fee of €10 per person will be charged and deducted from your bill.</p>
        </div>
    </div>
<?php
}
?>
