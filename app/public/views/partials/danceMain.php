<?php 

print_r($artists);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DANCE! - The Haarlem Festival</title>
    <link rel="stylesheet" href="../../assets/css/dance.css">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <section class="hero">
        <div class="overlay">
            <h1 class="hero-title">
                <span>D</span><span>A</span><span>N</span><span>C</span><span>E</span><span>!</span>
            </h1>
            <p class="hero-subtitle">The Haarlem Festival</p>

            <nav>
                <a href="#about" class="hero-button"> About</a>
                <a href="#artists" class="hero-button">Artists</a>
                <a href="#shows" class="hero-button">Shows</a>
                <a href="#passes" class="hero-button">Passes</a>
            </nav>
        
        </div>
    </section>

    <section id="about" class="section">
        <h2>ABOUT US</h2>
        <div class="content-box">
            <p>At Haarlem Dance, we showcase top-tier dance, house, techno, and trance acts in iconic venues in and around the city of Haarlem.</p>
            <p>Six world-class DJs will thrill audiences with epic <i>Back2Back</i> sessions on big stages and intimate experimental club sets.</p>
            <p>So don’t miss out — hop in, join the vibe, and dance the night away.</p>
        </div>
    </section>

    <section id="artists" class="section">
        <h2>ARTISTS</h2>
        <div class="artist-grid">

                <?php foreach ($artists as $artist): ?>
                    <div class="artist-card">
                        <img src="../../assets/img/dance/general/<?= htmlspecialchars($artist['Name'])?>.png" alt="<?= htmlspecialchars($artist['Name']) ?>">
                        <h3><i><?= htmlspecialchars($artist['Name']) ?></i></h3>
                    <p><i><?= htmlspecialchars($artist['Genre']) ?></i></p>
                        <button>Details</button>
                    </div>
               <?php endforeach; ?>

        </div>
    </section>

    <section id="shows" class="section">
        <h2>SHOWS</h2>
        <div class="shows-grid">
            <div class="show-day"> <h3>FRIDAY</h3> <p>20:00 - 02:00 | Hardwell, Afrojack</p> <button>Book This Show</button> </div>
            <div class="show-day"> <h3>SATURDAY</h3> <p>14:00 - 23:00 | Armin, Tiësto, Nicky</p> <button>Book This Show</button> </div>
            <div class="show-day"> <h3>SUNDAY</h3> <p>16:00 - 23:00 | Hardwell, Martin, Armin</p> <button>Book This Show</button> </div>
        </div>
    </section>

    <section id="passes" class="section">
        <h2>PASSES</h2>
        <div class="passes-container">
            <div class="pass"> <h3>Weekend All-Access</h3> <p>€250.00</p> <button>Purchase</button> </div>
            <div class="pass"> <h3>Friday Access</h3> <p>€125.00</p> <button>Purchase</button> </div>
            <div class="pass"> <h3>Saturday Access</h3> <p>€150.00</p> <button>Purchase</button> </div>
            <div class="pass"> <h3>Sunday Access</h3> <p>€150.00</p> <button>Purchase</button> </div>
        </div>
    </section>
</body>
</html>
