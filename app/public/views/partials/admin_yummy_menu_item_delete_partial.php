<link rel="stylesheet" href="/assets/css/admin.css">

<div class="admin-container">
    <div class="admin-main">
        <div class="admin-header">
            <button class="toggle-sidebar">
                <i class="fas fa-bars"></i>
            </button>
            <h1>Delete Menu Item</h1>
        </div>

        <div class="admin-content">
            <div class="admin-card mb-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Confirm Deletion</h5>
                </div>
                <div class="admin-card-body">
                    <div class="alert alert-danger">
                        <p>Are you sure you want to delete the menu item <strong><?= htmlspecialchars($menuItem['menuItem']['Title']) ?></strong> from <strong><?= htmlspecialchars($menuItem['menuItem']['MenuName']) ?></strong>?</p>
                        <p>This action cannot be undone.</p>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h4><?= htmlspecialchars($menuItem['menuItem']['Title']) ?></h4>
                            <p><strong>Description:</strong> <?= htmlspecialchars($menuItem['menuItem']['Description']) ?></p>
                            <p><strong>Price:</strong> €<?= number_format($menuItem['menuItem']['Price'], 2) ?></p>
                            <p><strong>Menu:</strong> <?= htmlspecialchars($menuItem['menuItem']['MenuName']) ?></p>
                            <p><strong>Restaurant:</strong> <?= htmlspecialchars($menuItem['menuItem']['RestaurantName']) ?></p>
                        </div>
                    </div>
                    
                    <form action="/admin/yummy/menu-items/delete/<?= htmlspecialchars($menuItem['menuItem']['MenuItemId']) ?>" method="post">
                        <div class="d-flex justify-content-between">
                            <a href="/admin/yummy/menu-items" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-danger">Delete Menu Item</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="/assets/js/admin.js"></script>