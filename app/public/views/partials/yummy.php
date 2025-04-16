<?php require_once __DIR__ . './../components/food-cart.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy</title>
    <link rel="stylesheet" href="/assets/css/yummy.css">
</head>

<body>
<!-- Hero Section -->
<section class="hero">
  <img src="/assets/img/home/yummy.png" alt="Food Festival">
  <h1>Yummy!</h1>
</section>

<!-- Food Festival Section -->
<section class="food-section">
    <h2>Delightful Tastes of Haarlem</h2>
    <p>Indulge in a culinary journey at The Haarlem Festival</p>
    
    <div class="food-cards">
        <?php foreach ($foodItems as $food): ?>
        <?php renderFoodCard($food['ImageName'], $food['Title'], $food['Content']); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="restaurant-section">
    <div class="restaurant-titles">
      <h2>Taste the Local Flavor</h2>
      <p>Discover a variety of restaurants and cuisines...</p>
    </div>
    
    <div class="restaurant-grid">
        <?php foreach ($restaurants as $restaurant): ?>
            <div class="restaurant-card">
                <img src="/assets/img/yummy/<?= htmlspecialchars($restaurant['Image_url']) ?>" alt="<?= htmlspecialchars($restaurant['Name']) ?>">
                <h3><?= htmlspecialchars($restaurant['Name']) ?></h3>
                <p><?= htmlspecialchars($restaurant['Description']) ?></p>
                <a href="/restaurant/<?= htmlspecialchars($restaurant['id']) ?>" class="view-details">View details →</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<script src="/assets/js/yummy.js"></script>
<?php require_once __DIR__ . "/../partials/footer.php"; ?>.
