<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Puzzles and Science at Teylers Museum</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
  <link href="magicTeylers.css" rel="stylesheet">
</head>
<body>

    <!-- Banner Image (exactly as before) -->
    <div class="container-fluid p-0">
    <img
      src="../../assets/img/magicTeylers/magicPicEdit.png"
      alt="Title Image"
      class="img-fluid w-100">
  </div>

  <main class="container py-5">
    <p class="lead text-center mb-5">
      Join us for a thrilling day of exploration and learning at Teylers Museum!
    </p>

    <div class="row g-4">
      <!-- Mobile@Teylers -->
      <div class="col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="card-title">Mobile@Teylers</h2>
            <p class="card-text">
              Discover the secrets of Professor Teyler and embark on a journey filled with fun and education.
            </p>
            <ul class="list-unstyled">
              <li>• Six unique science challenges</li>
              <li>• Interactive riddles to solve mysteries</li>
              <li>• Hands-on experiments for all ages</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Lorentz Formula -->
      <div class="col-md-6">
        <div class="card h-100 shadow-sm">
          <div class="card-body">
            <h2 class="card-title">The Lorentz Formula</h2>
            <p class="card-text">
              Explore the magic with fun hands-on activities! Perfect for families, this exhibit makes learning easy to understand.
            </p>
            <button
              class="btn btn-custom"
              data-bs-toggle="modal"
              data-bs-target="#datesModal">
              View available dates
            </button>
          </div>
        </div>
      </div>

      <!-- Demonstration Game -->
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-body d-md-flex justify-content-between align-items-center">
            <div>
              <h2 class="card-title">Download our Mobile Game</h2>
              <p class="card-text mb-0">Explore Teyler's secrets trough your phone  </p>
            </div>
            <a href="#" class="btn btn-custom mt-3 mt-md-0">Download Mobile App</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Dates Modal -->
  <div
    class="modal fade"
    id="datesModal"
    tabindex="-1"
    aria-labelledby="datesModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="datesModalLabel">
            Available Dates for The Lorentz Formula
          </h5>
          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="Close">
          </button>
        </div>
        <div class="modal-body">
          <ul class="list-unstyled mb-0">
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
          <button
            type="button"
            class="btn btn-secondary"
            data-bs-dismiss="modal">
            Close
          </button>
        </div>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
