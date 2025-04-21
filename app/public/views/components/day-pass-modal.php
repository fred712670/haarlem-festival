<!-- Day Pass Modal -->
<div id="dayPassModal" class="day-pass-modal">
    <div class="day-pass-modal-content">
        <span class="day-pass-close">&times;</span>
        <h2>Select a Day</h2>
        <p>Choose which day you would like to attend with your Day Pass:</p>
        
        <form action="/reserve" method="POST" class="day-pass-form">
            <input type="hidden" name="ticketType" value="DayPass">
            <input type="hidden" name="name" value="Jazz Festival Day Pass">
            <input type="hidden" name="price" value="35">
            <input type="hidden" name="selectedDay" id="selected-date-input">
            
            <div class="day-options">
                <div class="day-option">
                    <input type="radio" id="day-thu" name="selectedDay" value="2025-07-24">
                    <label for="day-thu">
                        <div class="day-info">
                            <span class="day-name">Thursday</span>
                            <span class="day-date">24 July</span>
                        </div>
                    </label>
                </div>
                
                <div class="day-option">
                    <input type="radio" id="day-fri" name="selectedDay" value="2025-07-25">
                    <label for="day-fri">
                        <div class="day-info">
                            <span class="day-name">Friday</span>
                            <span class="day-date">25 July</span>
                        </div>
                    </label>
                </div>
                
                <div class="day-option">
                    <input type="radio" id="day-sat" name="selectedDay" value="2025-07-26">
                    <label for="day-sat">
                        <div class="day-info">
                            <span class="day-name">Saturday</span>
                            <span class="day-date">26 July</span>
                        </div>
                    </label>
                </div>
                
               
                
            </div>
            
            <div class="day-pass-actions">
                <button type="button" class="btn-cancel">Cancel</button>
                <button type="submit" class="btn-confirm" disabled>Add to Cart</button>
            </div>
        </form>
    </div>
</div>