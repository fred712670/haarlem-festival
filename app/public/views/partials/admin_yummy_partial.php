<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Yummy Management Dashboard</h1>
        </div>

        <div class="admin-content">
            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['success_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_SESSION['error_message']) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Restaurants</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['restaurantCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-utensils fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Menus</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['menuCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book-open fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Menu Items</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['menuItemCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-hamburger fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Reservations</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['reservationCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="admin-card mb-4">
                        <div class="admin-card-header">
                            <h5 class="admin-card-title">Yummy Management</h5>
                        </div>
                        <div class="admin-card-body">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card border-left-primary shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Restaurants</h5>
                                            <p class="card-text">Manage restaurants including information, images, and working hours.</p>
                                            <a href="/admin/yummy/restaurants" class="btn btn-primary">Manage Restaurants</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="card border-left-success shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Menus</h5>
                                            <p class="card-text">Manage restaurant menus and their associations.</p>
                                            <a href="/admin/yummy/menus" class="btn btn-success">Manage Menus</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-4">
                                    <div class="card border-left-info shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Menu Items</h5>
                                            <p class="card-text">Manage menu items, descriptions, and prices.</p>
                                            <a href="/admin/yummy/menu-items" class="btn btn-info">Manage Menu Items</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>