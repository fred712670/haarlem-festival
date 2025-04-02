<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book History Tour - Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/history.css">
</head>
<body>
    <div class="booking-wrapper">
        <div class="booking-nav">
            <a href="/history" class="booking-back">
                <img src="../../assets/img/history/back-arrow.png" alt="Back">
            </a>
            <div class="booking-logo">
                <img src="../../assets/img/history/logo1.png" alt="Haarlem Festival">
            </div>
        </div>

        <div class="booking-box">
            <div class="booking-box-header">
                <div class="booking-title">
                    <span class="date-time-dot"></span>
                    <span>Date and time</span>
                </div>
            </div>

            <div class="booking-box-content">
                <!-- Error message container -->
                <div id="error-message" class="booking-error" style="display: none;"></div>

                <form id="history-booking-form" action="/reserve" method="post">
                    <div class="booking-field">
                        <label for="date">Select Date:</label>
                        <div class="booking-select-wrapper">
                            <select name="date" id="date" required>
                                <option value="">Select Date</option>
                                <option value="2025-07-24">Thursday, July 24, 2025</option>
                                <option value="2025-07-25">Friday, July 25, 2025</option>
                                <option value="2025-07-26">Saturday, July 26, 2025</option>
                                <option value="2025-07-27">Sunday, July 27, 2025</option>
                            </select>
                            <img src="../../assets/img/history/calendar-icon.png" class="booking-select-icon" alt="Calendar">
                        </div>
                    </div>
                    
                    <div class="booking-field">
                        <label for="time">Select Time:</label>
                        <div class="booking-select-wrapper">
                            <select name="time" id="time" required>
                                <option value="">Select Time</option>
                                <option value="10:00:00">10:00 AM</option>
                                <option value="13:00:00">1:00 PM</option>
                                <option value="16:00:00">4:00 PM</option>
                            </select>
                            <img src="../../assets/img/history/clock-icon.png" class="booking-select-icon" alt="Clock">
                        </div>
                    </div>
                    
                    <div class="booking-field">
                        <label for="language">Select Language:</label>
                        <div class="booking-select-wrapper">
                            <select name="language" id="language" required>
                                <option value="">Select Language</option>
                                <option value="English">English</option>
                                <option value="Dutch">Dutch</option>
                                <option value="Chinese">Chinese</option>
                            </select>
                            <img src="../../assets/img/history/globe-icon.png" class="booking-select-icon" alt="Globe">
                        </div>
                    </div>
                    
                    <div class="booking-field">
                        <label>Ticket Option:</label>
                        <div class="booking-radio-group">
                            <div class="booking-radio">
                                <input type="radio" id="regular" name="ticket_type" value="Regular Participant" checked>
                                <label for="regular">Regular Participant (€17.50)</label>
                            </div>
                            
                            <div class="booking-radio">
                                <input type="radio" id="family" name="ticket_type" value="Family Package Deal">
                                <label for="family">Family Package Deal (€60.00, Max 4 participants)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="seats-container" class="booking-field">
                        <label for="seats">Number of Seats:</label>
                        <div class="booking-quantity">
                            <button type="button" id="decrease-seats" class="booking-quantity-btn">-</button>
                            <input type="number" name="seats" id="seats" min="1" max="12" value="1">
                            <button type="button" id="increase-seats" class="booking-quantity-btn">+</button>
                        </div>
                    </div>
                    
                    <div class="booking-actions">
                        <div class="booking-price">
                            <p>Total Price: €<span id="total-price">0</span></p>
                        </div>
                        
                        <button type="submit" class="booking-submit">Reserve</button>
                    </div>
                </form>
                
                <p class="booking-tips">💡 Tours run for 2.5 hours and include a 15-minute refreshment break.</p>
            </div>
        </div>
    </div>

    <script src="../../assets/js/history.js"></script>
</body>
</html>

