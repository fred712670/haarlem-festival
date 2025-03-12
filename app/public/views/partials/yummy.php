<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yummy</title>
    <link rel="stylesheet" href="/assets/css/yummy.css">
</head>

<?php require_once __DIR__ . '/../components/food-cart.php'; ?>

<body>
<section class="hero">
    <img src="/assets/img/home/yummy.png" alt="Food Festival">
    <h1>Yummy!</h1>
</section>

<section class="food-section">
    <h2>Delightful Tastes of Haarlem</h2>
    <p>Indulge in a culinary journey at The Haarlem Festival</p>
    
    <div class="food-cards">
        <?php
        foreach ($foodItems as $food) {
            require __DIR__ . '/../components/food-card.php';
        }
        ?>
    </div>
</section>

<section class="restaurant-section">
    <div class="restaurant-titles">
      <h2>Taste the Local Flavor</h2>
      <p>Discover a variety of restaurants and cuisines...</p>
    </div>
    
    <div class="restaurant-grid">
        <?php require __DIR__ . '/../partials/restaurant-list.php'; ?>
    </div>
</section>

<script src="/assets/js/yummy.js"></script>
</body>
</html>
