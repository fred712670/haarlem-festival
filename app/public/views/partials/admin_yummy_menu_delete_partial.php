<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Delete Menu</h1>
        </div>

        <div class="admin-content">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Confirm Deletion</h5>
                </div>
                <div class="admin-card-body">
                    <div class="alert alert-danger">
                        <p>Are you sure you want to delete the menu <strong><?= htmlspecialchars($menu['menu']['MenuName']) ?></strong> from <strong><?= htmlspecialchars($menu['menu']['RestaurantName']) ?></strong>?</p>
                        <p>This action cannot be undone.</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4><?= htmlspecialchars($menu['menu']['MenuName']) ?></h4>
                            <p><strong>Restaurant:</strong> <?= htmlspecialchars($menu['menu']['RestaurantName']) ?></p>
                        </div>
                    </div>
                    
                    <form action="/admin/yummy/menus/delete/<?= htmlspecialchars($menu['menu']['MenuId']) ?>" method="post">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/yummy/menus" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Menu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>