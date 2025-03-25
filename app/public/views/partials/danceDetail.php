<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afrojack - Haarlem Festival</title>
    <link rel="stylesheet" href="/assets/css/dance.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
   
    <section class="artist-info">
        <h1 class="artist-name"><?= htmlspecialchars($artist['Name']) ?></h1>
            <div class="artist-detail">
                <img src="/assets/img/dance/<?= htmlspecialchars($artist['DetailImageName']) ?>" alt="<?= htmlspecialchars($artist['Name']) ?>" class="artist-image">
                <div class="desc-nav">
                    <p class="artist-description">
                        <?= htmlspecialchars($artist['Description']) ?>
                    </p>
                <nav>
                    <a href="#popular-works" class="hero-button">Popular Works</a>
                    <a href="#tickets" class="hero-button">Tickets</a>
                </nav>
                </div>
            </div>
    </section>

    <section id="popular-works">
        <h2>POPULAR WORKS</h2>
            <div class="song">
                <div class="song-content">
                    <h3>“Take Over Control” (2010)</h3>
                    <p>Feat. Eva Simons</p>
                    <p>Afrojack’s breakout hit, a global anthem that introduced his electro-house style to the world and catapulted him to international fame.</p>
                    <audio controls>
                        <source src="../../assets/audio/Afrojack_takeovercontrol.mp3" type="audio/mpeg">
                    </audio>
                </div>
                <img src="../../assets/img/dance/Afrojack_1.png" alt="Take Over Control" class="song-image">
            </div>

            <div class="song">
                <img src="../../assets/img/dance/Afrojack_2.png" alt="Give Me Everything" class="song-image">
                <div class="song-content">
                    <h3>“Give Me Everything” (2011)</h3>
                    <p>Feat. Pitbull, Ne-Yo, & Nayer</p>
                    <p>Co-produced by Afrojack, this collaboration with Pitbull topped the Billboard Hot 100 in the U.S. and charted in over 30 countries.</p>
                    <audio controls>
                        <source src="../../assets/audio/Afrojack_givemeeverything.mp3" type="audio/mpeg">
                    </audio>
                </div>
            </div>

            <div class="song">
                <div class="song-content">
                    <h3>“The Spark” (2013)</h3>
                    <p>Feat. Spree Wilson</p>
                    <p>A feel-good anthem that showcases Afrojack’s ability to blend EDM with pop elements, "The Spark" is a motivational track that resonates with audiences beyond the dance floor.</p>
                    <audio controls>
                        <source src="../../assets/audio/Afrojack_thespark.mp3" type="audio/mpeg">
                    </audio>
                </div>
                <img src="../../assets/img/dance/Afrojack_3.png" alt="The Spark" class="song-image">
            </div>
        </section>

        <section id="tickets" class="shows">
            <h2>AFROJACK’S APPEARANCES</h2>
            <div class="shows-grid">
                <div class="show">
                    <h3>FRIDAY</h3>
                    <p><strong>Time:</strong> 20:00</p>
                    <p><strong>Venue:</strong> Lichtfabriek</p>
                    <p><strong>Event:</strong> <i>Back2Back</i> session with Nicky Romero</p>
                    <p><strong>Price:</strong> €75.00</p>
                    <p><strong>Duration:</strong> 360 minutes</p>
                    <button class="small-button">Book This Show</button>
                </div>

                <div class="show">
                    <h3>SATURDAY</h3>
                    <p><strong>Time:</strong> 14:00</p>
                    <p><strong>Venue:</strong> Caprera Openluchttheater</p>
                    <p><strong>Event:</strong> <i>Back2Back</i> session with Tiësto and Nicky Romero</p>
                    <p><strong>Price:</strong> €110.00</p>
                    <p><strong>Duration:</strong> 540 minutes</p>
                    <button class="small-button">Book This Show</button>
                </div>

                <div class="show">
                    <h3>SUNDAY</h3>
                    <p><strong>Time:</strong> 22:00</p>
                    <p><strong>Venue:</strong> Jopenkerk</p>
                    <p><strong>Event:</strong> Club session</p>
                    <p><strong>Price:</strong> €60.00</p>
                    <p><strong>Duration:</strong> 90 minutes</p>
                    <button class="small-button">Book This Show</button>
                </div>
            </div>
        </section>
   
    </body>
</html>
