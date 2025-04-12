<!-- Tickets Section -->
<section class="jazz-tickets" id="tickets">
    <div class="container">
        <h2>Tickets</h2>
        
        <div class="ticket-options">
            <div class="ticket-card">
                <h3>Single Performances</h3>
                <p class="price">€10 - €15</p>
                <ul>
                    <li>Select individual performances</li>
                    <li>Main Hall performances: €15 per show</li>
                    <li>Second & Third Hall: €10 per show</li>
                    <li>Flexible scheduling to fit your plans</li>
                </ul>
                <a href="#schedule" class="btn-buy">Select Performance</a>
            </div>
            
            <div class="ticket-card">
                <h3>Day Pass</h3>
                <p class="price">€35.00</p>
                <ul>
                    <li>Full access to all venues for one day</li>
                    <li>Choose Thursday, Friday, or Saturday</li>
                    <li>Access to all performances on your chosen day</li>
                    <li>Convenient all-in-one ticket</li>
                </ul>
                <a href="#" class="btn-buy" id="day-pass-btn">Buy Now</a>
            </div>
            
            <div class="ticket-card featured">
                <h3>Weekend Pass (Thu-Sat)</h3>
                <p class="price">€80.00</p>
                <ul>
                    <li>Complete access Thursday through Saturday</li>
                    <li>Admission to all performances across three days</li>
                    <li>Experience the full range of indoor festival events</li>
                
                </ul>
                <a href="/jazz/tickets/weekend-pass" class="btn-buy">Best Value - Buy Now</a>
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

<!-- Include the Day Pass Modal -->
<?php include_once __DIR__ . '/../components/day-pass-modal.php'; ?>

<!-- Include CSS and JS -->
<link rel="stylesheet" href="/assets/css/jazz.css"> 
<script src="/assets/js/jazz.js"></script>