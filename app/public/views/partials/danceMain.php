<?php
function wrapParagraphs($text) {
    if (!is_string($text)) return '';
    $lines = preg_split('/\r\n|\r|\n/', trim($text));
    $paragraphs = array_filter($lines, fn($line) => trim($line) !== '');
    return implode("\n", array_map(fn($line) => "<p>" . htmlspecialchars($line) . "</p>", $paragraphs));
}
?>

<?php
$friday = [];
$saturday = [];
$sunday = [];

foreach ($danceEvents as $event) {
    $date = date('Y-m-d', strtotime($event['StartDateTime']));
    if ($date === '2025-07-25') $friday[] = $event;
    elseif ($date === '2025-07-26') $saturday[] = $event;
    elseif ($date === '2025-07-27') $sunday[] = $event;
}
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

    <section id="about">
        <h2>ABOUT</h2>
        <div class="about-content">
            <div class="content-box">
                <p><?= wrapParagraphs($aboutContent) ?></p>
            </div>
        </div>
    </section>


    <section id="artists">
        <h2>ARTISTS</h2>
        <div class="artist-grid">
            <?php foreach ($artists as $artist): ?>
            <div class="artist-card">
                <img src="../../assets/img/dance/<?= htmlspecialchars($artist['ProfileImageName']) ?>">
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
                <h3><?= $day ?></h3>
                <?php foreach ($events as $event): ?>
                <div class="show">
                    <p><strong><?= date('l, F j, Y', strtotime($event['StartDateTime'])) ?></strong></p> <!-- Day name, full date -->
                    <p><strong><?= htmlspecialchars($event['TimeSlot']) ?></strong></p>
                    <p><strong>Venue:</strong> <em><?= htmlspecialchars($event['Location']) ?></em></p>
                    <p><strong>Artists:</strong> <?= htmlspecialchars($event['Description']) ?></p>
                    <p><strong>Price:</strong> €<?= htmlspecialchars($event['Price']) ?></p>
                    <p><strong>Tickets left:</strong> <?= htmlspecialchars($event['TicketsAvailable']) ?></p>
                    <button class="small-button book-button" data-id="<?= $event['DanceEventId'] ?>">Book This Show</button>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section id="passes">
        <h2>PASSES</h2>
        <div class="passes-grid">
            <div class="pass"> <h3>Weekend All-Access</h3> <p>€250.00</p> <button class="small-button">Purchase</button> </div>
            <div class="pass"> <h3>Friday Access</h3> <p>€125.00</p> <button class="small-button">Purchase</button> </div>
            <div class="pass"> <h3>Saturday Access</h3> <p>€150.00</p> <button class="small-button">Purchase</button> </div>
            <div class="pass"> <h3>Sunday Access</h3> <p>€150.00</p> <button class="small-button">Purchase</button> </div>
        </div>
    </section>

    <?php require_once __DIR__ . '/../partials/danceBooker.php'; ?>











    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
  const modal = document.getElementById("booking-modal");
  const cancelBtn = document.getElementById("cancel-btn");

  // Open modal by adding 'active' class
  document.querySelectorAll(".book-button").forEach(button => {
    button.addEventListener("click", () => {
      modal.classList.add("active");
    });
  });

  // Close modal by removing 'active' class
  cancelBtn.addEventListener("click", () => {
    modal.classList.remove("active");
  });
});
</script>


</body>
</html>
