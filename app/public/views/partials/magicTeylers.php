<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Puzzles and Science at Teylers Museum</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
    rel="stylesheet">
  <link href="../../assets/css/magicTeylers.css" rel="stylesheet">
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
    <p class="text-center mb-5">
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
          <?php foreach($lorentzSchedule as $row): 
                    $start = new DateTime($row['StartDateTime']);
                    $end   = new DateTime($row['EndDateTime']);
                    ?>
                    <li class="list-group-item border-0 py-1">
                    <?= $start->format('l j F Y') ?>, 
                    <?= $start->format('H:i') ?> &ndash; <?= $end->format('H:i') ?>
                    </li>
            <?php endforeach; ?>
        </div>
        </div>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js">
  </script>
</body>
</html>
