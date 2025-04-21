
    <section class="hero">
        <div class="overlay">
            <h1 class="hero-title">
                <span>D</span><span>A</span><span>N</span><span>C</span><span>E</span><span>!</span>
            </h1>
            <p class="hero-subtitle">The Haarlem Festival</p>
            <nav>
                <a href="#about" class="hero-button">About</a>
                <a href="#artists" class="hero-button">Artists</a>
                <a href="#shows" class="hero-button">Shows</a>
                <a href="#passes" class="hero-button">Passes</a>
            </nav>
        </div>
    </section>

    <section id="about">
        <h2>ABOUT</h2>
        <div class="about-content">
            <div class="content-box">
                <?= $aboutContentWrapped ?>
            </div>
        </div>
    </section>

    <section id="artists">
        <h2>ARTISTS</h2>
        <div class="artist-grid">
            <?php foreach ($artists as $artist): ?>
                <div class="artist-card">
                    <img src="/assets/img/dance/<?= htmlspecialchars($artist['ProfileImageName']) ?>">
                    <h3><i><?= htmlspecialchars($artist['Name']) ?></i></h3>
                    <p><i><?= htmlspecialchars($artist['Genre']) ?></i></p>
                    <a href="/dance/artist?id=<?= htmlspecialchars($artist['ArtistId']) ?>">
                        <button class="small-button">Details</button>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="shows">
        <h2>SHOWS</h2>
        <div class="shows-grid">
            <?php foreach (['FRIDAY' => $friday, 'SATURDAY' => $saturday, 'SUNDAY' => $sunday] as $day => $events): ?>
                <div class="day-column">
                    <h3><?= htmlspecialchars($day) ?></h3>
                    <?php foreach ($events as $event): ?>
                        <div class="show">
                            <form action="/reserve" method="POST">
                                <!-- Hidden inputs -->
                                <input type="hidden" name="eventId" value="<?= htmlspecialchars($event['EventId']) ?>">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($artist['Name']) ?> - <?= htmlspecialchars($performance['Location']) ?>">
                                <input type="hidden" name="name" value="<?= htmlspecialchars($event['Description']) ?> - <?= htmlspecialchars($event['Location']) ?>">
                                <input type="hidden" name="guests" value="1">
                                <input type="hidden" name="date" value="<?= htmlspecialchars($event['StartDateTime']) ?>">
                                <input type="hidden" name="address" value="<?= htmlspecialchars($event['Location']) ?>">
                                <input type="hidden" name="artists" value="<?= htmlspecialchars($event['Description']) ?>">
                                <input type="hidden" name="price" value="<?= htmlspecialchars($event['Price']) ?>">
                                <input type="hidden" name="ticketsLeft" value="<?= htmlspecialchars($event['TicketsAvailable']) ?>">
                                <input type="hidden" name="ticketType" value="SingleUse">
                                
                                <!-- Visible tags -->
                                <p><strong>Date:</strong> <?= date('l, F j, Y', strtotime($event['StartDateTime'])) ?></p>
                                <p><strong>Time:</strong> <?= htmlspecialchars($event['TimeSlot']) ?></p>
                                <p><strong>Venue:</strong> <em><?= htmlspecialchars($event['Location']) ?></em></p>
                                <p><strong>Artists:</strong> <?= htmlspecialchars($event['Description']) ?></p>
                                <p><strong>Price:</strong> €<?= htmlspecialchars($event['Price']) ?></p>
                                <p><strong>Tickets left:</strong> <?= htmlspecialchars($event['TicketsAvailable']) ?></p>
                                
                                <button type="submit" class="small-button book-button">Book This Show</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="passes">
        <h2>PASSES</h2>
        <div class="passes-grid">
            <div class="pass">
            <form action="reserve" method="POST">
                <input type="hidden" name="eventId" value="null">
                <!--Some values should be pulled using eventid-->
                <input type="hidden" name="name" value="Dance Event">
                <h3>Weekend All-Access</h3>
                <input type="hidden" name="address" value="Dance Event Stage">
                <input type="hidden" name="price" value="250.00">
                <p>€250.00</p>
                <input type="hidden" name="date" value="null">
                <input type="hidden" name="time" value="null">
                <input type="hidden" name="ticketType" value="WeekendPass">
                <input type="hidden" name="guests" value="1">
                <button type="submit" class="small-button">Purchase</button>
            </form>
            </div>
            <div class="pass">
                <form action="reserve" method="POST">
                <input type="hidden" name="eventId" value="20">
                <input type="hidden" name="name" value="Dance Event">
                <input type="hidden" name="address" value="Dance Event Stage">
                <input type="hidden" name="price" value="125.00">
                <h3>Friday Access</h3>
                <p>€125.00</p>
                <input type="hidden" name="date" value="2025-06-21">
                <input type="hidden" name="time" value="00:00">
                <input type="hidden" name="ticketType" value="DayPass">
                <input type="hidden" name="guests" value="1">
                <button type="submit" class="small-button">Purchase</button>
                </form>
            </div>
            <div class="pass">
                <form action="reserve" method="POST">
                <input type="hidden" name="eventId" value="20">
                <input type="hidden" name="name" value="Dance Event">
                <input type="hidden" name="address" value="Dance Event Stage">
                <input type="hidden" name="price" value="150.00">
                <h3>Saturday Access</h3>
                <p>€150.00</p>
                <input type="hidden" name="date" value="2025-06-22">
                <input type="hidden" name="time" value="00:00">
                <input type="hidden" name="ticketType" value="DayPass">
                <input type="hidden" name="guests" value="1">
                <button type="submit" class="small-button">Purchase</button>
                </form>
            </div>
            <div class="pass">
                <form action="reserve" method="POST">
                <input type="hidden" name="eventId" value="20">
                <input type="hidden" name="name" value="Dance Event">
                <input type="hidden" name="address" value="Dance Event Stage">
                <input type="hidden" name="price" value="150.00">
                <h3>Sunday Access</h3>
                <p>€150.00</p>
                <input type="hidden" name="date" value="2025-06-23">
                <input type="hidden" name="time" value="00:00">
                <input type="hidden" name="ticketType" value="DayPass">
                <input type="hidden" name="guests" value="1">
                <button type="submit" class="small-button">Purchase</button>
                </form>
            </div>
        </section>