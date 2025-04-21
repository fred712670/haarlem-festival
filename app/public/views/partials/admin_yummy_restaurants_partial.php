<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Restaurants Management</h1>
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

            <div class="admin-card mb-4">
                <div class="admin-card-header d-flex justify-content-between align-items-center">
                    <h5 class="admin-card-title">Restaurants</h5>
                    <a href="/admin/yummy/restaurants/create" class="btn btn-primary">Add New Restaurant</a>
                </div>
                <div class="admin-card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Cuisine Type</th>
                                    <th>Address</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($viewData['restaurants'])): ?>
                                    <?php foreach ($viewData['restaurants'] as $restaurant): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($restaurant['RestaurantId']) ?></td>
                                            <td>
                                                <?php if (!empty($restaurant['Image_url'])): ?>
                                                    <img src="/assets/img/yummy/<?= htmlspecialchars($restaurant['Image_url']) ?>" 
                                                        alt="<?= htmlspecialchars($restaurant['Name']) ?>" 
                                                        style="width: 50px; height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <span>No image</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($restaurant['Name']) ?></td>
                                            <td><?= htmlspecialchars($restaurant['CuisineType']) ?></td>
                                            <td><?= htmlspecialchars(substr($restaurant['Address'], 0, 30)) . (strlen($restaurant['Address']) > 30 ? '...' : '') ?></td>
                                            <td>
                                                <a href="/admin/yummy/restaurants/edit/<?= htmlspecialchars($restaurant['RestaurantId']) ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="/admin/yummy/restaurants/delete/<?= htmlspecialchars($restaurant['RestaurantId']) ?>" class="btn btn-sm btn-danger">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No restaurants found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>