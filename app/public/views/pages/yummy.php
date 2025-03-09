<?php 
require_once __DIR__ . "/../partials/header.php"; 
require_once __DIR__ . "/../../controllers/YummyController.php"; 

$controller = new YummyController();
$restaurants = $controller->index();
?>

<body>
<!-- Hero Section -->
<section class="hero">
  <img src="/assets/img/banner.png" alt="Food Festival">
  <h1>Yummy!</h1>
</section>

<!-- Food Festival Section -->
<section class="food-section">
    <h2>Delightful Tastes of Haarlem</h2>
    <p>Indulge in a culinary journey at The Haarlem Festival</p>
    
    <div class="food-cards">
    <div class="food-card">
        <div class="food-card-content">
            <img src="/assets/img/spoon.png">
            <h3>Vegan Delights</h3>
            <p class="food-description">Explore a diverse menu of vegan options crafted to please every palate. 
                                        From fresh, vibrant salads to hearty, plant-based meals, our festival is 
                                        proud to serve delicious, cruelty-free food that satisfies and sustains. 
                                        Each dish is made with locally-sourced ingredients to ensure freshness and support our community.</p>
            <button class="expand-btn">+</button>
        </div>
    </div>

    <div class="food-card">
        <div class="food-card-content">
            <img src="/assets/img/fork.png">
            <h3>Gluten-Free Goodness</h3>
            <p class="food-description">Enjoy our gluten-free offerings that guarantee flavor without compromise. 
                                        Our dedicated gluten-free stations serve everything from gluten-free beers 
                                        and breads to complete meals, ensuring everyone can dine worry-free. 
                                        Carefully prepared to avoid cross-contamination, you can indulge safely in the true taste of Haarlem.</p>
            <button class="expand-btn">+</button>
        </div>
    </div>

    <div class="food-card">
        <div class="food-card-content">
            <img src="/assets/img/knife.png">
            <h3>Family Feasts</h3>
            <p class="food-description">Feeding the whole family has never been easier. Our family-friendly meals
                                        include options for both kids and adults, with fun and nutritious choices
                                        that will keep everyone happy. Look out for our special family meal deals 
                                        and kids' menus, designed to be both wallet-friendly and appealing to younger taste buds.</p>
            <button class="expand-btn">+</button>
        </div>
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
                <img src="/assets/img/<?= htmlspecialchars($restaurant['Image_url']) ?>" alt="<?= htmlspecialchars($restaurant['Name']) ?>">
                <h3><?= htmlspecialchars($restaurant['Name']) ?></h3>
                <p><?= htmlspecialchars($restaurant['Description']) ?></p>
                <a href="/restaurant/<?= htmlspecialchars($restaurant['id']) ?>" class="view-details">View details →</a>
            </div>
        <?php endforeach; ?>
    </div>
</section>
</body>


<?php require_once __DIR__ . "/../partials/footer.php"; ?>