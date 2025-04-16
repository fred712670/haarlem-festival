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
        <h1 class="artist-name"><?= strtoupper(htmlspecialchars($artist['Name'])) ?></h1>
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

    <?php foreach ($songs as $index => $song): ?>
        <div class="song">
            <?php if ($index % 2 === 0): ?>
                <div class="song-content">
                    <h3>"<?= htmlspecialchars($song['Title']) ?>" (<?= htmlspecialchars($song['ReleaseYear']) ?>)</h3>
                    <?php if (!empty($song['Credits'])): ?>
                        <p>Feat. <?= htmlspecialchars($song['Credits']) ?></p>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($song['Description']) ?></p>
                    <audio controls>
                        <source src="/assets/audio/<?= htmlspecialchars($song['SongFileName']) ?>" type="audio/mpeg">
                    </audio>
                </div>
                <img src="/assets/img/dance/<?= htmlspecialchars($song['ImageName']) ?>" 
                     alt="<?= htmlspecialchars($song['Title']) ?>" 
                     class="song-image">
            <?php else: ?>
                <img src="/assets/img/dance/<?= htmlspecialchars($song['ImageName']) ?>" 
                     alt="<?= htmlspecialchars($song['Title']) ?>" 
                     class="song-image">
                <div class="song-content">
                    <h3>"<?= htmlspecialchars($song['Title']) ?>" (<?= htmlspecialchars($song['ReleaseYear']) ?>)</h3>
                    <?php if (!empty($song['Credits'])): ?>
                        <p>Feat. <?= htmlspecialchars($song['Credits']) ?></p>
                    <?php endif; ?>
                    <p><?= htmlspecialchars($song['Description']) ?></p>
                    <audio controls>
                        <source src="/assets/audio/<?= htmlspecialchars($song['SongFileName']) ?>" type="audio/mpeg">
                    </audio>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</section>



        <section id="tickets" class="shows">
    <h2><?= strtoupper(htmlspecialchars($artist['Name'])) ?>’S APPEARANCES</h2>
    <div class="shows-grid">
        <?php foreach ($performances as $performance): ?>
            <div class="show">
                <h3>
                    <?= strtoupper(date('l', strtotime($performance['StartDateTime']))) ?>
                </h3>
                <p><strong>Time:</strong> <?= date('H:i', strtotime($performance['StartDateTime'])) ?></p>
                <p><strong>Venue:</strong> <?= htmlspecialchars($performance['Location']) ?></p>
                <p><strong>Event:</strong> <?= htmlspecialchars($performance['Description']) ?></p>
                <p><strong>Price:</strong> €<?= number_format($performance['Price'], 2) ?></p>
                <p><strong>Duration:</strong> <?= (int) $performance['DurationByMinute'] ?> minutes</p>
                <button class="small-button">Book This Show</button>
            </div>
        <?php endforeach; ?>
    </div>
</section>

    </body>
</html>
