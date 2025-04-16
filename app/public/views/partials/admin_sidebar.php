<div class="admin-sidebar">
<link rel="stylesheet" href="/assets/css/admin.css">
<div class="admin-sidebar-brand">
        <span>Haarlem Festival</span>
    </div>
    <div class="admin-sidebar-nav">
        <a href="/admin" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin') === 0 && $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-tachometer-alt"></i>
            <span class="admin-nav-text">Dashboard</span>
        </a>
        
        <div class="admin-nav-divider"></div>
        
        <div class="admin-nav-heading">Event Management</div>
        
        <a href="/admin/jazz" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/jazz') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-music"></i>
            <span class="admin-nav-text">Jazz Festival</span>
        </a>
        
        <a href="/admin/dance" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/dance') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-headphones"></i>
            <span class="admin-nav-text">Dance Festival</span>
        </a>
        
        <a href="/admin/history" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/history') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-landmark"></i>
            <span class="admin-nav-text">History Tours</span>
        </a>
        
        <a href="/admin/yummy" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/yummy') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-utensils"></i>
            <span class="admin-nav-text">Yummy! Food</span>
        </a>
        
        <div class="admin-nav-divider"></div>
        
        <div class="admin-nav-heading">Content Management</div>
        
        <a href="/admin/homepage-management" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/homepage-management') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-home"></i>
            <span class="admin-nav-text">Homepage</span>
        </a>
        
        <div class="admin-nav-divider"></div>
        
        <div class="admin-nav-heading">User Management</div>
        
        <a href="/admin/users" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/users') === 0 ? 'active' : '' ?>">
            <i class="admin-nav-icon fas fa-users"></i>
            <span class="admin-nav-text">Manage Users</span>
        </a>
        <div class="admin-nav-heading">Order Management</div>

<a href="/admin/orders" class="admin-nav-link <?= strpos($_SERVER['REQUEST_URI'], '/admin/orders') === 0 ? 'active' : '' ?>">
    <i class="admin-nav-icon fas fa-shopping-cart"></i>
    <span class="admin-nav-text">Manage Orders</span>
</a>
        <div class="admin-nav-divider"></div>
        
        <a href="/logout" class="admin-nav-link">
            <i class="admin-nav-icon fas fa-sign-out-alt"></i>
            <span class="admin-nav-text">Logout</span>
        </a>
    </div>
</div>
<script src="/assets/js/admin.js"></script>