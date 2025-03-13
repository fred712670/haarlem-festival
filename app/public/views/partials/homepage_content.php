<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Home</title>
    <link rel="stylesheet" href="/assets/css/home.css"/>
</head>
<!-- Hero Section (Slideshow) -->
<section class="hero">
    <div class="slideshow-container">
        <div class="slide fade" data-link="/" style="opacity: 1;">
            <img src="/assets/img/home/home.png" alt="Home">
            <div class="text-box">
                <h2>Home</h2>
            </div>
        </div>

        <div class="slide fade" data-link="/yummy">
            <img src="/assets/img/home/yummy.png" alt="Yummy">
            <div class="text-box">
                <h2>Yummy</h2>
            </div>
        </div>

        <div class="slide fade" data-link="/dance">
            <img src="/assets/img/home/dance.png" alt="Dance">
            <div class="text-box">
                <h2>Dance</h2>
            </div>
        </div>

        <div class="slide fade" data-link="/jazz">
            <img src="/assets/img/home/jazz.png" alt="Jazz">
            <div class="text-box">
                <h2>Jazz</h2>
            </div>
        </div>

        <div class="slide fade" data-link="/history">
            <img src="/assets/img/home/history.png" alt="History">
            <div class="text-box">
                <h2>History</h2>
            </div>
        </div>

        <div class="slide fade" data-link="/magicTeylers">
            <img src="/assets/img/home/magicTeylers.png" alt="Magic at Teylers">
            <div class="text-box">
                <h2>Magic at Teylers</h2>
            </div>
        </div>
    </div>

    <a id="read-more-btn" href="/" class="btn-yellow">Read more →</a>
</section>

<!-- Welcome Section -->
<section class="welcome-section">
    <h2>Welcome to The Haarlem Festival</h2>
    <p>
    Get ready to experience Haarlem like never before! 
    Our city’s charming cobblestone streets and historic 
    squares are transformed into a lively festival wonderland. 
    From music and art to mouthwatering local flavors, Haarlem’s 
    spirit will sweep you off your feet. Let the festive energy of 
    our city ignite your senses. Haarlem is calling — come join the celebration!
    </p>
</section>

<!-- About Section -->
<section class="about-section">
    <h2>About Our City</h2>
    <p>
    Nestled just minutes from Amsterdam, Haarlem is a 
    city of timeless beauty and artistic spirit. Marvel 
    at iconic landmarks like the Grote Kerk and soak in 
    the cozy atmosphere all while exploring our festival. 
    Let Haarlem’s magic inspire you!
    </p>
</section>

<!-- Event Locations -->
<section class="locations-section">
    <h2>The Event Locations</h2>
    <section class="map-section">

    <!-- Dropdown for selecting locations -->
    <select id="locationSelect" class="location-dropdown">
        <option value="Haarlem">Select a location</option>
        <option value="Café de Roemer, Botermarkt 17, 2011 XL Haarlem">Yummy - Café de Roemer</option>
        <option value="Stadsschouwburg Haarlem, Wilsonsplein 23, 2011 MB Haarlem">Dance - Stadsschouwburg Haarlem</option>
        <option value="Patronaat, Zijlsingel 2, 2013 DN Haarlem">Jazz - Patronaat</option>
        <option value="Teylers Museum, Spaarne 16, 2011 CH Haarlem">History - Teylers Museum</option>
        <option value="Teylers Museum, Spaarne 16, 2011 CH Haarlem">Magic at Teylers</option>
    </select>

    <!-- Google Maps Embed -->
    <iframe id="locationMap" 
        src="https://maps.google.com/maps?q=Haarlem&output=embed" 
        class="location-map" 
        width="100%" 
        height="400" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy">
    </iframe>
</section>

</section>

<!-- Festival Events -->
<section class="events-section">
    <h2>The Festival Events</h2>
    <div class="events-grid">
        <div class="event-card">
            <div class="event-card-line">
              <h3>Stroll Through History</h3>
              <img src="/assets/img/home/history-gif.png" />
            </div>
            <p>Explore Haarlem’s history through walking tours of the city's hidden gems.</p>
        </div>
        <div class="event-card">
           <div class="event-card-line">
               <h3>Yummy!</h3>
               <img src="/assets/img/home/yummy-gif.png" />
           </div>
            <p>Taste dishes from a variety of cuisines at the food festival.</p>
        </div>
        <div class="event-card">
           <div class="event-card-line">
              <h3>Dance!</h3>
              <img src="/assets/img/home/dance-gif.png" />
            </div>
              <p>Join the festival’s open dance sessions and experience fun choreography.</p>
           </div>
        <div class="event-card">
           <div class="event-card-line">
              <h3>Magic at Teylers</h3>
              <img src="/assets/img/home/magic-gif.png" />
            </div>
            <p>Experience breathtaking magic shows at the Teylers Museum.</p>
        </div>
        <div class="event-card">
            <div class="event-card-line">
               <h3>Jazz</h3>
               <img src="/assets/img/home/jazz-gif.png" />
            </div>
            <p>Enjoy live jazz performances from local and international artists.</p>
        </div>
    </div>
</section>
<script src="/assets/js/home.js"></script>