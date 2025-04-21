<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haarlem Festival</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <?php if(isset($_SESSION['role']) && strtolower($_SESSION['role']) == 'admin'): ?>
    <link rel="stylesheet" href="/assets/css/admin.css">
    <?php endif; ?>
</head>

<body>
    <nav class="navbar navbar-expand-lg admin_navbar">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="/assets/img/home/logo-not-extended.png" alt="Haarlem Festival" class="img-fluid">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>" href="/">
                            <i class="fas fa-home me-1"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/yummy') === 0 && strpos($_SERVER['REQUEST_URI'], '/admin/yummy') !== 0 ? 'active' : '' ?>" href="/yummy">
                            <i class="fas fa-utensils me-1"></i> Yummy!
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dance') === 0 && strpos($_SERVER['REQUEST_URI'], '/admin/dance') !== 0 ? 'active' : '' ?>" href="/dance">
                            <i class="fas fa-running me-1"></i> Dance!
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/jazz') === 0 && strpos($_SERVER['REQUEST_URI'], '/admin/jazz') !== 0 ? 'active' : '' ?>" href="/jazz">
                            <i class="fas fa-music me-1"></i> Jazz
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/history') === 0 ? 'active' : '' ?>" href="/history">
                            <i class="fas fa-history me-1"></i> History
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/magicTeylers') === 0 ? 'active' : '' ?>" href="/magicTeylers">
                            <i class="fas fa-magic me-1"></i> Magic@Teylers
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if(isset($_SESSION['role']) && strtolower($_SESSION['role']) == 'admin'): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" 
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-shield me-1"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') === 0 || $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : '' ?>" href="/admin/dashboard">
                                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/jazz') === 0 ? 'active' : '' ?>" href="/admin/jazz">
                                    <i class="fas fa-music me-2"></i> Jazz
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/dance') === 0 ? 'active' : '' ?>" href="/admin/dance">
                                    <i class="fas fa-running me-2"></i> Dance
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/yummy') === 0 ? 'active' : '' ?>" href="/admin/yummy">
                                    <i class="fas fa-utensils me-2"></i> Yummy
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') === 0 ? 'active' : '' ?>" href="/admin/users">
                                    <i class="fas fa-users me-2"></i> Users
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/homepage-management') === 0 ? 'active' : '' ?>" href="/admin/homepage-management">
                                    <i class="fas fa-home me-2"></i> Homepage
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item <?= strpos($_SERVER['REQUEST_URI'], '/admin/orders') === 0 ? 'active' : '' ?>" href="/admin/orders">
                                    <i class="fas fa-shopping-cart me-2"></i> Orders
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="/logout">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/profile') === 0 ? 'active' : '' ?>" href="/profile">
                            <i class="fas fa-user me-1"></i> Profile
                        </a>
                    </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a class="nav-link cart-icon <?= strpos($_SERVER['REQUEST_URI'], '/cart') === 0 ? 'active' : '' ?>" href="/cart">
                            <i class="fas fa-shopping-cart me-1"></i> Cart
                            <?php if(isset($_SESSION['cart']) && count($_SESSION['cart']) > 0): ?>
                            <span class="badge"><?= count($_SESSION['cart']) ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>