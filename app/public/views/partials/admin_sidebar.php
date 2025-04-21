<div class="admin-sidebar">
<link rel="stylesheet" href="/assets/css/admin.css">
<div class="admin-sidebar-brand">
        <span>Haarlem Festival</span>
    </div>
    <div class="admin-sidebar-nav">
        <div class="admin-nav-heading">Event Management</div>
        
        <a href="/admin/dashboard" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') === 0 || $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-tachometer-alt"></i>
            <span class="admin-nav-text">Dashboard</span>
        </a>
        <a href="/admin/jazz" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/jazz') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-music"></i>
            <span class="admin-nav-text">Jazz</span>
        </a>
        
        <a href="/admin/dance" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/dance') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-running"></i>
            <span class="admin-nav-text">Dance</span>
        </a>
        
        <a href="/admin/yummy" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/yummy') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-utensils"></i>
            <span class="admin-nav-text">Yummy</span>
        </a>
        
        <a href="/admin/users" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-users"></i>
            <span class="admin-nav-text">Users</span>
        </a>
        
        <a href="/admin/homepage-management" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/homepage-management') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-home"></i>
            <span class="admin-nav-text">Homepage</span>
        </a>
        
        <a href="/admin/orders" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/orders') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-shopping-cart"></i>
            <span class="admin-nav-text">Orders</span>
        </a>
        
        <div class="admin-nav-divider"></div>
        
        <div class="admin-nav-heading">View</div>
        
        <a href="/profile" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/profile') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-user"></i>
            <span class="admin-nav-text">Profile</span>
        </a>
        
        <a href="/cart" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/cart') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-shopping-cart"></i>
            <span class="admin-nav-text">Cart</span>
        </a>
        
        <a href="/" class="admin-nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-home"></i>
            <span class="admin-nav-text">Home</span>
        </a>
        
        <a href="/yummy" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/yummy') === 0 && strpos($_SERVER['REQUEST_URI'], '/admin/yummy') !== 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-utensils"></i>
            <span class="admin-nav-text">Yummy!</span>
        </a>
        
        <a href="/dance" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dance') === 0 && strpos($_SERVER['REQUEST_URI'], '/admin/dance') !== 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-running"></i>
            <span class="admin-nav-text">Dance!</span>
        </a>
        
        <a href="/jazz" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/jazz') === 0 && strpos($_SERVER['REQUEST_URI'], '/admin/jazz') !== 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-music"></i>
            <span class="admin-nav-text">Jazz</span>
        </a>
        
        <a href="/history" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/history') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-history"></i>
            <span class="admin-nav-text">History</span>
        </a>
        
        <a href="/magicTeylers" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/magicTeylers') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-magic"></i>
            <span class="admin-nav-text">Magic@Teylers</span>
        </a>
        
        <div class="admin-nav-divider"></div>
        
        <a href="/logout" class="admin-nav-link">
            <i class="admin-nav-icon fas fa-sign-out-alt"></i>
            <span class="admin-nav-text">Logout</span>
        </a>
    </div>
</div>
<script src="/assets/js/admin.js"></script>