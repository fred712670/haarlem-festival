<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haarlem Festival</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/assets/css/style.css">

</head>

<body>
<nav class="sidebar">
    <div class="top-section">
        <img id="logo" src="/assets/img/home/logo-not-extended.png" alt="Logo">
        <button class="toggle-btn">
            <i class="fas fa-angle-double-left"></i> <!-- Initial Arrow -->
        </button>
    </div>
    <ul class="nav-links">
    <li>
    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'Administrator'): ?>
        <a href="/admin"><i class="fas fa-user-shield"></i> <span class="link-text">Admin</span></a>
    <?php else: ?>
        <a href="/profile"><i class="fas fa-user"></i> <span class="link-text">Profile</span></a>
    <?php endif; ?>
</li>
        <li><a href="/cart"><i class="fas fa-shopping-cart"></i> <span class="link-text">Cart</span></a></li>
        <li><a href="/"><i class="fas fa-home"></i> <span class="link-text">Home</span></a></li>
        <li><a href="/yummy"><i class="fas fa-utensils"></i> <span class="link-text">Yummy!</span></a></li>
        <li><a href="jazz"><i class="fas fa-running"></i> <span class="link-text">Dance!</span></a></li>
        <li><a href="/dance"><i class="fas fa-music"></i> <span class="link-text">Jazz</span></a></li>
        <li><a href="/history"><i class="fas fa-history"></i> <span class="link-text">History</span></a></li>
        <li><a href="/magicTeylers"><i class="fas fa-magic"></i> <span class="link-text">Magic@Teylers</span></a></li>
    </ul>
    <!--<div class="language-switcher">
        <i class="fas fa-globe"></i>
        <select class="link-text">
            <option>English</option>
            <option>Deutsch</option>
            <option>Nederlands</option>
        </select>
    </div>-->
</nav>