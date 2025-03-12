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
        <?php
        // Food Card Data Array
        $foodItems = [
            [
                "image" => "/assets/img/yummy/spoon.png",
                "title" => "Vegan Delights",
                "description" => "Explore a diverse menu of vegan options crafted to please every palate. 
                                        From fresh, vibrant salads to hearty, plant-based meals, our festival is 
                                        proud to serve delicious, cruelty-free food that satisfies and sustains. 
                                        Each dish is made with locally-sourced ingredients to ensure freshness and support our community."
            ],
            [
                "image" => "/assets/img/yummy/fork.png",
                "title" => "Gluten-Free Goodness",
                "description" => "Enjoy our gluten-free offerings that guarantee flavor without compromise. 
                                        Our dedicated gluten-free stations serve everything from gluten-free beers 
                                        and breads to complete meals, ensuring everyone can dine worry-free. 
                                        Carefully prepared to avoid cross-contamination, you can indulge safely in the true taste of Haarlem."
            ],
            [
                "image" => "/assets/img/yummy/knife.png",
                "title" => "Family Feasts",
                "description" => "Feeding the whole family has never been easier. Our family-friendly meals
                                        include options for both kids and adults, with fun and nutritious choices
                                        that will keep everyone happy. Look out for our special family meal deals 
                                        and kids' menus, designed to be both wallet-friendly and appealing to younger taste buds."
            ]
        ];

        // Render Food Cards Dynamically
        foreach ($foodItems as $food) {
            renderFoodCard($food['image'], $food['title'], $food['description']);
        }
        ?>
    </div>
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
</html>