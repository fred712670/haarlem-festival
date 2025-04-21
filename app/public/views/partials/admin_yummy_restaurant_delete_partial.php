<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Delete Restaurant</h1>
        </div>

        <div class="admin-content">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Confirm Deletion</h5>
                </div>
                <div class="admin-card-body">
                    <div class="alert alert-danger">
                        <p>Are you sure you want to delete the restaurant <strong><?= htmlspecialchars($restaurant['Name']) ?></strong>?</p>
                        <p>This action cannot be undone. All associated menus and menu items will be deleted as well.</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <?php if (!empty($restaurant['Image_url'])): ?>
                                <img src="/assets/img/yummy/<?= htmlspecialchars($restaurant['Image_url']) ?>" 
                                     alt="<?= htmlspecialchars($restaurant['Name']) ?>" 
                                     class="img-thumbnail" style="max-height: 200px;">
                            <?php else: ?>
                                <p>No main image available</p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-8">
                            <h4><?= htmlspecialchars($restaurant['Name']) ?></h4>
                            <p><strong>Cuisine Type:</strong> <?= htmlspecialchars($restaurant['CuisineType']) ?></p>
                            <p><strong>Address:</strong> <?= htmlspecialchars($restaurant['Address']) ?></p>
                            <?php if (!empty($restaurant['Description'])): ?>
                                <p><strong>Description:</strong> <?= htmlspecialchars($restaurant['Description']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <form action="/admin/yummy/restaurants/delete/<?= htmlspecialchars($restaurant['RestaurantId']) ?>" method="post">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/yummy/restaurants" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Restaurant</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>