<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Puzzles and Science at Teylers Museum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid p-0"> <!-- Changed to container-fluid and padding zero for full width -->
        <div class="row">
            <div class="col-12 p-0"> <!-- Ensure no padding is applied to the column for the image -->
            <img src="../../assets/img/magicTeylers/magicPicEdit.png" alt="Title Image" class="img-fluid">
            </div>
        </div>

        <!-- Adding a container to control padding and margins for the text -->
        <div class="container my-5"> <!-- Margin for spacing around the container -->
            <div class="row text-section">
                <div class="col-12 mt-3">
                    <h1 class="h1-teylers">Puzzles and Science at Teylers Museum</h1>
                    <p>Join us for a thrilling day of exploration and learning at Teylers Museum!</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 highlight">
                    <h2 class="h2-teylers">Mobile@Teylers</h2>
                    <p>Discover the secrets of Professor Teyler and embark on a journey filled with fun and education.</p>
                    <ul>
                        <li>Six unique science challenges</li>
                        <li>Interactive riddles to solve mysteries</li>
                        <li>Hands-on experiments for all ages</li>
                    </ul>
                </div>
                <div class="col-md-6 highlight">
                    <h2>The Lorentz Formula</h2>
                    <p>Explore the magic with fun hands-on activities! Perfect for families, this exhibit makes learning easy to understand.</p>
                    <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#datesModal">View available dates</button>
                </div>
            </div>

            <div class="row">
                <div class="col-12 highlight">
                    <h2>Demonstration Game</h2>
                    <p>Light the bulb by fixing the broken cables!</p>
                    <button class="btn btn-custom">Download Mobile App</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="datesModal" tabindex="-1" aria-labelledby="datesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="datesModalLabel">Available Dates for The Lorentz Formula</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul>
                        <li>Friday 27 July 2025, 12:30 - 13:20</li>
                        <li>Friday 27 July 2025, 14:00 - 14:50</li>
                        <li>Friday 27 July 2025, 15:00 - 15:50</li>
                        <li>Saturday 28 July 2025, 12:30 - 13:20</li>
                        <li>Saturday 28 July 2025, 14:00 - 14:50</li>
                        <li>Saturday 28 July 2025, 15:00 - 15:50</li>
                        <li>Sunday 29 July 2025, 12:30 - 13:20</li>
                        <li>Sunday 29 July 2025, 14:00 - 14:50</li>
                        <li>Sunday 29 July 2025, 15:00 - 15:50</li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

