<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Jazz Management Dashboard</h1>
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
                                        Artists</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['artistCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                        Events</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['eventCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                        Venues</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['venueCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-map-marker-alt fa-2x text-gray-300"></i>
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
                                        Pass Types</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $viewData['passCount'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-ticket-alt fa-2x text-gray-300"></i>
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
                            <h5 class="admin-card-title">Jazz Management</h5>
                        </div>
                        <div class="admin-card-body">
                            <div class="row">
                                <div class="col-md-6 col-xl-3 mb-4">
                                    <div class="card border-left-primary shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Artists</h5>
                                            <p class="card-text">Manage jazz artists including profiles, descriptions, and images.</p>
                                            <a href="/admin/jazz/artists" class="btn btn-primary">Manage Artists</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xl-3 mb-4">
                                    <div class="card border-left-success shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Events</h5>
                                            <p class="card-text">Manage jazz events, performances, dates, and assigned artists.</p>
                                            <a href="/admin/jazz/events" class="btn btn-success">Manage Events</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xl-3 mb-4">
                                    <div class="card border-left-info shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Venues</h5>
                                            <p class="card-text">Manage jazz venues, capacities, and contact information.</p>
                                            <a href="/admin/jazz/venues" class="btn btn-info">Manage Venues</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6 col-xl-3 mb-4">
                                    <div class="card border-left-warning shadow h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">Passes</h5>
                                            <p class="card-text">Manage jazz festival passes, types, and pricing options.</p>
                                            <a href="/admin/jazz/passes" class="btn btn-warning">Manage Passes</a>
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
