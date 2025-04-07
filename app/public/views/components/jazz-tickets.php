<!-- Tickets Section -->
<section class="jazz-tickets" id="tickets">
    <div class="container">
        <h2>Tickets</h2>
        
        <div class="ticket-options">
            <div class="ticket-card">
                <form action="/reserve" method="post">
                    <input type="hidden" name="eventId" value="200">
                    <input type="hidden" name="name" value="Jazz Event">
                    <input type="hidden" name="address" value="Jazz Event Stage">
                    <h3>Single Performances</h3>
                    <p name="price" class="price" value="10">€10 - €15</p>
                    <input type="hidden" name="date" value="2025-06-24">
                    <input type="hidden" name="time" value="00:00">
                    <input type="hidden" name="ticketType" value="SingleUse">
                    <input type="hidden" name="guests" value="1">
                    <ul>
                        <li>Select individual performances</li>
                        <li>Main Hall performances: €15 per show</li>
                        <li>Second & Third Hall: €10 per show</li>
                        <li>Flexible scheduling to fit your plans</li>
                    </ul>
                    <button type="submit" class="btn-buy">Buy Now</button>
                </form>
            </div>
            
            <div class="ticket-card">
                <form action="/reserve" method="post">
                    <input type="hidden" name="eventId" value="300">
                    <input type="hidden" name="name" value="Jazz Event">
                    <input type="hidden" name="address" value="Jazz Event Stage">
                    <h3>Day Pass</h3>
                    <p name="price" value="35" class="price">€35.00</p>
                    <input type="hidden" name="date" value="2025-07-24">
                    <input type="hidden" name="time" value="00:00">
                    <input type="hidden" name="ticketType" value="DayPass">
                    <input type="hidden" name="guests" value="1">
                    <ul>
                        <li>Full access to all venues for one day</li>
                        <li>Choose Thursday, Friday, or Saturday</li>
                        <li>Access to all performances on your chosen day</li>
                        <li>Convenient all-in-one ticket</li>
                    </ul>
                    <button type="submit" class="btn-buy">Buy Now</button>
                </form>
            </div>
            
            <div class="ticket-card featured">
                <form action="/reserve" method="post">
                    <input type="hidden" name="eventId" value="300">
                    <input type="hidden" name="name" value="Jazz Event">
                    <input type="hidden" name="address" value="Jazz Event Stage">
                    <h3>Weekend Pass (Thu-Sat)</h3>
                    <p name="price" value="80" class="price">€80.00</p>
                    <ul>
                        <li>Complete access Thursday through Saturday</li>
                        <li>Admission to all performances across three days</li>
                        <li>Experience the full range of indoor festival events</li>
                    </ul>
                    <input type="hidden" name="date" value="2025-07-24">
                    <input type="hidden" name="time" value="00:00">
                    <input type="hidden" name="ticketType" value="WeekendPass">
                    <input type="hidden" name="guests" value="1">
                    <button type="submit" class="btn-buy">Best Value - Buy Now</button>
                </form>
            </div>
        </div>
        
        <div class="sunday-free-info">
            <div class="free-info-card">
                <h3>Sunday Performances - Free Entry</h3>
                <p>All performances at Grote Markt on Sunday, July 30th are <strong>free for all visitors</strong>. No reservation needed.</p>
                <p>Join us for a fantastic day of jazz in the heart of Haarlem!</p>
            </div>
        </div>
    </div>
</section>